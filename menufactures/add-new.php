<?php 
require_once('../config.php');
require_once('../includes/header.php');

$user_id = $_SESSION['user']['id'];

if(isset($_POST['add_new_form'])){
    $menu_name = $_POST['menu_name'];
    $address = $_POST['address'];
    $mobile_number = $_POST['mobile_number'];

    $mobileCount = getColumnCount('menufactures','mobile_number',$mobile_number);

    if(empty($menu_name)){
        $error = "Name is Required!";
    }
    elseif(empty($address)){
        $error = "Address is Required!";
    }
    elseif(empty($mobile_number)){
        $error = "Mobile number is Required!";
    }
    elseif(!is_numeric($mobile_number)){
        $error = "Mobile number must be number!";
    }
    elseif(strlen($mobile_number) != 11){
        $error = "Mobile number must be 11 Digit!";
    }
    elseif($mobileCount != 0){
        $error = "Mobile number Already Exits!";
    }
    else{
        $now = date('Y-m-d H:i:s');
        $stm = $connection->prepare("INSERT INTO menufactures(user_id,name,address,mobile_number,create_at) VALUES(?,?,?,?,?)");
        $stm->execute(array($user_id,$menu_name,$address,$mobile_number,$now));

        $success = "Create Successfully!";
    }

}

function menu_value($bip){
    if(isset($_POST[$bip])){
        echo $_POST[$bip];
    }
}


?>

    
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Create Menufacture</h3>
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
                                    <label for="menu_name">Name</label>
                                    <input type="text" name="menu_name" value="<?php menu_value('menu_name'); ?>" id="menu_name" class="form-control" placeholder="Menufacture Name">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" value="<?php menu_value('address'); ?>" id="address" class="form-control" placeholder="Address">
                                </div>
                                <div class="form-group">
                                    <label for="mobile_number">Mobile Number</label>
                                    <input type="text" name="mobile_number" value="<?php menu_value('mobile_number'); ?>" id="mobile_number" class="form-control" placeholder="Address">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="add_new_form" class="btn btn-success" value="Create">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    

<?php require_once('../includes/footer.php') ?>