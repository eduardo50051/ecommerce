<?php

use \Hcode\PageAdmin;
use \Hcode\Page;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use \Hcode\Model\Product;


$app->get("/admin/categories", function() {

	User::verifyLogin();

	$categories = Category::listAll();

	$page = new PageAdmin();

	$page->setTpl("categories", [
		'categories'=>$categories
	]);


});


$app->get("/admin/categories/create", function() {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("categories-create");


});

$app->post("/admin/categories/create", function() {

	User::verifyLogin();

$category = new Category();

$category->setData($_POST);

$category->save();

header('Location: /ecommerce/admin/categories');
exit;


});


$app->get("/admin/categories/:idcategory/delete", function($idcategory){

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header('Location: /ecommerce/admin/categories');
	exit;

});


$app->get("/admin/categories/:idcategory", function($idcategory){

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl("categories-update", [
		'category'=>$category->getValues()
	]);


});



$app->post("/admin/categories/:idcategory", function($idcategory){

User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header('Location: /ecommerce/admin/categories');
	exit;


});


$app->get("/categories/:idcategory", function($idcategory){

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new Page();

	$page->setTpl("category", [
		'category'=>$category->getValues(),
		'products'=>[]
	]);


});




?>