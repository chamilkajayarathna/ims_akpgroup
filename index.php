<?php
//main Index
require 'core/init.php';


$page_title = "Panditharatne Constructions";
require_once(FOLDER_Template . 'header.php');
//'SELECT e.name,m.date,m.in,m.out, d.designation 
//FROM attendance m JOIN employee e ON e.serial_no=m.emp_ID JOIN designation d ON 
//d.number = e.designation WHERE date = '".$curntDate."' "
?>

<div class="row">
    <div class="col-lg-12">

        <div id="inputbox" class="col-lg-3" >
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span><i class="fa fa-check fa-2x"></i></span>
                    Attendance  
                </div>
                <div class="panel-body">
                    Please Enter the Employee ID - 
                    <input type="text" id="name_stop" name="name_stop" autofocus="autofocus" class="form-control" />
                    <?php
//                    date_default_timezone_set('Asia/Kolkata');
//                    echo "<h4>" . date("l Y/m/d") . "</h4><h3>" . date("h:i A") . "</h3>";
                    ?>
                    <div id="timestamp"></div>
                </div>
            </div>

        </div>
        <div class="col-lg-9">

            <div class="display" ></div>
        </div>
    </div>
</div>
</div>
<div class="row">
    <div id="results"></div>
</div>
<script type="text/javascript" src="<?php FOLDER_JS ?>/IMS/js/jquery-latest.js"></script>
<script id="script15" type="text/javascript">
    function init() {
        key_count_global = 0; // Global variable
        document.getElementById("name_stop").onkeypress = function () {
            key_count_global++;
            setTimeout("lookup(" + key_count_global + ")", 1000);//Function will be called 1 second after user types anything. Feel free to change this value.
        }
    }
    window.onload = init; //or $(document).ready(init); - for jQuery

    function lookup(key_count) {
        if (key_count == key_count_global) { // The control will reach this point 1 second after user stops typing.
            // Do the ajax lookup here.
            //setTimeout("message()", 100);
            message();
            //document.getElementById("status_stop").innerHTML = " ... lookup result ...";
        }
    }

    function message() {
        $('.lookup').delay(5000).fadeOut('slow');
        var kw = $("#name_stop").val();
        var dataString = 'empID=' + kw;
        //alert(kw);
        $.ajax({
            type: "POST",
            url: "application/attendance/insert.php",
            data: dataString,
            cache: false,
            success: function (response) {
                $(".display").html(response);
            }
        });
        document.getElementById('name_stop').value = "";
        //setTimeout("reloadNew()", 100);
    }

    $(document).ready(function () {
        function load() {
            $.ajax({//create an ajax request to load_page.php
                type: "POST",
                url: "application/attendance/insert.php",
                dataType: "html", //expect html to be returned                
                success: function (response) {
                    $(".display").html(response);
                    setTimeout(load, 30000);
                }
            });
        }

        load(); //if you don't want the click
        //$("#display").click(load); //if you want to start the display on click
        setInterval(timestamp, 500);
    });

    function reloadNew() {
        setTimeout("location.reload(true);", 50000);
    }

//    $(function () {
//        $('.display').delay(4000).fadeOut('slow');
//    });

    function timestamp() {
        $.ajax({
            url: 'application/assets/timestamp.php',
            success: function(data) {
                $('#timestamp').html(data);
            },
        });
    }
</script>
<?php
//include "template/footer.php";
//include($_SERVER['DOCUMENT_ROOT'].'IMS/template/footer.php');
require_once(FOLDER_Template . 'footer.php');
?>
