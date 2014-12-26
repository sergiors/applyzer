Applyzer
--------

A simple way to invoke setters methods.

When you work with setters methods, is very boring call the setters methods every time;

If you work something similar as below:
```php
$user = new User();
$user
  ->setName($_POST['name'])
  ->setEmail($_POST['email']);
```

**Now, with the Applyzer, the code will look like this:**
```php
$user = new User();
(new Applyzer())
  ->add($_POST)
  ->apply($user);
```