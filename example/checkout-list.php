<?php
/* 
 * List checkouts
 * https://tech.payson.se/
 * 
 */

// Print wrapper
print('<div id="wrapper" style="width:100%;max-width:600px;margin:0 auto;">');
    
try {
    // Include library
    require_once '../include.php';

    // Include TestAccount credentials
    require_once 'test-credentials.php';

    // Init the connector
    $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);

    // Create the client
    $checkoutClient = new \Payson\Payments\CheckoutClient($connector);

    // List data
    $data = array(
        'page' => 1,
        'status' => 'readyToShip'
    );
    
    // Get list of checkouts
    $checkouts = $checkoutClient->listCheckouts($data);
    
    // Print entire response
    print('<pre>' . print_r($checkouts, true) . '</pre>');
    
} catch(Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}

// Close wrapper
print('</div>');
