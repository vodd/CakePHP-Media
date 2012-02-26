<div class="bloc">
    <div class="content">
		<div id="plupload">
		    <div id="droparea" href="#">
		    	<p>Déplacer les fichiers ici</p>
		    	ou<br/>
		    	<a id="browse" href="#">Parcourir</a> 
		    </div>
		</div>
		<table class="head" cellspacing="0">
			<thead>
				<tr>
					<th style="width:55%">Médias</th>
					<th style="width:20%">Ordre</th>
					<th style="width:25%">Actions</th>
				</tr>
			</thead>
		</table>
		<div id="filelist">
			<?php echo $this->Form->create('Media',array('url'=>array('controller'=>'medias','action'=>'order'))); ?>
			<?php foreach($medias as $v): $v = current($v);  ?>
				<?php require('admin_media.ctp'); ?>
			<?php endforeach; ?>
			<?php echo $this->Form->end(); ?>
		</div>

    </div>
</div>

<?php $this->Html->script('/media/js/jquery.form.js',array('inline'=>false)); ?>
<?php $this->Html->script('/media/js/plupload.js',array('inline'=>false)); ?>
<?php $this->Html->script('/media/js/plupload.html5.js',array('inline'=>false)); ?>
<?php $this->Html->script('/media/js/plupload.flash.js',array('inline'=>false)); ?>

<?php $this->Html->scriptStart(array('inline'=>false)); ?>

jQuery(function(){

	$( "#filelist>form" ).sortable({
		update:function(){
			i = 0; 
			$('#filelist>form>div').each(function(){
				i++;
				$(this).find('input').val(i); 
			});
			$('#MediaAdminIndexForm').ajaxSubmit(); 
		}
	});

	var uploader = new plupload.Uploader({
		runtimes : 'html5,flash',
		container: 'plupload',		
		browse_button : 'browse',
		max_file_size : '10mb',
		flash_swf_url : '<?php echo Router::url('/media/js/plupload/plupload.flash.swf'); ?>',
		url : '<?php echo Router::url(array('controller'=>'medias','action'=>'upload',$ref,$ref_id)); ?>',
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
		],
		drop_element : 'droparea',
		multipart:true,
		urlstream_upload:true
	});

	uploader.init();

	uploader.bind('FilesAdded', function(up, files) {
		for (var i in files) {
			$('#filelist>form').prepend('<div class="item" id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <div class="progressbar"><div class="progress"></div></div></div>');
		}
		uploader.start();
		$('#droparea').removeClass('dropping'); 
	});

	uploader.bind('UploadProgress', function(up, file) {
		$('#'+file.id).find('.progress').css('width',file.percent+'%')
	});

	uploader.bind('FileUploaded', function(up, file, response){
		$('#'+file.id).after(response.response);
		$('#'+file.id).remove()
	});

	$('#droparea').bind({
       dragover : function(e){
           $(this).addClass('dropping'); 
       },
       dragleave : function(e){
           $(this).removeClass('dropping'); 
       }
	});

	$('a.del').live('click',function(e){
		e.preventDefault(); 
		elem = $(this); 
		if(confirm('Voulez vous vraiment supprimer ce média ?')){
			$.post(elem.attr('href'),{},function(data){
				elem.parents('.item').slideUp();
			});
		}
	});

	$('a.toggle').live('click',function(e){
		e.preventDefault();
		var a = $(this);
		if(a.text() == 'Afficher'){
			a.text('Cacher');
			a.parent().parent().animate({
				height : 40 + a.parent().parent().find('.expand').outerHeight()
			});
		}else{
			a.text('Afficher');
			a.parent().parent().animate({
				height : 40
			});
		}
	});

});

<?php $this->Html->scriptEnd(); ?>
