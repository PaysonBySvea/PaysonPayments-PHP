<?php
/* 
 * Create checkout
 * https://tech.payson.se/
 * 
 */

try {
    // Include library
    require_once '../include.php';
    
    // Include TestAccount credentials
    require_once 'test-credentials.php';

    // Init the connector
    $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);

    // Create the client
    $checkoutClient = new \Payson\Payments\CheckoutClient($connector);

    // Get protocol for URLs
    $protocol = 'http://';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $protocol = 'https://';
    }
    
    // Checkout data
    $checkoutData = array(
        'customer' => array(
            'city' => 'Stan',
            'identityNumber' => '4605092222',
            'email' => 'tess.t.persson@test.se',
            'firstName' => 'Tess T',
            'lastName' => 'Persson',
            'postalCode' => '99999',
            'street' => 'Testgatan 1'
        ),
        'order' => array(
            'currency' => 'sek',
            'items' => array(
                array(
                    'name' => 'Product 1',
                    'quantity' => 1.00,
                    'unitPrice' => 99.00,
                    'taxRate' => 0.25
                ),
                array(
                    'name' => 'Product 2',
                    'quantity' => 2.00,
                    'unitPrice' => 299.00,
                    'taxRate' => 0.25
                )
            )
        ),
        'merchant' => array(
            'termsUri' => str_replace(basename($_SERVER['PHP_SELF']), 'terms.php', $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']),
            'checkoutUri' => "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            'confirmationUri' => str_replace(basename($_SERVER['PHP_SELF']), 'confirmation.php', $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . '?ref=co2',
            'notificationUri' => str_replace(basename($_SERVER['PHP_SELF']), 'notification.php', $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . '?ref=co2'
        ),
        'gui' => array(
            'colorScheme' => 'White',
            'locale' => 'sv'
        )
    );

    // Create checkout
    $paysonCheckout = $checkoutClient->create($checkoutData);
    
    // Save checkout ID (token) in cookie for use on confirmation page
    setcookie('checkoutId', $paysonCheckout['id'], time()+60*60*24*365 , '/', ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false, false);
    
    // Print wrapper
    print('<div id="wrapper" style="width:100%;max-width:600px;margin:0 auto;">');
    
    // Print checkout ID
    print('<h3 style="text-align:center;">Checkout ID: ' . $paysonCheckout['id'] . '</h3><hr />');
    
    // Print the checkout snippet
    print_r($paysonCheckout['snippet'], false);

    // Print entire response
    print('<hr /><h3 style="text-align:center;">Complete response:</h3>');
    print('<pre>' . print_r($paysonCheckout, true) . '</pre>');
    
    // Close wrapper
    print('</div>');

} catch(Exception $e) {
    // Print error message and error code
    print($e->getMessage() . $e->getCode());
}
