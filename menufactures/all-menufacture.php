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
                        <h4 class="card-title">All Menufacture</h4>
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
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Mobile</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $menufactures = getTableCount('menufactures');
                                    $a=1;
                                    foreach ($menufactures as $menu) :
                                    ?>
                                    <tr>
                                        <td><?php echo $a;$a++; ?></td>
                                        <td><?php echo $menu['name']; ?></td>
                                        <td><?php echo $menu['address']; ?></td>
                                        <td><?php echo $menu['mobile_number']; ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($menu['create_at'])); ?></td>
                                        <td>
                                            <a href="edit.php?id=<?php echo $menu['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                            &nbsp;&nbsp;
                                            <a onclick="return confirm('Are You Sure?');" href="menufacture-delete.php?id=<?php echo $menu['id']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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