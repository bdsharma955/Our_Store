<?php 
    //Get input data count
    function InputCount($col,$value){
        global $connection;
        $stm = $connection->prepare("SELECT $col FROM users WHERE $col=?");
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

    //Get Table Single data
    function getSingleCount($tbl,$id){
        global $connection;
        $stm = $connection->prepare("SELECT * FROM $tbl WHERE user_id=? AND id=?");
        $stm->execute(array($_SESSION['user']['id'],$id));
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
        //Get Product category DATA
    function getProductdata($col,$id){
        global $connection;
        $stm=$connection->prepare("SELECT $col FROM categories WHERE id=?");
        $stm->execute(array($id));
        $result=$stm->fetch(PDO::FETCH_ASSOC);
        return $result[$col];
    }
 

?>