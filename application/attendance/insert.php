<?php
require '../../core/init.php';

date_default_timezone_set('Asia/Kolkata');
$curntDate = date('Y/m/d') . "<br>";
$inTime = date("H:i:s A");
$outTime = date("H:i:s A");

$table_Name = 'attendance';
$fiels = 'e.name,m.date,m.in,m.out, d.designation';
$join = 'employee e ON e.serial_no = m.emp_ID JOIN designation d ON d.number = e.designation';

$where = 'date = ' . $curntDate;
$empID = NULL;
if (isset($_POST['empID'])) {
    $empID = $_POST['empID'];
    $count = $dbCRUD->countAll('employee','serial_no','serial_no='.$empID);
    if ($count<1) {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "SORRY ! Invalid User.";
        echo "</div>";
    }
    
    $nameCheck = $dbCRUD->countAll('attendance', 'emp_ID', 'emp_ID=' . $empID . ' AND date ="' . $curntDate . '" AND dayEnd = "0" ');
    if ($nameCheck>0) {
        $nameCheck = $dbCRUD->ddlDataLoad("SELECT name FROM employee WHERE serial_no= " . $empID . " ");
        foreach ($nameCheck as $name) {
            $curntName = $name['name'];
            $data = array('outTime' => $outTime,
                'dayEnd' => 1
            );
            $dbCRUD->updateData($table_Name, $data, 'emp_ID = ' . $empID . ' AND dayEnd = 0');
            echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "GoodBye ! You Successfully Logged Out";
            echo "</div>";
        }
    } else {
        $nameCheck = $dbCRUD->countAll('attendance', 'emp_ID', 'emp_ID=' . $empID . ' AND date ="' . $curntDate . '"');
        if ($dbCRUD->ddlDataLoad('SELECT `emp_ID` FROM `attendance` WHERE `emp_ID` = ' . $empID . ' AND date ="' . $curntDate . '" AND `dayEnd` = 1')) {
            echo "<div class=\"alert alert-danger alert-dismissable\" id='alert'>";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "SORRY! You Already Logged OUT...!!!";
            echo "</div>";
        } else {
            $nameCheck = $dbCRUD->ddlDataLoad("SELECT name FROM employee WHERE serial_no= " . $empID . " ");
            foreach ($nameCheck as $name) {
                $curntName = $name['name'];
                $data = array('emp_ID' => $empID,
                    'date' => $curntDate,
                    'inTime' => $inTime,
                    'dayEnd' => 0
                );
                $dbCRUD->insertData($table_Name, $data);
                echo "<div class=\"alert alert-success alert-dismissable\" id='alert'>";
                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                echo "Welcome! You successfully Logged In";
                echo "</div>";
            }
        }
    }
}

$query = 'select a.*, e.name, d.designation '
        . 'from attendance a, employee e, designation d '
        . 'where a.emp_ID = e.serial_no AND d.number = e.designation AND a.emp_ID=' . $empID . ' AND a.date ="' . $curntDate . '"';

$stmt1 = $dbCRUD->ddlDataLoad($query);
$name = NULL;
$date = NULL;
$in = NULL;
$out = NULL;

foreach ($stmt1 as $attendance1) {
    $name = $attendance1['name'];
    $date = $attendance1['date'];
    $in = $attendance1['inTime'];
    $out = $attendance1['outTime'];
}
?>
<div class="row">
    <div class="col-lg-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12">
                        <span><i class="fa fa-users fa-2x">&nbsp;&nbsp; <?php echo $name ?></i></span>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">
                    <div class="page-header">
                        <h3>IN Time &nbsp; :- &nbsp;<strong><?php echo $in ?></strong></h3>
                    </div>
                    <div class="page-header">
                        <h3>OUT Time &nbsp; :- &nbsp;<strong><?php echo $out ?></strong></h3>
                    </div>
                </span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<script>
    //$('#alert').show(0).delay(8000).hide(0);
</script>