<?php
//main Index Attendance
require '../../core/init.php';

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
$page_title = "Project Records";
require_once(FOLDER_Template . 'header.php');

$id = $_GET['id'];

$table_Name = 'project p, client c';
$fields = 'p.ID,p.CONTRACT_NO,p.NAME,c.NAME AS CLIENT_ID,p.PROGRESS,p.COMMENCEMENT_DATE,p.COMPLETION_DATE,p.EXTENDED_DATE,p.CONTRACT_PERIOD,p.CONTRACT_SUM,p.EXTENDED_CONTRACT_SUM';
$join = NULL;
$where = "p.CLIENT_ID = c.ID and p.ID=".$id."";
$orderBy = NULL;

$stmts = $dbCRUD->selectAll($table_Name, $fields, $join, $where, $orderBy, NULL);
$num = $stmts->rowCount();


while ($row = $stmts->fetch(PDO::FETCH_ASSOC)){
extract($row);
$contractNo = $CONTRACT_NO;
$projectName = $NAME;
$client= $CLIENT_ID;
$progress = $PROGRESS;
$commencementDate = $COMMENCEMENT_DATE;
$completionDate = $COMPLETION_DATE;
$extendedDate = $EXTENDED_DATE;
$contractPeriod = $CONTRACT_PERIOD;
$contractSum= $CONTRACT_SUM;
$extendedContractSum = $EXTENDED_CONTRACT_SUM;
  
}

?>

<link href="../../js/search/select2.css" rel="stylesheet" />
<script src="../../js/search/select2.js"></script>

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class='table-responsive col-lg-4'>
                <table id="dataTable1" class='table table-striped table-hover table-responsive table-bordered'>
                    <tr>
                        <td  class='col-md-3'>Contract No</td>
                        <td><?php echo $contractNo ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Project Name</td>
                        <td><?php echo $projectName  ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Client</td>
                        <td><?php echo $client ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Progress</td>
                        <td><?php echo $progress ?></td>
                    </tr>
                    
                    <tr>
                        <td  class='col-md-3'>Commencement Date</td>
                        <td><?php echo $commencementDate ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Completion Date</td>
                        <td><?php echo $completionDate ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Extended Date</td>
                        <td><?php echo $extendedDate  ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Contract Period</td>
                        <td><?php echo $contractPeriod  ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Contract Sum</td>
                        <td><?php echo $contractSum ?></td>
                    </tr>
                    <tr>
                        <td  class='col-md-3'>Extended Contract Sum</td>
                        <td><?php echo $extendedContractSum ?></td>
                    </tr>
                </table>

            </div>
            <div class='table-responsive col-lg-8'>
                <div class="row">
                    <div id='button' class='right-button-margin'>
                        <a id="listSites" href='site/index.php?pid=<?php echo $id;?>' class='btn btn-default pull-right left-margin btn-site'>List Sites</a>
                        <a id="addSite" href='site/add.php?pid=<?php echo $id;?>' class='btn btn-default pull-right left-margin btn-site'>Add Site</a>
                    </div> 
                </div>
                <div id="site-content">
<!--                    site content loads here from ajax-->
                </div>
            </div>
        </div>
        <div class="row">
            
            
            <?php 
                require_once (FOLDER_Template . 'footer.php');
            ?>
            
<script type="text/javascript">
    $(document).ready(function(){
        //alert('loaded');
        $.ajax({
            url: "site/index.php?pid=<?php echo $id;?>"
        }).done(function(data) { 
            $('#site-content').html(data); // display data
        });
        
        jQuery('.btn-site').bind('click',function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href')
            }).done(function(data) { 
                $('#site-content').html(data); // display data
            });     
        });
        
        
    });
    
    
    
//    var till = 2014;
//    var year = new Date().getFullYear();
//    var options = "";
//    for (var y = year; y >= till; y--) {
//        options += "<option>" + y + "</option>";
//    }
//    document.getElementById("year").innerHTML = options;
    

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

