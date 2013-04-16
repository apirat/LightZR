<?php
$module=array();
$module['category']=array('system'=>'ระบบหลักของเว็บไซต์');
$module['name']='ปรับแต่งค่าพื้นฐาน';
$module['url']='pref';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='ระบบปรับแต่งค่าพื้นฐานทั่วๆไปสำหรับเว็บไซต์';
$module['compatible']=1.0;
$module['type']='system';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no')
$module['core']='yes';   //  enum('yes','no')
// Events
// Module -  function: {folder}_module_install($module_id) , {folder}_module_uninstall($module_id) , {folder}_module_reload($module_id)
// Service - function: {folder}_service_create($service_id) , {folder}_service_remove($service_id)
function pref_module_install($id)
{
}
function pref_module_reload($id)
{
	pref_module_install($id);
}
?>