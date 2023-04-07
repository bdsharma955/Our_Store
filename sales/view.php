<?php 
require_once('../config.php');
require_once('../includes/header.php');
$id = $_REQUEST['id'];
$user_id = $_SESSION['user']['id'];

$purchaseDetails = $connection->prepare("SELECT * FROM purchases WHERE user_id=? AND id=?");
$purchaseDetails->execute(array($user_id,$id));
$result = $purchaseDetails->fetch(PDO::FETCH_ASSOC);

?>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                <div class="card-body">
                        <h4 class="card-title">Purchase View</h4>
                        <div class="table-responsive">
                            <table class="table header-border">
                                <tbody>
                                    <tr>
                                        <td>Product Name</td>
                                        <td><?php echo getProductName('product_name',$result['product_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Menufacture Name</td>
                                        <td><?php echo getMenufactureName('name',$result['menufacture_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Group Name</td>
                                        <td><?php echo $result['group_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Expire Date</td>
                                        <td><?php 
                                        $expireDate = getGroupName('expire_date',$result['group_name'],$result['product_id']); 
                                        echo date('d-m-Y',strtotime($expireDate));
                                        ?></td>
                                    </tr>
                                    <tr>
                                        <td>Quantity</td>
                                        <td><?php echo $result['quantity']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Per Item Price</td>
                                        <td><?php echo $result['per_item_price']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Per Item Menufacture Price</td>
                                        <td><?php echo $result['per_item_m_price']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Price</td>
                                        <td><?php echo $result['total_price']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Menufacture Price</td>
                                        <td><?php echo $result['total_m_price']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Created Date</td>
                                        <td><?php echo date('d-m-Y H:i:s',strtotime($expireDate)); ?></td>
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