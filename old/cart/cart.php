<?php
include '../db_extension.php';
session_start();

if (isset($_GET['type'])) {
  if ($_GET['type'] == 'increment') {
    addToCart(htmlspecialchars($_GET["productId"]));
  } else if ($_GET['type'] == 'decrement') {
    deleteFromCart(htmlspecialchars($_GET["productId"]));
  } else if ($_GET['type'] == 'remove') {
    deleteProductFromCart(htmlspecialchars($_GET["productId"]));
  }

  header('Location: cart.php');
}


$cartProducts =  getCartProducts();
$totalCost = 0;
if ($cartProducts != null) {
  foreach ($cartProducts as $product) {
    $totalCost += $product['ProductQuantity'] * $product['Price'];
  }
}


?>

<!DOCTYPE html>
<html class="nodarken">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body {
      font-family: Arial;
      font-size: 17px;
      padding: 8px;
      margin: 50px 100px 50px 100px;
    }

    * {
      box-sizing: border-box;
    }

    .row {
      display: -ms-flexbox;
      /* IE10 */
      display: flex;
      -ms-flex-wrap: wrap;
      /* IE10 */
      flex-wrap: wrap;
      margin: 0 -16px;
    }

    .col-25 {
      -ms-flex: 25%;
      /* IE10 */
      flex: 25%;
    }

    .col-50 {
      -ms-flex: 50%;
      /* IE10 */
      flex: 50%;
    }

    .col-75 {
      -ms-flex: 75%;
      /* IE10 */
      flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
      padding: 0 16px;
    }

    .container {
      background-color: #f2f2f2;
      padding: 5px 20px 15px 20px;
      border: 1px solid lightgrey;
      border-radius: 3px;
    }

    input[type=text] {
      width: 100%;
      margin-bottom: 20px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    label {
      margin-bottom: 10px;
      display: block;
    }

    .icon-container {
      margin-bottom: 20px;
      padding: 7px 0;
      font-size: 24px;
    }

    .btn {
      background-color: #4CAF50;
      color: white;
      padding: 12px;
      margin: 10px 0;
      border: none;
      width: 100%;
      border-radius: 3px;
      cursor: pointer;
      font-size: 17px;
    }

    .btn:hover {
      background-color: #45a049;
    }

    a {
      color: #2196F3;
    }

    hr {
      border: 1px solid lightgrey;
    }

    span.price {
      float: right;
      color: grey;
    }

    /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
    @media (max-width: 800px) {
      .row {
        flex-direction: column-reverse;
      }

      .col-25 {
        margin-bottom: 20px;
      }
    }
  </style>
</head>

<body>

  <h2>Checkout Page</h2>

  <div class="row">
    <div class="col-75">
      <div class="container">
        <form action="/action_page.php">

          <div class="row">
            <div class="col-50">
              <h3>Billing Address</h3>
              <label for="fname"><i class="fa fa-user"></i> Full Name</label>
              <input type="text" id="fname" name="firstname" placeholder="John M. Doe">
              <label for="email"><i class="fa fa-envelope"></i> Email</label>
              <input type="text" id="email" name="email" placeholder="john@example.com">
              <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
              <input type="text" id="adr" name="address" placeholder="542 W. 15th Street">
              <label for="city"><i class="fa fa-institution"></i> City</label>
              <input type="text" id="city" name="city" placeholder="New York">

              <div class="row">
                <div class="col-50">
                  <label for="state">State</label>
                  <input type="text" id="state" name="state" placeholder="NY">
                </div>
                <div class="col-50">
                  <label for="zip">Zip</label>
                  <input type="text" id="zip" name="zip" placeholder="10001">
                </div>
              </div>
            </div>

            <div class="col-25">
              <div class="container">
                <table summary="This table shows how to create responsive tables using Bootstrap's default functionality" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Product Name</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Total</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <?php if ($cartProducts != null) : ?>
                    <tbody>
                      <?php for ($index = 0; $index < count($cartProducts); $index++) : ?>
                        <tr>
                          <td>
                            <?php echo $cartProducts[$index]["ProductName"] ?>
                          </td>
                          <td>
                            <?php echo $cartProducts[$index]["Price"] ?>
                          </td>
                          <td>
                            <a href="./cart.php?type=decrement&productId=<?php echo $cartProducts[$index]["ProductID"] ?>" class="btn btn-outline-primary" style="margin: 5px 5px 0px 5px !important;
    padding: 7px !important;">-</a>
                            <?php echo $cartProducts[$index]["ProductQuantity"] ?>
                            <a href="./cart.php?type=increment&productId=<?php echo $cartProducts[$index]["ProductID"] ?>" class="btn btn-outline-primary" style="margin: 5px 5px 0px 5px !important;
    padding: 7px !important;">+</a>
                          </td>
                          <td>
                            <?php echo $totalCost ?>₺
                          </td>
                          <td>
                            <a href="./cart.php?type=remove&productId=<?php echo $cartProducts[$index]["ProductID"] ?>" class="btn btn-outline-primary" style="color:red; margin: 5px 5px 0px 5px !important;
    padding: 7px !important;">x</a>
                          </td>
                        </tr>
                      <?php endfor; ?>
                    </tbody>
                  <?php endif; ?>
                </table>
              </div>
            </div>

          </div>
          <label>
            <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
          </label>

          <a href="method.php">
            <input type="button" value="Continue to checkout" class="btn" />
          </a>
          <hr />

          <a href="/">
            <input type="button" value="Keep shopping" class="btn" />
          </a>
        </form>
      </div>
    </div>

  </div>



</body>

</html>