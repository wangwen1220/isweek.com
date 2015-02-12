<?php
namespace Admin\Controller;
use Think\Controller;
class AjaxController extends Controller {
	protected $products_obj;
	function _initialize() {
		$this->products_obj = D("Products");
	}
	//型号判断
	public function check_serial_no() {
		if(IS_POST) {
			$serial_no = I("post.val");
			$id = I("post.id");
			if($id != "") {
				$serial_count = $this->products_obj->where("serial_no='".$serial_no."' AND id!=".$id)->count();
			} else {
				$serial_count = $this->products_obj->where("serial_no='".$serial_no."'")->count();
			}
//			echo $this->products_obj->getLastSql();
			if($serial_count > 0) {
				$this->error("存在相同的产品型号");
			} else {
				$this->success("成功");
			}
		}
	}
}
