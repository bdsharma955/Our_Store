<?php 
require_once('../config.php');
require_once('../includes/header.php');

$profile = getProfile($_SESSION['user']['id']);

if(isset($_POST['change_pass_form'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    $db_password = $profile['password'];
    $current_password_hash = SHA1($current_password);

    if(empty($current_password)){
        $error = "Current Password is Required!";
    }
    elseif(empty($new_password)){
        $error = "New Password is Required!";
    }
    elseif(empty($confirm_new_password)){
        $error = "Current New Password is Required!";
    }
    elseif($new_password != $confirm_new_password){
        $error = "New Password and Current New Password Dons't Match!";
    }
    elseif($db_password != $current_password_hash){
        $error = "Current Password is Wrong!";
    }
    else{
        $new_password_hash = SHA1($confirm_new_password);
        $stm = $connection->prepare("UPDATE users SET password=? WHERE id=?");
        $stm->execute(array($new_password_hash,$_SESSION['user']['id']));

        $success = "Password Change Successfully!";
    }

}

?>

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="change-password.php">Change Password</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Change Password</h3>
                        <hr>
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
                        <div class="basic-form">
                            <form method="POST" action="">
                                <div class="form-group">
                                    <input type="password" name="current_password" class="form-control" placeholder="Current Password">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="new_password" class="form-control" placeholder="New Password">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_new_password" class="form-control" placeholder="Confirm New Password">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="change_pass_form" class="btn btn-success" value="Change Password">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
            
        </div>
    </div>
    <!-- #/ container -->

<?php require_once('../includes/footer.php') ?>