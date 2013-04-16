<?php
$db=lz::h('db');
$template=lz::h('template');
$cf=unserialize($box['option']);
lz::h('product')->set(array('type'=>'recent','limit'=>$cf['amount']));
$template->display('layout.recent');
?>