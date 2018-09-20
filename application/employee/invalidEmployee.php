<?php
//employee index
require ('../../core/init.php');
$page_title = "Invalid Employee Details";

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

$table_Name = 'employee';
$fields = 'epf_no,count(epf_no)';
$groupby = 'epf_no';
$having = 'count(epf_no)>1';

$stmts = $dbCRUD->selectHaving($table_Name, $fields, $groupby, $having);
$num = $stmts->rowCount();
//echo $num;
//echo $stmts;
//$epfNo="";

while ($row = $stmts->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $epfNo = $epf_no; 
}
?>

<?php
echo "Duplicate EPF NO's : EPF NO ";
echo $epfNo;

$table_Name2 = 'employee e';
$fields2 = 'e.*';
$join = NULL;
$where = "e.epf_no=$epfNo";
$orderBy = NULL;

$stmts2 = $dbCRUD->selectAll($table_Name2, $fields2, $join, $where, $orderBy, NULL);
$num2 = $stmts2->rowCount();
$currentPage = basename(($_SERVER['PHP_SELF']));
// display the products if there are any
if ($num2 > 0) {
    echo "<div class='table-responsive'>";
    echo "<table id='dataTable' class='table table-striped table-hover table-responsive table-bordered'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>No</th>";
    echo "<th>Name</th>";
    echo "<th>Designation</th>";
    echo "<th>EPF No</th>";
     echo "<th>Appoinment Date</th>";
    echo "<th>NIC</th>";
    echo "<th>Date of Birth</th>";
    echo "<th>Address</th>";
    echo "<th>Contact</th>";
    echo "<th>Action</th>";
    echo "</tr>";
    echo "</thead>";

    while ($row2 = $stmts2->fetch(PDO::FETCH_ASSOC)) {
        extract($row2);
        echo "<tr>";
        echo "<td>{$serial_no}</th>";
        echo "<td class='col-md-4'>{$name}</td>";
        echo "<td>{$designation}</td>";
        echo "<td>{$epf_no}</td>";
        echo "<td class='col-md-1'>{$appoinment_date}</td>";
        echo "<td>{$nic}</td>";
        echo "<td>{$dob}</td>";
        echo "<td class='col-md-4'>{$address}</td>";
        echo "<td>{$contact}</td>";
        echo "<td class='col-md-2'>";
        echo "<a href='updateEmployee.php?id={$serial_no}' class='btn btn-xs btn-primary left-margin'>Edit</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
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

