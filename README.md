# Console Log Facade for Laravel 5.x

The JavaScript console is an invaluable tool to help develop and debug our apps. With the console object and its logging methods, long are the days of of calling alert() to debug and get a variable’s value. On top of that, thanks to a work in progress standard, modern browsers are
finally supporting the same set of methods.

### Requirements
- PHP 7.0 or higher
- Laravel 5.0 or higher

### Installation
```
composer require arcostasi/console-log
```

And now you can publish your config:
```
php artisan vendor:publish --provider="Arcostasi\ConsoleLog\ConsoleLogServiceProvider"
```

Add to `config/app.php`
```php
'providers' => [
  ...
  Arcostasi\ConsoleLog\Providers\ConsoleLogServiceProvider::class,

'aliases' => [
  ...
  'Console' => Arcostasi\ConsoleLog\Facades\Console::class,
```

## Usage
Add in your blade view template:
```html
<!-- Console log scripts -->
@if(Session::has('console.log'))
<script>
    @foreach(Session::get('console.log') as $console)
    {!! $console !!}
    @endforeach
</script>
{{ Session::forget('console.log') }}
@endif
```

and add Console facade in your PHP files (controllers or models):
```php
use Console;
```

### Logging
Console::Log is the usual method we use to log values out to the console:
```php
Console::Log("Hello\nConsole!!!");      // Displays as text with break line
Console::Log(2 + (2 * 3));              // Calculates the number and prints the result as text
Console::Log(new \DateTime());          // Displays as an Object
Console::Log(\App\Models\User::all());  // Displays as an Array
```
But we also have access to more logging methods like warn, info and error:
```php
Console::Warn('This is an example of WARNING!!');
Console::Info('This is an example of INFO!');
Console::Error('This is an example of ERROR!!! Boom 💣');
```
As you can see from the resulting console output, using the warn or error methods also gives us a stack trace:

<img src="https://github.com/arcostasi/console-log/blob/master/img/logging-methods.png?raw=true" width="600">

You can also prints out objects with Debug method:
```php
use App\Models\User;
use Console;
  ...

Console::Debug(User::all());
```
or you can also trigger a stack trace with Trace method:
```php
use App\Models\User;
use Console;
  ...

Console::Trace(User::all());
```

### Table
If you feel so inclined, you can even display data in the console more neatly in a table format using Table method:
```php
use App\Models\User;
use Console;
  ...

Console::Table(User::all(['name', 'email']));
```
As you can see from the resulting console output, using the Table method:

<img src="https://github.com/arcostasi/console-log/blob/master/img/table.png?raw=true" width="600">

### Dir & DirXML
Console Dir and DirXML prints out objects in a nice formatted way:
```php
<?php
use Console;
  ...

$text = 'hello';

// This is a example with heredoc
$html = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- ... -->
</head>

<body>
  <h1>$text</h1>

  <script>
    console.dirxml(document.body);
  </script>
</body>

</html>
HTML;

Console::DirXML($html);
```
As you can see from the resulting console output, using the dirxml method:

<img src="https://github.com/arcostasi/console-log/blob/master/img/dirxml.png?raw=true" width="600">

### Clearing
You can clear the console with Clear method:
```php
Console::Clear();
```

### Asserting
The Assert method is an easy way to run simple assertion tests:
```php
Console::Assert(2 == '2', '2 not == to "2"'); // this will pass, nothing will be logged
Console::Assert(3 === '3', '3 not === to "3"'); // this fails, '3 not === to "3"' will be logged
```

### Counting
The Count method is used to count the number of times it has been invoked with the same provided label.
```php
for ($i = 1; $i <= 5; $i++) {
    if ($i % 2 === 0) {
        Console::Count('even');
    } else {
        Console::Count('odd');
    }
}
```

Result from console output:
```plain
// odd: 1
// even: 1
// odd: 2
// even: 2
// odd: 3
```

### Timing
As we’ve showed in this short post, you can start a timer with Time method and then end it with EndTime methos. Optionally the time can have a label:
```php
use Console;

Console::Time('fetching data');

$client = new \GuzzleHttp\Client();
$result = $client->get('https://api.github.com/user', ['auth' =>  ['user', 'pwd']]);

Console::Log("Status: {$result->getStatusCode()}"); // Status 200
Console::Log($result->getBody()->toArray());        // Object result

Console::TimeEnd('fetching data');
```

Result from console output:
```json
Status: 200
▼ Object
  name: "Anderson Costa"
  url: "https://api.github.com/users/arcostasi"
  blog: "https://arcostasi.github.com"
  avatar_url: "https://avatars0.githubusercontent.com/u/5041497?v=4"
  bio: "Software Developer"
  company: "AR2 Tecnologia"
  email: "arcostasi@gmail.com"
  created_at: "2013-07-18T18:04:44Z"
  ...
dashboard:397 fetching data: 0.264892578125ms
```

### Grouping
Use Group and GroupEnd methods to group console messages together with an optional label.
Notice also how a group can be nested into another one:
```php
Console::Group('🖍️ colors');
Console::Log('red');
Console::Log('orange');
Console::Group('HEX');
Console::Log('#FF4C89');
Console::Log('#7186FE');
Console::GroupEnd();
Console::Log('blue');
Console::GroupEnd();
```
Result from console output:

<img src="https://github.com/arcostasi/console-log/blob/master/img/group.png?raw=true" width="600">

## Credits
- alligator.io ([@alligatorio](https://twitter.com/alligatorio)) A Look at the JavaScript Console API: https://alligator.io/js/console/

## Licence
This library is signed under MIT License, Reproduce under it's terms.
