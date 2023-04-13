<?php 
require_once('../config.php');
require_once('../includes/header.php');

$id = $_REQUEST['id'];

$user_id = $_SESSION['user']['id'];

if(isset($_POST['add_new_form'])){
    $customer_name = $_POST['customer_name'];
    $product_id = $_POST['product_id'];
    $menufacture_id = $_POST['menufacture_id'];
    $group_name = $_POST['group_name'];
    $expire_date = $_POST['expire-date'];
    $per_item_price = $_POST['price'];
    $per_item_m_price = $_POST['menu_price'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $discount_type = $_POST['discount_type'];
    $discount_amount = $_POST['discount_amount'];
    $sub_total = $_POST['sub_total'];
    

    if(empty($group_name)){
        $error = "Customer Name is Required!";
    }
    elseif(empty($group_name)){
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
        // $total_m_price = $per_item_m_price*$quantity;
        
        // Create Sales 
        $stm = $connection->prepare("UPDATE sales SET customer_name=?,group_name=?,price=?,menu_price=?,quantity=?,expire_date=?,total_price=?,discount_type=?,discount_amount=?,sub_total=?,create_at=? WHERE user_id=? AND id=?");
        $stm->execute(array($customer_name,$group_name,$per_item_price,$per_item_m_price,$quantity,$expire_date,$total_price,$discount_type,$discount_amount,$sub_total,$now,$user_id,$id));

        $stm2 = $connection->prepare("UPDATE products SET stock=stock-? WHERE id=? AND user_id=?");
        $stm2->execute(array($quantity,$product_id,$user_id));

        // Create Purchase 
        // $stm = $connection->prepare("UPDATE purchases SET menufacture_id=?,product_id=?,group_name=?,quantity=?,per_item_price=?,per_item_m_price=?,total_price=?,total_m_price=?,create_at=? WHERE user_id=? AND id=?");
        // $stm->execute(array($menufacture_id,$product_id,$group_name,$quantity,$per_item_price,$per_item_m_price,$total_price,$total_m_price,$now,$user_id,$id));

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
                        <h3 class="card-title">Update Sales</h3>
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

                               <?php 
                                $sale_data = getSingleCount('sales',$id);
                               ?>

                                <div class="form-group">
                                    <label for="customer_name">Customer Name</label>
                                    <input type="text" name="customer_name" value="<?php echo $sale_data['customer_name'] ?>" id="customer_name" class="form-control" placeholder="Customer Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="product_id">Select Product</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="#">Select Product</option>
                                        <?php 
                                            $products = getTableCount('products');
                                            foreach($products as $product) :
                                         ?>
                                        <option value="<?php echo $product['id'] ?>"
                                        <?php if($product['id'] == $sale_data['product_id']){
                                            echo "selected";
                                        } ?>
                                        ><?php echo $product['product_name'] ?></option>
                                        <?php  endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="product_id">Select menufacture</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="#">Select Menufacture</option>
                                        <?php 
                                            $menufactures = getTableCount('menufactures');
                                            foreach($menufactures as $menufacture) :
                                         ?>
                                        <option value="<?php echo $menufacture['id'] ?>"
                                        <?php if($menufacture['id'] == $sale_data['menufacture_id']){
                                            echo "selected";
                                        } ?>
                                        ><?php echo $menufacture['name'] ?></option>
                                        <?php  endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="menufacture_name">Menufacture</label>
                                    <input type="text" name="menufacture_name" id="menufacture_name" value="<?php echo $sale_data['menufacture_id'] ?>" class="form-control" readonly>
                                    <input type="hidden" name="menufacture_id" id="menufacture_id">
                                </div>

                                <div class="form-group">
                                    <label for="group_name">Group Name</label>
                                    <select name="group_name" id="group_name" class="form-control">
                                        <option value="#">Select Group</option>
                                        <?php 
                                            $groups = getTableCount('groups');
                                            foreach($groups as $group) :
                                         ?>
                                        <option value="<?php echo $group['id'] ?>"
                                        <?php if($group['id'] == $sale_data['group_name']){
                                            echo "selected";
                                        } ?>
                                        ><?php echo $group['group_name'] ?></option>
                                        <?php  endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="expire">Expire Date</label>
                                    <input type="text" name="expire-date" id="expire" value="<?php echo $sale_data['expire_date'] ?>" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" value="<?php echo $sale_data['price'] ?>" class="form-control" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="menu_price">Menufacture Price</label>
                                    <input type="text" name="menu_price" id="menu_price" value="<?php echo $sale_data['menu_price'] ?>" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity: <span id="available_stock" class="badge badge-info"></span></label>
                                    <input type="number" name="quantity" id="quantity" value="<?php echo $sale_data['quantity'] ?>" class="form-control" placeholder="Quantity" required>
                                    <input type="hidden" name="stock" id="stock">
                                </div>
                                <div class="form-group">
                                    <label for="total_price">Total Price</label>
                                    <input type="text" name="total_price" id="total_price" value="<?php echo $sale_data['total_price'] ?>" class="form-control" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="discount_type">Discount Type</label>
                                    <select name="discount_type" id="discount_type" class="form-control" >
                                        <option value="<?php echo $sale_data['discount_type'] ?>"<?php if($sale_data['discount_type'] == "None"){
                                            echo "selected";
                                        } ?>>None</option>
                                        <option value="<?php echo $sale_data['discount_type'] ?>"<?php if($sale_data['discount_type'] == "fixed"){
                                            echo "selected";
                                        } ?>>Fixed</option>
                                        <option value="<?php echo $sale_data['discount_type'] ?>"<?php if($sale_data['discount_type'] == "percentage"){
                                            echo "selected";
                                        } ?>>Percentage</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="discount_amount">Discount Amount</label>
                                    <input type="text" name="discount_amount" id="discount_amount" value="<?php echo $sale_data['discount_amount'] ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="sub_total">Sub Total</label>
                                    <input type="text" name="sub_total" id="sub_total" value="<?php echo $sale_data['sub_total'] ?>" class="form-control" readonly required>
                                </div>


                                <div class="form-group">
                                    <input type="submit" name="add_new_form" class="btn btn-success" value="Create Sale">
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