<?php 
require_once('../config.php');
require_once('header.php');


?>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-body">
                        <h4 class="card-title">All Categories</h4>
                        <?php if(isset($_REQUEST['success'])) : ?>
                        <div class="alert alert-success">
                        <?php echo $_REQUEST['success']; ?>
                        </div>    
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>categoty</th>
                                        <th>Photo</th>
                                        <th>Date</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $products = getAdminData('products');
                                    $a=1;
                                    foreach ($products as $product) :
                                        $userData = getProfile($product['user_id']);
                                    ?> 
                                    <tr>
                                        <td><?php echo $a;$a++; ?></td>
                                        <td><a href="product-view.php?id=<?php echo $product['id']; ?>"><?php echo $product['product_name']; ?></a></td>
                                        <td><?php echo getProductdata('category_name',$product['category_id']); ?></td>
                                        <td><img height="50px";width="70px" src="../uploads/products/<?php echo $product['photo']; ?>" alt=""></td>
                                        <td><?php echo date('d-m-Y',strtotime($product['create_at'])); ?></td>
                                        <td><a href="profile-user.php?id=<?php echo $product['user_id']; ?>"><?php echo $userData['name']; ?></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>  
            </div>
            
        </div>
    </div>

<?php require_once('footer.php') ?>