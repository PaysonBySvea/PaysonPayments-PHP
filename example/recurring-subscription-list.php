<?php
/* 
 * List subscriptions
 * https://tech.payson.se/
 * 
 */

// Print wrapper
print('<div id="wrapper" style="width:100%;max-width:600px;margin:0 auto;">');
    
try {
    // Include library
    require_once '../paysonpayments/include.php';

    // Include TestAccount credentials
    require_once 'test-credentials.php';

    // Init the connector
    $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);

    // Create the client
    $recurringSubscriptionClient = new \Payson\Payments\RecurringSubscriptionClient($connector);

    // List data
    $data = array(
        'page' => 1,
        'status' => 'CustomerSubscribed'
    );
    
    // Get list of recurring subscriptions
    $recurringSubscriptions = $recurringSubscriptionClient->listRecurringSubscriptions($data);
    
    // Print entire response
    print('<pre>' . print_r($recurringSubscriptions, true) . '</pre>');
    
} catch(Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}

// Close wrapper
print('</div>');
    