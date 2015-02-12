<?php
namespace Home\Controller;
use Think\Controller;
// + ---------- ----------
// | 这是所有分类控制器
// | @author tan<admin@163.com>
// + ---------- ----------
class ContactusController extends CommonController {


	public function __construct() {
		parent::__construct ();
		$this->assign ( "css_style", "contact-us" );
		$this->assign ( 'title', 'Contact Us-ISweek.com' );
		$this->assign ( 'description', '' );
		$this->assign ( 'keywords', '' );
	}
	
	// + ---------- ----------
	// | 这是默认方法
	// | @author tan<admin@163.com>
	// + ---------- ----------
	public function index() {
		
		$this->display ();
	}

}
