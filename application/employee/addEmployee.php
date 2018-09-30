<?php
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

// set page headers
$page_title = "Add New Employee";
//include_once "header.php";
require_once(FOLDER_Template . 'header.php');

// read products button
echo "<div class='right-button-margin'>";
echo "<a href='index.php' class='btn btn-default pull-right left-margin'>View Employee</a>";
echo "<a href='editEmployee.php' class='btn btn-default pull-right left-margin'>Edit Employee</a>";
echo "<a href='category.php' class='btn btn-default pull-right left-margin'>Category Details</a>";
echo "</div>";

$serialNo = $dbCRUD->selectAll('employee', 'SERIAL_NO', NULL, NULL, 'SERIAL_NO DESC', '1');
if ($row1 = $serialNo->fetch(PDO::FETCH_ASSOC)) {
    $sno = substr(extract($row1), 1);
    //print_r($serial_no);
    if($sno){
        $newSerialNo = $sno + 1;
    }
}
else {
    $newSerialNo = 1;
    $newSerialNo = "E".str_pad($newSerialNo, 4, '0', STR_PAD_LEFT);
}

// if the form was submitted
if ($_POST) {
    // set product property values
    $txtId = $newSerialNo;
    $txtFullName = filter_input(INPUT_POST, 'txtFullName');
    $txtInitialName = filter_input(INPUT_POST,'txtInitialName');
    $txtPreferredName = filter_input(INPUT_POST,'txtPreferredName');
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
    //====================================================================================================
    // Save Image
    if (empty($_FILES['image']['tmp_name'])) {
        $newfilename = "addPhoto.png";
    } else {
        $allowed = array('gif', 'png', 'jpg', 'jpeg');
        $todir = 'images/EmployeePhoto/';
        $filename = $_FILES['image']['name'];
        $ext = explode('.', strtolower($_FILES["image"]["name"]));
        $newfilename = $id . "." . end($ext);
        //make directory
        if (is_dir($todir) == false) {
            $status = mkdir("$todir", 0777);
            if ($status < 1) {
                return "unable to create  diractory $file_dir ";
            }
        }
        // is this file allowed
        if (in_array(end($ext), $allowed)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $todir . $newfilename);
            echo "Image Uploaded";
        } else {
            return "Invalide Format/Type";
        }
    }
    //====================================================================================================
    $table_Name = 'employee';
    //$fiels = 'employee.name,employee.epf_no,employee.appoinment_date,employee.nic,employee.dob,employee.address,employee.contact,designation.designation';
    //$join = 'designation ON employee.designation = number';
    //Organize data to insert with field name and value
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
        'INSERT_USER' => 1,
        'INSERT_DATETIME' => date('Y-m-d H:i:s'),
        'UPDATE_USER' => 1,
        'UPDATE_DATETIME' => date('Y-m-d H:i:s'),
        'STATUS' => 1
    );

    // Add new record
    if ($dbCRUD->insertData($table_Name, $data)) {
        echo "<div class=\"alert alert-success alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
        echo "Thank you! New Employee saved successfully.";
        echo "</div>";
    }

    // if unable to add the record, error message
    else {
        echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "SORRY! Unable to save new employee. Try Again.";
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
        $("#datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1950:' + new Date().getFullYear().toString()
        });
        $("#datepicker1").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '2010:' + new Date().getFullYear().toString()
        });
    });
</script>

<!-- HTML form for creating a product -->
<form action='addEmployee.php' method='post'>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Personal Details</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <img src="<?php echo WWWROOT ?>images/addPhoto.png" class="img-thumbnail" id="preview" name="image" width="150" height="150">
                        <input type="file" class="btn btn-group-sm btn-default" value="Browse" name="image" onchange="previewImage(this)" accept="image/*">

                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <table class='table table-responsive'>
                        <tr>
                            <td>Employee No</td>
                            <td><input type='text' name='txtId' class='form-control' value="<?php echo $newSerialNo ?>" readonly></td>
                        </tr>
                        <tr>
                            <td>Full Name</td>
                            <td><input type='text' name='txtFullName' class='form-control' required title="Employee Name"></td>
                        </tr>
                        
                        <tr>
                            <td>Name with initials</td>
                            <td><input type='text' name='txtInitialName' class='form-control' required title="Employee Name"></td>
                        </tr>
                        
                        <tr>
                            <td>Preferred Name</td>
                            <td><input type='text' name='txtPreferredName' class='form-control' required title="Employee Name"></td>
                        </tr>
                        
                        <tr>
                            <td>NIC</td>
                            <td><input type='text' name='txtNic' class='form-control' required pattern="[0-9]{9}V" title="Enter NIC- 9 digits Number"></td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td><input type='text' name='txtDob' id='datepicker' class='form-control' required  title="Enter Employee Date of Birth"></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td><input type='text' name='txtAddress' class='form-control' required title="Enter Employee Address"></td>
                        </tr>
                        <tr>
                            <td>Contact Number</td>
                            <td><input type='text' name='txtContact' pattern="[\+]\d{2}[\(]\d{2}[\)]\d{4}[\-]\d{4}" class='form-control'></td>
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
                                $stmt = $dbCRUD->selectAll('designation', '*', NULL, NULL, NULL, NULL);
// put them in a select drop-down
                                echo "<select class='form-control' name='txtDesig' required>";
                                while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row_category);
                                    echo "<option value='{$ID}'>{$NAME}</option>";
                                }

                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>EPF Number</td>
                            <td><input type='text' name='txtEpf' class='form-control' required pattern="\d*" title="Enter Employee EPF No"></td>
                        </tr>
                        <tr>
                            <td>Appoinment Date</td>
                            <td><input type='text' name='txtAppoinmnt' id='datepicker1' class='form-control'></td>
                        </tr>
                        <tr>
                            <td>Work Station</td>
                            <td>
                                <?php
// read the product categories from the database
                                $stmt = $dbCRUD->selectAll('machinesite', '*', NULL, NULL, NULL, NULL);
// put them in a select drop-down
                                echo "<select class='form-control' name='txtWork'>";
                                while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row_category);
                                    echo "<option value='{$siteNo}'>{$siteN}</option>";
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
                                <td><input type='text' name='txtBasicSal' class='form-control' required pattern="\d*" title="Enter Employee Basic Salary"></td>
                            </tr>
                            <tr>
                                <td>Work Target</td>
                                <td><input type='text' name='txtWrkTrgt' class='form-control' ></td>
                            </tr>
                            <tr>
                                <td>Special Incentive</td>
                                <td><input type='text' name='txtSpIncntive' class='form-control' ></td>
                            </tr>
                            <tr>
                                <td>Difficult Incentive</td>
                                <td><input type='text' name='txtDfIncentive' class='form-control' ></td>
                            </tr>
                            <tr>
                                <td>Other</td>
                                <td><input type='text' name='txtOther' class='form-control'></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.col-sm-4 -->
            <button type="submit" class="btn btn-success">Save Employee</button>
        </div>
</form>

<script type="text/javascript">
//    $(document).ready(function(){
//       $( "#datepicker" ).datepicker({
//            changeMonth: true,
//            changeYear: true
//          });
//    });
//    
  
    
  </script>

<?php
//include_once "footer.php";
require_once(FOLDER_Template . 'footer.php');
?>