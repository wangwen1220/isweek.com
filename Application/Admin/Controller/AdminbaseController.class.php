<?php
namespace Admin\Controller;
class AdminbaseController extends AppframeController {
	
	public function __construct() {
		parent::__construct();
		$time=time();
		$this->assign("js_debug",APP_DEBUG?"?v=$time":"");
	}

    function _initialize() {
       parent::_initialize();
    	if(isset($_SESSION['ADMIN_ID'])){
    		$users_obj= D("Users");
    		$id=$_SESSION['ADMIN_ID'];
    		$user=$users_obj->where("ID=$id")->find();
    		if(!$this->check_access($user['role_id'])){
    			$this->error("您没有访问权限！");
    			exit();
    		}
    		$this->assign("admin",$user);
    	}else{
//    		$this->error("您还没有登录！",U("admin/public/login"));
    		header("Location:".U("admin/public/login"));
    		exit();
    	}
    }

    /**
     * 消息提示
     * @param type $message
     * @param type $jumpUrl
     * @param type $ajax 
     */
    public function success($message = '', $jumpUrl = '', $ajax = false) {
        parent::success($message, $jumpUrl, $ajax);
        $text = "应用：" . GROUP_NAME . ",模块：" . MODULE_NAME . ",方法：" . ACTION_NAME . "<br>提示语：" . $message;
    }


    //扩展方法，当用户没有权限操作，用于记录日志的扩展方法
    public function _ErrorLog() {
        
    }

    /**
     * 初始化后台菜单
     */
    public function initMenu() {
        $Menu = F("Menu");
        if (!$Menu) {
            $Menu=D("Menu")->menu_cache();
        }
        return $Menu;
    }

    /**
     *  排序 排序字段为listorders数组 POST 排序字段为：listorder
     */
    protected function listorders($model) {
        if (!is_object($model)) {
            return false;
        }
        $pk = $model->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $model->where(array($pk => $key))->save($data);
        }
        return true;
    }

    protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE) {
        if ($Page_Size == 0) {
            $Page_Size = C("PAGE_LISTROWS");
        }
        if (empty($PageParam)) {
			$PageParam = C("VAR_PAGE")!=""?C("VAR_PAGE"):"page";
        }
        $Page = new \Org\Cmf\Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
		$Page->SetPager('Admin', '总计{recordcount}:{first}{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}{last}', array("listlong" => "6", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
        return $Page;
    }

    /**
     * 获取菜单导航
     * @param type $app
     * @param type $model
     * @param type $action
     */
    public static function getMenu() {

        $menuid = (int) $_GET['menuid'];
        $menuid = $menuid ? $menuid : cookie("menuid", "", array("prefix" => ""));
        //cookie("menuid",$menuid);

        $db = D("Menu");
        $info = $db->cache(true, 60)->where(array("id" => $menuid))->getField("id,action,app,model,parentid,data,type,name");
        $find = $db->cache(true, 60)->where(array("parentid" => $menuid, "status" => 1))->getField("id,action,app,model,parentid,data,type,name");

        if ($find) {
            array_unshift($find, $info[$menuid]);
        } else {
            $find = $info;
        }
        foreach ($find as $k => $v) {
            $find[$k]['data'] = $find[$k]['data']."&menuid=$menuid" ;
        }

        return $find;
    }

    /**
     * 当前位置
     * @param $id 菜单id
     */
    final public static function current_pos($id) {
        $menudb = M("Menu");
        $r = $menudb->where(array('id' => $id))->find();
        $str = '';
        if ($r['parentid']) {
            $str = self::current_pos($r['parentid']);
        }
        return $str . $r['name'] . ' > ';
    }
    
    private function check_access($roleid){
    	
    		//如果用户角色是1，则无需判断
    		if($roleid == 1){
    			return true;
    		}
    		$role_obj=D("Role");
    		$role=$role_obj->field("status")->where("id=$roleid")->find();
    		if(!empty($role) && $role['status']==1){
    			$group=MODULE_NAME;
    			$model=CONTROLLER_NAME;
    			$action=ACTION_NAME;
    			if(MODULE_NAME.CONTROLLER_NAME.ACTION_NAME!="AdminIndexindex"){
    				$access_obj = M("Access");
					//权限控制相关
					if(MODULE_NAME == "Admin" &&
						(CONTROLLER_NAME=="Products" 
						|| CONTROLLER_NAME=="Supplier"
						|| CONTROLLER_NAME=="Audit"   
						)
					){
						$action_buttons = array('audit','recommend','show','delete','listorders','edit','check');


						foreach ($action_buttons as $v) {
							if(CONTROLLER_NAME == "Audit") {
								$model = 'Products';
							}
							$access_actions = $access_obj->where( "role_id=$roleid and g='".$group."' and m='".$model."' and a='$v'")->select();
//							echo $access_obj->getLastSql();
							if(!empty($access_actions)) {
								$this->assign($v.'_act', '');
							} else {
								$this->assign($v.'_act', 'style="display:none;"');
							}
						}
					}
					//END

    				$count = $access_obj->where ( "role_id=$roleid and g='$group' and m='$model' and a='$action'")->count();
    				return $count;
    			}else{
    				return true;
    			}
    		}else{
    			return false;
    		}
    		
    		
    		
    }
}

?>
