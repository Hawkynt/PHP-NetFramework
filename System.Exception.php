<?php

/**
 * System.Exception - Exception hierarchy for the System namespace
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System;

require_once 'System.Object.php';

/**
 * Base class for all exceptions in the System namespace.
 * Provides .NET-style exception functionality.
 */
class Exception extends BaseObject
{
    private $_message;
    private $_innerException;
    private $_stackTrace;
    
    /**
   * Initializes a new instance of the Exception class.
   * @param string $message The message that describes the error
   * @param Exception $innerException The exception that is the cause of the current exception
   */
    public function __construct($message = "", $innerException = null){
      $this->_message = $message;
      $this->_innerException = $innerException;
      $this->_stackTrace = debug_backtrace();
  }
    
    /**
   * Gets the message that describes the current exception.
   * @return string The error message
   */
    public function getMessage(){
      return $this->_message;
  }
    
    /**
   * Gets the Exception instance that caused the current exception.
   * @return Exception The inner exception
   */
    public function getInnerException(){
      return $this->_innerException;
  }
    
    /**
   * Gets the stack trace at the time the exception was thrown.
   * @return array The stack trace
   */
    public function getStackTrace(){
      return $this->_stackTrace;
  }
    
    /**
   * Returns a string representation of the current exception.
   * @return string String representation of the exception
   */
    public function ToString(){
      $result = get_class($this) . ": " . $this->_message;
      
      if($this->_innerException !== null){
        $result .= "\n---> " . $this->_innerException->ToString();
    }
      
      return $result;
  }
}

/**
 * Exception thrown when one of the arguments provided to a method is not valid.
 */
class ArgumentException extends Exception
{
    private $_parameterName;
    
    public function __construct($message = "", $parameterName = "", $innerException = null){
      parent::__construct($message, $innerException);
      $this->_parameterName = $parameterName;
  }
    
    public function getParameterName(){
      return $this->_parameterName;
  }
}
  
  /**
 * Exception thrown when a null reference is passed to a method that does not accept it.
 */
class ArgumentNullException extends ArgumentException
{
    public function __construct($parameterName = "", $message = "", $innerException = null){
      if($message === ""){
        $message = "Value cannot be null. Parameter name: " . $parameterName;
    }
      parent::__construct($message, $parameterName, $innerException);
  }
}
  
  /**
 * Exception thrown when the value of an argument is outside the allowable range.
 */
class ArgumentOutOfRangeException extends ArgumentException
{
    private $_actualValue;
    
    public function __construct($parameterName = "", $actualValue = null, $message = "", $innerException = null){
      if($message === ""){
        $message = "Specified argument was out of the range of valid values. Parameter name: " . $parameterName;
    }
      parent::__construct($message, $parameterName, $innerException);
      $this->_actualValue = $actualValue;
  }
    
    public function getActualValue(){
      return $this->_actualValue;
  }
}
  
  /**
 * Exception thrown when a method call is not valid for the object's current state.
 */
class InvalidOperationException extends Exception
{
    public function __construct($message = "", $innerException = null){
      if($message === ""){
        $message = "Operation is not valid due to the current state of the object.";
    }
      parent::__construct($message, $innerException);
  }
}
  
  /**
 * Exception thrown when an operation is not supported.
 */
class NotSupportedException extends Exception
{
    public function __construct($message = "", $innerException = null){
      if($message === ""){
        $message = "Specified method is not supported.";
    }
      parent::__construct($message, $innerException);
  }
}
  
  /**
 * Exception thrown when a method is not implemented.
 */
class NotImplementedException extends Exception
{
    public function __construct($message = "", $innerException = null){
      if($message === ""){
        $message = "The method or operation is not implemented.";
    }
      parent::__construct($message, $innerException);
  }
}
