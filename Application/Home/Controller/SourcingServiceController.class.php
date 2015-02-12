<?php
namespace Home\Controller;
use Think\Controller;

// + ---------- ----------
// | 这是所有分类控制器
// | @author tan<admin@163.com>
// + ---------- ----------
class SourcingServiceController extends CommonController {
	public function __construct() {
		parent::__construct ();
		$this->assign ( "css_style", "sourcing-service" );
		$this->assign ( 'title', 'Sourcing Service, Sourcing Industrial Products - ISweek.com' );
		$this->assign ( 'description', 'ISweek is an industrial sourcing provider. You can entrust ISweek to source products for you.' );
		$this->assign ( 'keywords', 'sourcing, sourcing service, industrial sourcing, sourcing products, ISweek Sourcing Service' );
	}
	
	
	// + ---------- ----------
	// | 这是默认方法
	// | @author tan<admin@163.com>
	// + ---------- ----------
	public function index() {
		$curr_menu_key = 'SourcingService';//菜单标记
		$this->assign('curr_menu_key',$curr_menu_key);
		
		$this->display ();
	}
	
	
	// + ---------- ----------
	// | 这是提交“委托采购”的方法
	// | 先把相关信息存入数据库，然后给管理者发邮件
	// | @author tan<admin@163.com>
	// + ---------- ----------
	public function add(){
		if(isset($_POST['dopost']) && $_POST['dopost']){
			$data = array();
			$data['product_name'] = trim($_POST['productName']);//产品名称
			$data['serial_no'] = trim($_POST['modelNumber']);//型号规格
			$data['product_brand'] = trim($_POST['brand']);//品牌
			$data['supplier_name'] = trim($_POST['manufacturer']);//制造厂家
			
			$data['required'] = trim($_POST['certificationRequired']);//认证要求
			$data['product_num'] = trim($_POST['purchaseQuantity']);//购买数量
			if(!empty($_FILES['attachment']) && $_FILES['attachment']['error']==0 && $_FILES['attachment']['size']>0){
				//若有选择附件
				$data['attachment'] = $this->upload('attachment');//附件
			}else{
				$data['attachment'] ='';
			}
			$data['name'] = trim($_POST['name']);
			
			$data['email'] = trim($_POST['email']);
			$data['mobile'] = trim($_POST['phoneNumber']);
			$data['company_name'] = trim($_POST['companyName']);
			$data['website'] = trim($_POST['website']);
			
			$data['add_time'] = time();
			$data['edit_time'] = $data['add_time'];
			$data['udate'] = date('Y-m-d H:i:s',$data['add_time']);
			
			$ebuy_obj=D("Ebuy");
			$rs = $ebuy_obj->add($data);//信息入库
			if(!$rs){
				$this->assign('result','error');
				$this->assign('content','Sorry! There is a system problem and your request has not been submitted. Please go back and submit again.<br/>You can also write an email to us: sales@isweek.com');
				$this->display('SourcingService:result');exit;
			}
			
			$title = '委托采购-ISweek.com：' . $data['product_name']; // 邮件标题
			$filename = ''; // 邮件附件（可选）
			$filename2 = ''; // 邮件内容中显示的上次的文件的地址
			if(!empty($data['attachment'])){
				set_time_limit(5*60);//延长5分钟
				$filename = './Uploads/' . $data['attachment'];
				$filename2 = 'http://www.isweek.com/Uploads/' . $data['attachment'];
			}
			$html = ''; // 邮件内容
			$html .= '来源：ISweek.com<br/><br/>';
			$html .= '采购产品：' . $data['product_name'] . '<br/><br/>';
			$html .= 'Model Number：' . $data['serial_no'] . '<br/><br/>';
			$html .= 'Brand：' . $data['product_brand'] . '<br/><br/>';
			
			$html .= 'Manufacturer：' . $data['supplier_name'] . '<br/><br/>';
			$html .= 'Certification Required：' . $data['required'] . '<br/><br/>';
			$html .= 'Purchase Quantity：' . $data['product_num'] . '<br/><br/>';
			$html .= 'Attachment：' . $filename2 . '<br/><br/>';
			
			//$html .= '<br/><hr/><br/>';
			$html .= '<b>Contact Information</b><br/><br/>';
			$html .= 'Name：' . $data['name'] . '<br/><br/>';
			$html .= 'Email：' . $data['email'] . '<br/><br/>';
			
			$html .= 'Phone Number：' . $data['mobile'] . '<br/><br/>';
			$html .= 'Company Name：' . $data['company_name'] . '<br/><br/>';
			$html .= 'Website：' . $data['website'] . '<br/><br/>';
			
			//发送邮件
			$rs = $this->send_mail($title,$html,$filename);
			if($rs === true){
				$this->assign('result','success');
				$this->assign('content','Your request has been submitted. ISweek team will contact you soon. Thank you.');
				$this->display('SourcingService:result');exit;
			}else{
				$this->assign('result','error');
				$this->assign('content','Sorry! There is a system problem and your request has not been submitted. Please go back and submit again.<br/>You can also write an email to us: sales@isweek.com');
				$this->display('SourcingService:result');exit;
			}
		}
// 		$this->assign('result','success');
// 		$this->assign('content','Your request has been submitted. ISweek team will contact you soon. Thank you.');
// 		$this->display('SourcingService:result');exit;
		//其实进到这里，说明当前操作是非法的
		$this->assign('result','error');
		$this->assign('content','Sorry! There is a system problem and your request has not been submitted. Please go back and submit again.<br/>You can also write an email to us: sales@isweek.com');
		$this->display('SourcingService:result');exit;
	}
	
	
	/**
	 * 上传附件
	 * @param string $inputName
	 * @return string
	 */
	public function upload($inputName='attachment'){
		set_time_limit(5*60);//延长5分钟
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize = 20 * 1024 * 1024 ;// 设置附件上传大小
		$upload->exts = array('jpg', 'gif', 'png', 'jpeg', 'txt', 'doc', 'xls', 'rar', 'zip', 'pdf');// 设置附件上传类型
		//$upload->savePath = 'ebuy/'; // 设置附件上传目录
		$upload->saveName = time().'_'.mt_rand();
		$upload->autoSub = true;
		$upload->subName = array('date','Ymd');
		// 上传单个文件
		$info   =   $upload->uploadOne($_FILES[$inputName]);
		if(!$info) {
			// 上传错误提示错误信息        
			//$this->error($upload->getError());
			return '';
		}else{
			// 上传成功 获取上传文件信息
			//echo $info['savepath'].$info['savename'];
			return $info['savepath'].$info['savename'];
		}
	}
	
}