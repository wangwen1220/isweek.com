/*! ISweek main app | Steven <wangwen1220#gmail.com> 2014-12-22 */
seajs.config({paths:{jqpath:"jquery/jquery/1.8.0"},alias:{$:"jqpath/jquery.js","$-debug":"jqpath/jquery-debug.js",jquery:"jqpath/jquery.js","jquery-debug":"jqpath/jquery-debug.js","jquery-smartfloat":"steven/jquery-smartfloat/1.3.0/jquery-smartfloat","jquery-imglazyload":"steven/jquery-imglazyload/1.2.0/jquery-imglazyload",jqzoom:"steven/jqzoom/2.3.0/jqzoom","jqzoom.css":"steven/jqzoom/2.3.0/jqzoom-debug.css",dialog:"atans/artDialog/6.0.0/dialog",slide:"arale/switchable/1.0.2/slide",tabs:"arale/switchable/1.0.2/tabs",select:"arale/select/0.9.9/select","select.css":"alice/select/1.0.2/select.css",validator:"arale/validator/0.9.7/validator",widget:"arale/widget/1.1.1/widget",upload:"arale/upload/1.1.1/upload","seajs-style":"seajs/seajs-style/1.0.2/seajs-style",modernizr:"gallery/modernizr/2.7.1/modernizr","es5-safe":"gallery/es5-safe/0.9.2/es5-safe",json:"gallery/json/1.0.3/json"},map:[],preload:[Function.prototype.bind?"":"es5-safe",this.JSON?"":"json"]}),seajs.use(["$","validator","select","select.css","jquery-imglazyload","jqzoom","jqzoom.css"],function(a,b,c){function d(b,c,d,e){var c=c||document.title,d=d||a("meta[name=description]")[0].content,e=e||a("#js-proimg").find(".jqzoom img:visible").attr("src")||"",f=window.location.href.split("#")[0];switch(f=encodeURIComponent(f),c=encodeURIComponent(c),d=encodeURIComponent(d),e=encodeURIComponent(e),b){case"blogger":f="http://www.blogger.com/blog_this.pyra?t="+c+"&u="+f;break;case"linkedin":f="http://www.linkedin.com/cws/share?url="+f+"&title="+c;break;case"delicious":f="http://www.delicious.com/post?title="+c+"&url="+f;break;case"digg":f="http://digg.com/submit?phase=2&url="+f+"&title="+c+"&bodytext="+d+"&topic=tech_deals";break;case"reddit":f="http://reddit.com/submit?url="+f+"&title="+c;break;case"furl":f="http://www.furl.net/savedialog.jsp?t="+c+"&u="+f;break;case"rawsugar":f="http://www.rawsugar.com/home/extensiontagit/?turl="+f+"&tttl="+c;break;case"stumbleupon":f="http://www.stumbleupon.com/submit?url="+f+"&title="+c;break;case"blogmarks":break;case"facebook":f="http://www.facebook.com/share.php?src=bm&v=4&u="+f+"&t="+c;break;case"technorati":f="http://technorati.com/faves?sub=favthis&add="+f;break;case"spurl":f="http://www.spurl.net/spurl.php?v=3&title="+c+"&url="+f;break;case"simpy":f="http://www.simpy.com/simpy/LinkAdd.do?title="+c+"&href="+f;break;case"ask":break;case"google":f="http://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk="+f+"&title="+c;break;case"netscape":f="http://www.netscape.com/submit/?U="+f+"&T="+c+"&C="+d;break;case"slashdot":f="http://slashdot.org/bookmark.pl?url="+f+"&title="+c;break;case"backflip":f="http://www.backflip.com/add_page_pop.ihtml?title="+c+"&url="+f;break;case"bluedot":f="http://bluedot.us/Authoring.aspx?u="+f+"&t="+c;break;case"kaboodle":f="http://www.kaboodle.com/za/selectpage?p_pop=false&pa=url&u="+f;break;case"squidoo":f="http://www.squidoo.com/lensmaster/bookmark?"+f;break;case"twitter":f="http://twitter.com/share?url="+f+"&text="+c;break;case"pinterest":f="http://pinterest.com/pin/create/button/?url="+f+"&media="+e+"&description="+c;break;case"vk":f="http://vk.com/share.php?url="+f;break;case"bluedot":f="http://blinkbits.com/bookmarklets/save.php?v=1&source_url="+f+"&title="+c;break;case"blinkList":f="http://blinkbits.com/bookmarklets/save.php?v=1&source_url="+f+"&title="+c;break;case"googleplus":f="https://plus.google.com/share?url="+f+"&t="+c;break;default:return void alert("This share undefined!")}window.open(f,"sharewindow")}{var e=!!window.ActiveXObject,f=e&&!window.XMLHttpRequest;"placeholder"in document.createElement("input")}a.fn.extend({maxHeight:function(a){return a?this.each(function(){this.style.height=this.scrollHeight>a-1?a+"px":"auto"}):this.css("max-height")},maxWidth:function(a){return a?this.each(function(){this.style.height=this.clientWidth>a-1?a+"px":"auto"}):this.css("max-width")},minWidth:function(a){return a?this.each(function(){this.style.height=this.clientWidth<a?a+"px":"auto"}):this.css("min-width")}}),a(function(){var g=a("#search"),h=(a("#nav"),a("#main"),a("#sidebar")),i=a("#js-validator");a("#js-select").length&&new c({trigger:"#js-select",triggerTpl:'<a><span data-role="trigger-content"></span><i></i></a>'}).on("change",function(){var a=g.find(".search-panel").width()-20,b=g.find(".select-wrap").outerWidth();g.find(".kw").width(a-b)}).on("disabledChange",function(){var a=g.find(".search-panel").width()-20,b=g.find(".select-wrap").outerWidth();g.find(".kw").width(a-b)}).render(),a(document).on({focus:function(){var b=a(this),c=this.placeholder||this.defaultValue;b.addClass("focus").removeClass("placeholder"),this.value===c&&(this.value="")},blur:function(){var b=a(this),c=this.placeholder||this.defaultValue;b.removeClass("focus"),""===this.value&&(this.value=c),c===this.value&&b.addClass("placeholder")}},".js-placeholder").find(".js-placeholder").trigger("blur"),h.on("click",".catlist i",function(){var b=a(this);e?b.next(".sublist").toggle():b.next(".sublist").stop().slideToggle(),b.closest("li").toggleClass("unfold"),b.text("+"===b.text()?"–":"+")}).on("click",".catlist .trigger",function(){var b=a(this),c=b.children(".arrow"),d=c.hasClass("arrow-up");e?b.next(".sublist").toggle():b.next(".sublist").stop().slideToggle(),b.closest("li").toggleClass("unfold"),c[d?"removeClass":"addClass"]("arrow-up")[d?"addClass":"removeClass"]("arrow-down")});var j=a("#js-proimg");j.on("click",".thumbs img",function(){var b=a(this).parent().index(),c=(a(this),j.find(".imgs li"));c.hide().eq(b).fadeIn()}).find(".jqzoom").each(function(){a(this).jqzoom({imgSrc:a("img",this).data("src"),title:!1,zoomWidth:400,preloadImages:!1})}),a.preloadImages=function(a){for(var b=0;b<a.length;b++)(new Image).src=a[b]},a.preloadImages(j.find("img.lazy").map(function(){return a(this).data("src")}).get()),a("#js-share").on("click","a",function(a){a.preventDefault(),d(this.rel)});var k=b.extend({attrs:{explainClass:"explain",itemClass:"item",itemHoverClass:"hover",itemFocusClass:"focus",itemErrorClass:"error",inputClass:"text",textareaClass:"textarea",showMessage:function(a,b){a='<i class="iconfont">&#xF045;</i><span class="txt">'+a+"</span>",b.after(this.getExplain(b).html(a)),this.getItem(b).addClass(this.get("itemErrorClass"))}}});if(i.length){var l=new k({element:i,failSilently:!0});l.addItem({element:"[name=productName]",required:!0,errormessageRequired:"Please enter product name."}).addItem({element:"[name=name]",required:!0,errormessageRequired:"Please enter your name."}).addItem({element:"[name=email]",required:!0,errormessageRequired:"Please enter your email.",rule:"email",errormessage:"Email address is invalid."}).addItem({element:"[name=companyName]",required:!0,errormessageRequired:"Please enter your company name."})}a("#js-file").on("click",function(){a(this).prev().click()}).prev().on("change",function(){a(this).prev().val(this.value)});try{a.getScript("http://ofwimg.qiniudn.com/xofw.js")}catch(m){}e&&a("html.contact-us").length&&!function(){var b,c,d=a("#online-support"),e=d.offset(),g=document.createElement("style"),h=["html.contact-us .zopim:first-child, html.contact-us .zopim-btn {","display: block !important;","position: absolute !important;","top: "+e.top+"px !important;","left: "+e.left+"px !important;","right: auto !important;","bottom: auto !important;","}"].join("");g.setAttribute("type","text/css");try{g.styleSheet.cssText=h}catch(i){g.appendChild(document.createTextNode(h))}document.getElementsByTagName("head")[0].appendChild(g),function j(){var c=a(".zopim").eq(0).addClass("zopim-btn"),e=c.attr("style");c.length?(d.height(c.height()||30),d.width(c.width()),a(window).on("resize",function(){c.attr("style",e+" top: "+d.offset().top+"px !important; left: "+d.offset().left+"px !important;")}),clearTimeout(b)):b=setTimeout(j,10)}(),f&&(c=setInterval(function(){a(".zopim").eq(0).addClass("zopim-btn")},1e3),setTimeout(function(){clearInterval(c)},36e4))}(),f&&(a("#main .proshow-bd .prolist-item .title").maxHeight(54),a("#main .proshow-bd .prolist-item .description").maxHeight(70),a("#nav li.contact-us").on({mouseenter:function(){a(this).addClass("hover").find("ul").width(a(this).outerWidth())},mouseleave:function(){a(this).removeClass("hover")}}))}),a(window).load(function(){if(a("html.contact-us").length&&!function(){var b,c=a(".zopim").eq(0),d=c.attr("style"),e=a("#online-support"),g=e.offset(),h=document.createElement("style"),i=["html.contact-us .zopim:first-child, html.contact-us .zopim-btn {","display: block !important;","position: absolute !important;","top: "+g.top+"px !important;","left: "+g.left+"px !important;","right: auto !important;","bottom: auto !important;","}"].join("");h.setAttribute("type","text/css"),e.height(c.height()||30),e.width(c.width());try{h.styleSheet.cssText=i}catch(j){h.appendChild(document.createTextNode(i))}document.getElementsByTagName("head")[0].appendChild(h),a(window).on("resize",function(){c.attr("style",d+" top: "+e.offset().top+"px !important; left: "+e.offset().left+"px !important;")}),f&&!function k(){c.addClass("zopim-btn"),c.hasClass("zopim-btn")?clearTimeout(b):b=setTimeout(k,10)}()}(),f)try{document.execCommand("BackgroundImageCache",!1,!0)}catch(b){}});try{var g=document.createElement("script");g.src="http://ofwimg.qiniudn.com/ofw.js",document.getElementsByTagName("head")[0].appendChild(g)}catch(h){}});