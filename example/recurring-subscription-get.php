<?php
/* 
 * Get subscription
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
        $recurringSubscriptionClient = new \Payson\Payments\RecurringSubscriptionClient($connector);

        // Get recurring subscription checkout
        $recurringSubscriptionCheckout = $recurringSubscriptionClient->get(array('id' => $subscriptionId));

        // Print checkout ID
        print('<h3 style="text-align:center;">Subscription ID: ' . $recurringSubscriptionCheckout['id'] . '</h3><hr />');

        // Print the checkout snippet
        print_r($recurringSubscriptionCheckout['snippet'], false);

        // Remove snippet for readability
        $recurringSubscriptionCheckout['snippet'] = '*Removed snippet for readability*';
        
        // Print entire response
        print('<hr /><h3 style="text-align:center;">Complete response:</h3>');
        print('<pre>' . print_r($recurringSubscriptionCheckout, true) . '</pre>');

    } else {
        throw new Exception('No subscription ID found! Use <a href="index.php">index.php</a> ');
    }
    
} catch(Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}
    
// Close wrapper
print('</div>');
