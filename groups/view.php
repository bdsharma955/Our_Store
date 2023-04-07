<?php 
require_once('../config.php');
require_once('../includes/header.php');

// $id = $_REQUEST['id'];
// $user_id = $_SESSION['user']['id'];
// $id = $_SESSION['user']['id'];
$id=$_REQUEST['id'];

// $groupDetails = $connection->prepare("SELECT * FROM groups WHERE user_id=? AND id=?");
// $groupDetails->execute(array($user_id,$id));
// $result = $groupDetails->fetch(PDO::FETCH_ASSOC);

$groupData = getSingleCount('groups',$id);

?>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                <div class="card-body">
                        <h4 class="card-title">Group View</h4>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <tbody>
                                    <tr>
                                        <td>Group Name</td>
                                        <td><?php echo $groupData['group_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Product Name</td>
                                        <td><?php echo getProductName('product_name',$groupData['product_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Expire Date</td>
                                        <td><?php echo date('d-m-Y',strtotime($groupData['expire_date'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Quantity</td>
                                        <td><?php echo $groupData['quantity']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Per Item Price</td>
                                        <td><?php echo $groupData['per_item_price']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Per Item Menufacture Price</td>
                                        <td><?php echo $groupData['per_item_m_price']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Price</td>
                                        <td><?php echo $groupData['total_price']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Menufacture Price</td>
                                        <td><?php echo $groupData['total_m_price']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Created Date</td>
                                        <td><?php echo  date('d-m-Y H:i:s',strtotime($groupData['create_at'])); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>  
            </div>
            
        </div>
    </div>

<?php require_once('../includes/footer.php') ?>