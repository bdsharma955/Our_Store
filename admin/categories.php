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
                        <div class="table-responsive">
                            <table class="table header-border">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category Name</th>
                                        <th>categoty Slug</th>
                                        <th>Date</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $categories = getAdminData('categories');
                                    $a=1;
                                    foreach ($categories as $category) :

                                        $userData = getProfile($category['user_id']);
                                    ?>
                                    <tr>
                                        <td><?php echo $a;$a++; ?></td>
                                        <td><?php echo $category['category_name']; ?></td>
                                        <td><?php echo $category['category_slug']; ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($category['create_at'])); ?></td>
                                        <td><a href="user-profile.php?id=<?php echo $category['user_id']; ?>"><?php echo $userData['name']; ?></a></td>
                                        
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