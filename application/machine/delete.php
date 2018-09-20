<?php
require ('../../core/init.php');

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
if (isset($_POST['delete_id'])) {
    // set product id to be deleted
    $id = $_POST['delete_id'];
    // delete the product
    if ($dbCRUD->deleteRow('machine', 'id='.$id)) {
        echo "Machine Successfully Deleted from Database.";
    } else {
        echo "Unable to delete Machine.";
    }
}

//Delete Service
if (isset($_POST['del_ser_id'])) {
    // set product id to be deleted
    $id = $_POST['del_ser_id'];
    // delete the product
    if ($dbCRUD->deleteRow('machineservice', 'id='.$id)) {
        echo "Machine Successfully Deleted from Database.";
    } else {
        echo "Unable to delete Machine.";
    }
}

// Delete Category
if (isset($_POST['name_id'])) {
    // set product id to be deleted
    $id = $_POST['name_id'];
    // delete the product
    $where ='nameIdMachine=' . $id. ' AND nameIdMachine NOT IN (SELECT nameId FROM machine WHERE nameId ='.$id.')';
    if ($dbCRUD->deleteRow('machinename',$where )) {
        echo "Category Successfully Deleted from Database.";
    } else {
        echo "Category still Functioning. Could not Delete!";
    }
}

// Delete Category
if (isset($_POST['brand_id'])) {
    // set product id to be deleted
    $id = $_POST['brand_id'];
    // delete the product
    $where ='brandNo=' . $id. ' AND brandNo NOT IN (SELECT brand FROM machine WHERE brand ='.$id.')';
    if ($dbCRUD->deleteRow('machinebrand',$where )) {
        echo "Category Successfully Deleted from Database.";
    } else {
        echo "Category still Functioning. Could not Delete!";
    }
}
?>
