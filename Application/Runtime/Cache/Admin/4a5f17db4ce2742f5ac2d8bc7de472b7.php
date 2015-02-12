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
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <div class="nav">
    <ul class="cc">
      <li class="<?php if(!isset($_REQUEST['status']) && !isset($_REQUEST['audit'])): ?>current<?php endif; ?>"><a href="<?php echo U('products/index');?>">所有产品</a></li>
	  <li class="<?php if(isset($_REQUEST['audit']) && $_REQUEST['audit']==2): ?>current<?php endif; ?>"><a href="<?php echo U('products/index', array('audit'=>'2'));?>">待审产品</a></li>
	  <li class="<?php if(isset($_REQUEST['audit']) && $_REQUEST['audit']==0): ?>current<?php endif; ?>"><a href="<?php echo U('products/index', array('audit'=>'0'));?>">审核未通过</a></li>
	  <li class="<?php if(isset($_REQUEST['status']) && $_REQUEST['status']==1): ?>current<?php endif; ?>"><a href="<?php echo U('products/index', array('status'=>'1'));?>">上架产品</a></li>
	  <li class="<?php if(isset($_REQUEST['status']) && $_REQUEST['status']==0): ?>current<?php endif; ?>"><a href="<?php echo U('products/index', array('status'=>'0'));?>">下架产品</a></li>
	  </ul>
  </div>
  <div class="h_a">搜索</div>
  <form  method="post" action="<?php echo u('products/index');?>">
    <?php if(isset($_REQUEST['audit'])): ?><input name="audit" type="hidden" value="<?php echo I('audit');?>" /><?php endif; ?>
    <?php if(isset($_REQUEST['status'])): ?><input name="status" type="hidden" value="<?php echo I('status');?>" /><?php endif; ?>    
	<div class="search_type cc mb10">
      <div class="mb10"> 
        <span class="mr20">分类：
        <select class="select_2" name="category">
          	<option value='0' >全部</option>
			<?php echo ($categorys); ?>
        </select>
        &nbsp;&nbsp;时间：
        <input type="text" name="start_time" class="input length_2 J_date" value="<?php echo ($formget["start_time"]); ?>" style="width:80px;" autocomplete="off">-<input type="text" class="input length_2 J_date" name="end_time" value="<?php echo ($formget["end_time"]); ?>" style="width:80px;" autocomplete="off">
        
        <!-- 
        <select class="select_2" name="searchtype" style="width:70px;">
          <option value='0' >标题</option>
        </select>
         -->
               &nbsp; &nbsp;关键字：
        <input type="text" class="input length_2" name="keyword" style="width:200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入关键字...">
		<select name="keyword_type" class="select_2">
		<option value="1" <?php if($_POST[keyword_type]==1): ?>selected="selected"<?php endif; ?>>Product Name</option>
		<option value="2" <?php if($_POST[keyword_type]==2): ?>selected="selected"<?php endif; ?>>Module Number</option>
		<option value="3" <?php if($_POST[keyword_type]==3): ?>selected="selected"<?php endif; ?>>Keyword</option>
		<option value="4" <?php if($_POST[keyword_type]==4): ?>selected="selected"<?php endif; ?>>Description</option>
		</select>
		
		&nbsp;&nbsp;
		推荐：
		<select name="recommend" class="select_2">
		<option value="0">ALL</option>
		<option value="1" <?php if($_POST[recommend]==1): ?>selected="selected"<?php endif; ?>>Recommend</option>
		<option value="2" <?php if($_POST[recommend]==2): ?>selected="selected"<?php endif; ?>>Not Recommend</option>
		</select>

        </span>
      </div>

	  <div class="mb10">
        <span class="mr20">供应商：
		<select name="supplier" class="select_2">
		<option value="0" >Select</option>
		<?php if(is_array($suppliers)): foreach($suppliers as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo[id]==$formget[supplier]) {echo 'selected="selected"';} ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
		</select>

		&nbsp;&nbsp;<input type="checkbox" name="attachment" value="1" id="attachment" /><label for="attachment">附件</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" class="btn" value="搜索"/>
		</span>
	  </div>

	  <div class="mb10">
        <span class="mr20">
		</span>
	  </div>

    </div>
  </form>
  <form class="J_ajaxForm" action="" method="post">
    <div class="table_list">
      <table width="100%">
        <thead>
	          <tr>
	            <td width="16"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
	            <!--<td width="50">排序</td>-->
	            <td width="40">ID</td>
	            <td>标题/推荐/附件/型号</td>
				<td>缩略图</td>
				<td width="120">分类</td>
	            <td width="80">公司名称</td>
	            <td width="120"><span><font color="red" title="最后发布">发布</font>/<font color="green" title="最后修改">编辑</font>/<font color="blue" title="审核时间">审核时间</font></span></td>
	            <td width="40">状态</td>
	            <td width="80">操作</td>
	          </tr>
        </thead>
        	<?php $status=array("1"=>"上架","0"=>"下架"); ?>
        	<?php if(is_array($products)): foreach($products as $key=>$vo): ?><tr>
		            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>" ></td>
		            <!--<td><input name='listorders[<?php echo ($vo["id"]); ?>]' class="input mr5"  type='text' size='3' value='<?php echo ($vo["listorder"]); ?>'></td>-->
		            <td><a><?php echo ($vo["id"]); ?></a></td>
		            <td><a href="<?php echo U('Admin/Audit/index',array('id'=>$vo['id']));?>" target="_blank" title="标题：<?php echo ($vo["product_name"]); ?>">
		            	<span style="" ><?php echo ($vo["product_name"]); ?></span></a>
		            	<?php echo ($recommend[$vo['recommend']]); ?>
		            	<?php if($vo['recommend']==1){ echo '<font color="blue" title="该产品已被设置为推荐">[荐]</font>'; } ?>
		            	<?php if(!empty($vo['attachment'])){ echo '<a href="'.$vo[attachment].'" target="_blank"><font color="red" title="点击下载相关附件">[附]</font></a>'; } ?><br/>
		            	<font title="型号：<?php echo ($vo["serial_no"]); ?>"><?php echo ($vo["serial_no"]); ?></font>
		            </td>
					<td><img src="<?php echo ($vo["thumb"]["url"]); ?>" width="60" height="60" /></td>
					<td><?php echo ($vo["terms_str"]); ?></td>
		            <td><?php echo ($vo["supplier_name"]); ?></td>
		            <td>
		            	<?php if(!empty($vo['post_time'])){ ?><font color="red" title="最后发布"><?php echo (date("Y-m-d G:i:s", $vo["post_time"])); ?></font><?php } ?><br/>
		            	<?php if(!empty($vo['edit_time'])){ ?><font color="green" title="最后修改"><?php echo (date("Y-m-d G:i:s", $vo["edit_time"])); ?></font><?php } ?><br/>
		            	<?php if(!empty($vo['audit_time'])){ ?><font color="blue" title="审核时间"><?php echo (date("Y-m-d G:i:s", $vo["audit_time"])); ?></font><?php } ?>
		            </td>
		            <td><?php echo ($status[$vo['status']]); ?></td>
		            <td>
		            	<a href="<?php echo U('products/edit',array('id'=>$vo[id]));?>" target="_blank" <?php echo ($edit_act); ?>>修改</a>|
		            	<a href="<?php echo U('products/delete',array('id'=>$vo[id]));?>" class="J_ajax_del" <?php echo ($delete_act); ?>>删除</a>
					</td>
	          	</tr><?php endforeach; endif; ?>
          </table>
      <div class="p10"><div class="pages"> <?php echo ($Page); ?> </div> </div>
     
    </div>
    <div>
      <div class="btn_wrap_pd">
        <label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>                
        <!--<button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo u('products/listorders');?>" <?php echo ($listorders_act); ?>>排序</button>-->
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo u('products/audit',array('check'=>1));?>" data-subcheck="true" <?php echo ($audit_act); ?>>审核</button>
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo u('products/audit',array('uncheck'=>1));?>" data-subcheck="true" <?php echo ($audit_act); ?>>审核未通过</button>
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo u('products/recommend',array('check'=>1));?>" data-subcheck="true" <?php echo ($recommend_act); ?>>推荐</button>
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo u('products/recommend',array('uncheck'=>1));?>" data-subcheck="true" <?php echo ($recommend_act); ?>>取消推荐</button>
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo u('products/show',array('check'=>1));?>" data-subcheck="true" <?php echo ($show_act); ?>>上架</button>
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo u('products/show',array('uncheck'=>1));?>" data-subcheck="true" data-subcheck="true" data-msg="你确定下架吗？"  <?php echo ($show_act); ?>>下架</button>
        <button class="btn J_ajax_submit_btn" type="submit" data-action="<?php echo u('products/delete');?>" data-subcheck="true" data-msg="你确定删除吗？" <?php echo ($delete_act); ?>>删除</button>
      </div>
    </div>
  </form>
</div>
<script src="/statics/js/common.js<?php echo ($js_debug); ?>"></script>
<script>

function refersh_window() {
    var refersh_time = getCookie('refersh_time');
    if (refersh_time == 1) {
        window.location="<?php echo u('products/index',$formget);?>";
    }
}
setInterval(function(){
	refersh_window();
}, 2000);
$(function () {
	setCookie("refersh_time",0);
    Wind.use('ajaxForm','artDialog','iframeTools', function () {
        //批量移动
        $('#J_Content_remove').click(function (e) {
            var str = 0;
            var id = tag = '';
            $("input[name='ids[]']").each(function () {
                if ($(this).attr('checked')) {
                    str = 1;
                    id += tag + $(this).val();
                    tag = ',';
                }
            });
            if (str == 0) {
				art.dialog.through({
					id:'error',
					icon: 'error',
					content: '您没有勾选信息，无法进行操作！',
					cancelVal: '关闭',
					cancel: true
				});
                return false;
            }
            var $this = $(this);
            art.dialog.open("/index.php?g=admin&m=post&a=move&ids=" + id, {
                title: "批量移动"
            });
        });
    });
});


</script>
</body>
</html>