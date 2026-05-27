<?php

include("../lib/Config.php");
print_r($_POST);

try {

    // Insert
    $objProduto						= Doctrine_Core::getTable($_POST['tabela'])->find($_POST['id']);
    $objProduto->status			= $_POST['status'];
    $objProduto->save();
    // $id_produto = $_POST['id'];


} catch(Exception $e){
	echo $e;	
}
print_r($_POST);
echo "ae";
