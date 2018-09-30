<?php
//Construction index page
require ('../../core/init.php');
$page_title = "Construction Project Details";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $user = $users->userdata($_SESSION['id']);
    $username = $user['USERNAME'];
    $logAuth = $user['USER_LEVEL'];
    if ($logAuth != 1) {
        header('Location:' . $global->wwwroot . 'application/login/deny.php');
    }
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

$table_Name = 'project p, clients c ';
$fiels = 'p.contractNo,p.projectName,p.client,p.progress,p.commencementDate,p.completionDate,p.extendedDate,p.contractPeriod,p.contractSum,p.extendedContractSum';
$join = NULL;
$where = 'p.contractNo = c.cid';
$order = 'p.contractNo ASC';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $where, $order, "$from_record_num,$records_per_page");
$num = $stmt->rowCount();

$currentPage = basename(($_SERVER['PHP_SELF']));
?>
<div class="row">
    <div id='button' class='right-button-margin'>
        <a href='editProjects.php' class='btn btn-default pull-left left-margin'>Refresh</a>
        <a href='editProjects.php' class='btn btn-default pull-right left-margin'>Edit Project Details</a>
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
                        <th>Project No</th>
                        <th>Name</th>
                        <th>Principal</th>
                        <th>Progress</th>
                        <th>Commencement Date</th>
                        <th>Completion Date</th>
                        <th>Extended Date</th>
                        <th>Contract Period</th>
                        <th>Contract Value</th>
                        <th>Extended Value</th>
                        <th>Total Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>                   
                    <?php
                    if ($num > 0) {
                        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $total = $rows['contractSum'] + $rows['extendedContractSum'];
                            echo "<tr>";
                            echo "<td>" . $rows['contractNo'] . "</td>";
                            echo "<td>" . $rows['projectName'] . "</td>";
                            echo "<td>" . $rows['client'] . "</td>";
                            echo "<td>" . $rows['progress'] . "</td>";
                            echo "<td>" . $rows['commencementDate'] . "</td>";
                            echo "<td>" . $rows['completionDate'] . "</td>";
                            echo "<td>" . $rows['extendedDate'] . "</td>";
                            echo "<td>" . $rows['contractPeriod'] . "</td>";
                            echo "<td>" . $rows['contractSum'] . "</td>";
                            echo "<td>" . $rows['extendedContractSum'] . "</td>";
                            echo "<td>" . $total . "</td>";
                            echo "<td>";
                            echo "<a href='addProject.php?id=" . $rows['contractNo'] . "' class='btn btn-xs btn-warning left-margin'>Edit</a>";
                            echo "<a delete-id='" . $rows['contractNo'] . "' class='btn btn-xs btn-danger delete-object'>Delete</a>";
                            echo "</td>";
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
            // paging buttons
            $_SESSION['pageName'] = $currentPage;
            $_SESSION['tableName'] = 'project';
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
<script>
    $(document).on('click', '.delete-object', function () {
        var id = $(this).attr('delete-id');
        var q = confirm("Are you sure Delete Machine From database ?");
        if (q === true) {
            $.post('delete.php', {
                project_delete_id: id
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