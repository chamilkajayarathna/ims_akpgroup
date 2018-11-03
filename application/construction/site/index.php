<?php
//Construction index page
require ('../../../core/init.php');
$page_title = "Construction Site Details";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}

//Load page Headder
require_once(FOLDER_Template . 'header-without-navi.php');

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 10;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

$pid = filter_input(INPUT_GET, 'pid');
if (isset($pid)) {

    $table_Name = 'site s';
    $fiels = '*';
    //$fields = '*';
    $join = NULL;
    $where = 's.PROJECT_ID='.$pid;
    $order = 's.INSERT_DATETIME DESC';

    $stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $where, $order, "$from_record_num,$records_per_page");
    $num = $stmt->rowCount();

    $currentPage = basename(($_SERVER['PHP_SELF']));
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class='table-responsive'>
            <table id='dataTable' class='table  table-striped table-hover table-responsive table-bordered'>
                <thead>
                    <tr>
                        <td>#</td>
                        <th>Site Name</th>
                        <th>Address</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>                   
                    <?php
                    if ($num > 0) {
                        $count=1;
                        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $count . "</td>";
                            echo "<td>" . $rows['NAME'] . "</td>";
                            echo "<td>" . $rows['ADDRESS'] . "</td>";
                            echo "<td>" . $rows['LATITUDE'] . "</td>";
                            echo "<td>" . $rows['LONGITUDE'] . "</td>";
                            echo "<td>" . $rows['PROGRESS'] . "</td>";
                            echo '</tr>';
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
            // paging buttons
            $_SESSION['pageName'] = $currentPage;
            $_SESSION['tableName'] = 'contractdetails';
            require_once (FOLDER_Template . 'paging_employee.php');
        } else {
            echo "<div>No sites found.</div>";
        }
        ?>
    </div>
     
</div>


<?php
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
<!--AJAX Search-->
<script src="<?php echo WWWROOT ?>application/assets/ajaxSearch.js"></script>
