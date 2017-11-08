About Application
=====

This is a sample application on how we can make a Laravel crud application without using any database. Use Csv instead for storing data. In this application I have created a client list for example.

Highlights
-------

You need PHP >= 7.0.10 and the mbstring extension to use Csv but the latest stable version of PHP is recommended.

Third Party libraries Used
-------

* Larevel 5.5 as framework
* league/csv to Read and Write to CSV documents 
* jenssegers/model to create Laravel eloquent-like model but not use database to store.
* Bootstrap v3.3.7 for front end

Third Party libraries Used
-------

Application is tested by PHPUnit. Test file included in test folder.To run the tests, run the following command from the project folder.

``` bash
$ phpunit
```

Install
-------

* Clone the repository
* Run `composer install` in the project folder
* Run `npm install` in the project folder
* Create a .env file and generate APP_KEY by command `php artisan key:generate`
* Final step run this command `php artisan serve` and go to URL: http://localhost:8000/clients
