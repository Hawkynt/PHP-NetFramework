<?php

/**
 * System.Decimal - High-precision decimal arithmetic
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System;

require_once 'System.Object.php';
require_once 'System.Exception.php';

/**
 * Represents a decimal floating-point number with high precision.
 * Uses BCMath extension for arbitrary precision arithmetic when available.
 */
class Decimal extends BaseObject
{
    private $_value;
    private $_scale;
    
    /**
   * Initializes a new instance of the Decimal class.
   * @param mixed $value The decimal value (string, int, float, or another Decimal)
   * @param int $scale The number of decimal places (default 10)
   */
    public function __construct($value = 0, $scale = 10){
      parent::__construct();
      $this->_scale = max(0, (int)$scale);
      
      if($value instanceof Decimal){
        $this->_value = $value->_value;
        $this->_scale = max($this->_scale, $value->_scale);
      } else {
        $this->_value = $this->_normalize((string)$value);
    }
  }
    
    /**
   * Gets the scale (number of decimal places) for this decimal.
   * @return int The scale
   */
    public function getScale(){
      return $this->_scale;
  }
    
    /**
   * Adds two decimal values.
   * @param Decimal|mixed $other The value to add
   * @return Decimal The sum
   */
    public function Add($other){
      $otherDecimal = $this->_toDecimal($other);
      $scale = max($this->_scale, $otherDecimal->_scale);
      
      if(function_exists('bcadd')){
        $result = bcadd($this->_value, $otherDecimal->_value, $scale);
      } else {
        $result = (string)((float)$this->_value + (float)$otherDecimal->_value);
    }
      
      return new Decimal($result, $scale);
  }
    
    /**
   * Subtracts one decimal value from another.
   * @param Decimal|mixed $other The value to subtract
   * @return Decimal The difference
   */
    public function Subtract($other){
      $otherDecimal = $this->_toDecimal($other);
      $scale = max($this->_scale, $otherDecimal->_scale);
      
      if(function_exists('bcsub')){
        $result = bcsub($this->_value, $otherDecimal->_value, $scale);
      } else {
        $result = (string)((float)$this->_value - (float)$otherDecimal->_value);
    }
      
      return new Decimal($result, $scale);
  }
    
    /**
   * Multiplies two decimal values.
   * @param Decimal|mixed $other The value to multiply by
   * @return Decimal The product
   */
    public function Multiply($other){
      $otherDecimal = $this->_toDecimal($other);
      $scale = max($this->_scale, $otherDecimal->_scale);
      
      if(function_exists('bcmul')){
        $result = bcmul($this->_value, $otherDecimal->_value, $scale);
      } else {
        $result = (string)((float)$this->_value * (float)$otherDecimal->_value);
    }
      
      return new Decimal($result, $scale);
  }
    
    /**
   * Divides one decimal value by another.
   * @param Decimal|mixed $other The divisor
   * @return Decimal The quotient
   */
    public function Divide($other){
      $otherDecimal = $this->_toDecimal($other);
      
      if($otherDecimal->_value === '0' || $otherDecimal->_value === '0.0'){
        throw new \System\InvalidOperationException("Division by zero");
    }
      
      $scale = max($this->_scale, $otherDecimal->_scale);
      
      if(function_exists('bcdiv')){
        $result = bcdiv($this->_value, $otherDecimal->_value, $scale);
      } else {
        $result = (string)((float)$this->_value / (float)$otherDecimal->_value);
    }
      
      return new Decimal($result, $scale);
  }
    
    /**
   * Returns the remainder from dividing two decimal values.
   * @param Decimal|mixed $other The divisor
   * @return Decimal The remainder
   */
    public function Remainder($other){
      $otherDecimal = $this->_toDecimal($other);
      
      if($otherDecimal->_value === '0' || $otherDecimal->_value === '0.0'){
        throw new \System\InvalidOperationException("Division by zero");
    }
      
      if(function_exists('bcmod')){
        $result = bcmod($this->_value, $otherDecimal->_value);
      } else {
        $result = (string)fmod((float)$this->_value, (float)$otherDecimal->_value);
    }
      
      return new Decimal($result, $this->_scale);
  }
    
    /**
   * Returns the absolute value of this decimal.
   * @return Decimal The absolute value
   */
    public function Abs(){
      if($this->_value[0] === '-'){
        return new Decimal(substr($this->_value, 1), $this->_scale);
    }
      return new Decimal($this->_value, $this->_scale);
  }
    
    /**
   * Returns the smallest integer greater than or equal to this decimal.
   * @return Decimal The ceiling value
   */
    public function Ceiling(){
      $floatVal = (float)$this->_value;
      $result = ceil($floatVal);
      return new Decimal((string)$result, 0);
  }
    
    /**
   * Returns the largest integer less than or equal to this decimal.
   * @return Decimal The floor value
   */
    public function Floor(){
      $floatVal = (float)$this->_value;
      $result = floor($floatVal);
      return new Decimal((string)$result, 0);
  }
    
    /**
   * Rounds this decimal to the specified number of decimal places.
   * @param int $decimals The number of decimal places
   * @return Decimal The rounded value
   */
    public function Round($decimals = 0){
      $floatVal = (float)$this->_value;
      $result = round($floatVal, $decimals);
      return new Decimal((string)$result, $decimals);
  }
    
    /**
   * Compares this decimal with another decimal.
   * @param Decimal|mixed $other The decimal to compare with
   * @return int -1 if less, 0 if equal, 1 if greater
   */
    public function CompareTo($other){
      $otherDecimal = $this->_toDecimal($other);
      
      if(function_exists('bccomp')){
        return bccomp($this->_value, $otherDecimal->_value, max($this->_scale, $otherDecimal->_scale));
      } else {
        $thisFloat = (float)$this->_value;
        $otherFloat = (float)$otherDecimal->_value;
        
        if($thisFloat < $otherFloat) return -1;
        if($thisFloat > $otherFloat) return 1;
        return 0;
    }
  }
    
    /**
   * Determines whether this decimal equals another decimal.
   * @param mixed $obj The object to compare with
   * @return bool true if equal; otherwise, false
   */
    public function Equals($obj){
      if(!($obj instanceof Decimal)){
        return false;
    }
      return $this->CompareTo($obj) === 0;
  }
    
    /**
   * Returns the hash code for this decimal.
   * @return string Hash code
   */
    public function GetHashCode(){
      return md5($this->_value);
  }
    
    /**
   * Converts this decimal to a float.
   * @return float The float representation
   */
    public function ToFloat(){
      return (float)$this->_value;
  }
    
    /**
   * Converts this decimal to an integer.
   * @return int The integer representation (truncated)
   */
    public function ToInt(){
      return (int)(float)$this->_value;
  }
    
    /**
   * Returns a string representation of this decimal.
   * @param int $decimals Optional number of decimal places to display
   * @return string The string representation
   */
    public function ToString($decimals = null){
      if($decimals === null){
        return $this->_value;
    }
      
      $floatVal = (float)$this->_value;
      return number_format($floatVal, $decimals, '.', '');
  }
    
    /**
   * Parses a string representation of a decimal.
   * @param string $s The string to parse
   * @param int $scale The scale to use
   * @return Decimal The parsed decimal
   */
    public static function Parse($s, $scale = 10){
      if(!is_numeric($s)){
        throw new \System\ArgumentException("String is not a valid decimal number");
    }
      return new Decimal($s, $scale);
  }
    
    /**
   * Tries to parse a string representation of a decimal.
   * @param string $s The string to parse
   * @param Decimal &$result The parsed decimal if successful
   * @param int $scale The scale to use
   * @return bool true if successful; otherwise, false
   */
    public static function TryParse($s, &$result, $scale = 10){
      try {
        $result = static::Parse($s, $scale);
        return true;
      } catch(\System\Exception $e){
        $result = null;
        return false;
    }
  }
    
    /**
   * Returns the larger of two decimals.
   * @param Decimal $val1 The first decimal
   * @param Decimal $val2 The second decimal
   * @return Decimal The larger decimal
   */
    public static function Max($val1, $val2){
      return $val1->CompareTo($val2) >= 0 ? $val1 : $val2;
  }
    
    /**
   * Returns the smaller of two decimals.
   * @param Decimal $val1 The first decimal
   * @param Decimal $val2 The second decimal
   * @return Decimal The smaller decimal
   */
    public static function Min($val1, $val2){
      return $val1->CompareTo($val2) <= 0 ? $val1 : $val2;
  }
    
    /**
   * Converts a value to a Decimal instance.
   * @param mixed $value The value to convert
   * @return Decimal The decimal representation
   */
    private function _toDecimal($value){
      if($value instanceof Decimal){
        return $value;
    }
      return new Decimal($value, $this->_scale);
  }
    
    /**
   * Normalizes a string representation of a decimal.
   * @param string $value The value to normalize
   * @return string The normalized value
   */
    private function _normalize($value){
      // Remove any whitespace
      $value = trim($value);
      
      // Ensure it's a valid number
      if(!is_numeric($value)){
        throw new \System\ArgumentException("Invalid decimal value: " . $value);
    }
      
      // Convert scientific notation if present
      if(strpos($value, 'e') !== false || strpos($value, 'E') !== false){
        $value = sprintf("%.{$this->_scale}f", (float)$value);
    }
      
      return $value;
  }
}
