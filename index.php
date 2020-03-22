<!-- dasdasd -->
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


<html>

<head>
    <meta charset="utf-8">
    <title> CHEHIWAT </title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ef2495b599.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>></script>

</head>

<body>


     <!---header 9dima-->
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



   <!-- jdida -->
    <!-- <nav class="navbar  navbar-trans fixed-top">
				<div class="container">
                    <a href="index.php" class=" navbar-brand header-logo justify-content-start">CHEHIWATY </a>

					<div class=" justify-content-end yellow" id="navbarToggler-1">
						<ul class="navbar-nav">
							<li class="nav-item active">
								<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Nos Entrées</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Nos Plats</a>
							</li>

							<li class="nav-item">
                            
								<a class="nav-link" href="#">Nos Desserts</a>
							</li>
                    <li class="nav-link"> 
                    <a href="panier.php">Panier  <i class="fas fa-cart-plus"></i></a>
                    </li>
							<li class="nav-item">
								<a class="btn btn-outline-white btn-outline" href="#"><i class="fa fa-user"></i> Login
								</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>


            <section class="cover text-center">
			<div class="cover-container pb-5">
				<div class="cover-inner container">
						<h1 class="jumbotron-heading">Bonne Appétit!</strong></h1>
						<p>
							<a href="contactus.php" class="btn btn-primary btn-lg mb-2 mr-2 ml-2">Contactez-Nous</a>
						</p>
						<p class="lead">If you fancy changing the navbar settings then simply change the toggleable-sm to toggleable-md , personally don't take it higher as it looks aweful.</p>
						<p class="lead">But feel free to change the settings.</p>
				</div>
			</div>
        </section>


    
      -->

    <div class="block">
        <div class="banner">
            <img src="img/ph.jpg" alt="chehiwat" class="banner-image">
            <div class="banner-content">
                <h1 class="title is=1"> Bonne Appétit!</h1>
                <h2 class="subtitle"> Découvrez votre plats préfèrés</h2>
                <a href="contactus.php"><button class="button is-link" id="open_modal">Contactez-Nous</button></a>


            </div>

        </div>

    </div>
    
    <!----a propos-->
    <div class="block">
        <h1 class="subtitle heading-site">À propos </h1>
        <div class="container about">
            <div class="columns">
                <div class="column about-single-element">
                    <i class="fas fa-code icon"></i>
                    <p>
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa it esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
                    </p>
                </div>
                <div class="column about-single-element">
                    <i class="fas fa-utensils icon"></i>
                    <p>
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa it esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?

                    </p>
                </div>
                <div class="column about-single-element">
                    <i class="fab fa-angrycreative icon"></i>
                    <p>
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa it esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!---Contact-->
    
</body>


</html>