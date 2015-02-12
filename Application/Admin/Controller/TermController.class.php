<?php
namespace Admin\Controller;
class TermController extends AdminbaseController {
	
	protected $terms_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->terms_obj = D("Terms");
		$this->terms_obj->terms_cache();
		
		//所有顶级分类（前台搜索下拉框）
		$list = $this->terms_obj->where('parent = 0 AND `status`=1')->order('listorder asc')->select();
		F('search_terms_cache',$list);unset($list);
		
		//所有分类（前台面包屑导航）
		$list = $this->terms_obj->order('listorder asc')->select();
		F('dao_hang_terms_cache',$list);unset($list);
	}
	function index(){
		$result = $this->terms_obj->order(array("name"=>"asc"))->select();
		
       /*  $tree = new PathTree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '---';
       	$tree->init($result);
       	$tree=$tree->get_tree();
       	$this->assign("terms",$tree); */
		$tree = new \Org\Cmf\Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			if($r['status'] == 0) {
			$forbid_cate = '| <a class="enable_cate" href="javascript:void(0);" data-count="'.$r['count'].'" data-id="' . $r['term_id'] . '">启用</a> ';
			} else {
			$forbid_cate = '| <a class="forbid_cate" href="javascript:void(0);" data-count="'.$r['count'].'" data-id="' . $r['term_id'] . '">禁用</a> ';
			}
			$delete_cate = '| <a class="delete_cate" href="javascript:void(0);" data-count="'.$r['count'].'" data-id="' . $r['term_id'] . '">删除</a> ';
			$r['str_manage'] = '<a href="' . U("term/add", array("parent" => $r['term_id'])) . '">添加子类</a> | <a target="_blank" href="' . U("term/edit", array("id" => $r['term_id'])) . '">修改</a> '.$forbid_cate. $delete_cate;
			$url=U('Home/Category/index',array('cid'=>$r['term_id']));
			$r['url'] = $url;
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			$r['homeshow'] = $r['homepage_show']==1? 'yes':'&nbsp;';
			if($r['navi_show'] == 1) {
				$r['navishow'] = 'yes';
				$r['sort_display'] = '';
			} else {
				$r['navishow'] = '&nbsp;';
				$r['sort_display'] = 'style="display:none;"';
				$r['listorder'] = -123;
			}
			if($r['status'] == 1) {
				$r['font'] = '';
			} else { 
				$r['font'] = 'style="color:red;"';
			}

			$array[] = $r;
		}
		
		$tree->init($array);
		$str = "<tr>
					<td>\$id</td>
					<td>\$spacer <a href='\$url' target='_blank' \$font>\$name</a></td>
					<td>\$homeshow</td>
					<td>\$navishow</td>
					<td><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input' \$sort_display></td>
					<td align='center'><a href='\$url' target='_blank'>访问</a></td>
					<td>\$str_manage</td>
				</tr>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
		$this->display();
	}
	
	
	function add(){
		$parentid = (int) I("get.parent");
	 	$tree = new \Org\Cmf\PathTree();
	 	$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
	 	$tree->nbsp = '---';
	 	$result = $this->terms_obj->order(array("path"=>"asc"))->select();
	 	$tree->init($result);
	 	$tree=$tree->get_tree();
	 	$this->assign("terms",$tree);
	 	$this->assign("parent",$parentid);
	 	$this->display();
	}
	
	function add_post(){
		if (IS_POST) {

			$_POST['name'] = trim($_POST['name']);
			$category = strtolower($_POST['name']);
			$_POST['seo_title'] = 'Wholesale high quality '.$category;
			$_POST['seo_keywords'] = $category.', '.$category.' wholesale, '.$category.' shopping, buy '.$category;
			$_POST['seo_description'] = 'Buy '.$category.' at wholesale price from ISweek. You\'ll find high quality and best price '.$category.' here and save your money than everywhere';
			//判断是否存在相同路径相同名称的分类
			$ex = $this->terms_obj->where("parent='".$_POST['parent']."' AND name='".$_POST['name']."'")->count();
			if ($ex== 0 && $this->terms_obj->create()) {
				if ($this->terms_obj->add()) {
					$this->success("新增成功！",U("term/index"));
				} else {
					$this->error("新增失败！");
				}
			} else {
				if($ex > 0) {
					$this->error("添加失败！已存在路径和名字完全一样的分类");
				} else {
					$this->error($this->terms_obj->getError());
				}
			}
		}
	}
	
	function edit(){
		$tree = new \Org\Cmf\PathTree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '---';
		$result = $this->terms_obj->order(array("path"=>"asc"))->select();
		$tree->init($result);
		$tree=$tree->get_tree();
			
		$id = (int) I("get.id");
		$data=$this->terms_obj->where(array("term_id" => $id))->find();
		$this->assign("terms",$tree);
		$this->assign("data",$data);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if(!isset($_POST['homepage_show'])) {
				$_POST['homepage_show'] = 0;
			}
			if(!isset($_POST['navi_show'])) {
				$_POST['navi_show'] = 0;
			}
			//超过6个导航推荐显示，提示超额
			if($_POST['navi_show'] == 1) {
				//查询
				if($this->terms_obj->where("navi_show=1")->count() >= 6) {
					$this->error("已有6个导航，无法新增导航产品类别");
				}
			}

			//新需求，若分类名未改变，则seo信息不变化(不区分大小写)
			$terms = D("Terms")->find($_POST['term_id']);//必须在修改前获取之前的对象
			//比较的字符串（将html代码转成htnl实体代码）
			$temp_name = htmlspecialchars_decode(trim($terms['name']),ENT_COMPAT);
			$temp_name = strtolower($temp_name);
			
			if ($this->terms_obj->create()) {
				if ($this->terms_obj->save()!==false) {
					//修改分类名时，同步分类名至SEO数据
					$_POST['name'] = trim($_POST['name']);
					$category = strtolower($_POST['name']);
					//被比较的字符（将html代码转成htnl实体代码）（比如将&amp; 替换为 &）
					$temp_name2 = htmlspecialchars_decode($_POST['name'],ENT_COMPAT);
					$temp_name2 = strtolower($temp_name2);
					//新需求，若分类名未改变，则seo信息不变化(不区分大小写)
					if($temp_name2!=$temp_name){
						//测试代码
						//$this->error("测试结果11|".$temp_name."|".$category."|".$temp_name2."|");
						$seo_title = 'Wholesale high quality '.$category;
						$seo_keywords = $category.', '.$category.' wholesale, '.$category.' shopping, buy '.$category;
						$seo_description = 'Buy '.$category.' at wholesale price from ISweek. You\'ll find high quality and best price '.$category.' here and save your money than everywhere';
						$model = M("");
						$model->execute("update __TERMS__ set seo_title='$seo_title', seo_keywords='$seo_keywords', seo_description=\"$seo_description\" where term_id='$_POST[term_id]'");
						//end
					}unset($terms);
					
					//测试代码
					//$this->error("测试结果22|".$temp_name."|".$category."|".$temp_name2."|");
					
					$term_id=$_POST['term_id'];
					$parent_id=$_POST['parent'];
					if($parent_id==0){
						$d['path']="0-$term_id";
					}else{
						$parent=$this->terms_obj->where("term_id=$parent_id")->find();
						$d['path']=$parent['path'].'-'.$term_id;
					}
					$this->terms_obj->where("term_id=$term_id")->save($d);
					cookie('refersh_time', 1);
					$this->success("修改成功！", 'javascript:window.close();');
				} else {
					$this->error("修改失败！");
				}
			} else {
				$this->error($this->terms_obj->getError());
			}
		}
	}
	
	//排序
	public function listorders() {
		//1-6且不重复验证
		$ids = $_POST['listorders'];
		$ids = array_filter($ids, create_function('$v', 'return $v!=-123;'));
//		var_dump($ids);
		rsort($ids);
		if($ids[0] > 6) {
			$this->error("排序更新失败！不能排序大于6");
		}
		sort($ids);
		if($ids[0] < 1) {
			$this->error("排序更新失败！不能排序小于0");
		}
		if(count($ids) != count(array_unique($ids))) {
			$this->error("排序更新失败！排序值不能重复");
		}


		$status = parent::listorders($this->terms_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	/**
	 *  禁用
	 */
	public function forbid() {
		$id = (int) I("get.id");
		//判断是禁用还是启用
		if(isset($_GET['ct']) && i("get.ct") == 0) { //禁用
			$count = $this->terms_obj->where(array("parent" => $id, "status"=>1))->count();
			if ($count > 0) {
				$this->error("该菜单下还有子类，无法禁用！请先禁用子分类");
			}
		}else if(isset($_GET['ct']) && i("get.ct") == 1) {//启用
			/*
			$count = $this->terms_obj->where(array("parent" => $id, "status"=>0))->count();
			if ($count > 0) {
				$this->error("该菜单下还有子类被禁用！请先启用子分类");
			}
			 */
		}
		$model = M("");
		$res = $model->execute("UPDATE __TERMS__ SET status=IF(status=0, 1, 0) WHERE term_id=". $id);
//		echo $model->getLastSql();
		if ($res) {
			//更新分类表status字段
			//产品详情页中该分类不显示TODO
			$this->success("禁用成功！");
		} else {
			$this->error("禁用失败！");
		}
	}
	/**
	 *  删除
	 */
	public function delete() {
		$id = (int) I("get.id");
		//删除分类是否需要删除该分类下的产品TODO
		$count = $this->terms_obj->where(array("parent" => $id))->count();
		if ($count > 0) {
			$this->error("该菜单下还有子类，无法删除！请先删除子分类");
		}
		if ($this->terms_obj->delete($id)) {
			//删除产品表中该字段记录TODO
			$products_obj = D("Products");
			$products_obj->deleteCategory($id);
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	
	public function show(){
		$result = $this->terms_obj->order(array("listorder"=>"asc"))->select();
		$tree = new Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			$name=$r['name'];
			$url=U('post/lists',array('term'=>$r['term_id']));
			$r['name']="<a class='term_link' href='$url' >$name</a>";
			$array[$r['term_id']] = $r;
		}
		$str = "<tr>
				<td >\$spacer\$name</td>
				</tr>";
		$tree->init($array);
		
		$categorys = $tree->get_tree(0, $str);;
			
		$this->assign("categorys", $categorys);
		$this->display();
		
	}
}
