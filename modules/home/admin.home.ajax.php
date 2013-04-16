<?php
set_time_limit(1800);
ini_set('html_errors',0);
ini_set('display_errors',E_ALL & ~E_NOTICE);
error_reporting(E_ALL & ~E_NOTICE);
restore_error_handler();

function save($name,$value,$input='input')
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$html=lz::h('html');
	$value=trim($value);
	if(in_array($name,array('display','firstname','lastname','bid','gender','birthday','address','zone','district','province','zipcode','phone','fax','mobile')))
	{
		if($name=='display')
		{
			if(mb_strlen($value,'utf-8')<3)
			{
				$ajax->show('กรุณากรอกชื่อในการแสดงผลอย่างน้อย 3ตัวอักษร');
			}
			elseif(!$db->GetOne('select id from user where display=? and id!=?',array($value,MY_ID)))
			{
				$db->Execute("update user set ".$name."=? where id=?",array($value,MY_ID));
			}
			else
			{
				$ajax->show('ชื่อแสดงผลนี้มีผู้ใช้งานแล้ว');
			}
			$tmp=$db->GetOne("select ".$name." from user where id=?",array(MY_ID));
			list($text,$input)=$html->form($name,$tmp,$input);
		}
		elseif(in_array($name,array('firstname','lastname')))
		{
			if(mb_strlen($value,'utf-8')<3)
			{
				$ajax->show('กรุณากรอกข้อมูลให้ถูกต้อง');
			}
			else
			{
				$db->Execute("update user set ".$name."=? where id=?",array($value,MY_ID));
			}
			$tmp=$db->GetOne("select ".$name." from user where id=?",array(MY_ID));
			list($text,$input)=$html->form($name,$tmp,$input);
		}
		elseif($name=='gender')
		{
			$db->Execute("update user set ".$name."=? where id=?",array($value,MY_ID));
			$tmp=$db->GetOne("select ".$name." from user where id=?",array(MY_ID));
			list($text,$input)=$html->form($name,$tmp,'select',array(),array('male'=>'ผู้ชาย','female'=>'ผู้หญิง'));
		}
		elseif($name=='birthday')
		{
			$db->Execute("update user set ".$name."=? where id=?",array($value,MY_ID));
			$tmp=$db->GetOne("select ".$name." from user where id=?",array(MY_ID));
			list($text,$input)=$html->form($name,$tmp,'date',array('full'=>1),array('startyear'=>date('Y')-120,'stopyear'=>date('Y')));
		}
		elseif($name=='province')
		{
			$db->Execute("update user set ".$name."=? where id=?",array($value,MY_ID));
			$tmp=$db->GetOne("select ".$name." from user where id=?",array(MY_ID));
			list($text,$input)=$html->form($name,$tmp,'province',array('space'=>'เลือกจังหวัด'));
		}
		else
		{
			$db->Execute("update user set ".$name."=? where id=?",array($value,MY_ID));
			$tmp=$db->GetOne("select ".$name." from user where id=?",array(MY_ID));
			list($text,$input)=$html->form($name,$tmp,$input);
		}
		$ajax->html($name,$text,$input);
	}
}
function clearcache()
{
	$ajax=lz::h('ajax');
	lz::h('cache')->clean();
	$ajax->show('ล้างข้อมูล Cache เรียบร้อยแล้ว');
}
function setbox($b,$c)
{
	$ajax=lz::h('ajax');
	if(in_array($b,array('password','profile')))
	{
		$template=lz::h('template');
		if($b=='profile')
		{
			$db=lz::h('db');
			lz::h('time');
			$template->assign('html',lz::h('html'));
			$template->assign('status',array('admin'=>'Admin','staff'=>'Staff','user'=>'สมาชิกทั่วไป','ban'=>'ระงับการใช้งาน'));
			$template->assign('profile',$db->GetRow("select u.* from user as u  where u.id=?",array(MY_ID)));
		}
		$ajax->script('$("#boxset").slideUp("fast")');
		$ajax->assign('boxset','innerHTML',$template->fetch('home.'.$b.''));
		$ajax->script('$("#boxset").slideDown("slow")');
		$ajax->script('$("#boxhome").slideUp("fast")');
	}
}
function password($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$len=mb_strlen(trim($frm['password_new']),'utf-8');
	if(trim($frm['password_new'])!=$frm['password_new'])
	{
		$ajax->show('ไม่สามารถใช้งานรหัสผ่านนี้ได้');
	}
	if($len<4||$len>20)
	{
		$ajax->show('รหัสผ่านต้องมีความยาว 4-20 ตัวอักษร');
	}
	elseif($frm['password_new']!=$frm['password_confirm'])
	{
		$ajax->show('กรุณายืนยันรหัสผ่านให้ถูกต้อง');
	}
	elseif(md5(md5($frm['password_old']))!=$db->GetOne('select password from user where id=?',array(MY_ID)))
	{
		$ajax->show('รหัสผ่านเดิมไม่ถูกต้อง');
	}
	elseif(lz::$cf['domain']=='lightzr.com'||lz::$cf['domain']=='poshsave.com')
	{
		$ajax->show('เวอร์ชั่นทดสอบ ไม่สามารถแก้ไขรหัสผ่านได้');
	}
	else
	{
		$db->Execute('update user set password=? where id=?',array(md5(md5($frm['password_new'])),MY_ID));
		$ajax->show('แก้ไขรหัสผ่านเรียบร้อยแล้ว');
		
		lz::h('cache')->clean();
		$frm=$db->GetRow('select id,firstname,lastname,display,email,password from user where id=?',array(MY_ID));
		$mail=lz::h('mail');
		$template=lz::h('template');
		$template->assign('site',$frm);
		$mail->fromname='LightZr Amazon Script';
		$mail->subject=" ข้อมูลรหัสผ่านใหม่";
		$mail->message=$template->fetch('home.password.mail');
		$mail->to=$frm['email'];
		$mail->send();
		lz::h('cache')->del('user_login_'.$_COOKIE['session_key']);
	}
}


function getphoto()
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if($product=$db->GetAll("select p.asin,p.category,p.s,p.m,p.l,c.link as clink from product as p left join product_category as c on p.category=c.id where p.l2=? group by p.asin limit 0,10",array('')))
	{
		for($i=0;$i<count($product);$i++)
		{
			if(lz::$c['image']=='2')
			{
				if($product[$i]['m'])
				{
					if($m=lz::h('photo')->copy($product[$i]['clink'].'-'.strtolower($product[$i]['asin']),trim($product[$i]['m']),'photo/'.$product[$i]['category'].'/m'))
					{
						$db->Execute('update product set m2=? where asin=? and category=?',array($m,$product[$i]['asin'],$product[$i]['category']));
						if($product[$i]['l'])
						{
							if($l=lz::h('photo')->copy($product[$i]['clink'].'-'.strtolower($product[$i]['asin']),trim($product[$i]['l']),'photo/'.$product[$i]['category'].'/l'))
							{
								$db->Execute('update product set l2=? where asin=? and category=?',array($l,$product[$i]['asin'],$product[$i]['category']));
							}
						}
					}				
					else
					{
						lz::h('amazon')->delete($product[$i]['asin'],$product[$i]['category']);
					}
				}
				else
				{
					lz::h('amazon')->delete($product[$i]['asin'],$product[$i]['category']);
				}
			}
			elseif(lz::$c['image']=='1')
			{
				if($product[$i]['s'])
				{
					if($m=lz::h('photo')->copy($product[$i]['clink'].'-'.strtolower($product[$i]['asin']),trim($product[$i]['s']),'photo/'.$product[$i]['category'].'/s'))
					{
						$db->Execute('update product set s2=? where asin=? and category=?',array($m,$product[$i]['asin'],$product[$i]['category']));
						if($product[$i]['l'])
						{
							if($l=lz::h('photo')->copy($product[$i]['clink'].'-'.strtolower($product[$i]['asin']),trim($product[$i]['l']),'photo/'.$product[$i]['category'].'/l'))
							{
								$db->Execute('update product set l2=? where asin=? and category=?',array($l,$product[$i]['asin'],$product[$i]['category']));
							}
						}
					}				
					else
					{
						lz::h('amazon')->delete($product[$i]['asin'],$product[$i]['category']);
					}
				}
				else
				{
					lz::h('amazon')->delete($product[$i]['asin'],$product[$i]['category']);
				}
			}
			else
			{
				$ajax->script("$('#sphoto').css({display:'none'});");
				$ajax->alert("กรุณาเซ็ทการดึงรูปภาพจากปรับแต่างค่าพืนฐานก่อน.");
				return;
			}
		}
		$ajax->script('wt=5;sendget();');
	}
	else
	{
		$ajax->script("$('#sphoto').css({display:'none'});");
	}
	$ajax->assign('cphoto','innerHTML',number_format($db->GetOne('select count(*) from product where l2!=?',array(''))));
}

function delphoto()
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if($product=$db->GetRow("select p.asin,p.category from product as p where p.s2!=? or p.m2!=? or p.l2!=?",array('','','')))
	{
		clearphoto($product['category']);
		$db->execute('update product set s2=?,m2=?,l2=? where category=?',array('','','',$product['category']));
		$ajax->script('wt=5;senddel();');
	}
	else
	{
		$ajax->script("$('#sphoto').css({display:'none'});");
	}
	$ajax->assign('cphoto','innerHTML',number_format($db->GetOne('select count(*) from product where l2!=?',array(''))));
	//
}



function clearphoto($dir)
{
	$folder=ROOT.'files/photo/';
	$dir=trim($dir,'/').'/';
	if (!is_dir($folder.$dir)||!($dh=@opendir($folder.$dir))) return;
	$result=true;
	while($file=readdir($dh))
	{
		if(!in_array($file,array('.','..')))
		{
			$file2=$dir.$file;
			if(is_dir($folder.$file2))
			{
				clearphoto($file2.'/');
			}
			else
			{
				if(is_file($folder.$file2)) $result=($result&&(_unlink($file2)));
			}
		}
		@rmdir($folder.$dir);
	}
	return false;
}

function _unlink($file)
{
	return (file_exists(ROOT.'files/photo/'.$file)&&!@unlink(ROOT.'files/photo/'.$file))?false:true;
}
?>
