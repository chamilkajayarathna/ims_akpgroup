<?php
require ('../../core/init.php');

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}

if (isset($_POST['object_id'])) {
    // set product id to be deleted
    $id = $_POST['object_id'];
    // delete the product
    if ($dbCRUD->deleteRow('resign', 'serial_no=' . $id)) {
        echo "Employee Successfully Deleted from Database.";
    } else {
        echo "Unable to delete.";
    }
}

if (isset($_POST['resign_id'])) {
    // set product id to be deleted
    $id = $_POST['resign_id'];

    //select record and insert to resign
    $table_Name = 'employee';
    $fiels = 'employee.*,employee.designation AS desigID,designation.designation';
    $join = 'designation ON employee.designation = number';
    $stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, 'serial_no=' . $id, NULL, NULL);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $data = array('serial_no' => $serial_no,
            'designation' => $desigID,
            'name' => $name,
            'epf_no' => $epf_no,
            'appoinment_date' => $appoinment_date,
            'nic' => $nic,
            'dob' => $dob,
            'address' => $address,
            'contact' => $contact,
            'workSite' => $workSite,
            'img' => $img,
            'basicSalary' => $basicSalary,
            'workTarget' => $workTarget,
            'spIntencive' => $spIntencive,
            'difficult' => $difficult,
            'other' => $other
        );
        $dbCRUD->insertData('resign', $data);
    }

    if ($dbCRUD->deleteRow($table_Name, 'serial_no=' . $id)) {
        echo "Employee Successfully Resigned from the Database.";
    } else {
        echo "Unable to delete.";
    }
}

// Delete Category
if (isset($_POST['cat_id'])) {
    // set product id to be deleted
    $id = $_POST['cat_id'];
    // delete the product
    $where ='number=' . $id. ' AND number NOT IN (SELECT designation FROM employee WHERE designation ='.$id.')';
    if ($dbCRUD->deleteRow('designation',$where )) {
        echo "Category Successfully Deleted from Database.";
    } else {
        echo "Category still Functioning. Could not Delete!";
    }
}

if (isset($_POST['work_id'])) {
    // set product id to be deleted
    $id = $_POST['work_id'];
    // delete the product
    $where ='siteNo=' . $id. ' AND siteNo NOT IN (SELECT workSite FROM employee WHERE siteNo ='.$id.')';
    if ($dbCRUD->deleteRow('machinesite',$where )) {
        echo "Category Successfully Deleted from Database.";
    } else {
        echo "Category still Functioning. Could not Delete!";
    }
}

if (isset($_POST['user_id_del'])) {
    // set product id to be deleted
    $id = $_POST['user_id_del'];
    // delete the product
    $where ='id=' . $id;
    if ($dbCRUD->deleteRow('users',$where )) {
        echo "User Successfully Deleted from Database.";
    } else {
        echo "SORRY! Could not Delete!";
    }
}
?>