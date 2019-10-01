<?php
/* 
 * Create recurring payment
 * https://tech.payson.se/
 * 
 */

// Print wrapper
print('<div id="wrapper" style="width:100%;max-width:600px;margin:0 auto;">');
    
try {
    if (isset($_POST['subscriptionId'])) {
        $subscriptionId = $_POST['subscriptionId'];
        
        // Include library
        require_once '../include.php';

        // Include TestAccount credentials
        require_once 'test-credentials.php';

        // Init the connector
        $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);

        // Create the client
        $recurringPaymentClient = new \Payson\Payments\RecurringPaymentClient($connector);
        
        // Get protocol for URLs
        $protocol = 'http://';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $protocol = 'https://';
        }
        
        // Recurring payment data
        $recurringPaymentData = array(
            'subscriptionid' => $subscriptionId,
            'notificationUri' => str_replace(basename($_SERVER['PHP_SELF']), 'notification.php', $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . '?ref=prp',
            'order' => array(
                'currency' => 'sek',
                'items' => array(
                    array (
                       'name' => 'Produkt 1',
                       'unitPrice' => 150.00,
                       'quantity' => 1.0,
                       'taxRate' => 0.25,
                    )
                )
             )
        );
        
        // Create recurring payment
        $recurringPayment = $recurringPaymentClient->create($recurringPaymentData);
        
        // Print checkout ID
        print('<h3 style="text-align:center;">Payment ID: ' . $recurringPayment['id'] . '</h3>');
        print('<h3 style="text-align:center;">Subscription ID: ' . $recurringPayment['subscriptionId'] . '</h3><hr />');

        // Print entire response
        print('<h3 style="text-align:center;">Complete response:</h3>');
        print('<pre>' . print_r($recurringPayment, true) . '</pre>');
        
    } else {
        throw new Exception('No subscription ID found! Use <a href="index.php">index.php</a>');
    }
    
} catch (Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}
    
// Close wrapper
print('</div>');
