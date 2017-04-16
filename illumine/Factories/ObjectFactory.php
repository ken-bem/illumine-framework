<?php namespace WppFramework\Factories;
use Closure;
use Exception;
class ObjectFactory {

    /**
     * Class Constructor
     * @param  array $arguments
     */
    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($this->toObject($arguments) as $property => $argument) {
                if ($argument instanceOf Closure) {
                    $this->{$property} = $argument;
                } else {
                    $this->{$property} = $argument;
                }
            }
        }
    }

    /**
     * Convert an array into a stdClass()
     * @param   array
     * @return  object
     */
    private function toObject($properties)
    {
        return json_decode(json_encode($properties));
    }

    /**
     * Convert a object to an array
     * @param   object
     * @return  array
     */
    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }

    /**
     * Call Cast Function
     * @param  $method
     * @param  $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call($method, $arguments) {
        if (isset($this->{$method}) && is_callable($this->{$method})) {
            return call_user_func_array($this->{$method}, $arguments);
        } else {
            throw new Exception("Fatal error: Call to undefined method stdObject::{$method}()");
        }
    }
}