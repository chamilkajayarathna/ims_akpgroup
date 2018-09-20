<?php

require 'core/init.php';
//$general->logged_out_protect();
//$general->deny();
$addNewFirst = $users->firstTimeUserAdd();
if ($addNewFirst === false) {
    $general->register();
} else {

    header('Location: register.php');
}
?>					
