<?php 
require_once('../config.php');
require_once('../includes/header.php');

$id = $_REQUEST['id'];

$user_id = $_SESSION['user']['id'];

if(isset($_POST['update_form'])){
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
    elseif(empty($discription)){
        $error = "Discription is Required!";
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
        move_uploaded_file($_FILES["photo"]["tmp_name"],$target_directory.$new_photo_name);
        $now = date('Y-m-d H:i:s');
        $stm = $connection->prepare("UPDATE products SET product_name=?,category_id=?,discription=?,photo=?,create_at=? WHERE id=?");
        $stm->execute(array($product_name,$product_category,$discription,$new_photo_name,$now,$id));

        $success = "Product Update Successfully!";
    }

}


?>

    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
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
                                <?php 
                                    $cate_data = getSingleCount('products',$id);
                                ?>
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo $cate_data['product_name']; ?>">
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
                                    <textarea name="discription" id="discription" class="form-control summernote"><?php echo $cate_data['discription']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input type="file" name="photo" id="photo" class="form-control">
                                    <p>Photo size less then 5MB!</p>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="update_form" class="btn btn-success" value="Update">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
            
        </div>
    </div>
    <!-- #/ container -->

<?php require_once('../includes/footer.php') ?>