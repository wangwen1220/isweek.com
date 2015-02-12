<?php
namespace Api\Controller;
use Think\Controller;
/**
 * 验证码处理
 */
class CheckcodeController extends Controller {

    public function index() {
		$checkcode = new \Think\Verify();
        if (isset($_GET['code_len']) && intval($_GET['code_len']))
            $checkcode->length = intval($_GET['code_len']);
		if ($checkcode->length > 8 || $checkcode->length < 2) {
			$checkcode->length = 4;
        }
        //强制验证码不得小于4位
		if($checkcode->length < 4){
			$checkcode->length = 4;
        }
        if (isset($_GET['fontSize']) && intval($_GET['fontSize']))
            $checkcode->fontSize = intval($_GET['fontSize']);
        if (isset($_GET['imageW']) && intval($_GET['imageW']))
			$checkcode->imageW = intval($_GET['imageW']);
		if ($checkcode->imageW <= 0) {
			$checkcode->imageW = 0;
        }
        if (isset($_GET['imageH']) && intval($_GET['imageH']))
            $checkcode->imageH = intval($_GET['imageH']);
        if ($checkcode->imageH <= 0) {
            $checkcode->imageH = 0;
        }
        
		//生成简单验证码
		$checkcode->useCurve = false;
		$checkcode->useNoise = false;
		//生成验证码
		$checkcode->entry();

    }

}

?>
