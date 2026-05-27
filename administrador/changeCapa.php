<?php

include("../lib/Config.php");

try {

    // Insert
    $obj				= Doctrine_Core::getTable($_POST['tabela'])->find($_POST['id']);
    $obj->capa			= $_POST['capa'];
    $obj->save();
    // $id_produto = $_POST['id'];


} catch(Exception $e){
	echo $e;	
}
print_r($_POST);
echo "ae";
