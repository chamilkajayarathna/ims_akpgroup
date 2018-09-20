<?php
//main Index Attendance
require '../../core/init.php';

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
$page_title = "Single Employer Attendance Record";
require_once(FOLDER_Template . 'header.php');

$emp = $dbCRUD->ddlDataLoad('SELECT serial_no,name,epf_no FROM employee');

$result = NULL;
$absentDays = NULL;
$num = 0;
$name = NULL;
$desig = NULL;
$epf = NULL;
$con = NULL;
if (isset($_POST['submit'])) {
    $txtEmpID = filter_input(INPUT_POST, 'ddlEmp1');
    $txtMonth = filter_input(INPUT_POST, 'month');
    $txtYear = filter_input(INPUT_POST, 'year');

    //Employee absent Calculate
    $empPresentDays = $dbCRUD->ddlDataLoad('SELECT date from attendance where emp_ID=' . $txtEmpID . ' AND month(date)=' . $txtMonth);
    $presentDays = array();
    foreach ($empPresentDays as $ddlData) {
        $presentDays[] = $ddlData['date'];
    }

    $days = array();
    $month = $txtMonth;
    $year = $txtYear;
    for ($d = 1; $d <= 31; $d++) {
        $time = mktime(12, 0, 0, $month, $d, $year);
        if (date('m', $time) == $month) {
            $days[] = date('Y-m-d', $time);
        }
    }
    $result = array_diff($days, $presentDays);

    $absentDays = count($result);
    //table information
    $table_Name = 'employee e, designation d, attendance a';
    $fields = 'a.*, e.name,e.epf_no,e.contact, d.designation';
    $join = NULL;
    $where = "a.emp_ID = e.serial_no AND d.number = e.designation AND e.serial_no=" . $txtEmpID . " AND MONTH(date) =" . $txtMonth . " AND YEAR(date) =" . $txtYear;
    $orderBy = 'a.id ASC';

    $stmts = $dbCRUD->selectAll($table_Name, $fields, $join, $where, $orderBy, NULL);
    $stmt = $dbCRUD->selectAll('employee e, designation d', 'e.name,e.epf_no,e.contact, d.designation', $join, 'd.number = e.designation AND e.serial_no=' . $txtEmpID, NULL, NULL);
    $num = $stmts->rowCount();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $name = $name;
        $desig = $designation;
        $epf = $epf_no;
        $con = $contact;
    }
//    $singleRecord = $dbCRUD->ddlDataLoad('SELECT a.*, e.name,e.epf_no,e.contact, d.designation '
//            . 'from employee e, designation d, attendance a '
//            . 'where a.emp_ID = e.serial_no AND d.number = e.designation AND '
//            . 'e.epf_no=' . $txtEmpID . '  AND MONTH(date) =' . $txtMonth . ' AND YEAR(date) =' . $txtYear . ' ');
}
?>
<link href="../../js/search/select2.css" rel="stylesheet"/>
<script src="../../js/search/select2.js"></script>
<script>
    $(document).ready(function () {
        $("#ddlEmp").select2({
            placeholder: "Select a State",
            allowClear: true
        });
        $("#ddlEmp1").select2({
            placeholder: "Select a State",
            allowClear: true
        });
    });
</script>
<div class="row">
    <div id='button' class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-left left-margin'>Refresh</a>
        <a href='<?php echo $global->wwwroot ?>/application/reports/attendance.php' class='btn btn-default pull-left left-margin'>Absent Employee</a>
    </div>
    <div class="col-lg-12">
        <form role="form" method="post">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Search</h3>
                </div>
                <div class="panel-body">
                    <div class="navbar-form pull-left">
                        <select name="ddlEmp1" id="ddlEmp1" >
                            <option selected>Select</option>
                            <?php
                            foreach ($emp as $ddlData) {
                                echo '<option value="' . $ddlData['serial_no'] . '">' . $ddlData['name'] . '</option>';
                            }
                            ?>
                        </select>

                        <select class="form-control" id="month" name="month">
                            <option value = "1">January</option>
                            <option value = "2">February</option>
                            <option value = "3">March</option>
                            <option value = "4">April</option>
                            <option value = "5">May</option>
                            <option value = "6">June</option>
                            <option value = "7">July</option>
                            <option value = "8">August</option>
                            <option value = "9">September</option>
                            <option value = "10">October</option>
                            <option value = "11">November</option>
                            <option value = "12">December</option> 
                        </select>
                        <select id="year" name="year" class="form-control"></select>
                        <input type="submit" name="submit" id="attendanceEPFNO" class="btn btn-default" value="Search"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class='table-responsive col-lg-5'>
                <table id="dataTable1" class='table table-striped table-hover table-responsive table-bordered'>
                    <tr>
                        <td  class='col-md-3'>Name  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $name ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Designation :-</td>
                        <td><?php echo $desig ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>EPF No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $epf ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Contact No &nbsp;:-</td>
                        <td><?php echo $con ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Number of Absents &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $absentDays ?></td>
                    </tr>
                </table>

            </div>
            
        </div>
        <div class="row">
            <?php
// display the products if there are any
            if ($num > 0) {
                echo "<div class='table-responsive col-lg-5'>";
                echo "<table class='table  table-striped table-hover table-responsive table-bordered'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>In Time</th>";
                echo "<th>Out Time</th>";
                echo "<th>Date</th>";
                echo "</tr>";
                echo "</thead>";
                while ($row = $stmts->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    echo "<tr>";
                    echo "<td>{$inTime}</td>";
                    echo "<td>{$outTime}</td>";
                    echo "<td>{$date}</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            }
// tell the user there are no products
            else {
                echo "<h4>Sorry! No Attendance Record For this Employer.</h4>";
            }
            ?>

            <div class='table-responsive col-lg-3'>
                <h4>Absent Dates</h4> 
                <?php
                $count = count($result);
                $half_count = ceil($count / 2); // make sure to ceil to an int. This will have your first column 1 larger than the second column when the count is odd
                echo '<ul style="float:left">';
                $counter = 0;
                if(!empty($result)){
                foreach ($result as $key => $value) {
                    echo '<li>', $value, '</li>';
                    $counter += 1;
                    if ($counter == $half_count && $count != 1) {
                        echo '</ul><ul style="float:right">';
                    }
                }
                }
                echo "</ul>";
                ?>
                <?php
//                    foreach ($result as $key => $value) {
//                        echo "<tr>";
//                        echo "<td>$value</td>";
//                        echo "</tr>";
//                    }
                ?>
            </div>
        </div>
    </div>
</div>
<a class="btn btn-primary" href="printsingleEmpRecord.php?eid=<?php echo $txtEmpID ?>&month=<?php echo $txtMonth ?>&year=<?php echo $txtYear ?>">Print Preview</a>




<?php
require_once(FOLDER_Template . 'footer.php');
?>

<script>
    var till = 2014;
    var year = new Date().getFullYear();
    var options = "";
    for (var y = year; y >= till; y--) {
        options += "<option>" + y + "</option>";
    }
    document.getElementById("year").innerHTML = options;

//    function search() {
//        $("#empName").html("");
//        $("#desig").html("");
//        $("#epf").html("");
//        $("#contact").html("");
//
//        var empName = null;
//        var desig = null;
//        var epf = null;
//        var contact = null;
//
//        var searchKeyword = $('#ddlEmp1').val();
//        var month = $('#month').val();
//        var year = $('#year').val();
//        $('#keyword').val('');
//        //table information
//        $table_Name = 'employee e, designation d, attendance a';
//        $fields = 'a.*, e.name,e.epf_no,e.contact, d.designation';
//        $join = null;
//        $where = "a.emp_ID = e.serial_no AND d.number = e.designation AND e.epf_no=" + searchKeyword + " AND MONTH(date) =" + month + " AND YEAR(date) =" + year;
//        $orderBy = 'a.id ASC';
//
//        $dataString = {keywords: searchKeyword, table_Name: $table_Name, fields: $fields, join: $join, where: $where, orderBy: $orderBy};
//        if (searchKeyword.length >= 1) {
//            $.ajax({
//                url: '../assets/search.php',
//                type: 'post',
//                data: $dataString,
//                dataType: "json",
//                cache: false,
//                async: false,
//                success: function (data) {
//                    if (!$.isArray(data) || !data.length) {
//                        $('table#dataTable  tbody').empty()
//                        content = '<tr><td>SORRY! No Record Found.</td></tr>';
//                        $('table#dataTable  tbody').append(content);
//                        return;
//                    }
//                    else {
//                        $('table#dataTable  tbody').empty()
//                        $.each(data, function () {
//                            empName = this.name;
//                            desig = this.designation;
//                            epf = this.epf_no;
//                            contact = this.contact;
//                            content = '<tr><td style="display:none;">' + this.emp_ID + '</td>';
//                            content += '<td>' + this.inTime + '</td>';
//                            content += '<td>' + this.outTime + '</td>';
//                            content += '<td>' + this.date + '</td>';
//                            $('table#dataTable  tbody').append(content);
//                        });
//                        $('#empName').append(empName);
//                        $('#desig').append(desig);
//                        $('#epf').append(epf);
//                        $('#contact').append(contact);
//                    }
//
//                }
//            });
//
//        }
//    }
</script>

