<?php
function savecontent($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if($frm['asin'])
	{
		$db->Execute('update product set content=? where asin=? and category=?',array(trim($frm['content']),$frm['asin'],lz::$f[1]));
		$ajax->assign('getproduct','innerHTML',getproduct());
		$ajax->show('บันทึกเนื้อหาของสินค้าเรียบร้อยแล้ว');
	}
	else
	{
		$ajax->show('ไม่มีสินค้าที่คุณเลือก');
	}
}
function editcontent($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if($v=$db->GetRow('select title,asin,content from product where asin=? and category=?',array($id,lz::$f[1])))
	{
		$tmp='<h2>เขียนเนื้อหาใหม่</h2><p>เนื้อหาของสินค้า: <b>'.$v['title'].'</b></p>
<form onSubmit="ajax_savecontent(this);lz.box.close();return false">
<input type="hidden" name="asin" value="'.$v['asin'].'">
<p><textarea class="tbox" name="content" style="width:500px; height:300px;">'.$v['content'].'</textarea></p>
<p align="center"><input type="submit" class="submit" value=" บันทึก "> <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()"></p>
</form>';
		$ajax->assign('opencontent','innerHTML',$tmp);
		$ajax->script('lz.box.open("#opencontent")');
	}
	else
	{
		$ajax->show('ไม่มีสินค้าที่คุณเลือก');
	}
}

function delcontent($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->Execute('update product set content=? where asin=? and category=?',array('',$id,lz::$f[1]));
	$ajax->assign('getproduct','innerHTML',getproduct());
	$ajax->show('ลบเนื้อหาขอองสินค้าเรียบร้อยแล้ว');
}

function update($service,$type,$id,$value,$input='input')
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$html=lz::h('html');
	$value=trim($value);
	if($service=='product')
	{
		$db->Execute("update product set ".$type."=? where category=? and asin=?",array($value,lz::$f[1],$id));
		$tmp=$db->GetOne("select ".$type." from product where  category=? and asin=?",array(lz::$f[1],$id));
		if($type=='title')
		{
			$l=lz::h('format')->link($tmp.'-'.$id,false);
			$db->Execute('update product set link=? where category=? and asin=?',array($l,lz::$f[1],$id));
		}
		if($type=='category')
		{
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
	lz::h('amazon')->delete($id,lz::$f[1]);
	$ajax->assign('getproduct','innerHTML',getproduct());
}
function newproduct($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$awstag=$db->GetOne('select awstag from product_category where id=?',array(lz::$f[1]));
	if(!trim($frm['asin']))
	{
		$ajax->show('กรุณากรอกรหัสสินค้า');
	}
	elseif($id=lz::h('amazon')->product(trim($frm['asin']),lz::$f[1],$awstag))
	{
		$ajax->show('เพิ่มสินค้าเรียบร้อยแล้ว');
	}
	else
	{
		$ajax->show('เกิดข้อผิดพลาด.'.mysql_error());
	}
	$ajax->assign('getproduct','innerHTML',getproduct());
}
function reload($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if($item=$db->GetRow("select asin,category from product where asin=? and category=?",array($id,lz::$f[1])))
	{
		$awstag=$db->GetOne('select awstag from product_category where id=?',array($item['category']));
		if($id=lz::h('amazon')->product($item['asin'],$item['category'],$awstag))
		{
			
		}
		else
		{
			$ajax->show('เกิดข้อผิดพลาด.'.mysql_error());
		}
	}
	$ajax->assign('getproduct','innerHTML',getproduct());
}
function setlist($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	lz::set('product',array('column'=>$frm['_box_view'],'rows'=>$frm['_box_rows'],'thumbnail'=>$frm['_box_thumbnail']));
	$ajax->assign('getproduct','innerHTML',getproduct());
}
?>
