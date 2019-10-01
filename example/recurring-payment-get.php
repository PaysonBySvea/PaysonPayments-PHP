<?php
/* 
 * Get recurring payment
 * https://tech.payson.se/
 * 
 */

// Print wrapper
print('<div id="wrapper" style="width:100%;max-width:600px;margin:0 auto;">');
    
try {
    if (isset($_POST['paymentId'])) {
        $paymentId = $_POST['paymentId'];

        // Include library
        require_once '../include.php';

        // Include TestAccount credentials
        require_once 'test-credentials.php';

        // Init the connector
        $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);

        // Create the client
        $recurringPaymentClient = new \Payson\Payments\RecurringPaymentClient($connector);

        // Get recurring payment
        $recurringPayment = $recurringPaymentClient->get(array('id' => $paymentId));

        // Print payment ID
        print('<h3 style="text-align:center;">Payment ID: ' . $recurringPayment['id'] . '</h3><hr />');


        // Print entire response
        print('<h3 style="text-align:center;">Complete response:</h3>');
        print('<pre>' . print_r($recurringPayment, true) . '</pre>');

    } else {
        throw new Exception('No payment ID found! Use <a href="index.php">index.php</a> ');
    }

} catch(Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}
    
// Close wrapper
print('</div>');
