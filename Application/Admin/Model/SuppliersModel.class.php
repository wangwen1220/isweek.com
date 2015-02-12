<?php
namespace Admin\Model;
use Think\Model;
class SuppliersModel extends Model {
	public function updateCount($supplier_ids, $increase=true) {
		$total_terms = array();
		$total_terms = (array)$supplier_ids;
		$unique_terms = array_unique($total_terms);
		$map['id'] = array('IN', $unique_terms);
		if($increase) {
			$this->where($map)->setInc('count');
		} else {
			$this->where($map)->setDec('count');
		}
	}
}
