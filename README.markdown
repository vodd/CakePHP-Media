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

Moreover the behavior add a "terms" virtual field within your find results (if you properly set the recursive) and a "Taxonomy" index containing all
your terms indexed by their type.
If you want to create checkboxes for editing a specifing Taxonomy
	
	$this->Form->input('Model.terms.type',array('type'=>'select','multiple'=>'checkbox','options'=>$options));

For instance if you want to edit the pet of an User

	$this->Form->input('Model.terms.pet',array('type'=>'select','multiple'=>'checkbox','options'=>$pets)))

If you want to find the list of some terms

	$this->Model->listTerms('pet','category','tag',....);


The Helper
-------------------------------------------------------
The Uploader helper allow you to create a quick and easy Upload system
Firstly you have to load the Helper

	public $helper = array('Html','Form','Media.Uploader');

To create a quick and easy media manager use
	
	$this->Uploader->iframe('MODELNAME',ID);

You can also create a quick tinyMCE that support the media manager using
	
	$this->Uploader->tinymce('fieldname'); 

