<?php
class time
{
	public static $month=array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
	public static $day=array('อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์');
	public static function ago($s)
	{
		$s = time()-strtotime($s);
		if ($s<0)$s=0;
		foreach (array("60:sec","60:min","24:hour","30:day","12:month","0:year") as $x)
		{
			$y=explode(":",$x);
			if($y[0]>1){$v=$s%$y[0];$s=floor($s/$y[0]);}else{$v=$s;}
			$t[$y[1]]=$v;
		}
		foreach (array('Year:year','Month:month','Day:day','Hour:hour','Min:min') as $x)
		{
			$y = explode(":",$x);
			if($t[$y[1]]) return $t[$y[1]]." ".$y[0];
		}
		return '>1 Min';
	}
	public static function show($s,$time='')
	{
		switch($time)
		{
			case 'date':
				return ($s=='0000-00-00'||$s==''?'':intval(substr($s,8,2))." ".time::$month[intval(substr($s,5, 2))-1]." ".intval(substr($s,0,4)));
			case 'time':
				return substr($s,0,5);
			case 'datetime':
				return ($s=='0000-00-00 00:00:00'||$s==''?'':intval(substr($s,8,2))." ".time::$month[intval(substr($s,5, 2))-1]." ".intval(substr($s,0,4)).' เวลา '.substr($s,11,5));
			case 'thaitime':
				if($s=='0000-00-00 00:00:00'||$s=='')return '';
				$s=date('Y-m-d H:i:s',strtotime($s)+(12*3600));
				return intval(substr($s,8,2))." ".time::$month[intval(substr($s,5, 2))-1]." ".intval(substr($s,0,4)).' เวลา '.substr($s,11,5);
		}
	}
	public static function show2($s,$time=true)
	{
		$tmp=getdate($s);
		return (int)$tmp['mday']." ".time::$month[(int)$tmp['mon']-1]." ".(int)($tmp['year']).($time?" เวลา ".$tmp['hours'].':'.$tmp['minutes'].':'.$tmp['seconds']:"");
	}
}
?>