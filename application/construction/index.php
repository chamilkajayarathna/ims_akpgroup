<?php
//Construction index page
require ('../../core/init.php');
$page_title = "Construction Project Details";

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

$table_Name = 'project p';
$fiels = 'p.CONTRACT_NO,p.NAME,p.CLIENT_ID,p.PROGRESS,p.COMMENCEMENT_DATE,p.COMPLETION_DATE,p.EXTENDED_DATE,p.CONTRACT_PERIOD,p.CONTRACT_SUM,p.EXTENDED_CONTRACT_SUM';
//$fields = '*';
$join = NULL;
$where = NULL;
$order = 'p.CONTRACT_NO ASC';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $where, $order, "$from_record_num,$records_per_page");
$num = $stmt->rowCount();

$currentPage = basename(($_SERVER['PHP_SELF']));
?>
<div class="row">
    <div id='button' class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-left left-margin'>Refresh</a>
        <a href='editProjects.php' class='btn btn-default pull-right left-margin'>Edit Projects</a>
        <a href='addProject.php' class='btn btn-default pull-right left-margin'>Add New Project</a>
        <a href='clients.php' class='btn btn-default pull-right left-margin'>Add New Client</a>
    </div> 
    <div class="col-lg-12">
        <form role="form" method="post">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Search</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group col-lg-3">
                        Project No<input type="text" class="form-control" id="projectID" placeholder="Enter Project No">
                    </div>
                    <div class="form-group col-lg-3">
                        Project Name<input type="text" class="form-control" id="projectName" placeholder="Enter Project Name">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class='table-responsive'>
            <table id='dataTable' class='table  table-striped table-hover table-responsive table-bordered'>
                <thead>
                    <tr>
                        
                        <th>Project Name</th>
                        <th>Client</th>
                        <th>Progress</th>
                        <th>Commencement Date</th>
                        <th>Completion Date</th>
                        <th>Extended Date</th>
                        <th>Contract Period</th>
                        <th>Contract Value</th>
                        <th>Extended Value</th>
                       
                    </tr>
                </thead>
                <tbody>                   
                    <?php
                    if ($num > 0) {
                        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $total = $rows['CONTRACT_SUM'] + $rows['EXTENDED_CONTRACT_SUM'];
                            echo "<tr>";
                            
                            echo "<td>" . $rows['CONTRACT_NO'] . "</td>";
                            echo "<td>" . $rows['NAME'] . "</td>";
                            echo "<td>" . $rows['PROGRESS'] . "</td>";
                            echo "<td>" . $rows['COMMENCEMENT_DATE'] . "</td>";
                            echo "<td>" . $rows['COMPLETION_DATE'] . "</td>";
                            echo "<td>" . $rows['EXTENDED_DATE'] . "</td>";
                            echo "<td>" . $rows['CONTRACT_PERIOD'] . "</td>";
                            echo "<td>" . $rows['CONTRACT_SUM'] . "</td>";
                            echo "<td>" . $rows['EXTENDED_CONTRACT_SUM'] . "</td>";
                           
                            echo '</tr>';
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
            echo "<div>No products found.</div>";
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
