<?php
//main Index
require '../../core/init.php';
if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $user = $users->userdata($_SESSION['id']);
    $username = $user['USERNAME'];
    $logAuth = $user['USER_LEVEL'];
    if ($logAuth == 1) {
    }
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}

$page_title = "IMS REPORTS";
require_once(FOLDER_Template . 'header.php');
//'SELECT e.name,m.date,m.in,m.out, d.designation 
//FROM attendance m JOIN employee e ON e.serial_no=m.emp_ID JOIN designation d ON 
//d.number = e.designation WHERE date = '".$curntDate."' "
?>
<link href="<?php FOLDER_CSS ?>/IMS/css/sb-admin-2.css" rel="stylesheet">
<div class="clearfix">&nbsp;</div>
<div class="row">
<span class="pull-right"><h4>Welcome Administrator</h4></span>
</div>
<div class="row">
    

    <div class="col-lg-3 col-md-6" >
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-barcode fa-4x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h4>Employee Attendance</h4>
                    </div>
                </div>
            </div>
            <a href="<?php echo $global->wwwroot; ?>application/reports/attendance.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6" >
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-car fa-4x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h4>Machine <br>Details</h4>
                    </div>
                </div>
            </div>
            <a href="<?php echo $global->wwwroot; ?>application/reports/machineDetails.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6" >
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-gears fa-4x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h4>Machine Service<br>Details </h4>
                    </div>
                </div>
            </div>
            <a href="<?php echo $global->wwwroot; ?>application/reports/machineService.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6" >
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-4x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h4>Employee<br>Details </h4>
                    </div>
                </div>
            </div>
            <a href="<?php echo $global->wwwroot; ?>application/reports/empDetails.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    
</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="row">
    
    <div class="col-lg-3 col-md-6" >
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-male fa-4x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h4>Contactor<br>Details</h4>
                    </div>
                </div>
            </div>
            <a href="<?php echo $global->wwwroot; ?>application/reports/clientDetails.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    
    
    <div class="col-lg-3 col-md-6" >
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-truck fa-4x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h4>Project <br>Records</h4>
                    </div>
                </div>
            </div>
            <a href="<?php echo $global->wwwroot; ?>application/reports/projectDetails.php">
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