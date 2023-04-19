<?php 
require_once('../config.php');
require_once('header.php');

//get form date
if(isset($_POST['filter_btn'])){

    $selected_month = $_POST["selected_month"];
    $stm=$connection->prepare("SELECT * FROM sales WHERE MONTH(create_at)=?");
    $stm->execute(array($selected_month));
    $monthly_result=$stm->fetchAll(PDO::FETCH_ASSOC);

}

//get to date
if(isset($_POST['date_to_date'])){

    $from_date = $_POST["from_date"];
    $to_date = $_POST["to_date"];
    $stm=$connection->prepare("SELECT * FROM sales WHERE create_at BETWEEN ? AND ? ");
    $stm->execute(array($from_date,$to_date));
    $date_result=$stm->fetchAll(PDO::FETCH_ASSOC);

}


?>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="select">
                                    <label for="select_month">Select Month</label>
                                        <div class="input-group mb-3">
                                            <select id="select_month" name="selected_month" class="form-control form-select">
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">Julay</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">&nbsp;</label>
                                <input type="submit" name="filter_btn" value="Filter" class="btn btn-success form-control">
                            </div>
                        </div>
                    </form>
                    <br>

                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="select">
                                    <label for="from_date">From Date</label>
                                    <div class="input-group mb-3">
                                        <input type="date" name="from_date" id="from_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="select">
                                    <label for="to_date">To Date</label>
                                    <div class="input-group mb-3">
                                        <input type="date" name="to_date" id="to_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">&nbsp;</label>
                                <input type="submit" name="date_to_date" value="Filter" class="btn btn-success form-control">
                            </div>
                        </div>
                    </form>

                    <?php  
                if(isset($_POST['date_to_date'])):
                ?> 
                    <h4 class="card-title">From Date: <?php echo $_POST['from_date'];  ?> To Date: <?php echo $_POST['to_date'];  ?> - Sales Reports</h4> 
                    <div class="table-responsive">
                        
                        <table class="table header-border">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Date</th>
                                    <th>User</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                $a=1;
                                foreach($date_result as $row):
                                    $userData = getProfile($row['user_id']);
                                ?>
                                <tr>
                                    <td><?php  echo $a;$a++; ?></td>

                                    <td><?php echo $row['customer_name']; ?></td> 
                                    <td><?php echo getProductName('product_name',$row['product_id']); ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['sub_total']; ?>tk</td>
 
                                    <td><?php  echo date('d-m-Y',strtotime($row['create_at'])); ?></td> 
                                    <td><a href="user-profile.php?id=<?php echo $row['user_id'];?>"><?php echo $userData['name'];?></a></td> 
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php 
                    elseif(isset($_POST['filter_btn'])):

                    ?>
                    <h4 class="card-title">Month (<?php echo date('F', mktime(0, 0, 0, $_POST['selected_month'], 10)); ?>) Sales Reports</h4>
                    <div class="table-responsive">
                        <table class="table header-border">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                $a=1;
                                foreach ($monthly_result as $row) :
                                    $userData = getProfile($row['user_id']);
                                ?> 
                                <tr>
                                    <td><?php echo $a;$a++; ?></td>
                                    <td><?php echo $row['customer_name']; ?></td> 

                                    <td><?php echo getProductName('product_name',$row['product_id']); ?></td>

                                    <td><?php echo $row['quantity']; ?></td>

                                    <td><?php echo $row['sub_total']; ?>tk</td>

                                    <td><?php  echo date('d-m-Y',strtotime($row['create_at'])); ?></td> 

                                    <td><a href="user-profile.php?id=<?php echo $row['user_id'];?>"><?php echo $userData['name'];?></a></td> 

                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php else: ?> 

                    <h4 class="card-title">Current Month ( <?php echo date('F');  ?> ) Sales Reports</h4> 
                    <div class="table-responsive">
                        
                        <table class="table header-border">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Date</th>
                                    <th>User</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $currentMonth = date('m');
                                $stm=$connection->prepare("SELECT * FROM sales WHERE MONTH(create_at)=?");
                                $stm->execute(array($currentMonth));
                                $result=$stm->fetchAll(PDO::FETCH_ASSOC);
                                
                                $a=1;
                                foreach($result as $row):
                                    $userData = getProfile($row['user_id']);
                                ?>
                                <tr>
                                    <td><?php  echo $a;$a++; ?></td>

                                    <td><?php echo $row['customer_name']; ?></td> 
                                    <td><?php echo getProductName('product_name',$row['product_id']); ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['sub_total']; ?>tk</td>
 
                                    <td><?php  echo date('d-m-Y',strtotime($row['create_at'])); ?></td> 
                                    <td><a href="user-profile.php?id=<?php echo $row['user_id'];?>"><?php echo $userData['name'];?></a></td> 
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    
                    <?php endif; ?>              
                    </div>
                </div>  
            </div>
            
        </div>
    </div>

<?php require_once('footer.php') ?>