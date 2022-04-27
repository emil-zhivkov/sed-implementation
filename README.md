#Php Sed

1.Install sed (stream editor)



##Install

Require the emil-zhivkov/sed-implementation package in your composer.json and update your dependencies:
```
composer require emil-zhivkov/sed-implementation
```

Add to config/app.php
```
 'providers' => [
    Zhivkov\SedImplementation\SedServiceProvider::class
 ]
```


##Usage

Console command
```
php artisan sed:substitution --search=keyword --replace=keyword --file=full_path_to_file
```
