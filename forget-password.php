<?php 
require_once('config.php');
session_start();

if(isset($_POST['forget_form'])){
    $email = $_POST['email'];

    if(empty($email)){
        $error = "Email is Required!";
    }
    else{
        $userCount = $connection->prepare("SELECT id,email FROM users WHERE email=?");
        $userCount->execute(array($email));
        $userEmailcount = $userCount->rowCount();

        if($userEmailcount == 1){
            $userData = $userCount->fetch(PDO::FETCH_ASSOC);
           
            $email_code = SHA1($email.time());
            $stm = $connection->prepare("UPDATE users SET forget_token=? WHERE email=?");
            $stm->execute(array($email_code,$userData['email']));
            
            $message = "<h1>Forget Password Email</h1>";
            $message .= '<a href="'.GET_APP_URL().'/forget-password.php?email='.$userData['email'].'&token='.$email_code.'">Click to reset Password</a>';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            mail($userData['email'],"Forget Password",$message,$headers);
            
            $success = "Email send successfully! , please check your Inbox.";
        
        }
        else{
            $error = "Email is not fund!";
        }
    }
}

// set password
if(isset($_POST['set_password_form'])){
    $email = $_REQUEST['email'];
    $token = $_REQUEST['token'];

    $new_password = $_POST['password'];
    $comfirm_password = $_POST['comfirm_password'];

    if(empty($new_password)){
        $error = "New Password is Required!";
    }
    elseif(empty($comfirm_password)){
        $error = "New Password is Required!";
    }
    elseif($new_password =! $comfirm_password){
        $error = "New Password & Confirm Password Doesn't Match!";
    }
    
    else{
        $userCount = $connection->prepare("SELECT id,email,forget_token FROM users WHERE email=? AND forget_token=?");
        $userCount->execute(array($email,$token));
        $userEmailcount = $userCount->rowCount();

        if($userEmailcount == 1){
            $userData = $userCount->fetch(PDO::FETCH_ASSOC);
           
            $password = SHA1($comfirm_password);
            $stm = $connection->prepare("UPDATE users SET forget_token=?,password=? WHERE email=?");
            $stm->execute(array(NULL,$password,$userData['email']));
            
            $message = "Forget Password Email";
            $message .= "Your Password Reset Successfully!";
            mail($userData['email'],"Forget Password",$message);

            $success = "Password Reset successfully! , please try to login.";
        
        }
        else{
            $error = "Invalid Email!";
        }
    }
}

?>


<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Our Store - Forget Password</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        .login-input .form-group .form-control{
            background: #0000000d;
            padding-left: 12px;
        }
    </style>
</head>

<body class="h-100">
    
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">

                            <?php if(isset($_REQUEST['token'])): ?>
                            <div class="card-body pt-5">
                                <a class="text-center" href="forget-password.php"> <h2>Set New Password</h2></a>
                                    <?php if(isset($error)) : ?>
                                    <div class="alert alert-danger">
                                    <?php echo $error; ?>
                                    </div>    
                                    <?php endif; ?>
                                    <?php if(isset($success)) : ?>
                                    <div class="alert alert-success">
                                    <?php echo $success; ?>
                                    </div>    
                                    <?php endif; ?>
                                <form action="" method="POST" class="mt-5 mb-5 login-input">
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="New Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="comfirm_password" class="form-control" placeholder="Confirm New Password">
                                    </div>
                                    <button type="submit" name="set_password_form" class="btn login-form__btn submit w-100">New Password</button>
                                </form>
                                <p class="login-form__footer"><a href="login.php" class="text-primary">Login</a> </p>
                            </div>

                            <?php else: ?>
                                <div class="card-body pt-5">
                                <a class="text-center" href="forget-password.php"> <h2>Forget Password</h2></a>
                                    <?php if(isset($error)) : ?>
                                    <div class="alert alert-danger">
                                    <?php echo $error; ?>
                                    </div>    
                                    <?php endif; ?>
                                    <?php if(isset($success)) : ?>
                                    <div class="alert alert-success">
                                    <?php echo $success; ?>
                                    </div>    
                                    <?php endif; ?>
                                <form action="" method="POST" class="mt-5 mb-5 login-input">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Email Number">
                                    </div>
                                    <button type="submit" name="forget_form" class="btn login-form__btn submit w-100">Forget Password</button>
                                </form>
                                <p class="login-form__footer"><a href="login.php" class="text-primary">Login</a> </p>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>
</html>





