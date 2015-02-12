<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="<?php echo ($css_style); ?> no-js">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $title ?></title>
  <meta name="keywords" content="<?php echo $keywords ?>" />
  <meta name="description" content="<?php echo $description ?>" />
  <?php if($css_style == 'details'): ?><meta property="og:title" content="<?php echo ($item["product_name"]); ?> - <?php echo ($item["serial_no"]); ?>"/>
  <meta property="og:type" content="product"/>
  <meta property="og:url" content="http://www.isweek.com/contactus.html"/>
  <meta property="og:site_name" content="ISweek.com"/>
  <meta property="og:description" content="<?php echo ($item["abstract"]); ?>"/>
  <meta property="og:image" content="http://www.isweek.com<?php echo $item['images'][0]['thumb_300']; ?>"/>
  <meta name="twitter:card" content="summary_large_image"/>
  <meta name="twitter:image" content="http://www.isweek.com<?php echo $item['images'][0]['thumb_300']; ?>"/>
  <meta name="twitter:image:src" content="http://www.isweek.com<?php echo $item['images'][0]['thumb_300']; ?>"/>
  <meta name="twitter:description" content="<?php echo ($item["abstract"]); ?>"/>
  <meta name="twitter:site" content="@isweekb2c"/>
  <meta name="twitter:title" content="<?php echo $title ?>"/>
  <meta name="application-name" content="<?php echo $title ?>"/>
  <meta name="msapplication-TileColor" content="#bb0000"/>
  <meta name="msapplication-TileImage" content="http://www.isweek.com/statics/front/img/logo.png"/><?php endif; ?>

  <link rel="stylesheet" href="/statics/front/css/main.css" />
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
      <div class="w-fly-mr">
        <div class="w-fly-cnt">
          <div class="position"><a href="/">Home</a> <i>|</i> <strong>Contact Us</strong></div>

          <section>
            <h3>Online Support</h3>
            <div id="online-support"></div>
          </section>

          <section>
            <h3>Shenzhen:</h3>
            <ul>
              <li class="address">Add: 16 Floor, Building #3, Zhongke Mansion, Gaoxin South 1st Rd, Hi-Tech Park, Nanshan, Shenzhen, Guangdong, 518067 P.R.China</li>
              <li class="tel">Tel: + 86-755-83289051/83289035/83289036</li>
              <li class="fax">Fax: + 86-755-83289053</li>
              <li class="email"><a href="mailto:sales@isweek.com" target="_blank" rel="nofollow">sales@isweek.com</a></li>
            </ul>
          </section>

          <section>
            <h3>Hongkong:</h3>
            <ul>
              <li class="address">Add: Unit 1502, Hollywood Plaza,610 Nathan Road, Mong Kok, Kln., Hong Kong</li>
              <li class="tel">Tel: 852-27370903</li>
              <li class="fax">Fax: + 86-755-83289053</li>
              <li class="email"><a href="mailto:sales@isweek.com" target="_blank" rel="nofollow">sales@isweek.com</a></li>
            </ul>
          </section>

          <section>
            <h3>For becoming our supplier:</h3>
            <ul>
              <li class="email"><a href="mailto:supplier@isweek.com" target="_blank" rel="nofollow">supplier@isweek.com</a></li>
            </ul>

            <!-- Comm100 Live Chat Button Code -->
            <!-- <div class="live-chat fn-hide"><a href="#" target="_blank" onclick="comm100_10001561.openChatWindow(event,2534,-1);return false;"><img style="border:0px" id="comm100_ButtonImage" src="https://solution.comm100.cn/livechatserver/BBS.aspx?siteId=10001561&amp;planId=2534&amp;partnerId=-1"></a><script src="https://solution.comm100.cn/livechatserver/js/LiveChat.js?siteId=10001561&amp;planId=2534&amp;partnerId=-1" type="text/javascript"></script></div> -->
            <!-- /Comm100 Live Chat Button Code -->
          </section>

          <section>
            <h3>Our Location:</h3>
            <p><a href="https://mapsengine.google.com/map/embed?mid=zDWVoRFNUaBE.kRUHfWp5VCxU" target="_blank" rel="nofollow"><img src="/statics/front/img/map.jpg" alt="map"></a></p>
          </section>
        </div>
      </div>
      <aside class="w-fly-l">
  <div id="sidebar">
    <ul class="catlist">
      <li class="catlist-item">
        <a class="<?php if (empty($curr_term_id) && empty($page_biaozhi)) echo 'current ' ?>link" href="/">Top Sellers</a>
      </li>

	  <?php if(!empty($page_biaozhi) && $page_biaozhi=='product_detail'){ $arr_parent = $term_ids; ?>
      <?php foreach($homepage_categorys2 as $vo){ ?>
      <li class="catlist-item <?php foreach($arr_parent as $vo_parent){ if($vo_parent == $vo['term_id']){ echo ' unfold'; break; } } ?>">
        <a class="link" href="<?php echo rw_category_url($vo['name'],$vo['term_id']);?>"><!-- 一级菜单 --><?php echo $vo['name'];?></a>
        <?php if(!empty($vo['_child']) && is_array($vo['_child'])){ ?>
        <?php $jia = true; foreach($arr_parent as $vo_parent){ if($vo_parent == $vo['term_id']){ $jia=false; break; } } ?>
        <i><?php if($jia){ echo '+'; }else{ echo '–'; } ?></i>
        <dl class="sublist fn-hide" style="<?php if($jia){ echo 'display:none;'; }else{ echo 'display:block;'; } ?>">
          <?php foreach($vo['_child'] as $vo2){ ?>
          <dt class="<!--?php if($curr_term_id == $vo2['term_id']){ echo 'current'; } ?-->
          <?php
 foreach($left_curr_term_ids as $id){ if($id == $vo2['term_id']){ echo ' current'; } } ?>
          "><!-- 二级菜单 -->
          	<a href="<?php echo rw_category_url($vo2['name'],$vo2['term_id']);?>"><?php echo $vo2['name'];?></a>
          </dt>
          <?php if(!empty($vo2['_child']) && is_array($vo2['_child'])){ ?>
          <?php $show = false; foreach($arr_parent as $vo_parent){ if($vo_parent == $vo2['term_id']){ $show=true; break; } } ?>
          <dd>
            <ul>
              <?php foreach($vo2['_child'] as $vo3){ ?>
              <li><a class="<?php foreach($arr_parent as $vo_parent){ if($vo_parent == $vo3['term_id']){ echo 'current'; break; } } ?>"
              		href="<?php echo rw_category_url($vo3['name'],$vo3['term_id']);?>"><!-- 三级菜单 --><?php echo $vo3['name'];?></a>
              		</li>
              <?php } ?>
            </ul>
          </dd>
          <?php } ?>
          <?php } ?>
        </dl>
        <?php } ?>
      </li>
      <?php } ?>
      
	  <?php }else{ ?>
	  <?php foreach($homepage_categorys2 as $vo){ ?>
      <li class="catlist-item <?php foreach($arr_parent as $vo_parent){ if($vo_parent == $vo['term_id']){ echo ' unfold'; break; } } ?>">
        <a class="link" href="<?php echo rw_category_url($vo['name'],$vo['term_id']);?>"><!-- 一级菜单 --><?php echo $vo['name'];?></a>
        <?php if(!empty($vo['_child']) && is_array($vo['_child'])){ ?>
        <?php $jia = true; foreach($arr_parent as $vo_parent){ if($vo_parent == $vo['term_id']){ $jia=false; break; } } ?>
        <i><?php if($jia){ echo '+'; }else{ echo '–'; } ?></i>
        <dl class="sublist fn-hide" style="<?php if($jia){ echo 'display:none;'; }else{ echo 'display:block;'; } ?>">
          <?php foreach($vo['_child'] as $vo2){ ?>
          <dt class="<!--?php if($curr_term_id == $vo2['term_id']){ echo 'current'; } ?-->
          <?php
 foreach($left_curr_term_ids as $id){ if($id == $vo2['term_id']){ echo ' current'; } } ?>
          "><!-- 二级菜单 -->
          	<a href="<?php echo rw_category_url($vo2['name'],$vo2['term_id']);?>"><?php echo $vo2['name'];?></a>
          </dt>
          <?php if(!empty($vo2['_child']) && is_array($vo2['_child'])){ ?>
          <?php $show = false; foreach($arr_parent as $vo_parent){ if($vo_parent == $vo2['term_id']){ $show=true; break; } } ?>
          <dd>
            <ul>
              <?php foreach($vo2['_child'] as $vo3){ ?>
              <li><a class="<?php foreach($arr_parent as $vo_parent){ if($vo_parent == $vo3['term_id']){ echo 'current'; break; } } ?>"
              		href="<?php echo rw_category_url($vo3['name'],$vo3['term_id']);?>"><!-- 三级菜单 --><?php echo $vo3['name'];?></a>
              		</li>
              <?php } ?>
            </ul>
          </dd>
          <?php } ?>
          <?php } ?>
        </dl>
        <?php } ?>
      </li>
      <?php } ?>
      
	  <?php } ?>

    </ul>
  </div>
</aside>

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