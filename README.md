# Console Log Facade for Laravel 5.x

The JavaScript console is an invaluable tool to help develop and debug our apps. With the console object and its logging methods, long are the days of of calling alert() to debug and get a variable’s value. On top of that, thanks to a work in progress standard, modern browsers are
finally supporting the same set of methods.

### Requirements
- PHP >= 7.*
- Laravel 5.*

### Installation
```
composer require arcostasi/console-log
```
Add to `config/app.php`
```
'providers' => [
  ...
  Arcostasi\ConsoleLog\Providers\ConsoleLogServiceProvider::class,
```

# Usage
Dependencies:
```
use Arcostasi\Facades\Console;
```

### Logging

Console::Log is the usual method we use to log values out to the console:
```
Console::Log('Hello World!!!\n');
```
But we also have access to more logging methods like warn, info and error:
```
Console::Info('This is a information');
Console::Warn('This is a warning');
Console::Error('This is a error');
```
