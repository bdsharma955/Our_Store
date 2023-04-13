
<?php 
require_once('../config.php');
require_once("header.php");

$id = $_SESSION['admins']['id'];
$user_id = $_SESSION['admins']['id'];


if(isset($_POST['update_profile_form'])){

    $userame = $_POST['userame'];
    $role = $_POST['role'];
    $photo = $_FILES['photo']['name'];

    $target_directory = '../uploads/profile/';
    $target_file = $target_directory . basename($_FILES["photo"]["name"]);
    $photoExtension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $usernameCount = adminInputCount('userame',$userame);

    $stm = $connection->prepare("SELECT * FROM admins WHERE userame=? AND id=?");
    $stm->execute(array($userame,$id));
    $ownUserCount = $stm->rowCount();

    if(empty($username)){
        $error = "Username is Required!";
    }
    elseif($usernameCount != 0 AND $ownUserCount != 1){
        $error = "Username Already Used!";
    }
    
    elseif(empty($photo)){
        $error = "Photo is Required!";
    }
    elseif($_FILES["photo"]["size"] > 5000000){
        $error = "Photo size less then 5MB!";
    }
    elseif($photoExtension != 'jpg' && $photoExtension != 'jpeg' && $photoExtension != 'png'){
        $error = "Photo is must be jpg or jpeg or png!";
    }
    else{
        // $new_photo = $id."-".rand(1111, 9999)."-".time().".".$photoExtension;
        $new_photo = $id." - ". rand(11111,99999). " - " . time() . "." .$photoExtension;

        move_uploaded_file($_FILES["photo"]["tmp_name"],$target_directory.$new_photo);

        // $create_at = date('Y-m-d H:i:s');
        // $username = strtolower($username);

        $stm = $connection->prepare("UPDATE admins SET userame=?,role=?,photo=? WHERE id=?");
        $stm->execute(array($userame,$role,$new_photo,$id));

        $success = "Profile Update Successfully!";
        
    }

}


?>

    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-8">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="index.php"> <h2>Update Profile</h2></a>
        
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

                                <form action="" method="POST" class="mt-5 mb-4 login-input" enctype="multipart/form-data">
                                    <?php
                                        $stm = $connection->prepare("SELECT * FROM admins WHERE id=?");
                                        $stm->execute(array($id));
                                        $result = $stm->fetch(PDO::FETCH_ASSOC);
                                        
                                    ?>
                                    <div class="form-group">
                                        <label for="userame">Username</label>
                                        <input type="text" name="userame" id="userame" value="<?php echo $result['userame']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <input type="text" name="role" id="role" value="<?php echo $result['role']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="file" name="photo" id="photo" value="<?php echo $result['photo']; ?>" class="form-control">
                                    </div>
                                    
                                    <button type="submit" name="update_profile_form" class="btn bg-info login-form__btn submit w-100">Update</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php require_once('footer.php') ?>





