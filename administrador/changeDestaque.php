<?php

include("../lib/Config.php");
print_r($_POST);

try {

    // Insert
    $objVeiculo						= Doctrine_Core::getTable('Veiculo')->find($_POST['id']);
    $objVeiculo->destaque			= $_POST['destaque'];
    $objVeiculo->save();
    // $id_produto = $_POST['id'];


} catch(Exception $e){
	echo $e;	
}
print_r($_POST);
echo "ae";
