<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
// + ---------- ----------
// | 这是产品分类控制器
// | @author tan<admin@163.com>
// + ---------- ----------
class CategoryController extends CommonController {


	public function __construct() {
		
		parent::__construct ();
		
		$this->assign ( "css_style", "home" );
	}
	
	// + ---------- ----------
	// | 这是默认方法（列表）
	// | @author tan<admin@163.com>
	// + ---------- ----------
	public function index() {
		
		$term_id = intval ( $_REQUEST ['cid'] ); // 分类ID
		
		if ($term_id > 0) {
			
			$term = D ( 'Terms' )->find ( $term_id );
			
			if (empty ( $term )) {
				@header ( "http/1.1 404 not found" );
				@header ( "status: 404 not found" );
				$this->display ( 'Public:404' );
				exit ();
			}
			//var_dump($_REQUEST['name'],$_REQUEST['cid']);echo '<hr/>';
			
			//判断URL中的分类名称是否正确，否则自动修正URL--begin
			
			$can = '';//?后面的参数
			if(isset($_REQUEST['perpage'])){
				if(empty($can)){
					$can .= 'perpage='.intval($_REQUEST['perpage']);
				}else{
					$can .= '&perpage='.intval($_REQUEST['perpage']);
				}
			}
			if(!empty($can)){
				$can = '?'.$can;
			}
			
			$p = isset($_REQUEST['p'])?intval($_REQUEST['p']):-1;
			if($p==0 || $p==1){
				//若有分页代码，且分页的页码<2
				header("location: http://www.isweek.com" . rw_category_url($term['name'], $term_id) . $can );
				exit;
			}
			
			//正确的url中应该存在的字符串
			$rw_name = rw_category_url($term['name'], $term_id);
			$rw_name = str_replace('/wholesale/', '', $rw_name);
			
			//传递的url部分
			$rw_name2 = isset($_REQUEST['name'])?trim($_REQUEST['name']):'';
			$rw_name2 = $rw_name2 . '_' . $term_id;
			
			if($p>1){
				//有分页代码
				if($rw_name != $rw_name2){
					header("http/1.1 301 moved permanently");
					header("location: http://www.isweek.com/wholesale/" . $rw_name . '/' . $p . '.html' . $can );
					exit();
				}
			}
			else{
				if($rw_name != $rw_name2){
					header("http/1.1 301 moved permanently");
					header("location: http://www.isweek.com/wholesale/" . $rw_name . $can );
					exit();
				}
			}
			//判断URL中的分类名称是否正确，否则自动修正URL--end
			
			
			// 面包屑导航处理
			$this->assign ( 'term_ids', explode ( '-', $term ['path'] ) );
			
			// 分类及其子分类
			$terms = D ( 'Terms' )->where ( 'term_id = ' . $term_id . ' OR path LIKE "' . $term ['path'] . '-%"' )->select ();
			
			$addsql = ''; // 和分类相关的sql语句
			foreach ( $terms as $vo ) {
				if (! empty ( $vo ['term_id'] )) {
					if (empty ( $addsql ))
						$addsql = ' `categorys` LIKE "%,' . $vo ['term_id'] . ',%"';
					else
						$addsql .= ' OR `categorys` LIKE "%,' . $vo ['term_id'] . ',%"';
				}
			}
			
			if (! empty ( $addsql ))
				$addsql = ' AND (' . $addsql . ')'; // 和分类相关的完整的sql语句
					                                    
			// 优先读取“推荐到主页”的产品，按推荐时间的倒序排列
			$union_sql_1 = 'SELECT * FROM `sp_products` WHERE `audit` = 1 AND `status` = 1 ' . $addsql . ' AND `recommend` = 1';
			
			// 其次读取其它产品、按产品审核通过的时间倒序排列
			$union_sql_2 = 'SELECT * FROM `sp_products` WHERE `audit` = 1 AND `status` = 1 ' . $addsql . ' AND `recommend` = 0';
			
			// 合并所有查询条件，得到最终的sql语句
			$sql = $union_sql_1 . ' union all ' . $union_sql_2 . ' ORDER BY `recommend` desc,`edit_time` desc,`audit_time` desc';
			
			$total_sql = '`audit` = 1 AND `status` = 1 ' . $addsql; // 最终的获取记录总数的where条件
			
			//var_dump($_REQUEST ['perpage'] ,$_COOKIE ['perpage']);exit;
			if (isset ( $_REQUEST ['perpage'] )) {
				$perpage = intval ( $_REQUEST ['perpage'] ) > 0 ? intval ( $_REQUEST ['perpage'] ) : 60;
			} else if (isset ( $_COOKIE ['perpage'] )) {
				$perpage = intval ( $_COOKIE ['perpage'] ) > 0 ? intval ( $_COOKIE ['perpage'] ) : 60;
			} else {
				$perpage = 60;
			}
			cookie ( 'perpage', $perpage, 3600 );
			
			$curr_page = intval ( $_REQUEST ['p'] ); // 当前页码
			if ($curr_page < 1)
				$curr_page = 1;
			$start_index = ($curr_page - 1) * $perpage; // 开始索引
			$page_sql = $sql . ' LIMIT ' . $start_index . ', ' . $perpage; // 最终的分页sql
			
//    		echo $union_sql_1.'<br/><hr><br/>';
//    		echo $union_sql_2.'<br/><hr><br/>';
//    		echo $sql.'<br/><hr><br/>';
			$total = D ( 'Products' )->where ( $total_sql )->count ();
			
			$page = $this->page ( $total, $perpage ); // 实例化分页对象
			
			$page_html = $page->show ( 'Front' ); // 得到的分页链接代码
			
			//对分页代码进行处理(第一页)
			$page_html = str_replace('/1.html', '', $page_html);
			
			$model = new Model ();
			
			$list = $model->query ( $page_sql );
			
			foreach ( $list as $k => $vo ) {
				if (! empty ( $vo ['images'] )) {
					$list [$k] ['images'] = json_decode ( $vo ['images'], true );
					$list [$k] ['thumb'] = $list [$k] ['images'] [0];
					$list [$k] ['thumb_200'] = $this->get_thumb ( $list [$k] ['images'] [0] ['url'], 200 );
				}
			}
			
			$this->assign ( 'list', $list );
			
			$this->assign ( 'page_html', $page_html );
			
			$this->assign ( 'perpage', $perpage );
			
			$this->assign ( 'action', $_SERVER ['REQUEST_URI'] );
			
			// seo
			$seo_page = '';
			if ($page->GetCurrentPage () > 1) {
				$seo_page = " - Page " . $page->GetCurrentPage ();
			}
			$seo_page .= ' - ISweek';
			$this->assign ( 'title', $term ['seo_title'] . $seo_page );
			$this->assign ( 'description', $term ['seo_description'] );
			$this->assign ( 'keywords', $term ['seo_keywords'] );
			
			$this->display ( 'Index:index' );
		
		} else {
			exit ( 'Error' );
		}
	}

}
