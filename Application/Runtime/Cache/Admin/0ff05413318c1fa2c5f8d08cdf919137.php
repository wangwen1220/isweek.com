<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge" />
<title>系统后台</title>
<link href="/statics/css/admin_style.css<?php echo ($js_debug); ?>" rel="stylesheet" />
<link href="/statics/js/artDialog/skins/default.css<?php echo ($js_debug); ?>" rel="stylesheet" />
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<script src="/statics/js/wind.js<?php echo ($js_debug); ?>"></script>
<script src="/statics/js/jquery.js<?php echo ($js_debug); ?>"></script>
<script type="text/javascript">
    var catid = "12";
</script>
<style type="text/css">
.col-auto {
	overflow: hidden;
	_zoom: 1;
	_float: left;
	border: 1px solid #c2d1d8;
}
.col-right {
	float: right;
	width: 210px;
	overflow: hidden;
	margin-left: 6px;
	border: 1px solid #c2d1d8;
}

body fieldset {
	border: 1px solid #D8D8D8;
	padding: 10px;
	background-color: #FFF;
}
body fieldset legend {
    background-color: #F9F9F9;
    border: 1px solid #D8D8D8;
    font-weight: 700;
    padding: 3px 8px;
}
.list-dot{ padding-bottom:10px}
.list-dot li,.list-dot-othors li{padding:5px 0; border-bottom:1px dotted #c6dde0; font-family:"宋体"; color:#bbb; position:relative;_height:22px}
.list-dot li span,.list-dot-othors li span{color:#004499}
.list-dot li a.close span,.list-dot-othors li a.close span{display:none}
.list-dot li a.close,.list-dot-othors li a.close{ background: url("/statics/images/cross.png") no-repeat left 3px; display:block; width:16px; height:16px;position: absolute;outline:none;right:5px; bottom:5px}
.list-dot li a.close:hover,.list-dot-othors li a.close:hover{background-position: left -46px}
.list-dot-othors li{float:left;width:24%;overflow:hidden;}
</style>
</head>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <div class="nav">
    <ul class="cc">
      <li class="current"><a href="#"><?php echo ((isset($term["name"]) && ($term["name"] !== ""))?($term["name"]):'产品预览'); ?></a></li>
    </ul>
  </div>
  <form name="myform" id="myform" action="<?php echo u('products/edit_post');?>" method="post" class="J_ajaxForms" enctype="multipart/form-data">

  <div class="col-auto">
    <div class="h_a">产品内容</div>
    <div class="table_full">
      <table width="100%">
            <tr>
              <th width="80">供应商<span class="must_red">*</th>
              <td>
              	<select name="supplier_id"  class="normal_select"  disabled="disabled">
				<?php if(is_array($suppliers)): foreach($suppliers as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo[id]==$products[supplier_id]) {echo 'selected="selected"';} ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
				</select>
              </td>
            </tr>
            <tr>
              <th width="80">产品名称<span class="must_red">*</span></th>
              <td>
              	<input type="text" disabled="disabled" style="width:400px;" name="product_name" id="product_name" value="<?php echo ($products["product_name"]); ?>" style="color:" class="input input_hd J_title_color" placeholder="请输入产品名称" maxlength="80"/>
              	
              </td>
            </tr>
            <tr>
              <th width="80">产品型号<span class="must_red">*</th>
              <td><input type='text' disabled="disabled" name='serial_no' id='serial_no' value='<?php echo ($products["serial_no"]); ?>' style='width:280px'   class='input' placeholder='请输入关键字'></td>
            </tr>
            <tr>
              <th width="80">产品分类<span class="must_red">*</th>
				<td>
					<table>
					<tr>
					<?php echo ($selected_cate_options); ?>
					</tr>
					</table>
				</td>
            </tr>

            <tr>
              <th width="80">关键词<span class="must_red">*</th>
              <td><input type='text' disabled="disabled"  name='keywords' id='keywords' value='<?php echo ($products["keywords"]); ?>' style='width:280px'   class='input' placeholder='请输入关键字'> 多关键词之间用半角逗号隔开</td>
            </tr>
            <tr>
              <th width="80">特性<span class="must_red">*</th>
              <td><textarea name='features' disabled="disabled"  id='features' style='width:50%;height:150px;'   maxlength="660" ><?php echo ($products["features"]); ?></textarea> <br/>Product Features 建议不超过10行，此段文字将在产品介绍页的最顶端展示。最多勿超过660字符。</td>
            </tr>		
            <tr>
              <th width="80">内容<span class="must_red">*</th>
              <td style='width:50%;height:150px;' >  <?php echo ($products["description"]); ?></td>
            </tr>			
			
              <tr>
              <th width="80">摘要<span class="must_red">*</th>
              <td><textarea name='abstract' disabled="disabled" id='abstract' style='width:50%;height:100px;' maxlength="160" ><?php echo ($products["abstract"]); ?></textarea><br/> Short Description 建议不超过160字符。此段将在产品列表页的摘要中展示，同时供搜索引擎收录用。可以写产品简介或参数。 </td>
            </tr>
          
            <tr>
              <th width="80">产品图片<span class="must_red">*</th>
              <td>
				<fieldset class="blue pad-10">
		        <legend>图片列表</legend>
				<ul id="photos" class="picList">
			        <?php if(is_array($images)): foreach($images as $key=>$vo): ?><li id="savedimage<?php echo ($key); ?>">
							<img src="<?php echo ($vo['url']); ?>" width="300"/>
						</li><?php endforeach; endif; ?>
				</ul>

<!--		        <ul id="photos" class="picList">
			        <?php if(is_array($images)): foreach($images as $key=>$vo): ?><li id="savedimage<?php echo ($key); ?>">
							<img src="<?php echo ($vo['url']); ?>" width="300"/>
				        	<input type="text" name="photos_url[]" value="<?php echo ($vo['url']); ?>" title='双击查看' style="width:310px;" ondblclick="image_priview(this.value);" class="input">
				        	<input type="text" name="photos_alt[]" value="<?php echo ($vo["alt"]); ?>" style="width:160px;" class="input" onfocus="if(this.value == this.defaultValue) this.value = ''" onblur="if(this.value.replace(' ','') == '') this.value = this.defaultValue;">
				        	<a href="javascript:remove_div('savedimage<?php echo ($key); ?>')">移除</a>

				        </li><?php endforeach; endif; ?>
				</ul>
-->

				</fieldset>
				<div class="bk10"></div>
            </tr>
         
            <tr>
              <th width="80">Data Sheet</th>
              <td>
			  <?php if($products.attachment!=''): ?><a href="<?php echo ($products["attachment"]); ?>" /><?php echo ($products["attachment"]); ?></a><?php endif; ?>
			  </td>
            </tr>


        <tr>
          <th width="80">发布时间</th>
          <td><?php echo (date('Y-m-d G:i:s', $products["post_time"])); ?></td>
        </tr>
						

        </tbody>
      </table>
    </div>
  </div>
  <div class="btn_wrap" style="z-index:999;text-align: center;">
    <div class="btn_wrap_pd">
      <input type="hidden" name="id" value="<?php echo I('get.id');?>" />
      <button class="btn btn_submit J_ajax_submit_btn"type="submit">提交</button>
      <a class="btn" href="/Admin/Audit">返回</a>
    </div>
  </div>
 </form>
</div>
<script type="text/javascript" src="/statics/js/common.js<?php echo ($js_debug); ?>"></script>
<script type="text/javascript" src="/statics/js/content_addtop.js<?php echo ($js_debug); ?>"></script>
<script type="text/javascript"> 
$(function () {

	//分类选择
	var num = 5;
	var ename = 'category';
	$('#button_r_'+ename).on('click',function(){
		var options = $('#content_'+ename+' :selected');
		var num_c = options.length;
		var num_v = $('#value_'+ename+' option').length;

		if((num_c+num_v) > num){
			alert('请选择不多于'+num+'个条目');
			return false;
		}
		//去除名字前面的标识符
		$(options).each(function(){
			var s = this.innerHTML;
			this.innerHTML = s.replace(/&nbsp;|└─|│|├─/g, '');
//			console.log(s.replace(/&nbsp;|└─|│|├─/g, ''));
		})
		$('#value_'+ename).append(options);
	});
	$('#button_l_'+ename).on('click',function(){
		var options = $('#value_'+ename+' :selected');
		$('#content_'+ename).append(options);
	});
		
		
	//setInterval(function(){public_lock_renewal();}, 10000);
	$(".J_ajax_close_btn").on('click', function (e) {
	    e.preventDefault();
	    Wind.use("artDialog", function () {
	        art.dialog({
	            id: "question",
	            icon: "question",
	            fixed: true,
	            lock: true,
	            background: "#CCCCCC",
	            opacity: 0,
	            content: "您确定需要关闭当前页面嘛？",
	            ok:function(){
					setCookie("refersh_time",1);
					window.close();
					return true;
				}
	        });
	    });
	});
	/////---------------------
	 Wind.use('validate', 'ajaxForm', 'artDialog', function () {
			//javascript
	        
	            //编辑器
	            editorcontent = new baidu.editor.ui.Editor();
	            editorcontent.render( 'description' );
	            //增加编辑器验证规则
	            jQuery.validator.addMethod('optionselect',function(v,e,p){
					return v!=0;
	            });
	            var form = $('form.J_ajaxForms');
	        //ie处理placeholder提交问题
	        if ($.browser.msie) {
	            form.find('[placeholder]').each(function () {
	                var input = $(this);
	                if (input.val() == input.attr('placeholder')) {
	                    input.val('');
	                }
	            });
	        }
	        //表单验证开始
	        form.validate({
				//是否在获取焦点时验证
				onfocusout:false,
				//是否在敲击键盘时验证
				onkeyup:false,
				//当鼠标掉级时验证
				onclick: false,
	            //验证错误
	            showErrors: function (errorMap, errorArr) {
					//errorMap {'name':'错误信息'}
					//errorArr [{'message':'错误信息',element:({})}]
					try{
						$(errorArr[0].element).focus();
						art.dialog({
							id:'error',
							icon: 'error',
							lock: true,
							fixed: true,
							background:"#CCCCCC",
							opacity:0,
							content: errorArr[0].message,
							cancelVal: '确定',
							cancel: function(){
								$(errorArr[0].element).focus();
							}
						});
					}catch(err){
					}
	            },
	            //验证规则
	            rules: {
					'supplier_id':{optionselect:true},
					'product_name':{required:1},
					'serial_no':{required:1},
					'keywords':{required:1},
					'abstract':{required:1},
					'features':{required:1},
					},
	            //验证未通过提示消息
	            messages: {
					'supplier_id':{optionselect:'请选择供应商'},
					'product_name':{required:'请输入标题'},
					'serial_no':{required:'请输入产品型号'},
					'keywords':{required:'请输入关键词'},
					'abstract':{required:'请输入摘要'},
					'features':{required:'请输入产品特性'},
					},
	            //给未通过验证的元素加效果,闪烁等
	            highlight: false,
	            //是否在获取焦点时验证
	            onfocusout: false,
	            //验证通过，提交表单
	            submitHandler: function (forms) {
					//选定分类项
					$('#value_category option').each(function(){this.selected=true;});

	                $(forms).ajaxSubmit({
	                    url: form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
	                    dataType: 'json',
	                    beforeSubmit: function (arr, $form, options) {
	                        try{
								editorcontent.sync();
							}catch(err){};
							//内容验证有问题，需要多加一次判断
							if(editorcontent.hasContents() == false){
								isalert('请输入内容');
								return false;
							}
							if($('input[name="photos_url[]"]').length < 1){
								isalert('请选择图片');
								return false;
							}
//							return true;
	                    },
	                    success: function (data, statusText, xhr, $form) {
	                        if(data.status){
								setCookie("refersh_time",1);
								//添加成功
								Wind.use("artDialog", function () {
								    art.dialog({
								        id: "succeed",
								        icon: "succeed",
								        fixed: true,
								        lock: true,
								        background: "#CCCCCC",
								        opacity: 0,
								        content: data.info,
										button:[
											{
												name: '确定',
												callback:function(){
													//reloadPage(window);
													return true;
												},
												focus: true
											}
										]
								    });
								});
							}else{
								isalert(data.info);
							}
	                    }
					});
	            }
	        });
	    });
	////-------------------------
});
</script>
</body>
</html>