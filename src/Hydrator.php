<?php

namespace andrewdanilov\hydrator;


/**
 * Hydrator can be used for two purposes:
 *
 * - To extract data from a class to be futher stored in a persistent storage.
 * - To instantiate a class having its data.
 *
 * In both cases it is saving and filling protected and private properties without calling
 * any methods which leads to ability to persist state of an object with properly incapsulated
 * data.
 */
class Hydrator
{
	/**
	 * Local cache of reflection class instances
	 *
	 * @var array
	 */
	private $reflectionClassMap = [];

	/**
	 * Creates an instance of a class filled with data according to it's pairs key => value,
	 * where the key represents object attribute name
	 *
	 * @param string $className
	 * @param array $data
	 * @return object
	 */
	public function hydrate($className, array $data)
	{
		$reflection = $this->getReflectionClass($className);
		$object = $reflection->newInstanceWithoutConstructor();
		foreach ($data as $propertyName => $propertyValue) {
			if (!$reflection->hasProperty($propertyName)) {
				throw new \InvalidArgumentException("There's no $propertyName property in $className.");
			}
			$property = $reflection->getProperty($propertyValue);
			$property->setAccessible(true);
			$property->setValue($object, $propertyValue);
		}
		return $object;
	}

	/**
	 * Fills an object passed with data array according to it's pairs key => value,
	 * where the key represents object attribute name
	 *
	 * @param object $object
	 * @param array $data
	 * @return object
	 */
	public function hydrateInto($object, array $data)
	{
		$className = get_class($object);
		$reflection = $this->getReflectionClass($className);
		foreach ($data as $propertyName => $propertyValue) {
			if (!$reflection->hasProperty($propertyName)) {
				throw new \InvalidArgumentException("There's no $propertyName property in $className.");
			}
			$property = $reflection->getProperty($propertyName);
			$property->setAccessible(true);
			$property->setValue($object, $propertyValue;
		}
		return $object;
	}

	/**
	 * Extracts data from an object according to $attributes list
	 *
	 * @param object $object
	 * @param array $attributes
	 * @return array
	 */
	public function extract($object, array $attributes)
	{
		$data = [];
		$className = get_class($object);
		$reflection = $this->getReflectionClass($className);
		foreach ($attributes as $propertyName) {
			if ($reflection->hasProperty($propertyName)) {
				$property = $reflection->getProperty($propertyName);
				$property->setAccessible(true);
				$data[$propertyName] = $property->getValue($object);
			}
		}
		return $data;
	}

	/**
	 * Returns instance of reflection class for class name passed
	 *
	 * @param string $className
	 * @return \ReflectionClass
	 * @throws \ReflectionException
	 */
	protected function getReflectionClass($className)
	{
		if (!isset($this->reflectionClassMap[$className])) {
			$this->reflectionClassMap[$className] = new \ReflectionClass($className);
		}
		return $this->reflectionClassMap[$className];
	}
}