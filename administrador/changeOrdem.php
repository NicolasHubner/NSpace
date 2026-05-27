<?php

include("../lib/Config.php");
print_r($_POST);

try {

    // Insert
    $obj				= Doctrine_Core::getTable($_POST['tabela'])->find($_POST['id']);
    $obj->ordem			= $_POST['ordem'];
    $obj->save();
    // $id_produto = $_POST['id'];


} catch(Exception $e){
	echo $e;	
}
print_r($_POST);
echo "ae";
