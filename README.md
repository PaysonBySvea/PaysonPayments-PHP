### Payson Recurring Payments and Payson Checkout API client for PHP

####  Setup using [**Composer**](https://getcomposer.org/)
```bash
composer require payson/paysonpayments
```

####  Setup using include
```php
require_once 'include.php';
```

#### Create connector
```php
// Include library (without composer)
require_once 'include.php';

// Connect to test environment
$agentId = '4';
$apiKey = '2acab30d-fe50-426f-90d7-8c60a7eb31d4';
$apiUrl = \Payson\Payments\Transport\Connector::TEST_BASE_URL;
 
$connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);
```

#### Create Payson Checkout client
```php
$checkoutClient = new \Payson\Payments\CheckoutClient($connector);
```

#### Create Recurring Subscription client
```php
$recurringSubscriptionClient = new \Payson\Payments\RecurringSubscriptionClient($connector);
```

#### Create Recurring Payment client
```php
$recurringPaymentClient = new \Payson\Payments\RecurringPaymentClient($connector);
```

#### Example method: getAccountInfo()
```php
// getAccountInfo() can be used with all three clients
$accountInformation = $checkoutClient->getAccountInfo();

// Print the result
print('<pre>' . print_r($accountInformation, true) . '</pre>');
```

#### Methods
##### Payson Checkout (\Payson\Payments\CheckoutClient)
* getAccountInfo()
* create()
* get()
* update()
* listCheckouts()

##### Payson Recurring Subscription (\Payson\Payments\RecurringSubscriptionClient)
* getAccountInfo()
* create()
* get()
* update()
* listRecurringSubscriptions()

##### Payson Recurring Payment (\Payson\Payments\RecurringPaymentClient)
* getAccountInfo()
* create()
* get()
* update()
* listRecurringPayments()

#### Examples
See files in the examples folder for examples of all methods.

#### Documentation
Use [**Payson Checkout REST API**](https://tech.payson.se/paysoncheckout2/rest-api/) or [**Payson Recurring Payments REST API**](https://tech.payson.se/paysonrecurringpayments/recurring-payments-rest-api/) for more information about available parameters.

#### Test credentials
For instant access to our test environment simply create a [**Payson TestAccount**](https://test-www.payson.se/testaccount/create/) to get your own Agent ID and API Key.

#### Requirements
cURL
PHP >= 7.0

