<?php 
require_once('../config.php');
require_once('../includes/header.php');

$user_id = $_SESSION['user']['id'];

if(isset($_POST['add_new_form'])){
    $product_id = $_POST['product_id'];
    $menufacture_id = $_POST['menufacture_id'];
    $group_name = $_POST['group_name'];
    $per_item_price = $_POST['price'];
    $per_item_m_price = $_POST['menu_price'];
    $quantity = $_POST['quantity'];
    $expire = $_POST['expire'];

    if(empty($group_name)){
        $error = "Group Name is Required!";
    }
    elseif(empty($per_item_price)){
        $error = "Price is Required!";
    }
    elseif(empty($per_item_m_price)){
        $error = "Menufacture Price is Required!";
    }
    elseif(empty($quantity)){
        $error = "Quantity is Required!";
    }
    elseif(empty($expire)){
        $error = "Expire Date is Required!";
    }
    else{
        $now = date('Y-m-d H:i:s');
        $total_price = $per_item_price*$quantity;
        $total_m_price = $per_item_m_price*$quantity;
        // Create Group 
        $stm = $connection->prepare("INSERT INTO groups(user_id,group_name,product_id,quantity,expire_date,per_item_price,per_item_m_price,total_price,total_m_price,create_at) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $stm->execute(array($user_id,$group_name,$product_id,$quantity,$expire,$per_item_price,$per_item_m_price,$total_price,$total_m_price,$now));

        // Create Purchase 
        $stm = $connection->prepare("INSERT INTO purchases(user_id,menufacture_id,product_id,group_name,quantity,per_item_price,per_item_m_price,total_price,total_m_price,create_at) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $stm->execute(array($user_id,$menufacture_id,$product_id,$group_name,$quantity,$per_item_price,$per_item_m_price,$total_price,$total_m_price,$now));

        $success = "Create Successfully!";
    }

}

?>

    
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Create Phurchase</h3>
                        <hr>
                        <?php if(isset($error)) : ?>
                        <div class="alert alert-danger">
                        <?php echo $error; ?>
                        </div>    
                        <?php endif; ?>

                        <?php if(isset($success)) : ?>
                        <div class="alert alert-success">
                        <?php echo $success; ?>
                        </div>    
                        <?php endif; ?>
                        
                        <div id="ajaxError" style="display:none;" class="alert alert-danger"></div>    
                        <div class="basic-form">
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="customer_name">Customer Name</label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Customer Name">
                                </div>
                                <div class="form-group">
                                    <label for="product_id">Select Product</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="#">Select Product</option>
                                        <?php 
                                            $products = getTableCount('products');
                                            foreach($products as $product) :
                                         ?>
                                        <option value="<?php echo $product['id'] ?>"><?php echo $product['product_name'] ?></option>
                                        <?php  endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="menufacture_name">Menufacture</label>
                                    <input type="text" name="menufacture_name" id="menufacture_name" class="form-control" readonly>
                                    <input type="hidden" name="menufacture_id" id="menufacture_id">
                                </div>
                                <div class="form-group">
                                    <label for="group_name">Group Name</label>
                                    <select name="group_name" id="group_name" class="form-control" ></select>
                                </div>
                                <div class="form-group">
                                    <label for="expire">Expire Date</label>
                                    <input type="text" name="expire" id="expire" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="menu_price">Menufacture Price</label>
                                    <input type="text" name="menu_price" id="menu_price" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity: <span id="available_stock" class="badge badge-info"></span></label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity">
                                    <input type="hidden" name="stock" id="stock">
                                </div>
                                <div class="form-group">
                                    <label for="total_price">Total Price</label>
                                    <input type="text" name="total_price" id="total_price" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="discount_type">Discount Type</label>
                                    <select name="discount_type" id="discount_type" class="form-control" >
                                        <option value="none">None</option>
                                        <option value="fixed">Fixed</option>
                                        <option value="percentage">Percentage</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="discount_amount">Discount Amount</label>
                                    <input type="text" name="discount_amount" id="discount_amount" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="sub_total">Sub Total</label>
                                    <input type="text" name="sub_total" id="sub_total" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="add_new_form" class="btn btn-success" value="Create Sale">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    

<?php require_once('../includes/footer.php') ?>

<script>
    $('#product_id').on('change',function(){
        let product_id = $(this).val();



        $.ajax({
            type: "POST",
            url: 'ajax.php',
            data:{
                product_id:product_id
            } ,
            success: function(response){
                let productResult = JSON.parse(response);

                if(productResult.count == 0){
                    $('#ajaxError').show().text(productResult.message);
                }
                else{
                    $('#ajaxError').hide();
                    $('#menufacture_name').val(productResult.menufacture_name);
                    $('#menufacture_id').val(productResult.menufacture_id);
                    $('#stock').val(productResult.stock);
                    $('#available_stock').text("Available Stock: "+productResult.stock);

                    // Get Groups
                    $('#group_name').empty();
                    let groups = productResult.groups;
                    $('#group_name').append('<option value="">Select Group</option>');
                    $.each(groups,function (i,item) {
                        $('<option value="'+groups[i].id+'">').html(
                            '<span>'+groups[i].group_name+'</span>'
                        ).appendTo('#group_name');
                    });
                }
            }
        });
    });

    // GET Group Data
    $('#group_name').on('change',function(){
        let group_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data:{
                group_id:group_id
            },
            success:function(response){
                let groupResult = JSON.parse(response);
                $('#expire').val(groupResult.expire_date);
                $('#price').val(groupResult.per_item_price);
                $('#menu_price').val(groupResult.per_item_price);
            }

        });
    });

    // get quantity total price
    $('#quantity').on('keyup',function(){
        
        let price = $('#price').val();
        let quantity = $(this).val();
        let stock = $('#stock').val();

        if(price.length == 0){
            $('#ajaxError').show().text("Please Select Product and Groups!");
        }
        else if(!jQuery.isNumeric(quantity)){
            $('#ajaxError').show().text("Quantity must be number!");
        }
        else if(quantity>stock){
            $('#ajaxError').show().text("Product stock is low!");
        }
        else{
            $('#ajaxError').hide();
            let total_price = price*quantity;
            $('#total_price').val(total_price);
            $('#sub_total').val(total_price);
        }

    });

    // get quantity total price
    $('#discount_amount').on('keyup',function(){
        let type = $('#discount_type').val();
        let discount_amount = $(this).val();

        if(type == "fixed"){
            if(!jQuery.isNumeric(discount_amount)){
                $('#ajaxError').show().text("Discount number must be number!");
            }
            else{
                let total__price = $('#total_price').val();
                let new_sub_total = total__price-discount_amount;
                $('#sub_total').val(new_sub_total)
            }
           
        }
        else if(type == "percentage"){
            if(!jQuery.isNumeric(discount_amount)){
                $('#ajaxError').show().text("Discount number must be number!");
            }
            else{
                let total___price = $('#total_price').val();
                let percentage_amount = total___price*discount_amount/100;
                let new__sub_total = total___price-percentage_amount;
                $('#sub_total').val(new__sub_total)
            }
        }
        else{
            $('#discount_amount').val('');
            let total__price = $('#total_price').val();
            $('#sub_total').val(total__price);
        }
        
    });

    $('#discount_type').on('change',function(){
        let dis_type = $(this).val();
        if(dis_type == "none"){
            $('#discount_amount').val('');
            let total__price = $('#total_price').val();
            $('#sub_total').val(total__price);
        }
    })
    


</script>