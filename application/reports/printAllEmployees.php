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

<input type="button" value="Print" onclick="window.print()" />


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
        echo "<td>$name</td>";
        echo "<td>{$designation}</td>";
        echo "<td>{$epf_no}</td>";
        echo "<td>{$appoinment_date}</td>";
        echo "<td>{$nic}</td>";
        echo "<td>{$dob}</td>";
        echo "<td>{$address}</td>";
        echo "<td>{$contact}</td>";
        echo "<td>{$siteN}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    // paging buttons
    $_SESSION['pageName'] = $currentPage;
    $_SESSION['tableName'] = 'employee';
//    require_once (FOLDER_Template . 'paging_employee.php');
}
// tell the user there are no products
else {
    echo "<div>No Employee Record found.</div>";
    
}

//Load page Footer

?>

<!--AJAX Search-->
<script src="<?php echo WWWROOT ?>application/assets/ajaxSearch.js"></script>

