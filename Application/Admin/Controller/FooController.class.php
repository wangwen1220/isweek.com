<?php
namespace Admin\Controller;
class FooController extends AdminbaseController {
	function _initialize() {
		parent::_initialize();
		$this->initMenu();
	}
    //后台框架首页
    public function index() {
        $this->assign("SUBMENU_CONFIG", json_encode(D("Menu")->menu_json()));
       	$this->display();
        
    }
}
