<?php
/* 
 * Update subscription
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

        // Remove snippet for readability
        $recurringSubscriptionCheckout['snippet'] = '*Removed snippet for readability*';
        
        // Print before update
        print('<h3 style="text-align:center;">Before update:</h3><hr />');
        print('<pre>' . print_r($recurringSubscriptionCheckout, true) . '</pre>');

        // Update checkout
        $guiColorScheme = 'white';
        if ($recurringSubscriptionCheckout['gui']['colorScheme'] == $guiColorScheme) {
           $guiColorScheme = 'gray';
        }
        $recurringSubscriptionCheckout['gui']['colorScheme'] = $guiColorScheme;
        $updatedRecurringSubscriptionCheckout = $recurringSubscriptionClient->update($recurringSubscriptionCheckout);
        
        // Remove snippet
        $updatedRecurringSubscriptionCheckout['snippet'] = '*Removed snippet for readability*';
        
        // Print after update
        print('<h3 style="text-align:center;">After update:</h3><h5 style="text-align:center;">Updated gui[colorScheme] to '. $guiColorScheme . '</h5><hr />');
        print('<pre>' . print_r($updatedRecurringSubscriptionCheckout, true) . '</pre>');

    } else {
        throw new Exception('No subscription ID found! Use <a href="index.php">index.php</a> ');
    }

} catch(Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}
// Close wrapper
print('</div>');