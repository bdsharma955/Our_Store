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
                        <h4 class="card-title">All Block Users</h4>
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
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $stm = $connection->prepare("SELECT * FROM users WHERE status=?");
                                    $stm->execute(array("Blocked"));
                                    $users = $stm->fetchAll(PDO::FETCH_ASSOC);

                                    // $users = getAdminData('users');
                                    $a=1;
                                    foreach ($users as $user) :
                                    ?> 
                                    <tr>
                                        <td><?php echo $a;$a++; ?></td>
                                        <td><a href="product-view.php?id=<?php echo $user['id']; ?>"><?php echo $user['name']; ?></a></td>

                                        <td><?php echo $user['mobile']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php if($user['status'] == "Active") : ?>
                                            <span class="badge badge-success">Active</span>
                                            <?php elseif($user['status'] == "Pending") : ?>
                                            <span class="badge badge-warning">Pending</span>
                                            <?php elseif($user['status'] == "Blocked") : ?>
                                            <span class="badge badge-danger">Blocked</span>
                                            <?php endif; ?></td>
                                        <td>
                                            <a href="profile-user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                            &nbsp;&nbsp;
                                            <?php if($user['status'] == "Blocked") : ?>
                                            <a onclick="return confirm('Are You Sure?');" href="unblock.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-success">Unblock</a>
                                            <?php else: ?>
                                                <a onclick="return confirm('Are You Sure?');" href="block.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger">Block</a>
                                            <?php endif; ?>
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

<?php require_once('footer.php') ?>