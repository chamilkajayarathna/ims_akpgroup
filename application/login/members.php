<?php
//Login index
require ('../../core/init.php');
$page_title = "Users";

//Load page Headder
require_once(FOLDER_Template . 'header.php');
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
$members = $users->get_users();
$member_count = count($members);
?>	
<div id="container" class="col-lg-offset-1">
     <div id='button' class='right-button-margin'>
        <a href='index.php' class='btn btn-default pull-left left-margin'>Refresh</a>
        <a href='register.php' class='btn btn-default pull-left left-margin'>Add New User</a>
    </div>
    <span class="pull-right"><h4>Welcome Administrator</h4></span>
    <h1>Our members</h1>
    <p>We have a total of <strong><?php echo $member_count; ?></strong> registered users. </p>

    <?php
    echo "<div class='table-responsive col-sm-3 pull-left'>";
    echo "<table id='dataTable' class='table table-striped table-hover table-responsive table-bordered pull-left'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Username</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    echo "</thead>";

    foreach ($members as $member) {
        echo "<tr>";
        echo "<td>" . $member['username'] . "</td>";
        echo "<td class='col-sm-2'><a delete-id='" . $member['id'] . "' class='btn btn-xs btn-danger delete-object'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</div>
<script>
    $(document).on('click', '.delete-object', function () {
        var id = $(this).attr('delete-id');
        var q = confirm("Are you sure?");

        if (q == true) {
            $.post('../employee/delEmployee.php', {
                user_id_del: id
            }, function (data) {
                alert(data);
                location.reload();
                
            }).fail(function () {
                alert('Unable to delete Employee.');
            });
        }
        return false;
    });
</script>
