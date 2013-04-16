<?php
class session
{
	public static $u;
  	function session()
  	{
		if(!empty($_POST['email'])&&!empty($_POST['password']))
		{
			$this->login($_POST['email'],$_POST['password']);
		}
		elseif($_SERVER['QUERY_STRING']=='logout'||lz::$f[0]=='logout')
		{
			$this->logout();
		}
		elseif($this->restore($_COOKIE['session_key']?$_COOKIE['session_key']:$_POST['session_key']))
		{
		}
  	}
	public function __call($f,$p)
	{
		lz::h('session.'.$f)->$f($p);
	}
}
?>
