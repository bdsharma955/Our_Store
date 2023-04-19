<?php 
require_once('../config.php');
require_once('header.php');
$id = $_REQUEST['id'];

$productDetails = $connection->prepare("SELECT * FROM products WHERE id=?");
$productDetails->execute(array($id));
$result = $productDetails->fetch(PDO::FETCH_ASSOC);



?>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                <div class="card-body">
                        <h4 class="card-title">Product Details</h4>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <tbody>
                                    <tr>
                                        <td>User ID</td>
                                        <td><?php 
                                        echo $result['user_id'];
                                         ?></td>
                                    </tr>
                                    <tr>
                                        <td>Product Name</td>
                                        <td><?php echo $result['product_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Stock</td>
                                        <td><?php echo $result['stock']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Discription</td>
                                        <td><?php echo $result['discription']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Photo</td>
                                        <td><img width="75" height="auto" src="../uploads/products/<?php echo $result['photo']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Created Date</td>
                                        <td><?php echo date('d-m-Y H:i:s',strtotime($result['create_at'])); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>  
            </div>
            
        </div>
    </div>

<?php require_once('footer.php') ?>