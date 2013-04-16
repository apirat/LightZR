<?php
define('DB',true);
class mysql
{
	public $connected;
	private $config;
	public function __construct($key="default")
	{
		$this->config=lz::$cf['db'][$key];
		$this->key=$key;
	}
	public function connect()
	{
		$time_start=array_sum(explode(' ',microtime()));
		if (!$this->connected=@mysql_connect($this->config['hostname'],$this->config['username'],$this->config['password']))
		{
			$this->dbError('Connect');
			return false;
		}
		if(!@mysql_select_db($this->config['database']))
		{
			$this->dbError('SelectDB');
			return false;
		}
		$this->connect_time+=(array_sum(explode(' ',microtime()))-$time_start);
		$this->Execute("SET NAMES ".$this->config['encode']);
		return true;
	}
	public function execute($sql,$inputarr=false)
	{
		if(!$this->connected&&!$this->Connect())return;
		if($inputarr&&is_array($inputarr))
		{
			$sqlarr=explode('?',$sql);
			$sql='';
			$i=0;
			foreach($inputarr as $v)
			{
				$sql.=$sqlarr[$i];
				switch(gettype($v))
				{
					case 'string':$sql.=$this->qstr($v); break;
					case 'double':$sql.=str_replace(',', '.', $v);break;
					case 'boolean':$sql.=$v?1:0;break;
					default:$sql.=($v===null?'NULL':$v);
				}
				$i++;
			}
			$sql.=$sqlarr[$i];
			if($i+1!=sizeof($sqlarr))
			{
				$this->dbError("Value in Array for Query [".$sql."]");
				return;
			}
		}
		$this->sql=trim($sql);
		$time_start=array_sum(explode(' ',microtime()));
		$this->query_count++;
		//mysql::$count++;
		//mysql::$logsql[]=$this->sql;
		$this->resultId=@mysql_query($this->sql,$this->connected);
		$this->query_time_total+=(array_sum(explode(' ',microtime()))-$time_start);
		//echo $this->sql.'<br>';
		if(!$this->resultId)
		{
			$this->lastsql=$this->sql;
			$this->dbError("query");
			return;
		}
		switch(trim(strtolower(substr($this->sql,0,strpos($this->sql,' ')))))
		{
			case 'insert': return @mysql_insert_id($this->connected);
			case 'update':
			case 'delete': return @mysql_affected_rows($this->connected);
			case 'show':
			case 'select': return @mysql_num_rows($this->resultId);
			default: return $this->resultId;
		}
	}
	public function qstr($string)
	{
		return "'".mysql_real_escape_string($string)."'";
	}
	public function fetch()
	{
		if($row=@mysql_fetch_assoc($this->resultId))
		{
			while(list($key,$val)=each($row)) $row[$key]=stripslashes($val);
			$row['db']=$this->key;
			return $row;
		}
		return array();
	}
	public function insert_id()
	{
		return @mysql_insert_id($this->connected);
	}
	public function getone($sql,$inputarr=false,$limit=true)
	{
		if($limit && strpos(strtolower($sql)," limit ")===false) $sql.=" limit 0,1";
		if($this->Execute($sql,$inputarr))
		{
			$a=@array_values($this->Fetch());
			return $a[0];
		}
	}
	public function getrow($sql,$inputarr=false,$limit=true)
	{
		if($limit && strpos(strtolower($sql)," limit ")===false) $sql.=" limit 0,1";
		if($this->Execute($sql,$inputarr)) return $this->Fetch();
	}
	public function getall($sql,$inputarr=false)
	{
		if($this->Execute($sql,$inputarr))
		{
			$b=array();
			while($a=$this->Fetch()) $b[]=$a;
			if(count($b))return $b;
		}
		return;
	}
	public function close()
	{
		if($this->connected)@mysql_close($this->connected);
		$this->connected=false;
	}
	public function dberror($e='')
	{
		$this->error=$e.' - '.$this->sql;
		echo "<div style='background:#ff0000;color:#ffffff'><b>DB Error!</b><br><b>Function</b>: ".$e."<br><b>Error Type</b>: ".@mysql_errno($this->connected)." - ".@mysql_error($this->connected)."<br><b>Sql</b>: ".$this->sql." <br><b>Last Sql</b>: ".$this->lastsql."<br><b>Server</b>: ".$this->config['hostname']."(".$this->key.")</div>";
	}
	public function count($disconnect=false)
	{
		if($disconnect)$this->close();
		return number_format($this->query_count);
	}
	public function time($connect=false)
	{
		return number_format(($connect?$this->connect_time:$this->query_time_total),4);
	}
}
?>