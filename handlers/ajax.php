<?php
class ajax
{
	protected $x=array('f'=>array());
	public $func=array();
	public function __construct()
	{
		
	}
	public function register($func,$file='',$inner='')
	{
		$this->func[$func]=array('file'=>$file,'inner'=>$inner);
	}
	public function alert($m)
	{
		$this->x['f'][]=array("a"=>"al",'v'=>$m);
	}
	public function show($m)
	{
		$this->x['f'][]=array("a"=>"sh",'v'=>$m);
	}
	public function html($t,$k,$v)
	{
		$this->x['f'][]=array("a"=>"ht","s"=>$t,'v'=>$k);
		$this->x['f'][]=array("a"=>"ml","s"=>$t,'v'=>$v);
	}
	public function prepend($t,$v)
	{
		$this->x['f'][]=array("a"=>"pp","s"=>$t,'v'=>$v);
	}
	public function append($t,$v)
	{
		$this->x['f'][]=array("a"=>"ap","s"=>$t,'v'=>$v);
	}
	public function assign($t,$k,$v)
	{
		$this->x['f'][]=array("a"=>"as","s"=>$t,"p"=>$k,'v'=>$v);
	}
	public function remove($v)
	{
		$this->x['f'][]=array("a"=>"rm",'v'=>$v);
	}
	public function redirect($u)
	{
		$this->script('window.location.href="'.$u.'";');
	}
	public function script($s)
	{
		$this->x['f'][]=array("a"=>"js",'v'=>$s);
	}
	public function process()
	{
		if(isset($_POST['ajax']))
		{
			$n=$_POST['ajax'];
			if(!empty($_POST["ajaxargs"]))$arg=$_POST["ajaxargs"];
			if(!is_array($arg))$arg=array();
			if(array_key_exists($n,$this->func))
			{
				if(!empty($this->func[$n]['file']))
				{
					$file=$this->func[$n]['file'];
					if(strpos($file,'/')===false)
					{
						$c=explode('.',$file);
						$file=ROOT.'modules/'.$c[1].'/'.$file;
					}
					if(file_exists($file))
					{
						ob_start();
						include_once($file);
						ob_end_clean();
					}
					else $this->alert("file not found: ".$file);
				}
				if(function_exists($n))
				{
					call_user_func_array($n,$arg);
					while (@ob_end_clean());
					echo $this->get();
					exit;
				}
				else $this->alert("Function not Found: ". $n);
			}
			else $this->alert("Function not Register: ".$n.' - '.print_r($this->func,true));
			while(@ob_end_clean());
			header('Content-type: application/json');
			echo $this->get();
			exit;
	
		}
		$tmp='<script type="text/javascript">';
		foreach($this->func as $f=>$b) $tmp.="function ajax_".$f."(){return lz.ajax.go(\"".$f."\",arguments".($this->func[$f]['inner']?",'".$this->func[$f]['inner']."'":"").");};";
		define('jsAJAX',$tmp.'</script>');
	}
	public function get()
	{
        return json_encode($this->x);
	}
}
?>