<?php

/**
 * System.Diagnostics - Diagnostic and debugging functionality
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System\Diagnostics;

require_once 'System.Object.php';
require_once 'System.Exception.php';

/**
 * Provides a set of methods and properties that you can use to accurately measure elapsed time.
 */
class Stopwatch extends \System\BaseObject
{
    private $_startTime;
    private $_elapsedTime;
    private $_isRunning;
    
    /**
   * Initializes a new instance of the Stopwatch class.
   */
    public function __construct(){
      parent::__construct();
      $this->_startTime = 0;
      $this->_elapsedTime = 0;
      $this->_isRunning = false;
  }
    
    /**
   * Gets a value indicating whether the Stopwatch timer is running.
   * @return bool true if the Stopwatch is running; otherwise, false
   */
    public function getIsRunning(){
      return $this->_isRunning;
  }
    
    /**
   * Gets the total elapsed time measured by the current instance, in milliseconds.
   * @return float The total elapsed time in milliseconds
   */
    public function getElapsedMilliseconds(){
      $elapsed = $this->_elapsedTime;
      if($this->_isRunning){
        $elapsed += (microtime(true) - $this->_startTime);
    }
      return $elapsed * 1000;
  }
    
    /**
   * Gets the total elapsed time measured by the current instance, in seconds.
   * @return float The total elapsed time in seconds
   */
    public function getElapsed(){
      $elapsed = $this->_elapsedTime;
      if($this->_isRunning){
        $elapsed += (microtime(true) - $this->_startTime);
    }
      return $elapsed;
  }
    
    /**
   * Starts, or resumes, measuring elapsed time for an interval.
   */
    public function Start(){
      if(!$this->_isRunning){
        $this->_startTime = microtime(true);
        $this->_isRunning = true;
    }
  }
    
    /**
   * Stops measuring elapsed time for an interval.
   */
    public function Stop(){
      if($this->_isRunning){
        $this->_elapsedTime += (microtime(true) - $this->_startTime);
        $this->_isRunning = false;
    }
  }
    
    /**
   * Stops time interval measurement and resets the elapsed time to zero.
   */
    public function Reset(){
      $this->_elapsedTime = 0;
      $this->_isRunning = false;
      $this->_startTime = 0;
  }
    
    /**
   * Stops time interval measurement, resets the elapsed time to zero, and starts measuring elapsed time.
   */
    public function Restart(){
      $this->Reset();
      $this->Start();
  }
    
    /**
   * Initializes a new Stopwatch instance, sets the elapsed time property to zero, and starts measuring elapsed time.
   * @return Stopwatch A new, started Stopwatch instance
   */
    public static function StartNew(){
      $stopwatch = new Stopwatch();
      $stopwatch->Start();
      return $stopwatch;
  }
    
    /**
   * Returns a string representation of the elapsed time.
   * @return string String representation of elapsed time
   */
    public function ToString(){
      $elapsed = $this->getElapsed();
      $hours = floor($elapsed / 3600);
      $minutes = floor(($elapsed % 3600) / 60);
      $seconds = $elapsed % 60;
      
      return sprintf("%02d:%02d:%06.3f", $hours, $minutes, $seconds);
  }
}

/**
 * Provides a set of methods and properties that help you trace the execution of your code.
 */
class Trace extends \System\BaseObject
{
    private static $_listeners = array();
    
    /**
   * Writes a message to the trace listeners.
   * @param string $message The message to write
   */
    public static function Write($message){
      if(empty(static::$_listeners)){
        static::$_listeners[] = function($msg) { echo $msg; };
    }
      
      foreach(static::$_listeners as $listener){
        call_user_func($listener, $message);
    }
  }
    
    /**
   * Writes a message followed by a line terminator to the trace listeners.
   * @param string $message The message to write
   */
    public static function WriteLine($message){
      static::Write($message . "\n");
  }
    
    /**
   * Writes a formatted string to the trace listeners.
   * @param string $format A composite format string
   * @param mixed ...$args An array of objects to write using format
   */
    public static function WriteLineFormat($format){
      $args = func_get_args();
      array_shift($args); // Remove format parameter
      
      $message = sprintf($format, ...$args);
      static::WriteLine($message);
  }
    
    /**
   * Checks for a condition; if the condition is false, displays a message.
   * @param bool $condition The conditional expression to evaluate
   * @param string $message The message to display if condition is false
   */
    public static function Assert($condition, $message = ""){
      if(!$condition){
        $assertMessage = "Assertion failed";
        if($message !== ""){
          $assertMessage .= ": " . $message;
      }
        static::WriteLine($assertMessage);
        
        // In debug mode, you might want to throw an exception
        // throw new \System\Exception($assertMessage);
    }
  }
    
    /**
   * Adds a trace listener to the collection.
   * @param callable $listener The listener function to add
   */
    public static function AddListener($listener){
      if(!is_callable($listener)){
        throw new \System\ArgumentException("Listener must be callable");
    }
      static::$_listeners[] = $listener;
  }
    
    /**
   * Removes all trace listeners.
   */
    public static function ClearListeners(){
      static::$_listeners = array();
  }
    
    /**
   * Flushes the output buffer and causes buffered data to write to the listeners.
   */
    public static function Flush(){
      // In PHP, this is typically handled automatically
      // but we can ensure output is flushed
      if(ob_get_level()){
        ob_flush();
    }
      flush();
  }
    
    /**
   * Increases the current IndentLevel by one.
   */
    public static function Indent(){
      // Simple implementation - in a full implementation you'd track indent level
      static::Write("  ");
  }
    
    /**
   * Decreases the current IndentLevel by one.
   */
    public static function Unindent(){
      // Simple implementation - would need to track and manage indent level properly
  }
}
