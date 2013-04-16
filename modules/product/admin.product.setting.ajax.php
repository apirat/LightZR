<?php
function save($type,$value,$input='input')
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$html=lz::h('html');
	$value=trim($value);
	if($type=='domain')
	{
		$value=strtolower($value);
		$value=preg_replace('/^http:\/\//','',$value);
		$value=preg_replace('/^www\./','',$value);
		$value=trim($value,'/');
	}
	
	$db->Execute("update product_category set ".$type."=? where id=?",array($value,lz::$f[1]));
	$tmp=$db->GetOne("select ".$type." from product_category where id=?",array(lz::$f[1]));
	if($type=='searchindex')
	{
		$searchindex=array();
		$amazon=lz::h('amazon');
		foreach($amazon->searchindex as $val)$searchindex[$val]=$val;			
		list($text,$input)=$html->form($type,$tmp,$input,array('space'=>''),$searchindex);
	}
	elseif($type=='rsort')
	{
		$amazon=lz::h('amazon');			
		list($text,$input)=$html->form($type,$tmp,$input,array('space'=>''),$amazon->reviewsort);
	}
	elseif($type=='link')
	{
		$db->Execute('update product_category set link=? where id=?',array(lz::h('format')->link($tmp,false),lz::$f[1]));
		list($text,$input)=$html->form($type,$tmp,$input);
	}
	elseif($type=='pgroup')
	{
		$pgroup=array();
		$p=array_values(array_filter(array_map('trim',explode(',',lz::$c['pgroup']))));
		foreach($p as $v)$pgroup[$v]=$v;
		list($text,$input)=$html->form($type,$tmp,$input,array('space'=>''),$pgroup);	
	}
	elseif($type=='ads468')
	{
		require(dirname(__FILE__).'/admin.product.config.php');
		list($text,$input)=$html->form($type,$tmp,$input,array('space'=>''),$ads468);	
		
	}
	elseif($type=='ads120')
	{
		require(dirname(__FILE__).'/admin.product.config.php');
		list($text,$input)=$html->form($type,$tmp,$input,array('space'=>''),$ads120);	
	}
	elseif($type=='cmode')
	{
		require(dirname(__FILE__).'/admin.product.config.php');
		list($text,$input)=$html->form($type,$tmp,$input,array('space'=>''),$mode);	
	}
	elseif($type=='theme')
	{
		$theme=array();
		$dh=@opendir(ROOT.'themes/');
		while($file=readdir($dh))
		{
			if(!in_array($file,array('.','..')))
			{
				if(is_dir(ROOT.'themes/'.$file))
				{
					$theme[$file]=ucfirst($file);
				}
			}
		}
		list($text,$input)=$html->form($type,$tmp,'select',array('full'=>true,'space'=>''),$theme);
		$ajax->html($type,$text,$input);
		
		if($tmp)
		{
			define('STYLEID',$tmp);
			require_once(MODULES.'style/admin.style.function.php');
			if(!$style=$db->getrow('select * from style where theme=?',array(STYLEID)))
			{
				restorefile();
			}
			savefile();
		}
	}
	else
	{
		list($text,$input)=$html->form($type,$tmp,$input,array('full'=>true));
	}
	
	$ajax->html($type,$text,$input);
}


function update($service,$type,$id,$value,$input='input')
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$html=lz::h('html');
	$value=trim($value);
	if($service=='blog')
	{
		$db->Execute("update blog_category set ".$type."=? where id=?",array($value,$id));
		$tmp=$db->GetOne("select ".$type." from blog_category where id=?",array($id));
		if($type=='ppd')
		{
			list($text,$input)=$html->form($service.'_'.$type.'_'.$id,$tmp,$input,array('space'=>'0','size'=>2));
		}
		else
		{
			list($text,$input)=$html->form($service.'_'.$type.'_'.$id,$tmp,$input);
		}
	}
	$ajax->html($service.'_'.$type.'_'.$id,$text,$input);
}

function del($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	//$db->Execute('delete from blog_category where id=? and site=?',array($id,lz::$s['id']));
	$ajax->assign('getblog','innerHTML',getblog());
}
function newblog($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if(!trim($frm['blog']))
	{
		$ajax->show('กรุณาเลือกบล็อกที่ต้องการ.');
	}
	elseif($id=$db->Execute('insert blog_category set blog=?,category=?',array(trim($frm['blog']),lz::$f[1])))
	{
		$ajax->assign('getblog','innerHTML',getblog());
		$ajax->show('เพิ่มบล็อกเรียบร้อยแล้ว.');
	}
	else
	{
		$ajax->show('เกิดข้อผิดพลาด.');
	}
}
?>