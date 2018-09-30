<?php
//employee index
require ('../../core/init.php');
$page_title = "Employee Details";

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

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 10;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

//$table_Name = 'employee e, designation d, machinesite m';
//$fiels = 'e.*, d.designation, m.siteN';
//$join = NULL;
//$where = 'e.designation = d.number AND e.workSite = m.siteNo';
//$order = 'e.serial_no ASC';
$table_Name = 'employee e, designation d';
$fiels = 'e.SERIAL_NO,e.NAME_WITH_INITIALS,e.EPF_NO,e.APPOINTMENT_DATE,e.NIC,e.DATE_OF_BIRTH,e.ADDRESS,e.PHONE,d.NAME DESIGNATION';
$join = NULL;
$where = 'e.DESIGNATION_ID=d.ID AND e.STATUS=1';
$order = 'e.SERIAL_NO ASC';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $where, $order, "$from_record_num,$records_per_page");

if (isset($_POST['csv'])) {
    $result = $dbCRUD->selectAll($table_Name, $fiels, $join, $where, $order, NULL);
    // Pick a filename and destination directory for the file
    // Remember that the folder where you want to write the file has to be writable
    $filename = "C:Employee_" . date('Y-m-d') . ".csv";
    // Actually create the file
    // The w+ parameter will wipe out and overwrite any existing file with the same name
    $handle = fopen($filename, 'w+');
    // Write the spreadsheet column titles / labels
    fputcsv($handle, array('Serial No', 'Designation', 'Name', 'Epf No', 'Appoinment Date', 'NIC', 
        'DOB', 'Address', 'Contact', 'Location', 'Basic Salary', 'Work Target', 'Special Intencive', 
        'Difficult', 'Other'));
    // Write all the user records to the spreadsheet
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($handle, array($row['serial_no'], $row['designation'], $row['name'], $row['epf_no'], 
            $row['appoinment_date'], $row['nic'], $row['dob'], $row['address'], $row['contact'], 
            $row['siteN'], $row['basicSalary'], $row['workTarget'], $row['spIntencive'], $row['difficult'], 
            $row['other']));
    }
    echo "<div class='alert alert-success' role='alert'>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\"aria-hidden=\"true\">&times;</button>";
    echo "<strong>Success!</strong> You successfully Downloaded the Employee Details.";
    echo "</div>";
    // Finish writing the file
    fclose($handle);
    $row= NULL;
}

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
        <a href='addEmployee.php' class='btn btn-default pull-right left-margin'>Add New Employee</a>
        <a href='editEmployee.php' class='btn btn-default pull-right left-margin'>Edit Employee</a>
        <a href='category.php' class='btn btn-default pull-right left-margin'>Category Details</a>
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
                        EPF number<input type="text" class="form-control" id="keyword" placeholder="Enter EPF Number">
                    </div>
                    <div class="form-group col-lg-3">
                        Employee Name<input type="text" class="form-control" id="name" placeholder="Enter Employee Name">
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
    echo "<table id='dataTable' class='table table-striped table-hover table-responsive table-bordered'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Designation</th>";
    echo "<th>EPF No</th>";
     echo "<th>Appoinment Date</th>";
    echo "<th>NIC</th>";
    echo "<th>Date of Birth</th>";
    echo "<th>Address</th>";
    echo "<th>Contact</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    echo "</thead>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td class='col-md-4'>{$NAME_WITH_INITIALS}</td>";
        echo "<td>{$DESIGNATION}</td>";
        echo "<td>{$EPF_NO}</td>";
        echo "<td class='col-md-1'>{$APPOINTMENT_DATE}</td>";
        echo "<td>{$NIC}</td>";
        echo "<td>{$DATE_OF_BIRTH}</td>";
        echo "<td class='col-md-4'>{$ADDRESS}</td>";
        echo "<td>{$PHONE}</td>";
        echo "<td class='col-md-2'>";
        echo "<a href='updateEmployee.php?id={$SERIAL_NO}' class='btn btn-xs btn-primary left-margin'>Edit</a>";
        echo "<a resign-id='{$SERIAL_NO}' class='btn btn-xs btn-warning resign-object'>Resign</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    // paging buttons
    $_SESSION['pageName'] = $currentPage;
    $_SESSION['tableName'] = 'employee';
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

