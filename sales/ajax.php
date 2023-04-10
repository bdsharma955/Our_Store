
<?php 
require_once('../config.php');

if(isset($_POST['product_id'])){

    $stm = $connection->prepare("SELECT menufacture_id,product_id FROM purchases WHERE product_id=?");
    $stm->execute(array($_POST['product_id']));
    $productCount = $stm->rowCount();
    
    if($productCount != 0){
        $result = $stm->fetch(PDO::FETCH_ASSOC);
        $menufacture_name = getMenufactureName('name',$result['menufacture_id']);

        //get groups
        $stm2 = $connection->prepare("SELECT id,group_name,product_id FROM groups WHERE product_id=?");
        $stm2->execute(array($_POST['product_id']));
        $groups = $stm2->fetchAll(PDO::FETCH_ASSOC);

        // get product stock
        $stock = getProductName('stock',$_POST['product_id']);

        $data = array(
            'message' => "Produc Get Success",
            'count' => $productCount,
            'menufacture_id' => $result['menufacture_id'],
            'menufacture_name' => $menufacture_name,
            'stock' => $stock,
            'groups' => $groups,
        );
    }
    else{
        $data = array(
            'count' => $productCount,
            'message' => "Product Out of Stock"
        );
    }

    echo json_encode($data);

};

// Get Group Name

if(isset($_POST['group_id'])){

    $stm = $connection->prepare("SELECT id,expire_date,per_item_price,per_item_m_price FROM groups WHERE id=?");
    $stm->execute(array($_POST['group_id']));
    $result = $stm->fetch(PDO::FETCH_ASSOC);

    echo json_encode($result);
}

?>