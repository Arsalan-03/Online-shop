<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<header>
    <a href="#" class="logo"> LOGO </a>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Technologies &bigtriangledown;</a>
                <ul>
                    <li><a href="#">HTML</a></li>
                    <li><a href="#">CSS</a></li>
                    <li><a href="#">JavaScript</a>
                        <ul>
                            <li><a href="#">PHP</a></li>
                            <li><a href="#">JQuery</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="#">Portfolio</a></li>
            <li><a href="#">Design &bigtriangledown;</a>
                <ul>
                    <li><a href="#">UI Design</a></li>
                    <li><a href="#">UX Design</a></li>
                </ul>
            </li>
            <li><a href="#">Contacts</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">

        <?php if (isset($products)) {
            foreach ($products as $product): ?>

        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                    Hit!
                </div>
                <img class="card-img-top" src="<?php echo $product['image']; ?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $product['name']; ?></p>
                    <a href="#"><h5 class="card-title"><?php echo $product['description']; ?></h5></a>
                    <div class="card-footer">
                        <?php echo $product['price']; ?>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; } ?>
    </div>
</div>

</body>
</html>

<style>
     * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         font-family: sans-serif;
         list-style: none;
         text-decoration: none;
     }

     body {
         height: 100vh;
         background-color: darkgrey;
         background-size: cover;
         background-position: center;
     }

     header {
         position: fixed;
         top: 0;
         left: 0;
         right: 0;
         background: #ffffff;
         display: flex;
         justify-content: space-between;
         align-items: center;
         padding: 0 8%;
         box-shadow: 0 5px 10px #000000;
     }
     header.logo {
         font-size: 20px;
         font-weight: 900;
         color: black;
         transition: .5s;
     }

     header.logo:hover {
         transform: scale(1.2);
     }

     header nav ul li {
         position: relative;
         float: left;
     }

     header nav ul li a {
         padding: 15px;
         color: black;
         font-size: 16px;
         display: block;
     }

     header nav ul li a:hover {
         background: black;
         color: white;
     }

     nav ul li ul {
         position: absolute;
         left: 0;
         width: 100px;
         background: white;
         display: none;
     }

     nav ul li ul li {
         width: 100%;
         border: 1px solid rgba(0, 0,0,.1);
     }

     nav ul li ul li ul {
         left: 100px;
          top: 0;
     }

     nav ul li:hover > ul {
         display: initial;''
     }

     a {
         text-decoration: none;
     }

     a:hover {
         text-decoration: none;
     }

     h3 {
         line-height: 3em;
     }

     .card {
         max-width: 16rem;
     }

     .card:hover {
         box-shadow: 1px 2px 10px lightgray;
         transition: 0.2s;
     }

     .card-header {
         font-size: 13px;
         color: gray;
         background-color: white;
     }

     .text-muted {
         font-size: 11px;
     }

     .card-footer{
         font-weight: bold;
         font-size: 18px;
         background-color: white;
     }
</style>