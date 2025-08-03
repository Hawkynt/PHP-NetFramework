<?php

// Simple test to verify basic functionality works
echo "🔍 Quick Framework Verification\n";
echo "==============================\n\n";

// Test individual components
try {
    // Test 1: Basic Object
    require_once '../System.Object.php';
    require_once '../System.Exception.php';
    
    $obj = new System\Object();
    echo "✅ Object: " . $obj->ToString() . "\n";
    
    // Test 2: String operations
    require_once '../System.php';
    $str = new System\String("Hello World");
    echo "✅ String: Length=" . $str->getLength() . ", Upper=" . $str->ToUpper()->ToString() . "\n";
    
    // Test 3: Math operations
    require_once '../System.Math.php';
    echo "✅ Math: PI=" . System\Math::PI . ", Sqrt(16)=" . System\Math::Sqrt(16) . "\n";
    
    // Test 4: Decimal
    require_once '../System.Decimal.php';
    $dec = new System\Decimal("10.50");
    echo "✅ Decimal: " . $dec->ToString() . "\n";
    
    // Test 5: TimeSpan
    require_once '../System.TimeSpan.php';
    $ts = new System\TimeSpan(1, 2, 30, 0);
    echo "✅ TimeSpan: " . $ts->ToString() . "\n";
    
    // Test 6: Collections
    require_once '../System.Collections.php';
    $hash = new System\Collections\Hashtable();
    $hash->Add("key", "value");
    echo "✅ Hashtable: Count=" . $hash->getCount() . "\n";
    
    // Test 7: Generic Collections
    require_once '../System.Collections.Generic.php';
    $list = new System\Collections\Generic\List();
    $list->Add("item1");
    $list->Add("item2");
    echo "✅ Generic List: Count=" . $list->getCount() . "\n";
    
    // Test 8: Array with LINQ
    require_once '../System.Array.php';
    $arr = new System\Array([1, 2, 3, 4, 5]);
    $evens = $arr->Where(function($x) { return $x % 2 == 0; });
    echo "✅ LINQ Array: Count=" . $arr->getCount() . ", Evens=" . $evens->getCount() . "\n";
    
    // Test 9: DateTime
    require_once '../System.DateTime.php';
    $now = System\DateTime::getNow();
    echo "✅ DateTime: Year=" . $now->getYear() . "\n";
    
    // Test 10: Diagnostics
    require_once '../System.Diagnostics.php';
    $sw = new System\Diagnostics\Stopwatch();
    $sw->Start();
    usleep(1000);
    $sw->Stop();
    echo "✅ Stopwatch: Elapsed=" . $sw->getElapsedMilliseconds() . "ms\n";
    
    echo "\n🎉 All basic components working correctly!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}

?>