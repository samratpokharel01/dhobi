<?php
include('../../dbconn.php');

// session_start();
if (!isset($_SESSION['ADMIN_NAME'])) {
    $_SESSION['msg'] = "Access Denied";
    header('location:../../login.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Custom Css -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Fontawesome CDN  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0-1/css/all.min.css" integrity="sha512-wDB6AYiYP4FO5Sxieamqy9wtpAY3qdHMqlhZecIEUu1YjkLw5gQf/4ZDgOzmCBAF5SheMjmugkpUSVoUrGbLkQ==" crossorigin="anonymous" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Admin's Dashboard</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-danger fixed-top ">
        <a class="navbar-brand text-white font-weight-bold py-1 font-25" href="../dashboard.php">Admin Pannel</a>
        <div class="dropdown ml-auto">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Welcome! Admin <i class="fas fa-user pl-1"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
            </div>
        </div>
        </div>

    </nav>

    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-md-2 col-sm-12 mt-5 ml-0">
                <ul class="nav flex-column bg-light">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" aria-current="page" href="../dashboard.php" style="color: black;">
                            <i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" aria-current="page" href="../customers/index.php" style="color: black;">
                            <i class="fas fa-spinner"></i> Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" aria-current="page" href="../categories/index.php" style="color: black;">
                            <i class="fas fa-box"></i> Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" aria-current="page" href="../items/index.php" style="color: black;">
                            <i class="fas fa-bullhorn"></i>Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" aria-current="page" href="../orders/index.php" style="color: black;">
                            <i class="fas fa-bullhorn"></i>Orders</a>
                    </li>
                </ul>
            </div>
            <div class="col-10 mt-3">
                <div class="shadow">
                    <p class="text-center font-weight-bold text-white p-2 bg-dark">Orders</p>
                    <div class="p-5 table-responsive">
                        <table class="table table-bordered my-2">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">SN</th>
                                    <th class="text-center" scope="col">Item Name</th>
                                    <th class="text-center" scope="col">Customer</th>
                                    <th class="text-center" scope="col">Quantity</th>
                                    <th class="text-center" scope="col">Total Price</th>
                                    <th class="text-center" scope="col">Date ordered</th>
                                    <th class="text-center" scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        
                                $sql = "SELECT * FROM `order` ORDER BY o_id DESC";
                                $i = 1;

                                $result = mysqli_query($con, $sql);
                               
                                if (mysqli_num_rows($result) > 0) {
                                    while ($data = mysqli_fetch_assoc($result)) {
                                                                                
                                        $userid = $data['cus_id'];
                                        $query = "SELECT `name` FROM `customer` WHERE cus_id = '$userid'";
                                        $result_name = mysqli_query($con, $query);
                                        $data1 = mysqli_fetch_assoc($result_name);                 
                                ?>

                                        <tr>
                                            <th class="text-center" scope="row"><?php echo $i; ?></th>
                                            <td class="text-center"><?php echo $data['item_name']; ?></td>
                                            <td class="text-center"><?php echo $data1['name']; ?></td>
                                            <td class="text-center"><?php echo $data['quantity']; ?></td>
                                            <td class="text-center"><?php echo $data['price']; ?></td>
                                            <td class="text-center"><?php echo $data['date']; ?></td>
                                            <td class="text-center">
                                                <?php
                                                if ($data['status'] == 1) {
                                                    echo '<p>  <a href="status.php?id=' . $data['o_id'] . '&status=0" class="btn btn-success"> Completed </a> </p>';
                                                } 
                                                elseif ($data['status'] == 2) {
                                                    echo '<p>  <a href="status.php?id=' . $data['o_id'] . '&status=1" class="btn btn-primary">In progress </a> </p>';
                                                } 
                                                else {
                                                    echo '<p>  <a href="status.php?id=' . $data['o_id'] . '&status=2" class="btn btn-danger"> Pending</a> </p>';
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                <?php
                                        $i++;
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>