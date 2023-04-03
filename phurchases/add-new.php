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

?>

    
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Create Phurchase</h3>
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
                                    <label for="menu_name">Select Product</label>
                                    <select name="product_category" id="product_category" class="form-control">
                                        <?php 
                                            $products = getTableCount('products');
                                            foreach($products as $product) :
                                         ?>
                                        <option value="<?php echo $product['id'] ?>"><?php echo $product['product_name'] ?></option>
                                        <?php  endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="menu_name">Select Menufacture</label>
                                    <select name="product_category" id="product_category" class="form-control">
                                        <?php 
                                            $menufactures = getTableCount('menufactures');
                                            foreach($menufactures as $menufacture) :
                                         ?>
                                        <option value="<?php echo $menufacture['id'] ?>"><?php echo $menufacture['name']." - ".$menufacture['mobile_number']; ?></option>
                                        <?php  endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="group_name">Group Name</label>
                                    <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Group Name">
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                </div>
                                <div class="form-group">
                                    <label for="menu_price">Menufacture Price</label>
                                    <input type="text" name="menu_price" id="menu_price" class="form-control" placeholder="Menufacture Price">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Quantity">
                                </div>
                                <div class="form-group">
                                    <label for="total_price">Total Price</label>
                                    <input type="text" name="total_price" id="total_price" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="total_menu_price">Total Menufacture Price</label>
                                    <input type="text" name="total_menu_price" id="total_menu_price" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="expire">Expire Date</label>
                                    <input type="date" name="expire" id="expire" class="form-control" placeholder="Expire Date">
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