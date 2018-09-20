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

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 10;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

//$stmt = $dbCRUD->selectAll('products', '*', NULL, NULL, 'name ASC', "$from_record_num,$records_per_page");
$table_Name = 'machine m, machinebrand b, machinesite s, machineName n';
$fiels = 'm.*, b.*, s.*, n.*';
$join = NULL;
$whereCond = 'm.brand = b.brandNo AND m.siteName = s.siteNo AND n.nameIdMachine = m.nameId';
$order = 'm.id ASC';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $whereCond, $order, "$from_record_num,$records_per_page");
$num = $stmt->rowCount();


$currentPage = basename(($_SERVER['PHP_SELF']));
?>
<input type="button" value="PRINT ALL" onclick="window.print()">
<?php
// display the products if there are any
if ($num > 0) {
    echo "<div class='table-responsive'>";
    echo "<table class='table  table-striped table-hover table-responsive table-bordered'>";
    echo "<thead>";
    echo "<tr>";
   
    echo "<th>Machine</th>";
    echo "<th>Machine  No</th>";
    echo "<th>Name</th>";
    echo "<th>Brand</th>";
    echo "<th>Model No</th>";
    echo "<th>Engine Model</th>";
    echo "<th>Engine Serial</th>";
    echo "<th>year</th>";
    echo "<th>Details</th>";
    echo "<th>Chassi Serial</th>";
    echo "<th>HP</th>";
    echo "<th>Site Name</th>";
    
    echo "</tr>";
    echo "</thead>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td>{$machineCategory}</td>";
        echo "<td>{$machineNo}</td>";
        echo "<td>{$machineName}</td>";
        echo "<td>{$brandName}</td>";
        echo "<td>{$model}</td>";
        echo "<td>{$engineModel}</td>";
        echo "<td>{$engineSerial}</td>";
        echo "<td>{$year}</td>";
        echo "<td>{$details}</td>";
        echo "<td>{$chassiSerial}</td>";
        echo "<td>{$hp}</td>";
        echo "<td>{$siteName}</td>";
        
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
    // paging buttons
    $_SESSION['pageName'] = $currentPage;
    $_SESSION['tableName'] = 'machine';
    //require_once (FOLDER_Template . 'paging_employee.php');
    
}
// tell the user there are no products
else {
    echo "<div>No Records found.</div>";
}
//Load page Footer
require_once (FOLDER_Template . 'footer.php');


?>
