<?php 
require_once('../config.php');
require_once('header.php');
$id = $_REQUEST['id'];

$userDetails = $connection->prepare("SELECT * FROM users WHERE id=?");
$userDetails->execute(array($id));
$result = $userDetails->fetch(PDO::FETCH_ASSOC);

?>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                <div class="card-body">
                        <h4 class="card-title">User Details</h4>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td><?php echo $result['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>User Name</td>
                                        <td><?php echo $result['username'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><?php echo $result['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile</td>
                                        <td><?php echo $result['mobile']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Business Name</td>
                                        <td><?php echo $result['business_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td><?php echo $result['address']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Photo</td>
                                        <td>
                                        <?php if($result['photo'] != NULL) : ?>
                                        <img class="mr-3 rounded-circle" style="object-fit:cover;" src="../uploads/profile/<?php echo $result['photo']; ?>" width="80" height="80" alt="">
                                        <?php else: ?>
                                        <img class="mr-3" src="../images/avatar/11.png" width="80" height="80" alt="">
                                        <?php endif; ?>
                                            <!-- <img width="75" height="auto" src="../uploads/products/<?php echo $result['photo']; ?>"> -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td><?php if($result['status'] == "Active") : ?>
                                        <span class="badge badge-success">Active</span>
                                        <?php elseif($result['status'] == "Pending") : ?>
                                        <span class="badge badge-warning">Pending</span>
                                        <?php elseif($result['status'] == "Blocked") : ?>
                                        <span class="badge badge-danger">Blocked</span>
                                        <?php endif; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td><?php echo $result['gender']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Brithday</td>
                                        <td><?php echo $result['date_of_birth']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Registration Date</td>
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