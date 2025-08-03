<?php

/**
 * System short summary.
 *
 * System description.
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System;

require_once 'System.Object.php';
require_once 'System.Exception.php';

/**
 * Enhanced String class with comprehensive string manipulation capabilities.
 */
class StringObject extends BaseObject
{
    private $_value;
    
    /**
   * Initializes a new instance of the String class.
   * @param string $value The string value
   */
    public function __construct($value = ""){
      parent::__construct();
      $this->_value = (string)$value;
  }
    
    /**
   * Gets the length of the string.
   * @return int The number of characters
   */
    public function getLength(){
      return strlen($this->_value);
  }
    
    /**
   * Gets the character at the specified index.
   * @param int $index The zero-based index
   * @return string The character at the specified index
   */
    public function get($index){
      if($index < 0 || $index >= strlen($this->_value)){
        throw new ArgumentOutOfRangeException("index", $index, "Index out of range");
    }
      return $this->_value[$index];
  }
    
    /**
   * Determines whether this string contains the specified substring.
   * @param string $value The substring to seek
   * @return bool true if value is found; otherwise, false
   */
    public function Contains($value){
      return strpos($this->_value, $value) !== false;
  }
    
    /**
   * Determines whether the end of this string matches the specified string.
   * @param string $value The string to compare
   * @return bool true if value matches the end; otherwise, false
   */
    public function EndsWith($value){
      $len = strlen($value);
      return $len === 0 || substr($this->_value, -$len) === $value;
  }
    
    /**
   * Determines whether the beginning of this string matches the specified string.
   * @param string $value The string to compare
   * @return bool true if value matches the beginning; otherwise, false
   */
    public function StartsWith($value){
      return strpos($this->_value, $value) === 0;
  }
    
    /**
   * Reports the zero-based index of the first occurrence of the specified string.
   * @param string $value The string to seek
   * @param int $startIndex The search starting position
   * @return int The index of value if found; otherwise, -1
   */
    public function IndexOf($value, $startIndex = 0){
      $pos = strpos($this->_value, $value, $startIndex);
      return $pos !== false ? $pos : -1;
  }
    
    /**
   * Reports the zero-based index of the last occurrence of the specified string.
   * @param string $value The string to seek
   * @return int The index of value if found; otherwise, -1
   */
    public function LastIndexOf($value){
      $pos = strrpos($this->_value, $value);
      return $pos !== false ? $pos : -1;
  }
    
    /**
   * Returns a new string in which all occurrences of a specified string are replaced.
   * @param string $oldValue The string to be replaced
   * @param string $newValue The string to replace all occurrences of oldValue
   * @return String A string equivalent to this string but with all instances of oldValue replaced with newValue
   */
    public function Replace($oldValue, $newValue){
      return new String(str_replace($oldValue, $newValue, $this->_value));
  }
    
    /**
   * Splits this string into substrings based on the specified delimiter.
   * @param string $separator The delimiter character or string
   * @return array An array of String objects
   */
    public function Split($separator){
      $parts = explode($separator, $this->_value);
      $result = array();
      foreach($parts as $part){
        $result[] = new String($part);
    }
      return $result;
  }
    
    /**
   * Retrieves a substring from this instance.
   * @param int $startIndex The zero-based starting character position
   * @param int $length The number of characters to retrieve
   * @return String A string equivalent to the substring
   */
    public function Substring($startIndex, $length = null){
      if($startIndex < 0 || $startIndex >= strlen($this->_value)){
        throw new ArgumentOutOfRangeException("startIndex", $startIndex, "Index out of range");
    }
      
      if($length === null){
        $result = substr($this->_value, $startIndex);
      } else {
        if($length < 0){
          throw new ArgumentOutOfRangeException("length", $length, "Length cannot be negative");
      }
        $result = substr($this->_value, $startIndex, $length);
    }
      
      return new String($result);
  }
    
    /**
   * Converts this string to lowercase.
   * @return String A string in lowercase
   */
    public function ToLower(){
      return new String(strtolower($this->_value));
  }
    
    /**
   * Converts this string to uppercase.
   * @return String A string in uppercase
   */
    public function ToUpper(){
      return new String(strtoupper($this->_value));
  }
    
    /**
   * Removes all leading and trailing white-space characters.
   * @return String A string with whitespace removed
   */
    public function Trim(){
      return new String(trim($this->_value));
  }
    
    /**
   * Removes all leading white-space characters.
   * @return String A string with leading whitespace removed
   */
    public function TrimStart(){
      return new String(ltrim($this->_value));
  }
    
    /**
   * Removes all trailing white-space characters.
   * @return String A string with trailing whitespace removed
   */
    public function TrimEnd(){
      return new String(rtrim($this->_value));
  }
    
    /**
   * Determines whether this string and another string have the same value.
   * @param mixed $obj The string to compare
   * @return bool true if equal; otherwise, false
   */
    public function Equals($obj){
      if($obj instanceof String){
        return $this->_value === $obj->_value;
    }
      if(is_string($obj)){
        return $this->_value === $obj;
    }
      return false;
  }
    
    /**
   * Returns the hash code for this string.
   * @return string Hash code
   */
    public function GetHashCode(){
      return md5($this->_value);
  }
    
    /**
   * Returns the string value.
   * @return string The string value
   */
    public function ToString(){
      return $this->_value;
  }
    
    /**
   * Formats parameters using the given string.
   * @param mixed $format 
   * @return mixed
   */
    public static function Format($format){
      $args=func_get_args();
      return(preg_replace_callback("/\{([0-9]+)\}/",function($match) use($args){return($args[$match[1]+1]);},$format) );
  }
    
    public static function FormatEx($format,$callback){
      
      # assume callback is a dictionary with key value pairs when it is not callable
      if(!is_callable($callback)){
        $data=$callback;
        $callback=function($field) use($data){
          return($data[$field]);
        };
    }
      
      return(preg_replace_callback("/\{\{([^}]+)\}\}/",function($match) use($callback){return(call_user_func($callback,$match[1]));},$format) );
  }
    
    /**
   * Determines whether a string is null or empty.
   * @param string $value The string to test
   * @return bool true if null or empty; otherwise, false
   */
    public static function IsNullOrEmpty($value){
      return $value === null || $value === "";
  }
    
    /**
   * Determines whether a string is null, empty, or consists only of white-space characters.
   * @param string $value The string to test
   * @return bool true if null, empty, or whitespace; otherwise, false
   */
    public static function IsNullOrWhiteSpace($value){
      return $value === null || trim($value) === "";
  }
    
    /**
   * Concatenates the string representations of the elements in a specified array.
   * @param string $separator The string to use as a separator
   * @param array $values An array of strings to concatenate
   * @return String The concatenated string
   */
    public static function Join($separator, $values){
      $stringValues = array();
      foreach($values as $value){
        if($value instanceof String){
          $stringValues[] = $value->ToString();
        } else {
          $stringValues[] = (string)$value;
      }
    }
      return new StringObject(implode($separator, $stringValues));
  }
}

// Create alias for backward compatibility (String conflicts with PHP)
class_alias('System\\StringObject', 'System\\String');
