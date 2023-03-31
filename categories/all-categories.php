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
                                        <th>Category Name</th>
                                        <th>categoty Slug</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $categories = getTableCount('categories');
                                    $a=1;
                                    foreach ($categories as $category) :
                                    ?>
                                    <tr>
                                        <td><?php echo $a;$a++; ?></td>
                                        <td><?php echo $category['category_name']; ?></td>
                                        <td><?php echo $category['category_slug']; ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($category['create_at'])); ?></td>
                                        <td>
                                            <a href="edit.php?id=<?php echo $category['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                            &nbsp;&nbsp;
                                            <a onclick="return confirm('Are You Sure?');" href="categories-delete.php?id=<?php echo $category['id']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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