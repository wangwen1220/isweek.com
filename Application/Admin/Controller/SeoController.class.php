<?php
namespace Admin\Controller;
class SeoController extends AdminbaseController {
	
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
		$result = $this->terms_obj->order(array("listorder"=>"asc"))->select();
		
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
			$r['str_manage'] = '<a href="' . U("seo/edit", array("id" => $r['term_id'])) . '">修改</a> ';
			$url=U('Home/Category/index',array('cid'=>$r['term_id']));
			$r['url'] = $url;
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			$r['homeshow'] = $r['homepage_show']==1? 'yes':'&nbsp;';
			$r['navishow'] = $r['navi_show']==1? 'yes':'&nbsp;';
			$array[] = $r;
		}
		
		$tree->init($array);
		$str = "<tr>
					<td>\$id</td>
					<td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
					<td>\$homeshow</td>
					<td>\$navishow</td>
					<td align='center'><a href='\$url' target='_blank'>访问</a></td>
					<td>\$str_manage</td>
				</tr>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
		$this->display();
        //$this->display();
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
			if ($this->terms_obj->create()) {
				if ($this->terms_obj->add()) {
					$this->success("新增成功！",U("term/index"));
				} else {
					$this->error("新增失败！");
				}
			} else {
				$this->error($this->terms_obj->getError());
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
			if ($this->terms_obj->create()) {
				if ($this->terms_obj->save()!==false) {
					$this->success("修改成功！");
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
		$status = parent::listorders($this->terms_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
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
			$this->error("该菜单下还有子类，无法删除！");
		}
		if ($this->terms_obj->delete($id)) {
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
