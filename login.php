<?php 
require_once('config.php');
session_start();

if(isset($_POST['login_form'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username)){
        $error = "Username is Required!";
    }
    elseif(empty($password )){
        $error = "Password  is Required!";
    }

    else{
        $password = SHA1($password);
        $loginCount = $connection->prepare("SELECT id,email,mobile,username,password,email_status,mobile_status FROM users WHERE username=? AND password=?");
        $loginCount->execute(array($username,$password));
        $userlogincount = $loginCount->rowCount();

        if($userlogincount == 1){
            $userData = $loginCount->fetch(PDO::FETCH_ASSOC);

            if($userData['email_status'] == 1 AND $userData['mobile_status'] == 1){
                $_SESSION['user'] = $userData;
                header('location:index.php');
            }
            else{
                $_SESSION['user_email'] = $userData['email'];
                $_SESSION['user_mobile'] = $userData['mobile'];
                
                $email_code = rand(111111,999999);
                $stm = $connection->prepare("UPDATE users SET email_code=? WHERE email=?");
                $stm->execute(array($email_code,$userData['email']));
                
                $message = "Your Verification Code is: ".$email_code;
                mail($userData['email'],"Email Verification",$message);

                
                header('location:verification.php');
            }
        }
        else{
            $error = "Username or Password is Wrong!";
        }
    }
}

if(isset($_SESSION['user'])){
    header('location:dashboard/index.php');
}

?>


<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Our Store - Login</title>
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
                            <div class="card-body pt-5">
                                <a class="text-center" href="index.php"> <h2>Login</h2></a>
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
                                        <input type="text" name="username" class="form-control" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                    <button type="submit" name="login_form" class="btn login-form__btn submit w-100">Login</button>
                                </form>
                                <p class="mt-5 login-form__footer">Dont have account? <a href="registration.php" class="text-primary">registration</a> now</p>
                            </div>
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




