<?php
class session_logout
{
  	public function logout()
  	{		
		setcookie('session_key','',time()+2592000,'/',lz::$cf['domain'],false,true);
		lz::h('cache')->del('user_login_'.$_COOKIE['session_key']);
		header('Location: '.(lz::$t=='admin'?PATHMIN:QUERY));
		exit;
	}
}
?>