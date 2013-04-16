<?php
class product
{
	public $rs=array();
	public $cr=0;
	public $count=0;
	public $pager;
	public $string;
	public $where;
	public $val;
	public $orderby;
	public $url;
	public $iurl;
	public $page;
	public $limit;
	public $length=150;
	public $type='';
	public $sql;
	public function __construct()
	{
		$this->sql="p.asin,p.link,p.url,p.title,p.category,p.avg,p.tavg,p.color,p.brand,p.minprice,p.minpricef,p.maxprice,p.maxpricef,p.price,p.pricef,p.saleprice,p.salepricef,p.minvar,p.minvarf,p.maxvar,p.maxvarf,
		".(lz::$c['antiindex']==3?"p.lastrewrite as lastbot":"p.lastbot").",
		if(p.m2!='',concat('".HTTP."files/photo/',p.category,'/m/',p.m2),p.m) as m,if(p.s2!='',concat('".HTTP."files/photo/',p.category,'/s/',p.s2),p.s) as s,
		p.feature,p.seller,p.bestoffer,if(p.content!='',p.content,p.editor) as editor,c.title as ctitle,c.link as clink,c.domain from product as p left join product_category as c on p.category=c.id ";
	}
	
	function set($arg)
	{
		$this->type=strval($arg['type']);
		$this->where=strval($arg['where']);
		$this->val=$arg['val'];
		$this->url=strval($arg['url']);
		$this->iurl=strval($arg['iurl']);
		$this->page=intval($arg['page']);
		$this->orderby=strval($arg['orderby']);
		$this->limit=intval($arg['limit']);
	}
	function get($arg=array())
	{
		if(isset($arg['where']))$this->where=$arg['where'];
		if(isset($arg['val']))$this->val=$arg['val'];
		if(isset($arg['url']))$this->url=$arg['url'];
		if(isset($arg['iurl']))$this->iurl=$arg['iurl'];
		if(isset($arg['page']))$this->page=$arg['page'];
		if(isset($arg['orderby']))$this->orderby=$arg['orderby'];
		if(isset($arg['limit']))$this->limit=$arg['limit'];
		if(isset($arg['length']))$this->length=$arg['length'];
		$this->cr=-1;
		$this->rs=array();
		if($this->type=='home')
		{
			if(!$this->limit)$this->limit=12;
			if(!is_numeric(lz::$c['homestar']))lz::$c['homestar']=4;
			if(!is_numeric(lz::$c['homeprice']))lz::$c['homeprice']=100;
			$this->rs=lz::h('db')->getall("select ".$this->sql." where p.avg>=? and p.price>? order by rand() limit 0,".$this->limit,array(lz::$c['homestar'],lz::$c['homeprice']*100));
			$this->count=count($this->rs);
		}
		elseif($this->type=='recent')
		{
			if(!$this->limit)$this->limit=6;
			$this->rs=lz::h('db')->getall("select ".$this->sql." ".(SERVICE_FOLDER=='home'||!isset(lz::$s['id'])?"":" where p.category='".lz::$s['id']."' ")." order by p.lastupdate desc limit 0,".$this->limit);
			$this->count=count($this->rs);
		}
		elseif($this->type=='recommend')
		{
			if(!$this->limit)$this->limit=12;
			$this->rs=lz::h('db')->getall("select ".$this->sql." ".(SERVICE_FOLDER=='home'||!isset(lz::$s['id'])?"":" where p.category='".lz::$s['id']."' ")." order by p.avg desc limit 0,".$this->limit);
			$this->count=count($this->rs);
		}
		elseif($this->type=='relate')
		{
			if(!$this->limit)$this->limit=6;
			if(lz::$c['antiindex']==3)define('ANTIINDEX',true);
			$this->rs=lz::h('db')->GetAll("select ".$this->sql." where p.asin>? and p.category=? order by p.asin limit 0,".$this->limit,$this->val);
			if(count($tthis->rs)<$this->limit)
			{
				$other=lz::h('db')->GetAll("select ".$this->sql." where p.asin<?php and p.category=? order by p.asin limit 0,".$this->limit,$this->val);
				if(is_array($this->rs)&&is_array($other))
				{
					$this->rs=array_merge($this->rs,$other);
				}
				elseif(is_array($other))
				{
					$this->rs=$other;
				}
			}
			$this->count=count($this->rs);
		}
		else
		{
			if($this->count=lz::h('db')->getone("select count(p.asin) from product as p ".$this->where,$this->val))
			{
				if(!$this->limit)$this->limit=24;
				list($this->pager,$limit)=lz::h('pager')->page($this->limit,$this->count,$this->url,($this->iurl?'-':'/').'page-',$this->page);
				$this->rs=lz::h('db')->GetAll("select ".$this->sql." ".$this->where." ".$this->orderby." ".$limit,$this->val);
			}
		}
	}
	public function fetch()
	{
		$this->cr++;
		if($this->cr >= count($this->rs))return false;
		$n=$this->rs[$this->cr];
		$n['i']=$this->cr;
		$n['amz']=$n['url'];
		$n['count']=count($this->rs);
		
		if(SERVICE_FOLDER=='home')
		{
			if($n['domain'])
			{
				$n['url']='http://www.'.$n['domain'].QUERY.$n['link'].'/';
			}
			elseif(lz::$c['sub']==2)
			{
				$n['url']='http://'.$n['clink'].'.'.lz::$cf['domain'].QUERY.$n['link'].'/';
			}
			elseif(lz::$c['sub']==1)
			{
				$n['url']=QUERY.$n['link'].'/';
			}
			else
			{
				$n['url']=QUERY.$n['clink'].'/'.$n['link'].'/';
			}
		}
		else
		{
			if(lz::$c['sub']==2||lz::$c['sub']==1||lz::$s['domain'])
			{
				$n['url']=QUERY.$n['link'].'/';
			}
			else
			{
				$n['url']=QUERY.lz::$s['link'].'/'.$n['link'].'/';
			}
		}
		$title=htmlspecialchars($n['title']);
		$n['a']=array(
									'title'=>'title="'.$title.'"',
									'url'=>array(
													'info'=>$n['url'].lz::$c['pinfo'],
													'compare'=>'http://www.amazon.'.lz::$c['zone'].'/gp/offer-listing/'.$asin.'/?tag='.lz::$c['awstag'],
													'store'=>($n['amz']?$n['amz']:'http://www.amazon.'.lz::$c['zone'].'/gp/product/'.$asin.'/?tag='.lz::$c['awstag']),
													'review'=>'http://www.amazon.'.lz::$c['zone'].'/review/product/'.$asin.'/?tag='.lz::$c['awstag'],
									),
									'rel'=>($n['lastbot']=='0000-00-00 00:00:00'&&lz::$c['antiindex']?'rel="noreferrer nofollow"':'')
								);
		$n['a']['href']=array(
											'info'=>'href="'.$n['a']['url']['info'].'"',
											'compare'=>'href="'.$n['a']['url']['compare'].'"',
											'store'=>'href="'.$n['a']['url']['store'].'"',
											'review'=>'href="'.$n['a']['url']['review'].'"',
											);
		$n['img']=array(
									's'=>($n['s']?$n['s']:HTTP.'themes/'.lz::$c['theme'].'/images/noimg.s.gif'),
									'm'=>($n['m']?$n['m']:HTTP.'themes/'.lz::$c['theme'].'/images/noimg.m.gif'),
									'title'=>$n['a']['title'],
									'alt'=>'alt="'.$title.'"',
								);
		
		$n['img']['src']=array(
														's'=>'src="'.$n['img']['s'].'"',
														'm'=>'src="'.$n['img']['m'].'"',
													);
				
		$n['content']=strip_tags($n['editor']);
		$n['content']=mb_strlen($n['content'],'utf-8')>$this->length?mb_substr($n['content'],0,$this->length,'utf-8').'...':$n['content'];
		
		$n['category']=lz::$s['title'];
		
		$n['offer']=unserialize($n['bestoffer']);
		$n['asin']=strtolower($n['asin']);
		return $n;
	}
}
?>