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

<a href="printMachineDetails.php">Print Preview</a>

    <?php
// display the products if there are any
if ($num > 0) {
    echo "<div class='table-responsive'>";
    echo "<table class='table  table-striped table-hover table-responsive table-bordered'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Machine</th>";
    echo "<th>Machine  No</th>";
    echo "<th>Name</th>";
    echo "<th>Brand</th>";
    echo "<th>Model No</th>";
    echo "<th>Site</th>";
    echo "</tr>";
    echo "</thead>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td><a href='single_machineDetail.php?mid=$id'>{$id}</a></td>";
        echo "<td>{$machineCategory}</td>";
        echo "<td>{$machineNo}</td>";
        echo "<td><a href='". $global->wwwroot."application/machine/machineDetails.php?id={$id}' class='btn btn-xs btn-info left-margin'>{$machineName}</a></td>";
        echo "<td>{$brandName}</td>";
        echo "<td>{$model}</td>";
        echo "<td>{$siteN}</td>";
        echo "</tr>";
    }

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
