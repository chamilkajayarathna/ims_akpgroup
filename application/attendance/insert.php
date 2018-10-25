<?php
require '../../core/init.php';

date_default_timezone_set('Asia/Kolkata');
//$curntDate = date('Y/m/d') . "<br>";
$curntDateTime = date("Y-m-d H:i:s");
$curntDate = date('Y/m/d');
$curntTime = date("H:i:s");
$inTime = date("H:i:s A");
$outTime = date("H:i:s A");

$table_Name = 'attendance';
$fiels = 'e.name,m.date,m.in,m.out, d.designation';
$join = 'employee e ON e.serial_no = m.emp_ID JOIN designation d ON d.number = e.designation';

$where = 'date = ' . $curntDate;
$empID = NULL;
$employee_id = NULL;
if (isset($_POST['empID'])) {
    $empID = $_POST['empID'];
    //$count = $dbCRUD->get('employee','SERIAL_NO','SERIAL_NO='.$empID);

    $table_Name = 'employee';
    $fiels = '*';
    $join = NULL;
    $where = 'SERIAL_NO=\'' . $empID . '\'';

    $stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $where);
    $count = $stmt->rowCount();

    if ($count < 1) {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "SORRY ! Invalid Employee ID.";
        echo "</div>";
    } else if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //extract($row);
        $employee_id = $row['ID'];

        $tableName = 'attendance';
        $fields = '*';
        $join = NULL;
        $where = 'EMPLOYEE_ID=\'' . $employee_id . '\' AND DATE(DATE_TIME)=\'' . $curntDate . '\'';
        $order = ' DATE_TIME DESC';
        $limit = NULL;

        $stmt = $dbCRUD->selectAll($tableName, $fields, $join, $where, $order, $limit);
        $todayAttendanceCount = $stmt->rowCount();

        if ($todayAttendanceCount > 0) {
            $attendanceType = '';
            if ($firstRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $checkTime = DateTime::createFromFormat('H:i a', '4:30 pm');
                if ($firstRow['TYPE'] == 'CHECK-IN') {
                    if ($curntTime < $checkTime) {
                        $attendanceType = 'TEMP-OUT';
                    } else {
                        $attendanceType = 'CHECK-OUT';
                    }
                } else if ($firstRow['TYPE'] == 'TEMP-OUT') {
                    if ($curntTime < $checkTime) {
                        $attendanceType = 'TEMP-IN';
                    } else {
                        $attendanceType = 'CHECK-OUT';
                    }
                } else if ($firstRow['TYPE'] == 'TEMP-IN') {
                    if ($curntTime < $checkTime) {
                        $attendanceType = 'TEMP-OUT';
                    } else {
                        $attendanceType = 'CHECK-OUT';
                    }
                }
                if ($attendanceType != '') {
                    $data = array(
                        'DATE_TIME' => $curntDateTime,
                        'TYPE' => $attendanceType,
                        'EMPLOYEE_ID' => $employee_id,
                        'INSERT_USER' => 1,
                        'INSERT_DATETIME' => date('Y-m-d H:i:s'),
                        'UPDATE_USER' => 1,
                        'UPDATE_DATETIME' => date('Y-m-d H:i:s'),
                        'STATUS' => 1
                    );
                    $success = $dbCRUD->insertData($tableName, $data);
                    if ($success) {
                        echo "<div class=\"alert alert-success alert-dismissable\" id='alert'>";
                        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                        echo $attendanceType . " Marked Successfully";
                        echo "</div>";
                    }
                }
            }
        } else {

            $data = array(
                'DATE_TIME' => $curntDateTime,
                'TYPE' => 'CHECK-IN',
                'EMPLOYEE_ID' => $employee_id,
                'INSERT_USER' => 1,
                'INSERT_DATETIME' => date('Y-m-d H:i:s'),
                'UPDATE_USER' => 1,
                'UPDATE_DATETIME' => date('Y-m-d H:i:s'),
                'STATUS' => 1
            );
            $success = $dbCRUD->insertData($tableName, $data);
            if ($success) {
                echo "<div class=\"alert alert-success alert-dismissable\" id='alert'>";
                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                echo "CHECK-IN Marked Successfully";
                echo "</div>";
            }
        }
    }
}

$name = NULL;
$date = NULL;
$in = NULL;
$out = NULL;
$tempInOut = array();

if ($employee_id != NULL) {
    $tableName = 'employee e, designation d, attendance a';
    $fields = '*';
    $join = NULL;
    $where = ' e.DESIGNATION_ID=d.ID AND e.ID=a.EMPLOYEE_ID AND e.ID=\'' . $employee_id . '\' AND DATE(a.DATE_TIME)=\'' . $curntDate . '\'';
    $order = ' a.DATE_TIME DESC';
    $limit = NULL;

    $stmt = $dbCRUD->selectAll($tableName, $fields, $join, $where, $order, $limit);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $name = $row['NAME_WITH_INITIALS'];
        if ($row['TYPE'] == 'CHECK-IN') {
            $in = substr($row['DATE_TIME'], 11, 8);
        } else if ($row['TYPE'] == 'CHECK-OUT') {
            $out = substr($row['DATE_TIME'], 11, 8);
        } else {
            array_push($tempInOut, $row['TYPE'] . ":" . $row['DATE_TIME']);
        }
    }
    $a = 0;
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
            <div class="panel-body">
                <div class="page-header">
                    <h3>IN Time &nbsp; :- &nbsp;<strong><?php echo $in ?></strong></h3>
                </div>
                <div class="page-header">
                    <h3>OUT Time &nbsp; :- &nbsp;<strong><?php echo $out ?></strong></h3>
                </div>
                <?php if (sizeof($tempInOut) > 0) { ?>
                    <div class="page-header">
                        <table class="table table-striped table-condensed">
                            <?php
                            $count = 0;
                            foreach ($tempInOut as $temp) {
                                ?>
                                <tr>
                                    <td><?php echo ++$count; ?></td>
                                    <td><?php echo substr($temp, 0, stripos($temp, ":")) ?></td>
                                    <td><?php echo substr(substr($temp, stripos($temp, ":") + 1), 11, 8); ?></td>
                                </tr>
    <?php } ?>



                        </table>
                    </div>
<?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    //$('#alert').show(0).delay(8000).hide(0);
</script>