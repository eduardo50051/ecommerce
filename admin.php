<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;



$app->get('/admin', function() {
    
	User::verifyLogin();

	$page = new PageAdmin();
	
	$page->setTpl("index");
	
	
});

$app->get('/admin/login', function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false

	]);

	$page->setTpl("login");


});

$app->post('/admin/login', function(){

	User::login($_POST["login"], $_POST["password"]);

	header("location: /ecommerce/admin");
	exit;


});

$app->get('/admin/logout', function(){

	User::logout();

	header("Location: /ecommerce/admin/login");
	exit;


});

?>