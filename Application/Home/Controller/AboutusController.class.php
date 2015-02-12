<?php
namespace Home\Controller;
use Think\Controller;
// + ---------- ----------
// | 这是所有分类控制器
// | @author tan<admin@163.com>
// + ---------- ----------
class AboutusController extends CommonController {


	public function __construct() {
		parent::__construct ();
		$this->assign ( "css_style", "about-us" );
		$this->assign ( 'title', 'About Us-ISweek.com' );
		$this->assign ( 'description', 'industry sourcing, electronics and industrial products wholesaler, electronics products wholesaler, electronics products purchase' );
		$this->assign ( 'keywords', 'ISweek is an industry sourcing wholesale supplier that sells industrial products and electronic products to global buyers. You can buy high quality products at the best wholesale price right here' );
	}
	
	// + ---------- ----------
	// | 这是默认方法
	// | @author tan<admin@163.com>
	// + ---------- ----------
	public function index() {
		$this->display ();
	}

}
