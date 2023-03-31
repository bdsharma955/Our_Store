<?php 
require_once('../config.php');
require_once('../includes/header.php');

$id = $_REQUEST['id'];

$user_id = $_SESSION['user']['id'];

if(isset($_POST['update_form'])){
    $category_name = $_POST['cate_name'];
    $category_slug = $_POST['cate_slug'];

    $slugCount = getColumnCount('categories','category_slug',$category_slug);
    $pattern1 = "/^[a-z-0-9]+$/";

    $stm = $connection->prepare("SELECT category_slug FROM categories WHERE category_slug=? AND id=?");
    $stm->execute(array($category_slug,$id));
    $ownSlugCount=$stm->rowCount();

    if(empty($category_name)){
        $error = "Category Name is Required!";
    }
    elseif(empty($category_slug)){
        $error = "Category Slug is Required!";
    }
    elseif($slugCount != 0 AND $ownSlugCount != 1){
        $error = "Category Slug Already Exits!";
    }
    elseif(!preg_match($pattern1, $category_slug)){
        $error = "Slug does't support use any Special or White Spece or Uppercase Caracters!";
    }
    
    else{
        $now = date('Y-m-d H:i:s');
        $stm = $connection->prepare("UPDATE categories SET category_name=?,category_slug=? WHERE user_id=? AND id=?");
        $stm->execute(array($category_name,$category_slug,$user_id,$id));

        $success = "Category Update Successfully!";
    }

}

?>

    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Create Category</h3>
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
                            <form method="POST" action="">
                                <?php 
                                    $cate_data = getSingleCount('categories',$id);
                                ?>
                                <div class="form-group">
                                    <label for="cate_name">Category Name</label>
                                    <input type="text" name="cate_name" id="cate_name" class="form-control" value="<?php echo $cate_data['category_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="cate_slug">Category Slug</label>
                                    <input type="text" name="cate_slug" id="cate_slug" class="form-control" value="<?php echo $cate_data['category_slug']; ?>">
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