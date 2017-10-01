<?php
return array (
		'name' => 'MUIC',
		'defaultController' => 'Dashboard',
		'import' => array (
				'application.models.*',
				'application.components.*' 
		),
		'components' => array (
				'urlManager' => array (
						'urlFormat' => 'path' 
				),
				'db' => array (
						'class' => 'CDbConnection',
						'connectionString' => 'mysql:host=localhost;dbname=prdappne_itechservicedb',
						'emulatePrepare' => true,
						'username' => 'root',
						'password' => 'P@ssw0rd',
						'charset' => 'utf8' 
				) 
		) 
);
?>