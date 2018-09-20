<?php
//main Index Attendance
require '../../core/init.php';

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
$page_title = "Single Client Records";
require_once(FOLDER_Template . 'header.php');

$cid = $_GET['cid'];


$table_Name = 'clients c';
$fields = 'c.*';
$join = NULL;
$where = "c.cid=".$cid."";
$orderBy = NULL;

$stmts = $dbCRUD->selectAll($table_Name, $fields, $join, $where, $orderBy, NULL);
$num = $stmts->rowCount();


while ($row = $stmts->fetch(PDO::FETCH_ASSOC)){
extract($row);
$cid = $cid;
$name = $name;
$address= $address;
$phoneNo = $phoneNo;
$fax = $fax;
$email = $email;
   
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
                        <td  class='col-md-3'>ID  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $cid ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Name  :-</td>
                        <td><?php echo $name ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $address ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Fax &nbsp;:-</td>
                        <td><?php echo $fax ?></td>
                    </tr>
                    
                    <tr>
                        <td  class='col-md-3'>Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-</td>
                        <td><?php echo $email ?></td>
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

