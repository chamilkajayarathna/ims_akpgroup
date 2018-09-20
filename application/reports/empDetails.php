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
                    <div id='message' class='form-group col-lg-3 pull-right'>                      
                        <a href='<?php echo $global->wwwroot ?>application/employee/resignedEmployee.php' class='btn btn-danger pull-right'>View Resigned Employee</a>
                    </div>
                    
                    <div id='message' class='form-group col-lg-3 pull-right'>                        
                        <a href='printAllEmployees.php' class='btn btn-danger pull-right'>View All Employees</a>
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
$table_Name = 'employee e, designation d, machinesite m';
$fiels = 'e.serial_no,e.name,e.epf_no,e.appoinment_date,e.nic,e.dob,e.address,e.contact,m.siteN,d.designation';
$join = NULL;
$where = 'e.designation= d.number AND e.workSite = m.siteNo';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $where, 'serial_no ASC', "$from_record_num,$records_per_page");
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
    echo "<th>Location</th>";
    echo "</tr>";
    echo "</thead>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td class='col-md-4'><a href='singleEmpRecordDetail.php?eid=$serial_no&empName=$name'>{$name}</a></td>";
        echo "<td>{$designation}</td>";
        echo "<td>{$epf_no}</td>";
        echo "<td class='col-md-1'>{$appoinment_date}</td>";
        echo "<td>{$nic}</td>";
        echo "<td>{$dob}</td>";
        echo "<td class='col-md-4'>{$address}</td>";
        echo "<td>{$contact}</td>";
        echo "<td>{$siteN}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    // paging buttons
    $_SESSION['pageName'] = $currentPage;
    $_SESSION['tableName'] = 'employee';
    require_once (FOLDER_Template . 'paging_employee.php');
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

