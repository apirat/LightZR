<?php
$db=lz::h('db');
$template=lz::h('template');
$cf=unserialize($box['option']);
if($cf['count']<1)$cf['count']=6;
lz::h('product')->set(array('type'=>'recommend','limit'=>$cf['count']));
$template->display('layout.recommend');
?>