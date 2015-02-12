<?php
function get_current_admin_id(){
	return $_SESSION['ADMIN_ID'];
}
function sp_password($pw){
	$decor=md5(C('DB_PREFIX'));
	$mi=md5($pw);
	return substr($decor,0,12).$mi.substr($decor,-4,4);
}
function sp_clear_cache(){
	$dirs = array ();
	// runtime/
	$rootdirs = scandir ( RUNTIME_PATH );
	//$noneed_clear=array(".","..","Data");
	$noneed_clear=array(".","..");
	$rootdirs=array_diff($rootdirs, $noneed_clear);
	foreach ( $rootdirs as $dir ) {

		if ($dir != "." && $dir != "..") {
			$dir = RUNTIME_PATH . $dir;
			if (is_dir ( $dir )) {
				array_push ( $dirs, $dir );
				$tmprootdirs = scandir ( $dir );
				foreach ( $tmprootdirs as $tdir ) {
					if ($tdir != "." && $tdir != "..") {
						$tdir = $dir . '/' . $tdir;
						if (is_dir ( $tdir )) {
							array_push ( $dirs, $tdir );
						}
					}
				}
			}else{
				@unlink($dir);
			}
		}
	}
	$dirtool=new \Org\Cmf\Dir("");
	foreach ( $dirs as $dir ) {
		$dirtool->del ( $dir );
	}

}

//本地上传文件的IO操作
function file_upload($src_file,$dest_file){
	$pdir=dirname($dest_file);
	if(!is_dir($pdir)) @mkdir($pdir,0777);
	return copy($src_file,$dest_file);
}
function file_delete($filename){
	return unlink($filename);
}
function file_get($filename){
	return file_get_contents($filename);
}
