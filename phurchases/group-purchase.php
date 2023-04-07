<?php 
require_once('../config.php');
require_once('../includes/header.php');

$user_id = $_SESSION['user']['id'];
$id =  $_SESSION['user']['id'];

?>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-body">
                        <h4 class="card-title">Group Purchase</h4>
                        <?php if(isset($_REQUEST['success'])) : ?>
                        <div class="alert alert-success">
                        <?php echo $_REQUEST['success']; ?>
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
                                                    <select class="form-select form-control" name="" id="">
                                                        <?php 
                                                            $pro_name = getTableCount('products');
                                                            foreach($pro_name as $product_name) :
                                                        ?>
                                                        <option value=""><?php echo $product_name['product_name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-grup">
                                                    <select class="form-select form-control" name="" id="">
                                                    <?php 
                                                            $pro_name = getTableCount('menufactures');
                                                            foreach($pro_name as $product_name) :
                                                        ?>
                                                        <option value=""><?php echo $product_name['name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    </select>
                                                </div>
                                            </td>
                                            <td><input type="text" placeholder="Group Name" class="form-control" name="" id=""></td>
                                            <td><input type="date" placeholder="Expire" class="form-control" name="" id=""></td>
                                            <td><input type="number" placeholder="Quantity" class="form-control" name="" id=""></td>
                                            <td><input type="number" placeholder="Item Price" class="form-control" name="" id=""></td>
                                            <td><input type="number" placeholder="Menufacture Price" class="form-control" name="" id=""></td>
                                            <td><input type="number" placeholder="Total Price" class="form-control" name="" id=""></td>
                                            <td>
                                                <a onclick="return confirm('Are You Sure?');" href="" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="10" class="text-right add"><button type="submit" class="btn btn-primary">Add New</button></td>
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