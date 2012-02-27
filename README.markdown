Media Plugin for CakePHP 2.0 Alpha
============================================================


Installation
-------------------------------------------------------
Copy this plugin in a directory called "Taxonomy" inside of your plugin directory
You can now load the plugin in your bootstrap.php using

    CakePlugin::load('Media');

After you have to create the two tables (terms and term_relationships)
You can create theses tables easily using the CakePHP Console :

	cake Media.create

The behavior
-------------------------------------------------------

To bind the Media manager on your model use : 

	public $actsAs = array('Media.Media'); 

You can configure the path for the media using 
	
	public $uploads = "uploads/%y/%m/%f"

%y  = Year
%m  = Month
%f  = Filename
%id = ID
%mid= ID/1000

If you want to use a thumb for your content you can save a file called "thumb". 

	$this->Form->input('thumb',array('type'=>file));

The thumb will be automatically uploaded and saved in the media table, and the media id is saved in the "media_id" field of the Model.

The Helper
-------------------------------------------------------
The Uploader helper allow you to create a quick and easy Upload system
Firstly you have to load the Helper

	public $helper = array('Html','Form','Media.Uploader');

To create a quick and easy media manager use
	
	$this->Uploader->iframe('MODELNAME',ID);

You can also create a quick tinyMCE that support the media manager using
	
	$this->Uploader->tinymce('fieldname'); 

