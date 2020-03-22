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

<div class="block">
        <header class="header">
            <a href="index.php" class="header-logo">CHEHIWATY </a>
            <nav class="header-menu">
                <ul>
                    <li class="nav-link"><a href="index.php">Accueil</a></li>
                    <li class="nav-link"><a href="#">chehiwat</a>
                        <ul>
                            <li><a href="entrees.php">Nos Entrées</a></li><br/>
                            <li><a href="plats.php">Nos Plats</a></li><br/>
                            <li><a href="desserts.php">Nos Desserts</a></li><br/>
                        </ul>
                    </li>
                    <li class="nav-link"><a href="login.php">S'identifier</a>
                    <li class="nav-link"><a href="signup.php">S'inscrire</a>
                    
                    <li class="nav-link"> <a href="panier.php">Panier  <i class="fas fa-cart-plus"></i></a></li>
                </ul>
            </nav>
        </header>
    </div>
    



    <div class="container">
        <div class="formDiv">
            <form>
                <div class="form-group">
                    <label for="emailInput">
                        Email Address:
                    </label>
                    <input type="email" class="form-control" aria-describedby="Email Address" id="emailInput" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="emailInput">
                        Email Address:
                    </label>
                    <input type="password" class="form-control" aria-describedby="Password" id="passwordInput" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-outline-success">Login</button>
            </form>
        </div>
    </div>
   
    
</body>

</html>