<?php
/* 
 * Update recurring payment
 * https://tech.payson.se/
 * 
 */

// Print wrapper
print('<div id="wrapper" style="width:100%;max-width:600px;margin:0 auto;">');
    
try {
    if (isset($_POST['paymentId'])) {
        $paymentId = $_POST['paymentId'];

        // Include library
        require_once '../paysonpayments/include.php';

        // Include TestAccount credentials
        require_once 'test-credentials.php';

        // Init the connector
        $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);

        // Create the client
        $recurringPaymentClient = new \Payson\Payments\RecurringPaymentClient($connector);

        // Get recurring payment
        $recurringPayment = $recurringPaymentClient->get(array('id' => $paymentId));

        // Print before update
        print('<h3 style="text-align:center;">Before update:</h3><hr />');
        print('<pre>' . print_r($recurringPayment, true) . '</pre>');
        
        // Decide what to update
        $change = '';
        if ($recurringPayment['status'] == 'readyToShip') {
            // Update status
            $recurringPayment['status'] = 'shipped';
            $change = 'Updated status to shipped';
        } elseif ($recurringPayment['status'] == 'shipped') {
            if ($recurringPayment['order']['items'][0]['creditedAmount'] < $recurringPayment['order']['items'][0]['totalPriceIncludingTax']) {
                $recurringPayment['order']['items'][0]['creditedAmount'] += 1;
                $change = 'Updated order[items][0][creditedAmount] to ' . $recurringPayment['order']['items'][0]['creditedAmount'];
            } else {
                $change = 'No update, order[items][0][creditedAmount] is already the same as order[items][0][totalPriceIncludingTax]';
            }
        }
       
        // Update payment
        $updatedRecurringPayment = $recurringPaymentClient->update($recurringPayment);
        
        // Print after update
        print('<h3 style="text-align:center;">After update:</h3><h5 style="text-align:center;">'. $change . '</h5><hr />');
        print('<pre>' . print_r($updatedRecurringPayment, true) . '</pre>');

    } else {
        throw new Exception('No payment ID found! Use <a href="index.php">index.php</a> ');
    }

} catch(Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}
// Close wrapper
print('</div>');