<?php
require ('../../../core/init.php');
if (isset($_GET['id'])) {
    $page_title = "Update Site Details";
} else {
    $page_title = "Add New Site";
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
require_once(FOLDER_Template . 'header-without-navi.php');

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
    flash('success', '<strong>Warning!</strong> Failed to Insert Site Details.');
    unset($_SESSION['faild']);
    echo "<div class=\"alert alert-danger alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}
if (isset($_SESSION['update']) && !empty($_SESSION['update'])) {
    flash('success', '<strong>Success!</strong> Client Successfully Updated.');
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
$id= filter_input(INPUT_GET, 'id');
$pid = filter_input(INPUT_GET, 'pid');
$projId = $pid;
if (isset($id) && isset($pid)) {
    $name = '';
    $address = '';
    $longitude = '';
    $latitude = '';
    $progress = '';
    //update data 
    if (isset($_POST['update'])) {
        if (is_numeric(filter_input(INPUT_GET, 'pid'))) {
            $id = filter_input(INPUT_GET, 'pid');
            // get the form data
            $name = filter_input(INPUT_POST, 'name');
            $address = filter_input(INPUT_POST, 'address');
            $longitude = filter_input(INPUT_POST, 'longitude');
            $latitude = filter_input(INPUT_POST, 'latitude');
            $progress = filter_input(INPUT_POST, 'progress');
            $projectId = filter_input(INPUT_GET, 'pid');

            $table_Name = 'site';
            $data = array(
                'NAME' => $name,
                'ADDRESS' => $address,
                'LONGITUDE' => $longitude,
                'LATITUDE' => $latitude,
                'PROGRESS' => $progress,
                'PROJECT_ID' => $projectId,
                'INSERT_USER' => 1,
                'INSERT_DATETIME' => date('Y-m-d H:i:s'),
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
        $id = filter_input(INPUT_GET, 'pid');
        //$getDBClient = $dbCRUD->ddlDataLoad('SELECT client FROM site WHERE PROJECT_ID=' . $id);
        $stmtClientData = $dbCRUD->selectAll('site', '*', NULL, 'PROJECT_ID=' . $id, NULL, NULL);
        while ($row1 = $stmtClientData->fetch(PDO::FETCH_ASSOC)) {
            extract($row1);
            $name = $NAME;
            $address = $ADDRESS;
            $longitude = $LONGITUDE;
            $latitude = $LATITUDE;
            $progress = $PROGRESS;
        }
        renderForm($name ,$address ,$longitude ,$latitude ,$progress = '', $pid);
    }
} else {
    renderForm(NULL, NULL, NULL, NULL, NULL, $pid);
    //Insert New data
    // if the form's submit button is clicked, we need to process the form
    if (isset($_POST['submit'])) {
        // get the form data
        $name = filter_input(INPUT_POST, 'name');
        $address = filter_input(INPUT_POST, 'address');
        $longitude = filter_input(INPUT_POST, 'longitude');
        $latitude = filter_input(INPUT_POST, 'latitude');
        $progress = filter_input(INPUT_POST, 'progress');
        $projectId = filter_input(INPUT_POST, 'pid');
        $table_Name = 'site';
        $data = array(
            'NAME' => $name,
            'ADDRESS' => $address,
            'LONGITUDE' => $longitude,
            'LATITUDE' => $latitude,
            'PROGRESS' => $progress,
            'PROJECT_ID' => $projectId,
            'INSERT_USER' => 1,
            'INSERT_DATETIME' => date('Y-m-d H:i:s'),
            'UPDATE_USER' => 1,
            'UPDATE_DATETIME' => date('Y-m-d H:i:s'),
            'STATUS' => 1
        );

        if ($dbCRUD->insertData($table_Name, $data)) {
            //$_SESSION['insert'] = $number;
            header('Location:../view.php?id=' . $projectId);
        } else {
            $_SESSION['faild'] = $name;
            header('Location:add.php?pid=' . $projectId);
        }
    }
}

function renderForm($name = '', $address = '', $longitude = '', $latitude = '', $progress = '', $pid='') {
    ?>
    <div class="row">
        <div id="message"> <?php flash('success'); ?></div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Site</h3>
                </div>
                <div class="panel-body">
                    <form action="site/add.php" method="post">
                        <input type="hidden" name="pid" value="<?php echo $pid?>"/>
                        <div class="col-md-12">
                            <table  class='table table-responsive'>
                                <tr>
                                    <td><strong>Site Name: *</strong></td>
                                    <td>
                                        <input type="text" name="name" value="<?php echo $name ?>" class="form-control" required />
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Address: *</strong></td>
                                    <td>
                                        <input type="text" name="address" value="<?php echo $address ?>" class="form-control" required />
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Latitude: </strong></td>
                                    <td>
                                        <input type="text" name="latitude" value="<?php echo $latitude ?>" class="form-control"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Longitude: </strong></td>
                                    <td>
                                        <input type="text" name="longitude" value="<?php echo $longitude ?>" class="form-control"/>
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
                            </table>
                            <p>* required</p>
                            <input type="button" name="cancle" value="Cancle" onClick="location.href = 'index.php'" class="btn btn-warning pull-right"/>

                            <?php
                            if (isset($_GET['id'])) {
                                echo '<input type="submit" name="update" value="Update" class="btn btn-success pull-right  left-margin" />';
                            } else {
                                echo '<input type="submit" name="submit" value="Add" class="btn btn-success pull-right  left-margin" />';
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>