<?php
namespace Home\Controller;
use Think\Controller;
// + ---------- ----------
// | 这是单页面控制器
// | @author tan<admin@163.com>
// + ---------- ----------
class PageController extends CommonController {
	
	// + ---------- ----------
	// | 联系我们
	// | @author tan<admin@163.com>
	// + ---------- ----------
	public function contact() {
		
		$this->assign ( 'css_style', 'article' );
		
		$this->display ();
	}

}