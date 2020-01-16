PHP Object Hydrator
===================
Class for fill private object attributes from array, and extract data from object

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require andrewdanilov/hydrator "~1.0.0"
```

or add

```
"andrewdanilov/hydrator": "~1.0.0"
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
