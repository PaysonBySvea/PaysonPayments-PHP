<?php
/* 
 * Update checkout
 * https://tech.payson.se/
 * 
 */

// Print wrapper
print('<div id="wrapper" style="width:100%;max-width:600px;margin:0 auto;">');
    
try {
    if (isset($_POST['checkoutId'])) {
        $checkoutId = $_POST['checkoutId'];

        // Include library
        require_once '../paysonpayments/include.php';

        // Include TestAccount credentials
        require_once 'test-credentials.php';

        // Init the connector
        $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);

        // Create the client
        $checkoutClient = new \Payson\Payments\CheckoutClient($connector);

        // Get checkout
        $currentCheckout = $checkoutClient->get(array('id' => $checkoutId));

        // Remove snippet for readability
        $currentCheckout['snippet'] = '*Removed snippet for readability*';
        
        // Print before update
        print('<h3 style="text-align:center;">Before update:</h3><hr />');
        print('<pre>' . print_r($currentCheckout, true) . '</pre>');

        // Update checkout
        $guiColorScheme = 'white';
        if ($currentCheckout['gui']['colorScheme'] == $guiColorScheme) {
            $guiColorScheme = 'blue';
        }
        $currentCheckout['gui']['colorScheme'] = $guiColorScheme;
        $updatedCheckout = $checkoutClient->update($currentCheckout);
        
        // Remove snippet
        $updatedCheckout['snippet'] = '*Removed snippet for readability*';
        
        // Print after update
        print('<h3 style="text-align:center;">After update:</h3><h5 style="text-align:center;">Updated gui[colorScheme] to '. $guiColorScheme . '</h5><hr />');
        print('<pre>' . print_r($updatedCheckout, true) . '</pre>');

    } else {
        throw new Exception('No checkout ID found! Use <a href="index.php">index.php</a> ');
    }

} catch(Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}
// Close wrapper
print('</div>');