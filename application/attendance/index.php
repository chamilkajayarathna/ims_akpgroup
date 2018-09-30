<?php
//main Index Attendance
require '../../core/init.php';

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

$page_title = "Attendance Rocords";
require_once(FOLDER_Template . 'header.php');
//==============================================
if (isset($_POST['addTime'])) {
    $table_Name1 = 'attendance';
    $in = filter_input(INPUT_POST, 'checkIn');
    $out = filter_input(INPUT_POST, 'checkOut');
    $id = filter_input(INPUT_POST, 'ddlEmp');
    $date = filter_input(INPUT_POST, 'txtDate');

    $data = array('inTime' => $in, 'outTime' => $out, 'date' => $date, 'emp_id' => $id, 'dayEnd' => '1');
    // Add new record
    if ($dbCRUD->insertData($table_Name1, $data)) {
        echo "<script type='text/javascript'>
            alert('New Attendance Successfully Added.')
                document.location = 'index.php'
            </script>";
    }
    // if unable to add the record, error message
    else {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "Unable to save Attendance.";
        echo "</div>";
    }
}
//============================================================================================================
//update
if (isset($_POST['up_addTime'])) {
    $table_Name = 'attendance';

    $in = filter_input(INPUT_POST, 'up_checkIn');
    $out = filter_input(INPUT_POST, 'up_checkOut');
    $id = filter_input(INPUT_POST, 'empid');
    $date = filter_input(INPUT_POST, 'date');
    //print_r($date." ".$id);
    $dataUpdate = array('inTime' => $in, 'outTime' => $out, 'dayEnd' => '1');
    // Add new record
    if ($dbCRUD->updateData($table_Name, $dataUpdate, 'emp_ID=' . $id . ' AND date="' . $date . '" ')) {
        echo "<script type='text/javascript'>
            alert('Attendance Successfully Updated.')
                document.location = 'index.php'
            </script>";
    } else {
        // if unable to add the record, error message
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "Unable to Update Time!";
        echo "</div>";
    }
}
//============================================================================================================
$emp = $dbCRUD->ddlDataLoad('SELECT serial_no,name,epf_no FROM employee');
//Download CSV file
$emp2 = $dbCRUD->ddlDataLoad('SELECT e.serial_no,e.name,e.epf_no FROM employee e, attendance a WHERE a.emp_ID = e.serial_no '
        . 'AND year(date)=2015 AND month(date)=1 ');
$table_Name2 = 'attendance a, employee e';
$fiels2 = 'e.name,a.date,a.inTime,a.outTime';
$join2 = NULL;
$whereCond2 = 'a.emp_ID = e.serial_no AND year(date)=2015 AND month(date)=1 ';
$order2 = NULL;
if (isset($_POST['csv'])) {
    $filename = NULL;
    $handle = NULL;

    $month = filter_input(INPUT_POST, 'monthCSV');
    $year = filter_input(INPUT_POST, 'yearCSV');
    //make directory
    $todir = 'C:/Employee_Attendance';
    if (is_dir($todir) == false) {
        $status = mkdir($todir, 0777);
        if ($status < 1) {
            return "unable to create  diractory $file_dir ";
        }
    }
    $result = $dbCRUD->selectAll($table_Name2, $fiels2, $join2, $whereCond2, $order2, NULL);
    // Pick a filename and destination directory for the file
    // Remember that the folder where you want to write the file has to be writable
    foreach ($emp2 as $ddlData) {
        $empName = $ddlData['name'];
        //change number to month
        $monthName = date('F', mktime(0, 0, 0, $month, 10));
        $filename = "" . $todir . "/" . $empName . "_" . $year."_".$monthName . ".csv";
        $handle = fopen($filename, 'w+');
        // Write the spreadsheet column titles / labels
        fputcsv($handle, array('Panditharatne Constructions - Attendance Details'));
        fputcsv($handle, array('Year - '.$year));
        fputcsv($handle, array('Month - '.$monthName));
        fputcsv($handle, array('-----------------------------------------'));
        fputcsv($handle, array('Date', 'IN Time', 'OUT Time'));

        $emp3 = $dbCRUD->ddlDataLoad('SELECT date,inTime,outTime FROM attendance '
                . 'WHERE year(date)='.$year.' AND month(date)='.$month.' AND emp_ID=' . $ddlData['serial_no'] );
        foreach ($emp3 as $data) {
            fputcsv($handle, array($data['date'], $data['inTime'], $data['outTime']));
        }
    }
    // Actually create the file
    // The w+ parameter will wipe out and overwrite any existing file with the same name
    // Write all the user records to the spreadsheet

    echo "<div class='alert alert-success' role='alert'>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
    echo "<strong>Success!</strong> You successfully Downloaded the Employee Attendance Details.";
    echo "</div>";
    // Finish writing the file
    if($handle != null)
    {
        fclose($handle);
        $row = NULL;
    }
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
<?php
include '../common/header.php';
?>
<div class="row">
    <div id='button' class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-left left-margin'>Refresh</a>
        <a href='<?php echo $global->wwwroot ?>/application/reports/attendance.php' class='btn btn-default pull-left left-margin'>Absent Employee</a>
        <div class="col-sm-3 pull-right">
            <?php if ($logAuth == 1) { ?>
                <form action="" method="post">
                    <select class="form-control " id="monthCSV" name="monthCSV">
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
                    <select id="yearCSV" name="yearCSV" class="form-control"></select>
                    <input type="submit" name="csv" id="submit" value="Download Attendance Details" class="btn btn-default pull-right">
                </form>
            <?php } ?>
        </div>
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
                                echo '<option value="' . $ddlData['epf_no'] . '">' . $ddlData['name'] . '</option>';
                            }
                            ?>
                        </select>

                        <select class="form-control" id="month">
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
                        <select id="year" class="form-control"></select>
                        <input type="button" id="attendanceEPFNO" class="btn btn-default" value="Search" onclick="search()"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <!-- ------------------------------------------------------------------------------------------------------------------------>
    <div class="col-sm-6"> 
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Add Check IN Time</h3>
            </div>
            <div class="panel-body">
                <form action='index.php' method='post'>
                    <table class='table table-responsive' >
                        <tr>
                            <td>Name</td>
                            <td>
                                <select name="ddlEmp" id="ddlEmp" >
                                    <option selected>Select</option>
                                    <?php
                                    foreach ($emp as $ddlData) {
                                        echo '<option value="' . $ddlData['serial_no'] . '">' . $ddlData['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Check IN Time</td>
                            <td><input type='text' name='checkIn' class='form-control' value="" required></td>
                        </tr>
                        <tr>
                            <td>Check OUT Time</td>
                            <td><input type='text' name='checkOut' class='form-control' value="" required></td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td><input type='text' name='txtDate' id="datepicker" class='form-control' value="" required></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" name="addTime" class="btn btn-success">Add</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

    </div><!-- /.col-sm-4 -->

    <div class="col-sm-5">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Update Check IN/OUT Time</h3>
            </div>
            <div class="panel-body">
                <form action='index.php' method='post'>
                    <table class='table table-responsive'>
                        <tr>
                            <td>Check IN Time</td>
                            <td><input type='text' name='up_checkIn' id="up_checkIn" class='form-control' value="" required>
                                <input type='hidden' id='empid' name='empid' value="">
                                <input type='hidden' id='date' name='date' value="">
                            </td>
                        </tr>
                        <tr>
                            <td>Check OUT Time</td>
                            <td><input type='text' name='up_checkOut' id="up_checkOut" class='form-control' value="" required></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" name="up_addTime" class="btn btn-warning">Update</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="row">
            <div class='table-responsive col-lg-8'>
                <table id="dataTable1" class='table table-striped table-hover table-responsive table-bordered'>
                    <tr>
                        <td  class='col-md-3'>Name  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><span id="empName"></span><br></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Designation :-</td>
                        <td><span id="desig"></span><br></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class='table-responsive col-lg-8'>
                <table id="dataTable" class='table table-striped table-hover table-responsive table-bordered'>
                    <thead>
                        <tr>
                            <th style='display:none;'>ID</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
require_once(FOLDER_Template . 'footer.php');
?>

<script>
    $(function () {
        $("#datepicker").datepicker();
    });

    $(document).on('click', '.resign-object', function () {
        var id = $(this).attr('resign-id');
        var q = confirm("Conform the Resignation?");
        if (q === true) {
            $.post('delEmployee.php', {
                resign_id: id
            }, function (data) {
                alert(data);
                location.reload();
            }).fail(function () {
                alert('Something went wrong. Try Again !.');
            });
        }
        return false;
    });

    var till = 2014;
    var year = new Date().getFullYear();
    var options = "";
    for (var y = year; y >= till; y--) {
        options += "<option>" + y + "</option>";
    }
    document.getElementById("year").innerHTML = options;
    document.getElementById("yearCSV").innerHTML = options;

    function search() {
        $("#empName").html("");
        $("#desig").html("");
        var empName = null;
        var desig = null;
        var searchKeyword = $('#ddlEmp1').val();
        var month = $('#month').val();
        var year = $('#year').val();
        $('#keyword').val('');
        //table information
        $table_Name = 'employee e, designation d, attendance a';
        $fields = 'a.*, e.name, d.designation';
        $join = null;
        $where = "a.emp_ID = e.serial_no AND d.number = e.designation AND e.epf_no=" + searchKeyword + " AND MONTH(date) =" + month + " AND YEAR(date) =" + year;
        $orderBy = 'a.id ASC';

        $dataString = {keywords: searchKeyword, table_Name: $table_Name, fields: $fields, join: $join, where: $where, orderBy: $orderBy};
        if (searchKeyword.length >= 1) {
            $.ajax({
                url: '../assets/search.php',
                type: 'post',
                data: $dataString,
                dataType: "json",
                cache: false,
                async: false,
                success: function (data) {
                    if (!$.isArray(data) || !data.length) {
                        $('table#dataTable  tbody').empty()
                        content = '<tr><td>SORRY! No Record Found.</td></tr>';
                        $('table#dataTable  tbody').append(content);
                        return;
                    }
                    else {
                        $('table#dataTable  tbody').empty()
                        $.each(data, function () {
                            empName = this.name;
                            desig = this.designation;
                            content = '<tr><td style="display:none;">' + this.emp_ID + '</td>';
                            content += '<td>' + this.inTime + '</td>';
                            content += '<td>' + this.outTime + '</td>';
                            content += '<td>' + this.date + '</td>';
                            content += '<td>' + "<a class='btn btn-xs btn-warning left-margin' onclick='run();'>Edit</a>";
                            $('table#dataTable  tbody').append(content);
                        });
                        $('#empName').append(empName);
                        $('#desig').append(desig);
                    }

                }
            });

        }
    }
    function run() {
        document.getElementById('dataTable').onclick = function (event) {
            event = event || window.event; //for IE8 backward compatibility
            var target = event.target || event.srcElement; //for IE8 backward compatibility
            while (target && target.nodeName != 'TR') {
                target = target.parentElement;
            }
            var cells = target.cells; //cells collection
            //var cells = target.getElementsByTagName('td'); //alternative
            if (!cells.length || target.parentNode.nodeName == 'THEAD') { // if clicked row is within thead
                return;
            }
            //var f1 = document.getElementById('Category');
            up_checkIn.value = cells[1].innerHTML;
            up_checkOut.value = cells[2].innerHTML;
            empid.value = cells[0].innerHTML;
            date.value = cells[3].innerHTML;

        }
    }
//============================================================================================================== 
</script>
