<?php
namespace Admin\Controller;
class IndexController extends AdminbaseController {
	function _initialize() {
		parent::_initialize();
		$this->initMenu();
		$this->terms_obj = D("Terms");
		$this->products_obj = D("Products");
	}
    public function index(){
		//此处加产品数的统计程序
		//TODO:当天只触发执行一次
		//供应商数据

		$this->updateSupplierProductsCount();
		$this->updateTermProductsCount();



		$this->assign("SUBMENU_CONFIG", json_encode(D("Menu")->menu_json()));
		$this->display();
    }

	private function updateTermProductsCount() {
		$terms_obj = D("Terms");
		$terms_obj->execute("update __TERMS__ set count=0");
		//控制仅统计上架产品数，调整统计数据可在此处理
		$all_products = $this->products_obj->where("status=1")->field("categorys")->select();
		foreach($all_products as $v) {
			$terms_obj->updateProductsCount(explode(',',$v['categorys']));
		}
	}

	private function updateSupplierProductsCount() {
		$all_products = $this->products_obj->field("supplier_ids")->select();
		$statistic = array();
		foreach($all_products as $v) {
			if(preg_match('/\d+/', $v['supplier_ids'])) {
				$supplier_ida = explode(',',trim($v['supplier_ids'],','));
				foreach ($supplier_ida as $val) {
					$statistic[$val]++;
				}
				
			}
		}
		if(!empty($statistic)) {
			foreach($statistic as $k=>$v) {
				$sql = "update __SUPPLIERS__ set count=$v where id=$k";
				$this->products_obj->execute($sql);
			}
			//更新其它供应商数据为0
			$sql = "update __SUPPLIERS__ set count=0 where id NOT IN (".implode(",", array_keys($statistic)).")";
			$this->products_obj->execute($sql);
		}
	}
}
