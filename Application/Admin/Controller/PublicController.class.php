<?php
namespace Admin\Controller;
/**
 */
class PublicController extends AdminbaseController {

    function _initialize() {}
    
    //后台登陆界面
    public function login() {
    	if(isset($_SESSION['ADMIN_ID'])){//已经登录
    		$this->success("已登录！",U("Index/index"));
    	}else{
    		$this->display();
    	}
    }
    
    public function logout(){
    	session('[destroy]'); 
    	$this->redirect("public/login");
    }
    
    public function dologin(){
    	$name = I('post.username');
		$login_url = U('admin/public/login');
    	if(empty($name)){
			$this->error("用户名不能为空！", $login_url);
    	}
    	$pass = I('post.password');
    	if(empty($pass)){
    		$this->error("密码不能为空！", $login_url);
    	}
		$verrify = I('post.verify');
    	if(empty($verrify)){
    		$this->error("验证码不能为空！", $login_url);
    	}
    	//验证码
		$verify = new \Think\Verify();
		if(!$verify->check($verrify))
    	{
    		$this->error("验证码错误！");
    	}else{
    		$user = D("Users");
    		$where['user_login']=$name;
    		$result = $user->where($where)->find();
    		if($result != null)
    		{
    			if($result['user_pass'] == sp_password($pass))
    			{
    				//登入成功页面跳转
    				$_SESSION["ADMIN_ID"]=$result["ID"];
    				$_SESSION['name']=$result["user_login"];
    				session("roleid",$result['role_id']);
    				$result['last_login_ip']=get_client_ip();
    				$result['last_login_time']=date("Y-m-d H:i:s");
    				$user->save($result);
    				$this->success("登录验证成功！",U("Index/index"));
    			}else{
    				$this->error("密码错误！");
    			}
    		}else{
    			$this->error("用户名不存在！");
    		}
    	}
    }

}

?>
