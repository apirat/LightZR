<?php

function savefile()
{
	$db=lz::h('db');
	$folder=lz::h('folder');
	$folder->mkdir(FILES.'style');
	if($fp=@fopen(FILES.'style/'.STYLEID.'.css', "wb"))
	{
		require(ROOT.'themes/'.STYLEID.'/'.STYLEID.'.php');
		$data='';
		$color=$db->GetRow('select * from style where theme=?',array(STYLEID));
		if($color['bg_color']||$color['bg_img'])$data.="body {background:".($color['bg_color']?"#".$color['bg_color']:"")."".($color['bg_img']?' url(/files/style/'.$color['bg_img'].')':'')." ".$color['bg_align']." ".$color['bg_repeat'].";".($color['bg_fix']?"background-attachment: fixed;":"")."}";
		if($color['flip'])$data.=$register['leftbox']."{float:left;}".$register['rightbox']."{float:right;}".$register['centerbox']."{float:right;}";
		
		if($color['text_font'])$data.="body,td,th,input,select,textarea{color:#".$color['text_font']."}";
		if($color['text_link'])$data.="a{color:#".$color['text_link']."}";
		
		if($color['lbar_img'])$data.=$register['rightbox']." h2{background:url(".($color['lbar_img']?HTTP.'files/style/'.$color['lbar_img']:'').") ".$color['lbar_align']." ".$color['lbar_repeat'].";}";
		if($color['lbar_color'])$data.=$register['rightbox']." h2{background-color:#".$color['lbar_color'].";}";
		if($color['lbar_font'])$data.=$register['rightbox']." h2,".$register['rightbox']." h2 a{color:#".$color['lbar_font']."}";
		
		
		if($color['head_img'])$data.=$register['header']."{background:url(".($color['head_img']?HTTP.'files/style/'.$color['head_img']:'').") ".$color['head_align']." ".$color['head_repeat'].";}";
		if($color['head_color'])$data.=$register['header']."{background-color:#".$color['head_color'].";}";
		if($color['content_img'])$data.=$register['content']."{background:url(".($color['content_img']?HTTP.'files/style/'.$color['content_img']:'').") ".$color['content_align']." ".$color['content_repeat'].";}";
		if($color['content_color'])$data.=$register['content']."{background-color:#".$color['content_color'].";}";
		if($color['foot_img'])$data.=$register['footer']."{background:url(".($color['foot_img']?HTTP.'files/style/'.$color['foot_img']:'').") ".$color['foot_align']." ".$color['foot_repeat'].";}";
		if($color['foot_color'])$data.=$register['footer']."{background-color:#".$color['foot_color'].";}";
		if($color['left_img'])$data.=$register['leftbox']."{background:url(".($color['left_img']?HTTP.'files/style/'.$color['left_img']:'').") ".$color['left_align']." ".$color['left_repeat'].";}";
		if($color['left_color'])$data.=$register['leftbox']."{background-color:#".$color['left_color'].";}";
		if($color['right_img'])$data.=$register['rightbox']."{background:url(".($color['right_img']?HTTP.'files/style/'.$color['right_img']:'').") ".$color['right_align']." ".$color['right_repeat'].";}";
		if($color['right_color'])$data.=$register['rightbox']."{background-color:#".$color['right_color'].";}";

		if($color['tab_img'])$data.=$register['sidebar']."{background:url(".($color['tab_img']?HTTP.'files/style/'.$color['tab_img']:'').") ".$color['tab_align']." ".$color['tab_repeat'].";}";
		if($color['tab_color'])$data.=$register['sidebar']."{background-color:#".$color['tab_color'].";}";
		if($color['tab_font'])$data.=$register['menu']." a{color:#".$color['tab_font']." !important}";
		if($color['tab_bg'])$data.=$register['menu']." a{background-color:#".$color['tab_bg']."}";

		if($color['tab_hfont'])$data.=$register['menu']." a:hover{color:#".$color['tab_hfont']." !important}";
		if($color['tab_hbg'])$data.=$register['menu']." a:hover{background-color:#".$color['tab_hbg']."}";

		if($color['tab_hfont'])$data.=$register['menu']." .current a,".$register['menu']." .current a:hover{color:#".$color['tab_hfont']." !important}";
		if($color['tab_hbg'])$data.=$register['menu']." .current a,".$register['menu']." .current a:hover{background-color:#".$color['tab_hbg']."}";

		

		if($color['css'])$data.=$color['css'];


		@fwrite($fp, $data, strlen($data));
		@fclose($fp);
	}
}


function saveimg($style,$type,$init)
{
	if($init[$type.'_img']&&is_file(ROOT.'themes/'.STYLEID.'/'.$init[$type.'_img']))
	{
		$db=lz::h('db');
		if($style[$type.'_img'])@unlink(FILES.'style/'.$style[$type.'_img']);
		$ext=strtolower(trim(preg_replace('/^.*\./', '', $init[$type.'_img'])));
		if(in_array($ext,array('jpg','gif','png')))
		{
			$n=$type.'_'.STYLEID.'.'.$ext;
			lz::h('folder')->mkdir(FILES.'style');
			@copy(ROOT.'themes/'.STYLEID.'/'.$init[$type.'_img'],FILES.'style/'.$n);
			$db->Execute("update style set ".$type."_img=? where theme=?",array($n,STYLEID));
		}
	}	
}

function restorefile()
{
	if(file_exists(ROOT.'themes/'.STYLEID.'/'.STYLEID.'.php'))
	{
		$db=lz::h('db');
		if(!$style=$db->GetRow('select * from style where theme=?',array(STYLEID)))
		{
			$db->Execute('insert style set theme=?',array(STYLEID));
			$style=array();
		}
		require(ROOT.'themes/'.STYLEID.'/'.STYLEID.'.php');
		
		$db->Execute("update style set css=?,
				bg_color=?,bg_fix=?,bg_align=?,bg_repeat=?,bg_img=?,
				head_color=?,head_align=?,head_repeat=?,head_img=?,
				content_color=?,content_align=?,content_repeat=?,content_img=?,
				foot_color=?,foot_align=?,foot_repeat=?,foot_img=?,
				left_color=?,left_align=?,left_repeat=?,left_img=?,
				right_color=?,right_align=?,right_repeat=?,right_img=?,
				lbar_color=?,lbar_align=?,lbar_repeat=?,lbar_font=?,lbar_img=?,
				tab_color=?,tab_align=?,tab_repeat=?,tab_img=?,
				tab_bg=?,tab_font=?,tab_hbg=?,tab_hfont=?,
				text_font=?,text_link=?, flip=?
				where theme=?",
		array(trim(strval($init['css'])),
				trim(strval($init['bg_color'])),trim(strval($init['bg_fix'])),trim(strval($init['bg_align'])),trim(strval($init['bg_repeat'])),'',
				trim(strval($init['head_color'])),trim(strval($init['head_align'])),trim(strval($init['head_repeat'])),'',
				trim(strval($init['content_color'])),trim(strval($init['content_align'])),trim(strval($init['content_repeat'])),'',
				trim(strval($init['foot_color'])),trim(strval($init['foot_align'])),trim(strval($init['foot_repeat'])),'',
				trim(strval($init['left_color'])),trim(strval($init['left_align'])),trim(strval($init['left_repeat'])),'',
				trim(strval($init['right_color'])),trim(strval($init['right_align'])),trim(strval($init['right_repeat'])),'',
				trim(strval($init['lbar_color'])),trim(strval($init['lbar_align'])),trim(strval($init['lbar_repeat'])),trim(strval($init['lbar_font'])),'',
				trim(strval($init['tab_color'])),trim(strval($init['tab_align'])),trim(strval($init['tab_repeat'])),'',
				trim(strval($init['tab_bg'])),trim(strval($init['tab_font'])),trim(strval($init['tab_hbg'])),trim(strval($init['tab_hfont'])),
				trim(strval($init['text_font'])),trim(strval($init['text_link'])),intval($init['flip']),
				STYLEID));
				
		saveimg($style,'bg',$init);
		saveimg($style,'head',$init);
		saveimg($style,'content',$init);
		saveimg($style,'foot',$init);
		saveimg($style,'left',$init);
		saveimg($style,'right',$init);
		saveimg($style,'lbar',$init);
		saveimg($style,'tab',$init);
	}
}
?>