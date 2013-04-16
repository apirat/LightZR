<?php
class html
{
	protected static $db=array();
	protected static $swfupload;
	public function __construct()
	{
		
	}
	public function tr($title,$fld,$value,$input='input',$prop=array(),$arg=array(),$arg2=array())
	{
		return '<tr><td class="colum">'.$title.':</td>'.$this->td($fld,$value,$input,$prop,$arg,$arg2).'</tr>';
	}
	public function td($fld,$value,$input='input',$prop=array(),$arg=array(),$arg2=array())
	{
		$func='';
		if(is_array($fld))
		{
			$func=' func="'.implode(',',$fld).'"';
			$fld=implode('_',$fld);
		}
		list($key,$val)=$this->form($fld,$value,$input,$prop,$arg,$arg2);
		if(isset($prop['enabled'])&&!$prop['enabled'])$val='';
		if(!$prop['tag'])$prop['tag']='td';
		if($input=='photo'||$input=='file')
		{
			return '<'.$prop['tag'].($prop['width']?' width="'.$prop['width'].'"':'').''.($prop['height']?' height="'.$prop['height'].'"':'').''.($prop['align']?' align="'.$prop['align'].'"':'').''.($prop['class']?' class="'.$prop['class'].'"':'').($prop['colspan']?' colspan="'.$prop['colspan'].'"':'').'>'.$prop['text1'].$key.$prop['text2'].$val.$prop['text'].($prop['help']?'<div style="border:1px solid #ddd; background:#f5f5f5; padding:5px; margin-top:5px">'.$prop['help'].'</div>':'').'</'.$prop['tag'].'>';
		}
		else
		{
			return '<'.$prop['tag'].' class="'.(isset($prop['enabled'])&&!$prop['enabled']?'':'edit').($prop['class']?' '.$prop['class']:'').'"'.($prop['width']?' width="'.$prop['width'].'"':'').''.($prop['title']?' title="'.$prop['title'].'"':'').''.($prop['height']?' height="'.$prop['height'].'"':'').''.($prop['align']?' align="'.$prop['align'].'"':'').''.($prop['full']?' full="'.$prop['full'].'"':'').((isset($prop['button'])&&!$prop['button'])?' nb="1"':'').((isset($prop['btdetail'])&&!$prop['btdetail'])?' nt="1"':'').($prop['colspan']?' colspan="'.$prop['colspan'].'"':'').'>'.$prop['text1'].'<span id="_'.$fld.'" ref="'.$input.'" sp="'.(isset($prop['space'])?'yes':'').'"'.$func.'>'.($key!=''?$key:'&nbsp;').'</span><strong id="_'.$fld.'_input">'.$val.'</strong>'.$prop['text2'].($prop['text']?'<em>'.$prop['text'].'</em>':'').($prop['help']?'<div style="border:1px solid #ddd; background:#f5f5f5; padding:5px; margin-top:5px">'.$prop['help'].'</div>':'').'</'.$prop['tag'].'>';
		}
	}
	public function form($fld,$value,$input='input',$prop=array(),$arg=array(),$arg2=array())
	{
		switch($input)
		{
			default:
				return array(htmlspecialchars(isset($prop['number_format'])?number_format($value,$prop['number_format']):$value, ENT_NOQUOTES),'<input type="text" class="tbox" size="'.($prop['size']?$prop['size']:'30').'" id="tmp_'.$fld.'" name="tmp_'.$fld.'" value="'.htmlspecialchars($value, ENT_QUOTES).'"'.($prop['required']?' required':'').'>');
			case 'textarea':
				return array(nl2br(htmlspecialchars($value, ENT_NOQUOTES)),'<textarea class="tbox" cols="'.($prop['cols']?$prop['cols']:'50').'" rows="'.($prop['rows']?$prop['rows']:'5').'" id="tmp_'.$fld.'" name="tmp_'.$fld.'"'.($prop['required']?' required':'').'>'.htmlspecialchars($value, ENT_NOQUOTES).'</textarea>');
			case 'date':
				if($fld=='birthday')
				{
					$arg['startyear']=date('Y')-120;
					$arg['stopyear']=date('Y')-10;
				}
				lz::h('time');
				$lang=(defined('LANG_ADMIN')?LANG_ADMIN:LANG);
				$html=$this->select2('tmp_'.$fld.'_day',intval(substr($value,8,2)),1,31,1,2,0,$prop);
				$html.='<select id="tmp_'.$fld.'_month" name="tmp_'.$fld.'_month" class="tbox"'.($prop['required']?' required':'').'>'.(isset($prop['space'])?'<option value="">'.$prop['space'].'</option>':'');
				for($i=1;$i<=12;$i++)$html.='<option value="'.substr("0".$i,-2).'"'.(intval(substr($value,5,2))==$i?' selected':'').'>'.time::$month[$i-1].'</option>';
				$html.="</select>\r\n";
				$html.=$this->select2('tmp_'.$fld.'_year',intval(substr($value,0,4)),($arg['startyear']?$arg['startyear']:date('Y')-1),($arg['stopyear']?$arg['stopyear']:date('Y')+1),-1,4,$lang=='th'?543:0,$prop);
				return array(time::show($value,'date'),$html);
			case 'time':
				lz::h('time');
				return array(time::show($value,'time'),$this->select2('tmp_'.$fld.'_hh',intval(substr($value,0,2)),0,23,1,2,0,$prop).':'.$this->select2('tmp_'.$fld.'_nn',intval(substr($value,3,2)),0,59,1,2,0,$prop));
			case 'datetime':
				$tmp=$this->form($fld,substr($value,0,10),'date',$prop,$arg);
				$tmp2=$this->form($fld,substr($value,11),'time',$prop,$arg);
				return array($tmp[0]?$tmp[0].' - '.$tmp2[0]:''.$tmp[1].' - '.$tmp2[1]);
			case 'select':
				if(!$arg&&$arg2['value'])
				{
					$arg=array();
					$l=explode("\n",trim($arg2['value']));
					for($i=0;$i<count($l);$i++)
					{
						$n=explode(',',$l[$i],2);
						$arg[$n[0]]=trim($n[1]);
					}					
				}
				return $this->select(($prop['notmp']?'':'tmp_').$fld,$value,$prop,$arg);
			case 'checkbox':
				if(!$arg&&$arg2['value'])
				{
					$arg=array();
					$l=explode("\n",trim($arg2['value']));
					for($i=0;$i<count($l);$i++)
					{
						$n=explode(',',$l[$i],2);
						$arg[$n[0]]=trim($n[1]);
					}					
				}
				return $this->checkbox(($prop['notmp']?'':'tmp_').$fld,$value,$prop,$arg);
			case 'db':
				return $this->select(($prop['notmp']?'':'tmp_').$fld,$value,$prop,html::db($arg['sql'],$arg['key'],$arg['value']));
			case 'province':
				$lang=(defined('LANG_ADMIN')?LANG_ADMIN:LANG);
				return $this->select(($prop['notmp']?'':'tmp_').$fld,$value,$prop,html::db('select id,name'.($lang!='th'?'_en as name':'').' from province order by name asc','id','name'));
			case 'photo':
			case 'file':
				$js='';
				if(!html::$swfupload)$js=html::$swfupload='<link rel="stylesheet" href="'.THEMES.'css/upload.css"><script src="'.HTTP.'js/swfupload.js" type="text/javascript"></script><script>function uploadSuccess(file,server_data){try{var progress = new FileProgress(file,this.customSettings.upload_target);progress.SetComplete();progress.SetStatus("Complete.  ["+$KB(file.size)+"]");progress.ToggleCancel(false);}catch(ex){this.debugMessage(ex);};thumbshow(server_data);};function fileDialogComplete(numFilesSelected, numFilesQueued){try{if(numFilesQueued>0){this.startUpload();}}catch (ex) {this.debug(ex);}};function thumbshow(file){var thumb=file.split("#");if(thumb.length>1){$("#file_view_"+$.trim(thumb[0])).html(thumb[1]);}else{lz.box.alert("error: "+file);}};</script>';
				$tmp=$this->$input('tmp_'.$fld,$value,$prop,$arg);
				return array($tmp[0],$js.$tmp[1]);
		}
	}
	public function db($sql,$key,$val)
	{
		if(!html::$db[$sql])
		{
			$tmp=lz::h('db')->getall($sql);
			html::$db[$sql]=array();
			for($i=0;$i<count($tmp);$i++)
			{
				html::$db[$sql][$tmp[$i][$key]]=$tmp[$i][$val];
			}
		}
		return html::$db[$sql];
	}
	public function select2($fld,$value,$start,$stop,$step=1,$size=2,$incval=0,$prop=array())
	{
		for($i=$start;$i<=$stop;$i=$i+abs($step))
		{
			$html=($step>0?$html:'').'<option value="'.substr("0000".$i,-$size).'"'.($value!=''&&intval($value)==$i?' selected':'').'>'.substr("0000".($i+$incval),-$size).'</option>'.($step>0?'':$html);
		}
		return '<select id="'.$fld.'" name="'.$fld.'" class="tbox'.($prop['required']?' validate required':'').'"'.($prop['required']?' required':'').'>'.(isset($prop['space'])?'<option value="">'.$prop['space'].'</option>':'').$html.'</select>'."\r\n";
	}
	public function select($fld,$value,$prop=array(),$arg=array())
	{
		$html='<select id="'.$fld.'" name="'.$fld.'" class="tbox'.($prop['required']?' validate required':'').'"'.($prop['required']?' required':'').'>';
		if(isset($prop['space']))
		{
			$html.='<option value="">'.$prop['space'].'</option>';
		}
		foreach($arg as $key=>$val)
		{
			if($key==$value)
			{
				$html.='<option value="'.$key.'" selected>'.$val.'</option>';
				$_value=$val;
			}
			else
			{
				$html.='<option value="'.$key.'">'.$val.'</option>';
			}
		}
		$html.="</select>\r\n";
		return $prop['form']?$html:array((!$_value&&(!$prop['empty']&&!isset($prop['space']))?$value:$_value),$html);
	}
	public function checkbox($fld,$value,$prop=array(),$arg=array())
	{
		$_value=array_map('trim',explode(',',$value));	
		$html='';	
		$c =' name="'.$k.($prop['form']?'[]':'').'"';
		$c .=' class="tbox '.$fld.' show-tooltip-w'.($e?' input_error':'').' '.$v['type'].'"';		
		foreach($arg as $key=>$val)
		{
			$html.='<label><input type="checkbox" id="s_'.$fld.'" '.$c.' value="'.$key.'"'.(in_array($key,$_value)?' checked':'').'> '.$val.' </label>';
		}
		return $prop['form']?$html:array($value,$html);
	}
	public function photo($fld,$value,$prop=array(),$arg=array())
	{
		if($value)$value='<img src="'.$value.'">';
		if($arg['relate']&&$arg['service'])
		{
			if($p=lz::h('db')->GetAll('select folder,s,t,o from file where relate=? and relate_type=? and file.service=? and type=?',array($arg['relate'],strval($arg['relate_type']),$arg['service'],'photo')))
			{
				$img=($arg['img']?$arg['img']:'s');
				for($i=0;$i<count($p);$i++)
				{
					$value .= '<img src="'.HTTP_FILES.$p[$i]['folder'].'/'.$img.'/'.$p[$i][$img].'"'.($arg['style']?' style="'.$arg['style'].'"':'').($arg['class']?' class="'.$arg['class'].'"':'').($arg['width']?' width="'.$arg['width'].'"':'').($arg['height']?' height="'.$arg['height'].'"':'').'> '.($arg['text2']?$arg['text2']:'');
				}
			}
		}
		if($arg['function'])
		{
			$value.=call_user_func($arg['function']);
		}
		return array('<div id="file_view_'.$fld.'" style="margin-bottom:5px">'.$value.'</div>','<div id="file_up_'.$fld.'" class="flash"></div><span><span id="file_select_'.$fld.'"></span></span><script>var file_object_'.$fld.';$(function(){file_object_'.$fld.'=new SWFUpload({upload_url: "'.URL.'",file_post_name: "file_post",post_params: {"session_key":"'.MY_SESSION.'","file_name":"'.$fld.'"},file_size_limit:"5120",file_types:"*.gif;*.jpg;*.jpeg;*.png;*.bmp",file_types_description:"All Images",file_upload_limit:"0",file_queue_limit:"0",file_queued_handler:uploadStart,file_queue_error_handler:fileQueueError,file_dialog_complete_handler:fileDialogComplete,upload_progress_handler:uploadProgress,upload_error_handler:uploadError,upload_success_handler:uploadSuccess,upload_complete_handler:uploadComplete,flash_url:"'.HTTP.'flash/swfupload.swf",custom_settings:{upload_target:"file_up_'.$fld.'"},button_placeholder_id : "file_select_'.$fld.'",button_image_url : "'.IMAGES.'selectfile.png",button_width: 130,button_height: 18,button_text_top_padding: 0,button_text_left_padding: 25,button_text : \'<span class="button">เลือกไฟล์รูปภาพ</span>\',button_text_style : \'.button { font-family: "ms Sans Serif"; font-size: 12pt; font-weight:bold;}\',button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,button_cursor: SWFUpload.CURSOR.HAND});});</script>');
	}
	public function file($fld,$value,$prop=array(),$arg=array())
	{
		if($value)$value='<a href="'.$value.'" target="_blank">'.$value.'</a>';
		if($arg['relate']&&$arg['service'])
		{
			if($p=lz::h('db')->GetAll('select folder,s,detail from file where relate=? and relate_type=? and file.service=? type=?',array($arg['relate'],strval($arg['relate_type']),$arg['service'],'file')))
			{
				for($i=0;$i<count($p);$i++)
				{
					$value .= '<a href="'.HTTP_FILES.$p[$i]['folder'].'/'.$p[$i]['s'].'"'.($arg['target']?' target="'.$arg['target'].'"':'').($arg['style']?' style="'.$arg['style'].'"':'').($arg['class']?' class="'.$arg['class'].'"':'').'>'.($p[$i]['detail']?$p[$i]['detail']:$p[$i]['s']).'</a>'.($arg['text2']?$arg['text2']:'');
				}
			}
		}
		if($arg['function'])
		{
			$value.=call_user_func($arg['function']);
		}
		return array('<div id="file_view_'.$fld.'" style="margin-bottom:5px">'.$value.'</div>','<div id="file_up_'.$fld.'" class="flash"></div><span><span id="file_select_'.$fld.'"></span> </span><script>var file_object_'.$fld.';$(function(){file_object_'.$fld.'=new SWFUpload({upload_url: "'.URL.'",file_post_name: "file_post",post_params: {"session_key":"'.MY_SESSION.'","file_name":"'.$fld.'"},file_size_limit:"5120",file_types:"*.*",file_types_description:"All Files",file_upload_limit:"0",file_queue_limit:"0",file_queued_handler:uploadStart,file_queue_error_handler:fileQueueError,file_dialog_complete_handler:fileDialogComplete,upload_progress_handler:uploadProgress,upload_error_handler:uploadError,upload_success_handler:uploadSuccess,upload_complete_handler:uploadComplete,flash_url:"'.HTTP.'flash/swfupload.swf",custom_settings:{upload_target:"file_up_'.$fld.'"},button_placeholder_id : "file_select_'.$fld.'",button_image_url : "'.IMAGES.'selectfile.png",button_width: 130,button_height: 18,button_text_top_padding: 0,button_text_left_padding: 25,button_text : \'<span class="button">เลือกไฟล์แนบ</span>\',button_text_style : \'.button { font-family: "ms Sans Serif"; font-size: 12pt; font-weight:bold;}\',button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,button_cursor: SWFUpload.CURSOR.HAND});});</script>');
	}
	
	public function input($k,$v,$d=array(),$e='')
	{
		$tmp='';
		$tmp.=' id="s_'.$k.'"';
		$tmp.=' name="'.$k.'"';
		$tmp.=' title="'.($v['title']?$v['title']:$v['name']).'"';
		$tmp.=' class="tbox show-tooltip-w'.($e?' input_error':'').''.($v['status']==3?' validate required':'').' '.$v['type'].'"';
		if($v['minlength'])$tmp.=' minlength="'.$v['minlength'].'"';
		if($v['maxlength'])$tmp.=' maxlength="'.$v['maxlength'].'"';
		$v['required']=false;
		if($v['status']==3)$v['required']=true;
		if($v['type']=='textarea')
		{
			if($v['size'])$tmp.=' cols="'.$v['size'].'"';
			if($v['rows'])$tmp.=' rows="'.$v['rows'].'"';
			
			$tmp='<textarea'.$tmp.($v['status']==3?' required':'').'>'.$d[$k].'</textarea>';
		}
		elseif($v['type']=='province')
		{
			$province=lz::h('db')->getall('select id,name from province order by id asc');
			$tmp='<select'.$tmp.($v['status']==3?' required':'').'>';
			$tmp.='<option value="">'.($v['space']?$v['space']:'กรุณาเลือกจังหวัด').'</option>';
			for($i=0;$i<count($province);$i++)
			{
				$tmp.='<option value="'.$province[$i]['id'].'"'.($d[$k]==$province[$i]['id']?' selected':'').'>'.$province[$i]['name'].'</option>';
			}
			$tmp.='</select>';
		}
		elseif($v['type']=='select')
		{
			$tmp='<select'.$tmp.($v['status']==3?' required':'').'>';
			$l=explode("\n",trim($v['value']));
			for($i=0;$i<count($l);$i++)
			{
				$n=explode(',',$l[$i],2);
				$tmp.='<option value="'.$n[0].'"'.($d[$k]==$n[0]?' selected':'').'>'.$n[1].'</option>';
			}
			$tmp.='</select>';
		}
		elseif($v['type']=='checkbox')
		{
			$tmp='';		
			//$c =' id="s_'.$k.'"';
			$c =' name="'.$k.'[]"';
			$c .=' title="'.($v['title']?$v['title']:$v['name']).'"';
			$c .=' class="tbox show-tooltip-w'.($e?' input_error':'').''.($v['status']==3?' validate required':'').' '.$v['type'].'"';
			$l=explode("\n",trim($v['value']));
			for($i=0;$i<count($l);$i++)
			{
				$n=explode(',',$l[$i],2);
				$tmp.='<label><input type="checkbox" id="s_'.$k.($i>1?$i:'').'" '.$c.' value="'.trim($n[0]).'"'.($d[$k]==trim($n[0])?' checked':'').'> '.trim($n[1]).'</label>';
			}
		}
		elseif($v['type']=='date')
		{
			$from=($v['from']?$v['from']:date('Y')-100);
			$to=($v['to']?$v['to']:date('Y'));
			
			$tmp=$this->select2($k.'_date',$d[$k.'_date'],1,31,1,2,0,array_merge($v,array('space'=>'วัน'))).' '.$this->select($k.'_month',$d[$k.'_month'],array_merge($v,array('space'=>'เดือน','form'=>true)),array('1'=>'มกราคม','2'=>'กุมภาพันธ์','3'=>'มีนาคม','4'=>'เมษายน','5'=>'พฤษภาคม','6'=>'มิถุนายน','7'=>'กรกฏาคม','8'=>'สิงหาคม','9'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม')).' '.$this->select2($k.'_year',$d[$k.'_year'],$from,$to,-1,4,543,array_merge($v,array('space'=>'ปี')));
		}
		else
		{
			if($v['size'])$tmp.=' size="'.$v['size'].'"';
			if($v['type']=='email')$v['type']='text';
			if($v['type']=='photo')$v['type']='file';
			
			$tmp='<input type="'.$v['type'].'"'.$tmp.' value="'.$d[$k].'"'.($v['status']==3?' required':'').'>';
		}
		if($v['status']==3) $tmp.=' <i>*</i>';
		$tmp.='<div id="err_'.$k.'" class="msg_error" style="display:'.($e?'block':'none').'">'.$e.'</div>';
		$tmp.=$v['text'];
		return $tmp;
	}
}