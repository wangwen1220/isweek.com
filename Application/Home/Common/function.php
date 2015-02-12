<?php

//������д
function rw_category_url($name, $id) {
	$return = '';
	$name = html_entity_decode($name);
	$return = '/wholesale/'.convert_url_string($name).'_'.$id;

	return $return;
}

//��Ʒ������д
function rw_product_url($name, $model, $id) {
	$return = '';
	$return = '/product/'.convert_url_string($name).'-'.convert_url_string($model).'_'.$id.'.html';

	return $return;
}

function convert_url_string($str) {
	$return = '';
	$tmp = preg_replace('/(\W)+/','-',$str);
	$tmp = preg_replace('/-+$/', '', $tmp);
	$return = preg_replace('/^-+/', '', $tmp);
	$return = strtolower($return);

	return $return;
}
