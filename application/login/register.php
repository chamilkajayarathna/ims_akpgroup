<?php
//Login index
require ('../../core/init.php');
$page_title = "Register New User";

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $user = $users->userdata($_SESSION['id']);
    $username = $user['username'];
    $logAuth = $user['userLevel'];
    if ($logAuth != 1) {
        header('Location:' . $global->wwwroot . 'application/login/deny.php');
    }
} else {
    if ($users->firstTimeUserAdd() === TRUE) {
        
    } else {
        if (empty($_SESSION['id'])) {
            header('Location:' . $global->wwwroot . 'application/login/login.php');
        }
    }
}


if (isset($_POST['submit'])) {
    if (empty($_POST['username'])& empty($_POST['password'])&empty($_POST['Userlevel'])) {
        $errors[] = 'All Fields are Required.';
    } else if (empty($_POST['username'])) {
        $errors[] = 'Enter the Username.';
    } else if (empty($_POST['password'])) {
        $errors[] = 'Enter the Password.';
    } elseif (empty($_POST['Userlevel'])) {
        $errors[] = 'Select the Authorization Level.';
    } else {
        if ($users->user_exists($_POST['username']) === true) {
            $errors[] = 'Username already exists. Please select another.';
        }
        if (!ctype_alnum($_POST['username'])) {
            $errors[] = 'Please enter a username with only alphabets and numbers';
        }
        if (strlen($_POST['password']) < 6) {
            $errors[] = 'Your password must be at least 6 characters';
        } else if (strlen($_POST['password']) > 18) {
            $errors[] = 'Your password cannot be more than 18 characters long';
        }
    }
    if (empty($errors) === true) {
        $username = htmlentities($_POST['username']);
        $password = $_POST['password'];
        $Userlevel = htmlentities($_POST['Userlevel']);

        $users->register($username, $password, $Userlevel);
        echo "<SCRIPT LANGUAGE='JavaScript'> 
			alert('Thank you for registering..')
                        window.location.href='" . WWWROOT . "application/login/register.php';
		</script>";
        //header('Location: register.php?success');
        exit();
    }
}
//Load page Headder
require_once(FOLDER_Template . 'header.php');
?>
<div class="row">
    <div class="main-login col-sm-5">
        <div class="box-login panel panel-default panel-body">
            <h3>Register New User</h3>
            <p>
                Please enter your Username and Password.
            </p>
            <form  class="form-login" id="registerform" method="post" action="">
                <?php
                if (empty($errors) === false) {
                    echo '<div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-remove"></i>&nbsp;&nbsp;&nbsp;' . implode('</p><p>', $errors) . '</div>';
                }
                if (empty($success) === false) {
                    echo '<div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-remove"></i>&nbsp;&nbsp;&nbsp;' . implode('</p><p>', $errors) . '</div>';
                }
                ?>
                <fieldset>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-user input-group-btn"></i> </span>
                        <input type="text" class="form-control" name="username" placeholder="username">
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock input-group-btn"></i> </span>
                        <input type="password" class="form-control password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-user input-group-btn"></i> </span>
                        <select name="Userlevel" class="form-control">
                            <option value="">Select User Level</option>
                            <option value="1">Administrator</option>
                            <option value="2">User</option>
                        </select>

                    </div>
                    <div class="form-actions">
                        <label for="remember" class="checkbox-inline">
                            <input type="checkbox" class="grey remember" id="remember" name="remember">
                            Keep me signed in
                        </label>
                        <input type="hidden" name="_task" id="_task" value="login">
                        <a href="<?php echo $global->wwwroot ?>index.php" class="btn btn-default pull-right">Cancle
                            <i class="fa fa-times"></i>
                        </a>
                        <button type="submit" class="btn btn-primary pull-right  left-margin" name="submit">
                            Add User <i class="fa fa-save"></i>
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
