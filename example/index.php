<?php
/* 
 * Examples
 * https://tech.payson.se/
 *
 */
?>

<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
        <style>
            html{font-family:'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}
            body{margin:20px;font-size:14px;line-height:1.42857143;color:#333;background-color:#fff}
            .container{margin:20px 0;}
            button{margin:5px 0 0 0;}
        </style>
    </head>
    <body>
        <h3>Account</h3>
        <div class="container">
            <a href="account-info.php" target="_blank">Get account information »</a>
        </div>
        <div class="container">
           <hr />
        </div>
        <h3>Payson Checkout 2.0</h3>
        <div class="container">
            <a href="checkout-list.php" target="_blank">List checkouts »</a>
        </div>
        <div class="container">
            <a href="checkout-create.php" target="_blank">Create checkout »</a>
        </div>
        <div class="container">
            Get checkout<br />
            <form method="post" action="checkout-get.php" target="_blank">
                <input type="text" placeholder="Enter Checkout ID" name="checkoutId" size=40 value="" /><br />
                <button type="submit">Get checkout »</button>
            </form>
        </div>
        <div class="container">
            Update checkout<br />
            <form method="post" action="checkout-update.php" target="_blank">
                <input type="text" placeholder="Enter Checkout ID" name="checkoutId" size=40 value="" /><br />
                <button type="submit">Update checkout »</button>
            </form>
        </div>
        <div class="container">
            Simulate notification<br />
            <form method="post" action="notification.php?ref=co2" target="_blank">
                <input type="text" placeholder="Enter Checkout ID" name="checkoutId" size=40 value="" /><br />
                <button type="submit">Simulate notification »</button>
            </form>
        </div>
        <div class="container">
           <hr />
        </div>
        <h3>Payson Recurring Subscriptions</h3>
        <div class="container">
            <a href="recurring-subscription-list.php" target="_blank">List subscriptions »</a>
        </div>
        <div class="container">
            <a href="recurring-subscription-create.php" target="_blank">Create subscription »</a>
        </div>
        <div class="container">
            Get subscription<br />
            <form method="post" action="recurring-subscription-get.php" target="_blank">
                <input type="text" placeholder="Enter Subscription ID" name="subscriptionId" size=40 value="" /><br />
                <button type="submit">Get subscription »</button>
            </form>
        </div>
        <div class="container">
            Update subscription<br />
            <form method="post" action="recurring-subscription-update.php" target="_blank">
                <input type="text" placeholder="Enter Subsciption ID" name="subscriptionId" size=40 value="" /><br />
                <button type="submit">Update subscription »</button>
            </form>
        </div>
        <div class="container">
            Simulate notification<br />
            <form method="post" action="notification.php?ref=prs" target="_blank">
                <input type="text" placeholder="Enter Subscription ID" name="checkoutId" size=40 value="" /><br />
                <button type="submit">Simulate notification »</button>
            </form>
        </div>
        <div class="container">
            &nbsp;
        </div>
        <h3>Payson Recurring Payments</h3>
        <div class="container">
            List payments<br />
            <form method="post" action="recurring-payment-list.php" target="_blank">
                <input type="text" placeholder="Enter Subscription ID" name="subscriptionId" size=40 value="" /><br />
                <button type="submit">List payments »</button>
            </form>
        </div>
        <div class="container">
            Create payment<br />
            <form method="post" action="recurring-payment-create.php" target="_blank">
                <input type="text" placeholder="Enter Subscription ID" name="subscriptionId" size=40 value="" /><br />
                <button type="submit">Create payment »</button>
            </form>
        </div>
        <div class="container">
            Get payment<br />
            <form method="post" action="recurring-payment-get.php" target="_blank">
                <input type="text" placeholder="Enter Payment ID" name="paymentId" size=40 value="" /><br />
                <button type="submit">Get payment »</button>
            </form>
        </div>
        <div class="container">
            Update payment<br />
            <form method="post" action="recurring-payment-update.php" target="_blank">
                <input type="text" placeholder="Enter Payment ID" name="paymentId" size=40 value="" /><br />
                <button type="submit">Update payment »</button>
            </form>
        </div>
        <div class="container">
            Simulate notification<br />
            <form method="post" action="notification.php?ref=prp" target="_blank">
                <input type="text" placeholder="Enter Payment ID" name="checkoutId" size=40 value="" /><br />
                <button type="submit">Simulate notification »</button>
            </form>
        </div>
        <div class="container">
            &nbsp;
        </div>
    </body>
</html>
