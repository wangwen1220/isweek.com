<?php
namespace Admin\Controller;
class SupplierController extends AdminbaseController {
	protected $suppliers_obj;
	function _initialize() {
		parent::_initialize();
		$this->suppliers_obj = D("Suppliers");
		$this->initMenu();
	}
    public function index(){
		$this->_lists();
		$this->display();
    }
    public function add(){
		$this->display();
    }
    public function add_post(){
		if (IS_POST) {
			$suppliers['name'] = I("post.name");
			$suppliers['code'] = I("post.code");
			$suppliers['status'] = 1;//默认启用状态
			
			//查询重复
			if($this->suppliers_obj->where(array('name'=>I("post.name")))->count() > 0) {
				$this->error("新增失败！此公司已存在");
			}
			if($this->suppliers_obj->where(array('code'=>I("post.code")))->count() > 0) {
				$this->error("新增失败！此编码已存在");
			}


			$suppliers['create_time'] = time();
			$result = $this->suppliers_obj->add($suppliers);
			if ($result) {
				//更新分类表的统计数据TODO
				$this->success("新增成功！");
			} else {
				$this->error("新增失败！");
			}
		}
    }
	public function edit(){
		$id=(int) I("get.id");
		//查询供应商数据
		$supplier = $this->suppliers_obj->where("id=$id")->find();

		$this->assign("supplier",$supplier);
		$this->display();
	}
	
	public function edit_post(){
		if (IS_POST) {
			//查询重复
			if($this->suppliers_obj->where(array('name'=>I("post.name"), 'id'=>array('NEQ',I("post.id"))))->count() > 0) {
				$this->error("修改失败！此公司已存在");
			}
			if($this->suppliers_obj->where(array('code'=>I("post.code"), 'id'=>array('NEQ',I("post.id"))))->count() > 0) {
				$this->error("修改失败！此编码已存在");
			}

			$result=$this->suppliers_obj->save(I("post."));
//			echo($this->suppliers_obj->getLastSql());die;
			if ($result!==false) {
				$this->success("保存成功！");
			} else {
				$this->error("保存失败！");
			}
		}
	}
	private  function _lists($status=1){
		
		$where_ands = array();
		//条件组合
		$fields=array(
			'keyword'  => array("field"=>"name","operator"=>"like"),
		);

		foreach ($fields as $param =>$val){
			if (isset($_REQUEST[$param]) && !empty($_REQUEST[$param])) {
				$operator=$val['operator'];
				$field   =$val['field'];
				$get=$_REQUEST[$param];
				$_GET[$param]=$get;
				if($operator=="like"){
					$get="%$get%";
				}
				array_push($where_ands, "$field $operator '$get'");
			}
		}
		
		$where= join(" and ", $where_ands);
			
			
		$count=$this->suppliers_obj
		->where($where)
		->count();
			
		$page = $this->page($count, 20);

		$suppliers = $this->suppliers_obj
			->where($where)
			->limit($page->firstRow . ',' . $page->listRows)
			->order("name ASC,listorder ASC")->select();
			
		$this->assign("suppliers",$suppliers);
		$this->assign("Page", $page->show('Admin'));
		$this->assign("current_page",$page->GetCurrentPage());
		$this->assign("formget",$_GET);
	}

	public function check(){
		$supplier_ids = I("post.ids");
		$products_obj = D("Products");

		$map['id'] = array("IN", $supplier_ids);

		$flag = '';
		$options_or = '';
		foreach ($supplier_ids as $v) {
			$options_or .= $flag." supplier_ids LIKE '%,".$v.",%' ";
			$flag = " OR ";
		}
		if ($options_or != '') {
			$where = "1 AND ($options_or)";
		} else {
			$this->error("禁用失败！供应商数据出错！");
		}
		if(isset($_POST['ids']) && $_GET["check"]){
			$data["status"]=1;
			$msg = "启用";
			//需要将产品状态改为上架
			$products_obj->where($where)->save($data);
			
		}
		if(isset($_POST['ids']) && $_GET["uncheck"]){
			$data["status"]=0;
			$msg = "禁用";
			//需要将产品状态改为下架
			$products_obj->where($where)->save($data);
		}
		if ( $this->suppliers_obj->where($map)->save($data)) {
			$this->success($msg."成功！");
		} else {
			$this->error($msg."失败！");
		}
	}
	public function delete(){
		if(isset($_GET['id'])){
			$id = I("get.id");
			if ($this->suppliers_obj->where("id=$id")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
		if(isset($_POST['ids'])){
			$map['id'] = array("IN", I("post.ids"));
			if ($this->suppliers_obj->where($map)->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}

	public function listorders() {
		$status = parent::listorders($this->suppliers_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
}
