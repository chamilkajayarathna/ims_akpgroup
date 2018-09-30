<?php
//employee index
require ('../../core/init.php');

if(isset($_GET['id'])){
    $page_title = "Update Machine Details";
}  else {
    $page_title = "Add New Machine";
}

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

$table_Name = 'machine m, machinebrand b, machinesite s, machineName n';
$fields = 'm.*, b.*, s.*, n.*';
$join = NULL;
$whereCond = 'm.brand = b.brandNo AND m.siteName = s.siteNo AND n.nameIdMachine = m.nameId';
$order = 'm.id DESC';
$limit = '1';

$serialNo = $dbCRUD->selectAll($table_Name, $fields, $join, $whereCond, $order, $limit);
while ($row1 = $serialNo->fetch(PDO::FETCH_ASSOC)) {
    extract($row1);
    //print_r($serial_no);
    if ($id == 0) {
        $newcount = 1;
    } else {
        $newcount = $id + 1;
    }
}
//Dropdown list data load
$machine = $dbCRUD->ddlDataLoad('SELECT * FROM machineName');
$brnd = $dbCRUD->ddlDataLoad('SELECT * FROM machinebrand');
$site1 = $dbCRUD->ddlDataLoad('SELECT * FROM machinesite');

// create product button
echo "<div class='right-button-margin'>";
echo "<a href='editCategory.php' class='btn btn-default pull-right left-margin'>Add Catgories</a>";
echo "<a href='index.php' class='btn btn-default pull-right left-margin'>View Machine</a>";
echo "</div>";

if (isset($_SESSION['update'])) {
    flash('success', '<strong>Success!</strong> Machine Details successfully Updated.');
    unset($_SESSION['update']);
    echo "<div class=\"alert alert-success alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}

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

if (isset($_SESSION['faild'])) {
    flash('success', '<strong>Warning!</strong> Faild to Update Machine Details.');
    unset($_SESSION['faild']);
    echo "<div class=\"alert alert-danger alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}
?>
<script type="text/javascript">
    function previewImage(input) {
        var preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.setAttribute('src', e.target.result);
                $('#preview').Jcrop({
                    onRelease: yourAjaxFunctionToSubmitToServer
                });
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.setAttribute('src', 'placeholder.png');
        }
    }
</script>
<?php

function renderForm($id = '', $nameIdMachine = '', $db_machinName = '', $categoryID = '', $db_brand = '', $db_site = '', $machine = '', $mnum = '', $name = '', $brandNo = '', $db_brnd = '', $brnd = '', $model = '', $eModel = '', $eSerial = '', $cSerial = '', $year = '', $details = '', $hp = '', $site1 = '') {
    ?>
    <div class="row">
        <div id="message"> <?php flash('success'); ?></div>
        <div class="col-md-12">

            <div class="page-header">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Work Details</h3>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="col-md-6">
                                <table class='table table-responsive'>

                                    <tr>
                                        <td align="right"><strong>ID: *</strong></td>
                                        <td><input type="text" name="id" value="<?php echo $id; ?>"  class='form-control' readonly/><br/></td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Machine: *</strong></td>
                                        <td>
                                            <?php
                                            echo "<select class='form-control'' name='Cname' id='Cname' required>";
                                            foreach ($machine as $machineName) {
                                                if ($categoryID == $machineName['nameIdMachine']) {
                                                    echo "<option value='" . $machineName['nameIdMachine'] . "' selected>";
                                                } else {
                                                    echo "<option value='" . $machineName['nameIdMachine'] . "'>";
                                                }
                                                echo $machineName['machineCategory'] . "</option>";
                                            }
                                            echo "</select>";
                                            ?>
                                           </td>
                                    </tr>
                                    <tr>
                                        <td align="right"> <strong>Machine No: *</strong></td>
                                        <td><input type="text" name="mnum" value="<?php echo $mnum ?>"  class='form-control' required title="Enter Machine Number"/><br/></td>
                                    </tr>
                                    <tr>
                                        <td align="right"> <strong>Machine Name: *</strong></td>
                                        <td><input type="text" name="name" value="<?php echo $name ?>"  class='form-control' required title="Enter Machine Name"/><br/></td>
                                    </tr>
                                    <tr>
                                        <td align="right"> <strong>Brand: *</strong></td>
                                        <td>
                                            <?php
                                            echo "<select class='form-control' name='brnd' id='brnd' required>";
                                            foreach ($brnd as $machineBrnd) {
                                                if ($db_brand == $machineBrnd['brandNo']) {
                                                    echo "<option value='" . $machineBrnd['brandNo'] . "' selected>";
                                                } else {
                                                    echo "<option value='" . $machineBrnd['brandNo'] . "'>";
                                                }
                                                echo $machineBrnd['brandName'] . "</option>";
                                            }
                                            echo "</select>";
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Model: *</strong></td>
                                        <td><input type="text" name="model" value="<?php echo $model ?>"  class='form-control' required/></td>
                                    </tr>
                                    <tr>
                                        <td align="right"> <strong>Engine Model: *</strong></td>
                                        <td><input type="text" name="eModel" value="<?php echo $eModel ?>"  class='form-control'/></td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class='table table-responsive'>
                                    <tr>
                                        <td align="right"><strong>Engine Serial: *</strong> </td>
                                        <td><input type="text" name="eSerial" value="<?php echo $eSerial ?>" class='form-control'/></td>
                                    </tr>
                                    <tr>
                                        <td align="right"> <strong>Chassi Serial: *</strong></td>
                                        <td><input type="text" name="cSerial" value="<?php echo $cSerial ?>"  class='form-control'/></td>
                                    </tr>
                                    <tr>
                                        <td align="right"> <strong>Year : *</strong></td>
                                        <td> <input type="text" name="year" value="<?php echo $year ?>"  class='form-control'/></td>
                                    </tr>
                                    <tr>
                                        <td align="right"> <strong>Details: *</strong></td>
                                        <td><input type="text" name="details" value="<?php echo $details ?>"  class='form-control'/></td>
                                    </tr>
                                    <tr>
                                        <td align="right"> <strong>HorsePower: *</strong></td>
                                        <td><input type="text" name="hp" value="<?php echo $hp ?>"  class='form-control'/></td>
                                    </tr>
                                    <tr>
                                        <td align="right"> <strong>Site Name: *</strong></td>
                                        <td>
                                            <?php
                                            echo "<select class='form-control' name='site' id='site' required>";
                                            foreach ($site1 as $dbSites) {

                                                if ($db_site == $dbSites['siteNo']) {
                                                    echo "<option value='" . $dbSites['siteNo'] . "' selected>";
                                                } else {
                                                    echo "<option value='" . $dbSites['siteNo'] . "'>";
                                                }
                                                echo $dbSites['siteN'] . "</option>";
                                            }
                                            echo "</select>";
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> <strong></strong></td>
                                        <td><button type="submit" name="addNew" class="btn btn-success">Save Machine</button>
                                            <input type="button" name="cancle" value="Cancle" onClick="location.href = 'index.php'" class="btn btn-warning"/>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.col-sm-4 -->
        </div>
    </div>
    <?php
}

if (isset($_GET['id'])) {
    // if the form's submit button is clicked, we need to process the form
    if (isset($_POST['addNew'])) {
        // make sure the 'id' in the URL is valid
        if (is_numeric($_POST['id'])) {
            $id = $_POST['id'];
            $mnum = htmlentities($_POST['mnum'], ENT_QUOTES);
            $name = htmlentities($_POST['name'], ENT_QUOTES);
            $model = htmlentities($_POST['model']);
            $Cname = htmlentities($_POST['Cname'], ENT_QUOTES);
            $brnd = htmlentities($_POST['brnd'], ENT_QUOTES);
            $eModel = htmlentities($_POST['eModel'], ENT_QUOTES);
            $eSerial = htmlentities($_POST['eSerial'], ENT_QUOTES);
            $cSerial = htmlentities($_POST['cSerial'], ENT_QUOTES);
            $year = htmlentities($_POST['year'], ENT_QUOTES);
            $details = htmlentities($_POST['details'], ENT_QUOTES);
            $hp = htmlentities($_POST['hp'], ENT_QUOTES);
            $site = htmlentities($_POST['site'], ENT_QUOTES);

            $data = array('nameId' => $Cname,
                'machineNo' => $mnum,
                'machineName' => $name,
                'brand' => $brnd,
                'model' => $model,
                'engineModel' => $eModel,
                'engineSerial' => $eSerial,
                'chassiSerial' => $cSerial,
                'year' => $year,
                'details' => $details,
                'hp' => $hp,
                'siteName' => $site
            );

            $table_Name_update = 'machine';

            if ($dbCRUD->updateData($table_Name_update, $data, 'id=' . $id . ' ')) {
                $_SESSION['update'] = $id;
                header('Location:addEditMachine.php?id=' . $id . ' ');
            } else {
                $_SESSION['faild'] = $id;
                header('Location:addEditMachine.php?id=' . $id . ' ');
            }
        } else {
            echo "Error Add New Record..";
        }
    } else {
        $id = $_GET['id'];

        $whereCond1 = 'm.brand = b.brandNo AND m.siteName = s.siteNo AND n.nameIdMachine = m.nameId AND m.id=' . $id;
        $order1 = NULL;
        $limit1 = NULL;

        $getSingleUser = $dbCRUD->selectAll($table_Name, $fields, $join, $whereCond1, $order1, $limit1);
        while ($row1 = $getSingleUser->fetch(PDO::FETCH_ASSOC)) {
            extract($row1);
            $db_machinName = $machineCategory;
            $nameIdMachine = $nameIdMachine;
            $categoryID = $nameId;
            $db_brand = $brand;
            $db_site = $siteName;
            $mnum = $machineNo;
            $name = $machineName;
            $db_brnd = $brandName;
            $brandNo = $brandNo;
            $model = $model;
            $eModel = $engineModel;
            $eSerial = $engineSerial;
            $cSerial = $chassiSerial;
            $year = $year;
            $details = $details;
            $hp = $hp;
        }
        renderForm($id, $nameIdMachine, $db_machinName, $categoryID, $db_brand, $db_site, $machine, $mnum, $name, $brandNo, $db_brnd, $brnd, $model, $eModel, $eSerial, $cSerial, $year, $details, $hp, $site1);
    }
} else {
    renderForm($newcount, NULL, NULL, NULL, NULL, NULL, $machine, NULL, NULL, NULL, NULL, $brnd, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $site1);

    if (isset($_POST['addNew'])) {

        $id = filter_input(INPUT_POST, 'id');
        $mnum = filter_input(INPUT_POST, 'mnum');
        $name = filter_input(INPUT_POST, 'model');
        $Cname = filter_input(INPUT_POST, 'Cname');
        $brnd = filter_input(INPUT_POST, 'brnd');
        $eModel = filter_input(INPUT_POST, 'eModel');
        $eSerial = filter_input(INPUT_POST, 'eSerial');
        $cSerial = filter_input(INPUT_POST, 'cSerial');
        $year = filter_input(INPUT_POST, 'year');
        $details = filter_input(INPUT_POST, 'details');
        $hp = filter_input(INPUT_POST, 'hp');
        $site = filter_input(INPUT_POST, 'site');

        $table_Name = 'machine';
        $data = array('id' => $id,
            'nameId' => $Cname,
            'machineNo' => $mnum,
            'machineName' => $name,
            'brand' => $brnd,
            'model' => $model,
            'engineModel' => $eModel,
            'engineSerial' => $eSerial,
            'chassiSerial' => $cSerial,
            'year' => $year,
            'details' => $details,
            'hp' => $hp,
            'siteName' => $site
        );


        if ($dbCRUD->insertData($table_Name, $data)) {
            $_SESSION['add'] = $id;
            header('Location:addEditMachine.php');
        } else {
            $_SESSION['faildAdd'] = $id;
            header('Location:addEditMachine.php');
        }
        //header('Location:addnewRec.php');
    }
}
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
