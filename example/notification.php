<?php
/* 
 * Handle notifications
 * https://tech.payson.se/
 * 
 * 
 * Payson will add query parameter checkout, subscription or payment to the notificationUri, e.g 
 * https://www.myexamplestore.nu/notification.php/?checkout=4ee4ab31-33bd-4a7e-8d80-a8ef0016265a
 * or
 * https://www.myexamplestore.nu/notification.php/?subscription=ccf49366-ea2d-410f-8bbf-a97b00912a37
 * or
 * https://www.myexamplestore.nu/notification.php/?payment=ccf49366-ea2d-410f-8bbf-a97b00912a37
 * 
 * Make sure the notificationUri is publicly accessible for notifications to work.
 * 
 * The POST to notificationUri expect a 200 OK in response and will keep on trying for up to 24 hours if the response is anything else.
 * 
 */

try {
    // Log to file notification-log.txt
    notificationLog('***Start notification***');
    notificationLog($_SERVER['REQUEST_URI']);
    
    // Get ID
    if (isset($_GET['checkout']) && $_GET['checkout'] != '') {
        // A checkout 2.0 notification should have a checkout query parameter
        $id = $_GET['checkout'];
    } elseif (isset($_GET['subscription']) && $_GET['subscription'] != '') {
        // A subscription notification should have a subscription query parameter
        $id = $_GET['subscription'];
    } elseif (isset($_GET['payment']) && $_GET['payment'] != '') {
        // A payment notification should have a payment query parameter
        $id = $_GET['payment'];
    } elseif (isset($_POST['checkoutId']) && $_POST['checkoutId'] != '') {
        // For simulating notification
        $id = $_POST['checkoutId'];
    } else {
        // Log to file notification-log.txt
        notificationLog('No checkout ID found');
            
        // Return 500 since we got no ID to work with
        returnResponse(500);
    }

    // Include library
    require_once '../include.php';

    // Include TestAccount credentials
    require_once 'test-credentials.php';

    // Init the connector
    $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);

    if (isset($_GET['ref']) && $_GET['ref'] == 'co2') {
        // Query parameter ref is for this example only
        // Handle Payson Checkout 2.0 notification
        // Create the client
        $checkoutClient = new \Payson\Payments\CheckoutClient($connector);

        // Get checkout
        $paysonCheckout = $checkoutClient->get(array('id' => $id));

        // Log to file notification-log.txt
        notificationLog('Checkout ID: ' . $id);
        notificationLog('Checkout status: ' . $paysonCheckout['status']);

        switch ($paysonCheckout['status']) {
            case 'readyToShip':
                // Take action, e.g create order

                // Return 200 to make the notifications stop
                returnResponse(200);
            case 'processingPayment':
                // Take action
                //Some time passes while payment is processed.

                // Return 200 OK
                returnResponse(200);
            case 'paidToAccount':
                // Take action, e.g mark order as paid

                // Return 200 OK
                returnResponse(200);
            case 'denied':
                // Take action, e.g mark order as unpaid

                // Return 200 OK
                returnResponse(200);
            case 'created':
            case 'readyToPay':
            case 'denied':
            case 'canceled':
            case 'expired':
            case 'shipped':
            case 'paidToAccount':
            default:
                // Return 200 OK
                returnResponse(200);
        }

    } elseif (isset($_GET['ref']) && $_GET['ref'] == 'prs') {
        // Query parameter ref is for this example only
        // Handle subscription notification
        // Create the client
        $recurringSubscriptionClient = new \Payson\Payments\RecurringSubscriptionClient($connector);

        // Get recurring subscription checkout
        $recurringSubscriptionCheckout = $recurringSubscriptionClient->get(array('id' => $id));

        // Log to file notification-log.txt
        notificationLog('Subscription ID: ' . $id);
        notificationLog('Subscription status: ' . $recurringSubscriptionCheckout['status']);

        switch ($recurringSubscriptionCheckout['status']) {
            case 'customerSubscribed':
                // Take action

                // Return 200 OK
                returnResponse(200);
            case 'customerUnsubscribed':
                // Take action

                // Return 200 OK
                returnResponse(200);
            case 'canceled':
            case 'expired':
            case 'created':
            case 'awaitingSubscription':
            default:
                // Return 200 OK
                returnResponse(200);
        }
        
    } elseif (isset($_GET['ref']) && $_GET['ref'] == 'prp') {
        // Query parameter ref is for this example only
        // Handle recurring payment notification
        // Create the client
        $recurringPaymentClient = new \Payson\Payments\RecurringPaymentClient($connector);

        // Get recurring payment
        $recurringPayment = $recurringPaymentClient->get(array('id' => $id));

        // Log to file notification-log.txt
        notificationLog('Payment ID: ' . $id);
        notificationLog('Payment status: ' . $recurringPayment['status']);

        switch ($recurringPayment['status']) {
            case 'readyToShip':
                // Take action

                // Return 200 OK
                returnResponse(200);
            case 'canceled':
            case 'expired':
            case 'created':
            case 'shipped':
            case 'paidToAccount':
            case 'denied':
            default:
                // Return 200 OK
                returnResponse(200);
        }

    } else {
        // Log to file notification-log.txt
        notificationLog('Unknown ref.');

        // Return 200 to make the notifications stop
        returnResponse(200);
    }
    
} catch(Exception $e) {
    // Log to file notification-log.txt
    notificationLog('Error: ' . $e->getMessage() . $e->getCode());
        
    // Return 500
    returnResponse(500);
}

function returnResponse($responseCode) {
    // Log to file notification-log.txt
    notificationLog('Response Code: ' .$responseCode);
        
    http_response_code($responseCode);
    echo http_response_code();
    exit();
}

function notificationLog($logMessage) {
    file_put_contents('./notification-log.txt', date("Y-m-d H:i:s") . ' ' . $logMessage . "\r\n", FILE_APPEND);
}
