<?php 
require_once('../config.php');
require_once('../includes/header.php');

$user_id = $_SESSION['user']['id'];

if(isset($_POST['add_new_form'])){
    $product_id = $_POST['product_id'];
    $menufacture_id = $_POST['menufacture_id'];
    $group_name = $_POST['group_name'];
    $per_item_price = $_POST['price'];
    $per_item_m_price = $_POST['menu_price'];
    $quantity = $_POST['quantity'];
    $expire = $_POST['expire'];

    $groupCount = getColumnCount('purchases','group_name',$group_name);

    
    if(empty($group_name)){
        $error = "Group Name is Required!";
    }
    elseif($groupCount != 0){
        $error = "Group Name Already Exists!";
    }
    elseif(empty($per_item_price)){
        $error = "Price is Required!";
    }
    elseif(empty($per_item_m_price)){
        $error = "Menufacture Price is Required!";
    }
    elseif(empty($quantity)){
        $error = "Quantity is Required!";
    }
    elseif(empty($expire)){
        $error = "Expire Date is Required!";
    }
    else{
        $now = date('Y-m-d H:i:s');
        $total_price = $per_item_price*$quantity;
        $total_m_price = $per_item_m_price*$quantity;
        // Create Group 
        $stm = $connection->prepare("INSERT INTO groups(user_id,group_name,product_id,quantity,expire_date,per_item_price,per_item_m_price,total_price,total_m_price,create_at) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $stm->execute(array($user_id,$group_name,$product_id,$quantity,$expire,$per_item_price,$per_item_m_price,$total_price,$total_m_price,$now));

        // Create Purchase 
        $stm = $connection->prepare("INSERT INTO purchases(user_id,menufacture_id,product_id,group_name,quantity,per_item_price,per_item_m_price,total_price,total_m_price,create_at) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $stm->execute(array($user_id,$menufacture_id,$product_id,$group_name,$quantity,$per_item_price,$per_item_m_price,$total_price,$total_m_price,$now));

        // upfate product stock
        $stm2 = $connection->prepare("UPDATE products SET stock=stock+? WHERE id=? AND user_id=?");
        $stm2->execute(array($quantity,$product_id,$user_id));

        $success = "Create Successfully!";
    }

}
function purchase_value($bip){
    if(isset($_POST[$bip])){
        echo $_POST[$bip];
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
                                    <label for="product_id">Select Product</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <?php 
                                            $products = getTableCount('products');
                                            foreach($products as $product) :
                                         ?>
                                        <option value="<?php echo $product['id'] ?>"><?php echo $product['product_name'] ?></option>
                                        <?php  endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="menufacture_id">Select Menufacture</label>
                                    <select name="menufacture_id" id="menufacture_id" class="form-control">
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
                                    <input type="text" name="group_name" value="<?php purchase_value('group_name'); ?>" id="group_name" class="form-control" placeholder="Group Name">
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" value="<?php purchase_value('price'); ?>" id="price" class="form-control" placeholder="Price">
                                </div>
                                <div class="form-group">
                                    <label for="menu_price">Menufacture Price</label>
                                    <input type="text" name="menu_price" value="<?php purchase_value('menu_price'); ?>" id="menu_price" class="form-control" placeholder="Menufacture Price">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="text" name="quantity" value="<?php purchase_value('quantity'); ?>" id="quantity" class="form-control" placeholder="Quantity">
                                </div>

                                <div class="form-group">
                                    <label for="expire">Expire Date</label>
                                    <input type="date" name="expire" id="expire" value="<?php purchase_value('expire'); ?>" class="form-control" placeholder="Expire Date">
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