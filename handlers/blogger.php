<?php
class blogger
{
	public static $gdClient;
	function __construct()
	{
		set_include_path(dirname(__FILE__).PATH_SEPARATOR.get_include_path());
		require_once 'Zend/Loader.php';
		Zend_Loader::loadClass('Zend_Gdata');
		Zend_Loader::loadClass('Zend_Gdata_Query');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		//lz::get('blogger');
	}
	
	function post($email,$password,$blogid,$title, $content,$category='')
	{
		$client = Zend_Gdata_ClientLogin::getHttpClient($email, $password, 'blogger', null, Zend_Gdata_ClientLogin::DEFAULT_SOURCE, null, null, Zend_Gdata_ClientLogin::CLIENTLOGIN_URI, 'GOOGLE');
		blogger::$gdClient = new Zend_Gdata($client);		
		$entry = blogger::$gdClient->newEntry();
		$entry->title = blogger::$gdClient->newTitle($title);
		$entry->content = blogger::$gdClient->newContent($content);
		$entry->content->setType('text');
		$createdPost = blogger::$gdClient->insertEntry($entry, 'http://www.blogger.com/feeds/' . $blogid . '/posts/default');
		$idText = split('-', $createdPost->id->text);
		return array($idText[2],$createdPost->link[4]->href); 
	}
}
?>