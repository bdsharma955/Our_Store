
<?php 
require_once('../config.php');
require_once("../includes/header.php");

$id = $_SESSION['user']['id'];


if(isset($_POST['update_profile_form'])){

    $name = $_POST['name'];
    $username = $_POST['username'];
    $business_name = $_POST['business_name'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $photo = $_FILES['photo']['name'];
    $date_of_birth = $_POST['date_of_birth'];

    $target_directory = '../uploads/profile/';
    $target_file = $target_directory . basename($_FILES["photo"]["name"]);
    $photoExtension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $usernameCount = InputCount('username',$username);

    $stm = $connection->prepare("SELECT username FROM users WHERE username=? AND id=?");
    $stm->execute(array($username,$id));
    $ownUserCount = $stm->rowCount();

    if(empty($name)){
        $error = "Name is Required!";
    }
    elseif(empty($username)){
        $error = "Username is Required!";
    }
    elseif($usernameCount != 0 AND $ownUserCount != 1){
        $error = "Username Already Used!";
    }
    
    elseif(empty($business_name)){
        $error = "Business_name is Required!";
    }
    elseif(empty($address)){
        $error = "Address is Required!";
    }
    elseif(empty($gender)){
        $error = "Gender is Required!";
    }
    elseif(empty($date_of_birth)){
        $error = "Date is Required!";
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

        $create_at = date('Y-m-d H:i:s');
        $username = strtolower($username);

        $stm = $connection->prepare("UPDATE users SET name=?,username=?,business_name=?,address=?,gender=?,photo=?,date_of_birth=?,create_at=? WHERE id=?");
        $stm->execute(array($name,$username,$business_name,$address,$gender,$new_photo,$date_of_birth,$create_at,$id));

        $success = "Profile Update Successfully!";
        
    }

}


?>

    <!--*******************
        Preloader start
    ********************-->
    <!-- <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div> -->
    <!--*******************
        Preloader end
    ********************-->
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
                                        $stm = $connection->prepare("SELECT * FROM users WHERE id=?");
                                        $stm->execute(array($id));
                                        $result = $stm->fetch(PDO::FETCH_ASSOC);
                                        
                                    ?>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" value="<?php echo $result['name']; ?>" class="form-control" >
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" value="<?php echo $result['username']; ?>" class="form-control"  placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <label for="business_name">Business Name</label>
                                        <input type="text" name="business_name" value="<?php echo $result['business_name']; ?>" class="form-control"  placeholder="Business Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" placeholder="Address"  class="form-control"><?php  echo $result['address'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="file" name="photo" id="photo" value="<?php echo $result['photo']; ?>" class="form-control"  placeholder="Business Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <br>
                                        <label><input type="radio" name="gender" value="Male" checked> Male</label>
                                        <label style="margin-left: 25px;"><input type="radio" name="gender" value="Female"> Female</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" name="date_of_birth" id="date" value="<?php echo $result['date_of_birth']; ?>" class="form-control"  placeholder="Date of Birth">
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="date_of_birth">Date</label>
                                        <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo $result['date_of_birth']; ?>" class="form-control"  placeholder="Date of Birth">
                                    </div> -->
                                    <button type="submit" name="update_profile_form" class="btn login-form__btn submit w-100">Update</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php require_once('../includes/footer.php') ?>





