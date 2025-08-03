<?php

/**
 * System.Array - Enhanced array class with LINQ-like methods
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System;

require_once 'System.Object.php';
require_once 'System.Exception.php';
require_once 'System.Collections.php';

/**
 * Enhanced array class that provides .NET-style array functionality with LINQ-like operations.
 */
class ArrayCollection extends BaseObject implements \System\Collections\IEnumerable
{
    private $_data;
    
    /**
   * Initializes a new instance of the Array class.
   * @param array $data Initial data for the array
   */
    public function __construct($data = array()){
      if(is_array($data)){
        $this->_data = array_values($data); // Ensure numeric indices
      } else {
        $this->_data = func_get_args();
    }
  }
    
    /**
   * Gets the number of elements in the array.
   * @return int The number of elements
   */
    public function getCount(){
      return count($this->_data);
  }
    
    /**
   * Gets the element at the specified index.
   * @param int $index The zero-based index
   * @return mixed The element at the specified index
   */
    public function get($index){
      if($index < 0 || $index >= count($this->_data)){
        throw new ArgumentOutOfRangeException("index", $index, "Index out of range");
    }
      return $this->_data[$index];
  }
    
    /**
   * Sets the element at the specified index.
   * @param int $index The zero-based index
   * @param mixed $value The value to set
   */
    public function set($index, $value){
      if($index < 0 || $index >= count($this->_data)){
        throw new ArgumentOutOfRangeException("index", $index, "Index out of range");
    }
      $this->_data[$index] = $value;
  }
    
    /**
   * Adds an element to the end of the array.
   * @param mixed $item The element to add
   */
    public function Add($item){
      $this->_data[] = $item;
  }
    
    /**
   * Removes all elements from the array.
   */
    public function Clear(){
      $this->_data = array();
  }
    
    /**
   * Determines whether the array contains a specific value.
   * @param mixed $item The value to locate
   * @return bool true if the value is found; otherwise, false
   */
    public function Contains($item){
      return in_array($item, $this->_data, true);
  }
    
    /**
   * Searches for the specified object and returns the zero-based index.
   * @param mixed $item The object to locate
   * @return int The zero-based index, or -1 if not found
   */
    public function IndexOf($item){
      $index = array_search($item, $this->_data, true);
      return $index !== false ? $index : -1;
  }
    
    /**
   * Removes the first occurrence of a specific object.
   * @param mixed $item The object to remove
   * @return bool true if successfully removed; otherwise, false
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
   * @param int $index The zero-based index
   */
    public function RemoveAt($index){
      if($index < 0 || $index >= count($this->_data)){
        throw new ArgumentOutOfRangeException("index", $index, "Index out of range");
    }
      array_splice($this->_data, $index, 1);
  }
    
    /**
   * Projects each element using a selector function.
   * @param callable $selector A function to apply to each element
   * @return Array A new Array with transformed elements
   */
    public function Select($selector){
      if(!is_callable($selector)){
        throw new ArgumentException("Selector must be callable");
    }
      
      $result = array();
      foreach($this->_data as $index => $item){
        $result[] = call_user_func($selector, $item, $index);
    }
      return new ArrayCollection($result);
  }
    
    /**
   * Filters elements based on a predicate.
   * @param callable $predicate A function to test each element
   * @return Array A new Array with filtered elements
   */
    public function Where($predicate){
      if(!is_callable($predicate)){
        throw new ArgumentException("Predicate must be callable");
    }
      
      $result = array();
      foreach($this->_data as $index => $item){
        if(call_user_func($predicate, $item, $index)){
          $result[] = $item;
      }
    }
      return new ArrayCollection($result);
  }
    
    /**
   * Sorts elements in ascending order using a key selector.
   * @param callable $keySelector A function to extract the key for comparison
   * @return Array A new Array with sorted elements
   */
    public function OrderBy($keySelector = null){
      $data = $this->_data;
      
      if($keySelector === null){
        sort($data);
      } else {
        if(!is_callable($keySelector)){
          throw new ArgumentException("Key selector must be callable");
      }
        
        $keys = array();
        foreach($data as $index => $item){
          $keys[$index] = call_user_func($keySelector, $item);
      }
        array_multisort($keys, SORT_ASC, $data);
    }
      
      return new ArrayCollection($data);
  }
    
    /**
   * Sorts elements in descending order using a key selector.
   * @param callable $keySelector A function to extract the key for comparison
   * @return Array A new Array with sorted elements
   */
    public function OrderByDescending($keySelector = null){
      $data = $this->_data;
      
      if($keySelector === null){
        rsort($data);
      } else {
        if(!is_callable($keySelector)){
          throw new ArgumentException("Key selector must be callable");
      }
        
        $keys = array();
        foreach($data as $index => $item){
          $keys[$index] = call_user_func($keySelector, $item);
      }
        array_multisort($keys, SORT_DESC, $data);
    }
      
      return new ArrayCollection($data);
  }
    
    /**
   * Returns the first element that satisfies a condition.
   * @param callable $predicate A function to test each element
   * @return mixed The first element that satisfies the condition
   */
    public function First($predicate = null){
      if($predicate === null){
        if(count($this->_data) === 0){
          throw new InvalidOperationException("Sequence contains no elements");
      }
        return $this->_data[0];
    }
      
      if(!is_callable($predicate)){
        throw new ArgumentException("Predicate must be callable");
    }
      
      foreach($this->_data as $item){
        if(call_user_func($predicate, $item)){
          return $item;
      }
    }
      
      throw new InvalidOperationException("Sequence contains no matching element");
  }
    
    /**
   * Returns the first element or a default value if no element is found.
   * @param callable $predicate A function to test each element
   * @return mixed The first element or null
   */
    public function FirstOrDefault($predicate = null){
      try {
        return $this->First($predicate);
      } catch(InvalidOperationException $e){
        return null;
    }
  }
    
    /**
   * Determines whether any element satisfies a condition.
   * @param callable $predicate A function to test each element
   * @return bool true if any element satisfies the condition; otherwise, false
   */
    public function Any($predicate = null){
      if($predicate === null){
        return count($this->_data) > 0;
    }
      
      if(!is_callable($predicate)){
        throw new ArgumentException("Predicate must be callable");
    }
      
      foreach($this->_data as $item){
        if(call_user_func($predicate, $item)){
          return true;
      }
    }
      return false;
  }
    
    /**
   * Determines whether all elements satisfy a condition.
   * @param callable $predicate A function to test each element
   * @return bool true if all elements satisfy the condition; otherwise, false
   */
    public function All($predicate){
      if(!is_callable($predicate)){
        throw new ArgumentException("Predicate must be callable");
    }
      
      foreach($this->_data as $item){
        if(!call_user_func($predicate, $item)){
          return false;
      }
    }
      return true;
  }
    
    /**
   * Returns the number of elements that satisfy a condition.
   * @param callable $predicate A function to test each element
   * @return int The number of elements that satisfy the condition
   */
    public function Count($predicate = null){
      if($predicate === null){
        return count($this->_data);
    }
      
      if(!is_callable($predicate)){
        throw new ArgumentException("Predicate must be callable");
    }
      
      $count = 0;
      foreach($this->_data as $item){
        if(call_user_func($predicate, $item)){
          $count++;
      }
    }
      return $count;
  }
    
    /**
   * Returns an enumerator that iterates through the array.
   * @return \System\Collections\IEnumerator An enumerator
   */
    public function GetEnumerator(){
      return new \System\Collections\ArrayEnumerator($this->_data);
  }
    
    /**
   * Converts the Array to a PHP array.
   * @return array PHP array representation
   */
    public function ToArray(){
      return $this->_data;
  }
    
    /**
   * Returns a string representation of the Array.
   * @return string String representation
   */
    public function ToString(){
      return "Array[Count=" . count($this->_data) . "]";
  }
}

// Create aliases for backward compatibility (Array conflicts with PHP's array concept)
// Note: Aliases removed due to PHP reserved word conflicts
