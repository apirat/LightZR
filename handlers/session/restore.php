<?php
class session_restore
{
  	public function restore($skey)
  	{
   		if(empty($skey[0])||strlen($skey[0])<33) return false;	
		$seskey=array(substr($skey[0],32),substr($skey[0],0,32));
    		$cache=lz::h('cache');
		if(!session::$u=$cache->get('user_login_'.$skey[0]))
		{
			$db=lz::h('db');
			if(session::$u=$db->GetRow('select u.id,u.type,u.time,u.ip,u.display,u.username,u.firstname,u.lastname,u.inbox,u.fbid  from user as u where u.id=? and MD5(concat(u.id,u.password))=?',$seskey))
			{
				$db->Execute('update user set lasttime=NOW(),ip=? where id=?',array($_SERVER['REMOTE_ADDR'],session::$u['id']));
				$cache->set('user_login_'.$skey[0],session::$u,600);
			}
		}
		if(session::$u['id'])
		{
			if(!in_array(session::$u['type'],array('ban')))
			{
				define('MY_ID',session::$u['id']);
				define('MY_NAME',session::$u['display']);
				define('MY_USER',session::$u['username']);
				define('MY_FULLNAME',session::$u['firstname'].' '.session::$u['lastname']);
				define('MY_INBOX',session::$u['inbox']);
				if(in_array(session::$u['type'],array('staff','admin','sysop')))define('MY_ADMIN',session::$u['type']);
				if(session::$u['fbid'])define('MY_FBID',session::$u['fbid']);
				define('MY_SESSION',$skey[0]);
				return true;
			}
			else
			{
				setcookie('session_key','',time()+86400);
				setcookie('session_key','',time()+2592000,'/',lz::$cf['domain'],false,true);
				$cache->del('user_login_'.$skey[0]);
			}
		}
    	return false;
	}
}
?>