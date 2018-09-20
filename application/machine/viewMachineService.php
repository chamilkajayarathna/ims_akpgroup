<?php
//employee index
require ('../../core/init.php');
$page_title = "Machine Service Details";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $user = $users->userdata($_SESSION['id']);
    $username = $user['username'];
    $logAuth = $user['userLevel'];
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

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 10;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;


    $table_Name = 'machine m, machineservice s';
    $fiels = 'm.machineNo, m.machineName, s.lastService, s.nextService, s.mechanic';
    $join = NULL;
    $whereCond = 'm.id=s.machineID';
    $order = NULL;

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $whereCond, $order, "$from_record_num,$records_per_page");


if (isset($_SESSION['insert']) && !empty($_SESSION['insert'])) {
    flash('success', '<strong>Success!</strong> Project Details successfully Saved.');
    unset($_SESSION['insert']);
    echo "<div class=\"alert alert-success alert-dismissable\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
    echo flash('success');
    echo "</div>";
}
?>
<div class="row">
    <div id='button' class='right-button-margin'>
        <a href='editEmployee.php' class='btn btn-default pull-left left-margin'>Refresh</a>
        <a href='machineDetails.php' class='btn btn-default pull-right left-margin'>Machine Details</a>
        <a href='addServiceDetails.php' class='btn btn-default pull-right left-margin'>Back</a>
       
        <form action="" method="post">
       
        </form>
    </div>
    <div class="col-lg-12">
        <form role="form" method="post">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Search</h3>
                </div>
                <div class="panel-body">
                    
                    <div class="form-group col-lg-3">
                        Machine ID<input type="text" class="form-control" id="name" placeholder="Enter Machine Name">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php


//$table_Name = 'employee';
//$fiels = 'employee.serial_no,employee.name,employee.epf_no,employee.appoinment_date,employee.nic,employee.dob,employee.address,employee.contact,designation.designation';
//$join = 'designation ON employee.designation = number';

//$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, NULL, 'serial_no ASC', "$from_record_num,$records_per_page");
$num = $stmt->rowCount();
$currentPage = basename(($_SERVER['PHP_SELF']));
// display the products if there are any
if ($num > 0) {
    echo "<div class='table-responsive'>";
                        echo "<table class='table  table-striped table-hover table-responsive table-bordered'>";
                        echo "<thead>";
                        echo "<tr>";
                        
                        echo "<th>Machine No</th>";                        
                        echo "<th>Last Service</th>";
                        echo "<th>Next Service</th>";
                        echo "<th>Mechanic</th>";
                       
                        echo "</tr>";
                        echo "</thead>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
                            
                            echo "<td>{$machineNo}</td>";                         
                            echo "<td>{$lastService}</td>";
                            echo "<td>{$nextService}</td>";
                            echo "<td>{$mechanic}</td>";
                            
                            echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    // paging buttons
    $_SESSION['pageName'] = $currentPage;
    $_SESSION['tableName'] = 'machineservice';
    require_once (FOLDER_Template.'paging_employee.php');
}
// tell the user there are no products
else {
    echo "<div>No Employee Record found.</div>";
}
?>

<script>
    $(document).on('click', '.resign-object', function () {
        var id = $(this).attr('resign-id');
        var q = confirm("Conform the Resignation?");
        if (q === true) {
            $.post('delEmployee.php', {
                resign_id: id
            }, function (data) {
                alert(data);
                location.reload();
            }).fail(function () {
                alert('Something went wrong. Try Again !.');
            });
        }
        return false;
    });
</script>

<?php

//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>
<script>
$(document).ready(function () {
    $('#keyword').on('input', function () {
        var searchKeyword = $(this).val();
        $('#name').val('');

        //table information
        $table_Name = 'employee';
        $fields = 'employee.serial_no,employee.name,employee.epf_no,employee.appoinment_date,employee.nic,employee.dob,employee.address,employee.contact,designation.designation';
        $join = 'designation ON employee.designation = number';
        $where = "epf_no LIKE '%" + searchKeyword + "%'";
        $orderBy = 'serial_no ASC';

        $dataString = {keywords: searchKeyword, table_Name: $table_Name, fields: $fields, join: $join, where: $where, orderBy: $orderBy};
        if (searchKeyword.length >= 1) {
            $.ajax({
                url: '../assets/search.php',
                type: 'post',
                data: $dataString,
                dataType: "json",
                cache: false,
                async: false,
                success: function (data) {
                    $('table#dataTable  tbody').empty()
                    //$('table#dataTable  tbody').append(data.name);
                    $.each(data, function () {
                        content = '<tr><td>' + this.name + '</td>';
                        content += '<td>' + this.designation + '</td>';
                        content += '<td>' + this.epf_no + '</td>';
                        content += '<td>' + this.appoinment_date + '</td>';
                        content += '<td>' + this.nic + '</td>';
                        content += '<td>' + this.dob + '</td>';
                        content += '<td>' + this.address + '</td>';
                        content += '<td>' + this.contact + '</td>';
                        content += '<td>' + "<a href='updateEmployee.php?id="+this.serial_no+" ' class='btn btn-xs btn-primary left-margin'>Edit</a>\n\
                    <a resign-id="+this.serial_no+" class='btn btn-xs btn-warning resign-object'>Resign</a>" +'</td></tr>';
                        $('table#dataTable  tbody').append(content);
                    });
                }
            });
        }
    });

    $('#name').on('input', function () {
        var searchKeyword = $(this).val();
        $('#keyword').val('');
        //table information
        $table_Name = 'employee';
        $fields = 'employee.serial_no,employee.name,employee.epf_no,employee.appoinment_date,employee.nic,employee.dob,employee.address,employee.contact,designation.designation';
        $join = 'designation ON employee.designation = number';
        $where = "name LIKE '%" + searchKeyword + "%'";
        $orderBy = 'serial_no ASC';

        $dataString = {keywords: searchKeyword, table_Name: $table_Name, fields: $fields, join: $join, where: $where, orderBy: $orderBy};
        if (searchKeyword.length >= 1) {
            $.ajax({
                url: '../assets/search.php',
                type: 'post',
                data: $dataString,
                dataType: "json",
                cache: false,
                async: false,
                success: function (data) {
                    $('table#dataTable  tbody').empty()
                    //$('table#dataTable  tbody').append(data.name);
                    $.each(data, function () {
                        content = '<tr><td>' + this.name + '</td>';
                        content += '<td>' + this.designation + '</td>';
                        content += '<td>' + this.epf_no + '</td>';
                        content += '<td>' + this.appoinment_date + '</td>';
                        content += '<td>' + this.nic + '</td>';
                        content += '<td>' + this.dob + '</td>';
                        content += '<td>' + this.address + '</td>';
                        content += '<td>' + this.contact + '</td>';
                        content += '<td>' + "<a href='updateEmployee.php?id="+this.serial_no+" ' class='btn btn-xs btn-primary left-margin'>Edit</a>\n\
                    <a resign-id="+this.serial_no+" class='btn btn-xs btn-warning resign-object'>Resign</a>" +'</td></tr>';
                        $('table#dataTable  tbody').append(content);
                    });
                }
            });

        }
    });
});
</script>

