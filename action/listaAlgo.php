<?php
    include("../lib/Config.php");

    $retCliente = Doctrine_Query::create()->select()->from('Cliente')->execute();
    echo json_encode(['data' => $retCliente->toArray()]);