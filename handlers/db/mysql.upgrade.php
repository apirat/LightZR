<?php
class mysql_upgrade
{
	public $key;
	public function __construct($key="default")
	{
		$this->key=$key;
	}
	public function strtofield($sql) 
	{
		$keys = array (); 
		if(strpos($sql, "(\r\n "))
		{ 
			$sql = str_replace("\r\n", "\n", $sql); 
		}
		elseif (strpos($sql, "(\r "))
		{ 
			$sql = str_replace("\r", "\n", $sql); 
		}
		$sql_lines = explode("\n", trim($sql)); 
		// lets find first line with constraints 
		if(preg_match('/CREATE\sTABLE\s(.+)`(.+)`\s+/i',$sql_lines[0],$c))
		{
			$keys['table']=$c[2];
		}
		for($i=1;$i<count($sql_lines);$i++)
		{ 
			$sql_line = trim($sql_lines[$i]); 
			if (substr($sql_line,-1) ==',') $sql_line = substr($sql_line,0,-1); 
			if (preg_match('/^[\s]*(CONSTRAINT|FOREIGN|PRIMARY|UNIQUE)*[\s]+(KEY)+/', $sql_lines[$i]))
			{ 
				$keys['keys'][] = trim($sql_line); 
			}
			else if (preg_match('/(ENGINE)+/', $sql_line))
			{ 
			}
			else
			{ 
				$x = strpos( $sql_line,' '); 
				$key = substr($sql_line,0,$x); 
				if (strpos("`'\"", substr($key,0,1)) !== false)
				{ 
					$key = substr($key,1,-1); 
				} 
				$keys['fields'][$key] = trim(substr($sql_line,$x)); 
			} 
		} 
		return $keys; 
	} 
	public function upgrade( $sql ) 
	{
		$newtable = $this->strtofield($sql);
		if($newtable['table'])
		{
			$db=lz::h('db',$this->key);
			if($db->execute('show tables like ?',array($newtable['table'])))
			{
				if($db->execute('SHOW CREATE TABLE `'.$newtable['table'].'`'))
				{
					$result=$db->fetch();
					
					$oldtable=$this->strtofield($result['Create Table']);
					
					$error = ''; 
					
					$update = false; 
					$sql = ""; 
					$oldkey = ''; 
					foreach ($newtable['fields'] as $key => $info) 
					{// echo $key,'-'; 
						if(!array_key_exists($key,$oldtable['fields']))
						{
							$update = true;
							$sql .= ', ADD `' . $key . "` " . $info; 
							$sql .= (($oldkey == '')?' FIRST':' AFTER `'.$oldkey.'`');//. "\n"; 
						}
						elseif(trim(strtolower($info)) != trim(strtolower($oldtable['fields'][$key])))
						{ 
							echo '<br>'.$info," - ", $oldtable['fields'][$key],"<br>\n"; 
							$update = true; 
							$sql .= ', MODIFY `' . $key . "` " . $info; 
					//                      $sql .= (($oldkey == '')?' FIRST':' AFTER ' . $oldkey);//. "\n"; 
						}
						$oldkey = $key; 
					} 
					$sql = 'ALTER TABLE `'.$newtable['table'].'` '.substr($sql, 2); 
		
					 If ($update) 
					 {
						 $result = $db->execute($sql); 
					 } 
				}
			}
			else
			{
				$db->execute($sql);
			}
	  } 
	}
}

?>