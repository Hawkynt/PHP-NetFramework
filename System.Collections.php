<?php

/**
 * System.Collections - Collection classes and interfaces
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System\Collections;

require_once 'System.Object.php';
require_once 'System.Exception.php';

/**
 * Defines a method to enumerate objects in a collection.
 */
interface IEnumerable
{
    /**
   * Returns an enumerator that iterates through a collection.
   * @return IEnumerator An enumerator object
   */
    public function GetEnumerator();
}
  
  /**
 * Supports a simple iteration over a generic collection.
 */
interface IEnumerator
{
    /**
   * Gets the element in the collection at the current position of the enumerator.
   * @return mixed The element at the current position
   */
    public function getCurrent();
    
    /**
   * Advances the enumerator to the next element of the collection.
   * @return bool true if the enumerator was successfully advanced; false if it has passed the end
   */
    public function MoveNext();
    
    /**
   * Sets the enumerator to its initial position, which is before the first element in the collection.
   */
    public function Reset();
}
  
  /**
 * Simple enumerator implementation for arrays.
 */
class ArrayEnumerator implements IEnumerator
{
    private $_array;
    private $_position;
    private $_keys;
    
    public function __construct($array){
      $this->_array = $array;
      $this->_keys = array_keys($array);
      $this->_position = -1;
  }
    
    public function getCurrent(){
      if($this->_position < 0 || $this->_position >= count($this->_keys)){
        throw new \System\InvalidOperationException("Enumeration has not started or has ended");
    }
      $key = $this->_keys[$this->_position];
      return $this->_array[$key];
  }
    
    public function MoveNext(){
      $this->_position++;
      return $this->_position < count($this->_keys);
  }
    
    public function Reset(){
      $this->_position = -1;
  }
}
  
  /**
 * Represents a collection of key/value pairs that are organized based on the hash code of the key.
 */
class Hashtable extends \System\BaseObject implements IEnumerable
{
    private $_data;
    private $_count;
    
    /**
   * Initializes a new, empty instance of the Hashtable class.
   */
    public function __construct(){
      parent::__construct();
      $this->_data = array();
      $this->_count = 0;
  }
    
    /**
   * Gets the number of key/value pairs contained in the Hashtable.
   * @return int The number of elements
   */
    public function getCount(){
      return $this->_count;
  }
    
    /**
   * Gets a collection containing the keys in the Hashtable.
   * @return array Collection of keys
   */
    public function Keys(){
      return array_keys($this->_data);
  }
    
    /**
   * Gets a collection containing the values in the Hashtable.
   * @return array Collection of values
   */
    public function Values(){
      return array_values($this->_data);
  }
    
    /**
   * Adds an element with the specified key and value into the Hashtable.
   * @param mixed $key The key of the element to add
   * @param mixed $value The value of the element to add
   */
    public function Add($key, $value){
      if($key === null){
        throw new \System\ArgumentNullException("key");
    }
      
      $hashKey = $this->_getHashKey($key);
      if(array_key_exists($hashKey, $this->_data)){
        throw new \System\ArgumentException("An item with the same key has already been added");
    }
      
      $this->_data[$hashKey] = $value;
      $this->_count++;
  }
    
    /**
   * Removes all elements from the Hashtable.
   */
    public function Clear(){
      $this->_data = array();
      $this->_count = 0;
  }
    
    /**
   * Determines whether the Hashtable contains a specific key.
   * @param mixed $key The key to locate
   * @return bool true if the key is found; otherwise, false
   */
    public function ContainsKey($key){
      if($key === null) return false;
      $hashKey = $this->_getHashKey($key);
      return array_key_exists($hashKey, $this->_data);
  }
    
    /**
   * Determines whether the Hashtable contains a specific value.
   * @param mixed $value The value to locate
   * @return bool true if the value is found; otherwise, false
   */
    public function ContainsValue($value){
      return in_array($value, $this->_data, true);
  }
    
    /**
   * Removes the element with the specified key from the Hashtable.
   * @param mixed $key The key of the element to remove
   * @return bool true if the element is successfully removed; otherwise, false
   */
    public function Remove($key){
      if($key === null) return false;
      
      $hashKey = $this->_getHashKey($key);
      if(array_key_exists($hashKey, $this->_data)){
        unset($this->_data[$hashKey]);
        $this->_count--;
        return true;
    }
      return false;
  }
    
    /**
   * Gets or sets the value associated with the specified key.
   * @param mixed $key The key
   * @return mixed The value associated with the key
   */
    public function get($key){
      if($key === null){
        throw new \System\ArgumentNullException("key");
    }
      
      $hashKey = $this->_getHashKey($key);
      if(!array_key_exists($hashKey, $this->_data)){
        return null;
    }
      return $this->_data[$hashKey];
  }
    
    /**
   * Sets the value associated with the specified key.
   * @param mixed $key The key
   * @param mixed $value The value to set
   */
    public function set($key, $value){
      if($key === null){
        throw new \System\ArgumentNullException("key");
    }
      
      $hashKey = $this->_getHashKey($key);
      $exists = array_key_exists($hashKey, $this->_data);
      $this->_data[$hashKey] = $value;
      
      if(!$exists){
        $this->_count++;
    }
  }
    
    /**
   * Returns an enumerator that iterates through the Hashtable.
   * @return IEnumerator An enumerator
   */
    public function GetEnumerator(){
      return new ArrayEnumerator($this->_data);
  }
    
    /**
   * Converts the Hashtable to a PHP array.
   * @return array PHP array representation
   */
    public function ToArray(){
      return $this->_data;
  }
    
    /**
   * Returns a string representation of the Hashtable.
   * @return string String representation
   */
    public function ToString(){
      return "Hashtable[Count=" . $this->_count . "]";
  }
    
    /**
   * Generates a hash key for the given key.
   * @param mixed $key The key to hash
   * @return string The hash key
   */
    private function _getHashKey($key){
      if(is_object($key) && method_exists($key, 'GetHashCode')){
        return $key->GetHashCode();
    }
      if(is_string($key) || is_numeric($key)){
        return (string)$key;
    }
      if(is_bool($key)){
        return $key ? "true" : "false";
    }
      if(is_array($key)){
        return md5(serialize($key));
    }
      return md5(serialize($key));
  }
}
