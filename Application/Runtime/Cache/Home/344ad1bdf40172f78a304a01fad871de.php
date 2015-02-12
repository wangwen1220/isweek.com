<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="home no-js">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>error - isweek.com</title>
  <meta name="keywords" content="industrial products,industry sourcing,wholesale industrial,industrial supplies,electronic products,electronic components" />
  <meta name="description" content="ISweek is an industry sourcing wholesale supplier that sells industrial products and electronic products to global buyers. You can buy high quality products at the best wholesale price right here" />
  <link rel="stylesheet" href="/statics/css/main.css" />
  <link rel="stylesheet" href="/statics/front/css/main.css">
  <!-- <script src="/statics/front/js/cssrefresh.js"></script> -->
  <!-- <script src="/statics/front/js/live.js"></script> -->

  <!--[if lt IE 9]>
  <script src="/statics/front/js/ie/html5shiv.js"></script>
  <script src="/statics/front/js/ie/respond.js"></script>
  <script src="/statics/front/js/ie/nwmatcher.js"></script>
  <script src="/statics/front/js/ie/selectivizr.js"></script>
  <![endif]-->
  <!--[if IE 6]>
  <script src="/statics/front/js/ie/pngfix.js"></script>
  <![endif]-->

  <script src="/statics/front/js/sea-modules/seajs/seajs/2.2.1/sea.js" id="seajsnode"></script>
  <script src="/statics/front/js/main.js"></script>
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  <script src="/statics/js/jquery-1.8.0.min.js"></script>
  <script type="text/javascript">
$(function(){
 //随机的20个产品
 var url = "http://www.isweek.com/index.php/product/do_get_rand20";
 $.post(url,function(data){
      var i = 0;
      var html = "";
      if(data == undefined || data==null){ return false; }
      var len = data.length;
      for(i=0; i<len;i++){
        var item = data[i];
        var url = item.thumb_200;
        html +=  '<li>';
        html +=   '<a href="'+item.url+'"><img src="'+url+'"></a>';
        html +=   '<h3 class="title"><a href="'+item.url+'">'+item.product_name+'</a></h3>';
        html +=    '<p class="description">'+item.abstract+'</p>';
        html += '</li>';
      }
      $('.listbox ul').html(html);
      
	  var timer=null;
	  var speed=8000;
	  var w=200;  //每个li的宽度
	  var ml=0;
	  var num=5; //每次移动的个数
	  var dis=20;
	  var len=$(".listbox ul li").length*2;
	  var dw=parseInt($(".listbox").width()); //澶栧眰div鐨勫搴�
	  $(".listbox ul").append($(".listbox ul").html()).css({'width':len*w+len*dis, 'margin-left': -len*w/2-(len/2)*dis});
	 
	timer=setInterval(init,speed);	
	function init(){
		 $(".next").trigger('click'); 
	}
		
	function show(ml){
	     if($(".listbox ul").is(':animated')){ 
	      return;
	   }
		
	  $(".listbox ul").animate({'margin-left':ml},"slow",function(){
		if(ml<=(w+dis)*(num-len)){  
			    $(".listbox ul").css("margin-left",(w+dis)*(num-len/2));
		   }
		   
		   if(ml==0){
			   $(".listbox ul").css("margin-left",-(len/2)*(w+dis));  
		   }
	    });
	  }
	  
	  $(".listbox ul li").hover(function(){
		 clearInterval(timer);
		},function(){
			timer=setInterval(init,speed);
	   });
	
	  $(".prev").click(function(){
		  ml=parseInt($(".listbox ul").css("margin-left"))+num*(w+dis); 
			 show(ml); 
		  });
		  $(".next").click(function(){
		    ml=parseInt($(".listbox ul").css("margin-left"))-num*(w+dis);
			show(ml);
	  });
         
 });
});
</script>
  <style type="text/css">
     .nofind{padding:59px 0 50px;  width:350px; margin:0 auto;}
     .nofind .sls{float:left;font-family:Microsoft Yahei; font-size:48px;color:#7f7f7f;margin-right:45px;}
     .nofind .sls_r{float:left;}
	 .nofind .sls_r p{line-height:20px;color:#333;font-size:12px;}
	 .nofind .sls_r .no_exist{font-size:14px;color:#ee7711; padding-bottom:5px;}
	 .option{padding-top:25px; line-height:22px;border-top:1px dashed #ddd;}
	 .option dt{padding-bottom:3px;}
	 .option dd i{ display:inline-block;width:3px; height:3px; overflow:hidden; background:#8d8d8e;margin-right:10px; vertical-align:middle;}
	 
	 .interest{width:1192px;margin-top:80px; background:#f2f2f2;padding:4px;}
	 .interest .intere_title{ border-bottom:1px solid #e9e9e9;font-weight:bold;font-size:14px; padding:16px 0 16px 25px;}
	 .intere_inner{ background:#fff; border:1px solid #e9e9e9;}
	 
	  .listbox{width:1100px; height:305px; margin:0 auto; overflow:hidden;}
  .listbox ul{width:9999px;}
  .listbox ul li{ float:left; display:inline; padding-bottom:10px; margin:0 10px;width:200px; }
   .listbox ul li h3{padding:0 10px;margin-bottom:5px;}
   .listbox ul li h3 a{color:#000;font-size:15px;}
   .listbox ul li p{padding:0 10px; height:50px; overflow:hidden;color:#666;}
   .scrollbox{ position:relative;margin-top:5px; padding-bottom:10px;}
   .scrollbox .prev{ position:absolute;left:20px;_left:-20px; top:100px; background:url(/statics/img/prev.gif) left 0 no-repeat;width:16px; height:26px;}
   .scrollbox .next{position:absolute;right:20px; top:100px;background:url(/statics/img/next.gif) 0 0 no-repeat; width:16px; height:26px;}
  </style>
</head>

<body>
 <header id="header">
    <div class="wrapper">
      <h1><a href="/"><img src="/statics/front/img/logo.png" alt="ISweek.com" /></a></h1>
      <!-- <nav>
        <a href="/contactus.html" title="contact us-ISweek.com">Contact Us</a>
      </nav> -->
      <form action="<?php echo U('/home/search');?>" class="search clearfix" id="search">
        <fieldset class="search-panel">
          <input type="text" name="kw" class="kw js-placeholder" value="<?php if(empty($_GET['kw'])){ echo 'Product Keyword/Model Number'; }else{ echo $_GET['kw']; } ?>"/>
          <span class="select-wrap">
            <select name="cid" id="js-select">
              <option value="0">All Categories</option>
              <?php foreach($search_categorys as $vo){ ?>
              <option value="<?php echo ($vo["term_id"]); ?>" <?php if($curr_search_cid==$vo['term_id']){ echo 'selected'; } ?> ><?php echo ($vo["name"]); ?></option>
              <?php } ?>
            </select>
          </span>
        </fieldset>
        <button type="submit" class="search-submit"><span>Search</span></button>
      </form>

      <a class="lang" href="http://www.isweek.cn/" target="_blank">中文</a>
    </div>
  </header>
  <nav id="nav">
    <div class="wrapper">
      <ul>
        <li><a class="<?php if(empty($curr_term_id)){ echo 'on'; }?> first" href="/allcategories/">All CATEGORIES</a></li>
        <?php foreach($navi_categorys as $vo){ ?>
        <li><a class="<?php foreach($arr_parent as $vo_parent){ if($vo_parent == $vo['term_id']){ echo ' on'; break; } } ?>"
        	href="<?php echo rw_category_url($vo['name'],$vo['term_id']);?>"><?php echo ($vo["name"]); ?></a></li>
        <?php } ?>
        <li class="contact-us">
          <a class="trigger" href="/contactus.html">Contact Us</a>
          <!-- <ul>
            <li><a href="/aboutus.html">About Us</a></li>
            <li><a href="/contactus.html" title="contact us-ISweek.com">Contact Us</a></li>
          </ul> -->
        </li>
      </ul>
    </div>
  </nav>


  <div id="main">
    <div class="wrapper">
    <!--add begin-->
       
    
      <div class="nofind fn-clear">
        <strong class="sls">404</strong>
        <div class="sls_r">
             <p class="no_exist">
             <strong>Sorry, the page does not exist.</strong></p>
             <p>Click link blow to go to </p>
             <p><a href="http://www.isweek.com/" style="color:#3f48cc;">Home page</a></p>
        </div>  
      </div>
      <dl class="option">
         <dt><strong>You may also try any option below:</strong></dt>
         <dd><i></i>Check the web address you entered to make sure it is correct</dd>
         <dd><i></i>Access the page from ISweek Home instead of via a bookmark. If the page has moved, reset your bookmark</dd>
         <dd><i></i>Enter keywords in Search box and click Search button, or view categories listed below to look for items you want</dd>
      </dl>
      
      <div class="interest">
         <div class="intere_inner">
          <h3 class="intere_title">Other items you might be interested in</h3>
          <div class="scrollbox"> 
       <div class="listbox">
            <ul class="fn-clear">
            <!-- 
            <li>
              <a href="#"><img src="img/pro.jpg"></a>
               <h3 class="title"><a href="/product/personal-tracker-mobile-phone-mambo2-b6_378.html" target="_blank">Personal Tracker &amp; Mobile Phone</a></h3>
               <p class="description">
               MAMBO2-B6 can be used as a cell phone with the standard features, voice calls, SMS all through a simple menu-guided operation. 
    </p>
            </li>
             -->
             <!-- 循环读取数据 -->
         </ul>
         
         
         </div>
        <a href="javascript:;" class="prev"></a>
         <a href="javascript:;" class="next"></a>
     </div>
        </div>
      </div>
        
      
 <!--add over-->
    </div>
  </div>
  <footer id="footer">
    <div class="wrapper">
      <dl class="connect">
        <dt>Join our community</dt>
        <dd>
          <a class="facebook" href="https://www.facebook.com/isweekb2c" title="Connect with us on facebook" target="_blank" rel="nofollow">Like us <strong>on Facebook</strong></a>
          <a class="twitter" href="https://twitter.com/isweekb2c" title="Connect with us on twitter" target="_blank" rel="nofollow">Follow us <strong>on Twitter</strong></a>
          <a class="googleplus" href="https://plus.google.com/114361625880192443581/posts" title="Connect with us on google+" target="_blank" rel="nofollow">Connect with us <strong>on Google+</strong>+</a>
        </dd>
      </dl>

      <div class="helper clearfix">
        <dl class="support">
          <dt>Customer Support</dt>
          <dd>
            <a class="skype" href="skype:ISweek_daisychen?call" target="_blank" rel="nofollow">Skype</a>
            <span class="tel">+86-755-83289036 &nbsp;&nbsp; +852-27370903</span>
            <!-- <a class="online" href="javascript:;" target="_blank" rel="nofollow">Online Support</a> -->
            <!-- <a class="msn" href="javascript:;" target="_blank" rel="nofollow">MSN</a> -->
            <a class="email" href="mailto:sales@isweek.com" target="_blank" rel="nofollow">sales@isweek.com</a>
          </dd>
        </dl>
        <dl class="link">
          <dt>About ISweek.com</dt>
          <dd>
            <a href="/aboutus.html">About Us</a>
            <a href="/contactus.html" title="contact us-ISweek.com">Contact Us</a>
          </dd>
        </dl>
        <!-- <dl class="about">
          <dt>About ISweek</dt>
          <dd>
            <p>ISweek is a wholesaler that sells electronics and industrial products directly from manufacturers to global buyers and importers. It is a subsidiary of <a href="http://www.ofweek.com" target="_blank" style="text-decoration: underline;">OFweek</a>, which is a comprehensive web portal in China's high-tech industry with 1,000,000 members across various industries. You'll find good quality and best price products at ISweek.com and save your money than everywhere.</p>
            <p>If you cannot find the products that you want, you can ask us to source for you. We will be very happy to assist you with every problem related to products and provide you with the best solution. We give our customers the best customer service that they deserve.</p>
          </dd>
        </dl> -->
      </div>

      <p class="copyright">Copyright © ISweek All Rights Reserved.</p>
    </div>
  </footer>

  <!--Start of Zopim Live Chat Script-->
  <script>
    window.$zopim||(function(d,s){var z=$zopim=function(c){
    z._.push(c)},$=z.s=
    d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
    _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
    $.src='//v2.zopim.com/?2V10a6XjnrGnMHO9EXYxsdQvhBVX1zWc';z.t=+new Date;$.
    type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
  </script>
  <!--End of Zopim Live Chat Script-->

  <!-- 谷歌统计 -->
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-53583783-1', 'auto');
    ga('send', 'pageview');
  </script>

  <!-- CNZZ 统计代码 -->
  <div style="display:none;"><script src="http://v1.cnzz.com/stat.php?id=1253484179&web_id=1253484179" language="JavaScript"></script></div>
</body>
</html>