<?php 
require_once('../config.php');
require_once('../includes/header.php');

$id = $_REQUEST['id'];

$user_id = $_SESSION['user']['id'];

if(isset($_POST['update_form'])){
    $menu_name = $_POST['menu_name'];
    $address = $_POST['address'];
    $mobile_number = $_POST['mobile_number'];


    if(empty($menu_name)){
        $error = "Name is Required!";
    }
    elseif(empty($address)){
        $error = "Address is Required!";
    }
    elseif(empty($mobile_number)){
        $error = "Mobile Number is Required!";
    }
    else{
        $now = date('Y-m-d H:i:s');
        $stm = $connection->prepare("UPDATE menufactures SET name=?,address=?,mobile_number=?,create_at=? WHERE id=?");
        $stm->execute(array($menu_name,$address,$mobile_number,$now,$id));

        $success = "Update Successfully!";
    }

}

?>

    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Create Category</h3>
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
                            <form method="POST" action="" enctype="multipart/form-data">
                                <?php 
                                    $cate_data = getSingleCount('menufactures',$id);
                                ?>
                                <div class="form-group">
                                    <label for="menu_name">Name</label>
                                    <input type="text" name="menu_name" id="menu_name" class="form-control" value="<?php echo $cate_data['name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control" value="<?php echo $cate_data['address']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="mobile_number">Mobile Number</label>
                                    <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="<?php echo $cate_data['mobile_number']; ?>">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="update_form" class="btn btn-success" value="Update">
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