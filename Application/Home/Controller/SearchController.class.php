<?php
namespace Home\Controller;
use Think\Controller;
// + ---------- ----------
// | 这是产品搜索控制器
// | @author tan<admin@163.com>
// + ---------- ----------
class SearchController extends CommonController {
	private $products_obj;


	public function __construct() {
		parent::__construct ();
		$this->products_obj = M ( "Products" );
		
		// 模板样式赋值
		$this->assign ( "css_style", "search" );
	}


	public function index() {
		$this->search ();
		$this->display ();
	}


	/**
	 * 搜索过关键字处理（过滤特殊符号）
	 * @param unknown $keyword
	 * @return mixed
	 */
	private function _getkwd($keyword) {
		$keyword = str_replace ( '\'', '', $keyword );
		$keyword = str_replace ( '"', '', $keyword );
		$keyword = str_replace ( '?', '', $keyword );
		$keyword = str_replace ( '`', '', $keyword );
		//$keyword = str_replace ( '%', '', $keyword );
		//$keyword = str_replace ( '!', '', $keyword );
		//$keyword = str_replace ( '#', '', $keyword );
		//$keyword = str_replace ( '-', '', $keyword );
		return $keyword;
	}


	private function search() { // 搜索处理
		/* $keyword = htmlspecialchars_decode ( trim ( I ( "get.kw" ) ) );
		// 允许搜索的字体
		$keyword = preg_replace ( "/[^\w -]+/", "", $keyword );
		// $keyword = preg_replace("/\W+/","",$keyword); */
		$keyword = htmlspecialchars_decode ( trim ( I ( "get.kw" ) ) );
		$keyword = $this->_getkwd ( $keyword ); // 对关键字进行处理
		$_GET ['kw'] = stripslashes ( $_GET ['kw'] );
		$category = I ( "get.cid" );
		if (isset ( $_REQUEST ['perpage'] )) {
			$perpage = intval ( $_REQUEST ['perpage'] ) > 0 ? intval ( $_REQUEST ['perpage'] ) : 60;
		} else if (isset ( $_COOKIE ['perpage'] )) {
			$perpage = intval ( $_COOKIE ['perpage'] ) > 0 ? intval ( $_COOKIE ['perpage'] ) : 60;
		} else {
			$perpage = 60;
		}
		cookie ( 'perpage', $perpage, 3600 );
		// var_dump($keyword, $category, $perpage);
		$where_and = " `audit`=1 and `status`=1 ";
		if ($keyword != '') {
			$where_and .= " AND (`product_name` LIKE '%$keyword%' OR `serial_no` LIKE '%$keyword%' OR `keywords` LIKE '%$keyword%' OR `features` LIKE '%$keyword%' OR `abstract` LIKE '%$keyword%' OR `description` LIKE '%$keyword%')";
		}
		if ($category > 0) {
			// 搜索该分类的路径，找出子类
			$terms_obj = M ( "Terms" );
			$cate_path = $terms_obj->getFieldByTermId ( $category, 'path' );
			$categorys_array = $terms_obj->field ( 'term_id' )->where ( "path LIKE '" . $cate_path . "%'" )->select ();
			$cids_options = implode ( ' OR ', array_map ( create_function ( '$item', 'return " `categorys` LIKE \'%,".$item[term_id].",%\'";' ), $categorys_array ) );
			
			$where_and .= " AND ($cids_options)";
		}
		
		$count = $this->products_obj->where ( $where_and )->count ();
		$page = $this->page ( $count, $perpage );
		
		$res = $this->products_obj->where ( $where_and )->order ( 'edit_time DESC' )->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		// echo $this->products_obj->getLastSql();
		foreach ( $res as $k => $vo ) {
			if (! empty ( $vo ['images'] )) {
				$res [$k] ['images'] = json_decode ( $vo ['images'], true );
				$res [$k] ['thumb'] = $res [$k] ['images'] [0];
				$res [$k] ['thumb_200'] = $this->get_thumb ( $res [$k] ['images'] [0] ['url'], 200 );
			}
		}
		
		$this->assign ( 'title', 'Search Products - ISweek.com' );
		$this->assign ( "products", $res );
		$this->assign ( "keyword", $keyword );
		$this->assign ( "page", $page->show ( 'Front' ) );
		$this->assign ( "current_page", $page->GetCurrentPage () );
		$this->assign ( "products_count", $count );
		$this->assign ( "curr_search_cid", $category );
		$this->assign ( "perpage", $perpage );
		// dump($res);
	}

}