PHP Object Hydrator
===================
Class for fill private object attributes from array, and extract data from object

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist andrewdanilov/hydrator "*"
```

or add

```
"andrewdanilov/hydrator": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Filling data array from object attributes:

```php
$object = new ExampleObject();

$hydrator = new \andrewdanilov\hydrator\Hydrator();

$data = $hydrator->extract($object, ['id', 'name']);
```

Filling object with data:

```php
$data = [
	'id' => $id,
	'name' => $name,
];

$hydrator = new \andrewdanilov\hydrator\Hydrator();

$object = $hydrator->hydrate(ExampleObject::class, $data);
```

Filling existing object with data:

```php
$object = new ExampleObject();

$data = [
	'id' => $id,
	'name' => $name,
];

$hydrator = new \andrewdanilov\hydrator\Hydrator();

$object = $hydrator->hydrateInto($object, $data);
```