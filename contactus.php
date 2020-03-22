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
   <title>Contact us</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
   <link rel="stylesheet" href="main.css">
   <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet" >
   <script src="https://kit.fontawesome.com/ef2495b599.js" crossorigin="anonymous"></script>



    <script src="https://kit.fontawesome.com/ef2495b599.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </head>
    <style>
      .heading-site{
    text-align: center;
    font-family: 'Montserrat', sans-serif;
}
.COLORED {
    height: 400px;
    width: 100%;
    background-color: #ff9f43;
    padding: 30px;
    text-align: center;

}

/*
HEADER
*/
.header{
    width: 100%;
    margin-left: 0;
    margin-right: 0;
    height: 70px;
    line-height: 70px;
    background-color: rgba(0, 0 ,0 ,0);
    position: fixed;
    top: 0;
    z-index: 999;}
    .header .header-logo{
      color: coral;
      font-family: 'Montserrat', sans-serif;
      float: left;
      margin-left: 30px;
      position: fixed;
}
.header .header-menu{
      float: right;
      margin-right: 30px;
      overflow: hidden;

}
.header .header-menu a{
    margin-right: 15px;
    color: coral;
    font-family: 'Montserrat', sans-serif;
}
.header .header-menu a:hover{
    color: cornflowerblue;
}

.header .header-menu ul li{
        list-style: none;
        float:left;
        margin-left: 160px;
    }

.header .header-menu ul li a {
    text-decoration: none;
    width: 100px;
    text-align: center;
    line-height: 50px;
}
.header .header-menu ul ul{
    position: absolute;
    visibility: hidden;
}
.header .header-menu ul ul li a{
    width: auto;
    clear: both;
    display: block;
    height: 30px;
    line-height: 30px;
    text-align:left;
    color:white;
    border-top:  solid white;
    margin-left: -120px;
    background-color: coral;
}
.header ul li:hover ul{
    visibility: visible;
}



/*BANNER
*/

/*
ABOUT
*/
.about .about-single-element .icon{
    font-size: 60px;
    text-align: center;
}
.about .about-single-element{
    text-align: center;
}
.about .about-single-element p{
    text-align: left;
    margin-top: 20px;
}
.own-modal{
    padding-top: 100px;
}

    </style>
    <body>
      <div class="block">
      <header class="header"> 
        <a href="index.html" class="header-logo" >CHEHIWATY </a>
        <nav class="header-menu">
            <ul>
              <li><a href="index.php">Accueil</a></li>
              <li><a href="#">chehiwat</a>
                 <ul>
                  <li><a href="entrees.php">Nos Entrées</a></li><br/>
                  <li><a href="plats.php">Nos Plats</a></li><br/>
                  <li><a href="desserts.php">Nos Desserts</a></li><br/>
                 </ul>    
              </li>
              <li><button type="button" class="nav-link btn-outline-info" data-toggle="modal" data-target="#cart">Cart</button></li>
               <li> <a href="#">Panier <i class="fas fa-cart-plus"></i></a></li>
            </ul>
        </nav>
      </header>
      </div>



      <div class="block">
        <footer class="footer">
            <h2 class="heading-site"> Contactez-Nous </h2>
            <div class="footer-contact-form">
                <form >
                  <div class="field">
                      <label class="label"> Votre Nom :</label>
                    <div class="control">
                      <input type="text" name="first_name" id="first_name" class=" input" data-rule="minlen:3" data-msg="Please enter at least 3 chars">
                    </div>
                </div>
  
                <div class="field">
                  <label class="label"> Votre Prénom :</label>
                <div class="control">
                  <input type="text" name="last_name" id="last_name" class=" input" data-rule="minlen:3" data-msg="Please enter at least 3 chars">            
                </div>
            </div>
      <div class="field">
        <label class="label">Email:</label>
      <div class="control">
        <input type="email" name="email" id="email" class="input" data-rule="email" data-msg="Please enter a valid email">
      </div>
  </div>

  <div class="field">
      <label class="label">Tel:</label>
    <div class="control">
      <input type="text" name="phone" id="phone" class="input" data-rule="required" data-msg="The phone number is required">
    </div>
</div>
<div class="field">
  <label class="label">Adresse:</label>
<div class="control">
  <input type="text" name="Adresse" id="Adresse" class="input" data-rule="Adresse" data-msg="Please entrer votre propre Adresse">
</div>
</div>


</form>
<button class="button is-link" id="send_email">Envoyer</button>


</div>
<div class="footer-information">

</div>
</footer>
</div>


</body>
</html>