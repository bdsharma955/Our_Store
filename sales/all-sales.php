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
                        <h4 class="card-title">All Purchase</h4>
                        <?php if(isset($_REQUEST['success'])) : ?>
                        <div class="alert alert-success">
                        <?php echo $_REQUEST['success']; ?>
                        </div>    
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <thead>
                                    <tr>

                                        <th>Product Name</th>
                                        <th>Menufacture</th>
                                        <th>Group</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $purchases = getTableCount('purchases');
                                    $a=1;
                                    foreach ($purchases as $purchase) :
                                    ?>
                                    <tr>
                                        <td><?php echo getProductName('product_name',$purchase['product_id']); ?></td>
                                        <td><?php echo getMenufactureName('name',$purchase['menufacture_id']); ?></td>
                                        <td><?php echo $purchase['group_name']; ?></td>
                                        <td><?php echo $purchase['quantity']; ?></td>
                                        <td><?php echo $purchase['total_price']; ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($purchase['create_at'])); ?></td>
                                        <td>
                                            <a href="view.php?id=<?php echo $purchase['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                            &nbsp;&nbsp;
                                            <a href="edit.php?id=<?php echo $purchase['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                            &nbsp;&nbsp;
                                            <a onclick="return confirm('Are You Sure?');" href="purchases-delete.php?id=<?php echo $purchase['id']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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