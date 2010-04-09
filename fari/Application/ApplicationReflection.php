<?php if (!defined('FARI')) die();

/**
 * Fari Framework
 *
 * @copyright Copyright (c) 2008, 2010 Radek Stepan
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link      http://radekstepan.com
 * @category  Fari Framework
 */



/**
 * Method reflection determining parameters.
 *
 * @copyright Copyright (c) 2008, 2010 Radek Stepan
 * @package   Fari Framework\Application
 */
class Fari_ApplicationReflection {

    /** @var ReflectionMethod */
    private $method;

    /** @var array of parameters to call method with */
    private $parameters;

	/**
     * Construct Reflection.
     * @param $class
     * @param $method
	 */
    public function __construct($class, $method) {
        // create new ReflectionMethod object
        $this->method = new ReflectionMethod($class, $method);
 	}

	/**
     * Does method have parameters?
     * @return TRUE is method has at least 1 required parameter
	 */
    public function hasParameters() {
        $parameters = $this->method->getNumberOfRequiredParameters();
        return ($parameters > 0) ? TRUE : FALSE;
    }

	/**
     * Set parameters for a future call.
     * @param mixed $values
	 */
    public function setParameters($values) {
        // $values could be a string and the fastest is to:
        if (!is_array($values)) $values = array($values);

        // traverse the action's parameters
        $position = 0;
        foreach ($this->method->getParameters() as $parameter) {
            // traverse the array
            $value = @$values[$position++];
            // key 'name' => value 'is default available'
            $this->parameters[$parameter->getName()] = (isset($value)) ? $value : NULL;
        }
    }

	/**
     * Call a class reference method with set parameters.
     * @param $classInstance instantiated class name
	 */
    public function call($classInstance) {
        if (isset($this->parameters)) {
            $this->method->invokeArgs($classInstance, $this->parameters);
        } else {
            $this->method->invoke($classInstance);
        }
    }
	
}