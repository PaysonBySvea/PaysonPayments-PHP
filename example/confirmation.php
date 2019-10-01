<?php
/* 
 * Confirmation page
 * https://tech.payson.se/
 * 
 * 
 */

// Print wrapper
print('<div id="wrapper" style="width:100%;max-width:600px;margin:0 auto;">');
        
try {
    if (isset($_COOKIE['checkoutId']) && $_COOKIE['checkoutId'] != '') {
        $checkoutId = $_COOKIE['checkoutId'];
        
        // Reset cookie
        unset($_COOKIE['checkoutId']);
        setcookie('checkoutId', '', time()-60*60*24*365 , '/', ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false, false);
        
        // Include library
        require_once '../include.php';

        // Include TestAccount credentials
        require_once 'test-credentials.php';
        
        // Init the connector
        $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);
    
        if (isset($_GET['ref']) && $_GET['ref'] == 'co2') {
            // Query parameter ref is for this example only
            // Handle Payson Checkout 2.0 confirmation
            // Create the client
            $checkoutClient = new \Payson\Payments\CheckoutClient($connector);
            
            // Get checkout
            $paysonCheckout = $checkoutClient->get(array('id' => $checkoutId));
            
            switch ($paysonCheckout['status']) {
                case 'readyToShip':
                    // Print checkout ID
                    print('<h3 style="text-align:center;">Checkout ID: ' . $paysonCheckout['id'] . '</h3><hr />');
                    
                    // Print the checkout snippet
                    print_r($paysonCheckout['snippet'], false);
                    break;
                case 'created':
                case 'readyToPay':
                case 'denied':
                case 'canceled':
                case 'expired':
                case 'shipped':
                case 'paidToAccount':
                case 'denied':
                default:
                    throw new Exception('Unable to show confirmation! Status: ' . $paysonCheckout['status']);
            }
            
            // Print entire response
            print('<hr /><h3 style="text-align:center;">Complete response:</h3>');
            print('<pre>' . print_r($paysonCheckout, true) . '</pre>');

        } elseif (isset($_GET['ref']) && $_GET['ref'] == 'prs') {
            // Query parameter ref is for this example only
            // Handle subscription confirmation
            // Create the client
            $recurringSubscriptionClient = new \Payson\Payments\RecurringSubscriptionClient($connector);
            
            // Get recurring subscription checkout
            $recurringSubscriptionCheckout = $recurringSubscriptionClient->get(array('id' => $checkoutId));
            
            switch ($recurringSubscriptionCheckout['status']) {
                case 'customerSubscribed':
                    // Print recurring subscription checkout ID
                    print('<h3 style="text-align:center;">Subscription ID: ' . $recurringSubscriptionCheckout['id'] . '</h3><hr />');
                    
                    // Print the recurring subscription checkout snippet
                    print_r($recurringSubscriptionCheckout['snippet'], false);
                    break;
                case 'created':
                case 'awaitingSubscription':
                case 'customerUnsubscribed':
                case 'canceled':
                case 'expired':
                default:
                    throw new Exception('Unable to show confirmation! Status: ' . $recurringSubscriptionCheckout['status']);
            }
            
            // Print entire response
            print('<hr /><h3 style="text-align:center;">Complete response:</h3>');
            print('<pre>' . print_r($recurringSubscriptionCheckout, true) . '</pre>');

        } else {
            throw new Exception('Unknown ref! ');
        }
    } else {
        throw new Exception('No cookie with ID found! Use <a href="index.php">index.php</a> ');
    }
    
} catch(Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}

// Close wrapper
print('</div>');
