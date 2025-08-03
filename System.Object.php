<?php

/**
 * System.Object - Base class for all objects in the System namespace
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System;
  /**
 * Base class that provides fundamental functionality for all objects.
 * All classes in the System namespace should inherit from this class.
 */
class Object
{
    /**
   * Returns a string representation of the current object.
   * @return string String representation of the object
   */
    public function ToString(){
      return get_class($this);
  }
    
    /**
   * Gets the type of the current instance.
   * @return string The exact runtime type of the current instance
   */
    public function GetType(){
      return get_class($this);
  }
    
    /**
   * Determines whether the specified object is equal to the current object.
   * @param mixed $obj The object to compare with the current object
   * @return bool true if the specified object is equal to the current object; otherwise, false
   */
    public function Equals($obj){
      if($obj === null) return false;
      if($this === $obj) return true;
      
      // For objects, compare their string representations
      if(is_object($obj) && method_exists($obj, 'ToString')){
        return $this->ToString() === $obj->ToString();
    }
      
      return false;
  }
    
    /**
   * Serves as the default hash function.
   * @return string A hash code for the current object
   */
    public function GetHashCode(){
      return spl_object_hash($this);
  }
    
    /**
   * Creates a shallow copy of the current object.
   * @return Object A shallow copy of the current object
   */
    public function MemberwiseClone(){
      return clone $this;
  }
    
    /**
   * Determines whether two object instances are equal.
   * @param mixed $objA The first object to compare
   * @param mixed $objB The second object to compare
   * @return bool true if objA is equal to objB; otherwise, false
   */
    public static function ReferenceEquals($objA, $objB){
      return $objA === $objB;
  }
}
