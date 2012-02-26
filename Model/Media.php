<?php
class Media extends AppModel{
	
	public $useTable = 'medias';
	public $order    = 'position ASC';

	function beforeDelete($cascade = true){
		$file = $this->field('file');
		$info = pathinfo($file);
		foreach(glob(IMAGES.$info['dirname'].'/'.$info['filename'].'_*x*.jpg') as $v){
			unlink($v);
		}
		unlink(IMAGES.$file); 
		return true;
	}

	function afterFind($data){
		foreach($data as $k=>$v){
			$i = key($v); 
			$v = current($v); 
			if(isset($v['file'])){
				$data[$k][$i]['filef'] = substr($v['file'],0,-4).'_%dx%d.jpg';
			}
		}
		return $data; 
	}

	function beforeSave($options = array()){
		if( isset($this->data['Media']['file']) && is_array($this->data['Media']['file']) && isset($this->data['Media']['ref']) ){
			$model 		= ClassRegistry::init($this->data['Media']['ref']);
			$dir 		= $model->uploads;
			$pathinfo 	= pathinfo($this->data['Media']['file']['name']);
			$filename 	= Inflector::slug($pathinfo['filename'],'-').'.'.$pathinfo['extension'];
			$search 	= array('%y','%m','%f','%id','%mid');
			$replace 	= array(date('Y'),date('m'),$filename,$model->id,ceil($model->id/1000));
			$dir  		= str_replace($search,$replace,$dir);
			$this->testDuplicate($dir); 
			if(!file_exists(dirname(IMAGES.$dir))){
				mkdir(dirname(IMAGES.$dir),0777,true);
			}
			move_uploaded_file($this->data['Media']['file']['tmp_name'], IMAGES.$dir);
			$this->data['Media']['file'] = $dir;
		}
		return true; 
	}

	/**
	* If the file $dir already exists we add a {n} before the extension
	**/
	function testDuplicate(&$dir,$count = 0){
		$file = $dir; 
		if($count > 0){
			$pathinfo = pathinfo($dir);
			$file = $pathinfo['dirname'].'/'.$pathinfo['filename'].'-'.$count.'.'.$pathinfo['extension'];
		}
		if(!file_exists(IMAGES.$file)){
			$dir = $file; 
		}else{
			$count++;
			$this->testDuplicate($dir,$count);
		}
	}

}