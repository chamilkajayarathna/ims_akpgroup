<?php
//employee index
require ('../../core/init.php');
$page_title = "Client Details";

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
$table_Name = 'clients c';
$fiels = 'c.cid,c.name,c.address,c.phoneNo,c.fax,c.email';
$join = NULL;
$where = NULL;
$order = 'c.cid ASC';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $where, $order, "$from_record_num,$records_per_page");
$num = $stmt->rowCount();


$currentPage = basename(($_SERVER['PHP_SELF']));
?>

<a href="printAllClients.php">Preview All</a>

    <?php
// display the products if there are any
if ($num > 0) {
    echo "<div class='table-responsive'>";
    echo "<table class='table  table-striped table-hover table-responsive table-bordered'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Address </th>";
    echo "<th>Phone no</th>";
    echo "<th>Fax</th>";
    echo "<th>Email</th>";
    
    echo "</tr>";
    echo "</thead>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td class='col-md-4'><a href='singleClientDetails.php?cid=$cid&name=$name'>{$name}</a></td>";       
        echo "<td>{$address}</td>";        
        echo "<td>{$phoneNo}</td>";
        echo "<td>{$fax}</td>";
        echo "<td>{$email}</td>";
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
