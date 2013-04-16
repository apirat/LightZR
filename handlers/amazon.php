<?php
class amazon
{
	public $searchindex=array('All','Apparel','Automotive','Baby','Beauty','Blended','Books','Classical','DVD','DigitalMusic','Electronics','GourmetFood','Grocery','HealthPersonalCare','HomeGarden','Industrial','Jewelry','KindleStore','Kitchen','MP3Downloads','Magazines','Merchants','Miscellaneous','Music','MusicTracks','MusicalInstruments','OfficeProducts','OutdoorLiving','PCHardware','PetSupplies','Photo','Shoes','SilverMerchants','Software','SportingGoods','Tools','Toys','UnboxVideo','VHS','Video','VideoGames','Watches','Wireless','WirelessAccessories');
	public $reviewsort=array('SubmissionDate'=>'ใหม่ไปเก่า','-SubmissionDate'=>'เก่าไปใหม่','Rank'=>'Rankมากสุด','-Rank'=>'Rankน้อยสุด');
	//SubmissionDate
	function search($index,$keyword,$page=1,$db=false,$category=0,$group=false,$intitle=false,$outtitle=false,$inalltitle=false,$onlymanu=false,$sort='SubmissionDate',$node=false,$rate=0,$awstag='')
	{
		if(!$sort||!array_key_exists($sort,$this->reviewsort))$sort='SubmissionDate';
		$params=array();
		$params['Condition']='All';
		$params['MerchantId']='All';
		$params['Operation']='ItemSearch';
		$params['ReviewSort']=$sort;
		$params['SearchIndex']=$index;
		$params['Keywords']=$keyword;
		$params['ItemPage']=$page;
		if($node)$params['BrowseNode']=$node;
		$data = lz::h('xml')->process($this->request($params,$awstag));
		$array = $data['Items'];
		//print_r($array);
		//exit;
		if($array['Item']['ItemAttributes']['Title'])
		{
			$array['Item']=array($array['Item']);
		}
		if($category&&$array['Item'][0])
		{
			for($i=0;$i<count($array['Item']);$i++)
			{
				if(($title=strtolower($array['Item'][$i]['ItemAttributes']['Title']))&&($array['Item'][$i]['SmallImage']['URL']&&$array['Item'][$i]['MediumImage']['URL']&&$array['Item'][$i]['LargeImage']['URL']))
				{
					if(!$group||in_array(strtolower($array['Item'][$i]['ItemAttributes']['ProductGroup']),$group))
					{
						if($intitle)
						{
							$cont=true;
							for($j=0;$j<count($intitle);$j++)
							{
								if(strpos($title,$intitle[$j])>-1)
								{
										$cont=false;
										break;
								}
							}
							if($cont)continue;
						}
						if($inalltitle)
						{
							$cont=false;
							for($j=0;$j<count($inalltitle);$j++)
							{
								if(strpos($title,$inalltitle[$j])===false)
								{
										$cont=true;
										break;
								}
							}
							if($cont)continue;
						}
						if($outtitle)
						{
							$cont=false;
							for($j=0;$j<count($outtitle);$j++)
							{
								if(strpos($title,$outtitle[$j])>-1)
								{
										$cont=true;
										break;
								}
							}
							if($cont)continue;
						}
						if($onlymanu)
						{
							$manu=trim(strtolower($array['Item'][$i]['ItemAttributes']['Manufacturer']));
							$cont=true;
							for($j=0;$j<count($onlymanu);$j++)
							{
								if($manu==$onlymanu[$j])
								{
										$cont=false;
										break;
								}
							}
							if($cont)
							{
								continue;
							}
						}
						$array['Item'][$i]['onlybinding']=$this->assigndb($array['Item'][$i],$category,$db);
					}
				}
			}
		}
		return $array;
	}
	function delete($asin,$category)
	{
		$db=lz::h('db');
		if($count=$db->GetOne('select count(*) from product where asin=? ',array($asin)))
		{
			if($count<2)
			{
				//$db->Execute('delete from image where asin=?',array($asin));
				$db->Execute('delete from review where asin=?',array($asin));
				//$db->Execute('delete from offer where asin=?',array($asin));
			}
			$product=$db->GetRow('select s2,m2,l2 from product where asin=? and category=?',array($asin,$category));
			if($product['s2']&&file_exists($s=FILES.'photo/'.$category.'/s/'.$product['s2']))@unlink($s);
			if($product['m2']&&file_exists($m=FILES.'photo/'.$category.'/m/'.$product['m2']))@unlink($m);
			if($product['l2']&&file_exists($l=FILES.'photo/'.$category.'/l/'.$product['l2']))@unlink($l);
			$db->Execute('delete from product where asin=? and category=?',array($asin,$category));
		}
	}
	function product($asin,$category,$awstag='')
	{
		$params=array();
		$params['MerchantId']='All';
		$params['Condition']='All';
		$params['Operation']='ItemLookup';
		$params['ItemId']=$asin;
		
		$data = $this->request($params,$awstag);
		//lz::h('ajax')->assign('footer','innerHTML',$data);
		//return;
		
		$data = lz::h('xml')->process($data);
		//$array = $data['ItemLookupResponse']['Items']['Item'];
		$array = $data['Items']['Item'];
		unset($data);
		if($array['ItemAttributes']['Title'])
		{
			if($a=$this->assigndb($array,$category,true))
			{
				$this->getavg($array['ASIN'],$category);
			}
			return $a;			
   		}
		return false;
   	}
	
   	function assigndb($array,$category,$todb)
	{
		if($array['ASIN']&&$array['SmallImage']['URL']&&$array['MediumImage']['URL']&&$array['LargeImage']['URL'])
		{
			$db=lz::h('db');
			$res=array();
			$res['category']=$category;
			$res['asin']=$array['ASIN'];
			$res['url']=$array['DetailPageURL'];
			$res['title']=strip_tags($array['ItemAttributes']['Title']);
			if(intval(lz::$c['linkword'])<1)lz::$c['linkword']=99;
			$res['link']=implode('-',array_slice(explode('-',lz::h('format')->link($res['title'],false)),0,lz::$c['linkword'])).'-'.strtolower($res['asin']);
			
			$res['brand']=$array['ItemAttributes']['Brand'];
			$res['color']=$array['ItemAttributes']['Color'];
			if(is_array($res['feature']=$array['ItemAttributes']['Feature']))
			{
				shuffle($res['feature']);
				$res['feature']='<li>'.implode('</li><li>',$res['feature']).'</li>';
			}
			$res['salesrank']=$array['SalesRank'];
			if($array['EditorialReviews']['EditorialReview'][0])
			{
				$res['editor']=$array['EditorialReviews']['EditorialReview'][0]['Content'];
			} 
			else
			{
				$res['editor']=$array['EditorialReviews']['EditorialReview']['Content'];
			}
			
			$res['price']=intval($array['ItemAttributes']['ListPrice']['Amount']);
		    $res['pricef']=$array['ItemAttributes']['ListPrice']['FormattedPrice'];
		    $res['saleprice']=intval($array['OfferSummary']['LowestNewPrice']['Amount']);	
		    $res['salepricef']=$array['OfferSummary']['LowestNewPrice']['FormattedPrice'];			
		    $res['minvar']=intval($array['VariationSummary']['LowestPrice']['Amount']);	
		    $res['minvarf']=$array['VariationSummary']['LowestPrice']['FormattedPrice'];
		    $res['maxvar']=intval($array['VariationSummary']['HighestPrice']['Amount']);
		    $res['maxvarf']=$array['VariationSummary']['HighestPrice']['FormattedPrice'];
			
			if(!$res['price'])
			{
				$res['price']=$res['saleprice'];
				$res['pricef']=$res['salepricef'];
			}
			if(!$res['saleprice'])
			{
				$res['saleprice']=$res['price'];
				$res['salepricef']=$res['pricef'];
			}
			if(!$res['price'])
			{
				$res['price']=$res['minvar'];
				$res['pricef']=$res['minvarf'];
			}
			if(!$res['saleprice'])
			{
				$res['saleprice']=$res['minvar'];
				$res['salepricef']=$res['minvarf'];
			}
			
			if(!$res['price'])return false;
			if(!$todb)return $array['ASIN'];
			
			
			if($ttoffer=$array['Offers']['TotalOffers']) 
			{
				$res['seller']=$ttoffer;
				if($ttoffer>1)
				{
					$alloffer=$array['Offers']['Offer'];
				}
				else
				{
					$alloffer=array($array['Offers']['Offer']);
				}
				$res['offer']=array();
				$res['maxprice']=0;
				$res['minprice']=0;
				if(is_array($alloffer))
				{
					foreach($alloffer as $offer) 
					{
						
						$price=$offer['OfferListing']['Price']['Amount'];
						$pricef=$offer['OfferListing']['Price']['FormattedPrice'];
						if($saleprice=$offer['OfferListing']['SalePrice']['Amount'])
						{
							$salepricef=$offer['OfferListing']['SalePrice']['FormattedPrice'];
						}
						else
						{
							$saleprice=$price;
							$salepricef=$pricef;
							$price=$res['price'];
							$pricef=$res['pricef'];
						}
						if(!$price)
						{
							$price=$res['price'];
							$pricef=$res['pricef'];
						}
						if(!$saleprice)
						{
							$saleprice=$res['saleprice'];
							$salepricef=$res['salepricef'];
						}
						if(($saleprice<$res['minprice']&&$saleprice!=0)||$res['minprice']==0)
						{
							$res['minprice']=$saleprice;
							$res['minpricef']=$salepricef;
						}
						if(($saleprice>$res['maxprice'])||$res['maxprice']==0)
						{
							$res['maxprice']=$saleprice;
							$res['maxpricef']=$salepricef;
						}
						$res['offer'][]=array(
									  'name'=>$offer['Merchant']['Name'],
									  'rating'=>$offer['Merchant']['AverageFeedbackRating'],									  
									  'cond'=>$offer['OfferAttributes']['Condition'],
									  'condnote'=>$offer['OfferAttributes']['ConditionNote'],									  
									  'listing'=>$offer['OfferListing']['OfferListingId'],
									  'exchange'=>$offer['OfferListing']['ExchangeId'],									  
									  'price'=>$price,												  								  
									  'pricef'=>$pricef,												  
									  'saleprice'=>$saleprice,			  
									  'salepricef'=>$salepricef,
									  'ava'=>$offer['OfferListing']['Availability'],	
									  'supersave'=>$offer['OfferListing']['IsEligibleForSuperSaverShipping'],	
									  );
					}
				}
				shuffle($res['offer']);
				$res['bestoffer']=$res['offer'];
				$bo=array();
				for($i=0;$i<count($res['bestoffer'])&&$i<3;$i++)
				{
					$of=intval($res['bestoffer'][$i]['saleprice']/100);
					if($of>0)$bo[$res['bestoffer'][$i]['name']]=number_format($of,0);
				}
				$res['bestoffer']=serialize($bo);
				$res['offer']=serialize($res['offer']);	
			}
			
			
			$res['s']=$array['SmallImage']['URL'];
			$res['m']=$array['MediumImage']['URL'];
			$res['l']=$array['LargeImage']['URL'];
			
			if(lz::$c['image']=='2')
			{
				$cate=$db->getrow('select id,link from product_category where id=?',array($category));
				$res['m2']=lz::h('photo')->copy($cate['link'].'-'.strtolower($array['ASIN']),trim($res['m']),'photo/'.$category.'/m');
				$res['l2']=lz::h('photo')->copy($cate['link'].'-'.strtolower($array['ASIN']),trim($res['l']),'photo/'.$category.'/l');
				if($res['m2']||$res['l2'])$db->Execute('update product set m2=?,l2=? where asin=? and category=?',array($res['m2'],$res['l2'],$array['ASIN'],$category));
			}
			elseif(lz::$c['image']=='1')
			{
				$cate=$db->getrow('select id,link from product_category where id=?',array($category));
				$res['s2']=lz::h('photo')->copy($cate['link'].'-'.strtolower($array['ASIN']),trim($res['s']),'photo/'.$category.'/s');
				$res['l2']=lz::h('photo')->copy($cate['link'].'-'.strtolower($array['ASIN']),trim($res['l']),'photo/'.$category.'/l');
				if($res['s2']||$res['l2'])$db->Execute('update product set s2=?,l2=? where asin=? and category=?',array($res['s2'],$res['l2'],$array['ASIN'],$category));
			}
			
			$k=array();
			$v=array();
			foreach($res as $key=>$val)
			{
				if(!in_array($key,array('category','asin')))
				{
					$k[]=$key.'=?';
					$v[]=(is_null($val)?"":$val);
				}
			}
			$v[]=$res['asin'];
			$v[]=$res['category'];
			if($ch=$db->GetRow('select  * from product where asin=? and category=?',array($res['asin'],$res['category'])))
			{
				$db->Execute("update product set ".join(',',$k).",lastupdate=now() where asin=? and category=?",$v);
			}
			else
			{
				$db->Execute("insert product set ".join(',',$k).",added=now(),lastupdate=now(),asin=?,category=?",$v);
			}
			return $array['ASIN'];
		}
		return false;
	}
   
	function request($params,$awstag='') 
	{
		$params["Service"] = "AWSECommerceService"; 
		$params["AWSAccessKeyId"] = lz::$c['awskey']; 
		$params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z", time() + 10000); 
		$params["Version"] = "2011-08-01"; 
		$params["MinimumPrice"] = "1"; 
		//$params['ResponseGroup']='Large,VariationSummary';
		$params['ResponseGroup']='Medium,OfferFull,OfferSummary,VariationSummary';
		//$params['ResponseGroup']='Large,VariationSummary';
		$params['AssociateTag']=($awstag?$awstag : lz::$c['awstag']);
		ksort($params); 
		$canonicalized_query = array(); 
		foreach ($params as $param=>$value) 
		{ 
			$param = str_replace("%7E", "~", rawurlencode($param)); 
			$value = str_replace("%7E", "~", rawurlencode($value)); 
			$canonicalized_query[] = $param."=".$value; 
		} 
		
		$canonicalized_query = implode("&", $canonicalized_query); 
		$string_to_sign = "GET\nwebservices.amazonaws.".lz::$c['zone']."\n/onca/xml\n".$canonicalized_query; 
		$signature=base64_encode(hash_hmac("sha256", $string_to_sign, lz::$c['awssecret'], True));		
		$signature = str_replace("%7E", "~", rawurlencode($signature)); 		
		$request = "http://webservices.amazonaws.".lz::$c['zone']."/onca/xml?".$canonicalized_query."&Signature=".$signature; 
		$context = stream_context_create(array('http' => array('ignore_errors'=>true,'timeout' => 1)));
		return @file_get_contents($request,0,$context);
	} 
	
	
	function getavg($asin,$category,$lang=false)
	{
		#------------------------------------------------------------------------  Start - Rating & Review ---------------------------------------------------------------#
		$db=lz::h('db');
		list($avg,$tavg,$review)=$this->getreview($asin,$lang);
		if($avg=='0.0')$avg='';
		if($avg||$tavg||$review)
		{
			if($avg&&!$tavg&&count($review))
			{
				$tavg=count($review);					
			}
			if($avg&&$tavg&&$review)
			{
				$order=0;
				foreach($review as $index)
				{
					if($index['rating']&&$index['customerid']&&$index['name']&&$index['date']&&$index['content'])
					{
						$k=array('dorder=?','category=?');
						$v=array($order,$category);
						foreach($index as $key=>$val)
						{
							$k[]=$key.'=?';
							$v[]=(is_null($val)?"":$val);
						}
						$db->Execute("replace review set ".join(',',$k),$v);
						$order++;
					}
					elseif($index['rating']&&$index['date']&&$index['content'])
					{
						
					}
					else
					{
						$txt = '<h1>Error Review</h1>';
						$txt.= '<pre>';
						$txt.=print_r($index,true);
						$txt.= '</pre>';
						//return array($txt);
					}
				}
				$db->Execute('update product set avg=?,tavg=?,lastreview=now() where asin=?',array($avg,$tavg,$asin));
				return array(false,$avg,$tavg);
			}
			else
			{
				$txt='<h1>Error Rating</h1>';
				$txt.='<h3>ASIN: '.$asin.'</h3>';
				$txt.= '<h3>AVG: '.$avg.'</h3>';
				$txt.= '<h3>TAVG: '.$tavg.'</h3>';
				$txt.= '<h3>review</h3>';
				$txt.= '<pre>';
				$txt.=print_r($review,true);
				$txt.= '</pre>';
				//return array($txt);
				$db->Execute('update product set lastreview=now() where asin=?',array($asin));
				return array(false,0,0);
			}				
		}
		else
		{
			$db->Execute('update product set lastreview=now() where asin=?',array($asin));
			return array(false,0,0);
		}
		#------------------------------------------------------------------  End - Rating & Review ---------------------------------------------------------------#
		
	}
	
	function getreview($asin,$lang=false)
	{
		lz::h('db')->close();
		$art=@file_get_contents('http://www.amazon.'.lz::$c['zone'].'/product-reviews/'.strtoupper($asin),null,stream_context_create(array('http'=>array('ignore_errors'=>true,'method'=>"GET",
		'header'=>"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Charset:UTF-8,*;q=0.5
Accept-Language:en-US,en;q=0.8
Cache-Control:max-age=0
Connection:keep-alive
Host:www.amazon.com
User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_2) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.202 Safari/535.1
Referer: http://www.amazon.com/
"))));
		require_once(dirname(__FILE__).'/simple_html_dom.php');
		$html=str_get_html($art);
		if($c=$html->find('.swSprite',0))
		{
			//$c=$c->parent;
			$avg=false;
			$tavg=false;
			$review=false;
			if(preg_match('/s\_star\_([0-9]+)\_([0-9]+)/',$c->class,$d1))
			{
				$avg=$d1[1].'.'.$d1[2];
			}
			//echo $avg;
			
			$c=$c->parent;
			if(!$c=$html->find('.crAvgStars',0))
			{
				$c=$html->find('.swSprite',0);
				$c=$c->parent;
				if(preg_match('/([0-9,]+) customer review/',$c->find('a',0)->innertext,$d1))
				{
					$tavg=$d1[1];
				}	
			}
			else
			{
				if(preg_match('/([0-9,]+) customer review/',$c->find('a',1)->innertext,$d1))
				{
					$tavg=$d1[1];
				}	
			}
		
			$c=$html->find('#productReviews',0);
			if($c)
			{
				$review=array();	
				$html=explode('<!-- BOUNDARY -->',$c->innertext);
				for($i=1;$i<=count($html);$i++)
				{
					if(!trim($html[$i]))continue;
					$c=str_get_html($html[$i]);
					if($d=$c->find('div',0))
					{
				//echo 'sss';
						$e=$d->find('div');
						if(strpos($e[0]->innertext,'The manufacturer commented on the review below')>-1)
						{
							$start=2;	
						}
						elseif(strpos($e[0]->innertext,'people found the following review helpful')>-1)
						{
							$start=1;	
						}
						else
						{
							$start=0;	
						}
						$l2=trim(strip_tags($e[$start]->find('span',0)->innertext));
						preg_match('/^(.+) out of 5 stars/',$l2,$q);
						$l2=trim(strip_tags($e[$start]->find('b',0)->innertext));
						$t=trim(strip_tags($e[$start]->find('nobr',0)->innertext));
						$l3=$e[$start+1]->find('a',0)->href;
						preg_match('/http\:\/\/www\.amazon\.'.lz::$c['zone'].'\/gp\/pdp\/profile\/(\w+)\//',$l3,$w);
						$l4=strip_tags($e[$start+1]->find('a',0)->innertext);
						for($j=0;$j<count($e);$j++)
						{
							$e[$j]->outertext='';
						}
						$txt=trim(strip_tags($d->innertext)); 
						if(intval($q[1])>=3)
						{
							$review[]=array(
								  'asin'=>$asin,
								  'rating'=>intval($q[1]),
								  'customerid'=>$w[1],
								  'name'=>$l4,
								  'date'=>date('Y-m-d',strtotime($t)),
								  'summary'=>$l2,
								  'content'=>nl2br($txt)
								  );
						}
					}
				}			
				shuffle($review);
				$review=array_slice($review,0,3);
				if($lang)
				{
					$rv=array();
					for($k=0;$k<count($review);$k++)
					{
						$rv[]=strip_tags($review[$k]['content']);
					}
					
					if(count($rv))
					{
						$tmp='';
						if(lz::h('spinner')->connect())
						{
							$tmp=lz::h('spinner')->rewrite(implode("\n\n #% \n\n",$rv));
						}
						if(!$tmp && $lang)
						{
							$tmp=lz::h('rewrite')->gen(implode("\r\n\r\n #% \r\n\r\n",$rv),$lang);
						}
						$rv=array();
						if(strpos($tmp,'#%')>-1)
						{
							$rv=explode('#%',$tmp);
						}
						elseif(strpos($tmp,'# %')>-1)
						{
							$rv=explode('# %',$tmp);
						}
						
						for($k=0;$k<count($review);$k++)
						{
							if($rv[$k])$review[$k]['content']=$rv[$k];
						}
					}
				}
			}				
			return array($avg,$tavg,$review);
		}
	}
}
?>