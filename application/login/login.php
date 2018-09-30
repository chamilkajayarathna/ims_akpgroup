<?php
//Login index
require ('../../core/init.php');
$page_title = "Login";

$general->logged_in_protect();

if (empty($_POST) === false) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    echo $username;
    if (empty($username) === true || empty($password) === true) {
        $errors[] = 'Sorry, We need your username and password.';
    } else if ($users->user_exists($username) === false) {
        $errors[] = 'Sorry that username doesn\'t exists.';
    }
    else {
        if (strlen($password) > 18) {
            $errors[] = 'The password should be less than 18 characters, without spacing.';
        }
        $login = $users->login($username, $password);
        if ($login === false) {
            $errors[] = 'Sorry, The password you entered is invalid!';
        } else {
            $_SESSION['id'] = $login;
            header('Location: ' . $global->wwwroot . 'application/reports/index.php');
            exit();
        }
    }
}

//Load page Headder
require_once(FOLDER_Template . 'header.php');
?>
<div class="main-login col-sm-5">
    <div class="box-login panel panel-default panel-body">
        <div class="logo">
        <?php
        $stmt1 = $dbCRUD->selectAll('user', 'ID', NULL, NULL, NULL, NULL);
        $num1 = $stmt1->rowCount();
        if ($num1 > 0) {
            
        } else {
            echo "<input type='button' class='btn btn-success' value='Add New User' name='button' onClick=location.href='" . WWWROOT . "application/login/register.php'>";
        }
        ?>
    </div>
        <h3>Sign in to your account</h3>
        <p>
            Please enter your Username and Password to log in.
        </p>
        <form  class="form-login" id="loginform" method="post" action="">
            <?php
            if (empty($errors) === false) {
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
                <div class="form-actions">
                    <label for="remember" class="checkbox-inline">
                        <input type="checkbox" class="grey remember" id="remember" name="remember">
                        Keep me signed in
                    </label>
                    <input type="hidden" name="_task" id="_task" value="login">
                    <a href="<?php echo $global->wwwroot ?>index.php" class="btn btn-default pull-right">Cancle
                        <i class="fa fa-times"></i>
                    </a>
                    <button type="submit" class="btn btn-primary pull-right  left-margin">
                        Login <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </fieldset>
        </form>
    </div>

</div>
<?php
//Load page Footer
require_once (FOLDER_Template . 'footer.php');
?>