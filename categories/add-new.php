<?php 
require_once('../config.php');
require_once('../includes/header.php');

$user_id = $_SESSION['user']['id'];

if(isset($_POST['add_new_form'])){
    $category_name = $_POST['cate_name'];
    $category_slug = $_POST['cate_slug'];

    $slugCount = getColumnCount('categories','category_slug',$category_slug);
    $pattern1 = "/^[a-z-0-9]+$/";

    if(empty($category_name)){
        $error = "Category Name is Required!";
    }
    elseif(empty($category_slug)){
        $error = "Category Slug is Required!";
    }
    elseif($slugCount != 0){
        $error = "Category Slug Already Exits!";
    }
    elseif(!preg_match($pattern1, $category_slug)){
        $error = "Slug does't support use any Special or White Spece or Uppercase Caracters!";
    }
    
    else{
        $now = date('Y-m-d H:i:s');
        $stm = $connection->prepare("INSERT INTO categories(user_id,category_name,category_slug,create_at) VALUES(?,?,?,?)");
        $stm->execute(array($user_id,$category_name,strtolower($category_slug),$now));

        $success = "Category Create Successfully!";
    }

}
function category_value($bip){
    if(isset($_POST[$bip])){
        echo $_POST[$bip];
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
                                <div class="form-group">
                                    <label for="cate_name">Category Name</label>
                                    <input type="text" name="cate_name" value="<?php category_value('cate_name'); ?>" id="cate_name" class="form-control" placeholder="Category Name">
                                </div>
                                <div class="form-group">
                                    <label for="cate_slug">Category Slug</label>
                                    <input type="text" name="cate_slug" value="<?php category_value('cate_slug'); ?>" id="cate_slug" class="form-control" placeholder="Category Slug">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="add_new_form" class="btn btn-success" value="Create">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
            
        </div>
    </div>
    

<?php require_once('../includes/footer.php') ?>