<header>
    <h3>Checkout</h3>
</header>

<main>

    <section class="checkout-form">
        <form action="/order" method="post">
            <h6>Contact information</h6>
            <div class="form-control">
                <label style="color: red"> <?php if (isset($errors['email'])) echo $errors['email']; ?></label>
                <label for="email">E-mail</label>
                <div>
                    <span class="fa fa-envelope"></span>
                    <input type="email" id="email" name="email" placeholder="Enter your email...">
                </div>
            </div>
            <div class="form-control">
                <label style="color: red"> <?php if (isset($errors['phone'])) echo $errors['phone']; ?></label>
                <label for="phone">Phone</label>
                <div>
                    <span class="fa fa-phone"></span>
                    <input type="tel" name="phone" id="phone" placeholder="Enter you phone...">
                </div>
            </div>
            <br>
            <h6>Shipping address</h6>
            <div class="form-control">
                <label style="color: red"> <?php if (isset($errors['name'])) echo $errors['name']; ?></label>
                <label for="name">Full name</label>
                <div>
                    <span class="fa fa-user-circle"></span>
                    <input type="text" id="name" name="name" placeholder="Enter you name...">
                </div>
            </div>
            <div class="form-control">
                <label style="color: red"> <?php if (isset($errors['address'])) echo $errors['address']; ?></label>
                <label for="address">Address</label>
                <div>
                    <span class="fa fa-home"></span>
                    <input type="text" name="address" id="address" placeholder="Your address...">
                </div>
            </div>
            <div class="form-control">
                <label style="color: red"> <?php if (isset($errors['city'])) echo $errors['city']; ?></label>
                <label for="city">City</label>
                <div>
                    <span class="fa fa-building"></span>
                    <input type="text" name="city" id="city" placeholder="Your city...">
                </div>
            </div>
            <div class="form-group">
                <div class="form-control">
                    <label style="color: red"> <?php if (isset($errors['country'])) echo $errors['country']; ?></label>
                    <label for="country">Country</label>
                    <div>
                        <span class="fa fa-globe"></span>
                        <input type="text" name="country" id="country" placeholder="Your country..." list="country-list">
                        <datalist id="country-list">
                            <option value="India"></option>
                            <option value="USA"></option>
                            <option value="Russia"></option>
                            <option value="Japan"></option>
                            <option value="Egypt"></option>
                        </datalist>
                    </div>
                </div>
                <div class="form-control">
                    <label style="color: red"> <?php if (isset($errors['postalCode'])) echo $errors['postalCode']; ?></label>
                    <label for="postalCode">Postal code</label>
                    <div>
                        <span class="fa fa-archive"></span>
                        <input type="numeric" name="postalCode" id="postalCode" placeholder="Your postal code...">
                    </div>
                </div>
            </div>
            <div class="form-control checkbox-control">
                <input type="checkbox" name="checkout-checkbox" id="checkout-checkbox">
                <label for="checkout-checkbox">Save this information for next time</label>
            </div>
            <div class="form-control-btn">
                <button>Continue</button>
            </div>
        </form>
    </section>

    <section class="checkout-details">
        <div class="checkout-details-inner">
            <div class="checkout-lists">
                <?php if (isset($newOrderProducts)) {
                foreach ($newOrderProducts as $newOrderProduct): ?>
                <div class="card">
                    <div class="card-image"><img src="<?php echo $newOrderProduct->getProduct()->getImage(); ?>" alt=""></div>
                    <div class="card-details">
                        <div class="card-name"><?php echo $newOrderProduct->getProduct()->getName(); ?></div>
                        <div class="card-price"><?php echo '$' . $newOrderProduct->getProduct()->getPrice() . '₽'; ?> <span>$94.99</span></div>
                        <div class="card-wheel">
                            <div style="display: flex; align-items: center;">

                                <form action="/deleteProduct" method="post" style="margin: 0;">
                                    <input type="hidden" name="product_id" value="<?php echo $newOrderProduct->getProductId(); ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit">-</button>
                                </form>

                                <span style="margin: 0 10px;"><?php echo $newOrderProduct->getQuantity(); ?></span>

                                <form action="/addProduct" method="post" style="margin: 0;">
                                    <input type="hidden" name="product_id" value="<?php echo $newOrderProduct->getProductId(); ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit">+</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;}?>

            </div>
            <div class="checkout-total">
                <h6>Total</h6>
                <p><?php
                     $totalPrice = 0;
                     foreach ($newOrderProducts as $newOrderProduct) {
                         $totalPrice += $newOrderProduct->getProduct()->getPrice() * $newOrderProduct->getQuantity();
                     }
                     echo "$" . $totalPrice;
                    ?></p>
            </div>
        </div>
    </section>

</main>

<footer>
    <p>Created by - <a href="https://vetri-suriya.web.app/"><span>Vetri Suriya</span></a></p>
</footer>

</main>

<style>* {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        background-color: lightgrey;
    }
    body {
        font-family: "Poppins", sans-serif;
        height: 110vh;
        width: 70%;
        margin: 0px auto;
        padding: 50px 0px 0px;
        color: black;



        header {

            height: 5%;
            margin-bottom: 30px;

            > h3 {
                font-size: 25px;
                color: #4E5150;
                font-weight: 500;
            }

        }

        main {
            height: 85%;
            display: flex;
            column-gap: 100px;

            .checkout-form  {
                width: 50%;

                form {

                    h6 {
                        font-size: 12px;
                        font-weight: 500;
                    }

                    .form-control  {
                        margin: 10px 0px;
                        position: relative;

                        label:not([for="checkout-checkbox"]) {
                            display: block;
                            font-size: 10px;
                            font-weight: 500;
                            margin-bottom: 2px;
                        }

                        input:not([type="checkbox"]) {
                            width: 100%;
                            padding: 10px 10px 10px 40px;
                            border-radius: 10px;
                            outline: none;
                            border: .2px solid #4e515085;
                            font-size: 12px;
                            font-weight: 700;

                            &::placeholder {
                                font-size: 10px;
                                font-weight: 500;
                            }
                        }

                        label[for="checkout-checkbox"] {
                            font-size: 9px;
                            font-weight: 500;
                            line-height: 10px;
                        }

                        > div {
                            position: relative;

                            span.fa {
                                position: absolute;
                                top: 50%;
                                left: 0%;
                                transform: translate(15px, -50%);
                            }
                        }
                    }

                    .form-group {
                        display: flex;
                        column-gap: 25px;
                    }

                    .checkbox-control {
                        display: flex;
                        align-items: center;
                        column-gap: 10px;
                    }

                    .form-control-btn {
                        display: flex;
                        align-items: center;
                        justify-content: flex-end;

                        button {
                            padding: 10px 25px;
                            font-size: 10px;
                            color: #fff;
                            background: #F2994A;
                            border: 0;
                            border-radius: 7px;
                            letter-spacing: .5px;
                            font-weight: 200;
                            cursor: pointer;
                        }
                    }
                }
            }

            .checkout-details {
                width: 25%;

                .checkout-details-inner {
                    background: darkviolet;
                    border-radius: 10px;
                    padding: 20px;



                    .checkout-lists {
                        display: flex;
                        flex-direction: column;
                        row-gap: 15px;
                        margin-bottom: 40px;

                        .card {
                            width: 100%;
                            display: flex;
                            column-gap: 15px;

                            .card-image {
                                width: 35%;

                                img {
                                    width: 100%;
                                    object-fit: fill;
                                    border-radius: 10px;
                                }
                            }

                            .card-details {
                                display: flex;
                                flex-direction: column;

                                .card-name {
                                    font-size: 12px;
                                    font-weight: 500;
                                }
                                .card-price {
                                    font-size: 14px;
                                    font-weight: 900;
                                    color: black;
                                    margin-top: 5px;

                                    span {
                                        color: #4E5150;
                                        text-decoration: line-through;
                                        margin-left: 10px;
                                    }
                                }
                                .card-wheel {
                                    margin-top: 17px;
                                    border: .2px solid #4e515085;
                                    width: 90px;
                                    padding: 8px 8px;
                                    border-radius: 10px;
                                    font-size: 12px;
                                    display: flex;
                                    justify-content: space-between;

                                    button {
                                        background: #E0E0E0;
                                        color: #828282;
                                        width: 15px;
                                        height: 15px;
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;
                                        border: 0;
                                        cursor: pointer;
                                        border-radius: 3px;
                                        font-weight: 500;
                                    }
                                }
                            }
                        }
                    }

                    .checkout-shipping, .checkout-total {
                        display: flex;
                        font-size: 20px;
                        padding: 5px 0px;
                        border-top: 1px solid #BDBDBD;
                        justify-content: space-between;

                        p {
                            font-size: 16px;
                            font-weight: 900;
                        }
                    }
                }
            }
        }

        footer {

            height: 5%;
            color: #BDBDBD;
            display: -ms-grid;
            display: grid;
            place-items: center;
            font-size: 12px;

            a {
                text-decoration: none;
                color: inherit;
            }

        }

    }

    @media screen and (max-width: 1024px) {
        body {
            width: 80%;

            main {
                column-gap: 70px;
            }
        }
    }

    @media screen and (max-width: 768px) {
        body {
            width: 92%;

            main {
                flex-direction: column-reverse;
                height: auto;
                margin-bottom: 50px;

                .checkout-form {
                    width: 100%;
                    margin-top: 35px;
                }

                .checkout-details {
                    width: 100%;
                }
            }

            footer {
                height: 10%;
            }
        }
    }
</style>