<?php
class MediaBehavior extends ModelBehavior{


	public function setup($model,$options = array()){
		if(!isset($model->uploads)){
			$model->uploads = 'uploads/%y/%m/%f';
		}
		$model->hasMany['Media'] = array(
			'className'  => 'Media.Media',
			'foreignKey' => 'ref_id',
			'conditions' => 'ref = "'.$model->name.'"',
			'dependent'  => true
		);
	}

	public function afterSave($model){
		if(!empty($model->data[$model->name]['thumb']['name'])){
			$file = $model->data[$model->name]['thumb']; 
			
			// Current thumb
			$media_id = $model->field('media_id');
			if($media_id != 0){
				$model->Media->delete($media_id); 
			}

			// Upadte thumb
			$model->Media->save(array(
				'ref_id' => $model->id,
				'ref'	 => $model->name,
				'file'   => $file
			));
			$model->saveField('media_id',$model->Media->id);
		}
	}

	public function afterFind($model,$data){
		foreach($data as $k=>$v){
			// Thumbnail
			if(!empty($v['Media'])){
				$v['Media'] = Set::Combine($v['Media'],'{n}.id','{n}');
			}
			if( !empty($v[$model->name]['media_id']) && isset($v['Media'][$v[$model->name]['media_id']]) ){
				$media_id = $v[$model->name]['media_id'];
				$v[$model->name]['thumb'] = $v['Media'][$media_id]['file'];
				$v[$model->name]['thumbf'] = $v['Media'][$media_id]['filef'];
			}
			$data[$k] = $v;
		}
		return $data;
	}

	



}