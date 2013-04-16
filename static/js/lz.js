

var lz={
	version:'3.0.0',http:'',
	init:function()
	{
		lz.http=$('script[src$="lz.js"]').attr('src');
		lz.http=lz.http.substring(0,lz.http.lastIndexOf('js/lz.js'));
		window.tinyMCEPreInit = {suffix:'',base:lz.http+'js/tiny_mce'};
	},
	box:{
		opened:false,onopen:'',onclose:'',
		init:function(){if($('#gbox').length==0){var g=$('<div>').attr({id:'gbox'}),a=$('<div>').attr({id:'gboxa'}),b=$('<div>').attr({id:'gboxb'}),c=$('<div>').attr({id:'gboxc'});$('body').prepend($(g).append($(a)).append($(b).append($(c))));};if(!$('#loading')[0]){$('body').prepend($('<div>').attr({id:'loading'}));};},
		open:function()
		{
			$('#gbox').remove();
			lz.box.init();
			$(arguments[0]).addClass('setview');
			this.width=$(arguments[0]).width()+20;
			this.height=$(arguments[0]).height()+20;
			$('#gboxa').css({opacity:0.5});
			$('#gbox').show();
			lz.box.update();
			$('#gboxc').html('<img src="'+lz.http+'images/close.gif" style="position:absolute;top:10px;right:10px;cursor:pointer" onclick="javascript:lz.box.close()">'+$(arguments[0]).html().replace(/_tmp_/gi,'_box_'));
			lz.box.onopen=$(arguments[0]).attr('onopen');
			lz.box.onclose=$(arguments[0]).attr('onclose');
			if(arguments.length>1)
			{
				$('#gboxb').css({width:lz.box.width,height:lz.box.height});
				if(lz.box.onopen)eval(lz.box.onopen);
			}
			else
			{
				$('#gboxb').css({width:lz.box.width,height:0});
				$('#gboxb').animate({height: lz.box.height},2000,'easeOutBounce',function(){
					if(lz.box.onopen)eval(lz.box.onopen);
				});
			}
		},
		close:function()
		{
			if(arguments.length>1)
			{
				$('#gbox').remove();
				lz.box.opened=false;
				if(arguments[0])lz.box.open(arguments[0]);
			}
			else
			{
				$('#gboxb').animate({height:0},2000,'easeOutBounce',function(){
					$('#gbox').remove();
					lz.box.opened=false;
					if(arguments[0])lz.box.open(arguments[0]);
				});
			}
		},
		update:function()
		{
			if(!$('#gbox')[0])return;
			if($('#gbox').css('display')!='none')
			{
				$('#gbox').css({top:$(document).scrollTop(),left:$(document).scrollLeft(),height:$(window).height()});
				$('#gboxa').css({height:$(window).height()});
				$('#gboxb').css({top:(($(window).height()-lz.box.height)/2),left:(($(window).width()-lz.box.width)/2)});
			};
			if($('#loading').css('display')=='block')
			{
				$('#loading').css({top:($(document).scrollTop()+(($(window).height()-$('#loading').height())/2)),left:($(document).scrollLeft()+(($(window).width()-$('#loading').width())/2))});
			}
		},	
		alert:function(s){lz.box.init();clearTimeout(lz.box.timer);$('#loading').css({display:'block',opacity:0}).html('<div><a href="javascript:;" onclick="lz.box.hide()" class="loading_close"><img src="'+lz.http+'images/close.gif"></a><span>'+s+'</span></div>').fadeTo("slow",1);lz.box.update();lz.box.timer=setTimeout('lz.box.hide()',arguments.length>1?arguments[1]:5000)},
		hide:function(){$('#loading').fadeOut('slow')},
	},
	ajax:{
		init:function(){if(!$('#ajax_load')[0]){$('body').prepend($('<img>').attr({id:'ajax_load',src:lz.http+'images/load.gif'}).css({'position':'absolute','z-index':999,'top':0,'left':0,'display':'none'}));}},
		gourl:function(a,s){var arg=new Array(),i;for(i=2;i<arguments.length;i++)arg[i-2]=arguments[i];this.go(s,arg,'',a);},
		getForm:function(s){if($(s)[0].nodeName=='FORM'){var o={};var a=$(s).serializeArray();$.each(a,function(){if(o[this.name]){if (!o[this.name].push){o[this.name]=[o[this.name]];};o[this.name].push(this.value||'');}else{o[this.name]=this.value||'';}});return o;};return s},
		go:function(f,p){lz.ajax.init();$('#ajax_load').css({display:'inline'});if(arguments.length>2){var loader= 'loading_'+arguments[2];if((targetObj=document.getElementById(arguments[2]))&&!document.getElementById(loader)){targetObj.style.position='relative';$('<div id="'+loader+'"></div>').css({left:0,top:0,padding:0,width:'100%',height:'100%',background:'#000000',zIndex:1000,opacity:0.5,position:'absolute'}).html('<table width="100%" height="100%"><tr><td align="right" height="16" valign="top"><img src="'+lz.http+'images/close.gif" style="cursor:pointer" border="0" alt="close" onclick="lz.ajax.remove(\''+loader+'\');"></td></tr><tr><td align="center" valign="middle"><img src="'+lz.http+'images/loading.gif" border="0" alt="Loading..."></td></tr></table>').appendTo(targetObj);}};params={'ajax':f,'ajaxargs':new Array()};if(p){for(i=0;i<p.length;i++){value=p[i];if(typeof(value)=="object")value=this.getForm(value);params['ajaxargs'][i]=value;}};$.ajax({url:arguments.length>=4?arguments[3]:URL,type:"POST",data:params,dataType:"json",success:function(data){$('#ajax_load').css({display:'none'});if(!data)return;var i,j,e;for(i=0;i<data['f'].length;i++){e=data['f'][i];switch(e['a']){case "al":lz.box.alert(e['v']);break;case "sh":lz.box.alert(e['v']);break;case "ht":$('#_'+e['s']).html(e['v']);/*$('#edit-tooltip').css({display:'none'});*/break;case "ml":$('#_'+e['s']+'_input').html(e['v']);break;case "rm":this.remove(e['v']);break;case "pp":$('#'+e['s']).prepend(e['v']);break;case "ap":$('#'+e['s']).append(e['v']);break;case "as":eval("$('#'+e['s'])[0]."+e['p']+"=e['v'];");break;case "js":eval(e['v']);break;}};lz.tooltop();}});},
		loading:function(e){if(!$('#ajax_load')[0])return;/*if($('#ajax_load').css('display')!='none'){*/if(!e)e=event;;$('#ajax_load').css({left:Math.floor($(document).scrollLeft()+e.clientX+16),top:Math.floor($(document).scrollTop()+e.clientY+16)})/*};*/},
		remove:function(sId){$('#'+sId).fadeOut('slow',function(){$(this).remove();})}	
	},
	edit:
	{
		profile:new Array(),
		mouseclear:function(){if(lz.edit.curedit){$('.editting').removeClass('editting');lz.edit.curedit='';}},
		click:function(e){e=lz.edit.find(e.target);if(e){var div=$(e).find('SPAN')[0],p=$(e).find('STRONG')[0],em=$(e).find('EM');if(div.innerHTML.toLowerCase().indexOf(p.innerHTML.toLowerCase().substr(0,5))<0){lz.edit.profile[div.id]=$(div).html();if(lz.edit.curedit!=div&&lz.edit.curedit){$(lz.edit.curedit).html(lz.edit.profile[lz.edit.curedit.id]);$(lz.edit.curedit).parent().removeClass('editting');};$(div).html($(p).html().replace(/tmp_/gi, "update_")+"");$(div).find('input:text,textarea,select').keypress(function(e){var c=(e.keyCode?e.keyCode:e.which);if(c==13&&!e.shiftKey)lz.edit.submit(div.id);});$(div).find('input:text,input:checkbox,textarea,select').keyup(function(e){var c=(e.keyCode?e.keyCode:e.which);if(c==27)lz.edit.cancel(div.id);});if(em.length>0)$(em[0]).css({display:'none'});lz.edit.curedit=div;lz.edit.resize();
		if(!$('#edit-tooltip')[0]&&!$(e).attr('nb')){$('body').append($('<div>').attr({id:'edit-tooltip'}))};if(!$(e).attr('nb')){$('#edit-tooltip').html("<a href='javascript:;' onclick='lz.edit.submit(\""+div.id+"\")'><img src='"+lz.http+"images/save.gif' style='vertical-align:text-bottom'></a> <a href='javascript:;' onclick='lz.edit.cancel(\""+div.id+"\")'><img src='"+lz.http+"images/reload.gif' style='vertical-align:text-bottom'></a>"+(!$(e).attr('nt')&&$(div).attr('ref')!='checkbox'?' (หรือ '+($(div).attr('ref')=='textarea'?'กด Shift + Enter เพื่อขึ้นบรรทัดใหม่, ':'')+'กด Enter เพื่อบันทึก, กด Esc เพื่อยกเลิก)':''));$('#edit-tooltip').css({display:'inline',top:$(e).offset().top-$('#edit-tooltip').height()-7,left:$(e).offset().left+2});};$(e).addClass('editting');}}},
		find:function(e){var i=0;while(e&&i<3){if($(e).hasClass('edit'))return e;e=e.parentNode;i++;};return false;},
		submit:function(a)
		{
			$('#edit-tooltip').css({display:'none'});
			var c='#'+a,p=$(c).attr('id'),z=$(c).attr('ref'),s=$(c).attr('sp'),f=$(c).attr('func'),v='';
			if(z=='datetime')
			{
				v=$('#update'+p+'_year').val()+'-'+$('#update'+p+'_month').val()+'-'+$('#update'+p+'_day').val()+' '+$('#update'+p+'_hh').val()+':'+$('#update'+p+'_nn').val()+':00';
			}
			else if(z=='date')
			{
				v=$('#update'+p+'_year').val()+'-'+$('#update'+p+'_month').val()+'-'+$('#update'+p+'_day').val();
			}
			else if(z=='time')
			{
				v=$('#update'+p+'_hh').val()+':'+$('#update'+p+'_nn').val()+':00';
			}
			else if(z=='checkbox')
			{
				$('.update'+p+':checked').each(function(i,e){v+=(i?', ':'')+$(this).val();});
			}
			else
			{
				v=$('#update'+p).val();
			}
			if($.trim(v)!=''||s)
			{
				if(f)
				{
					f=','+f;
					var t=f.split(',');
				}
				else
				{
					var t=p.split('_');
				}
				switch(t.length)
				{
					case 4:ajax_update(t[1],t[2],t[3],v,z);break;
					case 3:ajax_service(t[1],t[2],v,z);break;
					case 2:ajax_save(t[1],v,z);break;
				}
				$('#'+p).html('<img src="'+lz.http+'images/saving.gif" class="icon"> กำลังบันทึกข้อมูล...');
				lz.edit.curedit='';
			}
			else
			{
				lz.edit.cancel(p);
			}
			$('.editting').removeClass('editting');
		},
		resize:function(){if(lz.edit.curedit){var a=lz.edit.curedit,b=$(a).parent()[0];if($(b).attr('full')!=''){/*alert($(b).attr('full')+'zz-'+$(a).attr('id'));*/$('#update'+$(a).attr('id')).css({width:$(b).width()-5-parseInt($(b).attr('full'))});};$('#update'+$(a).attr('id')).focus();}},
		cancel:function(p){if(!p)p=lz.edit.curedit.id;$('#'+p).html(lz.edit.profile[p]);$('.editting').removeClass('editting');/*$(p).style.textIndent='5px';*/var em=$('#'+p).parent().find('EM');if(em.length>0)em[0].style.display='inline';$('#edit-tooltip').css({display:'none'});}
	},
	img:
	{
		load:function(e,s){var a=Math.floor((s-$(e).height())/2);$(e).css({margin:a+'px 0px'});}
	},
	amz:{search:function(){var mi=$('#min').val(),ma=$('#max').val(),keywords=$('#keywords').val(),disc=$('#disc').val(),shipping=$('#shipping').val();window.open('http://www.amazon.com/gp/search/?ie=UTF8&rh=n:'+$('#node').val()+(shipping=='free'?',p_76:1-':(shipping=='eligible'?',p_76:1':''))+'&bbn='+$('#node').val()+'&tag='+AWS_TAG+(keywords?'&field-keywords='+encodeURIComponent(keywords):'')+(disc?'&pct-off='+disc+'-':'')+(mi?'&low-price='+mi:'')+(ma?'&high-price='+ma:'')+'&sort='+$('#sort').val(),'_blank');}},
	tooltop:function(){if($.fn.tipsy){$(['n','s','w','e','we','ns']).each(function(i,d){$('.show-tooltip-'+d).tipsy({html:true,gravity:(d=='ns'?$.fn.tipsy.autoNS:(d=='we'?$.fn.tipsy.autoWE:(d))),fade:true})});}},
	update:function(){lz.box.update();lz.edit.resize();}
};

//tooltip
(function($){$.fn.tipsy=function(g){$('.tipsy').remove();g=$.extend({},$.fn.tipsy.defaults,g);return this.each(function(){var f=$.fn.tipsy.elementOptions(this,g);$(this).hover(function(){$.data(this,'cancel.tipsy',true);var a=$.data(this,'active.tipsy');if(!a){a=$('<div class="tipsy"><div class="tipsy-inner"/></div>');a.css({position:'absolute',zIndex:100000});$.data(this,'active.tipsy',a)}if($(this).attr('title')||typeof($(this).attr('original-title'))!='string'){$(this).attr('original-title',$(this).attr('title')||'').removeAttr('title')}var b;if(typeof f.title=='string'){b=$(this).attr(f.title=='title'?'original-title':f.title)}else if(typeof f.title=='function'){b=f.title.call(this)}a.find('.tipsy-inner')[f.html?'html':'text'](b||f.fallback);var c=$.extend({},$(this).offset(),{width:this.offsetWidth,height:this.offsetHeight});a.get(0).className='tipsy';a.remove().css({top:0,left:0,visibility:'hidden',display:'block'}).appendTo(document.body);var d=a[0].offsetWidth,actualHeight=a[0].offsetHeight;var e=(typeof f.gravity=='function')?f.gravity.call(this):f.gravity;switch(e.charAt(0)){case'n':a.css({top:c.top+c.height,left:c.left+c.width/2-d/2}).addClass('tipsy-north');break;case's':a.css({top:c.top-actualHeight,left:c.left+c.width/2-d/2}).addClass('tipsy-south');break;case'e':a.css({top:c.top+c.height/2-actualHeight/2,left:c.left-d}).addClass('tipsy-east');break;case'w':a.css({top:c.top+c.height/2-actualHeight/2,left:c.left+c.width}).addClass('tipsy-west');break}if(f.fade){a.css({opacity:0,display:'block',visibility:'visible'}).animate({opacity:0.8})}else{a.css({visibility:'visible'})}},function(){$.data(this,'cancel.tipsy',false);var b=this;setTimeout(function(){if($.data(this,'cancel.tipsy'))return;var a=$.data(b,'active.tipsy');if(f.fade){a.stop().fadeOut(function(){$(this).remove()})}else{a.remove()}},100)})})};$.fn.tipsy.elementOptions=function(a,b){return $.metadata?$.extend({},b,$(a).metadata()):b};$.fn.tipsy.defaults={fade:false,fallback:'',gravity:'n',html:false,title:'title'};$.fn.tipsy.autoNS=function(){return $(this).offset().top>($(document).scrollTop()+$(window).height()/2)?'s':'n'};$.fn.tipsy.autoWE=function(){return $(this).offset().left>($(document).scrollLeft()+$(window).width()/2)?'e':'w'}})(jQuery);

// Checkbox
(function($){var i=function(e){if(!e)var e=window.event;e.cancelBubble=true;if(e.stopPropagation)e.stopPropagation()};$.fn.checkbox=function(f){try{document.execCommand('BackgroundImageCache',false,true)}catch(e){}var g={cls:'jqcheckbox',empty:lz.http+'images/empty.png'};g=$.extend(g,f||{});var h=function(a){var b=a.checked;var c=a.disabled;var d=$(a);if(a.stateInterval)clearInterval(a.stateInterval);a.stateInterval=setInterval(function(){if(a.disabled!=c)d.trigger((c=!!a.disabled)?'disable':'enable');if(a.checked!=b)d.trigger((b=!!a.checked)?'check':'uncheck')},10);return d};return this.each(function(){var a=this;var b=h(a);if(a.wrapper)a.wrapper.remove();a.wrapper=$('<span class="'+g.cls+'"><span class="mark"><img src="'+g.empty+'" /></span></span>');a.wrapperInner=a.wrapper.children('span:eq(0)');a.wrapper.hover(function(e){a.wrapperInner.addClass(g.cls+'-hover');i(e)},function(e){a.wrapperInner.removeClass(g.cls+'-hover');i(e)});b.css({position:'absolute',zIndex:-1,visibility:'hidden'}).after(a.wrapper);var c=false;if(b.attr('id')){c=$('label[for='+b.attr('id')+']');if(!c.length)c=false}if(!c){c=b.closest?b.closest('label'):b.parents('label:eq(0)');if(!c.length)c=false}if(c){c.hover(function(e){a.wrapper.trigger('mouseover',[e])},function(e){a.wrapper.trigger('mouseout',[e])});c.click(function(e){b.trigger('click',[e]);i(e);return false})}a.wrapper.click(function(e){b.trigger('click',[e]);i(e);return false});b.click(function(e){i(e)});b.bind('disable',function(){a.wrapperInner.addClass(g.cls+'-disabled')}).bind('enable',function(){a.wrapperInner.removeClass(g.cls+'-disabled')});b.bind('check',function(){a.wrapper.addClass(g.cls+'-checked')}).bind('uncheck',function(){a.wrapper.removeClass(g.cls+'-checked')});$('img',a.wrapper).bind('dragstart',function(){return false}).bind('mousedown',function(){return false});if(window.getSelection)a.wrapper.css('MozUserSelect','none');if(a.checked)a.wrapper.addClass(g.cls+'-checked');if(a.disabled)a.wrapperInner.addClass(g.cls+'-disabled')})}})(jQuery);
lz.init();
$(window).scroll(lz.update);
$(window).resize(lz.update);
$(document).click(lz.edit.click);
$(document).mouseover(lz.ajax.loading);
$(lz.tooltop);