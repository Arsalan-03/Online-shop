<form action="" method="POST">
    <div class="container">
        <h1>Добавить товар</h1>
        <hr>

        <label style="color: red"> <?php if (isset($errors['product_id'])) echo $errors['product_id'];; ?></label>
        <label for="product_id"><b>Product-ID</b></label>
        <input type="text" placeholder="product_id" name="product_id" id="product_id" required>

        <label style="color: red"> <?php if (isset($errors['quantity'])) echo $errors['quantity'];; ?></label>
        <label for="quantity"><b>Quantity</b></label>
        <input type="text" placeholder="Enter quantity" name="quantity" id="quantity" required>

        <button type="submit" class="registerbtn">Добавить в корзину</button>
    </div>

    <div class="container signin">
        <p>Already have an account? <a href="#">Sign in</a>.</p>
    </div>
</form>

<style>
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>




