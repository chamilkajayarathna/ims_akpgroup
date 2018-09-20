<?php
//employee index
require ('../../core/init.php');
$page_title = "Machine Details";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
//Load page Headder
require_once(FOLDER_Template . 'header.php');


// create product button
echo "<div class='right-button-margin'>";
echo "<a href='addEditMachine.php' class='btn btn-default pull-right'>Add New Machine</a>";
echo "<a href='addServiceDetails.php' class='btn btn-default pull-right left-margin'>Add Service Details</a>";
echo "<a href='editCategory.php' class='btn btn-default pull-right left-margin'>Edit Category</a>";
echo "</div>";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 10;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

//$stmt = $dbCRUD->selectAll('products', '*', NULL, NULL, 'name ASC', "$from_record_num,$records_per_page");
$table_Name = 'machine m,machinename mn,machinebrand mb, machinesite ms';
$fiels = 'm.id,mn.machineCategory,m.machineNo,m.machineName, mb.brandName, m.model, ms.siteN';
$join = NULL;
$whereCond = 'mn.nameIdMachine=m.nameId AND mb.brandNo=m.brand AND ms.siteNo=m.siteName';
$order = 'm.id ASC';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $whereCond, $order, "$from_record_num,$records_per_page");
$num = $stmt->rowCount();

$currentPage = basename(($_SERVER['PHP_SELF']));
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
                        Machine Name<input type="text" class="form-control" id="machine" placeholder="Enter Employee Name">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
// display the products if there are any
if ($num > 0) {
    echo "<div class='table-responsive'>";
    echo "<table id='dataTable' class='table  table-striped table-hover table-responsive table-bordered'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Machine</th>";
    echo "<th>Machine  No</th>";
    echo "<th>Name</th>";
    echo "<th>Brand</th>";
    echo "<th>Model No</th>";
    //echo "<th>Site</th>";
    if ($logAuth == 1) {
        echo "<th>Actions</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$machineCategory}</td>";
        echo "<td>{$machineNo}</td>";
        echo "<td><a href='machineDetails.php?id={$id}' class='btn btn-xs btn-info left-margin'>{$machineName}</a></td>";
        echo "<td>{$brandName}</td>";
        echo "<td>{$model}</td>";
       // echo "<td>{$siteN}</td>";
        if ($logAuth == 1) {
            echo "<td>";
            echo "<a href='addEditMachine.php?id={$id}' class='btn btn-xs btn-warning left-margin'>Edit</a>";
            echo "<a delete-id='{$id}' class='btn btn-xs btn-danger delete-object'>Delete</a>";
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    // paging buttons
    $_SESSION['pageName'] = $currentPage;
    $_SESSION['tableName'] = 'machine';
    require_once (FOLDER_Template . 'paging_employee.php');
}
// tell the user there are no products
else {
    echo "<div>No Records found.</div>";
}
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
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
<!--AJAX Search-->
<script src="<?php echo WWWROOT ?>application/assets/ajaxSearch.js"></script>