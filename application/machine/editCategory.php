<?php
//employee index
require ('../../core/init.php');
$page_title = "Machine Category Details";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $user = $users->userdata($_SESSION['id']);
    $username = $user['username'];
    $logAuth = $user['userLevel'];
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


//End of headder

$table_Name = 'machinename';
$join = 'designation ON resign.designation = number';

$stmt = $dbCRUD->selectAll($table_Name, '*', NULL, NULL, NULL, NULL);
$num = $stmt->rowCount();

$stmt1 = $dbCRUD->selectAll('machinebrand', '*', NULL, NULL, NULL, NULL);
$num1 = $stmt1->rowCount();

$currentPage = basename(($_SERVER['PHP_SELF']));
//============================================================================================================
//insert category
if (isset($_POST['sub_mch_name'])) {
    $table_Name = 'machinename';
    $txtMchName = filter_input(INPUT_POST, 'txt_mch_name');

    $data = array('machineCategory' => $txtMchName);
    // Add new record
    if ($dbCRUD->insertData($table_Name, $data)) {
        echo "<script type='text/javascript'>
            alert('New Category Successfully Added.')
                document.location = 'editCategory.php'
            </script>";
    }
    // if unable to add the record, error message
    else {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "Unable to save Category.";
        echo "</div>";
    }
}
//============================================================================================================
//update 
if (isset($_POST['sub_edit'])) {
    $table_Name = 'machinename';

    $txtEdit = filter_input(INPUT_POST, 'txt_edit');
    $txtId = filter_input(INPUT_POST, 'txt_id');
    print_r($txtId);
    $dataUpdate = array('machineCategory' => $txtEdit);
    // Add new record
    if ($dbCRUD->updateData($table_Name, $dataUpdate, 'nameIdMachine=' . $txtId)) {
        echo "<script type='text/javascript'>
            alert('Category Successfully Updated.')
                document.location = 'editCategory.php'
            </script>";
    }
    // if unable to add the record, error message
    else {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "Unable to Update!";
        echo "</div>";
    }
}
//============================================================================================================
//insert Work Station
if (isset($_POST['sub_brand'])) {
    $table_Name1 = 'machinebrand';
    $txtCategory1 = filter_input(INPUT_POST, 'txtBrand');
    $data = array('brandName' => $txtCategory1);
    // Add new record
    if ($dbCRUD->insertData($table_Name1, $data)) {
        echo "<script type='text/javascript'>
            alert('New Category Successfully Added.')
                document.location = 'editCategory.php'
            </script>";
    }
    // if unable to add the record, error message
    else {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "Unable to save Category.";
        echo "</div>";
    }
}
//============================================================================================================
//============================================================================================================
//update work station
if (isset($_POST['sub_edit1'])) {
    $table_Name = 'machinebrand';

    $txtCategoryEdit = filter_input(INPUT_POST, 'txtEdit1');
    $txtCategoryId = filter_input(INPUT_POST, 'txtId1');
 
    $dataUpdate = array('brandName' => $txtCategoryEdit);
    // Add new record
    if ($dbCRUD->updateData($table_Name, $dataUpdate, 'brandNo=' . $txtCategoryId)) {
        echo "<script type='text/javascript'>
            alert('Category Successfully Updated.')
                document.location = 'editCategory.php'
            </script>";
    }
    // if unable to add the record, error message
    else {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "Unable to Update Brand Name!";
        echo "</div>";
    }
}
//============================================================================================================
?>
<div class="row">
    <div id='button' class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-right'>Back</a>
        <a href='editCategory.php' class='btn btn-default pull-right left-margin'>Add Categories</a>
        <a href='addServiceDetails.php' class='btn btn-default pull-right left-margin'>Add Service Details</a>
        
    </div>
    
    <div class="col-sm-5">
        <div class="panel panel-default" style=" padding: 15px;">  
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Add New Machine Name Category</h3>
                </div>
                <div class="panel-body">
                    <form action='editCategory.php' method='post'>
                        <table class='table table-responsive' >
                            <tr>
                                <td>Category Name</td>
                                <td><input type='text' name='txt_mch_name' class='form-control' value="" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" name="sub_mch_name" class="btn btn-success">Save Category</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Category</h3>
                </div>
                <div class="panel-body">
                    <form action='editCategory.php' method='post'>
                        <table class='table table-responsive'>
                            <tr>
                                <td>Edit Machine Name Category</td>
                                <td><input type='text' id="txt_edit" name='txt_edit' class='form-control' value="" required>
                                    <input type='hidden' id='txt_id' name='txt_id' value="">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" name="sub_edit" class="btn btn-warning">Update Category</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <div class="panel-body">
                <?php
// display the products if there are any
                if ($num > 0) {
                    echo "<div id='table1' class='table-responsive' >";
                    echo "<table class='table table-striped table-hover table-responsive table-bordered'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th style='display:none;'>ID</th>";
                    echo "<th>Category</th>";
                    echo "<th>Actions</th>";
                    echo "</tr>";
                    echo "</thead>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>";
                        echo "<td style='display:none;'>{$nameIdMachine}</td>";
                        echo "<td>{$machineCategory}</td>";
                        echo "<td>";
                        echo "<a class='btn btn-xs btn-warning left-margin' onclick='run();'>Edit</a>";
                        echo "<a name-id='{$nameIdMachine}' class='btn btn-xs btn-danger name-object'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
// tell the user there are no products
                else {
                    echo "<div>No products found.</div>";
                }
                ?>
            </div>
        </div>
    </div><!-- /.col-sm-4 -->
    
<!--Work Station 
------------------------------------------------------------------------------------------------------------------------>
    <div class="col-sm-5">
        <div class="panel panel-default" style=" padding: 15px;">  
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Add NeW Brand</h3>
                </div>
                <div class="panel-body">
                    <form action='editCategory.php' method='post'>
                        <table class='table table-responsive' >
                            <tr>
                                <td>Work Station</td>
                                <td><input type='text' name='txtBrand' class='form-control' value="" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" name="sub_brand" class="btn btn-success">Save Category</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Brand</h3>
                </div>
                <div class="panel-body">
                    <form action='editCategory.php' method='post'>
                        <table class='table table-responsive'>
                            <tr>
                                <td>Edit Brand Name</td>
                                <td><input type='text' id="txtEdit1" name='txtEdit1' class='form-control' value="" required>
                                    <input type='hidden' id='txtId1' name='txtId1' value="">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" name="sub_edit1" class="btn btn-warning">Update Category</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <div class="panel-body">
                <?php
// display the products if there are any
                if ($num1 > 0) {
                    echo "<div id='brand' class='table-responsive' >";
                    echo "<table class='table table-striped table-hover table-responsive table-bordered'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th style='display:none;'>ID</th>";
                    echo "<th>Category</th>";
                    echo "<th>Actions</th>";
                    echo "</tr>";
                    echo "</thead>";
                    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                        extract($row1);
                        echo "<tr>";
                        echo "<td style='display:none;'>{$brandNo}</td>";
                        echo "<td>{$brandName}</td>";
                        echo "<td>";
                        echo "<a class='btn btn-xs btn-warning left-margin' onclick='run1();'>Edit</a>";
                        echo "<a brand-id='{$brandNo}' class='btn btn-xs btn-danger brand-object'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
// tell the user there are no products
                else {
                    echo "<div>No products found.</div>";
                }
                ?>
            </div>
        </div>
    </div><!-- /.col-sm-4 -->
</div>


<script>
    $(document).on('click', '.name-object', function () {
        var id = $(this).attr('name-id');
        var q = confirm("Are you sure?");
        if (q == true) {
            $.post('delete.php', {
                name_id: id
            }, function (data) {
                alert(data);
                location.reload();
            }).fail(function () {
                alert('Something went wrong. Try Again !.');
            });
        }
        return false;
    });
    
    function run() {
        document.getElementById('table1').onclick = function (event) {
            event = event || window.event; //for IE8 backward compatibility
            var target = event.target || event.srcElement; //for IE8 backward compatibility
            while (target && target.nodeName != 'TR') {
                target = target.parentElement;
            }
            var cells = target.cells; //cells collection
            //var cells = target.getElementsByTagName('td'); //alternative
            if (!cells.length || target.parentNode.nodeName == 'THEAD') { // if clicked row is within thead
                return;
            }
            //var f1 = document.getElementById('Category');
            txt_edit.value = cells[1].innerHTML;
            txt_id.value = cells[0].innerHTML;
        }
    }
//============================================================================================================== 
//==============================================================================================================   
    $(document).on('click', '.brand-object', function () {
        var id = $(this).attr('brand-id');
        var q = confirm("Are you sure?");
        if (q == true) {
            $.post('delete.php', {
                brand_id: id
            }, function (data) {
                alert(data);
                location.reload();
            }).fail(function () {
                alert('Something went wrong. Try Again !.');
            });
        }
        return false;
    });
    function run1() {

        document.getElementById('brand').onclick = function (event) {
            event = event || window.event; //for IE8 backward compatibility
            var target = event.target || event.srcElement; //for IE8 backward compatibility
            while (target && target.nodeName != 'TR') {
                target = target.parentElement;
            }
            var cells = target.cells; //cells collection
            //var cells = target.getElementsByTagName('td'); //alternative
            if (!cells.length || target.parentNode.nodeName == 'THEAD') { // if clicked row is within thead
                return;
            }
            //var f1 = document.getElementById('Category');
            txtEdit1.value = cells[1].innerHTML;
            txtId1.value = cells[0].innerHTML;
        }
    }
</script>

<?php
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
