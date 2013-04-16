<?php
class session_login
{
	public function login($p)
  	{
		$db=lz::h('db');
		$template=lz::h('template');
  		if($user=$db->GetRow('select id,password,type FROM user WHERE email=? AND password=?',array($p[0],md5(md5($p[1])))))
		{
			//if(in_array($user['status'],array('ban','pending')))
			if(in_array($user['type'],array('ban')))
			{
				$template->assign('loginerror','ไอดีสมาชิกนี้ถูกระงับการใช้งาน');
			}
			else
			{
				setcookie('session_key',md5($user['id'].$user['password']).$user['id'],time()+2592000,'/',lz::$cf['domain'],false,true);
				header('Location: '.URL);
				exit;
			}
		}
		else
		{			
			$template->assign('loginerror','ข้อมูลล็อคอินไม่ถูกต้อง');
		}
  	}
}
?>