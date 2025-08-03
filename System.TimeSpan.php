<?php

/**
 * System.TimeSpan - Represents a time interval
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System;

require_once 'System.Object.php';
require_once 'System.Exception.php';

/**
 * Represents a time interval (duration of time or elapsed time).
 */
class TimeSpan extends BaseObject
{
    private $_totalSeconds;
    
    /**
   * Initializes a new instance of the TimeSpan class.
   * @param int $days The number of days
   * @param int $hours The number of hours
   * @param int $minutes The number of minutes
   * @param int $seconds The number of seconds
   * @param int $milliseconds The number of milliseconds
   */
    public function __construct($days = 0, $hours = 0, $minutes = 0, $seconds = 0, $milliseconds = 0){
      
      $this->_totalSeconds = 
        $days * 86400 +           // 24 * 60 * 60
        $hours * 3600 +           // 60 * 60
        $minutes * 60 +
        $seconds +
        $milliseconds / 1000.0;
  }
    
    /**
   * Gets the days component of the time interval.
   * @return int The days component
   */
    public function getDays(){
      return (int)floor(abs($this->_totalSeconds) / 86400);
  }
    
    /**
   * Gets the hours component of the time interval.
   * @return int The hours component (0-23)
   */
    public function getHours(){
      return (int)floor((abs($this->_totalSeconds) % 86400) / 3600);
  }
    
    /**
   * Gets the minutes component of the time interval.
   * @return int The minutes component (0-59)
   */
    public function getMinutes(){
      return (int)floor((abs($this->_totalSeconds) % 3600) / 60);
  }
    
    /**
   * Gets the seconds component of the time interval.
   * @return int The seconds component (0-59)
   */
    public function getSeconds(){
      return (int)(abs($this->_totalSeconds) % 60);
  }
    
    /**
   * Gets the milliseconds component of the time interval.
   * @return int The milliseconds component (0-999)
   */
    public function getMilliseconds(){
      $fractional = abs($this->_totalSeconds) - floor(abs($this->_totalSeconds));
      return (int)round($fractional * 1000);
  }
    
    /**
   * Gets the total number of days represented by this instance.
   * @return float The total days
   */
    public function getTotalDays(){
      return $this->_totalSeconds / 86400;
  }
    
    /**
   * Gets the total number of hours represented by this instance.
   * @return float The total hours
   */
    public function getTotalHours(){
      return $this->_totalSeconds / 3600;
  }
    
    /**
   * Gets the total number of minutes represented by this instance.
   * @return float The total minutes
   */
    public function getTotalMinutes(){
      return $this->_totalSeconds / 60;
  }
    
    /**
   * Gets the total number of seconds represented by this instance.
   * @return float The total seconds
   */
    public function getTotalSeconds(){
      return $this->_totalSeconds;
  }
    
    /**
   * Gets the total number of milliseconds represented by this instance.
   * @return float The total milliseconds
   */
    public function getTotalMilliseconds(){
      return $this->_totalSeconds * 1000;
  }
    
    /**
   * Adds another TimeSpan to this instance.
   * @param TimeSpan $other The TimeSpan to add
   * @return TimeSpan A new TimeSpan representing the sum
   */
    public function Add($other){
      if(!($other instanceof TimeSpan)){
        throw new \System\ArgumentException("Argument must be a TimeSpan");
    }
      
      $result = new TimeSpan();
      $result->_totalSeconds = $this->_totalSeconds + $other->_totalSeconds;
      return $result;
  }
    
    /**
   * Subtracts another TimeSpan from this instance.
   * @param TimeSpan $other The TimeSpan to subtract
   * @return TimeSpan A new TimeSpan representing the difference
   */
    public function Subtract($other){
      if(!($other instanceof TimeSpan)){
        throw new \System\ArgumentException("Argument must be a TimeSpan");
    }
      
      $result = new TimeSpan();
      $result->_totalSeconds = $this->_totalSeconds - $other->_totalSeconds;
      return $result;
  }
    
    /**
   * Returns the absolute value of this TimeSpan.
   * @return TimeSpan A new TimeSpan with absolute value
   */
    public function Duration(){
      $result = new TimeSpan();
      $result->_totalSeconds = abs($this->_totalSeconds);
      return $result;
  }
    
    /**
   * Returns the negated value of this TimeSpan.
   * @return TimeSpan A new TimeSpan with negated value
   */
    public function Negate(){
      $result = new TimeSpan();
      $result->_totalSeconds = -$this->_totalSeconds;
      return $result;
  }
    
    /**
   * Compares this TimeSpan with another TimeSpan.
   * @param TimeSpan $other The TimeSpan to compare with
   * @return int -1 if less, 0 if equal, 1 if greater
   */
    public function CompareTo($other){
      if(!($other instanceof TimeSpan)){
        throw new \System\ArgumentException("Object must be of type TimeSpan");
    }
      
      if($this->_totalSeconds < $other->_totalSeconds) return -1;
      if($this->_totalSeconds > $other->_totalSeconds) return 1;
      return 0;
  }
    
    /**
   * Determines whether this TimeSpan equals another TimeSpan.
   * @param mixed $obj The object to compare with
   * @return bool true if equal; otherwise, false
   */
    public function Equals($obj){
      if(!($obj instanceof TimeSpan)){
        return false;
    }
      return abs($this->_totalSeconds - $obj->_totalSeconds) < 0.001; // Allow for small floating point differences
  }
    
    /**
   * Returns the hash code for this TimeSpan.
   * @return string Hash code
   */
    public function GetHashCode(){
      return md5((string)$this->_totalSeconds);
  }
    
    /**
   * Returns a string representation of this TimeSpan.
   * @return string The string representation in format [-]d.hh:mm:ss.fff
   */
    public function ToString(){
      $negative = $this->_totalSeconds < 0 ? "-" : "";
      $absTotalSeconds = abs($this->_totalSeconds);
      
      $days = (int)floor($absTotalSeconds / 86400);
      $hours = (int)floor(($absTotalSeconds % 86400) / 3600);
      $minutes = (int)floor(($absTotalSeconds % 3600) / 60);
      $seconds = (int)($absTotalSeconds % 60);
      $milliseconds = (int)round(($absTotalSeconds - floor($absTotalSeconds)) * 1000);
      
      if($days > 0){
        return sprintf("%s%d.%02d:%02d:%02d.%03d", $negative, $days, $hours, $minutes, $seconds, $milliseconds);
      } else {
        return sprintf("%s%02d:%02d:%02d.%03d", $negative, $hours, $minutes, $seconds, $milliseconds);
    }
  }
    
    /**
   * Parses a string representation of a TimeSpan.
   * @param string $s The string to parse (format: [-]d.hh:mm:ss[.fff] or [-]hh:mm:ss[.fff])
   * @return TimeSpan The parsed TimeSpan
   */
    public static function Parse($s){
      if(!is_string($s)){
        throw new \System\ArgumentException("Argument must be a string");
    }
      
      $s = trim($s);
      $negative = false;
      
      if(strlen($s) > 0 && $s[0] === '-'){
        $negative = true;
        $s = substr($s, 1);
    }
      
      // Try to match patterns: d.hh:mm:ss.fff or hh:mm:ss.fff
      if(preg_match('/^(\d+)\.(\d{1,2}):(\d{1,2}):(\d{1,2})(?:\.(\d{1,3}))?$/', $s, $matches)){
        // Format: d.hh:mm:ss[.fff]
        $days = (int)$matches[1];
        $hours = (int)$matches[2];
        $minutes = (int)$matches[3];
        $seconds = (int)$matches[4];
        $milliseconds = isset($matches[5]) ? (int)str_pad($matches[5], 3, '0', STR_PAD_RIGHT) : 0;
      } elseif(preg_match('/^(\d{1,2}):(\d{1,2}):(\d{1,2})(?:\.(\d{1,3}))?$/', $s, $matches)){
        // Format: hh:mm:ss[.fff]
        $days = 0;
        $hours = (int)$matches[1];
        $minutes = (int)$matches[2];
        $seconds = (int)$matches[3];
        $milliseconds = isset($matches[4]) ? (int)str_pad($matches[4], 3, '0', STR_PAD_RIGHT) : 0;
      } else {
        throw new \System\ArgumentException("String was not recognized as a valid TimeSpan");
    }
      
      $result = new TimeSpan($days, $hours, $minutes, $seconds, $milliseconds);
      if($negative){
        $result = $result->Negate();
    }
      
      return $result;
  }
    
    /**
   * Tries to parse a string representation of a TimeSpan.
   * @param string $s The string to parse
   * @param TimeSpan &$result The parsed TimeSpan if successful
   * @return bool true if successful; otherwise, false
   */
    public static function TryParse($s, &$result){
      try {
        $result = static::Parse($s);
        return true;
      } catch(\System\Exception $e){
        $result = null;
        return false;
    }
  }
    
    /**
   * Returns a TimeSpan that represents a specified number of days.
   * @param float $value The number of days
   * @return TimeSpan A TimeSpan representing the specified days
   */
    public static function FromDays($value){
      $result = new TimeSpan();
      $result->_totalSeconds = $value * 86400;
      return $result;
  }
    
    /**
   * Returns a TimeSpan that represents a specified number of hours.
   * @param float $value The number of hours
   * @return TimeSpan A TimeSpan representing the specified hours
   */
    public static function FromHours($value){
      $result = new TimeSpan();
      $result->_totalSeconds = $value * 3600;
      return $result;
  }
    
    /**
   * Returns a TimeSpan that represents a specified number of minutes.
   * @param float $value The number of minutes
   * @return TimeSpan A TimeSpan representing the specified minutes
   */
    public static function FromMinutes($value){
      $result = new TimeSpan();
      $result->_totalSeconds = $value * 60;
      return $result;
  }
    
    /**
   * Returns a TimeSpan that represents a specified number of seconds.
   * @param float $value The number of seconds
   * @return TimeSpan A TimeSpan representing the specified seconds
   */
    public static function FromSeconds($value){
      $result = new TimeSpan();
      $result->_totalSeconds = $value;
      return $result;
  }
    
    /**
   * Returns a TimeSpan that represents a specified number of milliseconds.
   * @param float $value The number of milliseconds
   * @return TimeSpan A TimeSpan representing the specified milliseconds
   */
    public static function FromMilliseconds($value){
      $result = new TimeSpan();
      $result->_totalSeconds = $value / 1000.0;
      return $result;
  }
    
    /**
   * Represents the zero TimeSpan value.
   * @return TimeSpan A TimeSpan with zero duration
   */
    public static function getZero(){
      return new TimeSpan();
  }
    
    /**
   * Represents the maximum TimeSpan value.
   * @return TimeSpan The maximum TimeSpan
   */
    public static function getMaxValue(){
      $result = new TimeSpan();
      $result->_totalSeconds = PHP_FLOAT_MAX;
      return $result;
  }
    
    /**
   * Represents the minimum TimeSpan value.
   * @return TimeSpan The minimum TimeSpan
   */
    public static function getMinValue(){
      $result = new TimeSpan();
      $result->_totalSeconds = -PHP_FLOAT_MAX;
      return $result;
  }
}
