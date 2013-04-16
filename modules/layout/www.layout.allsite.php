<?			
$db=lz::h('db');
$cf=unserialize($box['option']);
if($cf['home']<1)$cf['home']=40;
if($cf['more']<1)$cf['more']=20;
if(defined('NOCONTENT'))
{
	$site=$db->GetAll('select title,link,pgroup,domain from product_category where pgroup!=? order by rand() limit 0,'.$cf['home'],array(''));
}
else
{
	$site=$db->GetAll('select id,title,link,pgroup,domain from product_category where pgroup!=?  and id>? order by id asc limit 0,'.$cf['more'],array('', lz::$s['id']));
	if(!is_array($site))$site=array();
	if(count($site)<$cf['more'])
	{
		if(isset($site[0]['id']))$h=$site[0]['id'];
		$site2=$db->GetAll('select title,link,pgroup,domain from product_category where pgroup!=?  and id!=? '.(isset($site[0]['id'])?" and id<'".$site[0]['id']."'":"").' order by id asc limit 0,'.($cf['more']-count($site)),array('',lz::$s['id']));
		if(is_array($site2))$site=array_merge($site,$site2);
	}
}
$n=array();
$m=array();
if(count($site))
{
	ksort($site);
	foreach($site as $k=>$v)
	{
		$n[$k]=$v['pgroup'];
		$m[$k]=$v['name'];
	}
	array_multisort($site, SORT_STRING,$n, SORT_STRING,$m);
}
$template=lz::h('template');
$template->assign('site2',$site);
$template->display('layout.allsite');
?>