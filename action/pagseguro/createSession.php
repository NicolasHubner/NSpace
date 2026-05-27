<?php
  include('../../lib/Config.php');
  try {
    //code...
    \PagSeguro\Library::initialize();
    \PagSeguro\Library::cmsVersion()->setName("NSPACE")->setRelease("1.0.0");
    \PagSeguro\Library::moduleVersion()->setName("NSPACE")->setRelease("1.0.0");

    $sessionCode = \PagSeguro\Services\Session::create(
      \PagSeguro\Configuration\Configure::getAccountCredentials()
    );
    $data['session'] = $sessionCode->getResult();

    echo json_encode($data);
  } catch (Exception $e) {
    echo $e->getMessage();
  }
?>