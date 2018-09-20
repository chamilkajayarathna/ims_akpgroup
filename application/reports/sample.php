<?php
//employee details
require ('../../core/init.php');
$page_title = "PageName";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}

//Load page Headder
require_once(FOLDER_Template . 'header.php');
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
<?php 
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
