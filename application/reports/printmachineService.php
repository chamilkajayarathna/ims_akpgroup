<?php
//employee index
require ('../../core/init.php');
$page_title = "Machine Details";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
//Load page Headder
require_once(FOLDER_Template . 'header.php');

$num = 0;
$num1 = 0;


    $txtID = $_GET['id'];
  
    
    
    $id = filter_input(INPUT_POST, 'ddlEmp1');
    $table_Name = 'machine m, machinebrand b, machinesite s, machineName n';
    $fiels = 'm.*, b.*, s.*, n.*';
    $join = NULL;
    $whereCond = 'm.brand = b.brandNo AND m.siteName = s.siteNo AND n.nameIdMachine = m.nameId AND id=' . $id;
    $order = 'm.id ASC';

    $stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $whereCond, $order, NULL);
    $num = $stmt->rowCount();

    $table_Name1 = 'machineservice';
    $fiels1 = '*';
    $join1 = NULL;
    $whereCond1 = 'machineID =' . $id;
    $order1 = NULL;

    $site2 = $dbCRUD->ddlDataLoad('SELECT * FROM machineservice WHERE machineID =' . $id);
    $stmt1 = $dbCRUD->selectAll($table_Name1, $fiels1, $join1, $whereCond1, $order1, NULL);
    $num1 = $stmt1->rowCount();

    $currentPage = basename(($_SERVER['PHP_SELF']));

    $dbFilters = NULL;
    $filterType = NULL;
    $filterName = NULL;
    foreach ($site2 as $dbFilterDetils) {
        $serialized_data = base64_decode($dbFilterDetils['filters']);
        $var1 = unserialize(unserialize($serialized_data));
        foreach ($var1 as $key => $value) {
            $dbFilters .= "<strong>" . $key . "</strong>- " . $value . " ";
        }
    }

?>
<link href="../../js/search/select2.css" rel="stylesheet"/>
<script src="../../js/search/select2.js"></script>
<script>
    $(document).ready(function () {
        $("#ddlEmp").select2({
            placeholder: "Select a State",
            allowClear: true
        });
        $("#ddlEmp1").select2({
            placeholder: "Select a State",
            allowClear: true
        });
    });
</script>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Search</h3>
            </div>
            <div class="panel-body">
                <form role="form" method="post">
                    <div class="navbar-form pull-left">
                        <select name="ddlEmp1" id="ddlEmp1" >
                            <option selected>Select</option>
                            <?php
                            $mchine = $dbCRUD->ddlDataLoad('SELECT id,machineName FROM machine');
                            foreach ($mchine as $ddlData) {
                                echo '<option value="' . $ddlData['id'] . '">' . $ddlData['machineName'] . '</option>';
                            }
                            ?>
                        </select>
                        <input type="submit" name="submit" id="attendanceEPFNO" class="btn btn-success" value="Search"/>
                    </div> 
                </form>
            </div>
        </div>
        <div id="message"> <?php flash('success'); ?></div>
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Machine Details</h3>
                </div>
                <div class="panel-body">

                    <?php
// display the products if there are any
                    if ($num > 0) {
                        echo "<div class='table-responsive'>";
                        echo "<table class='table  table-striped table-hover table-responsive table-bordered'>";
                        echo "<thead>";
                        echo "<tr>";
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
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "</div>";
                    }
// tell the user there are no products
                    else {
                        echo "<div>No Machine found.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Machine Service Details</h3>
                </div>
                <div class="panel-body">
                    <?php
                    if ($num1 > 0) {
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
                    <th>Details</th>         
                </tr></thead>";
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
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "</div>";
                    }
// tell the user there are no products
                    else {
                        echo "<div>SORRY! No Service Record found.</div>";
                    }
                    ?>
                </div>
            </div>

        </div>
        
        
        <input type="button" value="Print" onclick="window.print()">
        
        
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
                    alert(id);
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