<?php
//main Index
require '../core/init.php';
if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $user = $users->userdata($_SESSION['id']);
    $username = $user['username'];
    $logAuth = $user['userLevel'];
    if ($logAuth == 1) {
    }
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}

$page_title = "Panditharatne Constructions";
require_once(FOLDER_Template . 'header.php');
//'SELECT e.name,m.date,m.in,m.out, d.designation 
//FROM attendance m JOIN employee e ON e.serial_no=m.emp_ID JOIN designation d ON 
//d.number = e.designation WHERE date = '".$curntDate."' "
?>

<div class="row">
    <span class="pull-right"><h4>Welcome Administrator</h4></span>
    <div class="col-lg-3 col-md-6" >
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-4x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h4>Absent Employees</h4>
                    </div>
                </div>
            </div>
            <a href="reports/attendance.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>


<?php
//include "template/footer.php";
//include($_SERVER['DOCUMENT_ROOT'].'IMS/template/footer.php');
require_once(FOLDER_Template . 'footer.php');
?>