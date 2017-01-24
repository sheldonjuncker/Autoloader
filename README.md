# Autoloader
This is what I believe to be an implementation of a PSR-4 compatible autoloader.
However, I don't have the expertise to guarantee that it is indeed fully PSR-4 compliant.
I created this to learn more about Autoloading, and I've used it in some of my own projects.
Use it at your own risk!

##Example
```php
//Create a new autoloader instance
$autoloader = new Autoloader();

//Add a single prefix => directory mapping
$autoloader->addPrefix("Abc\\Def", __DIR__ . "/classes/Abc/Def");

//Add multiple mappings at once
$autoloader->addPrefixes("Abc\\Def", [
	__DIR__ . "/classes/Abc/Def",
	__DIR__ . "otherLocation/Abc/Def"
]);

//Register the autoloader with SPL
$autoloader->register();

//It will now find your classes!
use Abc\Def\Ghi;
$ghi = new Ghi;
```