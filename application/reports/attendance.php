<?php
//employee details
require ('../../core/init.php');
$page_title = "Employee Attendance Details";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
//Load page Headder
require_once(FOLDER_Template . 'header.php');

$emp = $dbCRUD->ddlDataLoad('SELECT serial_no,name,epf_no FROM employee');

date_default_timezone_set('Asia/Kolkata');
$location = 'Head Office';
$curntDate = date('Y/m/d');
$curntDateView = date("l jS \of F Y",strtotime($curntDate));

if (isset($_POST['changeDate'])) {
    $curntDate = filter_input(INPUT_POST, 'txtDate');
    $curntDateView = date("l jS \of F Y",strtotime($curntDate));
}
if (isset($_POST['changeLoc'])) {
    $location = filter_input(INPUT_POST, 'txtWork');
}


?>

<div class="row">
    <div id='button' class='right-button-margin'>
        <a href='attendance.php' class='btn btn-default pull-left left-margin'>Refresh</a>
        <a href='<?php echo $global->wwwroot ?>/application/reports/singleEmpRecord.php' class='btn btn-default pull-left left-margin'>Single Employee Record</a>
    </div>
    <div class="col-lg-12">
        <div class="col-lg-12">
            <form role="form" method="post">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Search</h3>
                    </div>
                    <div class="panel-body">
                        
                        <div class="navbar-form pull-left">
                            <input type='text' name='txtDate' id="datepicker" class='form-control' value="">
                            <button type="submit" name="changeDate" class="btn btn-success">Change Date</button>
                        </div>
                        <div class="navbar-form pull-left">
                            <?php
                            $stmt = $dbCRUD->selectAll('machinesite', '*', NULL, NULL, NULL, NULL);
                            echo "<select class='form-control' name='txtWork'>";
                            while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row_category);
                                echo "<option value='{$siteN}'>{$siteN}</option>";
                            }
                            echo "</select>";
                            ?>
                            <button type="submit" name="changeLoc" class="btn btn-success">Change Location</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php
        $query = 'SELECT e.serial_no,e.name,e.epf_no,e.nic,e.dob,e.address,e.contact,d.designation '
                . 'from employee e, machinesite m, designation d '
                . 'where m.siteNo=e.workSite AND d.number = e.designation AND '
                . 'm.siteN="Head Office" AND e.serial_no NOT IN '
                . '(SELECT a.emp_ID from employee e, machinesite m,attendance a '
                . 'where m.siteNo=e.workSite AND a.emp_ID=e.serial_no AND '
                . 'a.date="' . $curntDate . '" AND m.siteN="'.$location.'" )';

        $stmt1 = $dbCRUD->ddlDataLoad($query);
        $num = count($stmt1);
       echo '<h4>&nbsp;&nbsp;&nbsp;&nbsp;Absent Employee</h4>';
        echo '<div class="col-sm-6">
            <pre>Date :- '.  $curntDateView.'</pre>
            <pre>Location :- '.$location.' - Panditharatne Constructions</pre>
            <pre>Number of Absent Employee :-'. count($stmt1).'</pre>
        </div>';
        $currentPage = basename(($_SERVER['PHP_SELF']));
// display the products if there are any
        if ($num > 0) {
            echo "<div class='table-responsive col-sm-10'>";
            echo "<table id='dataTable' class='table table-striped table-hover table-responsive table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Designation</th>";
            echo "<th>EPF No</th>";
            echo "<th>NIC</th>";
            echo "<th>Date of Birth</th>";
            echo "<th>Address</th>";
            echo "<th>Contact</th>";
            echo "</tr>";
            echo "</thead>";

            foreach ($stmt1 as $result) {
                echo "<tr>";
                echo "<td class='col-md-4'>" . $result['name'] . "</td>";
                echo "<td>" . $result['designation'] . "</td>";
                echo "<td>" . $result['epf_no'] . "</td>";
                echo "<td>" . $result['nic'] . "</td>";
                echo "<td>" . $result['dob'] . "</td>";
                echo "<td class='col-sm-2'>" . $result['address'] . "</td>";
                echo "<td>" . $result['contact'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        }
// tell the user there are no products
        else {
            echo "<div>No Employee Record found.</div>";
        }
        ?>
    </div>
</div>
<?php
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
<script>
    $(function () {
        $("#datepicker").datepicker();
    });

    var till = 2014;
    var year = new Date().getFullYear();
    var options = "";
    for (var y = year; y >= till; y--) {
        options += "<option>" + y + "</option>";
    }
    document.getElementById("year").innerHTML = options;
    
   
</script>