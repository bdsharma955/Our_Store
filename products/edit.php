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


    if(empty($product_name)){
        $error = "Category Name is Required!";
    }
    elseif(empty($product_category)){
        $error = "Category is Required!";
    }
    
    else{
        $image_link = getProductName('photo',$id);

        if(!empty($_FILES['photo']['name'])){
            
            $target_file = $target_directory . basename($_FILES["photo"]["name"]);
            $photoExtensionType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            if($photoExtensionType != 'jpg' && $photoExtensionType != 'jpeg' && $photoExtensionType != 'png'){
                $error = "Photo is must be jpg or jpeg or png!";
            }
            else{

                $new_photo_name = $user_id."-".rand(1111,9999)."-".time().".".$photoExtensionType;
                
                move_uploaded_file($_FILES["photo"]["tmp_name"],$target_directory.$new_photo_name);

                if(file_exists($target_directory.$image_link)){
                    unlink($target_directory.$image_link); 
                } 
    
            }
            $image_link =  $new_photo_name;

        }

        $stm=$connection->prepare("UPDATE products SET product_name=?,category_id=?,discription=?,photo=? WHERE id=?");
        $stm->execute(array($product_name,$product_category,$discription,$image_link,$id));

        $success = "Product Update Successfully!";


        // option 1
        
        // if(!empty($_FILES['photo']['name'])){
            
        //     $target_file = $target_directory . basename($_FILES["photo"]["name"]);
        //     $photoExtensionType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        //     if($photoExtensionType != 'jpg' && $photoExtensionType != 'jpeg' && $photoExtensionType != 'png'){
        //         $error = "Photo is must be jpg or jpeg or png!";
        //     }
        //     else{

        //         $new_photo_name = $user_id."-".rand(1111,9999)."-".time().".".$photoExtensionType;
                
        //         move_uploaded_file($_FILES["photo"]["tmp_name"],$target_directory.$new_photo_name);
                
        //         $stm2 = $connection->prepare("UPDATE products SET product_name=?,category_id=?,discription=?,photo=? WHERE id=?");
        //         $stm2->execute(array($product_name,$product_category,$discription,$new_photo_name,$id));
    
        //         $success = "Product Update Successfully!";
        //     }

        // }
        // else{
        //     $stm = $connection->prepare("UPDATE products SET product_name=?,category_id=?,discription=? WHERE id=?");
        //     $stm->execute(array($product_name,$product_category,$discription,$id));
    
        // }
        
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
                                    $pro_up_data = getSingleCount('products',$id);
                                ?>
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo $pro_up_data['product_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="product_category">Select Category</label>
                                    <select name="product_category" id="product_category" class="form-control">
                                        <?php 
                                            $categories = getTableCount('categories');
                                            foreach($categories as $category) :
                                         ?>
                                        <option value="<?php echo $category['id'] ?>"
                                        <?php if($pro_up_data['category_id'] == $category['id']){
                                            echo "selected ";
                                        } ?>
                                        ><?php echo $category['category_name'] ?></option>
                                        <?php  endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="discription">Discription</label>
                                    <textarea name="discription" id="discription" class="form-control summernote"><?php echo $pro_up_data['discription']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <label for="photo">Photo: <mark>Skip it, if won't update photo</mark></label>
                                    <input type="file" name="photo" id="photo" class="form-control">
                                    <p>Photo size less then 5MB!</p>
                                    <div class="preview">
                                        <img style="width:100px; height:auto" src="../uploads/products/<?php echo $pro_up_data['photo']; ?>">
                                    </div>
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