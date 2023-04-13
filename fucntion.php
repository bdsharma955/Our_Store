<?php 
    //Get input data count
    function InputCount($col,$value){
        global $connection;
        $stm = $connection->prepare("SELECT $col FROM users WHERE $col=?");
        $stm->execute(array($value));
        $count=$stm->rowCount();

        return  $count;
    }
    //Get Admin input data count
    function adminInputCount($col,$value){
        global $connection;
        $stm = $connection->prepare("SELECT $col FROM admins WHERE $col=?");
        $stm->execute(array($value));
        $count=$stm->rowCount();

        return  $count;
    }

    //GET Add New Table col data
    function getColumnCount($tbl,$col,$value){
        global $connection;
        $stm = $connection->prepare("SELECT $col FROM $tbl WHERE $col=?");
        $stm->execute(array($value));
        $count=$stm->rowCount();

        return  $count;
    }

    //Get Table view data
    function getTableCount($tbl){
        global $connection;
        $stm = $connection->prepare("SELECT * FROM $tbl WHERE user_id=?");
        $stm->execute(array($_SESSION['user']['id']));
        $result=$stm->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //Get Admin Table view data
    function getAdminData($tbl){
        global $connection;
        $stm = $connection->prepare("SELECT * FROM $tbl");
        $stm->execute(array());
        $result=$stm->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //Get Table Single data
    function getSingleCount($tbl,$id){
        global $connection;
        $stm = $connection->prepare("SELECT * FROM $tbl WHERE user_id=? AND id=?");
        $stm->execute(array($_SESSION['user']['id'],$id));
        $result=$stm->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    //Get Table Single data
    function getUserView($tbl,$id){
        global $connection;
        $stm = $connection->prepare("SELECT * FROM $tbl WHERE id=?");
        $stm->execute(array($id));
        $result=$stm->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //Get Table delete data
    function DeleteTableData($tbl,$id){
        global $connection;
        $stm = $connection->prepare("DELETE FROM $tbl WHERE user_id=? AND id=?");
        $delete = $stm->execute(array($_SESSION['user']['id'],$id));
        
        return $delete;
    }


        //Get Profile DATA
    function getProfile($id){
        global $connection;
        $stm=$connection->prepare("SELECT * FROM users WHERE id=?");
        $stm->execute(array($id));
        $result=$stm->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

        //Get Admin Profile DATA
    function getAdminProfile($id){
        global $connection;
        $stm=$connection->prepare("SELECT * FROM admins WHERE id=?");
        $stm->execute(array($id));
        $result=$stm->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
        //Get Product category DATA
    function getProductdata($col,$id){
        global $connection;
        $stm=$connection->prepare("SELECT $col FROM categories WHERE id=?");
        $stm->execute(array($id));
        $result=$stm->fetch(PDO::FETCH_ASSOC);
        return $result[$col];
    }

        //Get Product Products DATA
    function getProductName($col,$id){
        global $connection;
        $stm=$connection->prepare("SELECT $col FROM products WHERE id=?");
        $stm->execute(array($id));
        $result=$stm->fetch(PDO::FETCH_ASSOC);
        return $result[$col];
    }
    function getTableProduct(){
        global $connection;
        $stm=$connection->prepare("SELECT Id FROM products");
        $stm->execute();
        $result=$stm->rowCount();
        return $result;
    }


        //Get Product Menufactures DATA
    function getMenufactureName($col,$id){
        global $connection;
        $stm=$connection->prepare("SELECT $col FROM menufactures WHERE id=?");
        $stm->execute(array($id));
        $result=$stm->fetch(PDO::FETCH_ASSOC);
        return $result[$col];
        

    }

        //Get Group name
    function getGroupName($col,$name,$pid){
        global $connection;
        $stm=$connection->prepare("SELECT $col FROM groups WHERE group_name=? AND product_id=?");
        $stm->execute(array($name,$pid));
        $result=$stm->fetch(PDO::FETCH_ASSOC);
        return $result[$col];

    }

        //Get Group name
        function getGroupNameByID($col,$id,$pid){
            global $connection;
            $stm=$connection->prepare("SELECT $col FROM groups WHERE id=? AND product_id=?");
            $stm->execute(array($id,$pid));
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            return $result[$col];
        }


   // get dashborad value
   function getTotalValue($tbl,$col){
         
    $total_sales = 0;
    $sales = getTableCount($tbl);
    foreach($sales as $sale){
        $total_sales = $total_sales + $sale[$col];
    }
    return $total_sales;
   }
     
   

?>