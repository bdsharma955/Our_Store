<?php 
require_once('../config.php');
require_once('../includes/header.php');

$user_id = $_SESSION['user']['id'];

if(isset($_POST['add_new_form'])){
    $target_directory = '../uploads/products/';

    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $discription = $_POST['discription'];
    $photo = $_FILES['photo']['name'];
    $target_file = $target_directory . basename($_FILES["photo"]["name"]);
    $photoExtensionType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


    if(empty($product_name)){
        $error = "Category Name is Required!";
    }
    elseif(empty($product_category)){
        $error = "Category is Required!";
    }
    elseif(empty($photo)){
        $error = "Photo is Required!";
    }
    elseif($_FILES["photo"]["size"] > 5000000){
        $error = "Photo size less then 5MB!";
    }
    elseif($photoExtensionType != 'jpg' && $photoExtensionType != 'jpeg' && $photoExtensionType != 'png'){
        $error = "Photo is must be jpg or jpeg or png!";
    }
    
    else{
        $new_photo_name = $user_id."-".rand(1111,9999)."-".time().".".$photoExtensionType;

        // $getSize = getimagesize($_FILES["photo"]["tmp_name"]);
        // print_r($getSize);

        move_uploaded_file($_FILES["photo"]["tmp_name"],$target_directory.$new_photo_name);
        $now = date('Y-m-d H:i:s');

        $stm = $connection->prepare("INSERT INTO products(user_id,product_name,category_id,discription,photo,create_at,stock) VALUES(?,?,?,?,?,?,?)");
        $stm->execute(array($user_id,$product_name,$product_category,$discription,$new_photo_name,$now,"Null"));

        $success = "Product Create Successfully!";
    }

}

?>

    
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Create Products</h3>
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
                        <div class="basic-form">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name">
                                </div>
                                <div class="form-group">
                                    <label for="product_category">Select Category</label>
                                    <select name="product_category" id="product_category" class="form-control">
                                        <?php 
                                            $categories = getTableCount('categories');
                                            foreach($categories as $category) :
                                         ?>
                                        <option value="<?php echo $category['id'] ?>"><?php echo $category['category_name'] ?></option>
                                        <?php  endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="discription">Discription</label>
                                    <textarea name="discription" id="discription"  class="form-control summernote"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input type="file" name="photo" id="photo" class="form-control">
                                    <p>Photo size less then 5MB!</p>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="add_new_form" class="btn btn-success" value="Products">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
            
        </div>
    </div>
    

<?php require_once('../includes/footer.php') ?>