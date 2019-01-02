<?php
/* 
 * List recurring payments
 * https://tech.payson.se/
 * 
 */

// Print wrapper
print('<div id="wrapper" style="width:100%;max-width:600px;margin:0 auto;">');
    
try {
    if (isset($_POST['subscriptionId'])) {
        $subscriptionId = $_POST['subscriptionId'];

        // Include library
        require_once '../paysonpayments/include.php';

        // Include TestAccount credentials
        require_once 'test-credentials.php';

        // Init the connector
        $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);

        // Create the client
        $recurringPaymentClient = new \Payson\Payments\RecurringPaymentClient($connector);

        // List data
        $data = array(
            'subscriptionId' => $subscriptionId,
            'page' => 1
        );
        
        // Get recurring payments
        $recurringPayments = $recurringPaymentClient->listRecurringPayments($data);

        // Print entire response
        print('<pre>' . print_r($recurringPayments, true) . '</pre>');

    } else {
        throw new Exception('No subscription ID found! Use index.php ');
    }
    
} catch(Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}

// Close wrapper
print('</div>');
    