<?php
//main Index Attendance
require '../../core/init.php';

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
$page_title = "Single Machine Records";
require_once(FOLDER_Template . 'header.php');

$machineID = $_GET['mid'];


$table_Name = 'Machine m';
$fields = 'm.*';
$join = NULL;
$where = "m.id=".$machineID."";
$orderBy = NULL;

$stmts = $dbCRUD->selectAll($table_Name, $fields, $join, $where, $orderBy, NULL);
$num = $stmts->rowCount();


while ($row = $stmts->fetch(PDO::FETCH_ASSOC)){
extract($row);
$machine_id = $id;
$name_id = $nameId;
$mno = $machineNo;
$mname = $machineName;
$brand = $brand;
$model = $model;
$enModel = $engineModel;
$e_serial = $engineSerial;
$chassi = $chassiSerial;
$year = $year;
$details = $details;
$hp = $hp;
$sname = $siteName;
   
}

?>

<link href="../../js/search/select2.css" rel="stylesheet" />
<script src="../../js/search/select2.js"></script>

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class='table-responsive col-lg-5'>
                <table id="dataTable1" class='table table-striped table-hover table-responsive table-bordered'>
                    <tr>
                        <td  class='col-md-3'>Machine ID  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $machine_id ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Name id :-</td>
                        <td><?php echo $name_id ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Machine No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $machineNo ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Machine Name &nbsp;:-</td>
                        <td><?php echo $machineName ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Brand &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $brand ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Model &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $model ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Engine Model &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $engineModel ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Engine Model &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $engineModel ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Engine Serial &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $engineSerial ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Chassi Serial &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $chassiSerial ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>year &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $year ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $details ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>HP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $hp ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Site Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $siteName ?></td>
                    </tr>
                </table>

            </div>
            
        </div>
        <div class="row">
            
            <input type="button" value="Print" onclick="window.print()" />
            
            
            <?php 
                require_once (FOLDER_Template . 'footer.php');
            ?>
            
<script>
    var till = 2014;
    var year = new Date().getFullYear();
    var options = "";
    for (var y = year; y >= till; y--) {
        options += "<option>" + y + "</option>";
    }
    document.getElementById("year").innerHTML = options;

//    function search() {
//        $("#empName").html("");
//        $("#desig").html("");
//        $("#epf").html("");
//        $("#contact").html("");
//
//        var empName = null;
//        var desig = null;
//        var epf = null;
//        var contact = null;
//
//        var searchKeyword = $('#ddlEmp1').val();
//        var month = $('#month').val();
//        var year = $('#year').val();
//        $('#keyword').val('');
//        //table information
//        $table_Name = 'employee e, designation d, attendance a';
//        $fields = 'a.*, e.name,e.epf_no,e.contact, d.designation';
//        $join = null;
//        $where = "a.emp_ID = e.serial_no AND d.number = e.designation AND e.epf_no=" + searchKeyword + " AND MONTH(date) =" + month + " AND YEAR(date) =" + year;
//        $orderBy = 'a.id ASC';
//
//        $dataString = {keywords: searchKeyword, table_Name: $table_Name, fields: $fields, join: $join, where: $where, orderBy: $orderBy};
//        if (searchKeyword.length >= 1) {
//            $.ajax({
//                url: '../assets/search.php',
//                type: 'post',
//                data: $dataString,
//                dataType: "json",
//                cache: false,
//                async: false,
//                success: function (data) {
//                    if (!$.isArray(data) || !data.length) {
//                        $('table#dataTable  tbody').empty()
//                        content = '<tr><td>SORRY! No Record Found.</td></tr>';
//                        $('table#dataTable  tbody').append(content);
//                        return;
//                    }
//                    else {
//                        $('table#dataTable  tbody').empty()
//                        $.each(data, function () {
//                            empName = this.name;
//                            desig = this.designation;
//                            epf = this.epf_no;
//                            contact = this.contact;
//                            content = '<tr><td style="display:none;">' + this.emp_ID + '</td>';
//                            content += '<td>' + this.inTime + '</td>';
//                            content += '<td>' + this.outTime + '</td>';
//                            content += '<td>' + this.date + '</td>';
//                            $('table#dataTable  tbody').append(content);
//                        });
//                        $('#empName').append(empName);
//                        $('#desig').append(desig);
//                        $('#epf').append(epf);
//                        $('#contact').append(contact);
//                    }
//
//                }
//            });
//
//        }
//    }
</script>

