<?php
//employee index
require ('../../core/init.php');
$page_title = "Resigned Employee Details";

$user = $users->userdata($_SESSION['id']);
$username = $user['USERNAME'];
$logAuth = $user['USER_LEVEL'];


if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
//Load page Headder
require_once(FOLDER_Template . 'header.php');

// create product button
echo "<div id='message' class='right-button-margin'>";
echo "<a href='index.php' class='btn btn-default pull-right'>View Employee</a>";
echo "</div>";
?>

<div class="row">
    <div class="col-lg-12">
        <form role="form" method="post">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Search</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group col-lg-3">
                        EPF number<input type="text" class="form-control" id="epfResigned" placeholder="Enter EPF Number">
                    </div>
                    <div class="form-group col-lg-3">
                        Employee Name<input type="text" class="form-control" id="nameResigned" placeholder="Enter Employee Name">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<a href="printResignedEmployees.php">Print Preview</a>
<?php
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 10;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

$table_Name = 'resign';
$fiels = 'resign.*,designation.designation';
$join = 'designation ON resign.designation = number';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, NULL, 'serial_no ASC', "$from_record_num,$records_per_page");
$num = $stmt->rowCount();
$currentPage = basename(($_SERVER['PHP_SELF']));
// display the products if there are any
if ($num > 0) {
    echo "<div class='table-responsive'>";
    echo "<table id='dataTable' class='table table-hover table-responsive table-bordered'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Designation</th>";
    echo "<th>EPF No</th>";
    echo "<th>NIC</th>";
    echo "<th>Date of Birth</th>";
    echo "<th>Address</th>";
    echo "<th>Contact</th>";
    if ($logAuth == 1) {
        echo "<th>Actions</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td class='col-md-4'><a href='resignedEmpDetail.php?eid=$serial_no&name=$name'>{$name}</a></td>";
        echo "<td>{$designation}</td>";
        echo "<td>{$epf_no}</td>";
        echo "<td>{$nic}</td>";
        echo "<td>{$dob}</td>";
        echo "<td class='col-md-4'>{$address}</td>";
        echo "<td>{$contact}</td>";
        if ($logAuth == 1) {
            echo "<td class='col-md-1'>";
        echo "<a delete-id='{$serial_no}' class='btn btn-xs btn-danger delete-object'>Delete</a>";
        echo "</td>";
        }
        
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    // paging buttons
    $_SESSION['pageName'] = $currentPage;
    $_SESSION['tableName'] = $table_Name;
    require_once (FOLDER_Template . 'paging_employee.php');
}

// tell the user there are no products
else {
    echo "<div>No products found.</div>";
}
?>

<script>
    $(document).on('click', '.delete-object', function () {
        var id = $(this).attr('delete-id');
        var q = confirm("Are you sure?");

        if (q == true) {
            $.post('delEmployee.php', {
                object_id: id
            }, function (data) {
                alert(data);
                location.reload();

            }).fail(function () {
                alert('Unable to delete Employee.');
            });
        }

        return false;
    });
</script>

<?php
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
<!--AJAX Search-->
<script src="<?php echo WWWROOT ?>application/assets/ajaxSearch.js"></script>