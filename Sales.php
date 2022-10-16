<?php require 'config.php';
session_start();
?>
<html>

<head>
  <link rel="stylesheet" href="assets/css/Userhome.css">
  <link rel="stylesheet" href="assets/css/header.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
    integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" media="screen and (max-width: 1101px)" href="assets/css/phone.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
    integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT"
    crossorigin="anonymous"></script>
</head>

<style>
  table {
    margin-top: 2%;
    margin-left: 2%;
    padding-top: 50%;
    padding-left: 10px;
    text-align: center;
  }

  th,
  td {
    border: 1px solid black;
    text-align: center;
  }
</style>

<body>
  <div class="header">
    <img class="logo" src="assets/img/logo.jpeg">
    <div class="dropdown">
      <input class="btn btn-secondary dropdown-toggle userbutton btn-lg" type="image" src="assets/img/user.png"
        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      </input>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="AdminProfile.html">Profile</a>
        <a class="dropdown-item" href="home.html">Log Out</a>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-sm navbar-custom ">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="Adminhome.html"><i class="fa fa-fw fa-home"></i>Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_menu_view.html"><i class="fa fa-spoon" aria-hidden="true"></i>
          Menu</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_combo_view.html"><i class="fa fa-cutlery" aria-hidden="true"></i> Combos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="OrderList_all.html"><i class="fa fa-check-square" aria-hidden="true"></i> Orders</a>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Admin_order_history.html"><i class="fa fa-check-square" aria-hidden="true"></i>
          Order History</a>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#"><i class="fa fa-check-square" aria-hidden="true"></i> Sales Report</a>
        </a>
      </li>
    </ul>
  </nav>

  <table style="width:90%">
    <tr>
      <th>Order Id</th>
      <th>Food Name</th>
      <th>Combo Name</th>
      <th>Price</th>
      <th>Sales</th>
      <th>Total</th>
    </tr>
    <?php $sql = "select * from order_today order by `time` DESC;";
    $result = mysqli_query($conn, $sql);
    while ($row = $result->fetch_assoc()) {
        $date = explode(' ', $row['time']);
        $combo = unserialize($row['combo_id']);
        $food = unserialize($row['food_id']);
        ?>
    <tr>
      <td>1</td>
      <td>Samosa</td>
      <td>Snacks</td>
      <td>00</td>
      <td>00</td>
      <td>00</td>
    </tr>
  <?php }?>
  </table>

</body>


</html>