<?php
//employee index
require ('../../core/init.php');
$page_title = "Machine Service Details";

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

//End of headder
$machineName = $dbCRUD->ddlDataLoad('SELECT id,machineName FROM machine');

if (isset($_SESSION['add'])) {
    flash('success', '<strong>Success!</strong> Machine Details successfully Updated.');
    unset($_SESSION['add']);
    echo "<div class=\"alert alert-success alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}

if (isset($_SESSION['faildAdd'])) {
    flash('success', '<strong>Warning!</strong> Faild to Insert Machine Details.');
    unset($_SESSION['faildAdd']);
    echo "<div class=\"alert alert-danger alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}
?>
<link href="../../js/search/select2.css" rel="stylesheet"/>
<script src="../../js/search/select2.js"></script>
<script>
    $(function () {
        $("#datepicker").datepicker();
    });
    $(document).ready(function () {
        $("#ddlMachine").select2({
            placeholder: "Select a State",
            allowClear: true
        });
    });
</script>
<script type="text/javascript" src="../../js/search/elementsCntroller.js"></script>
<div class="row">
    <div id='button' class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-right'>Back</a>
        <a href='editCategory.php' class='btn btn-default pull-right left-margin'>Add Categories</a>
        <a href='viewMachineService.php' class='btn btn-default pull-right left-margin'>View Service Details</a>

    </div>
    <div id="message"> <?php flash('success'); ?></div>
    <div class="col-sm-12">
        <div class="panel-body" id="get_service">

        </div>
    </div><!-- /.col-sm-4 -->
</div>
<form action='' method='post' id="serviceAdd">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default" style=" padding: 15px;"> 
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add New Service Detail</h3>
                    </div>
                    <div class="panel-body">
						<table class='table table-responsive' >
                            
                        </table>
                        <table class='table table-responsive'>
                        <tr>
                                <td>Category Name</td>
                                <td><input type='text' name='txtCategory' class='form-control' value="" required></td>
                            </tr>
                            <tr>
                                <td align="right"> <strong>Machine ID: *</strong></td>
                                <td>
                                    <select name="ddlMachine" id="ddlMachine" style="width:100%" >
                                        <option selected>Select</option>
                                        <?php
                                        foreach ($machineName as $ddlData) {
                                            echo '<option value="' . $ddlData['id'] . '">' . $ddlData['machineName'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="right"> <strong>Last Service: *</strong></td>
                                <td><input type="text" id="datepicker" name="datepicker" class='form-control' required ></td>
                            </tr>
                            <tr>
                                <td align="right"> <strong>Next Service: *</strong></td>
                                <td><input type="text" id="datepicker" name="datepicker2" class='form-control' required ></td>
                            </tr>
                            <tr>
                                <td align="right"> <strong>Mechanic: *</strong></td>
                                <td><input type="text" id="mechanic" name="mechanic" class='form-control' required ></td>
                            </tr>
                            <tr>
                                <td align="right"> <strong>Operator: *</strong></td>
                                <td><input type="text" id="operator" name="operator" class='form-control' required ></td>
                            </tr>
                            <tr>
                                <td align="right"> <strong>Date: *</strong></td>
                                <td><input type="text" id="datepicker" name="datepicker3" class='form-control' required ></td>
                            </tr>
                            <tr>
                                <td align="right"> <strong>Other Details: </strong></td>
                                <td><input type="text" id="other" name="other" class='form-control' ></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" value="Save" name="newServiceAdd" class="btn btn-sm btn-success"  class='form-control'></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- //.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-default" style=" padding: 15px;">  
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Service Detail - Filters</h3>
                    </div>
                    <div class="panel-body">
                        <div id="main">
                            <select id="ddlFilters" class="form-control dropdown" >
                                <option value="select" selected="">Select</option>
                                <option value="air_filter">Air Filter</option>
                                <option value="oil_filter">Oil Filter</option>
                                <option value="water_filter">Water Filter</option>
                            </select>
                            <br/>
                            <input type="button" id="btAdd" value="Add Element" class="btn btn-sm btn-default" />
                            <input type="button" id="btRemove" value="Remove Element" class="btn btn-sm btn-default"/>
                            <input type="button" id="btRemoveAll" value="Remove All" class="btn btn-sm btn-default" /><br />
                        </div>
                    </div>
                </div>
            <!--</div>-->
        </div>
    </div>
</form>
<form action="" method="post">
    <div class="row">

    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        var iCnt = 0;
        var optionVal = null;
        var placeHolder = null;
        var container = $(document.createElement('div')).attr('id', 'filterInput').css({
            padding: '5px', margin: '20px', width: '200px', border: '1px dashed',
            borderTopColor: '#999', borderBottomColor: '#999',
            borderLeftColor: '#999', borderRightColor: '#999'
        });
        $('#ddlFilters').change(function () {
            optionVal = $(this).find('option:selected').val();
        });
        $('#btAdd').click(function () {
            if (optionVal == null) {
                alert("Please Select Filter Type.");
            }
            else if (optionVal == "select") {
                alert("Please Select Filter Type.");
            }
            else {
                if (optionVal == "air_filter") {
                    placeHolder = "Add-Air-Filter";
                }
                if (optionVal == "oil_filter") {
                    placeHolder = "Add-Oil-Filter";
                }
                if (optionVal == "water_filter") {
                    placeHolder = "Add-Water-Filter";
                }
                if (iCnt <= 15) {
                    iCnt = iCnt + 1;
                    $(container).append('<input type=text class="form-control" id=' + optionVal +
                            ' name=' + optionVal + "[]" + ' placeholder=' + placeHolder + ' />');
                    $('#main').after(container);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
                }
                else {      
                    $(container).append('<label>Reached the limit</label>');
                    $('#btAdd').attr('class', 'bt-disable');
                    $('#btAdd').attr('disabled', 'disabled');
                }
            }
        });
        $('#btRemove').click(function () {   // REMOVE ELEMENTS ONE PER CLICK.
            if (iCnt != 0) {
                $('#tb' + iCnt).remove();
                iCnt = iCnt - 1;
            }
            if (iCnt == 0) {
                $(container).empty();
                $(container).remove();
                $('#btSubmit').remove();
                $('#btAdd').removeAttr('disabled');
                $('#btAdd').attr('class', 'bt')
            }
        });
        $('#btRemoveAll').click(function () {    // REMOVE ALL THE ELEMENTS IN THE CONTAINER.
            $(container).empty();
            $(container).remove();
            $('#btSubmit').remove();
            iCnt = 0;
            $('#btAdd').removeAttr('disabled');
            $('#btAdd').attr('class', 'bt');
        });
    });
    //======================================================================================
</script>
<?php
$srting = NULL;
$mechanicEmpID = NULL;
$operatorEmpID = NULL;
if (isset($_POST['newServiceAdd'])) {
    $airFilter = NULL;
    $oilFilter = NULL;
    $waterFilter = NULL;

    $arrAir = array();
    $arrOil = array();
    $arrWater = array();

    $arrData = array();

    if (count(filter_input(INPUT_POST, 'air_filter')) != 0) {
        foreach ($_POST['air_filter'] as $key => $value) {
            //echo htmlentities($value);
            $airFilter .= $value . ",";
            $arrAir = array('Air-Filter' => $airFilter);
        }
    }
    if (count(filter_input(INPUT_POST, 'oil_filter')) != 0) {
        foreach ($_POST['oil_filter'] as $key => $value) {
            //echo htmlentities($value);
            $oilFilter .= $value . ",";
            $arrOil = array('Oil-Filter' => $oilFilter);
        }
    }
    if (count(filter_input(INPUT_POST, 'water_filter')) != 0) {
        foreach ($_POST['water_filter'] as $key => $value) {
            //echo htmlentities($value);
            $waterFilter .= $value . ",";
            $arrWater = array('Water-Filter' => $waterFilter);
        }
    }
    $arrData = $arrAir + $arrOil + $arrWater;
    /// Serialize Array
    $arrData = serialize($arrData);
    $stringData = base64_encode(serialize($arrData));
    print_r($arrData) . "<br />";

    $machineID = filter_input(INPUT_POST, 'ddlMachine');
    $lastService = filter_input(INPUT_POST, 'lstService');
    $nextService = filter_input(INPUT_POST, 'nxtService');
    $mechanic = filter_input(INPUT_POST, 'mechanic');
    $operator = filter_input(INPUT_POST, 'operator');
    $date = filter_input(INPUT_POST, 'datepicker');
    $filters = filter_input(INPUT_POST, 'filters');
    $srvdetails = filter_input(INPUT_POST, 'other');

    if (!empty($_POST['mechanicEmpID'])) {
        $mechanicEmpID = filter_input(INPUT_POST, 'mechanicEmpID');
    }
    if (!empty($_POST['operatorEmpID'])) {
        $operatorEmpID = filter_input(INPUT_POST, 'operatorEmpID');
    }

    $table_Name = 'machineservice';
    $data = array('machineID' => $machineID,
        'lastService' => $lastService,
        'nextService' => $nextService,
        'mechanic' => $mechanic,
        'mechanicEmpID' => $mechanicEmpID,
        'operator' => $operator,
        'operatorEmpID' => $operatorEmpID,
        'date' => $date,
        'filters' => $stringData,
        'srvdetails' => $srvdetails,
    );

    if ($dbCRUD->insertData($table_Name, $data)) {
        $_SESSION['add'] = $machineID;
        header('Location:addServiceDetails.php');
    } else {
        exit;
        $_SESSION['faildAdd'] = $machineID;
        header('Location:addServiceDetails.php');
    }
}
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>