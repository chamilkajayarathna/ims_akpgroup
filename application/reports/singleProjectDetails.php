<?php
//main Index Attendance
require '../../core/init.php';

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
$page_title = "Single Project Records";
require_once(FOLDER_Template . 'header.php');

$contractNo = $_GET['contractNo'];


$table_Name = 'project p';
$fields = 'p.*';
$join = NULL;
$where = "p.contractNo=".$contractNo."";
$orderBy = NULL;

$stmts = $dbCRUD->selectAll($table_Name, $fields, $join, $where, $orderBy, NULL);
$num = $stmts->rowCount();


while ($row = $stmts->fetch(PDO::FETCH_ASSOC)){
extract($row);
$contractNo = $contractNo;
$projectName = $projectName;
$client= $client;
$progress = $progress;
$commencementDate = $commencementDate;
$completionDate = $completionDate;
$extendedDate = $extendedDate;
$contractPeriod = $contractPeriod;
$contractSum= $contractSum;
$extendedContractSum = $extendedContractSum;
  
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
                        <td  class='col-md-3'>Contract No  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $contractNo ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Project Name  :-</td>
                        <td><?php echo $projectName  ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Client &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $client ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Progress &nbsp;:-</td>
                        <td><?php echo $progress ?></td>
                    </tr>
                    
                    <tr>
                        <td  class='col-md-3'>Commencement Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $commencementDate ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Completion Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $completionDate ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Extended Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $extendedDate  ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Contract Period &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $contractPeriod  ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Contract Sum &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $contractSum ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Extended Contract Sum &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $extendedContractSum ?></td>
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

