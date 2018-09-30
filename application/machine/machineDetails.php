<?php
//employee index
require ('../../core/init.php');
$page_title = "Machine Details";

$user = $users->userdata($_SESSION['id']);
$username = $user['USERNAME'];
$logAuth = $user['USER_LEVEL'];


if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
//Load page Headder
require_once(FOLDER_Template . 'header.php');
$site1 = $dbCRUD->ddlDataLoad('SELECT * FROM machinesite');

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

//machine details
$table_Name = 'machine m, machinebrand b, machinesite s, machineName n';
$fiels = 'm.*, b.*, s.*, n.*';
$join = NULL;
$whereCond = 'm.brand = b.brandNo AND m.siteName = s.siteNo AND n.nameIdMachine = m.nameId AND id=' . $id;
$order = 'm.id ASC';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $whereCond, $order, NULL);
$num = $stmt->rowCount();

//service details
$table_Name1 = 'machineservice';
$fiels1 = '*';
$join1 = NULL;
$whereCond1 = 'machineID =' . $id;
$order1 = NULL;

$getCurrentSite = $dbCRUD->selectAll('machine', 'siteName', NULL, 'id=' . $id . ' ', NULL, NULL);
$site2 = $dbCRUD->ddlDataLoad('SELECT * FROM machineservice WHERE machineID =' . $id);
$stmt1 = $dbCRUD->selectAll($table_Name1, $fiels1, $join1, $whereCond1, $order1, NULL);
$num1 = $stmt1->rowCount();

//Success message
if (isset($_SESSION['update'])) {
    flash('success', '<strong>Success!</strong> Machine Details successfully Updated.');
    unset($_SESSION['update']);
    echo "<div class=\"alert alert-success alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
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

$currentPage = basename(($_SERVER['PHP_SELF']));

$dbFilters = NULL;
$CSVdbFilters = NULL;
$filterType = NULL;
$filterName = NULL;
foreach ($site2 as $dbFilterDetils) {
    $serialized_data = base64_decode($dbFilterDetils['filters']);
    $var1 = unserialize(unserialize($serialized_data));
    foreach ($var1 as $key => $value) {
        $dbFilters .= "<strong>" . $key . "</strong>- " . $value . " ";
        $CSVdbFilters .= $key . " " . $value . " ";
    }
}
//Download CSV file
//machine details
$table_Name2 = 'machine m, machinebrand b, machinesite s, machineName n, machineservice ms';
$fiels2 = 'm.*, b.*, s.*, n.*,ms.*';
$join2 = NULL;
$whereCond2 = 'm.brand = b.brandNo AND m.siteName = s.siteNo AND n.nameIdMachine = m.nameId AND ms.machineID=m.id AND ms.machineID=' . $id;
$order2 = 'm.id ASC';
if (isset($_POST['csv'])) {
    $result = $dbCRUD->selectAll($table_Name2, $fiels2, $join2, $whereCond2, $order2, NULL);
    // Pick a filename and destination directory for the file
    // Remember that the folder where you want to write the file has to be writable
    $filename = "C:Machine_Service_Details_" . date('Y-m-d') . ".csv";
    // Actually create the file
    // The w+ parameter will wipe out and overwrite any existing file with the same name
    $handle = fopen($filename, 'w+');
    // Write the spreadsheet column titles / labels
    fputcsv($handle, array('Serial No', 'Machine Name', 'Location', 'Last Service', 'Next Service', 'Mechanic', 'Operator', 
        'Date', 'Filters', 'Remarks'));
    // Write all the user records to the spreadsheet
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($handle, array($row['id'], $row['machineName'], $row['siteN'], $row['lastService'], $row['nextService'], 
            $row['mechanic'], $row['operator'], $row['date'], $CSVdbFilters, $row['srvdetails'] ));
    }
    echo "<div class='alert alert-success' role='alert'>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
    echo "<strong>Success!</strong> You successfully Downloaded the Machine Service Details.";
    echo "</div>";
    // Finish writing the file
    fclose($handle);
    $row= NULL;
}
?>
<div id="message"> <?php flash('success'); ?></div>
<div class="row">
    <div id='button' class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-right'>Back</a>
        <a href='addEditMachine.php' class='btn btn-default pull-right left-margin'>Add New Machine</a>
        <a href='addServiceDetails.php' class='btn btn-default pull-right left-margin'>Add Service Details</a>
        <?php 
        if ($logAuth == 1) { ?>
        <form action="" method="post">
        
        </form>
        <?php  } ?>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class=" col-sm-offset-9">Site Name
                    <form action="" method="post">
                        <?php
                        //current db site name
                        $db_site = NULL;
                        while ($dbSiteName = $getCurrentSite->fetch(PDO::FETCH_ASSOC)) {
                            $db_site = $dbSiteName['siteName'];
                        }
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
                        if ($logAuth == 1) {
                            echo '<button type="submit" name="addNew" class="btn btn-sm btn-success">Change Location</button>';
                        }
                        ?>

                    </form>

                </div> 

                <?php
// display the products if there are any
                if ($num > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table  table-striped table-hover table-responsive table-bordered'>";
                    echo "<thead>";
                    echo "<tr>";
                    ;
                    echo "<th>ID</th>";
                    echo "<th>Machine No</th>";
                    echo "<th>Name</th>";
                    echo "<th>Brand</th>";
                    echo "<th>Model No</th>";
                    echo "<th>Engine Model</th>";
                    echo "<th>Engine Serial</th>";
                    echo "<th>Chassi</th>";
                    echo "<th>Year</th>";
                    echo "<th>Details</th>";
                    echo "<th>Horsepower</th>";
                    if ($logAuth == 1) {
                        echo "<th>Action</th>";
                    }
                    echo "</tr>";
                    echo "</thead>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$machineCategory}</td>";
                        echo "<td>{$machineNo}</td>";
                        echo "<td>{$brandName}</td>";
                        echo "<td>{$model}</td>";
                        echo "<td>{$engineModel}</td>";
                        echo "<td>{$engineSerial}</td>";
                        echo "<td>{$chassiSerial}</td>";
                        echo "<td>{$year}</td>";
                        echo "<td>{$details}</td>";
                        echo "<td>{$hp}</td>";
                        if ($logAuth == 1) {
                            echo "<td>";
                            echo "<a delete-id='{$id}' class='btn btn-sm btn-danger delete-object pull-right'>Delete</a>";
                            echo "<a href='addEditMachine.php?id={$id}' class='btn btn-sm btn-warning pull-right left-margin '>Edit</a>";
                            echo "</td>";
                        }

                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
// tell the user there are no products
                else {
                    echo "<div>No products found.</div>";
                }
                ?>
            </div>
        </div>
    </div><!-- /.col-sm-4 -->

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Machine Service Details</h3>
            </div>
            <div class="panel-body">
                <?php
                if ($num > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table  table-striped table-hover table-responsive table-bordered'>";
                    echo "<thead>";
                    echo "<tr>
                    <th>Last Service</th>
                    <th>Next Service</th>
                    <th>Mechanic</th>
                    <th>Operator</th>
                    <th>Date</th>
                    <th>Filters</th>
                    <th>Details</th>";
                    if ($logAuth == 1) {
                        echo "<th>Action</th>";
                    }
                    echo "</tr></thead>";
                    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                        extract($row1);

                        echo "<tr>";
                        echo "<td>{$lastService}</td>";
                        echo "<td>{$nextService}</td>";
                        echo "<td>{$mechanic}</td>";
                        echo "<td>{$operator}</td>";
                        echo "<td>{$date}</td>";
                        echo "<td>$dbFilters</td>";
                        echo "<td>{$srvdetails}</td>";
                        if ($logAuth == 1) {
                            echo "<td class='col-sm-1'>";
                            echo "<a delete-id='{$id}' class='btn btn-xs btn-danger del-service-object pull-right'>Delete</a>";
                            echo "</td>";
                        }

                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
                // tell the user there are no products
                else {
                    echo "<div>No products found.</div>";
                }
                ?>
            </div>
        </div>
    </div><!-- /.col-sm-4 -->
</div>
<?php
if (isset($_POST['addNew'])) {
    $id = $_GET['id'];

    $site = htmlentities($_POST['site'], ENT_QUOTES);
    $data = array('siteName' => $site);

    $table_Name_update = 'machine';

    if ($dbCRUD->updateData($table_Name_update, $data, 'id=' . $id . ' ')) {
        $_SESSION['update'] = $id;
        header('Location:machineDetails.php?id=' . $id . ' ');
    } else {
        $_SESSION['faild'] = $id;
        header('Location:machineDetails.php?id=' . $id . ' ');
    }
}
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
<script>
    $(document).on('click', '.delete-object', function () {
        var id = $(this).attr('delete-id');
        var q = confirm("Are you sure Delete Machine From database ?");
        if (q === true) {
            $.post('delete.php', {
                delete_id: id
            }, function (data) {
                location.reload();
            }).fail(function () {
                alert('Something went wrong. Try Again !.');
            });
        }
        return false;
    });

    $(document).on('click', '.del-service-object', function () {
        var id = $(this).attr('delete-id');
        var q = confirm("Are you sure Delete Machine From database ?");
        if (q === true) {
            alert(id);
            $.post('delete.php', {
                del_ser_id: id
            }, function (data) {
                location.reload();
            }).fail(function () {
                alert('Something went wrong. Try Again !.');
            });
        }
        return false;
    });
</script>