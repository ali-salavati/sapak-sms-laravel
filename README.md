# Sapak SMS - Laravel Adapter

This package is an **unofficial** Laravel adapter for the [Sapak SMS API](https://docs.sapak.me/).

It provides a clean, "Laravel-way" integration for the core [sapak-sms-php (Core SDK)](https://github.com/ali-salavati/sapak-sms), automatically registering the `SapakClient` in the Service Container and providing a Facade for easy access.

## Table of Contents

1. [Installation](https://www.google.com/search?q=%231-installation)

2. [Configuration (Required)](https://www.google.com/search?q=%232-configuration-required)

3. [Usage](https://www.google.com/search?q=%233-usage)

   * [A) Using the Facade (Easy Method)](https://www.google.com/search?q=%23a-using-the-facade-easy-method)

   * [B) Using Dependency Injection (DI)](https://www.google.com/search?q=%23b-using-dependency-injection-di)

4. [Calling Core SDK Methods](https://www.google.com/search?q=%234-calling-core-sdk-methods)

5. [Contributing](https://www.google.com/search?q=%235-contributing)

6. [License](https://www.google.com/search?q=%236-license)

## 1. Installation

You can install the package via Composer:

```
composer require salavati/sapak-sms-laravel
```

Thanks to Laravel's Auto-Discovery, the Service Provider and Facade will be registered automatically.

## 2. Configuration (Required)

The only setup required is setting your API key.

### A) Publish the Config File

First, publish the `config/sapak.php` configuration file:

```
php artisan vendor:publish --provider="Sapak\\Sms\\Laravel\\SapakServiceProvider"
```

This will create a new file at `config/sapak.php`.

### B) Set API Key in `.env`

Open your `.env` file and add your API key (obtained from the Sapak panel):

```
SAPAK_API_KEY="YOUR_API_KEY_HERE"
```

The package automatically reads this variable via the `config/sapak.php` file.

## 3. Usage

This package registers the `SapakClient` as a **Singleton** in the Service Container. You can access it in two idiomatic "Laravel ways":

### A) Using the Facade (Easy Method)

You can use the `Sapak` Facade for static-like access.

```php
use Sapak\Sms\Laravel\SapakFacade as Sapak;
// Or alias it in config/app.php to just `use Sapak;`

Route::get('/test-sms', function () {
    try {
        $creditDto = Sapak::account()->getCredit();
        return "Your credit is: " . $creditDto->credit;
    } catch (\Sapak\Sms\Exceptions\AuthenticationException $e) {
        return "API Key is wrong: " . $e->getMessage();
    }
});
```

### B) Using Dependency Injection (DI)

This is the 'cleaner' and preferred method for use in controllers or service classes. Laravel will automatically inject the `SapakClient`.

```php
use Sapak\Sms\SapakClient;
use Sapak\Sms\Exceptions\ApiException;

class SmsNotificationService
{
    // Laravel automatically injects the client from the container
    public function __construct(
        private SapakClient $client
    ) {}

    public function getBalance(): float
    {
        try {
            return $this->client->account()->getCredit()->credit;
        } catch (ApiException $e) {
            return 0.0;
        }
    }
}
```

## 4. Calling Core SDK Methods

This package is just a bridge. All core logic (sending messages, checking status, finding messages) resides in the [sapak-sms-php (Core SDK)](https://www.google.com/search?q=https://github.com/YOUR_USERNAME/sapak-sms-php).

For a complete list of methods and their required DTOs, please read the [**Core Package Documentation**](https://www.google.com/search?q=https://github.com/YOUR_USERNAME/sapak-sms-php/blob/main/README.md).

**Example (Sending a Message):**

```php
use Sapak\Sms\Laravel\SapakFacade as Sapak;
use Sapak\Sms\DTOs\Requests\SendMessage; // <-- DTO comes from the core package

// ...

$message = new SendMessage(
    from: config('services.sapak.sender_number'), // Your sender number
    to: ['98912...'],
    text: 'Hello from Laravel!'
);

$results = Sapak::messages()->send($message);

echo "Message ID: " . $results[0]-\>id;
```

## 5. Contributing

Contributions are welcome. Please open a Pull Request on the GitHub repository.

## 6. License

This package is open-source software licensed under the MIT license.
