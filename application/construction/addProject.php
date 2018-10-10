<?php
require ('../../core/init.php');
if(isset($_GET['id'])){
    $page_title = "Update Project Details";
} else {
    $page_title = "Add New Project";
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

//Dropdown list data load
$ddlClients = $dbCRUD->ddlDataLoad('SELECT * FROM client WHERE STATUS=1');


if (isset($_SESSION['insert']) && !empty($_SESSION['insert'])) {
    flash('success', '<strong>Success!</strong> Project Details successfully Saved.');
    unset($_SESSION['insert']);
    echo "<div class=\"alert alert-success alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}

if (isset($_SESSION['faild'])) {
    //print_r($_SESSION['faild']);
    flash('success', '<strong>Warning!</strong> Faild to Insert Project Details.');
    unset($_SESSION['faild']);
    echo "<div class=\"alert alert-danger alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}
if (isset($_SESSION['update']) && !empty($_SESSION['update'])) {
    flash('success', '<strong>Success!</strong> Client successfully Updated.');
    unset($_SESSION['update']);
    echo "<div class=\"alert alert-success alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}
if (isset($_SESSION['faildUpdate'])) {
    flash('success', '<strong>Warning!</strong> Faild to Update Client Details.');
    unset($_SESSION['faildUpdate']);
    echo "<div class=\"alert alert-danger alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}
?>
<script type="text/javascript">
    $(function () {
        $("#datepicker").datepicker();
        $("#datepicker1").datepicker();
        $("#datepicker2").datepicker();
    });
</script>
<?php
if (isset($_GET['id'])) {
    //update data 
    if (isset($_POST['update'])) {
        if (is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            // get the form data
            $number = filter_input(INPUT_POST, 'number');
            $name = filter_input(INPUT_POST, 'name');
            $clint_no = filter_input(INPUT_POST, 'clint_no');
            $progress = filter_input(INPUT_POST, 'progress');
            $commencement = filter_input(INPUT_POST, 'commencement');
            $completion = filter_input(INPUT_POST, 'completion');
            $extendedDate = filter_input(INPUT_POST, 'extendedDate');
            $period = filter_input(INPUT_POST, 'period');
            $sum = filter_input(INPUT_POST, 'sum');
            $esum = filter_input(INPUT_POST, 'esum');

            $table_Name = 'project';
                $data = array(
                'NAME' => $name,
                'COMMENCEMENT_DATE' => $commencement,
                'COMPLETION_DATE' => $completion,
                'EXTENDED_DATE' => $extendedDate,
                'CONTRACT_PERIOD' => $period,
                'CONTRACT_SUM' => $sum,
                'EXTENDED_CONTRACT_SUM' => $esum,
                'CLIENT_ID' => $clint_no,
                'PROGRESS' => $progress,
                'UPDATE_USER' => 1,
                'UPDATE_DATETIME' => date('Y-m-d H:i:s'),
                'STATUS' => 1
            );

            if ($dbCRUD->updateData($table_Name, $data, 'id=' . $id . ' ')) {
                $_SESSION['update'] = $id;
                header('Location:addProject.php?id=' . $id . ' ');
            } else {
                $_SESSION['faildUpdate'] = $id;
                header('Location:addProject.php?id=' . $id . ' ');
            }
        }
    } else {
        // if not submit Select data
        $id = $_GET['id'];
        $getDBClient = $dbCRUD->ddlDataLoad('SELECT client FROM project WHERE id=' . $id);
        $stmtClientData = $dbCRUD->selectAll('project', '*', NULL, 'id=' . $id, NULL, NULL);
        while ($row1 = $stmtClientData->fetch(PDO::FETCH_ASSOC)) {
            extract($row1);
            $number = $CONTRACT_NO;
            $name = $NAME;
            $commencement = $COMMENCEMENT_DATE;
            $completion = $COMPLETION_DATE;
            $extendedDate = $EXTENDED_DATE;
            $period = $CONTRACT_PERIOD;
            $sum = $CONTRACT_SUM;
            $esum = $EXTENDED_CONTRACT_SUM;
            $clint_no = $CLIENT_ID;
            $progress = $PROGRESS;
        }
        renderForm($number, $name, $commencement, $completion, $extendedDate, $period, $sum, $esum, $clint_no, $progress, $ddlClients);
    }
} else {
    renderForm(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $ddlClients);
    //Insert New data
    // if the form's submit button is clicked, we need to process the form
    if (isset($_POST['submit'])) {
        // get the form data
        $number = filter_input(INPUT_POST, 'number');
        $name = filter_input(INPUT_POST, 'name');
        $clint_no = filter_input(INPUT_POST, 'clint_no');
        $progress = filter_input(INPUT_POST, 'progress');
        $commencement = filter_input(INPUT_POST, 'commencement');
        $completion = filter_input(INPUT_POST, 'completion');
        $extendedDate = filter_input(INPUT_POST, 'extendedDate');
        $period = filter_input(INPUT_POST, 'period');
        $sum = filter_input(INPUT_POST, 'sum');
        $esum = filter_input(INPUT_POST, 'esum');

        $table_Name = 'project';
        $data = array('CONTRACT_NO' => $number,
            'NAME' => $name,
            'COMMENCEMENT_DATE' => $commencement,
            'COMPLETION_DATE' => $completion,
            'EXTENDED_DATE' => $extendedDate,
            'CONTRACT_PERIOD' => $period,
            'CONTRACT_SUM' => $sum,
            'EXTENDED_CONTRACT_SUM' => $esum,
            'CLIENT_ID' => $clint_no,
            'PROGRESS' => $progress,
            'INSERT_USER' => 1,
            'INSERT_DATETIME' => date('Y-m-d H:i:s'),
            'UPDATE_USER' => 1,
            'UPDATE_DATETIME' => date('Y-m-d H:i:s'),
            'STATUS' => 1
        );

        if ($dbCRUD->insertData($table_Name, $data)) {
            $_SESSION['insert'] = $number;
            header('Location:index.php');
        } else {
            $_SESSION['faild'] = $number;
            header('Location:addProject.php');
        }
    }
}

function renderForm($number = '', $name = '', $commencement = '', $completion = '', $extendedDate = '', $period = '', $sum = '', $esum = '', $clint_no = '', $progress = '', $ddlClients = '', $getDBClient = '') {
    ?>
    <div class="row">
        <div id='button' class='right-button-margin'>
            <a href='addProject.php' class='btn btn-default pull-left left-margin'>Refresh</a>
            <a href='index.php' class='btn btn-default pull-right left-margin'>Back</a>
            <a href='editProjects.php' class='btn btn-default pull-right left-margin'>Edit Projects</a>
        </div> 
        <div id="message"> <?php flash('success'); ?></div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Project Details</h3>
                </div>
                <div class="panel-body">
                    <form action="" method="post">
                        <div class="col-md-6">
                            <table  class='table table-responsive'>
                                <tr>
                                    <td><strong>Ref No: *</strong></td>
                                    <td>
                                        <input type="text" name="number" value="<?php echo $number ?>" class="form-control" />
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td><strong>Project Name: *</strong></td>
                                    <td>
                                        <input type="text" name="name" value="<?php echo $name ?>" class="form-control" required pattern="^[a-zA-Z. ]+$"/>
                                    </td>
                                </tr>
                                 <tr>
                                    <td> <strong>Client: *</strong></td>
                                    <td> 
                                        <select name="clint_no" id="cli_no" class="form-control">
                                            <?php
                                            //current db site name
                                            foreach ($ddlClients as $clients) {
                                                if ($clint_no == $clients['ID']) {
                                                    echo "<option value='" . $clients['ID'] . "' selected>";
                                                } else {
                                                    echo "<option value='" . $clients['ID'] . "'>";
                                                }
                                                echo $clients['NAME'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <strong>Progress: *</strong></td>
                                    <td>
                                        <select name="progress" id="progress" class="form-control">
                                            <option value="OnGoing">OnGoing</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Commencement Date: *</strong> </td>
                                    <td><input type="text" name="commencement" id="datepicker" value="<?php echo $commencement ?>" class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td> <strong>Completion Date: *</strong></td>
                                    <td>
                                        <input type="text" name="completion" id="datepicker1" value="<?php echo $completion ?>" class="form-control"/></td>
                                </tr>
                            </table>
                            <p>* required</p>
                        </div>
                        <div class="col-md-6">
                            <table  class='table table-responsive'>
                                <tr>
                                    <td> <strong>Extended Date: *</strong></td>
                                    <td>
                                        <input name="extendedDate" id="datepicker2" type="text" value="<?php echo $extendedDate ?>" class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td> <strong>Contract Period: *</strong></td>
                                    <td>
                                        <input id="period" name="period" type="text" value="<?php echo $period ?>" class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td> <strong>Contract Sum: *</strong></td>
                                    <td>
                                        <input id="sum" name="sum" type="text" value="<?php echo $sum ?>" class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td> <strong>Extended Contract Sum: *</strong></td>
                                    <td>
                                        <input id="esum" name="esum" type="text" value="<?php echo $esum ?>" class="form-control"/></td>
                                </tr>

                                <td> <strong></strong></td>
                                <td>
                                    <input type="button" name="cancle" value="Cancle" onClick="location.href = 'index.php'" class="btn btn-warning pull-right"/>
                                      
                                    <?php
                                    if(isset($_GET['id'])){
                                        echo '<input type="submit" name="update" value="Update" class="btn btn-success pull-right  left-margin" />';
                                    }  else {
                                        echo '<input type="submit" name="submit" value="Add" class="btn btn-success pull-right  left-margin" />';
                                    }
                                    ?>
                                </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>