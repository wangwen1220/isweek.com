<?php
namespace Admin\Controller;
use Think\Controller;
class TestController extends Controller {
    public function index(){
		$this->assign("SUBMENU_CONFIG", json_encode(D("Menu")->menu_json()));
		$this->display();
    }
	public function test() {
		echo T();
	}
}
