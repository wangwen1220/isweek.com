<?php
namespace Home\Controller;
use Think\Controller;
// + ---------- ----------
// | 空模块空操作
// | @author tan<admin@163.com>
// + ---------- ----------
class EmptyController extends Controller {


	public function index() {
		$this->_empty ();
		exit ();
	}


	/**
	 * 空操作
	 * 例如http://www.isweek.com/index.php/productaaaaaaaa/fdsadsafsdafds
	 */
	public function _empty() {
		@header ( "http/1.1 404 not found" );
		@header ( "status: 404 not found" );
		// @header ( "Location:" . APP_404_URL );
		// exit ();
		$this->display ( 'Public:404' );
		exit ();
	}

}
