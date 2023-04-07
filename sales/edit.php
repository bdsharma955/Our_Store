<?php 
require_once('../config.php');
require_once('../includes/header.php');

$id = $_REQUEST['id'];

$user_id = $_SESSION['user']['id'];

if(isset($_POST['add_new_form'])){
    $product_id = $_POST['product_id'];
    $menufacture_id = $_POST['menufacture_id'];
    $group_name = $_POST['group_name'];
    $per_item_price = $_POST['per_item_price'];
    $per_item_m_price = $_POST['per_item_m_price'];
    $quantity = $_POST['quantity'];
    // $expire_date = $_POST['expire'];

    if(empty($group_name)){
        $error = "Group Name is Required!";
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
    // elseif(empty($expire_date)){
    //     $error = "Expire Date is Required!";
    // }
    else{
        $now = date('Y-m-d H:i:s');
        $total_price = $per_item_price*$quantity;
        $total_m_price = $per_item_m_price*$quantity;
        
        // Create Group 
        $stm = $connection->prepare("UPDATE groups SET group_name=?,product_id=?,quantity=?,per_item_price=?,per_item_m_price=?,total_price=?,total_m_price=?,create_at=? WHERE user_id=? AND id=?");
        $stm->execute(array($group_name,$product_id,$quantity,$per_item_price,$per_item_m_price,$total_price,$total_m_price,$now,$user_id,$id));

        // Create Purchase 
        $stm = $connection->prepare("UPDATE purchases SET menufacture_id=?,product_id=?,group_name=?,quantity=?,per_item_price=?,per_item_m_price=?,total_price=?,total_m_price=?,create_at=? WHERE user_id=? AND id=?");
        $stm->execute(array($menufacture_id,$product_id,$group_name,$quantity,$per_item_price,$per_item_m_price,$total_price,$total_m_price,$now,$user_id,$id));

        $success = "Update Successfully!";
    }

}

?>

    
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Update Phurchase</h3>
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
                                    $getPurchases = getSingleCount('purchases',$id);
                                    // foreach($getPurchases as $getPurchase) :
                                 ?>
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
                                    <input type="text" name="group_name" value="<?php echo $getPurchases['group_name'] ?>" id="group_name" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="per_item_price">Price</label>
                                    <input type="text" name="per_item_price" value="<?php echo $getPurchases['per_item_price'] ?>" id="per_item_price" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="per_item_m_price">Menufacture Price</label>
                                    <input type="text" name="per_item_m_price" value="<?php echo $getPurchases['per_item_m_price'] ?>" id="per_item_m_price" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="text" name="quantity" value="<?php echo $getPurchases['quantity'] ?>" id="quantity" class="form-control">
                                </div>

                                <!-- <div class="form-group">
                                    <label for="expire_date">Expire Date</label>
                                    <input type="date" name="expire_date"<?php 
                                    // $expireDate = getGroupName('expire_date',$getPurchases['group_name'],$getPurchases['product_id']); 
                                    // echo date('d-m-Y',strtotime($expireDate));
                                    ?> id="expire_date" class="form-control">
                                </div> -->
                                <div class="form-group">
                                    <input type="submit" name="add_new_form" class="btn btn-success" value="Update">
                                </div>
                            </form>
                            <?php
                                // endforeach; 
                            ?>
                        </div>
                    </div>
                </div>  
            </div>

        </div>
    </div>
    

<?php require_once('../includes/footer.php') ?>