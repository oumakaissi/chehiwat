<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'price' => $productByCode[0]["price"], 'image' => $productByCode[0]["image"]));

                if (!empty($_SESSION["cart_item"])) {
                    if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productByCode[0]["code"] == $k) {
                                if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                    if (empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            break;
        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

    <!-- <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <script src="popper/popper.js"></script>
    <script src="jquery/jquery.js"></script> -->
    <title>Bout7anouty</title>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark fixed-top">
        <a href="#" class="nav"></a>
        <ul class="nav mr-auto nav-tabs">
            <li class="nav-item active">
                <a href="index.php" class="nav-link btn-outline-info">
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a href="about.php" class="nav-link btn-outline-info">
                    About Us
                </a>
            </li>
            <li class="nav-item">
                <a href="contactus.php" class="nav-link btn-outline-info">
                    Contact Us

                </a>
            </li>

        </ul>
        <ul class="nav nav-pills">
            <!-- Show cart -->
            <li class="nav-item">

                <button type="button" class="nav-link btn-outline-info" data-toggle="modal" data-target="#cart">Cart</button>
            </li>
            <li class="nav-item">
                <a href="signup.php" class="nav-link btn-outline-info">
                    Sign up
                </a>
            </li>
            <li class="nav-item">

                <a href="login.php" class="nav-link btn-outline-success">
                    Login

                </a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="formDiv">
            <form>
                <div class="form-group">
                    <label for="fullNameInput">
                        Full Name:
                    </label>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" id="firstName" placeholder="First Name" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="lastName" placeholder="Last Name" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="usernameInput">Username:</label>
                    <input type="text" class="form-control" aria-describedby="Username" id="usernameInput" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="emailInput">
                        Email Address:
                    </label>
                    <input type="email" class="form-control" aria-describedby="Email Address" id="emailInput" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="emailInput">
                        Password:
                    </label>
                    <input type="password" class="form-control" aria-describedby="Password" id="passwordInput" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="address" placeholder="Address" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="address2" placeholder="Address 2" required>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" id="city" placeholder="City" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="state" placeholder="State" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="zip" placeholder="zip" required>
                </div>

                <button type="submit" class="btn btn-outline-info">Sign Up</button>
            </form>
        </div>
    </div>
     <!-- Cart -->
     <div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="shopping-cart">

                        <a id="btnEmpty" href="index.php?action=empty">Empty Cart</a>
                        <?php
                        if (isset($_SESSION["cart_item"])) {
                            $total_quantity = 0;
                            $total_price = 0;
                        ?>
                            <table class="tbl-cart" cellpadding="10" cellspacing="1">
                                <tbody>
                                    <tr>
                                        <th style="text-align:left;">Name</th>
                                        <th style="text-align:left;">Code</th>
                                        <th style="text-align:right;" width="5%">Quantity</th>
                                        <th style="text-align:right;" width="10%">Unit Price</th>
                                        <th style="text-align:right;" width="10%">Price</th>
                                        <th style="text-align:center;" width="5%">Remove</th>
                                    </tr>
                                    <?php
                                    foreach ($_SESSION["cart_item"] as $item) {
                                        $item_price = $item["quantity"] * $item["price"];
                                    ?>
                                        <tr>
                                            <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
                                            <td><?php echo $item["code"]; ?></td>
                                            <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
                                            <td style="text-align:right;"><?php echo "$ " . $item["price"]; ?></td>
                                            <td style="text-align:right;"><?php echo "$ " . number_format($item_price, 2); ?></td>
                                            <td style="text-align:center;"><a href="index.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
                                        </tr>
                                    <?php
                                        $total_quantity += $item["quantity"];
                                        $total_price += ($item["price"] * $item["quantity"]);
                                    }
                                    ?>

                                    <tr>
                                        <td colspan="2" align="right">Total:</td>
                                        <td align="right"><?php echo $total_quantity; ?></td>
                                        <td align="right" colspan="2"><strong><?php echo "$ " . number_format($total_price, 2); ?></strong></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php
                        } else {
                        ?>
                            <div class="no-records">Your Cart is Empty</div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Order now</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>