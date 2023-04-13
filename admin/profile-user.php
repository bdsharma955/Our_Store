<?php 
require_once('../config.php');
require_once('header.php');

$id = $_REQUEST['id'];


$userViewData = getUserView('users',$id);

?>

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="profile.php">Profile</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center mb-4">
                            <?php if($userViewData['photo'] != NULL) : ?>
                            <img class="mr-3 rounded-circle" style="object-fit:cover;" src="../uploads/profile/<?php echo $userViewData['photo']; ?>" width="80" height="80" alt="">
                            <?php else: ?>
                            <img class="mr-3" src="../images/avatar/11.png" width="80" height="80" alt="">
                            <?php endif; ?>
                            <div class="media-body">
                                <h3 class="mb-0"><?php echo $userViewData['name']; ?></h3>
                                <p class="text-muted mb-0"><?php echo $userViewData['username']; ?></p>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card card-profile text-center">
                                    <span class="mb-1 text-primary"><i class="icon-people"></i></span>
                                    <h3 class="mb-0">263</h3>
                                    <p class="text-muted px-4">Total Purchase</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card card-profile text-center">
                                    <span class="mb-1 text-warning"><i class="icon-user-follow"></i></span>
                                    <h3 class="mb-0">263</h3>
                                    <p class="text-muted">Total Sale</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <p>Profile Status:
                                    <?php if($userViewData['status'] == "Active") : ?>
                                    <span class="badge badge-success">Active</span>
                                    <?php elseif($userViewData['status'] == "Pending") : ?>
                                    <span class="badge badge-warning">Pending</span>
                                    <?php elseif($userViewData['status'] == "Blocked") : ?>
                                    <span class="badge badge-danger">Blocked</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <h4>About Me</h4>
                       
                        <ul class="card-profile__info">
                            <li class="mb-1"><strong class="text-dark mr-4">Business Name</strong> <span>
                                <?php echo $userViewData['business_name']; ?>
                            </span></li>
                            <li class="mb-1"><strong class="text-dark mr-4">Mobile</strong> <span>
                                <?php echo $userViewData['mobile']; ?>
                            </span></li>
                            <li><strong class="text-dark mr-4">Email</strong> <span>
                                <?php echo $userViewData['email']; ?>
                            </span></li>
                            <li><strong class="text-dark mr-4">Address</strong> <span>
                                <?php echo $userViewData['address']; ?>
                            </span></li>
                            <li><strong class="text-dark mr-4">Gender</strong> <span>
                                <?php echo $userViewData['gender']; ?>
                            </span></li>
                            <li><strong class="text-dark mr-4">Birthday</strong> <span>
                                <?php echo $userViewData['date_of_birth']; ?>
                            </span></li>
                        </ul>
                        <br>
                    </div>
                </div>  
            </div>
            
        </div>
    </div>
    

<?php require_once('footer.php') ?>