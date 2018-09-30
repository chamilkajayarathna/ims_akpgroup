<?php
//Clients index page
require ('../../core/init.php');
$page_title = "Client Details";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $user = $users->userdata($_SESSION['id']);
    $username = $user['USERNAME'];
    $logAuth = $user['USER_LEVEL'];
    if ($logAuth != 1) {
        header('Location:' . $global->wwwroot . 'application/login/deny.php');
    }
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}

//Load page Headder
require_once(FOLDER_Template . 'header.php');

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 10;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

$table_Name = 'clients';
$fiels = '*';
$join = NULL;
$where = NULL;
$order = NULL;

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $where, $order, "$from_record_num,$records_per_page");
$num = $stmt->rowCount();

$currentPage = basename(($_SERVER['PHP_SELF']));

if (isset($_SESSION['insert']) && !empty($_SESSION['insert'])) {
    flash('success', '<strong>Success!</strong> New Client successfully Saved.');
    unset($_SESSION['insert']);
    echo "<div class=\"alert alert-success alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}

if (isset($_SESSION['faild'])) {
    //print_r($_SESSION['faild']);
    flash('success', '<strong>Warning!</strong> Faild to Insert New Client.');
    unset($_SESSION['faild']);
    echo "<div class=\"alert alert-danger alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}
if (isset($_SESSION['update']) && !empty($_SESSION['update'])) {
    flash('success', '<strong>Success!</strong> Client successfully Updated.');
    unset($_SESSION['update']);
    echo "<div class=\"alert alert-success alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}
if (isset($_SESSION['faildUpdate'])) {
    //print_r($_SESSION['faild']);
    flash('success', '<strong>Warning!</strong> Faild to Update Client Details.');
    unset($_SESSION['faildUpdate']);
    echo "<div class=\"alert alert-danger alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}
if (isset($_GET['cid'])) {
    //update data 
    if (isset($_POST['update'])) {
        if (is_numeric($_GET['cid'])) {
            $id = $_GET['cid'];
            // get the form data for Update data
            $name = filter_input(INPUT_POST, 'name');
            $address = filter_input(INPUT_POST, 'address');
            $phoneNo = filter_input(INPUT_POST, 'phoneNo');
            $fax = filter_input(INPUT_POST, 'fax');
            $email = filter_input(INPUT_POST, 'email');

            $table_Name = 'clients';
            $data = array('name' => $name,
                'address' => $address,
                'phoneNo' => $phoneNo,
                'fax' => $fax,
                'email' => $email
            );
            if ($dbCRUD->updateData($table_Name, $data, 'cid=' . $cid . ' ')) {
                $_SESSION['update'] = $cid;
                header('Location:clients.php');
            } else {
                $_SESSION['faildUpdate'] = $cid;
                header('Location:clients.php');
            }
        }
    } else {
        // if not submit Select data
        $id = $_GET['cid'];
        $stmtClientData = $dbCRUD->selectAll('clients', '*', NULL, 'cid=' . $id, NULL, NULL);
        while ($row1 = $stmtClientData->fetch(PDO::FETCH_ASSOC)) {
            extract($row1);
            $name = $name;
            $address = $address;
            $phoneNo = $phoneNo;
            $fax = $fax;
            $email = $email;
        }
        //renderForm(NULL, NULL, NULL, NULL, NULL);
        renderForm($name, $address, $phoneNo, $fax, $email);
    }
} else {
    renderForm(NULL, NULL, NULL, NULL, NULL);
    //Insert New data
    if (isset($_POST['add'])) {
        // get the form data to Insert new record
        $name = filter_input(INPUT_POST, 'name');
        $address = filter_input(INPUT_POST, 'address');
        $phoneNo = filter_input(INPUT_POST, 'phoneNo');
        $fax = filter_input(INPUT_POST, 'fax');
        $email = filter_input(INPUT_POST, 'email');
        $table_Name = 'clients';
        $data = array('name' => $name,
            'address' => $address,
            'phoneNo' => $phoneNo,
            'fax' => $fax,
            'email' => $email
        );
        if ($dbCRUD->insertData($table_Name, $data)) {
            $_SESSION['insert'] = $name;
            header('Location:clients.php');
        } else {
            $_SESSION['faild'] = $name;
            header('Location:clients.php');
        }
    }
}
?>
<div class="row">
    
    <div id="message"> <?php flash('success'); ?></div>
    <?php

    function renderForm($name = '', $address = '', $phoneNo = '', $fax = '', $email = '') {
        ?>
    <div id='button' class='right-button-margin'>
        <a href='clients.php' class='btn btn-default pull-left left-margin'>Refresh</a>
        <a href='index.php' class='btn btn-default pull-right left-margin'>Back</a>
        <a href='addProject.php' class='btn btn-default pull-right left-margin'>Add New Project</a>
    </div> 
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php
                        if (isset($_GET['cid'])) {
                            echo 'Update Client Details';
                        } else {
                            echo 'Add New Client';
                        }
                        ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <form action="" method="post">
                        <div class="col-md-6">
                            <table  class='table table-responsive'>
                                <tr>
                                    <td><strong>Name: *</strong></td>
                                    <td>
                                        <input type="text" name="name" value="<?php echo $name ?>" required pattern="^[a-zA-Z. ]+$" class="form-control"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <strong>Address: *</strong></td>
                                    <td> <input type="text" name="address" value="<?php echo $address ?>"  class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td> <strong>Telephone: *</strong></td>
                                    <td>
                                        <input id="phoneNo" name="phoneNo" type="text" value="<?php echo $phoneNo ?>" required pattern="[0-9]{10}" class="form-control"/>
                                    </td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-md-6">
                            <table  class='table table-responsive'>
                                <tr>
                                    <td><strong>Fax Number: *</strong> </td>
                                    <td><input type="text" name="fax" value="<?php echo $fax ?>" required pattern="[0-9]{10}" class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td> <strong>Email ID: *</strong></td>
                                    <td>
                                        <input id="email" name="email" type="text" value="<?php echo $email ?>" class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td> <strong></strong></td>
                                    <td>
                                        <input type="button" name="cancle" value="Cancle" onClick="location.href = 'index.php'" class="btn btn-warning pull-right"/>
                                        <?php
                                        if (isset($_GET['cid'])) {
                                            echo '<input type="submit" name="update" value="Update" class="btn btn-success pull-right  left-margin" />';
                                        } else {
                                            echo '<input type="submit" name="add" value="Add" class="btn btn-success pull-right  left-margin" />';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class='table-responsive'>
            <table id='dataTable' class='table  table-striped table-hover table-responsive table-bordered'>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone No</th>
                        <th>Fax</th>
                        <th>E-mail</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>                   
                    <?php
                    if ($num > 0) {
                        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $rows['name'] . "</td>";
                            echo "<td>" . $rows['address'] . "</td>";
                            echo "<td>" . $rows['phoneNo'] . "</td>";
                            echo "<td>" . $rows['fax'] . "</td>";
                            echo "<td>" . $rows['email'] . "</td>";
                            echo "<td>";
                            echo "<a href='clients.php?id=" . $rows['cid'] . "' class='btn btn-xs btn-warning left-margin'>Edit</a>";
                            echo "<a delete-id='" . $rows['cid'] . "' class='btn btn-xs btn-danger delete-object'>Delete</a>";
                            echo "</td>";
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php
            // paging buttons
            $_SESSION['pageName'] = $currentPage;
            $_SESSION['tableName'] = 'clients';
            require_once (FOLDER_Template . 'paging_employee.php');
        } else {
            echo "<div>No products found.</div>";
        }
        ?>

    </div>
</div>
<script>
    $(document).on('click', '.delete-object', function () {
        var id = $(this).attr('delete-id');
        var q = confirm("Are you sure Delete Machine From database ?");
        if (q === true) {
            $.post('delete.php', {
                delete_id: id
            }, function (data) {
                alert(data);
                location.reload();
            }).fail(function () {
                alert('Something went wrong. Try Again !.');
            });
        }
        return false;
    });
</script>