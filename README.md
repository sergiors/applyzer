Applyzer
--------

A simple way to invoke setter methods.

When you work with setter methods, is very boring call the setter methods every time;

If you work something similar as below:
```php
$user = new User();
$user
  ->setName($_POST['name'])
  ->setEmail($_POST['email']);
```

Now, with the Applyzer, the code will look like this:
```php
$user = new User();
$user = (new Applyzer())->apply($_POST, $user);
```

Installation
------------
You can install with Composer

```sh
php composer.phar require sergiors/applyzer "~1.0"
```

License
-------
Licensed under the MIT License.
