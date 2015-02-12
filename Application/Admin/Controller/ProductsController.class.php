<?php
namespace Admin\Controller;
class ProductsController extends AdminbaseController {
	protected $products_obj;
	protected $terms_relationship;
	protected $terms_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->products_obj = D("Products");
		$this->terms_obj = D("Terms");
		$this->suppliers_obj = D("Suppliers");
		//查询供应商数据
		$suppliers_obj = D("Suppliers");
		$suppliers = $suppliers_obj->field("id, name")->order("name ASC,listorder ASC")->select();
		$this->assign("suppliers",$suppliers);
		
// 		//自动修改seo信息为空的terms对象（理论上下面的要换成英文...........）
// 		$list_terms = $this->terms_obj->where('`seo_title` = "" or `seo_keywords` = "" or `seo_description` = ""')->select();
// 		//update sp_terms set seo_title='',seo_keywords='',seo_description=''
// 		foreach($list_terms as $vo){
// 			$data = array();
// 			$data['term_id'] = $vo['term_id'];
// 			$data['seo_title'] = $vo['name'] . '批发_' . $vo['name'] . '供应商_' . $vo['name'] . '厂家直销 - ISweek工采网';
// 			$data['seo_keywords'] = $vo['name'] . '厂家直销,' . $vo['name'] . '批发,' . $vo['name'] . '供应商';
// 			$data['seo_description'] = 'ISweek工采网供应' . $vo['name'] . '厂家直销代理、' . $vo['name'] . '批发、' . $vo['name'] . '供应商、' . $vo['name'] . '生产厂家批发等综合信息，查询' . $vo['name'] . '产品图、产品详细信息请上ISweek.';
// 			$this->terms_obj->save($data);
// 			//标题：***批发_***供应商_***厂家直销 - ISweek工采网
// 			//关键词：***厂家直销,***批发,***供应商
// 			//描述：ISweek工采网供应***厂家直销代理、***批发、***供应商、***生产厂家批发等综合信息，查询***产品图、产品详细信息请上ISweek.
// 			//var_dump($this->terms_obj->getLastSql());
// 		}
	}
	function index(){
		$this->_lists();
		$this->_getTree();
		$this->display();
	}
	
	function add(){
		if(isset($_COOKIE['params'])) {
			$params = cookie('params');
//			dump($params);
			//查询分类数据
			$selected_cate = $this->products_obj->getCategoryByIds($params['categorys']);
			$selected_cate_options = "";
			foreach($selected_cate as $v) {
				$selected_cate_options .= "<option value='$v[term_id]' >$v[name]</option>";
			}

			$this->assign("selected_cate_options",$selected_cate_options);

			$selected_cate = $this->products_obj->getSupplierByIds($params['supplier_id']);
			$selected_cate_options = "";
			foreach($selected_cate as $v) {
				$selected_cate_options .= "<option value='$v[id]' >$v[name]</option>";
			}
			$this->assign("selected_supplier_options",$selected_cate_options);
		}
		$this->_getTree();
		$this->display();
	}

	private function make_thumb($url) {
		$image = new \Think\Image();
		$image_path = str_replace(C('UPLOADPATH'),'',$url);
		$thumb_size = array("300","200", "100", "35");
		$thumb_name = substr($image_path, strrpos($image_path,'/')+1);
		$thumb_path = substr($image_path, 1, strrpos($image_path, '/')-1);
		foreach($thumb_size as $v) {
			//居中剪裁
			$image->open('./'.$url);
			$thumb_dir = "./Thumbs/".$v.'/'.$thumb_path.'/';
			if(!is_dir($thumb_dir)) {
				mkdir($thumb_dir, 0777, 1);
			}
			$thumb_file = $thumb_dir.$thumb_name;
			if(!file_exists($thumb_file)) {
				$image->thumb($v,$v, \Think\Image::IMAGE_THUMB_FILLED)->save($thumb_file);
			}
		}
	}

	
	function add_post(){
		if (IS_POST) {
//			echo json_encode(array('info'=>'asfdafsdaf','status'=> 0));
//			var_dump(I("post."));

			if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
				foreach ($_POST['photos_url'] as $key=>$url){
					$tmp['image_array'][] =array("url"=>$url,"alt"=>$_POST['photos_alt'][$key]);
					//缩略图处理TODO
					$this->make_thumb($url);
				}
			}

			//基本数据
			$products['supplier_ids']=isset($_POST['suppliers'])?','.implode(',',$_POST['suppliers']).',':'';
			$products['product_name']=$_POST['product_name'];
			$products['serial_no']=$_POST['serial_no'];
			$products['keywords']=$_POST['keywords'];
			$products['images']=json_encode($tmp['image_array']);
			//分类TODO
			$products['categorys']=isset($_POST['categorys'])?','.implode(',',$_POST['categorys']).',':'';

			$products['features']=$_POST['features'];
			$products['description']=$_POST['description'];
			$products['abstract']=$_POST['abstract'];
			$products['attachment']=$_POST['attachment'];

			//相关数据
			$products['post_member']=get_current_admin_id();
			if(!isset($_POST['post_time'])) {
				$products['post_time'] = time();
			} else {
				$products['post_time']=strtotime($_POST['post_time']);
			}
			$products['audit']=2; //默认为待审核产品


			//判断重复型号
			$serial_count = $this->products_obj->where("serial_no='".$_POST['serial_no']."'")->count();
//			echo $this->products_obj->getLastSql();
			if($serial_count > 0) {
				$this->error("存在相同产品型号!");
			}

			$result=$this->products_obj->add($products);
			if ($result) {
				//更新供应商的统计数据
				$this->suppliers_obj->updateCount($_POST['suppliers']);
				//更新分类表的统计数据
				$this->terms_obj->updateProductsCount($_POST['categorys']);

//				$this->success("添加成功",U("Products/add", array('params'=>json_encode(array('supplier_id'=>$products['supplier_id'], 'categorys'=>$products['categorys'])))));
				//添加params cookie
				cookie('params', array('supplier_id'=>$products['supplier_ids'], 'categorys'=>$products['categorys']));
				$this->success("添加成功");
			} else {
				$this->error("新增失败！");
			}
			 
		}
	}
	
	public function edit(){
		$id=(int) I("get.id");
		$this->_getTree();
		//查询产品数据
		$products=$this->products_obj->where("id=$id")->find();
		//查询供应商数据
		$suppliers_obj = D("Suppliers");
		$suppliers = $suppliers_obj->field("id, name")->order("name ASC,listorder ASC")->select();

		$selected_cate = $this->products_obj->getSupplierByIds($products['supplier_ids']);
		$selected_cate_options = "";
		foreach($selected_cate as $v) {
			$selected_cate_options .= "<option value='$v[id]' >$v[name]</option>";
		}
		$this->assign("selected_supplier_options",$selected_cate_options);

		//查询分类数据
		$selected_cate = $this->products_obj->getCategoryByIds($products['categorys']);
		$selected_cate_options = "";
		foreach($selected_cate as $v) {
			$selected_cate_options .= "<option value='$v[term_id]' >$v[name]</option>";
		}


		$this->assign("products",$products);
		$this->assign("selected_cate_options",$selected_cate_options);
		$this->assign("images",json_decode($products['images'],true));
		$this->display();
	}
	
	public function edit_post(){//修改产品信息
		//涉及到分类调整
		$terms_obj=D("Terms");
		if (IS_POST) {
			if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
				$image = new \Think\Image();
				foreach ($_POST['photos_url'] as $key=>$url){
					$tmp['image_array'][] =array("url"=>$url,"alt"=>$_POST['photos_alt'][$key]);
					//缩略图处理TODO
					$this->make_thumb($url);
				}
			}

			//基本数据
			$products['supplier_ids']=isset($_POST['suppliers'])?','.implode(',',$_POST['suppliers']).',':'';
			$products['product_name']=$_POST['product_name'];
			$products['serial_no']=$_POST['serial_no'];
			$products['keywords']=$_POST['keywords'];

			if($products['supplier_ids'] == '' || $products['product_name'] == '' || $products['serial_no'] == '' || $products['keywords'] == '') {
				$this->error("数据不完整");
			}

			$products['images']=json_encode($tmp['image_array']);
			//分类TODO
			$products['categorys']=isset($_POST['categorys'])?','.implode(',',$_POST['categorys']).',':'';

			$products['features']=$_POST['features'];
			$products['description']=$_POST['description'];
			$products['abstract']=$_POST['abstract'];
			$products['attachment']=$_POST['attachment'];

			//判断重复型号
			$serial_count = $this->products_obj->where("serial_no='".$_POST['serial_no']."' AND id!=" . I("post.id"))->count();
//			echo $this->products_obj->getLastSql();
			if($serial_count > 0) {
				$this->error("存在相同的产品型号!");
			}
			
			//相关数据
//			if(!isset($_POST['post_time'])) {
//				$products['post_time'] = time();
//			} else {
//				$products['post_time']=strtotime($_POST['post_time']);
//			}
			$products['edit_time']=time();
			if($_POST['audit'] == 0) {
				$products['audit'] = 2;
			}

			//调整分类统计数据TODO
			//查询原始分类数据，比较新旧数据的交集与补集
			//交集数据不做变更，旧数据与交集的补集数据减，新数据与交集的补集数据加

			//分类数据
			$old_categorys = $this->products_obj->field("categorys")->where("id=".I("post.id"))->find();
			$old_categorys_array = explode(',', trim($old_categorys['categorys'], ','));
			if($this->identical_values($old_categorys_array, $_POST['categorys'])) { //新旧分类相同不做处理
			} else {
				$intersect_categorys = array_intersect($old_categorys_array, $_POST['categorys']);
				$diff_categorys_with_old = array_diff($old_categorys_array, $intersect_categorys);
				$diff_categorys_with_new = array_diff($_POST['categorys'], $intersect_categorys);
				if(!empty($diff_categorys_with_old)) { //减去计数
					$this->terms_obj->updateProductsCount($diff_categorys_with_old, false);
				}
				if(!empty($diff_categorys_with_new)) { //增加计数
					$this->terms_obj->updateProductsCount($diff_categorys_with_new);
				}
			}
			//供应商数据
			$old_categorys = $this->products_obj->field("supplier_ids")->where("id=".I("post.id"))->find();
			$old_categorys_array = explode(',', trim($old_categorys['supplier_ids'], ','));
			if($this->identical_values($old_categorys_array, $_POST['suppliers'])) { //新旧分类相同不做处理
			} else {
				$intersect_categorys = array_intersect($old_categorys_array, $_POST['suppliers']);
				$diff_categorys_with_old = array_diff($old_categorys_array, $intersect_categorys);
				$diff_categorys_with_new = array_diff($_POST['suppliers'], $intersect_categorys);
				if(!empty($diff_categorys_with_old)) { //减去计数
					$this->suppliers_obj->updateCount($diff_categorys_with_old, false);
				}
				if(!empty($diff_categorys_with_new)) { //增加计数
					$this->suppliers_obj->updateCount($diff_categorys_with_new);
				}
			}


			$this->products_obj->where("id=".I("post.id"))->save($products);
			if ($result!==false) {
				$this->success("保存成功！");
			} else {
				$this->error("保存失败！");
			}
		}
	}

	private function identical_values( $arrayA , $arrayB ) { 

	    sort( $arrayA ); 
	    sort( $arrayB ); 

	    return $arrayA == $arrayB; 
	} 	

	//排序
	public function listorders() {
		$status = parent::listorders($this->products_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	private  function _lists(){
		//默认待审核列表页
		
		$fields=array(
			'category' => array("field"=>"p.categorys","operator"=>"super like"),
			'start_time'=> array("field"=>"p.post_time","operator"=>">"),
			'end_time'  => array("field"=>"p.post_time","operator"=>"<"),
			'keyword'  => array("field"=>"p.products_name","operator"=>"like"),
		);
			
		//搜索条件
		$where = "1 ";
		$list_type = 0;
		if(isset($_REQUEST['audit']) && $_REQUEST['audit'] == 0) { //审核未通过
			$where .= " AND p.audit = 0 ";
			$list_type = 1;
		}
		if(isset($_REQUEST['audit']) && $_REQUEST['audit'] == 2) { //待审核产品
			$where .= " AND p.audit = 2 ";
			$list_type = 2;
		}
		if(isset($_REQUEST['status']) && $_REQUEST['status'] == 0) { //下架产品
			$where .= " AND p.status = 0 ";
			$list_type = 3;
		}
		if(isset($_REQUEST['status']) && $_REQUEST['status'] == 1) { //上架产品
			$where .= " AND (p.status = 1 AND p.audit!=2) ";
			$list_type = 4;
		}
		$this->assign('list_type', $list_type);

		//表单条件
		if(!empty($_REQUEST['category'])) {
			$res = $this->terms_obj->field("term_id")->where("CONCAT('-', path, '-') LIKE '%-".$_REQUEST['category']."-%'")->select();
			$category_link = array_unique(array_map(create_function('$v', 'return $v[term_id];'), $res));
//			dump($category_link);
			$flag = '';
			$category_link_or = '';
			foreach ($category_link as $v) {
				$category_link_or .= $flag." p.categorys LIKE '%,".$v.",%' ";
				$flag = " OR ";
			}
			if ($category_link_or != '') {
				$where .= " AND ($category_link_or)";
			}
		}
		if(!empty($_REQUEST['start_time'])) {
			$where .= " AND p.post_time >=".strtotime($_REQUEST['start_time']);
		}
		if(!empty($_REQUEST['end_time'])) {
			$where .= " AND p.post_time <=".(strtotime($_REQUEST['end_time'])+3600*24);
		}
		if(!empty($_REQUEST['keyword'])) {
			$_REQUEST['keyword'] = trim(urldecode($_REQUEST['keyword']));
			switch($_REQUEST['keyword_type']) {
			case 1:
				$where .= " AND p.product_name LIKE '%".$_REQUEST['keyword']."%'";
				break;
			case 2:
				$where .= " AND p.serial_no LIKE '%".$_REQUEST['keyword']."%'";
				break;
			case 3:
				$where .= " AND p.keywords LIKE '%".$_REQUEST['keyword']."%'";
				break;
			case 4:
				$where .= " AND p.description LIKE '%".$_REQUEST['keyword']."%'";
				break;
			default:
				break;
			}
		}
		if(!empty($_REQUEST['recommend'])) {
			if($_REQUEST['recommend'] == 1) { //推荐
				$where .= " AND p.recommend=1";
			} else if($_REQUEST['recommend'] == 2) { //不推荐
				$where .= " AND p.recommend=0";
			}
		}
		if(!empty($_REQUEST['supplier'])) {
			$where .= " AND p.supplier_ids LIKE '%,".$_REQUEST['supplier'].",%'";
		}
		if(!empty($_REQUEST['attachment'])) {
			$where .= " AND p.attachment!=''";
		}
		$_GET = $_REQUEST;
			
		$count=$this->products_obj
			->alias("p")
			->where($where)
			->count();
			
		$page = $this->page($count, 20);

		$col = array(
			"p.id"=>"id",
			"product_name",
			"serial_no",
			"images",
			"categorys",
//			"s.name"=>"supplier_name",
//			"s.status"=>"supplier_status",
			"supplier_ids",
			"attachment",
			"post_time",
			"audit_time",
			"edit_time",
			"recommend",
			"p.status",
			"p.listorder",
		);
		$products = $this->products_obj
			->field($col)
			->alias("p")
//			->join(C('DB_PREFIX')."suppliers s ON p.supplier_id=s.id", "LEFT")
			->where($where)
			->limit($page->firstRow . ',' . $page->listRows)
			->order("p.post_time DESC,p.listorder ASC")
			->select();
//		echo $this->products_obj->getLastSql();
			
		foreach ($products as $k=>$v) {
			//图片，取第一张
			$t = json_decode($v['images'],true);
			$products[$k]['thumb'] = $t[0];
			//公司
			$map = array();
			$map['id'] = array("in", trim($v['supplier_ids'],","));
			$suppliers = $this->suppliers_obj->field("name,status")->where($map)->select();
			$suppliers_string = implode(",", array_map(create_function('$item','if($item["status"] ==1){return $item["name"];}else{return "<font style=\"color:red;text-decoration: line-through;\">".$item["name"]."</font>";}'), $suppliers));
			$products[$k]['suppliers_str'] = $suppliers_string;
			//分类
			$map = array();
			$map['term_id'] = array("in", trim($v['categorys'],","));
			$terms = $this->terms_obj->field("name")->where($map)->select();
			$terms_string = implode(",", array_map(create_function('$item','return $item["name"];'), $terms));
			$products[$k]['terms_str'] = $terms_string;

		}
//		dump($products);
		$this->assign("products",$products);
		$this->assign("Page", $page->show('Admin'));
		$this->assign("current_page",$page->GetCurrentPage());
		$this->assign("formget",$_REQUEST);
	}
	
	private function _getTree(){
		$category_id=$_REQUEST['category'];
		$result = $this->terms_obj->order(array("listorder"=>"asc"))->select();
		
		$tree = new \Org\Cmf\Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			$r['selected']=$category_id==$r['id']?"selected":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$categorys = $tree->get_tree(0, $str);
		$this->assign("categorys", $categorys);
	}
	
	function delete(){
		if(isset($_GET['id'])){
			$tid = I("get.id");
			$categorys = trim($this->products_obj->getFieldById($tid, 'categorys'), ',');
			if ($this->products_obj->where("id=$tid")->delete()) {
				//更新分类表的统计数据
				$this->terms_obj->updateProductsCount(explode(',',$categorys), 0);
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
		if(isset($_POST['ids'])){
			$tids=join(",",$_POST['ids']);
			foreach($_POST['ids'] as $v) {
				$categorys = trim($this->products_obj->getFieldById($v, 'categorys'), ',');
				//更新分类表的统计数据
				$this->terms_obj->updateProductsCount(explode(',',$categorys), 0);
			}
			if ($this->products_obj->where("id in ($tids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}
	
	function show(){
		if(isset($_POST['ids']) && $_GET["check"]){
			$data["status"]=1;
			
			$tids=implode(",",$_POST['ids']);
			if ( $this->products_obj->where("ID in ($tids)")->save($data)) {
				$this->success("上架成功！");
			} else {
				$this->error("上架失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["uncheck"]){
			
			$data["status"]=0;
			$tids=join(",",$_POST['ids']);
			if ( $this->products_obj->where("ID in ($tids)")->save($data)) {
				$this->success("下架成功！");
			} else {
				$this->error("下架失败！");
			}
		}
	}
	function recommend(){
		$data["recommend_time"]=time();
		if(isset($_POST['ids']) && $_GET["check"]){
			$data["recommend"]=1;
			
			$tids=implode(",",$_POST['ids']);
			if ( $this->products_obj->where("ID in ($tids)")->save($data)) {
				$this->success("推荐成功！");
			} else {
				$this->error("推荐失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["uncheck"]){
			
			$data["recommend"]=0;
			$tids=join(",",$_POST['ids']);
			if ( $this->products_obj->where("ID in ($tids)")->save($data)) {
				$this->success("取消推荐成功！");
			} else {
				$this->error("取消推荐失败！");
			}
		}
	}
	function audit(){
		//审核
		//需要检验该公司的禁用状态，若为禁用，则status为0，不予上架TODO
		if(isset($_POST['ids']) && $_GET["check"]){
			foreach($_POST['ids'] as $k=>$v) {
				//公司
				$model = M("products");
				$res = $model->where("id=$v")->field("supplier_ids")->find();
//				var_dump($res);
				$map = array();
				$map['id'] = array("in", trim($res['supplier_ids'],","));
				$suppliers = $this->suppliers_obj->field("status")->where($map)->select();
				$suppliers_status = 1;
				foreach ($suppliers as $val) {
					$suppliers_status &= $val['status'];
				}

//				var_dump($suppliers_status);
				if($suppliers_status != 1) {
					unset($_POST['ids'][$k]);
				}
			}
			$data["audit"]=1;
			$data["status"] = 1;
			//更新审核者与审核时间
			$data["audit_member"] = session("ADMIN_ID");
			$data["audit_time"] = time();
			
			$tids=implode(",",$_POST['ids']);
			if ( $this->products_obj->where("ID in ($tids)")->save($data)) {
				$this->success("审核成功！");
			} else {
				$this->error("审核失败！".($suppliers_status == 0?'公司被禁用':''));
			}
		}
		//取消审核
		if(isset($_POST['ids']) && $_GET["uncheck"]){
			
			$data["audit"]=0;
			$data["status"] = 0;
			//更新审核者与审核时间
			$data["audit_member"] = session("ADMIN_ID");
			$data["audit_time"] = time();

			$tids=join(",",$_POST['ids']);
			if ( $this->products_obj->where("ID in ($tids)")->save($data)) {
				$this->success("取消审核成功！");
			} else {
				$this->error("取消审核失败！");
			}
		}
	}
	
}
