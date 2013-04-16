<?php
if(strtolower(lz::$f[1])!=strtolower(lz::$c['cron']))
{
		header ('HTTP/1.1 301 Moved Permanently');
		header('Location: '.QUERY);
		exit;
}

set_time_limit(1800);
ini_set('html_errors',0);
ini_set('display_errors',E_ALL & ~E_NOTICE);
error_reporting(E_ALL & ~E_NOTICE);
restore_error_handler();


$db=lz::h('db');
$waitting=false;


echo '<br>-------------------------------------------------------------------<br><br>';

if(intval(lz::$c['asindelay'])>0)
{
	if($ctime=$db->GetRow('select id,asinpost,lastasin from product_category where asinpost!=? order by lastasin desc',array('')))
	{
		$diff=time()-strtotime($ctime['lastasin']);
		if($diff>=(60 * lz::$c['asindelay']) || $ctime['lastasin']=='0000-00-00 00:00:00')
		{
			if($cate=$db->GetRow('select id,title,asinpost,awstag,domain,link,lastasin from product_category where asinpost!=? order by lastasin asc,id asc',array('')))
			{
				$asin=array_unique(array_map('trim',explode(',',strtolower($cate['asinpost']))));
				$tmp=array();
				$product=false;
				for($i=0;$i<count($asin);$i++)
				{
					if(preg_match('/^b0([a-z0-9]+)$/',$asin[$i],$param)||preg_match('/^([0-9]{10})$/',$asin[$i],$param))
					{
						if(!$db->GetRow('select asin from product where asin=? and category=?',array($asin[$i],$cate['id'])))
						{
							if(!$product)
							{
								$product=$asin[$i];
							}
							else
							{
								$tmp[]=$asin[$i];
							}
						}
					}
				}
				$db->Execute('update product_category set lastasin=now(), asinpost=? where id=?',array(implode(', ',$tmp),$cate['id']));
				if($product)
				{
					$amazon=lz::h('amazon');
					$params=array();
					$params['MerchantId']='All';
					$params['Condition']='All';
					$params['Operation']='ItemLookup';
					$params['ItemId']=$product;					
					$data = $amazon->request($params,$cate['awstag']);
					$data = lz::h('xml')->process($data);
					$array = $data['Items']['Item'];
					unset($data,$product);
					if($array['ItemAttributes']['Title'])
					{
						$amazon->assigndb($array,$cate['id'],true);
						if($product=$db->GetRow('select title,link from product where asin=? and category=?',array($array['ASIN'],$cate['id'])))
						{
							if($cate['domain'])
							{
								$purl='http://www.'.$cate['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
							}
							elseif(lz::$c['sub']==2)
							{
								$purl='http://'.$cate['link'].'.'.lz::$cf['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
							}
							elseif(lz::$c['sub']==1)
							{
								$purl='http://www.'.lz::$cf['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
							}
							else
							{
								$purl='http://www.'.lz::$cf['domain'].QUERY.$cate['link'].'/'.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
							}
						}
					
						echo '<h5>เพิ่มสินค้าด้วย ASIN ในหมวด - '.$cate['id'].' - '.$cate['title'].'</h5>';
						$lang=array('af','sq','ar','be','bg','ca','hr','cs','da','nl','en','et','tl','fi','fr','gl','de','el','ht','iw','hi','hu','is','id','ga','it','ja','ko','lv','lt','mk','ms','mt','no','fa','pl','pt','ro','ru','sr','sk','sl','es','sw','sv','th','tr','uk','vi','cy','yi');
						$v=explode(',',lz::$c['apdlang']);
						$z=array();
						for($i=0;$i<count($v);$i++)
						{
							$k=strtolower(trim($v[$i]));
							if(in_array($k,$lang))
							{
								$z[]=$k;
							}
						}
						if(count($z)&&intval(lz::$c['aptype'])>=1)
						{
							$title=trim(strip_tags(strval($array['ItemAttributes']['Title'])));
							if($array['EditorialReviews']['EditorialReview'][0])
							{
								$content=$array['EditorialReviews']['EditorialReview'][0]['Content'];
							} 
							else
							{
								$content=$array['EditorialReviews']['EditorialReview']['Content'];
							}
							$db->close();
							
							if(in_array(intval(lz::$c['aptype']),array(2,4)))
							{
								$tmp=lz::h('rewrite')->gen(strip_tags($title."\r\n\r\n #% \r\n\r\n".$content),$z);
								if(strpos($tmp,'#%')>-1)
								{
									list($title2,$content2)=explode('#%',$tmp,2);
								}
								elseif(strpos($tmp,'# %')>-1)
								{
									list($title2,$content2)=explode('# %',$tmp,2);
								}
								else
								{
									list($title2,$content2)=explode('#',$tmp,2);
									$content2=trim(trim($content2),'%');
								}
								$title2=trim(strip_tags(strval($title2)));
								if(!$title2)$title2=$title;
							}
							else
							{
								$title2=$title;
								$content2=lz::h('rewrite')->gen(strip_tags($content),$z);
							}
							
							if(intval(lz::$c['linkword'])<1)lz::$c['linkword']=99;
							$link=implode('-',array_slice(explode('-',lz::h('format')->link($title2,false)),0,lz::$c['linkword'])).'-'.strtolower($array['ASIN']);
					
					
							$db->Execute('update product set title=?,link=?,content=?,lastrewrite=now() where asin=? and category=?',array($title2,$link,trim(strval($content2)),$array['ASIN'],$cate['id']));
							
							if($cate['domain'])
							{
								$purl='http://www.'.$cate['domain'].QUERY.$link.(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
							}
							elseif(lz::$c['sub']==2)
							{
								$purl='http://'.$cate['link'].'.'.lz::$cf['domain'].QUERY.$link.(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
							}
							elseif(lz::$c['sub']==1)
							{
								$purl='http://www.'.lz::$cf['domain'].QUERY.$link.(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
							}
							else
							{
								$purl='http://www.'.lz::$cf['domain'].QUERY.$cate['link'].'/'.$link.(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
							}
						}
						
						if(lz::$c['zone']=='com')
						{
							$v=explode(',',lz::$c['aprlang']);
							$z=array();
							for($i=0;$i<count($v);$i++)
							{
								$k=strtolower(trim($v[$i]));
								if(in_array($k,$lang))
								{
									$z[]=$k;
								}
							}
							if(count($z)&&intval(lz::$c['aptype'])>=3)
							{
								lz::h('amazon')->getavg($array['ASIN'],$cate['id'],$z);
								$db->Execute('update autopost set rew2=? where id=?',array(1,$logsid));
							}
							else
							{
								lz::h('amazon')->getavg($array['ASIN'],$cate['id']);
							}
							echo '<h5>ดังข้อมูล custome review - '.$array['ItemAttributes']['Title'].'</h5>';
						}
						
						lz::h('cache')->del('home');
						lz::h('cache')->del('box_'.$cate['id']);
						
						if(lz::$c['apping']==1||(lz::$c['apping']==2&&rand(0,1)==1))
						{
							sendping($product['title'],$purl);
							$db->Execute('update product set pingo=now() where asin=? and category=?',array($array['ASIN'],$cate['id']));
						}
						echo '<h5>เสร็จสิ้นการดึงสินค้าด้วย asin - '.$purl.'</h5>';
					//	exit;
					}
				}
			}
		}
		else
		{
			$waitting=true;
		}
	}
}

echo '<br>-------------------------------------------------------------------<br><br>';

if(intval(lz::$c['apdelay'])>0)
{
	
	if($ctime=$db->GetRow('select lastsearch from product_category order by lastsearch desc'))
	{
		$diff=time()-strtotime($ctime['lastsearch']);
		if($diff>=(60 * lz::$c['apdelay']) || $ctime['lastsearch']=='0000-00-00 00:00:00')
		{
			$cate=$db->GetAll('select c.* from product_category as c where c.searchindex!=? and c.keywords!=? and c.autopost!=? and c.maxpage>? group by c.id order by c.lastsearch asc, c.id asc limit 0,5',array('','','no',0));
			$have=false;
			for($i=0;$i<count($cate);$i++)
			{
				$db->Execute('update product_category set lastsearch=now() where id=?',array($cate[$i]['id']));
				if($cate[$i]['scur']<1)
				{
					$cate[$i]['scur']=1;
					$db->Execute('update product_category set scur=? where id=?',array($cate[$i]['scur'],$cate[$i]['id']));
				}
				if($cate[$i]['maxpage']<$cate[$i]['scur'])
				{
					$cate[$i]['scur']=1;
					$db->Execute('update product_category set scur=? where id=?',array($cate[$i]['scur'],$cate[$i]['id']));
				}
				$group=false;
				if(trim($cate[$i]['onlygroup']))
				{
					$group=array_map('trim',explode(',',strtolower($cate[$i]['onlygroup'])));
				}
				$intitle=false;
				if(trim($cate[$i]['intitle']))
				{
					$intitle=array_map('trim',explode(',',strtolower($cate[$i]['intitle'])));
				}
				$inalltitle=false;
				if(trim($cate[$i]['inalltitle']))
				{
					$inalltitle=array_map('trim',explode(',',strtolower($cate[$i]['inalltitle'])));
				}
				$outtitle=false;
				if(trim($cate[$i]['outtitle']))
				{
					$outtitle=array_map('trim',explode(',',strtolower($cate[$i]['outtitle'])));
				}
				$onlymanu=false;
				if(trim($cate[$i]['onlymanu']))
				{
					$onlymanu=array_map('trim',explode(',',strtolower($cate[$i]['onlymanu'])));
				}
				
				$item=lz::h('amazon')->search($cate[$i]['searchindex'],$cate[$i]['keywords'],$cate[$i]['scur'],false,$cate[$i]['id'],$group,$intitle,$outtitle,$inalltitle,$onlymanu,$cate[$i]['rsort'],$cate[$i]['node'],$cate[$i]['rate'],$cate[$i]['awstag']);
				
				for($j=0;$j<count($item['Item']);$j++)
				{
					if($item['Item'][$j]['onlybinding'])
					{
						if(!$db->GetOne('select asin from product where category=? and asin=?',array($cate[$i]['id'],$item['Item'][$j]['onlybinding'])))
						{
							$have=array('item'=>$item['Item'][$j],'category'=>$cate[$i]);
							break;
						}
					}
				}
				if(!$have)
				{
					$fail=$cate[$i]['scur'];
					$cate[$i]['scur']+=1;
					if(intval($item['TotalPages'])<$cate[$i]['scur'])
					{
						$cate[$i]['scur']=1;
					}
					$db->Execute('update product_category set scur=?,spage=? where id=?',array($cate[$i]['scur'],intval($item['TotalPages']),$cate[$i]['id']));
					$db->Execute('insert autopost set time=now(),status=?,category=?,detail=?',array(2,$cate[$i]['id'],'ไม่พบสินค้าใหม่ในหน้าที่ '.$fail.', ระบบจะค้นหน้าถัดไปอัตโนมัติในรอบถัดไป'));
					echo '<h5>ไม่พบสินค้าใหม่ ระบบจะค้นไปยังหน้าถัดไป - '.$cate[$i]['title'].'</h5>';
				}
				else
				{
					break;
				}
			}
			
			if($have)
			{
				$amazon=lz::h('amazon');
				$amazon->assigndb($have['item'],$have['category']['id'],true);
				if($product=$db->GetRow('select title,link from product where asin=? and category=?',array($have['item']['ASIN'],$have['category']['id'])))
				{
					if($have['category']['domain'])
					{
						$purl='http://www.'.$have['category']['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
					elseif(lz::$c['sub']==2)
					{
						$purl='http://'.$have['category']['link'].'.'.lz::$cf['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
					elseif(lz::$c['sub']==1)
					{
						$purl='http://www.'.lz::$cf['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
					else
					{
						$purl='http://www.'.lz::$cf['domain'].QUERY.$have['category']['link'].'/'.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
				}
				$logsid=$db->Execute('insert autopost set time=now(),status=?,category=?,product=?,detail=?',array(3,$have['category']['id'],$have['item']['ASIN'],$purl));
				
				echo '<h5>เพิ่มสินค้าใหม่ในหมวด - '.$have['category']['title'].'</h5>';
				$lang=array('af','sq','ar','be','bg','ca','hr','cs','da','nl','en','et','tl','fi','fr','gl','de','el','ht','iw','hi','hu','is','id','ga','it','ja','ko','lv','lt','mk','ms','mt','no','fa','pl','pt','ro','ru','sr','sk','sl','es','sw','sv','th','tr','uk','vi','cy','yi');
				$v=explode(',',lz::$c['apdlang']);
				$z=array();
				for($i=0;$i<count($v);$i++)
				{
					$k=strtolower(trim($v[$i]));
					if(in_array($k,$lang))
					{
						$z[]=$k;
					}
				}
				
							
				if(intval(lz::$c['aptype'])>=1&&intval(lz::$c['aptype'])<=4)
				{
					$title=trim(strip_tags(strval($have['item']['ItemAttributes']['Title'])));
					if($have['item']['EditorialReviews']['EditorialReview'][0])
					{
						$content=$have['item']['EditorialReviews']['EditorialReview'][0]['Content'];
					} 
					else
					{
						$content=$have['item']['EditorialReviews']['EditorialReview']['Content'];
					}
					$db->close();
					
					$tmp='';
					
					if(in_array(intval(lz::$c['aptype']),array(2,4)))
					{
						
						if(lz::h('spinner')->connect())
						{
							$tmp=lz::h('spinner')->rewrite(strip_tags($title."\n\n #% \n\n".$content));
						}
						if(!$tmp && count($z))
						{
							$tmp=lz::h('rewrite')->gen(strip_tags($title."\r\n\r\n #% \r\n\r\n".$content),$z);
						}
					
						
						if(strpos($tmp,'#%')>-1)
						{
							list($title2,$content2)=explode('#%',$tmp,2);
						}
						elseif(strpos($tmp,'# %')>-1)
						{
							list($title2,$content2)=explode('# %',$tmp,2);
						}
						else
						{
							list($title2,$content2)=explode('#',$tmp,2);
							$content2=trim(trim($content2),'%');
						}
						$title2=trim(strip_tags(strval($title2)));
						if(!$title2)$title2=$title;
						echo '<h5>ชื่อสินค้า - '.$title.'</h5>';
						echo '<h5>บทความ - '.strval($content).'</h5>';
						echo '<h5>rewrite ชื่อสินค้าใหม่ - '.strval($title2).'</h5>';
						echo '<h5>rewrite บทความใหม่ - '.strval($content2).'</h5>';
					}
					else
					{
						$title2=$title;
						
						if(lz::h('spinner')->connect())
						{
							$content2=lz::h('spinner')->rewrite(strip_tags($content));
						}
						if(!$tmp && count($z))
						{
							$content2=lz::h('rewrite')->gen(strip_tags($content),$z);
						}
						echo '<h5>บทความ - '.strval($content).'</h5>';
						echo '<h5>rewrite บทความใหม่ - '.strval($content2).'</h5>';
					}
					
					if(intval(lz::$c['linkword'])<1)lz::$c['linkword']=99;
					$link=implode('-',array_slice(explode('-',lz::h('format')->link($title2,false)),0,lz::$c['linkword'])).'-'.strtolower($have['item']['ASIN']);
			
			
					$db->Execute('update product set title=?,link=?,content=?,lastrewrite=now() where asin=? and category=?',array($title2,$link,trim(strval($content2)),$have['item']['ASIN'],$have['category']['id']));
					
					if($have['category']['domain'])
					{
						$purl='http://www.'.$have['category']['domain'].QUERY.$link.(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
					elseif(lz::$c['sub']==2)
					{
						$purl='http://'.$have['category']['link'].'.'.lz::$cf['domain'].QUERY.$link.(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
					elseif(lz::$c['sub']==1)
					{
						$purl='http://www.'.lz::$cf['domain'].QUERY.$link.(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
					else
					{
						$purl='http://www.'.lz::$cf['domain'].QUERY.$have['category']['link'].'/'.$link.(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
					
					$db->Execute('update autopost set rew1=?,detail=? where id=?',array(1,$purl,$logsid));
				}
				
				if(lz::$c['zone']=='com')
				{
					$v=explode(',',lz::$c['aprlang']);
					$z=array();
					for($i=0;$i<count($v);$i++)
					{
						$k=strtolower(trim($v[$i]));
						if(in_array($k,$lang))
						{
							$z[]=$k;
						}
					}
					if(count($z)&&intval(lz::$c['aptype'])>=3)
					{
						lz::h('amazon')->getavg($have['item']['ASIN'],$have['category']['id'],$z);
						$db->Execute('update autopost set rew2=? where id=?',array(1,$logsid));
					}
					else
					{
						lz::h('amazon')->getavg($have['item']['ASIN'],$have['category']['id']);
					}
					echo '<h5>ดังข้อมูล custome review - '.$have['item']['ItemAttributes']['Title'].'</h5>';
				}
				
				lz::h('cache')->del('home');
				lz::h('cache')->del('box_'.$have['category']['id']);
				
				if(lz::$c['apping']==1||(lz::$c['apping']==2&&rand(0,1)==1))
				{
					sendping($product['title'],$purl);
					$db->Execute('update autopost set ping=? where id=?',array(1,$logsid));
					$db->Execute('update product set pingo=now() where asin=? and category=?',array($have['item']['ASIN'],$have['category']['id']));
				}
				$db->Execute('update autopost set status=? where id=?',array(1,$logsid));
				echo '<h5>เสร็จสิ้นการดึงสินค้าใหม่ - '.$purl.'</h5>';
			//	exit;
			}
		}
		else
		{
			$waitting=true;
		}
	}
	else
	{
		echo 'คุณยังไม่ได้เพิ่มหมวดสินค้า';	
		//exit;
	}
	
}


echo '<br>-------------------------------------------------------------------<br><br>';

if(intval(lz::$c['rwdelay'])>0&&intval(lz::$c['aptype'])>0)
{
	if($ctime=$db->GetRow('select lastreview,category from product order by lastreview desc'))
	{
		$diff=time()-strtotime($ctime['lastreview']);
		if($diff>=(60 * lz::$c['rwdelay']) || $ctime['lastreview']=='0000-00-00 00:00:00')
		{
			if(!$product=$db->GetRow('select title,link,category,asin,editor,content,lastreview,lastbot from product where content=? and lastrewrite=? and category>? order by category asc,avg desc',array('','0000-00-00 00:00:00',$ctime['category'])))
			{
				$product=$db->GetRow('select title,link,category,asin,editor,content,lastreview,lastbot from product where content=? and lastrewrite=? order by category asc,avg desc',array('','0000-00-00 00:00:00'));
			}
			if($product)
			{
				echo '<h5>rewrite สินค้าใหม่ในหมวด - '.$product['title'].'</h5>';
				$lang=array('af','sq','ar','be','bg','ca','hr','cs','da','nl','en','et','tl','fi','fr','gl','de','el','ht','iw','hi','hu','is','id','ga','it','ja','ko','lv','lt','mk','ms','mt','no','fa','pl','pt','ro','ru','sr','sk','sl','es','sw','sv','th','tr','uk','vi','cy','yi');
				$v=explode(',',lz::$c['apdlang']);
				$z=array();
				for($i=0;$i<count($v);$i++)
				{
					$k=strtolower(trim($v[$i]));
					if(in_array($k,$lang))
					{
						$z[]=$k;
					}
				}
				if(count($z))
				{
					$db->close();
					if(in_array(intval(lz::$c['aptype']),array(2,4)))
					{
						$tmp=lz::h('rewrite')->gen(strip_tags($product['title']."\r\n\r\n #% \r\n\r\n".$product['editor']),$z);
						if(strpos($tmp,'#%')>-1)
						{
							list($title2,$content2)=explode('#%',$tmp,2);
						}
						elseif(strpos($tmp,'# %')>-1)
						{
							list($title2,$content2)=explode('# %',$tmp,2);
						}
						else
						{
							list($title2,$content2)=explode('#',$tmp,2);
							$content2=trim(trim($content2),'%');
						}
						$title2=trim(strip_tags(strval($title2)));
						if(!$title2)$title2=$product['title'];
						echo '<h5>ชื่อสินค้า - '.$product['title'].'</h5>';
						echo '<h5>บทความ - '.$product['editor'].'</h5>';
						echo '<h5>rewrite ชื่อสินค้าใหม่ - '.strval($title2).'</h5>';
						echo '<h5>rewrite บทความใหม่ - '.strval($content2).'</h5>';
						
					}
					else
					{
						$content2=lz::h('rewrite')->gen(strip_tags($product['editor']),$z);
						$title2=$product['title'];
						echo '<h5>บทความ - '.$product['editor'].'</h5>';
						echo '<h5>rewrite บทความใหม่ - '.strval($content2).'</h5>';
					}
					if($product['lastbot']=='0000-00-00 00:00:00')
					{
						if(intval(lz::$c['linkword'])<1)lz::$c['linkword']=99;
						$link=implode('-',array_slice(explode('-',lz::h('format')->link($title2,false)),0,lz::$c['linkword'])).'-'.strtolower($product['asin']);
						$db->Execute('update product set title=?,link=?,content=?,lastrewrite=now() where asin=? and category=?',array($title2,$link,trim(strval($content2)),$product['asin'],$product['category']));
					}
					else
					{
						$db->Execute('update product set title=?,content=?,lastrewrite=now() where asin=? and category=?',array($title2,trim(strval($content2)),$product['asin'],$product['category']));
					}
				}
				
				if(lz::$c['zone']=='com'&&intval(lz::$c['aptype'])>=3)
				{
					$v=explode(',',lz::$c['aprlang']);
					$z=array();
					for($i=0;$i<count($v);$i++)
					{
						$k=strtolower(trim($v[$i]));
						if(in_array($k,$lang))
						{
							$z[]=$k;
						}
					}
					if(count($z))
					{
						$db->Execute('delete from review where asin=?',array($asin));
						lz::h('amazon')->getavg($product['asin'],$product['category'],$z);
					}
				}
				
				lz::h('cache')->del('home');
				lz::h('cache')->del('box_'.$product['category']);
				
				echo '<h5>เสร็จสิ้น rewrite บทความ</h5>';
			//	exit;
			}
		}
		else
		{
			$waitting=true;
		}
	}
	else
	{
		echo 'คุณยังไม่ได้เพิ่มหมวดสินค้า';	
		//exit;
	}
	
}

echo '<br>-------------------------------------------------------------------<br><br>';


$sendbl=true;



if(intval(lz::$c['bldelay'])>0)
{
	if($ctime=$db->GetRow('select postid,time from blog_post order by time desc'))
	{
		$diff=time()-strtotime($ctime['time']);
		if($ctime['postid']&&$diff<(60 * lz::$c['bldelay']))
		{
			$sendbl=false; 	//echo 'ยังไม่ถึงคิวโพสถัดไป';				//exit;
		}
	}
	if($sendbl)
	{
		if(!$site=$db->GetAll('select c.id,c.title,c.link,c.pgroup,c.domain from product_category as c order by c.lastblog asc,c.id asc'))
		{
			$sendbl=false;
			echo 'คุณยังไม่ได้เพิ่มหมวดสินค้า';	
			exit;
		}
		$blog=$db->GetRow('select * from blog order by lastpost asc,id asc');
		$findcate=false;
		$lastd='';
		for($i=0;$i<count($site);$i++)
		{
			
			if($site[$i]['domain'])
			{
				$url='http://www.'.$site[$i]['domain'].QUERY;
			}
			elseif(lz::$c['sub']==2)
			{
				$url='http://'.$site[$i]['link'].'.'.lz::$cf['domain'].QUERY;
			}
			else
			{
				$url='http://www.'.lz::$cf['domain'].QUERY.$site[$i]['link'];
			}
			if($product=$db->GetRow('select p.asin,p.category,p.url as amazon,p.link,p.title,p.editor,p.feature,p.l,p.l2,p.brand,p.color from product as p where p.category=? and p.asin not in (select asin  from blog_post where category=? and blog=?) order by p.lastreview desc,p.tavg desc',array($site[$i]['id'],$site[$i]['id'],$blog['id'])))
			{
				echo '<h4>'.$site[$i]['id'].' - '.$site[$i]['title'].' - '.$url.'</h4>';
				$db->Execute('update blog set lastpost=now() where id=?',array($blog['id']));				
				$content=strip_tags($product['editor']).($product['brand']?", Brand ".$product['brand']:"").($product['color']?", Color ".$product['color'].", ":"").strip_tags($product['feature'])."\n";
				$review=$db->GetAll('select content from review where asin=? order by rand()',array($product['asin']));
				for($j=0;$j<count($review);$j++)
				{
					$content.=(($j?', ':'').$review[$j]['content']);
				}
				$db->Close();
				
				if(strlen(strip_tags($content))<500)
				{
					$art=@file_get_contents('http://www.articlesbase.com/find-articles.php?q='.urlencode($site[$i]['title']),null,stream_context_create(array('http'=>array('ignore_errors'=>true,'method'=>"GET",'header'=>"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13 GTB7.1 ( .NET CLR 3.5.30729)\r\nReferer: http://www.articlesbase.com/\r\n"))));
					require_once(HANDLERS.'simple_html_dom.php');
					$html=str_get_html($art);
					$c=$html->find('div.title h3 a');
					echo 'น้อยกว่า 500 ตัวอักษร <br>';
					if(count($c))
					{
						$rand=rand(0,count($c)-1);
						$content.="\n".$c[$rand]->innertext;
						echo 'สุ่ม article ได้หัวข้อ  '.$c[$rand]->innertext.' ที่ลิ้งค์ '.$c[$rand]->href.'<br>';
						$art=@file_get_contents($c[$rand]->href,null,stream_context_create(array('http'=>array('ignore_errors'=>true,'method'=>"GET",'header'=>"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13 GTB7.1 ( .NET CLR 3.5.30729)\r\nReferer: http://www.articlesbase.com/\r\n"))));
						$html=str_get_html($art);
						$c=$html->find('div.article_cnt',0);				
 						if(is_array($dh=$c->find('a')))
						{
							foreach($dh as $dh2)
							{
								$dh2->outertext=$dh2->innertext;
							}
						}
						$content.="\n".$c->innertext;
					}
				}
				
				if($site[$i]['domain'])
				{
					$purl='http://www.'.$site[$i]['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					if($product['l2'])$product['l']='http://www.'.$site[$i]['domain'].HTTP.'files/photo/'.$product['category'].'/l/'.$product['l2'];
				}
				elseif(lz::$c['sub']==2)
				{
					$purl='http://'.$site[$i]['link'].'.'.lz::$cf['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					if($product['l2'])$product['l']='http://'.$site[$i]['link'].'.'.lz::$cf['domain'].HTTP.'files/photo/'.$product['category'].'/l/'.$product['l2'];
				}
				elseif(lz::$c['sub']==1)
				{
					$purl='http://www.'.lz::$cf['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					if($product['l2'])$product['l']='http://www.'.lz::$cf['domain'].HTTP.'files/photo/'.$product['category'].'/l/'.$product['l2'];
				}
				else
				{
					$purl='http://www.'.lz::$cf['domain'].QUERY.$site[$i]['link'].'/'.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					if($product['l2'])$product['l']='http://www.'.lz::$cf['domain'].HTTP.'files/photo/'.$product['category'].'/l/'.$product['l2'];
				}
				$content=strip_tags($content);
				if(mb_strlen($content,'utf-8')>900)$content=mb_substr($content,0,900,'utf-8').'...';
				$content2=lz::h('rewrite')->gen(strip_tags($content));
				if(strlen($content2)>100)$content=$content2;
				
				
				
				$product['url']=$purl;
				$product['img']=$product['l'];
				$site[$i]['url']=$url;
				
				$template=lz::h('template');
				$template->assign('content',$content);
				$template->assign('product',$product);
				$template->assign('category',$site[$i]);
				$content=$template->fetch('cron.blacklink');
				
				//echo '<br><br>----------<br>'.$content;
				//exit;
				
				if(is_numeric($blog['blogid']))
				{
					$postid=lz::h('blogger')->post($blog['email'],$blog['password'],$blog['blogid'],$product['title'], $content);
				}
				else
				{
					$postid=wpp($blog['email'],$blog['password'],$blog['blogid'],$product['title'], $content,$site[$i]['pgroup'],implode(', ',explode(' ',$site[$i]['title'])));
					if($postid[0])
					{
						if(substr(trim($postid[1]),0,1)=='/')$postid[1]=$blog['blogid'].$postid[1];
						@file_get_contents($postid[1],null,stream_context_create(array('http'=>array('ignore_errors'=>true,'method'=>"GET",'header'=>"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13 GTB7.1 ( .NET CLR 3.5.30729)\r\n"))));
						$r=$http_response_header;
						for($j=0;$j<count($r);$j++)
						{
							if(substr(trim($r[$j]),0,9)=='Location:'&&strstr($postid[1],$blog['blogid']))
							{
								$postid[1]=substr(trim($r[$j]),10);
							}
						}
					}			
				}			
					
				if($postid[0])
				{
					echo 'ทำการโพสเรียบร้อยแล้ว <br>';
					echo 'หมายเลขโพสที่ '.$postid[0].'<br>';
					echo 'ลิ้งค์โพส  '.$postid[1].'<br>';
					$db->Execute('update product_category set lastblog=now(),countbl=countbl+1 where id=?',array($site[$i]['id']));
				}
				else
				{
					echo 'เกิดความผิดพลาดในการโพส<br>';
					$postid[1]=substr(strip_tags($postid[1]),0,100);
					echo 'ความผิดพลาด  '.$postid[1].'<br>';
					echo 'เนื้ิอหา  '.$content.'<br>';
				}
				$db->Execute('insert blog_post set blog=?,postid=?,posturl=?,asin=?,category=?,time=now()',array($blog['id'],$postid[0],$postid[1],$product['asin'],$site[$i]['id']));
				echo 'ที่บล็อก '.$blog['blogid'].' <br>';
				echo 'ชื่อสินค้า '.$product['title'].'<br>';
				echo 'คีย์เวิร์ด '.$site[$i]['title'].'<br>';
				echo '<br><br><br>'.$txt.'<br><br><br><br><br>';
				break;
			//	exit;
			}
			else
			{
				$db->Execute('update product_category set lastblog=now() where id=?',array($site[$i]['id']));
			}						
		}
	}
	else
	{
		$waitting=true;
	}
}


echo '<br>-------------------------------------------------------------------<br><br>';

if(intval(lz::$c['pgdelay'])>0)
{
	if($ctime=$db->GetRow('select pingo from product_category order by pingo desc'))
	{
		$diff=time()-strtotime($ctime['pingo']);
		if($diff>=(60 * lz::$c['pgdelay']))
		{
			if($site=$db->GetRow('select id,title,link from product_category order by pingo asc, id asc'))
			{
				$db->Execute('update product_category set pingo=now() where id=?',array($site['id']));
				if($product=$db->GetRow('select p.asin,p.title,p.link,c.link as clink from product as p left join product_category as c on p.category=c.id where (p.lastbot=? or to_days(now())-to_days(p.lastbot)>?) and p.category=? order by lastbot asc limit 0,1',array('0000-00-00 00:00:00',15,$site['id'])))
				{
					if($site[$i]['domain'])
					{
						$purl='http://www.'.$site[$i]['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
					elseif(lz::$c['sub']==2)
					{
						$purl='http://'.$site['link'].'.'.lz::$cf['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
					elseif(lz::$c['sub']==1)
					{
						$purl='http://www.'.lz::$cf['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
					else
					{
						$purl='http://www.'.lz::$cf['domain'].QUERY.$site['link'].'/'.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
					}
					$res=sendping($product['title'],$purl);
					$db->execute('update product set pingo=now() where asin=? and category=?',array($product['asin'],$site['id']));
					//exit;
				}
			}
		}
		else
		{
			$waitting=true;
		}
	}
}

echo '<br>-------------------------------------------------------------------<br><br>';

/*
if(intval(lz::$c['twdelay'])>0)
{
	$u=array_map('trim',explode(',',lz::$c['twuser']));
	$p=array_map('trim',explode(',',lz::$c['twpass']));
	if(count($u))
	{
		if(trim(lz::$c['twformat']))
		{
			if($ctime=$db->GetRow('select twitter from product_category order by twitter desc'))
			{
				$diff=time()-strtotime($ctime['twitter']);
				if($diff>=(60 * lz::$c['twdelay']))
				{
					if($site=$db->GetRow('select id,title,link from product_category order by twitter asc, id asc'))
					{
						
						$db->Execute('update product_category set twitter=now() where id=?',array($site['id']));
						if($product=$db->GetRow('select p.asin,p.title from product as p where p.category=? order by lasttwitter asc limit 0,1',array($site['id'])))
						{
							$url='http://www.'.lz::$cf['domain'].HTTP.$site['id'].'/'.$product['asin'];
							$message=str_replace('{link}',$url,lz::$c['twformat']);
							$len=140-mb_strlen($message,'utf-8')+mb_strlen('{message}','utf-8');
							if(mb_strlen($product['title'],'utf-8')>$len)
							{
								$message=str_replace('{message}',mb_substr($product['title'],0,$len-3,'utf-8').'...',$message);
							}
							else
							{
								$message=str_replace('{message}',$product['title'],$message);
							}
							$index=rand(1,count($u))-1;
							if($u[$index]&&$p[$index])
							{
								$curl_handle = curl_init();
								curl_setopt($curl_handle, CURLOPT_URL, 'http://twitter.com/statuses/update.xml');
								curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
								curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($curl_handle, CURLOPT_POST, 1);
								curl_setopt($curl_handle, CURLOPT_POSTFIELDS, 'status='.$message);
								curl_setopt($curl_handle, CURLOPT_USERPWD, $u[$index].':'.$p[$index]);
								$buffer = curl_exec($curl_handle);
								curl_close($curl_handle);
								if (empty($buffer)) {
								 echo ' username/password ไม่ถูกต้อง';
								} else {
								 echo 'ทำการโพสเข้าทวิสเตอร์เรียบร้อยแล้ว<br>user:'.$u[$index].'<br>pass:'.$p[$index].'<br>message:'.$message.'<br>'.$buffer;
								}
							}
							else
							{
								echo 'ไม่มีข้อมูล user/pass';
							}
						}
						else
						{
							echo 'ไม่มีข้อมูลสินค้า';
						}
						$db->execute('update product set lasttwitter=now() where asin=? and category=?',array($product['asin'],$site['id']));
						//exit;
					}
					else
					{
						echo 'ไม่มีข้อมูลคีย์เวิร์ด';
					}
				}
				else
				{
					echo 'ยังไม่ถึงเวลาในการโพส tw (2)';
				}
			}
			else
			{
				$waitting=true;
				echo 'ยังไม่ถึงเวลาในการโพส tw';
			}
		}
		else
		{
			echo 'ไม่มีชุดรูปแบบในการโพส';
		}
	}
	else
	{
		echo 'ชุดข้อมูล user/pass  ไม่ถูกต้อง';
	}
}
else
{
	echo 'ไม่ได้เปิดการทำงาน tw';
}


echo '<br>-------------------------------------------------------------------<br><br>';
*/


if($waitting)echo 'ยังไม่ถึงคิวโพสต่อไป';




















function wpp($a,$b,$c,$d,$e,$f='',$g='')
{		
	$d = htmlentities($d,ENT_NOQUOTES,'UTF-8');
	//$e = htmlentities($e,ENT_NOQUOTES,'UTF-8');
	$f = htmlentities($f,ENT_NOQUOTES,'UTF-8');
	if(substr($c,0,4)!='http')$c='http://'.$c;
	if(substr($c,-1)!='/')$c.='/';		
	
	$content = array(
		'title'=>$d,
		'description'=>$e,
		'mt_allow_comments'=>0,  // 1 pour autoriser les commentaires
		'mt_allow_pings'=>1,  // 1 pour autoriser les trackbacks
		'post_type'=>'post',
		'mt_keywords'=>$g,
		'categories'=>array($f)
	);
	$params = array(0,$a,$b,$content,true);
	$request = xmlrpc_encode_request('metaWeblog.newPost',$params);
	$context = stream_context_create(array('http' => array('ignore_errors'=>true,'method' => "POST",'header' => "Content-Type: text/xml\r\nUser-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13 GTB7.1 ( .NET CLR 3.5.30729)\r\n",'content' => $request)));
	$ee = @file_get_contents($c.'xmlrpc.php', false, $context);
	$pid=intval(trim(strip_tags($ee)));
	$purl=($pid>0?$c.'?p='.$pid:$ee);
	return array($pid,$purl);
}



function sendping($title,$url)
{	

		$url = 'http://pingomatic.com/ping/?title='.urlencode($title).'&blogurl='.urlencode($url).'&rssurl='.urlencode('http://').'&chk_weblogscom=on&chk_blogs=on&chk_feedburner=on&chk_syndic8=on&chk_newsgator=on&chk_myyahoo=on&chk_pubsubcom=on&chk_blogdigger=on&chk_blogstreet=on&chk_moreover=on&chk_weblogalot=on&chk_icerocket=on&chk_newsisfree=on&chk_topicexchange=on&chk_google=on&chk_tailrank=on&chk_postrank=on&chk_skygrid=on&chk_collecta=on&chk_superfeedr=on&chk_audioweblogs=on&chk_rubhub=on&chk_geourl=on&chk_a2b=on&chk_blogshares=on';
		$ee = @file_get_contents($url,null,stream_context_create(array('http'=>array('ignore_errors'=>true,'method'=>"GET",'header'=>"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13 GTB7.1 ( .NET CLR 3.5.30729)\r\nReferer: http://pingomatic.com/\r\n"))));
		$j='<table class="resultstable" cellpadding="0" cellspacing="0">';
		$i=strpos($ee,$j);
		if($i>0)
		{
			$ee=substr($ee,$i);
			$j='</table>';
			$i=strpos($ee,$j);
			if($i>0)$ee=substr($ee,0,$i).$j;
			
		}
		echo '<h5>ping '.$url.'</h5>';
		//echo '<h3>'.$url.'</h3>';
		//echo $ee;
}
exit;


?>