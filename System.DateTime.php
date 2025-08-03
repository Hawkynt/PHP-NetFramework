<?php

/**
 * System.DateTime - Date and time functionality
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System;

require_once 'System.Object.php';
require_once 'System.Exception.php';

/**
 * Represents an instant in time, typically expressed as a date and time of day.
 */
class DateTime extends BaseObject
{
    private $_timestamp;
    
    /**
   * Creates a DateTime from a Unix timestamp (internal use).
   * @param int $timestamp Unix timestamp
   * @return DateTime DateTime instance
   */
    public static function FromTimestamp($timestamp){
      $result = new DateTime();
      $result->_timestamp = $timestamp;
      return $result;
  }
    
    /**
   * Initializes a new instance of the DateTime class.
   * @param int $year The year (1 to 9999)
   * @param int $month The month (1 to 12)
   * @param int $day The day (1 to the number of days in month)
   * @param int $hour The hours (0 to 23)
   * @param int $minute The minutes (0 to 59)
   * @param int $second The seconds (0 to 59)
   */
    public function __construct($year = null, $month = null, $day = null, $hour = 0, $minute = 0, $second = 0){
      parent::__construct();
      
      if($year === null){
        $this->_timestamp = time();
      } else {
        $this->_timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        if($this->_timestamp === false){
          throw new ArgumentException("Invalid date/time values");
      }
    }
  }
    
    /**
   * Gets the current date and time on this computer.
   * @return DateTime A DateTime object representing the current date and time
   */
    public static function getNow(){
      return new DateTime();
  }
    
    /**
   * Gets the current date with the time component set to 00:00:00.
   * @return DateTime A DateTime object representing today's date
   */
    public static function getToday(){
      $now = new DateTime();
      return new DateTime($now->getYear(), $now->getMonth(), $now->getDay());
  }
    
    /**
   * Gets the year component of the date.
   * @return int The year
   */
    public function getYear(){
      return (int)date('Y', $this->_timestamp);
  }
    
    /**
   * Gets the month component of the date.
   * @return int The month
   */
    public function getMonth(){
      return (int)date('n', $this->_timestamp);
  }
    
    /**
   * Gets the day of the month.
   * @return int The day of the month
   */
    public function getDay(){
      return (int)date('j', $this->_timestamp);
  }
    
    /**
   * Gets the hour component of the date.
   * @return int The hour
   */
    public function getHour(){
      return (int)date('G', $this->_timestamp);
  }
    
    /**
   * Gets the minute component of the date.
   * @return int The minute
   */
    public function getMinute(){
      return (int)date('i', $this->_timestamp);
  }
    
    /**
   * Gets the second component of the date.
   * @return int The second
   */
    public function getSecond(){
      return (int)date('s', $this->_timestamp);
  }
    
    /**
   * Gets the day of the week.
   * @return int The day of the week (0=Sunday, 1=Monday, etc.)
   */
    public function getDayOfWeek(){
      return (int)date('w', $this->_timestamp);
  }
    
    /**
   * Gets the day of the year.
   * @return int The day of the year (1 to 366)
   */
    public function getDayOfYear(){
      return (int)date('z', $this->_timestamp) + 1;
  }
    
    /**
   * Returns a new DateTime that adds the specified number of days.
   * @param int $value The number of days to add
   * @return DateTime A new DateTime object
   */
    public function AddDays($value){
      $newTimestamp = strtotime("+{$value} days", $this->_timestamp);
      $result = new DateTime();
      $result->_timestamp = $newTimestamp;
      return $result;
  }
    
    /**
   * Returns a new DateTime that adds the specified number of hours.
   * @param int $value The number of hours to add
   * @return DateTime A new DateTime object
   */
    public function AddHours($value){
      $newTimestamp = strtotime("+{$value} hours", $this->_timestamp);
      $result = new DateTime();
      $result->_timestamp = $newTimestamp;
      return $result;
  }
    
    /**
   * Returns a new DateTime that adds the specified number of minutes.
   * @param int $value The number of minutes to add
   * @return DateTime A new DateTime object
   */
    public function AddMinutes($value){
      $newTimestamp = strtotime("+{$value} minutes", $this->_timestamp);
      $result = new DateTime();
      $result->_timestamp = $newTimestamp;
      return $result;
  }
    
    /**
   * Returns a new DateTime that adds the specified number of seconds.
   * @param int $value The number of seconds to add
   * @return DateTime A new DateTime object
   */
    public function AddSeconds($value){
      $result = new DateTime();
      $result->_timestamp = $this->_timestamp + $value;
      return $result;
  }
    
    /**
   * Returns a new DateTime that adds the specified number of months.
   * @param int $value The number of months to add
   * @return DateTime A new DateTime object
   */
    public function AddMonths($value){
      $newTimestamp = strtotime("+{$value} months", $this->_timestamp);
      $result = new DateTime();
      $result->_timestamp = $newTimestamp;
      return $result;
  }
    
    /**
   * Returns a new DateTime that adds the specified number of years.
   * @param int $value The number of years to add
   * @return DateTime A new DateTime object
   */
    public function AddYears($value){
      $newTimestamp = strtotime("+{$value} years", $this->_timestamp);
      $result = new DateTime();
      $result->_timestamp = $newTimestamp;
      return $result;
  }
    
    /**
   * Compares this instance to another DateTime object.
   * @param DateTime $other The DateTime to compare to
   * @return int A value less than 0 if this is earlier, 0 if equal, greater than 0 if later
   */
    public function CompareTo($other){
      if(!($other instanceof DateTime)){
        throw new ArgumentException("Object must be of type DateTime");
    }
      
      if($this->_timestamp < $other->_timestamp) return -1;
      if($this->_timestamp > $other->_timestamp) return 1;
      return 0;
  }
    
    /**
   * Converts the value to its equivalent string representation using the specified format.
   * @param string $format A standard or custom date and time format string
   * @return string The string representation of the value
   */
    public function ToString($format = null){
      if($format === null){
        return date('Y-m-d H:i:s', $this->_timestamp);
    }
      
      // Convert .NET format strings to PHP format strings
      $formatMap = array(
        'yyyy' => 'Y',
        'yy' => 'y',
        'MM' => 'm',
        'M' => 'n',
        'dd' => 'd',
        'd' => 'j',
        'HH' => 'H',
        'H' => 'G',
        'mm' => 'i',
        'm' => 'i',
        'ss' => 's',
        's' => 's'
      );
      
      $phpFormat = str_replace(array_keys($formatMap), array_values($formatMap), $format);
      return date($phpFormat, $this->_timestamp);
  }
    
    /**
   * Converts a string representation of a date and time to its DateTime equivalent.
   * @param string $s A string containing a date and time to convert
   * @return DateTime A DateTime equivalent to the date and time contained in s
   */
    public static function Parse($s){
      $timestamp = strtotime($s);
      if($timestamp === false){
        throw new ArgumentException("String was not recognized as a valid DateTime");
    }
      
      $result = new DateTime();
      $result->_timestamp = $timestamp;
      return $result;
  }
    
    /**
   * Converts a string representation of a date and time to its DateTime equivalent using try/catch pattern.
   * @param string $s A string containing a date and time to convert
   * @param DateTime &$result When this method returns, contains the DateTime equivalent if successful
   * @return bool true if s was converted successfully; otherwise, false
   */
    public static function TryParse($s, &$result){
      try {
        $result = static::Parse($s);
        return true;
      } catch(Exception $e){
        $result = null;
        return false;
    }
  }
    
    /**
   * Determines whether the specified object is equal to the current object.
   * @param mixed $obj The object to compare
   * @return bool true if equal; otherwise, false
   */
    public function Equals($obj){
      if(!($obj instanceof DateTime)){
        return false;
    }
      return $this->_timestamp === $obj->_timestamp;
  }
    
    /**
   * Returns the hash code for this instance.
   * @return string A hash code for the current object
   */
    public function GetHashCode(){
      return md5($this->_timestamp);
  }
}
