<?php
class MediasController extends AppController{
    
    public $components = array('Media.Img');
    public $order = array('Media.position ASC'); 

    function beforeFilter(){
        parent::beforeFilter(); 
        $this->layout = 'uploader';
    }

    /**
    * Permet de cropper les images
    **/
    function crop(){ 
        extract($_GET);
        $images = glob(IMAGES.$org.'.*');
        if(empty($images)){
            die(); 
        }else{
            $image = current($images); 
        }
        if($this->Img->redim($image,$dest,$w,$h)){
            header("Content-type: image/jpg");
            echo file_get_contents($dest);
            exit();
        }
    }

    /**
    * Liste les médias
    **/
    function admin_index($ref,$ref_id){
        $d['ref'] = $ref;
        $d['ref_id'] = $ref_id;
        $medias = $this->Media->find('all',array(
            'conditions' => array('ref_id' => $ref_id,'ref' => $ref)
        )); 
        $d['medias'] = $medias;
        $this->set($d);
    }

    /**
    * Upload (Ajax)
    **/
    function admin_upload($ref,$ref_id){
        $this->Media->save(array(
            'ref'    => $ref,
            'ref_id' => $ref_id,
            'file'   => $_FILES['file']
        ));
        $d['v'] = current($this->Media->read());
        $this->set($d);
        $this->layout = false; 
        $render = $this->render('admin_media'); 
        die($render);
    }

    /**
    * Suppression (Ajax)
    **/
    function admin_delete($id){
        $this->Media->delete($id); 
        die(); 
    }

    function admin_order(){
        print_r($this->request->data); 
        if(!empty($this->request->data['Media'])){
            foreach($this->request->data['Media'] as $k=>$v){
                $this->Media->id = $k;
                $this->Media->saveField('position',$v); 
            }
        }
        die(); 
    }
    

}