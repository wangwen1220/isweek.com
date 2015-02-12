<?php
namespace Admin\Controller;
class AuditController extends AdminbaseController {
	protected $products_obj;
	protected $terms_obj;
	function _initialize() {
		parent::_initialize();
		$this->products_obj = D("Products");
		$this->terms_obj = D("Terms");
		//查询供应商数据
		$suppliers_obj = D("Suppliers");
		$suppliers = $suppliers_obj->field("id, name")->order("name ASC,listorder ASC")->select();
		$this->assign("suppliers",$suppliers);
	}
	public function index() {
		$id=(int) I("get.id");
		//查询产品数据
		$products=$this->products_obj->where("id=$id")->find();
		//处理缩略图
    	$products['images'] = json_decode($products['images'],true);
//    	$item['thumb'] 	= $item['images'][0];//原图
//    	$item['thumb_300'] 	= $this->get_thumb($item['images'][0]['url'],300);//长宽300PX图片（缩略图）
    	
    	foreach($products['images'] as $k=>$vo){
    		$products['images'][$k]['thumb_35'] = $this->get_thumb($vo['url'],35);//长宽30PX图片（缩略图）
    		$products['images'][$k]['thumb_100'] = $this->get_thumb($vo['url'],100);//长宽30PX图片（缩略图）
    		$products['images'][$k]['thumb_200'] = $this->get_thumb($vo['url'],200);//长宽200PX图片（缩略图）
    		$products['images'][$k]['thumb_300'] = $this->get_thumb($vo['url'],300);//长宽300PX图片（缩略图）
    	}
//		dump($products);
		//查询供应商数据
		$selected_cate = $this->products_obj->getSupplierByIds($products['supplier_ids']);
		$selected_cate_options = "";
		foreach($selected_cate as $v) {
			$selected_cate_options .= "<option value='$v[id]' >$v[name]</option>";
		}
		$this->assign("selected_supplier_options",$selected_cate_options);

		//查询分类数据
		$selected_cate = explode(',',trim($products['categorys'],','));
		foreach($selected_cate as $v) {
			$selected_cate_options .= $this->terms_obj->get_terms_path($v).'<br/>';
		}


		$this->assign("products",$products);
		$this->assign("selected_cate_options",$selected_cate_options);
		$this->assign("images",json_decode($products['images'],true));
		$this->display();
	}
	private function get_thumb($img, $size="35") {
		$image_path = str_replace(C('UPLOADPATH'),'',$img);
		$thumb_name = substr($image_path, strrpos($image_path,'/')+1);
		$thumb_path = substr($image_path, 1, strrpos($image_path, '/')-1);
		$thumb_dir = "/Thumbs/".$size.'/'.$thumb_path.'/';
		$thumb_file = $thumb_dir.$thumb_name;

		return $thumb_file;
	}

	function audit(){
		//审核
		//需要检验该公司的禁用状态，若为禁用，则status为0，不予上架TODO
		if(isset($_GET['id']) && $_GET["check"]){
			$model = M("products");
			$res = $model->where("id=$_GET[id]")->field("supplier_ids")->find();
//				var_dump($res);
			$map = array();
			$map['id'] = array("in", trim($res['supplier_ids'],","));
			$suppliers = M("Suppliers")->field("status")->where($map)->select();
			$suppliers_status = 1;
			foreach ($suppliers as $val) {
				$suppliers_status &= $val['status'];
			}
			if($suppliers_status != 1) {
				$this->error("审核失败，该公司未启用！");
			}
			$data["audit"]=1;
			$data["status"] = 1;
			//更新审核者与审核时间
			$data["audit_member"] = session("ADMIN_ID");
			$data["audit_time"] = time();
			
			$tids=implode(",",$GET['ids']);
			if ( $this->products_obj->where("ID =".$_GET['id'])->save($data)) {
				cookie('refersh_time', 1);
				$this->success("审核成功！", 'javascript:window.close();');
			} else {
				$this->error("审核失败！");
			}
		}
		//取消审核
		if(isset($_GET['id']) && $_GET["uncheck"]){
			
			$data["audit"]=0;
			$data["status"] = 0;
			//更新审核者与审核时间
			$data["audit_member"] = session("ADMIN_ID");
			$data["audit_time"] = time();

			if ( $this->products_obj->where("ID =".$_GET['id'])->save($data)) {
				$this->success("取消审核成功！", 'javascript:window.close();');
			} else {
				$this->error("取消审核失败！");
			}
		}
	}
	function delete(){
		if(isset($_GET['id'])){
			$tid = I("get.id");
			$categorys = trim($this->products_obj->getFieldById($tid, 'categorys'), ',');
			if ($categorys && $this->products_obj->where("id=$tid")->delete()) {
				//更新分类表的统计数据
				$this->terms_obj->updateProductsCount(explode(',',$categorys), 0);
				$this->success("删除成功！", 'javascript:window.close();');
			} else {
				$this->error("删除失败！");
			}
		}
	}
}

