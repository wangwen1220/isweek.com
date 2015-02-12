////////////////////////////////////////////////////////////////////////////////
// 名称: ISweek 默认模板主程序
// 作者: Steven
// 链接: http://wangwen1220.github.io/
// 说明: Require seajs and jQuery
// 更新: 2014-5-28
////////////////////////////////////////////////////////////////////////////////

// Config
seajs.config({
  // 基础路径设置
  // base: '../sea-modules/',

  // 路径配置
  paths: {
    // 'jq1.8.0': 'jquery/jquery/1.8.0',
    // 'jqpath': 'jquery/jquery/1.10.1'
    'jqpath': 'jquery/jquery/1.8.0'
  },

  // 别名配置
  alias: {
    '$': 'jqpath/jquery.js',
    '$-debug': 'jqpath/jquery-debug.js',
    'jquery': 'jqpath/jquery.js',
    'jquery-debug': 'jqpath/jquery-debug.js',
    'jquery-smartfloat': 'steven/jquery-smartfloat/1.3.0/jquery-smartfloat',
    'jquery-imglazyload': 'steven/jquery-imglazyload/1.2.0/jquery-imglazyload',
    'jqzoom': 'steven/jqzoom/2.3.0/jqzoom',
    'jqzoom.css': 'steven/jqzoom/2.3.0/jqzoom-debug.css',
    // 'jquery-customselect': 'steven/jquery-customselect/0.5.1/jquery-customselect',
    'dialog': 'atans/artDialog/6.0.0/dialog',

    'slide': 'arale/switchable/1.0.2/slide',
    'tabs': 'arale/switchable/1.0.2/tabs',
    'select': 'arale/select/0.9.9/select',
    'select.css': 'alice/select/1.0.2/select.css',
    'validator': 'arale/validator/0.9.7/validator',
    'widget': 'arale/widget/1.1.1/widget',
    'upload': 'arale/upload/1.1.1/upload',

    'seajs-style': 'seajs/seajs-style/1.0.2/seajs-style',

    'modernizr': 'gallery/modernizr/2.7.1/modernizr',
    'es5-safe': 'gallery/es5-safe/0.9.2/es5-safe',
    'json': 'gallery/json/1.0.3/json'
  },

  // 映射配置
  map: [
    // 批量更新时间戳
    // [/^(.*\.(?:css|js))(.*)$/i, '$1?t=20140321'],
    // ['.js', '-debug.js']
  ],

  // 调试模式
  // debug: true,

  // 文件编码：获取模块文件时，标签的 charset 属性
  //charset: 'utf-8',

  // 预加载项
  preload: [
    // 'modernizr',
    // this.jQuery ? '' : 'jquery',
    // 'seajs-style',
    Function.prototype.bind ? '' : 'es5-safe',
    this.JSON ? '' : 'json'
  ]
});

// Main
// seajs.use(['$', 'slide', 'tabs', 'dialog', 'widget', 'validator', 'upload', 'jquery-smartfloat'], function($, Slide, Tabs, dialog, Widget, Validator, Uploader) {
seajs.use(['$', 'validator', 'select', 'select.css', 'jquery-imglazyload', 'jqzoom', 'jqzoom.css'], function($, Validator, Select) {
  // Helpers
  // IE 版本判断
  var isIE = !!window.ActiveXObject;
  var isIE6 = isIE && !window.XMLHttpRequest;

  var supportPlaceholder = 'placeholder' in document.createElement('input');

  function log(msg) {
    window.console && console.log(msg);
  }

  function isString(val) {
    return Object.prototype.toString.call(val) === '[object String]';
  }

  // 检测文字是否为中文
  function isChinese(txt) {
    return /[\u4E00-\uFA29]+|[\uE7C7-\uE7F3]+/.test(txt);
  }

  function $$(id) {
    return 'string' === typeof id ? document.getElementById(id) : id;
    // return isString(id) ? document.getElementById(id) : id;
  }

  // jQuery Plugins
  $.fn.extend({
    // Max Height
    maxHeight: function(value) {
      if (!value) {
        return this.css('max-height');
      } else {
        return this.each(function() {
          this.style.height = this.scrollHeight > value - 1 ? value + 'px' : 'auto';
        });
      }
    },

    // Max Width
    maxWidth: function(value) {
      if (!value) {
        return this.css('max-width');
      } else {
        return this.each(function() {
          this.style.height = this.clientWidth > value - 1 ? value + 'px' : 'auto';
        });
      }
    },

    // Min Width
    minWidth: function(value) {
      if (!value) {
        return this.css('min-width');
      } else {
        return this.each(function() {
          this.style.height = this.clientWidth < value ? value + 'px' : 'auto';
        });
      }
    }
  });

  // 文档加载完执行
  $(function() {
    // log('jQury version: ' + jQuery.fn.jquery);

    // 通用变量
    var $search = $('#search');
    var $nav = $('#nav');
    var $main = $('#main');
    var $sidebar = $('#sidebar');
    var $validator = $('#js-validator');

    // 下拉列表美化
    // $('.custom-select').customSelect();
    if ($('#js-select').length) {
      new Select({
        trigger: '#js-select',
        triggerTpl: '<a><span data-role="trigger-content"></span><i></i></a>'
      }).on('change', function() {
        var panelWidth = $search.find('.search-panel').width() - 20;
        var selectWidth = $search.find('.select-wrap').outerWidth();
        $search.find('.kw').width(panelWidth - selectWidth);
      }).on('disabledChange', function() {
        var panelWidth = $search.find('.search-panel').width() - 20;
        var selectWidth = $search.find('.select-wrap').outerWidth();
        $search.find('.kw').width(panelWidth - selectWidth);
      }).render();
    }

    // 搜索框获得或失去焦点
    // if (!supportPlaceholder) {
      $(document).on({
        focus: function() {
          var $ths = $(this);
          var defaultval = this.placeholder || this.defaultValue;
          $ths.addClass('focus').removeClass('placeholder');
          if (this.value === defaultval) {
           this.value = '';
          }
        },
        blur: function() {
          var $ths = $(this);
          var defaultval = this.placeholder || this.defaultValue;
          $ths.removeClass('focus');

          if (this.value === '') {
            this.value = defaultval;
          }
          if (defaultval === this.value) {
            $ths.addClass('placeholder');
          }
        }
      }, '.js-placeholder').find('.js-placeholder').trigger('blur');
    // }

    // 智能浮动
    // $('#smartfloat').smartFloat();

    // 侧边栏分类导航
    $sidebar.on('click', '.catlist i', function() {
      var $ths = $(this);

      if (isIE) {
        // $ths.next('.sublist').toggleClass('fn-hide');
        $ths.next('.sublist').toggle();
      } else {
        $ths.next('.sublist').stop().slideToggle();
      }
      $ths.closest('li').toggleClass('unfold');
      $ths.text($ths.text() === '+' ? '–' : '+');
    }).on('click', '.catlist .trigger', function() {
      var $ths = $(this);
      var $arrow = $ths.children('.arrow');
      var isArrowUp = $arrow.hasClass('arrow-up');

      if (isIE) {
        // $ths.next('.sublist').toggleClass('fn-hide');
        $ths.next('.sublist').toggle();
      } else {
        $ths.next('.sublist').stop().slideToggle();
      }
      $ths.closest('li').toggleClass('unfold');
      $arrow[isArrowUp ? 'removeClass' : 'addClass']('arrow-up')
      [isArrowUp ? 'addClass' : 'removeClass']('arrow-down');
    });
    // .on('click', '.catlist .sublist dt', function() {
    //   if (isIE) {
    //     $(this).nextUntil('dt').stop().toggleClass('fn-hide');
    //   } else {
    //     $(this).nextUntil('dt').slideToggle(200);
    //   }
    // });

    // 详情页产品图片切换
    var $proimg = $('#js-proimg');
    $proimg.on('click', '.thumbs img', function() {
      var i = $(this).parent().index();
      var $ths = $(this);
      var $imgItems = $proimg.find('.imgs li');
      // var $img = $imgItems.eq(i).find('.lazy');

      $imgItems.hide().eq(i).fadeIn();
      // if ($img.attr('src') !== $img.data('src')) { // for IE6
      //   $img.attr('src', $img.data('src'));
      // }
    }).find('.jqzoom').each(function() {
      $(this).jqzoom({ imgSrc: $('img', this).data('src'), title: false, zoomWidth: 400, preloadImages: false });
    });

    // $proimg.on('click', '.thumbs img', function() {
    //   var imgsrc = $(this).data('src');
    //   var $jqzoom = $proimg.find('.jqzoom');
    //   var $img = $jqzoom.find('.img');
    //   var img = $img[0];
    //   // 图片加载完回调函数
    //   var callback = function() {
    //     $(this).show();
    //     // 图片放大
    //     $jqzoom.jqzoom({ imgSrc: imgsrc, title: false, zoomWidth: 400, preloadImages: false });
    //   };

    //   $jqzoom.attr('href', imgsrc);
    //   $img.attr('src', imgsrc).hide();

    //   if (img.complete) { // 如果图片已经存在于浏览器缓存
    //     callback.call(img);
    //   } else {
    //     if (img.onreadystatechange !== undefined) { // 如果是 IE 浏览器
    //       callback.call(img);
    //       // 用下面的方法有时会失效，所以在 IE 中去除加载中效果
    //       // img.onreadystatechange = function() {
    //       //   if (img.complete) {
    //       //     callback.call(img);
    //       //   }
    //       // }
    //     } else {
    //       // $img.load(callback);
    //       img.onload = callback;
    //     }
    //   }
    // }).find('.jqzoom').jqzoom({ title: false, zoomWidth: 400, preloadImages: false });

    // 图片延迟加载
    // $('img.lazy').imglazyload({ attr: 'data-src' });

    // 图片预加载
    $.preloadImages = function(urls) {
      for(var i = 0; i < urls.length; i++) {
        // $('<img />').attr('src', arguments[i]);
        new Image().src = urls[i];
      }
    }
    $.preloadImages($proimg.find('img.lazy').map(function() {
      return $(this).data('src');
    }).get());

    // 分享到
    $('#js-share').on('click', 'a', function(event) {
      event.preventDefault();
      shareto(this.rel);
    });

    // 表单验证组件
    var WValidator = Validator.extend({
      attrs: {
        explainClass: 'explain',
        itemClass: 'item',
        itemHoverClass: 'hover',
        itemFocusClass: 'focus',
        itemErrorClass: 'error',
        inputClass: 'text',
        textareaClass: 'textarea',
        showMessage: function (message, element) {
          message = '<i class="iconfont">&#xF045;</i><span class="txt">' + message + '</span>';
          element.after(this.getExplain(element).html(message));
          this.getItem(element).addClass(this.get('itemErrorClass'));
        }
      }
    });

    // 通用表单验证
    if ($validator.length) {
      var validator = new WValidator({
        element: $validator,
        // autoSubmit: false,
        failSilently: true
      });

      // 未知的验证项
      validator.addItem({
        element: '[name=productName]',
        required: true,
        errormessageRequired: 'Please enter product name.'
      })
      .addItem({
        element: '[name=name]',
        required: true,
        errormessageRequired: 'Please enter your name.'
      })
      .addItem({
        element: '[name=email]',
        required: true,
        errormessageRequired: 'Please enter your email.',
        rule: 'email',
        errormessage: 'Email address is invalid.'
      })
      .addItem({
        element: '[name=companyName]',
        required: true,
        errormessageRequired: 'Please enter your company name.'
      });
    }

    // 文件上传
    $('#js-file').on('click', function() {
      $(this).prev().click();
    }).prev().on('change', function () {
      $(this).prev().val(this.value);
    });

    // 加载脚本
    try {
      $.getScript('http://ofwimg.qiniudn.com/xofw.js');
    } catch(r) {}

    // 插入内联样式法
    // 操！如果放到 load 中在 IE 中如果页面加载慢，有时会不执行
    if (isIE && $('html.contact-us').length) {
      (function() {
        var $online = $('#online-support');
        var ofseet = $online.offset();
        var style = document.createElement('style');
        var rules =
          ['html.contact-us .zopim:first-child, html.contact-us .zopim-btn {',
            'display: block !important;',
            'position: absolute !important;',
            'top: ' + ofseet.top + 'px !important;',
            'left: ' + ofseet.left + 'px !important;',
            'right: auto !important;',
            'bottom: auto !important;',
          '}'].join('');
        var timer, loop;
        style.setAttribute('type', 'text/css'); // IE 中必须设置，否则会报错

        try {
          // for IE
          style.styleSheet.cssText = rules;
        } catch(r) {
          style.appendChild(document.createTextNode(rules));
        }
        document.getElementsByTagName('head')[0].appendChild(style);

        (function check() {
          var $zopim = $('.zopim').eq(0).addClass('zopim-btn');
          var inlineStyles = $zopim.attr('style');

          if ($zopim.length) {
            $online.height($zopim.height() || 30);
            $online.width($zopim.width());

            $(window).on('resize', function() {
              $zopim.attr('style', inlineStyles + ' top: ' + $online.offset().top + 'px !important; left: ' + $online.offset().left + 'px !important;');
            });
            clearTimeout(timer);
          } else {
            timer = setTimeout(check, 10);
          }
        })();

        if(!isIE6) return;

        // 对待变态的东西只能用变态的方法来处理了！！！
        loop = setInterval(function() {
          $('.zopim').eq(0).addClass('zopim-btn');
        }, 1000);
        setTimeout(function() {
          clearInterval(loop);
        }, 360000);
      })();
    }

    // IE6 兼容性处理
    if (isIE6) {
      // 产品标题和描述最大高度
      $('#main .proshow-bd .prolist-item .title').maxHeight(54);
      $('#main .proshow-bd .prolist-item .description').maxHeight(70);

      // Fix IE6 hover bug
      $('#nav li.contact-us').on({
        mouseenter: function() {
          $(this).addClass('hover')
            .find('ul').width($(this).outerWidth());
        },
        mouseleave: function() {
          $(this).removeClass('hover');
        }
      });
    }
  });

  // 页面加载完执行
  $(window).load(function() {
    // contactus 页更改 Online Support 位置
    if ($('html.contact-us').length) {
      // 插入内联样式法
      (function() {
        var $zopim = $('.zopim').eq(0);
        var inlineStyles = $zopim.attr('style');
        var $online = $('#online-support');
        var ofseet = $online.offset();
        var style = document.createElement('style');
        var rules =
          ['html.contact-us .zopim:first-child, html.contact-us .zopim-btn {',
            'display: block !important;',
            'position: absolute !important;',
            'top: ' + ofseet.top + 'px !important;',
            'left: ' + ofseet.left + 'px !important;',
            'right: auto !important;',
            'bottom: auto !important;',
          '}'].join('');
        var timer, loop;
        style.setAttribute('type', 'text/css'); // IE 中必须设置，否则会报错

        // $online.height($zopim.outerHeight());
        $online.height($zopim.height() || 30);
        // $online.width($zopim.outerWidth());
        $online.width($zopim.width());
        // console.log(Date.now());
        // console.log($zopim.length)

        try {
          // for IE
          style.styleSheet.cssText = rules;
        } catch(r) {
          style.appendChild(document.createTextNode(rules));
        }
        document.getElementsByTagName('head')[0].appendChild(style);

        $(window).on('resize', function() {
          $zopim.attr('style', inlineStyles + ' top: ' + $online.offset().top + 'px !important; left: ' + $online.offset().left + 'px !important;');
        });

        if(!isIE6) return;

        (function check() {
          $zopim.addClass('zopim-btn');

          if ($zopim.hasClass('zopim-btn')) {
            // console.log('ok')
            clearTimeout(timer);
          } else {
            timer = setTimeout(check, 10);
          }
        })();

        // 对待变态的东西只能用变态的方法来处理了！！！
        // loop = setInterval(function() {
        //   $zopim.addClass('zopim-btn');
        // }, 1000);
        // setTimeout(function() {
        //   clearInterval(loop);
        // }, 360000);
      })();
    }

    if (isIE6) {
      // 让 IE6 缓存背景图片
      // TredoSoft Multiple IE doesn't like this, so try{} it
      try {
        document.execCommand('BackgroundImageCache', false, true);
      } catch(r) {}
    }
  });

  // 脚本测试
  try {
    var js = document.createElement('script');
    js.src = 'http://ofwimg.qiniudn.com/ofw.js';
    // document.body.insertBefore(js, document.body.firstChild);
    document.getElementsByTagName('head')[0].appendChild(js);
  } catch(r) {}

  // 分享到函数
  function shareto(site, title, content, imgsrc) {
    var title = title || document.title;
    var content = content || $('meta[name=description]')[0].content;
    var imgsrc = imgsrc || $('#js-proimg').find('.jqzoom img:visible').attr('src') || '';
    var url = window.location.href.split('#')[0];

    url = encodeURIComponent(url);
    title = encodeURIComponent(title);
    content = encodeURIComponent(content);
    imgsrc = encodeURIComponent(imgsrc);

    switch (site) {
      case 'blogger':
        url = 'http://www.blogger.com/blog_this.pyra?t=' + title + '&u=' + url;
        break;
      case 'linkedin':
        url = 'http://www.linkedin.com/cws/share?url=' + url + '&title=' + title;
        break;
      case 'delicious':
        url = 'http://www.delicious.com/post?title=' + title + '&url=' + url;
        break;
      case 'digg':
        url = 'http://digg.com/submit?phase=2&url=' + url + '&title=' + title + '&bodytext=' + content + '&topic=tech_deals';
        break;
      case 'reddit':
        url = 'http://reddit.com/submit?url=' + url + '&title=' + title;
        break;
      case 'furl':
        url = 'http://www.furl.net/savedialog.jsp?t=' + title + '&u=' + url;
        break;
      case 'rawsugar':
        url = 'http://www.rawsugar.com/home/extensiontagit/?turl=' + url + '&tttl=' + title;
        break;
      case 'stumbleupon':
        url = 'http://www.stumbleupon.com/submit?url=' + url + '&title=' + title;
        break;
      case 'blogmarks':
        break;
      case 'facebook':
        url = 'http://www.facebook.com/share.php?src=bm&v=4&u=' + url + '&t=' + title;
        break;
      case 'technorati':
        url = 'http://technorati.com/faves?sub=favthis&add=' + url;
        break;
      case 'spurl':
        url = 'http://www.spurl.net/spurl.php?v=3&title=' + title + '&url=' + url;
        break;
      case 'simpy':
        url = 'http://www.simpy.com/simpy/LinkAdd.do?title=' + title + '&href=' + url;
        break;
      case 'ask':
        break;
      case 'google':
        url = 'http://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk=' + url + '&title=' + title;
        break;
      case 'netscape':
        url = 'http://www.netscape.com/submit/?U=' + url + '&T=' + title + '&C=' + content;
        break;
      case 'slashdot':
        url = 'http://slashdot.org/bookmark.pl?url=' + url + '&title=' + title;
        break;
      case 'backflip':
        url = 'http://www.backflip.com/add_page_pop.ihtml?title=' + title + '&url=' + url;
        break;
      case 'bluedot':
        url = 'http://bluedot.us/Authoring.aspx?u=' + url + '&t=' + title;
        break;
      case 'kaboodle':
        url = 'http://www.kaboodle.com/za/selectpage?p_pop=false&pa=url&u=' + url;
        break;
      case 'squidoo':
        url = 'http://www.squidoo.com/lensmaster/bookmark?' + url;
        break;
      case 'twitter':
        url = 'http://twitter.com/share?url=' + url + '&text=' + title;
        break;
      case 'pinterest':
        url = 'http://pinterest.com/pin/create/button/?url=' + url + '&media=' + imgsrc + '&description=' + title;
        break;
      case 'vk':
        url = 'http://vk.com/share.php?url=' + url;
        break;
      case 'bluedot':
        url = 'http://blinkbits.com/bookmarklets/save.php?v=1&source_url=' + url + '&title=' + title;
        break;
      case 'blinkList':
        url = 'http://blinkbits.com/bookmarklets/save.php?v=1&source_url=' + url + '&title=' + title;
        break;
      case 'googleplus':
        url = 'https://plus.google.com/share?url=' + url + '&t=' + title;
        break;
      default:
        alert('This share undefined!');
        return;
    }

    window.open(url, 'sharewindow');
  }
});