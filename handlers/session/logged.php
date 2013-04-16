<?php
class session_logged
{
	public function logged()
	{
		if(!defined('MY_ID'))
		{
			if(isset($_POST['ajax']))
			{
				$ajax=lz::h('ajax');
				$ajax->show('กรุณาลงชื่อเข้าใช้งานเพื่อดำเนินการต่อ');
				if(lz::$t=='www')
				{
					$ajax->script("lz.box.open('#signin');");
				}
				else
				{
					$ajax->script('setTimeout(function(){window.location.href=\''.URL.'\'},2000)');
				}
				echo $ajax->get();
				exit;
			}
			$template=lz::h('template');
			$template->display('content.login');
			exit;
		}
	}
}
?>