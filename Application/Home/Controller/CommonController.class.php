<?php
namespace Home\Controller;
use Think\Controller;
// + ---------- ----------
// | 这是前台公共控制器
// | @author tan<admin@163.com>
// + ---------- ----------
class CommonController extends Controller {


	public function __construct() {
		parent::__construct ();
		$time = time ();
		$this->assign ( 'js_debug', APP_DEBUG ? "?v=$time" : "" );
		$this->assign ( 'css_style', 'home' );
	}


	public function _initialize() {
		// 公共初始化方法
		// 读取公共数据
		// 分类数据TODO
		$navi_categorys = $this->get_navi_show_categorys ();
		$this->assign ( 'navi_categorys', $navi_categorys );
		
		// 前台左侧菜单
		$homepage_categorys2 = $this->get_homepage_show_categorys2 ();
		
		// 将结果集排序
		$homepage_categorys2 = $this->leipi_to_tree ( $homepage_categorys2 );
		
		// 处理左侧菜单选中效果
		$curr_term_id = intval ( $_REQUEST ['cid'] ); // 当前分类ID
		$arr_parent = array (); // 当前分类所有父级分类ID(不包括0)
		$curr_term = D ( 'Terms' )->find ( $curr_term_id );
		if (! empty ( $curr_term )) {
			$parent = explode ( '-', $curr_term ['path'] ); // 所有父级分类和自身ID
			foreach ( $parent as $vo ) {
				if ($vo > 0)
					$arr_parent [] = $vo;
			}
		}
		
		$this->assign ( 'curr_term_id', $curr_term_id ); // 当前分类ID
		$this->assign ( 'arr_parent', $arr_parent ); // 当前分类所有父级分类和自身ID
		$this->assign ( 'homepage_categorys2', $homepage_categorys2 ); // 左侧菜单
		                                                               // var_dump($this->get_dao_hang_categorys());
		$this->assign ( 'search_categorys', $this->get_search_categorys () );
		$this->assign ( 'dao_hang_categorys', $this->get_dao_hang_categorys () );
	
	}


	protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = false) {
		if ($Page_Size == 0) {
			$Page_Size = C ( "PAGE_LISTROWS" );
		}
		if (empty ( $PageParam )) {
			$PageParam = C ( "VAR_PAGE" ) != "" ? C ( "VAR_PAGE" ) : "page";
		}
		$Page = new \Org\Cmf\PageFront ( $Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static );
		$Page->SetPager ( 'Front', '{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}', array (
				"listlong" => "6",
				"first" => "first",
				"last" => "last",
				"prev" => "<i>&lt;</i> PREV",
				"next" => "NEXT <i>&gt;</i>",
				"list" => "*",
				"disabledclass" => "",
				"more" => '<span class="ellipsis">...</span>' 
		) );
		return $Page;
	}


	public function get_navi_show_categorys() {
		// TODO:排序规则
		$return = array ();
		$terms = F ( "terms_cache" );
		foreach ( $terms as $k => $v ) {
			// if ($v['navi_show'] && $v['parent'] == 0) {
			if ($v ['navi_show']) {
				$return [$k] = $v;
				$sort [$k] = $v ['listorder'];
			}
		}
		array_multisort ( $sort, SORT_ASC, $return );
		return array_slice ( $return, 0, 6 );
	}


	public function get_homepage_show_categorys() {
		// TODO:排序规则
		$return = array ();
		$terms = F ( "terms_cache" );
		foreach ( $terms as $v ) {
			if ($v ['homepage_show']) {
				$return [] = $v;
			}
		}
		return $return;
	}
	
	// 不读取没有产品的菜单，比如左侧菜单
	public function get_homepage_show_categorys2() {
		// TODO:排序规则
		$return = array ();
		$terms = F ( "terms_cache" );
		foreach ( $terms as $v ) {
			if ($v ['homepage_show'] && $v ['count'] > 0) {
				$return [] = $v;
			}
		}
		return $return;
	}
	
	// size:35,100,200,300
	public function get_thumb($img, $size = "35") {
		$image_path = str_replace ( C ( 'UPLOADPATH' ), '', $img );
		$thumb_name = substr ( $image_path, strrpos ( $image_path, '/' ) + 1 );
		$thumb_path = substr ( $image_path, 1, strrpos ( $image_path, '/' ) - 1 );
		$thumb_dir = "/Thumbs/" . $size . '/' . $thumb_path . '/';
		$thumb_file = $thumb_dir . $thumb_name;
		
		return $thumb_file;
	}


	public function get_search_categorys() {
		$return = F ( "search_terms_cache" );
		return $return;
	}


	public function get_dao_hang_categorys() {
		$return = F ( "dao_hang_terms_cache" );
		return $return;
	}


	/**
	 * 把返回的数据集转换成Tree
	 * @param array $list 要转换的数据集
	 * @param string $pid parent标记字段
	 * @param string $level level标记字段
	 * @return array
	 */
	function leipi_to_tree($list, $pk = 'term_id', $pid = 'parent', $child = '_child', $root = 0) {
		// 创建Tree
		$tree = array ();
		if (is_array ( $list )) {
			// 创建基于主键的数组引用
			$refer = array ();
			foreach ( $list as $key => $data ) {
				$refer [$data [$pk]] = & $list [$key];
			}
			foreach ( $list as $key => $data ) {
				// 判断是否存在parent
				$parentId = $data [$pid];
				if ($root == $parentId) {
					$tree [] = & $list [$key];
				} else {
					if (isset ( $refer [$parentId] )) {
						$parent = & $refer [$parentId];
						$parent [$child] [] = & $list [$key];
					}
				}
			}
		}
		return $tree;
	}


	/**
	 * 将leipi_to_tree的树还原成列表
	 * @param array $tree 原来的树
	 * @param string $child 孩子节点的键
	 * @param string $order 排序显示的键，一般是主键 升序排列
	 * @param array $list 过渡用的中间数组，
	 * @return array 返回排过序的列表数组
	 */
	function leipi_to_list($tree, $child = '_child', $order = 'listorder', &$list = array()) {
		if (is_array ( $tree )) {
			$refer = array ();
			foreach ( $tree as $key => $value ) {
				$reffer = $value;
				if (isset ( $reffer [$child] )) {
					unset ( $reffer [$child] );
					$this->leipi_to_list ( $value [$child], $child, $order, $list );
				}
				$list [] = $reffer;
			}
			// $list = list_sort_by($list, $order, $sortby='asc');该函数在thinkphp的扩展里面（当前版本貌似去掉该函数了）
			$list = $this->leipi_list_sort ( $list, $order, $sortby = 'asc' );
		}
		return $list;
	}


	/**
	 * 空操作（若模块正确，但操作不存在，则会自动进入该函数）
	 * 例如http://www.isweek.cn/index.php/product/fdsadsafsdafds
	 */
	public function _empty() {
		@header ( "http/1.1 404 not found" );
		@header ( "status: 404 not found" );
		//@header ( "Location:" . APP_404_URL );
		//exit ();
		$this->display ( 'Public:404' );
		exit ();
	}
	
	
	/**
	 * 发送邮件
	 * @param $subject 邮件标题
	 * @param $body 邮件内容
	 * @param $filename 附件地址
	 * @return 若发送成功，返回true，否则返回异常信息
	 */
	protected function send_mail($subject='这是邮件标题',$body='这是邮件内容',$filename=''){
		require_once './Public/plug/mailer/class.phpmailer.php';
		$email_conf = require_once APP_PATH . 'Home/Conf/email_config.php';
		try {
			$mail = new \PHPMailer(true); //实例化
			$body             = preg_replace('/\\\\/','', $body); //Strip backslashes
			
			$mail->IsSMTP(); // tell the class to use SMTP
			$mail->SMTPAuth = true; // 是否身份认证
			$mail->Port = $email_conf['smtp_port']; // smtp端口
			$mail->Host = $email_conf['smtp_host']; // smtp服务器
			$mail->Username = $email_conf['smtp_username']; // smtp账号
			$mail->Password = $email_conf['smtp_password']; // smtp密码
			
			//$mail->IsSendmail();
			$mail->CharSet="utf-8"; // 设置邮件编码
			//$mail->AddReplyTo($email_conf['smtp_reply'],$email_conf['smtp_replyname']);
			$mail->AddReplyTo($email_conf['email_from'],$email_conf['email_fromname']);
			$mail->From = $email_conf['email_from']; // 发件人账号
			$mail->FromName   = $email_conf['email_fromname']; // 发件人名称
			
			foreach($email_conf['email_address'] as $vo){
				//循环添加收件人
				$mail->AddAddress($vo[0],$vo[1]); // 收件人[，收件人名称]
			}
			
			if(!empty($filename) && is_file($filename)){
				$mail->AddAttachment($filename,basename($filename)); // 添加附件
			}
			
			$mail->Subject  = $subject; // 邮件主题
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			$mail->WordWrap   = 80; // 是否自动换行  80 个字符
			$mail->MsgHTML($body); // 邮件内容
			$mail->IsHTML(true); // 是否允许发送html文档
			
			$mail->Send();
			return true;
		} catch (phpmailerException $e) {
			return $e->errorMessage();
		}
	}
	
}