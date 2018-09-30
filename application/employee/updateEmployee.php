<?php
//employee index
require ('../../core/init.php');
$page_title = "Update Employee Details";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
//Load page Headder
require_once(FOLDER_Template . 'header.php');

// create product button
echo"<p>";
echo "<div class='right-button-margin'>";

echo "</div>";

echo "<div class='right-button-margin'>";

echo "</div>";

echo "<div class='right-button-margin'>";
echo "<a href='editEmployee.php' class='btn btn-default pull-right left-margin'>Back</a>";
echo "<a href='addEmployee.php' class='btn btn-default pull-right left-margin'>Add New Employee</a>";
echo "</div>";

// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

$table_Name = 'employee';
$fiels = 'employee.*,employee.designation AS desigID,designation.designation';
$join = 'designation ON employee.designation = number';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, 'serial_no=' . $id, NULL, NULL);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $employee->setSerial_no($serial_no);
    $employee->setDesignation($desigID);
    $employee->setName($name);
    $employee->setEpf_no($epf_no);
    $employee->setAppoinment_date($appoinment_date);

    $employee->setNic($nic);
    $employee->setDob($dob);
    $employee->setAddress($address);
    $employee->setContact($contact);
    $employee->setWorkSite($workSite);

    $employee->setImg($img);
    $employee->setBasicSalary($basicSalary);
    $employee->setWorkTarget($workTarget);
    $employee->setSpIntencive($spIntencive);
    $employee->setDifficulte($difficult);
    $employee->setOther($other);
//$employee->setSerial_no($serial_no);
}
// if the form was submitted
if ($_POST) {
    $txtID = filter_input(INPUT_POST, 'txtId');
    $txtName = filter_input(INPUT_POST, 'txtName');
    $txtNic = filter_input(INPUT_POST, 'txtNic');
    $txtDob = filter_input(INPUT_POST, 'txtDob');
    $txtAddress = filter_input(INPUT_POST, 'txtAddress');
    $txtContact = filter_input(INPUT_POST, 'txtContact');
    $txtDesig = filter_input(INPUT_POST, 'txtDesig');
    $txtEpf = filter_input(INPUT_POST, 'txtEpf');
    $txtAppoinmnt = filter_input(INPUT_POST, 'txtAppoinmnt');
    $txtwork = filter_input(INPUT_POST, 'txtWork');
    $txtBasicSal = filter_input(INPUT_POST, 'txtBasicSal');
    $txtWrkTrgt = filter_input(INPUT_POST, 'txtWrkTrgt');
    $txtSpIncntive = filter_input(INPUT_POST, 'txtSpIncntive');
    $txtDfIncentive = filter_input(INPUT_POST, 'txtDfIncentive');
    $txtOther = filter_input(INPUT_POST, 'txtOther');

    //Image Update Check
    $imagePreCheck = filter_input(INPUT_POST, 'imagePreCheck');
    $newfilename = NULL;
    if (empty($_FILES['image']['tmp_name'])) {
        if (empty($imagePreCheck)) {
            $newfilename = "addPhoto.png";
        } else {
            $newfilename = $imagePreCheck;
        }
    } else {

        $allowed = array('gif', 'png', 'jpg', 'jpeg', 'JPG');
        $todir = '../../images/EmployeePhoto/';
        $filename = $_FILES['image']['name'];
        $ext = explode(".", strtolower($_FILES["image"]["name"]));

        $newfilename = $id . "." . end($ext);

        //make directory
        if (is_dir($todir) == false) {
            $status = mkdir("$todir", 0777);
            if ($status < 1) {
                echo "<div class=\"alert alert-danger alert-dismissable\">";
                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                echo "unable to create  diractory !";
                echo "</div>";
            }
        }
        // is this file allowed
        if (in_array(end($ext), $allowed)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $todir . $newfilename);
        } else {
            return "Invalide Format/Type";
        }
    }

    //$newfilename
    //Organize Update array
    $data = array('SERIAL_NO' => $txtId,
        'FULL_NAME' => $txtFullName,
        'NAME_WITH_INITIALS' => $txtFullName,
        'PREFFERED_NAME' => $txtPreferredName,
        'EPF_NO' => $txtEpf,
        'APPOINTMENT_DATE' => $txtAppoinmnt,
        'NIC' => $txtNic,
        'DATE_OF_BIRTH' => $txtDob,
        'ADDRESS' => $txtAddress,
        'PHONE' => $txtContact,
        'PHOTO' => $newfilename,
        'BASIC_SALARY' => $txtBasicSal,
        'WORK_TARGET' => $txtWrkTrgt,
        'SP_INTENCIVE' => ($txtSpIncntive =="" ? 0.0 : $txtSpIncntive),
        'DIFFICULTY' => ($txtDfIncentive =="" ? 0.0 : $txtDfIncentive),
        'OTHER' => ($txtOther =="" ? 0.0 : $txtOther),
        'DESIGNATION_ID' => $txtDesig,
        'UPDATE_USER' => 1,
        'UPDATE_DATETIME' => date('Y-m-d H:i:s'),
        'STATUS' => 1
    );
    
    // update the product
    if ($dbCRUD->updateData($table_Name, $data, 'serial_no=' . $txtID . ' ')) {
        echo "<div class=\"alert alert-success alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "Employee Successfully updated!";
        echo "</div>";
    }
    // if unable to update the product, tell the user
    else {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "Unable to update Employee. Try again !";
        echo "</div>";
    }
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

    $(function () {
        $("#datepicker").datepicker();
        $("#datepicker1").datepicker();
    });
</script>
<form action='updateEmployee.php?id=<?php echo $id; ?>' method='post' enctype="multipart/form-data" >
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Personal Details</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <img src="<?php echo WWWROOT ?>images/EmployeePhoto/<?php echo $employee->getImg($img); ?>" class="img-thumbnail" id="preview" name="image" width="150" height="150">
                        <input type="file" class="btn btn-group-sm btn-default" value="Browse" name="image" onchange="previewImage(this)" accept="image/*">
                        <input type="hidden" id="imagePreCheck" name="imagePreCheck" value="<?php echo $employee->getImg($img); ?>"/>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <table class='table table-responsive '>
                        <tr>
                            <td>ID</td>
                            <td><input type='text' name='txtId' class='form-control' value="<?php echo $employee->getSerial_no(); ?>" required></td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td><input type='text' name='txtName' class='form-control' value="<?php echo $employee->getName(); ?>" required></td>
                        </tr>
                        <tr>
                            <td>NIC</td>
                            <td><input type='text' name='txtNic' class='form-control' value="<?php echo $employee->getNic(); ?>" required></td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td><input type='text' name='txtDob' id='datepicker' class='form-control' value="<?php echo $employee->getDob(); ?>" required></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td><input type='text' name='txtAddress' class='form-control' value="<?php echo $employee->getAddress(); ?>" required></td>
                        </tr>
                        <tr>
                            <td>Contact Number</td>
                            <td><input type='text' name='txtContact' class='form-control' value="<?php echo $employee->getContact(); ?>"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Work Details</h3>
                </div>
                <div class="panel-body">
                    <table class='table table-responsive '>
                        <tr>
                            <td>Designation</td>
                            <td>
                                <?php
// read the product categories from the database
                                $empDesig = $employee->getDesignation();
                                $stmt = $dbCRUD->selectAll('designation', '*', NULL, NULL, NULL, NULL);
// put them in a select drop-down
                                echo "<select class='form-control' name='txtDesig' required>";
                                while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row_category);
                                    if ($empDesig == $number) {
                                        echo "<option value='{$number}' selected>";
                                    } else {
                                        echo "<option value='{$number}'>";
                                    }
                                    echo "{$designation}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>EPF Number</td>
                            <td><input type='text' name='txtEpf' class='form-control'  value="<?php echo $employee->getEpf_no(); ?>" required></td>
                        </tr>
                        <tr>
                            <td>Appoinment Date</td>
                            <td><input type='text' name='txtAppoinmnt' id='datepicker1' class='form-control'  value="<?php echo $employee->getAppoinment_date(); ?>"></td>
                        </tr>
                        <tr>
                            <td>Work Station</td>
                            <td>
                                <?php
// read the product categories from the database
                                $workSite = $employee->getWorkSite();
                                $stmt = $dbCRUD->selectAll('machinesite', '*', NULL, NULL, NULL, NULL);
// put them in a select drop-down
                                echo "<select class='form-control' name='txtWork'>";
                                while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row_category);
                                    if ($workSite == $siteNo) {
                                        echo "<option value='{$siteNo}' selected>";
                                    } else {
                                        echo "<option value='{$siteNo}'>";
                                    }
                                    echo "{$siteN}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-md-6">

            <div class="page-header">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Work Details</h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-responsive '>
                            <tr>
                                <td>Basic Salary</td>
                                <td><input type='text' name='txtBasicSal' class='form-control' value="<?php echo $employee->getBasicSalary(); ?>" required></td>
                            </tr>
                            <tr>
                                <td>Work Target</td>
                                <td><input type='text' name='txtWrkTrgt' class='form-control' value="<?php echo $employee->getWorkTarget(); ?>"></td>
                            </tr>
                            <tr>
                                <td>Special Incentive</td>
                                <td><input type='text' name='txtSpIncntive' class='form-control' value="<?php echo $employee->getSpIntencive(); ?>"></td>
                            </tr>
                            <tr>
                                <td>Difficult Incentive</td>
                                <td><input type='text' name='txtDfIncentive' class='form-control' value="<?php echo $employee->getDifficulte(); ?>"></td>
                            </tr>
                            <tr>
                                <td>Other</td>
                                <td><input type='text' name='txtOther' class='form-control' value="<?php echo $employee->getOther(); ?>"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.col-sm-4 -->
            <button type="submit" class="btn btn-success">Save Employee</button>
        </div>
</form>
<?php
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
