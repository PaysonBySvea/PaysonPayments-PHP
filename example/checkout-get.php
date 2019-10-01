<?php
/* 
 * Get checkout
 * https://tech.payson.se/
 * 
 */

// Print wrapper
print('<div id="wrapper" style="width:100%;max-width:600px;margin:0 auto;">');
    
try {
    if (isset($_POST['checkoutId'])) {
        $checkoutId = $_POST['checkoutId'];

        // Include library
        require_once '../include.php';

        // Include TestAccount credentials
        require_once 'test-credentials.php';

        // Init the connector
        $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);

        // Create the client
        $checkoutClient = new \Payson\Payments\CheckoutClient($connector);

        // Get checkout
        $paysonCheckout = $checkoutClient->get(array('id' => $checkoutId));

        // Print checkout ID
        print('<h3 style="text-align:center;">Checkout ID: ' . $paysonCheckout['id'] . '</h3><hr />');

        // Print the checkout snippet
        print_r($paysonCheckout['snippet'], false);

        // Remove snippet for readability
        $paysonCheckout['snippet'] = '*Removed snippet for readability*';
        
        // Print entire response
        print('<hr /><h3 style="text-align:center;">Complete response:</h3>');
        print('<pre>' . print_r($paysonCheckout, true) . '</pre>');

    } else {
        throw new Exception('No checkout ID found! Use <a href="index.php">index.php</a> ');
    }

} catch(Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}
// Close wrapper
print('</div>');
