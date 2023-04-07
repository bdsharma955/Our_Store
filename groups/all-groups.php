<?php 
require_once('../config.php');
require_once('../includes/header.php');

?>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-body">
                        <h4 class="card-title">All Groups</h4>
                        <?php if(isset($_REQUEST['success'])) : ?>
                        <div class="alert alert-success">
                        <?php echo $_REQUEST['success']; ?>
                        </div>    
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <thead>
                                    <tr>
                                        <th>Group Name</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Expire</th>
                                        <th>Total Price</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $purchases = getTableCount('groups');
                                    $a=1;
                                    foreach ($purchases as $purchase) :
                                    ?>
                                    <tr>
                                        <td><?php echo $purchase['group_name']; ?></td>
                                        <td><?php echo getProductName('product_name',$purchase['product_id']); ?></td>
                                        <td><?php echo $purchase['expire_date']; ?></td>
                                        <td><?php echo $purchase['quantity']; ?></td>
                                        <td><?php echo $purchase['total_price']; ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($purchase['create_at'])); ?></td>
                                        <td>
                                            <a href="view.php?id=<?php echo $purchase['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                            
                                        </td>
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

<?php require_once('../includes/footer.php') ?>