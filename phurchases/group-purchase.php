<?php 
require_once('../config.php');
require_once('../includes/header.php');

$user_id = $_SESSION['user']['id'];
$id =  $_SESSION['user']['id'];

if(isset($_POST['details_submit'])){
    $product_id = $_POST['product_id'];
    $menufacture_id = $_POST['menufacture_id'];
    $group_name = $_POST['group_name'];
    $expire_date = $_POST['expire'];
    $quantity = $_POST['quantity'];
    $per_item_price = $_POST['price'];
    $per_item_m_price = $_POST['menufacture_price'];
    $total_price = $_POST['total_price'];

    if(empty($group_name)){
        $error = "Group Name is Required!";
    }
    elseif(empty($expire_date)){
        $error = "Expire Date is Required!";
    }
    elseif(empty($quantity)){
        $error = "Quantity is Required!";
    }
    elseif(empty($per_item_price)){
        $error = "Price is Required!";
    }
    elseif(empty($per_item_m_price)){
        $error = "Menufacture Price is Required!";
    }
    // elseif(empty($total_price)){
    //     $error = "Total Price is Required!";
    // }
    else{

        $now = date('Y-m-d H:i:s');
        $total_price = $per_item_price*$quantity;
        $total_m_price = $per_item_m_price*$quantity;
        // Create Purchase 
        $stm = $connection->prepare("INSERT INTO purchases(user_id,menufacture_id,product_id,group_name,quantity,per_item_price,per_item_m_price,total_price,total_m_price,create_at) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $stm->execute(array($user_id,$menufacture_id,$product_id,$group_name,$quantity,$per_item_price,$per_item_m_price,$total_price,$total_m_price,$now));

        $success = "Purchase Update";


    }

}

?>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-body">
                        <h4 class="card-title">Group Purchase</h4>
                        <?php if(isset($error)) : ?>
                        <div class="alert alert-danger">
                        <?php echo $error; ?>
                        </div>    
                        <?php endif; ?>
                        <?php if(isset($success)) : ?>
                        <div class="alert alert-success">
                        <?php echo $success; ?>
                        
                        <?php //if(isset($_REQUEST['success'])) : ?>
                        <!-- <div class="alert alert-success"> -->
                        <?php //echo $_REQUEST['success']; ?>
                        </div>    
                        <?php endif; ?>
                        <form action="" method="POST">
                            <div class="table-responsive">
                                <table class="table header-border" id="append">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Menufacture</th>
                                            <th>Group</th>
                                            <th>Expire</th>
                                            <th>Quantity</th>
                                            <th>Item Price</th>
                                            <th>Menufacture Price</th>
                                            <th>Total Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-grup">
                                                    <select class="form-select form-control" name="product_id" id="">
                                                        <?php 
                                                            $pro_name = getTableCount('products');
                                                            foreach($pro_name as $product_name) :
                                                        ?>
                                                        <option value="<?php echo $product_name['id']; ?>"><?php echo $product_name['product_name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-grup">
                                                    <select class="form-select form-control" name="menufacture_id" id="">
                                                    <?php 
                                                            $menu_name = getTableCount('menufactures');
                                                            foreach($menu_name as $menufac_name) :
                                                        ?>
                                                        <option value="<?php echo $menufac_name['id']; ?>"><?php echo $menufac_name['name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    </select>
                                                </div>
                                            </td>
                                            <td><input type="text" placeholder="Group Name" class="form-control" name="group_name" id="group_name"></td>
                                            <td><input type="date" placeholder="Expire" class="form-control" name="expire" id="expire"></td>
                                            <td><input type="number" placeholder="Quantity" class="form-control" name="quantity" id="quantity"></td>
                                            <td><input type="number" placeholder="Item Price" class="form-control" name="price" id="price"></td>
                                            <td><input type="number" placeholder="Menufacture Price" class="form-control" name="menufacture_price" id="menufacture_price"></td>
                                            <td><input type="number" placeholder="Total Price" class="form-control" name="total_price" id="total_price"></td>
                                            <td>
                                                <a onclick="return confirm('Are You Sure?');" href="" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="10" class="text-right add"><button type="submit" name="add_new_btn" class="btn btn-primary">Add New</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="submit" name="details_submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
            
        </div>
    </div>

<?php require_once('../includes/footer.php') ?>