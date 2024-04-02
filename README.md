                                Logviewer Package

Logviewer is a Laravel package that provides a log viewing functionality for your Laravel applications.

Installation

You can install the Logviewer package via Composer:

composer require logviewer/logviewer

Configuration

After installing the Logviewer package, you need to publish its configuration file using the following artisan command:

php artisan vendor:publish --provider="Logviewer\Logviewer\LogServiceProvider"

This will publish the configuration file to config/logviewer.php.

Usage

Once the package is installed and configured, you can use the log viewing functionality by accessing the /log-viewer route in your Laravel application.

It redirect to login page 

Login Credentials

Email : sparkout@123.com

Password : Sparkout@123

Contributing

Thank you for considering contributing to the Logviewer package! Please feel free to submit bug reports, feature requests, or pull requests.

License

The Logviewer package is open-source software licensed under the MIT license.


