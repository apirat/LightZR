<?php
function update($service,$type,$id,$value,$input='input')
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$html=lz::h('html');
	$value=trim($value);
	if($service=='category')
	{
		if($type=='domain')
		{
			$value=strtolower($value);
			$value=preg_replace('/^http:\/\//','',$value);
			$value=preg_replace('/^www\./','',$value);
			$value=trim($value,'/');
		}
		$db->Execute("update product_category set ".$type."=? where id=?",array($value,$id));
		$tmp=$db->GetOne("select ".$type." from product_category where id=?",array($id));
		if($type=='link')
		{
			$tmp=lz::h('format')->link($tmp,false);
			$db->Execute('update product_category set link=? where id=?',array(($tmp?$tmp:'category-'.$id),$id));
			list($text,$input)=$html->form($service.'_'.$type.'_'.$id,$tmp,$input);
		}
		elseif($type=='pgroup')
		{
			$pgroup=array();
			$p=array_values(array_filter(array_map('trim',explode(',',lz::$c['pgroup']))));
			foreach($p as $v)$pgroup[$v]=$v;
			list($text,$input)=$html->form($service.'_'.$type.'_'.$id,$tmp,$input,array('space'=>''),$pgroup);			
		}
		elseif($type=='ads468')
		{
			require(dirname(__FILE__).'/admin.product.config.php');
			list($text,$input)=$html->form($service.'_'.$type.'_'.$id,$tmp,$input,array('space'=>''),$ads468);
			
		}
		elseif($type=='ads120')
		{
			require(dirname(__FILE__).'/admin.product.config.php');
			list($text,$input)=$html->form($service.'_'.$type.'_'.$id,$tmp,$input,array('space'=>''),$ads120);
		}
		elseif($type=='cmode')
		{
			require(dirname(__FILE__).'/admin.product.config.php');
			list($text,$input)=$html->form($service.'_'.$type.'_'.$id,$tmp,$input,false,$mode);
		}
		else
		{
			list($text,$input)=$html->form($service.'_'.$type.'_'.$id,$tmp,$input);
		}
	}
	$ajax->html($service.'_'.$type.'_'.$id,$text,$input);
}
function asinsave($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if($id=trim($frm['category']))
	{
		$asin=array_unique(array_map('trim',explode(',',strtolower($frm['content']))));
		$tmp=array();
		for($i=0;$i<count($asin);$i++)
		{
			if(preg_match('/^b0([a-z0-9]+)$/',$asin[$i],$param)||preg_match('/^([0-9]{10})$/',$asin[$i],$param))
			{
				if(!$db->GetRow('select asin from product where asin=? and category=?',array($asin[$i],$id)))
				{
					$tmp[]=$asin[$i];
				}
			}
		}
		$db->Execute('update product_category set asinpost=? where id=?',array(implode(', ',$tmp),$id));
		$ajax->assign('getcategory','innerHTML',getcategory());
		$ajax->show('บันทึกเนื้อหาของสินค้าเรียบร้อยแล้ว');
	}
}
function asinpost($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if($v=$db->GetRow('select asinpost from product_category where id=?',array($id)))
	{
		$asin=implode(', ',array_unique(array_map('trim',explode(',',strtolower($v['asinpost'])))));
		$tmp='<h2>ASIN สำหรับใช้ในการดึงสินค้า</h2>
<form onSubmit="ajax_asinsave(this);lz.box.close();return false">
<input type="hidden" name="category" value="'.$id.'">
<p><textarea class="tbox" name="content" style="width:500px; height:200px;">'.$asin.'</textarea></p>
<p align="center"><input type="submit" class="submit" value=" บันทึก "> <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()"></p>
<p><br>- <u>ระบบจะทำการตัด asin ที่มีการโพสหรือมีอยู่แล้วออกโดยอัตโนมัติ</u><br>
- ลำดับการโพสจะเรียงจากการกรอก ASIN จากหน้าไปหลัง<br>
- ใช้ comma (,) คั่นระหว่าง ASIN แต่ละอัน
</form>';
		$ajax->assign('opencontent','innerHTML',$tmp);
		$ajax->script('lz.box.open("#opencontent")');
	}
	else
	{
		$ajax->show('ไม่มีหมวดสินค้าที่คุณเลือก');
	}
}


function autopost($id,$status)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->Execute('update product_category set autopost=? where id=?',array($status,$id));
	$ajax->assign('getcategory','innerHTML',getcategory());
}
function del($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$product=$db->GetAll('select asin,category from product where category=?',array($id));
	for($i=0;$i<count($product);$i++)
	{
		lz::h('amazon')->delete($product[$i]['asin'],$product[$i]['category']);	
	}
	if(!$db->GetRow('select * from product where category=?',array($id)))
	{
		$db->Execute('delete from product_category where id=?',array($id));
		$ajax->alert('ลบหมวดสินค้านี้เรียบร้อยแล้ว');
	}
	$ajax->assign('getcategory','innerHTML',getcategory());
}
function newcategory($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$inalltitle='';//implode(', ',array_values(array_filter(explode(' ',trim($frm['title'])))));
	if(!trim($frm['title']))
	{
		$ajax->show('กรุณากรอกชื่อหมวด.');
	}
	elseif($db->getrow('select * from product_category where title=?',array(trim($frm['title']))))
	{
		$ajax->show('มีหมวดนี้อยู่ในระบบแล้ว');
	}
	elseif($id=$db->Execute('insert product_category set title=?,autodb=?,keywords=?,getmax=?,maxpage=?,inalltitle=?,rsort=?,added=now()',array(trim($frm['title']),1,trim($frm['title']),100,10,$inalltitle,'Rank')))
	{
		$l=lz::h('format')->link(trim($frm['title']),false);
		$db->Execute('update product_category set link=? where id=?',array(($l?$l:'category'),$id));
		$ajax->assign('getcategory','innerHTML',getcategory());
		$ajax->show('เพิ่มหมวดเรียบร้อยแล้ว.');
		$ajax->redirect(PATHMIN.SERVICE_LINK.'/setting/'.$id);
	}
	else
	{
		$ajax->show('เกิดข้อผิดพลาด.');
	}
}


function newcategories($frm)
{
	$found=false;
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$tmp=explode("\n",$frm['categories']);
	$co=0;
	$inco=0;
	
	$pgroup=array_map('trim',explode(',',lz::$c['pgroup']));
		
	require(dirname(__FILE__).'/admin.product.config.php');
	for($i=0;$i<count($tmp);$i++)
	{
		if(trim($tmp[$i]))
		{
			$cate=array_values(array_filter(explode(",",trim($tmp[$i]))));
			if(trim($cate[0]))
			{
				if(trim($cate[1]))
				{
					$cate[1]=lz::h('format')->link($cate[1],false);
				}
				else
				{
					$cate[1]=lz::h('format')->link($cate[0],false);
				}
				if(in_array(trim($cate[2]),$pgroup))
				{
					$cate[2]=trim($cate[2]);
				}
				else
				{
					$cate[2]='';
				}
				if(in_array(trim($cate[3]),lz::h('amazon')->searchindex))
				{
					$cate[3]=trim($cate[3]);
				}
				else
				{
					$cate[3]='';
				}
				if(trim($cate[4]))
				{
					$cate[4]=trim($cate[4]);
				}
				else
				{
					$cate[4]='';
				}
				if(trim($cate[5])<1)
				{
					$cate[5]='5';
				}
				else
				{
					$cate[5]=trim($cate[5]);
				}
				$sort=array_flip(lz::h('amazon')->reviewsort);
				if($sort[trim($cate[6])])
				{
					$cate[6]=$sort[trim($cate[6])];
				}
				else
				{
					$cate[6]='';
				}
				$cate[7]=intval('0'.trim($cate[7]));
				
				if(!$db->getrow('select * from product_category where title=?',array(trim($cate[0]))))
				{
					$db->Execute('insert product_category set title=?,link=?,pgroup=?,searchindex=?,keywords=?,maxpage=?,rsort=?,node=?',array($cate[0],$cate[1],$cate[2],$cate[3],$cate[4],$cate[5],$cate[6],$cate[7]));
					$co++;
				}
				else
				{
					$inco++;
				}
			}
		}
	}
	$ajax->show('เพิ่มข้อมูลใหม่ สำเร็จ '.$co.' รายการ, ไม่สำเร็จ '.$inco.' รายการ');
	$ajax->assign('getcategory','innerHTML',getcategory());
}

?>