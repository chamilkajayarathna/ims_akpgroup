<?php
//employee index
require ('../../core/init.php');
$page_title = "Employee Details";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}

//Load page Headder
require_once(FOLDER_Template . 'header.php');
?>
<div class="row">
    <div id='button' class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-left left-margin'>Refresh</a>
        <a href='addEmployee.php' class='btn btn-default pull-right left-margin'>Add New Employee</a>
        <a href='editEmployee.php' class='btn btn-default pull-right left-margin'>Edit Employee</a>
        <a href='category.php' class='btn btn-default pull-right left-margin'>Category Details</a>
    </div>
    <div class="col-lg-12">
        <form role="form" method="post">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Search</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group col-lg-3">
                        EPF number<input type="text" class="form-control" id="keyword" placeholder="Enter EPF Number">
                    </div>
                    <div class="form-group col-lg-3">
                        Employee Name<input type="text" class="form-control" id="name" placeholder="Enter Employee Name">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 10;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

//$stmt = $dbCRUD->selectAll('products', '*', NULL, NULL, 'name ASC', "$from_record_num,$records_per_page");
//$table_Name = 'employee e, designation d, machine_site m';
//$fiels = 'e.SERIAL_NO,e.NAME_WITH_INITIALS,e.EPF_NO,e.APPOINTMENT_DATE,e.NIC,e.DOB,e.ADDRESS,e.CONTACT,m.SITEN,d.DESIGNATION_ID';
//$join = NULL;
//$where = 'e.DESIGNATION_ID= d.NUMBER AND e.WORKSITE = m.SITENO';

$table_Name = 'employee e, designation d';
$fiels = 'e.SERIAL_NO,e.NAME_WITH_INITIALS,e.EPF_NO,e.APPOINTMENT_DATE,e.NIC,e.DATE_OF_BIRTH,e.ADDRESS,e.PHONE,d.NAME DESIGNATION';
$join = NULL;
$where = 'e.DESIGNATION_ID=d.ID AND e.STATUS=1';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $where, 'SERIAL_NO ASC', "$from_record_num,$records_per_page");
$num = $stmt->rowCount();


$currentPage = basename(($_SERVER['PHP_SELF']));
// display the products if there are any
if ($num > 0) {
    echo "<div class='table-responsive'>";
    echo "<table id='dataTable' class='table table-striped table-hover table-responsive table-bordered'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Designation</th>";
    echo "<th>EPF No</th>";
     echo "<th>Appoinment Date</th>";
    echo "<th>NIC</th>";
    echo "<th>Date of Birth</th>";
    echo "<th>Address</th>";
    echo "<th>Contact</th>";
//    echo "<th>Location</th>";
    echo "</tr>";
    echo "</thead>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td class='col-md-4'>{$NAME_WITH_INITIALS}</td>";
        echo "<td>{$DESIGNATION}</td>";
        echo "<td>{$EPF_NO}</td>";
        echo "<td class='col-md-1'>{$APPOINTMENT_DATE}</td>";
        echo "<td>{$NIC}</td>";
        echo "<td>{$DATE_OF_BIRTH}</td>";
        echo "<td class='col-md-4'>{$ADDRESS}</td>";
        echo "<td>{$PHONE}</td>";
//        echo "<td>{$siteN}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    // paging buttons
    $_SESSION['pageName'] = $currentPage;
    $_SESSION['tableName'] = 'employee';
    require_once (FOLDER_Template.'paging_employee.php');
}
// tell the user there are no products
else {
    echo "<div>No Employee Record found.</div>";
}
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
<!--AJAX Search-->
<script src="<?php echo WWWROOT ?>application/assets/ajaxSearch.js"></script>

