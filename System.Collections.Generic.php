<?php

/**
 * System.Collections.Generic - Generic collection classes
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System\Collections\Generic;

require_once 'System.Object.php';
require_once 'System.Exception.php';
require_once 'System.Collections.php';
require_once 'System.Array.php';

/**
 * Represents a strongly typed list of objects that can be accessed by index.
 */
class GenericList extends \System\BaseObject implements \System\Collections\IEnumerable
{
    private $_items;
    private $_count;
    private $_capacity;
    
    /**
   * Initializes a new instance of the List class.
   * @param int $capacity The initial capacity
   */
    public function __construct($capacity = 4){
      parent::__construct();
      $this->_capacity = max(0, (int)$capacity);
      $this->_items = array();
      $this->_count = 0;
  }
    
    /**
   * Gets the number of elements in the List.
   * @return int The count
   */
    public function getCount(){
      return $this->_count;
  }
    
    /**
   * Gets the total number of elements the List can hold.
   * @return int The capacity
   */
    public function getCapacity(){
      return $this->_capacity;
  }
    
    /**
   * Sets the capacity of the List.
   * @param int $value The new capacity
   */
    public function setCapacity($value){
      $value = max(0, (int)$value);
      if($value < $this->_count){
        throw new \System\ArgumentOutOfRangeException("capacity", $value, "Capacity cannot be less than count");
    }
      $this->_capacity = $value;
  }
    
    /**
   * Gets the element at the specified index.
   * @param int $index The zero-based index
   * @return mixed The element at the specified index
   */
    public function get($index){
      if($index < 0 || $index >= $this->_count){
        throw new \System\ArgumentOutOfRangeException("index", $index, "Index out of range");
    }
      return $this->_items[$index];
  }
    
    /**
   * Sets the element at the specified index.
   * @param int $index The zero-based index
   * @param mixed $value The value to set
   */
    public function set($index, $value){
      if($index < 0 || $index >= $this->_count){
        throw new \System\ArgumentOutOfRangeException("index", $index, "Index out of range");
    }
      $this->_items[$index] = $value;
  }
    
    /**
   * Adds an object to the end of the List.
   * @param mixed $item The object to add
   */
    public function Add($item){
      $this->_ensureCapacity($this->_count + 1);
      $this->_items[$this->_count] = $item;
      $this->_count++;
  }
    
    /**
   * Adds the elements of the specified collection to the end of the List.
   * @param array|\System\Collections\IEnumerable $collection The collection to add
   */
    public function AddRange($collection){
      if(is_array($collection)){
        foreach($collection as $item){
          $this->Add($item);
      }
      } elseif($collection instanceof \System\Collections\IEnumerable){
        $enumerator = $collection->GetEnumerator();
        while($enumerator->MoveNext()){
          $this->Add($enumerator->getCurrent());
      }
      } else {
        throw new \System\ArgumentException("Collection must be an array or IEnumerable");
    }
  }
    
    /**
   * Removes all elements from the List.
   */
    public function Clear(){
      $this->_items = array();
      $this->_count = 0;
  }
    
    /**
   * Determines whether the List contains a specific value.
   * @param mixed $item The object to locate
   * @return bool true if item is found; otherwise, false
   */
    public function Contains($item){
      return $this->IndexOf($item) >= 0;
  }
    
    /**
   * Searches for the specified object and returns the zero-based index.
   * @param mixed $item The object to locate
   * @return int The zero-based index of item if found; otherwise, -1
   */
    public function IndexOf($item){
      for($i = 0; $i < $this->_count; $i++){
        if($this->_items[$i] === $item){
          return $i;
      }
    }
      return -1;
  }
    
    /**
   * Inserts an element into the List at the specified index.
   * @param int $index The zero-based index at which item should be inserted
   * @param mixed $item The object to insert
   */
    public function Insert($index, $item){
      if($index < 0 || $index > $this->_count){
        throw new \System\ArgumentOutOfRangeException("index", $index, "Index out of range");
    }
      
      $this->_ensureCapacity($this->_count + 1);
      
      // Shift elements to the right
      for($i = $this->_count; $i > $index; $i--){
        $this->_items[$i] = $this->_items[$i - 1];
    }
      
      $this->_items[$index] = $item;
      $this->_count++;
  }
    
    /**
   * Removes the first occurrence of a specific object from the List.
   * @param mixed $item The object to remove
   * @return bool true if item was successfully removed; otherwise, false
   */
    public function Remove($item){
      $index = $this->IndexOf($item);
      if($index >= 0){
        $this->RemoveAt($index);
        return true;
    }
      return false;
  }
    
    /**
   * Removes the element at the specified index.
   * @param int $index The zero-based index of the element to remove
   */
    public function RemoveAt($index){
      if($index < 0 || $index >= $this->_count){
        throw new \System\ArgumentOutOfRangeException("index", $index, "Index out of range");
    }
      
      // Shift elements to the left
      for($i = $index; $i < $this->_count - 1; $i++){
        $this->_items[$i] = $this->_items[$i + 1];
    }
      
      $this->_count--;
      unset($this->_items[$this->_count]);
  }
    
    /**
   * Reverses the order of the elements in the entire List.
   */
    public function Reverse(){
      $reversed = array();
      for($i = $this->_count - 1; $i >= 0; $i--){
        $reversed[] = $this->_items[$i];
    }
      $this->_items = $reversed;
  }
    
    /**
   * Sorts the elements in the entire List using the specified comparison.
   * @param callable $comparison The comparison function to use when comparing elements
   */
    public function Sort($comparison = null){
      if($this->_count <= 1) return;
      
      $items = array_slice($this->_items, 0, $this->_count);
      
      if($comparison === null){
        sort($items);
      } else {
        if(!is_callable($comparison)){
          throw new \System\ArgumentException("Comparison must be callable");
      }
        usort($items, $comparison);
    }
      
      $this->_items = $items;
  }
    
    /**
   * Copies the elements of the List to a new array.
   * @return array An array containing copies of the elements
   */
    public function ToArray(){
      return array_slice($this->_items, 0, $this->_count);
  }
    
    /**
   * Returns an enumerator that iterates through the List.
   * @return \System\Collections\IEnumerator An enumerator
   */
    public function GetEnumerator(){
      return new \System\Collections\ArrayEnumerator($this->ToArray());
  }
    
    /**
   * Returns a string representation of the List.
   * @return string String representation
   */
    public function ToString(){
      return "List[Count=" . $this->_count . "]";
  }
    
    /**
   * Ensures the list has enough capacity for the specified number of items.
   * @param int $min The minimum required capacity
   */
    private function _ensureCapacity($min){
      if($this->_capacity < $min){
        $newCapacity = $this->_capacity === 0 ? 4 : $this->_capacity * 2;
        if($newCapacity < $min) $newCapacity = $min;
        $this->setCapacity($newCapacity);
    }
  }
}

/**
 * Represents a collection of keys and values.
 */
class Dictionary extends \System\BaseObject implements \System\Collections\IEnumerable
{
    private $_keys;
    private $_values;
    private $_count;
    
    /**
   * Initializes a new instance of the Dictionary class.
   */
    public function __construct(){
      parent::__construct();
      $this->_keys = array();
      $this->_values = array();
      $this->_count = 0;
  }
    
    /**
   * Gets the number of key/value pairs in the Dictionary.
   * @return int The count
   */
    public function getCount(){
      return $this->_count;
  }
    
    /**
   * Gets a collection containing the keys in the Dictionary.
   * @return List A List containing the keys
   */
    public function getKeys(){
      $keyList = new GenericList();
      foreach($this->_keys as $key){
        $keyList->Add($key);
    }
      return $keyList;
  }
    
    /**
   * Gets a collection containing the values in the Dictionary.
   * @return List A List containing the values
   */
    public function getValues(){
      $valueList = new GenericList();
      foreach($this->_values as $value){
        $valueList->Add($value);
    }
      return $valueList;
  }
    
    /**
   * Gets the value associated with the specified key.
   * @param mixed $key The key whose value to get
   * @return mixed The value associated with the specified key
   */
    public function get($key){
      $index = $this->_findKey($key);
      if($index < 0){
        throw new \System\ArgumentException("The given key was not present in the dictionary");
    }
      return $this->_values[$index];
  }
    
    /**
   * Sets the value associated with the specified key.
   * @param mixed $key The key whose value to set
   * @param mixed $value The value to associate with the key
   */
    public function set($key, $value){
      $index = $this->_findKey($key);
      if($index >= 0){
        $this->_values[$index] = $value;
      } else {
        $this->Add($key, $value);
    }
  }
    
    /**
   * Adds the specified key and value to the Dictionary.
   * @param mixed $key The key of the element to add
   * @param mixed $value The value of the element to add
   */
    public function Add($key, $value){
      if($this->ContainsKey($key)){
        throw new \System\ArgumentException("An item with the same key has already been added");
    }
      
      $this->_keys[$this->_count] = $key;
      $this->_values[$this->_count] = $value;
      $this->_count++;
  }
    
    /**
   * Removes all keys and values from the Dictionary.
   */
    public function Clear(){
      $this->_keys = array();
      $this->_values = array();
      $this->_count = 0;
  }
    
    /**
   * Determines whether the Dictionary contains the specified key.
   * @param mixed $key The key to locate
   * @return bool true if the Dictionary contains an element with the key; otherwise, false
   */
    public function ContainsKey($key){
      return $this->_findKey($key) >= 0;
  }
    
    /**
   * Determines whether the Dictionary contains the specified value.
   * @param mixed $value The value to locate
   * @return bool true if the Dictionary contains an element with the value; otherwise, false
   */
    public function ContainsValue($value){
      for($i = 0; $i < $this->_count; $i++){
        if($this->_values[$i] === $value){
          return true;
      }
    }
      return false;
  }
    
    /**
   * Removes the value with the specified key from the Dictionary.
   * @param mixed $key The key of the element to remove
   * @return bool true if the element is successfully found and removed; otherwise, false
   */
    public function Remove($key){
      $index = $this->_findKey($key);
      if($index < 0) return false;
      
      // Shift elements left
      for($i = $index; $i < $this->_count - 1; $i++){
        $this->_keys[$i] = $this->_keys[$i + 1];
        $this->_values[$i] = $this->_values[$i + 1];
    }
      
      $this->_count--;
      unset($this->_keys[$this->_count]);
      unset($this->_values[$this->_count]);
      
      return true;
  }
    
    /**
   * Gets the value associated with the specified key.
   * @param mixed $key The key whose value to get
   * @param mixed &$value When this method returns, the value associated with the specified key, if found
   * @return bool true if the Dictionary contains an element with the specified key; otherwise, false
   */
    public function TryGetValue($key, &$value){
      $index = $this->_findKey($key);
      if($index >= 0){
        $value = $this->_values[$index];
        return true;
    }
      $value = null;
      return false;
  }
    
    /**
   * Returns an enumerator that iterates through the Dictionary.
   * @return \System\Collections\IEnumerator An enumerator
   */
    public function GetEnumerator(){
      $pairs = array();
      for($i = 0; $i < $this->_count; $i++){
        $pairs[] = array('Key' => $this->_keys[$i], 'Value' => $this->_values[$i]);
    }
      return new \System\Collections\ArrayEnumerator($pairs);
  }
    
    /**
   * Returns a string representation of the Dictionary.
   * @return string String representation
   */
    public function ToString(){
      return "Dictionary[Count=" . $this->_count . "]";
  }
    
    /**
   * Finds the index of the specified key.
   * @param mixed $key The key to find
   * @return int The index of the key, or -1 if not found
   */
    private function _findKey($key){
      for($i = 0; $i < $this->_count; $i++){
        if($this->_keys[$i] === $key){
          return $i;
      }
    }
      return -1;
  }
}

// Create aliases for backward compatibility (List is reserved in PHP 7.0+)
class_alias('System\\Collections\\Generic\\GenericList', 'System\\Collections\\Generic\\ListCollection');
class_alias('System\\Collections\\Generic\\GenericList', 'System\\Collections\\Generic\\List');
