<?php
require ('../../core/init.php');

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}

//Delete Client
if (isset($_POST['delete_id'])) {
    // set product id to be deleted
    $id = $_POST['delete_id'];
    // delete the product
    if ($dbCRUD->deleteRow('clients', 'id='.$id)) {
        echo "Client Successfully Deleted from Database.";
    } else {
        echo "Unable to delete Client.";
    }
}

//Delete Project
if (isset($_POST['project_delete_id'])) {
    // set product id to be deleted
    $id = $_POST['project_delete_id'];
    // delete the product
    if ($dbCRUD->deleteRow('contractdetails', 'id='.$id)) {
        echo "Project Successfully Deleted from Database.";
    } else {
        echo "Unable to delete Project.";
    }
}