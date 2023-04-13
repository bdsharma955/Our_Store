<?php 
require_once('../config.php');
require_once('../includes/header.php');
$id = $_REQUEST['id'];
$user_id = $_SESSION['user']['id'];

$purchaseDetails = $connection->prepare("SELECT * FROM sales WHERE user_id=? AND id=?");
$purchaseDetails->execute(array($user_id,$id));
$result = $purchaseDetails->fetch(PDO::FETCH_ASSOC);

?>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                <div class="card-body">
                        <h4 class="card-title">Sales Details</h4>
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
                                        <td><?php echo getGroupNameByID('group_name',$result['group_name'],$result['product_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Expire Date</td>
                                        <td><?php echo $result['expire_date']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Quantity</td>
                                        <td><?php echo $result['quantity']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Per Item Price</td>
                                        <td><?php echo $result['price']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Per Item Menufacture Price</td>
                                        <td><?php echo $result['menu_price']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td><?php 
                                        if($result['discount_type'] == "fixed"){
                                            echo $result['discount_amount']." tk"; 
                                        }
                                        elseif($result['discount_type'] == "percentage"){
                                            echo $result['discount_amount']." %"; 
                                        }
                                        else{
                                            echo "None";
                                        }
                                       
                                        ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Price</td>
                                        <td><?php echo $result['total_price']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td><?php echo $result['sub_total']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Created Date</td>
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

<?php require_once('../includes/footer.php') ?>