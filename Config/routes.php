<?php
Router::connect('/admin/medias/*', array('controller' => 'medias', 'action' => 'index','admin'=>true));

