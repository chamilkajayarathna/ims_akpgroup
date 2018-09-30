<?php
//employee index
require ('../../core/init.php');
$page_title = "Category Details";

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


echo "<div id='message' class='right-button-margin'>";
echo "<a href='index.php' class='btn btn-default pull-right left-margin'>View Employee</a>";
echo "</div>";

$table_Name = 'designation';
$join = 'designation ON resign.designation = number';

$stmt = $dbCRUD->selectAll($table_Name, '*', NULL, NULL, NULL, NULL);
$num = $stmt->rowCount();

$stmt1 = $dbCRUD->selectAll('machinesite', '*', NULL, NULL, NULL, NULL);
$num1 = $stmt1->rowCount();

$currentPage = basename(($_SERVER['PHP_SELF']));
//============================================================================================================
//insert category
if (isset($_POST['sub_category'])) {
    $table_Name = 'designation';
    $txtCategory = filter_input(INPUT_POST, 'txtCategory');

    $data = array('designation' => $txtCategory);
    // Add new record
    if ($dbCRUD->insertData($table_Name, $data)) {
        echo "<script type='text/javascript'>
            alert('New Category Successfully Added.')
                document.location = 'category.php'
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
//update Designation
if (isset($_POST['sub_category_edit'])) {
    $table_Name = 'designation';

    $txtCategoryEdit = filter_input(INPUT_POST, 'txtCategoryEdit');
    $txtCategoryId = filter_input(INPUT_POST, 'txtCategoryId');

    $dataUpdate = array('designation' => $txtCategoryEdit);
    // Add new record
    if ($dbCRUD->updateData($table_Name, $dataUpdate, 'number=' . $txtCategoryId)) {
        echo "<script type='text/javascript'>
            alert('Category Successfully Updated.')
                document.location = 'category.php'
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
if (isset($_POST['sub_work'])) {
    $table_Name1 = 'machinesite';
    $txtCategory1 = filter_input(INPUT_POST, 'txtWork');
    $data = array('siteN' => $txtCategory1);
    // Add new record
    if ($dbCRUD->insertData($table_Name1, $data)) {
        echo "<script type='text/javascript'>
            alert('New Category Successfully Added.')
                document.location = 'category.php'
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
if (isset($_POST['sub_work_edit'])) {
    $table_Name = 'machinesite';

    $txtCategoryEdit = filter_input(INPUT_POST, 'txtWorkEdit');
    $txtCategoryId = filter_input(INPUT_POST, 'txtWorkId');

    $dataUpdate = array('siteN' => $txtCategoryEdit);
    // Add new record
    if ($dbCRUD->updateData($table_Name, $dataUpdate, 'siteNo=' . $txtCategoryId)) {
        echo "<script type='text/javascript'>
            alert('Category Successfully Updated.')
                document.location = 'category.php'
            </script>";
    }
    // if unable to add the record, error message
    else {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "Unable to Update Station!";
        echo "</div>";
    }
}
//============================================================================================================
?>
<div class="row">
    <div class="col-sm-5">
        <div class="panel panel-default" style=" padding: 15px;">  
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Add New Designation</h3>
                </div>
                <div class="panel-body">
                    <form action='category.php' method='post'>
                        <table class='table table-responsive' >
                            <tr>
                                <td>Category Name</td>
                                <td><input type='text' name='txtCategory' class='form-control' value="" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" name="sub_category" class="btn btn-success">Save</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Designation</h3>
                </div>
                <div class="panel-body">
                    <form action='category.php' method='post'>
                        <table class='table table-responsive'>
                            <tr>
                                <td>Edit Category Name</td>
                                <td><input type='text' id="txtCategoryEdit" name='txtCategoryEdit' class='form-control' value="" required>
                                    <input type='hidden' id='txtCategoryId' name='txtCategoryId' value="">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" name="sub_category_edit" class="btn btn-warning">Update</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <div class="panel-body">
                <?php
// display the products if there are any
                if ($num > 0) {
                    echo "<div id='category' class='table-responsive' >";
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
                        echo "<td style='display:none;'>{$number}</td>";
                        echo "<td>{$designation}</td>";
                        echo "<td>";
                        echo "<a class='btn btn-xs btn-warning left-margin' onclick='run();'>Edit</a>";
                        echo "<a cat-id='{$number}' class='btn btn-xs btn-danger cat-object'>Delete</a>";
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
                    <h3 class="panel-title">Add New Work Station</h3>
                </div>
                <div class="panel-body">
                    <form action='category.php' method='post'>
                        <table class='table table-responsive' >
                            <tr>
                                <td>Work Station</td>
                                <td><input type='text' name='txtWork' class='form-control' value="" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" name="sub_work" class="btn btn-success">Save Category</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Work Station</h3>
                </div>
                <div class="panel-body">
                    <form action='category.php' method='post'>
                        <table class='table table-responsive'>
                            <tr>
                                <td>Edit Work Station</td>
                                <td><input type='text' id="txtWorkEdit" name='txtWorkEdit' class='form-control' value="" required>
                                    <input type='hidden' id='txtWorkId' name='txtWorkId' value="">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" name="sub_work_edit" class="btn btn-warning">Update Category</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <div class="panel-body">
                <?php
// display the products if there are any
                if ($num1 > 0) {
                    echo "<div id='work' class='table-responsive' >";
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
                        echo "<td style='display:none;'>{$siteNo}</td>";
                        echo "<td>{$siteN}</td>";
                        echo "<td>";
                        echo "<a class='btn btn-xs btn-warning left-margin' onclick='run1();'>Edit</a>";
                        echo "<a work-id='{$siteNo}' class='btn btn-xs btn-danger work-object'>Delete</a>";
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
    $(document).on('click', '.cat-object', function () {
        var id = $(this).attr('cat-id');
        var q = confirm("Are you sure?");
        if (q == true) {
            $.post('delEmployee.php', {
                cat_id: id
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
        document.getElementById('category').onclick = function (event) {
            event = event || window.event; //for IE8 backward compatibility
            var target = event.target || event.srcElement; //for IE8 backward compatibility
            while (target && target.nodeName != 'TR') {
                target = target.parentElement;
            }
            var cells = target.cells; //cells collection
            if (!cells.length || target.parentNode.nodeName == 'THEAD') { // if clicked row is within thead
                return;
            }
            //var f1 = document.getElementById('Category');
            txtCategoryEdit.value = cells[1].innerHTML;
            txtCategoryId.value = cells[0].innerHTML;
        }
    }
//============================================================================================================== 
//==============================================================================================================   
    $(document).on('click', '.work-object', function () {
        var id = $(this).attr('work-id');
        var q = confirm("Are you sure?");
        if (q == true) {
            $.post('delEmployee.php', {
                work_id: id
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
        document.getElementById('work').onclick = function (event) {
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
            txtWorkEdit.value = cells[1].innerHTML;
            txtWorkId.value = cells[0].innerHTML;

        }
    }
</script>

<?php
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
