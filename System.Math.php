<?php

require_once 'System.Object.php';
require_once 'System.Exception.php';

/**
 * System.Math - Mathematical functions and constants
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System;
{
  /**
   * Provides constants and static methods for trigonometric, logarithmic, and other common mathematical functions.
   */
  class Math extends Object
  {
    /**
     * Represents the ratio of the circumference of a circle to its diameter, specified by the constant, π.
     */
    const PI = M_PI;
    
    /**
     * Represents the natural logarithmic base, specified by the constant, e.
     */
    const E = M_E;
    
    /**
     * Returns the absolute value of a number.
     * @param float $value A number
     * @return float The absolute value of the number
     */
    public static function Abs($value){
      return abs($value);
    }
    
    /**
     * Returns the angle whose cosine is the specified number.
     * @param float $d A number representing a cosine
     * @return float An angle measured in radians
     */
    public static function Acos($d){
      return acos($d);
    }
    
    /**
     * Returns the angle whose sine is the specified number.
     * @param float $d A number representing a sine
     * @return float An angle measured in radians
     */
    public static function Asin($d){
      return asin($d);
    }
    
    /**
     * Returns the angle whose tangent is the specified number.
     * @param float $d A number representing a tangent
     * @return float An angle measured in radians
     */
    public static function Atan($d){
      return atan($d);
    }
    
    /**
     * Returns the angle whose tangent is the quotient of two specified numbers.
     * @param float $y The y coordinate of a point
     * @param float $x The x coordinate of a point
     * @return float An angle measured in radians
     */
    public static function Atan2($y, $x){
      return atan2($y, $x);
    }
    
    /**
     * Returns the smallest integer greater than or equal to the specified number.
     * @param float $a A number
     * @return float The smallest integer greater than or equal to a
     */
    public static function Ceiling($a){
      return ceil($a);
    }
    
    /**
     * Returns the cosine of the specified angle.
     * @param float $d An angle, measured in radians
     * @return float The cosine of d
     */
    public static function Cos($d){
      return cos($d);
    }
    
    /**
     * Returns the hyperbolic cosine of the specified angle.
     * @param float $value An angle, measured in radians
     * @return float The hyperbolic cosine of value
     */
    public static function Cosh($value){
      return cosh($value);
    }
    
    /**
     * Returns e raised to the specified power.
     * @param float $d A number specifying a power
     * @return float The number e raised to the power d
     */
    public static function Exp($d){
      return exp($d);
    }
    
    /**
     * Returns the largest integer less than or equal to the specified number.
     * @param float $d A number
     * @return float The largest integer less than or equal to d
     */
    public static function Floor($d){
      return floor($d);
    }
    
    /**
     * Returns the natural (base e) logarithm of a specified number.
     * @param float $d A number whose logarithm is to be found
     * @return float The natural logarithm of d
     */
    public static function Log($d){
      return log($d);
    }
    
    /**
     * Returns the base 10 logarithm of a specified number.
     * @param float $d A number whose logarithm is to be found
     * @return float The base 10 logarithm of d
     */
    public static function Log10($d){
      return log10($d);
    }
    
    /**
     * Returns the larger of two numbers.
     * @param float $val1 The first of two numbers to compare
     * @param float $val2 The second of two numbers to compare
     * @return float The larger of val1 and val2
     */
    public static function Max($val1, $val2){
      return max($val1, $val2);
    }
    
    /**
     * Returns the smaller of two numbers.
     * @param float $val1 The first of two numbers to compare
     * @param float $val2 The second of two numbers to compare
     * @return float The smaller of val1 and val2
     */
    public static function Min($val1, $val2){
      return min($val1, $val2);
    }
    
    /**
     * Returns a specified number raised to the specified power.
     * @param float $x A number to be raised to a power
     * @param float $y A number that specifies a power
     * @return float The number x raised to the power y
     */
    public static function Pow($x, $y){
      return pow($x, $y);
    }
    
    /**
     * Rounds a value to the nearest integer.
     * @param float $a A number to be rounded
     * @return float The integer nearest to a
     */
    public static function Round($a){
      return round($a);
    }
    
    /**
     * Returns an integer that indicates the sign of a number.
     * @param float $value A signed number
     * @return int A number that indicates the sign of value
     */
    public static function Sign($value){
      if($value > 0) return 1;
      if($value < 0) return -1;
      return 0;
    }
    
    /**
     * Returns the sine of the specified angle.
     * @param float $a An angle, measured in radians
     * @return float The sine of a
     */
    public static function Sin($a){
      return sin($a);
    }
    
    /**
     * Returns the hyperbolic sine of the specified angle.
     * @param float $value An angle, measured in radians
     * @return float The hyperbolic sine of value
     */
    public static function Sinh($value){
      return sinh($value);
    }
    
    /**
     * Returns the square root of a specified number.
     * @param float $d A number
     * @return float The positive square root of d
     */
    public static function Sqrt($d){
      if($d < 0){
        throw new ArgumentOutOfRangeException("d", $d, "Cannot calculate square root of negative number");
      }
      return sqrt($d);
    }
    
    /**
     * Returns the tangent of the specified angle.
     * @param float $a An angle, measured in radians
     * @return float The tangent of a
     */
    public static function Tan($a){
      return tan($a);
    }
    
    /**
     * Returns the hyperbolic tangent of the specified angle.
     * @param float $value An angle, measured in radians
     * @return float The hyperbolic tangent of value
     */
    public static function Tanh($value){
      return tanh($value);
    }
    
    /**
     * Calculates the integral part of a specified number.
     * @param float $d A number to truncate
     * @return float The integral part of d
     */
    public static function Truncate($d){
      return $d < 0 ? ceil($d) : floor($d);
    }
  }
}