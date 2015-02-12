<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="<?php echo ($css_style); ?>" lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $title ?></title>
  <meta name="keywords" content="<?php echo $keywords ?>" />
  <meta name="description" content="<?php echo $description ?>" />
  <?php if($css_style == 'details'): ?><meta property="og:title" content="<?php echo ($item["product_name"]); ?> - <?php echo ($item["serial_no"]); ?>"/>
  <meta property="og:type" content="product"/>
  <meta property="og:url" content="http://www.isweek.com/product/123-20333_32.html"/>
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
        <li><a class="<?php if(empty($curr_term_id)){ echo 'xon'; }?> first" href="/allcategories/">All CATEGORIES</a></li>
        <?php foreach($navi_categorys as $vo){ ?>
        <li><a class="<?php foreach($arr_parent as $vo_parent){ if($vo_parent == $vo['term_id']){ echo ' on'; break; } } ?>"
        	href="<?php echo rw_category_url($vo['name'],$vo['term_id']);?>"><?php echo ($vo["name"]); ?></a></li>
        <?php } ?>
        
        <li class="fr">
          <a class="trigger" href="/contactus.html">Contact Us</a>
          <!-- <ul>
            <li><a href="/aboutus.html">About Us</a></li>
            <li><a href="/contactus.html" title="contact us-ISweek.com">Contact Us</a></li>
          </ul> -->
        </li>
        <li class="fr">
          <a class="trigger" href="/SourcingService.html">Sourcing Service</a>
        </li>
      </ul>
    </div>
  </nav>

  <div id="main">
    <div class="wrapper">
      <div class="w-fly-mr">
        <div class="w-fly-cnt">

        <div class="position"><a href="/">Home</a>
        <?php $left_curr_term_ids=array(); foreach($term_ids as $id){ foreach($dao_hang_categorys as $vo){ if($id==$vo['term_id']){ if($id != $curr_term_id){ $left_curr_term_ids[] = $id; $url = rw_category_url($vo['name'],$vo['term_id']); echo '<i>|</i> <a href="'.$url.'">'.$vo['name'].'</a>'; }else{ echo '<i>|</i> <span class="highlight">Terms and Conditions</span>'; } } } } ?></div>

          <aside class="aside">
            <div class="w-box w-box-contact">
              <div class="w-box-hd">
                <h2 class="title">Contact ISweek</h2>
              </div>
              <div class="w-box-bd">
                <ul>
                  <li><a class="skype" href="skype:ISweek_daisychen?call" target="_blank" rel="nofollow">Skype</a></li>
				  <li><span class="tel">+86-755-83289036<br>+852-27370903</span></li>
<!--
                  <li><a class="online" href="#" target="_blank" rel="nofollow">Online Support</a></li>
                  <li><a class="msn" href="#" target="_blank" rel="nofollow">MSN</a></li>

-->
                  <li><a class="email" href="mailto:sales@isweek.com" target="_blank" rel="nofollow">sales@isweek.com</a></li>
                </ul>
              </div>
            </div>
            <?php if(!empty($recommend_products)): ?><div class="w-box w-box-popular">
              <div class="w-box-hd">
                <h2 class="title">Popular on ISweek</h2>
              </div>
              <div class="w-box-bd">
                <ul>
				  <?php if(is_array($popular_products)): $i = 0; $__LIST__ = $popular_products;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
					  <a class="img" href="<?php echo rw_product_url($vo['product_name'],$vo['serial_no'],$vo['id']);?>" target="_blank"><img src="<?php echo ($vo["thumb_200"]); ?>" alt="<?php echo ($vo["product_name"]); ?>" width="100" height="100" /></a>
					  <h5 class="name"><a href="<?php echo rw_product_url($vo['product_name'],$vo['serial_no'],$vo['id']);?>" target="_blank"><?php echo ($vo["product_name"]); ?></a></h5>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
              </div>
            </div><?php endif; ?>
          </aside>

          <div class="prodetails">
            <h1 class="protitle"><?php echo ($item["product_name"]); ?> - <?php echo ($item["serial_no"]); ?></h1>
            <div class="proimg" id="js-proimg">
              <div class="info">
                <p><?php echo ($item["features"]); ?></p>
                <ul>
                  <li>Model Number: <?php echo ($item["serial_no"]); ?></li>
                  <?php if(!empty($item['attachment'])){ ?>
                  <li>Data Sheet: <a href="<?php echo ($item["attachment"]); ?>" target="_blank"><img src="/statics/front/img/icon-pdf.png" alt="Date Sheet File" /></a></li>
                  <?php } ?>
                </ul>
              </div>
              <div class="preview">
                <ul class="imgs">
                  <?php foreach($item['images'] as $k=>$vo){ ?>
                  <?php if($k==0){ ?>
                  <li><a class="jqzoom"><img class="lazy" src="<?php echo ($vo["thumb_300"]); ?>" data-src="<?php echo ($vo["url"]); ?>" alt="<?php echo ($item["product_name"]); ?>" width="300" height="300" /></a></li>
                  <?php }else{ ?>
              	  <li class="fn-hide"><a class="jqzoom"><img class="lazy" src="<?php echo ($vo["thumb_300"]); ?>" data-src="<?php echo ($vo["url"]); ?>" alt="<?php echo ($item["product_name"]); ?>" width="300" height="300" /></a></li>
                  <?php } } ?>
                </ul>
                <div class="tips">Mouse over image to zoom</div>
              </div>
              <ul class="thumbs">
              <?php foreach($item['images'] as $vo){ ?>
              <li><img class="lazy" src="<?php echo ($vo["thumb_100"]); ?>" /></li>
              <?php } ?>
              </ul>
              <div id="js-share" class="share">
                <span>Share:</span>
                <a class="twitter" rel="twitter" title="Connect with us on twitter"></a>
                <a class="facebook" rel="facebook" title="Connect with us on facebook"></a>
                <a class="googleplus" rel="googleplus" title="Connect with us on Google Plus"></a>
              </div>
            </div>
            <div class="prodesc">
              <h3 class="title">Product Specification</h3>
              <p><?php echo ($item["description"]); ?></p>
            </div>
          </div>

          <div class="box-sourcing-service">
            <p>If you cannot find what you want, you can entrust ISweek to source for you. Just click:</p>
            <a href="/SourcingService.html">Sourcing Service</a>
          </div>

		  <?php if(!empty($recommend_products)): ?><div class="w-prolist fn-cb">
            <div class="w-prolist-hd">
              <h2 class="title">Recommended Products</h2>
            </div>
            <div class="w-prolist-bd">
              <ul class="clearfix">
			  <!-- -->
			  <?php if(is_array($recommend_products)): $i = 0; $__LIST__ = $recommend_products;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                  <a class="img" href="<?php echo rw_product_url($vo['product_name'],$vo['serial_no'],$vo['id']);?>" target="_blank"><img src="<?php echo ($vo["thumb_100"]); ?>" alt="<?php echo ($vo["product_name"]); ?>" width="100" height="100" /></a>
                  <h5 class="name"><a href="<?php echo rw_product_url($vo['product_name'],$vo['serial_no'],$vo['id']);?>" target="_blank"><?php echo ($vo["product_name"]); ?></a></h5>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
			  <!-- end -->
              </ul>
            </div>
          </div><?php endif; ?>
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
            <a href="/SourcingService.html">Sourcing Service</a>
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