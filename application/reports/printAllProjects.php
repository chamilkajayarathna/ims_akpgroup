<?php
//employee index
require ('../../core/init.php');
$page_title = "All Project Details";

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
$table_Name = 'project p';
$fiels = 'p.contractNo,p.projectName,p.client,p.progress,p.commencementDate,p.completionDate,p.extendedDate,p.contractPeriod,p.contractSum,p.extendedContractSum';
$join = NULL;
$where = NULL;
$order = 'p.contractNo ASC';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $where, $order, "$from_record_num,$records_per_page");
$num = $stmt->rowCount();


$currentPage = basename(($_SERVER['PHP_SELF']));
?>

<input type="button" value="Print" onclick="window.print()" />

    <?php
// display the products if there are any
if ($num > 0) {
    echo "<div class='table-responsive'>";
    echo "<table class='table  table-striped table-hover table-responsive table-bordered'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Project Name</th>";
    echo "<th>Client </th>";
    echo "<th>Progress</th>";
    echo "<th>Commencement Date</th>";
    echo "<th>Completion Date</th>";
    echo "<th>Extended Date</th>";
    echo "<th>Contract Period </th>";
    echo "<th>Contract Sum</th>";
    echo "<th>Extended Contract Sum</th>";
    
    echo "</tr>";
    echo "</thead>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td>$projectName</td>";                    
        echo "<td>{$client}</td>";
        echo "<td>{$progress}</td>";
        echo "<td>{$commencementDate}</td>";
        echo "<td>{$completionDate}</td>";        
        echo "<td>{$extendedDate}</td>";
        echo "<td>{$contractPeriod}</td>";
        echo "<td>{$contractSum}</td>";
        echo "<td>{$extendedContractSum}</td>";
        
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
    // paging buttons
    $_SESSION['pageName'] = $currentPage;
    $_SESSION['tableName'] = 'project';
    
    
}
// tell the user there are no products
else {
    echo "<div>No Records found.</div>";
}
//Load page Footer
require_once (FOLDER_Template . 'footer.php');


?>
