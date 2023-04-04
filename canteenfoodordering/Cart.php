<?php require "config.php" ?>
<html>

<head>
  <link rel="stylesheet" href="assets/css/Cart.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="assets/css/header.css?v=<?php echo time(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
</head>

<body>
  <div class="header">
    <img class="logo" src="assets/img/logo.jpeg">
    <div class="dropdown">
      <input class="btn btn-secondary dropdown-toggle userbutton btn-lg" type="image" src="assets/img/user.png" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      </input>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="Userprofile.php">Profile</a>
        <a class="dropdown-item" href="logout.php">Log Out</a>
      </div>
    </div>
  </div>
  </div>

  <nav class="navbar navbar-expand-sm navbar-custom ">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="Userhome.php"><i class="fa fa-fw fa-home" aria-hidden="true"></i> Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="menu.php"><i class="fa fa-spoon" aria-hidden="true"></i> Menu</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="combos.php"><i class="fa fa-cutlery" aria-hidden="true"></i> Combos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="OrderHistory.php"><i class="fa fa-check-square" aria-hidden="true"></i> Order
          History</a>
    </ul>
    <ul class="navbar-nav ml-auto active">
      <li class="nav-item active">
        <a class="nav-link" href="Cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart</a>
      </li>
    </ul>
  </nav>

  <div class="itemlist">
    <?php
    session_start();
    $count = 0;
    if (!(empty($_SESSION['cart']))) {
      foreach ($_SESSION['cart'] as $item => $itemquatity) {
        $count = $count + (int)$itemquatity;
      }
    }
    ?>

    <div class="ylist">
      <h4> <b>Cart Items: <?php echo $count; ?></b></h4>
      <br>
      <div class="yourlist">
        <h5><b>Your Order:</b></h5>
        <br>
        <?php
        $total = 0;
        $uid = $_SESSION['uid'];
        $combo = array();
        $food = array();
        foreach ($_SESSION['cart'] as $item => $itemquatity) {

          if ($itemquatity > 0) {
            $sql = "select * from combo where `name`='" . $item . "';";
            $result = mysqli_query($conn, $sql);
            if ($result->num_rows == 1) {
              $row = $result->fetch_assoc();
        ?>
              <div class="order">
                <img src='./assets/img/<?php echo $row['image'] ?>' alt="">
                <h5><b><?php echo $row["name"]; ?></b></h5>
                <div class="cost">
                  Cost:<?php echo $row["price"]; ?>
                </div>
                <div class="quantity">
                  Quantity: <?php echo $itemquatity; ?>
                </div>
                <div class="subtotal">
                  <?php $subtotal = ($row['price'] * (int)$itemquatity);
                  $total = $total + $subtotal; ?>

                  Subtotal: <?php echo '₹' . $subtotal; ?>
                </div>
              </div>
              <?php
              $combo[$row['name']] = $itemquatity;
            } else {
              echo $item;
              $sql = "select * from menu where `name`='" . $item . "';";
              $result = mysqli_query($conn, $sql);
              while ($row = $result->fetch_assoc()) {
              ?>
                <div class="order">
                  <img src='./assets/img/<?php echo $row['image'] ?>' alt="">
                  <h5><b><?php echo $row["name"]; ?></b></h5>
                  <div class="cost">
                    Cost:<?php echo $row["price"]; ?>
                  </div>
                  <div class="quantity">
                    Quantity: <?php echo $itemquatity; ?>
                  </div>
                  <div class="subtotal">
                    <?php $subtotal = ($row['price'] * (int)$itemquatity);
                    $total = $total + $subtotal; ?>

                    Subtotal: <?php echo '₹' . $subtotal; ?>
                  </div>
                </div>
        <?php
                $food[$row['name']] = $itemquatity;
              }
            }
          }
        }

        ?>

      </div>
    </div>
    <?php
    if (isset($_POST['pay'])) {
      $id = 'AP' . rand(0, 10000);
      if ($count == 0) {
        echo '<script>alert("Order could not be placed! Try again")</script>';
      } else {
        //check if the quantity is available
        //if yes then
        $signal = 1;
        foreach ($food as $item => $itemquatity) {
          $sql = "SELECT `quantity` FROM `menu` WHERE `name`='" . $item . "'";
          $res = mysqli_query($conn, $sql);
          if ($res->num_rows == 1) {
            $row = $res->fetch_assoc();
            $avail = $row['quantity'];
            if ($avail >= $itemquatity) {
              $avail = intval($avail) - intval($itemquatity);
              $query = "UPDATE `menu` SET `quantity`='" . $avail . "' WHERE `name`='" . $item . "'";
              mysqli_query($conn, $query);
            } else {
              $signal = 0;
              unset($food[$item]);
              unset($_SESSION['cart'][$item]);
    ?>
              <script>
                window.alert("<?php echo $item; ?> is not available!");
              </script>
            <?php
              break;
            }
          }
        }
        foreach ($combo as $item => $itemquatity) {
          $sql = "SELECT `quantity` FROM `combo` WHERE `name`='" . $item . "'";
          $res = mysqli_query($conn, $sql);
          if ($res->num_rows == 1) {
            $row = $res->fetch_assoc();
            $avail = $row['quantity'];
            if ($avail >= $itemquatity) {
              $avail = intval($avail) - intval($itemquatity);
              $query = "UPDATE `combo` SET `quantity`='" . $avail . "' WHERE `name`='" . $item . "'";
              mysqli_query($conn, $query);
            } else {
              $signal = 0;
              unset($combo[$item]);
              unset($_SESSION['cart'][$item]);
            ?>
              <script>
                window.alert("<?php echo $item; ?> is not available!");
              </script>
    <?php
              break;
            }
          }
        }
        if ($signal == 1) {
          $food = serialize($food);
          $combo = serialize($combo);
          $sql = "INSERT INTO `order_today`(`Order_id`, `food`, `combo`, `status`, `user_id`,`cost`) VALUES ('" . $id . "','" . $food . "','" . $combo . "',0,'" . $uid . "','" . $total . "');";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $_SESSION['cart'] = array();
            echo '<script> window.alert("Your Order has been placed!");window.location.href="Userhome.php";</script>';
          } else {
            echo '<script>alert("Order could not be placed! Try again")</script>';
          }
        }
      }
    }


    ?>
    <div class="amountsection">
      <form action='' method='post'>
        <div class="Titleamount">
          Total amount:
          <?php echo '₹' . $total; ?>
        </div>
        <br>
        <button class="pay" name="pay">Pay Now</button>

      </form>
    </div>

  </div>

</body>

</html>