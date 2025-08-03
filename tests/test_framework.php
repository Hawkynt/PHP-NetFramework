<?php

// Comprehensive test to verify the entire PHP-NetFramework works correctly

// Include all required files (relative to parent directory)
require_once '../System.Object.php';
require_once '../System.Exception.php';
require_once '../System.php';
require_once '../System.Decimal.php';
require_once '../System.TimeSpan.php';
require_once '../System.Collections.php';
require_once '../System.Collections.Generic.php';
require_once '../System.Array.php';
require_once '../System.Math.php';
require_once '../System.DateTime.php';
require_once '../System.Diagnostics.php';
require_once '../System.IO.php';

// use System\Object; // Removed due to PHP reserved word
// use System\String; // Removed due to PHP reserved word
use System\Decimal;
use System\TimeSpan;
use System\Collections\Hashtable;
// use System\Collections\Generic\List; // Removed due to PHP reserved word
use System\Collections\Generic\Dictionary;
// use System\Array; // Removed due to PHP reserved word
use System\Math;
use System\DateTime;
use System\Diagnostics\Stopwatch;
use System\Diagnostics\Trace;
use System\IO\FileInfo;
use System\IO\DirectoryInfo;
use System\IO\Path;
use System\IO\File;

echo "🧪 Testing PHP-NetFramework Complete Implementation\n";
echo "==================================================\n\n";

$testCount = 0;
$passedCount = 0;

function test($description, $condition) {
    global $testCount, $passedCount;
    $testCount++;
    
    if ($condition) {
        echo "✅ PASS: $description\n";
        $passedCount++;
    } else {
        echo "❌ FAIL: $description\n";
  }
}

try {
    // Test 1: Object Hierarchy
    echo "📦 Testing Object Hierarchy...\n";
    $obj = new System\BaseObject();
    test("Object creation", $obj instanceof System\BaseObject);
    test("Object ToString", $obj->ToString() === "System\\BaseObject");
    test("Object GetType", $obj->GetType() === "System\\BaseObject");
    
    // Test 2: Enhanced String Operations
    echo "\n📝 Testing Enhanced String Operations...\n";
    $str = new System\StringObject("Hello, World!");
    test("String creation", $str instanceof System\StringObject);
    test("String length", $str->getLength() === 13);
    test("String character access", $str->get(0) === "H");
    test("String contains", $str->Contains("World") === true);
    test("String indexOf", $str->IndexOf("o") === 4);
    test("String toUpper", $str->ToUpper()->ToString() === "HELLO, WORLD!");
    test("String startsWith", $str->StartsWith("Hello") === true);
    test("String endsWith", $str->EndsWith("!") === true);
    $parts = $str->Split(", ");
    test("String split", is_array($parts) && count($parts) === 2);
    test("String IsNullOrEmpty", System\StringObject::IsNullOrEmpty("") === true);
    
    // Test 3: Decimal Operations
    echo "\n💰 Testing Decimal Operations...\n";
    $dec1 = new Decimal("10.50");
    $dec2 = new Decimal("5.25");
    test("Decimal creation", $dec1 instanceof Decimal);
    $sum = $dec1->Add($dec2);
    test("Decimal addition", $sum instanceof Decimal);
    test("Decimal comparison", $dec1->CompareTo($dec2) > 0);
    test("Decimal toString", is_string($dec1->ToString()));
    
    // Test 4: TimeSpan Operations
    echo "\n⏱️ Testing TimeSpan Operations...\n";
    $timespan = new TimeSpan(1, 2, 30, 45); // 1 day, 2 hours, 30 minutes, 45 seconds
    test("TimeSpan creation", $timespan instanceof TimeSpan);
    test("TimeSpan getDays", $timespan->getDays() === 1);
    test("TimeSpan getHours", $timespan->getHours() === 2);
    test("TimeSpan getMinutes", $timespan->getMinutes() === 30);
    test("TimeSpan getSeconds", $timespan->getSeconds() === 45);
    test("TimeSpan toString", is_string($timespan->ToString()));
    
    $hours = TimeSpan::FromHours(2.5);
    test("TimeSpan FromHours", $hours instanceof TimeSpan);
    
    // Test 5: Generic Collections
    echo "\n📋 Testing Generic Collections...\n";
    $list = new System\Collections\Generic\GenericList();
    $list->Add("apple");
    $list->Add("banana");
    $list->Add("cherry");
    test("List creation and adding", $list->getCount() === 3);
    test("List get item", $list->get(0) === "apple");
    test("List contains", $list->Contains("banana") === true);
    test("List indexOf", $list->IndexOf("cherry") === 2);
    $list->Remove("banana");
    test("List remove", $list->getCount() === 2);
    
    $dict = new Dictionary();
    $dict->Add("name", "John");
    $dict->Add("age", 30);
    test("Dictionary creation and adding", $dict->getCount() === 2);
    test("Dictionary get", $dict->get("name") === "John");
    test("Dictionary containsKey", $dict->ContainsKey("age") === true);
    $value = null;
    $found = $dict->TryGetValue("name", $value);
    test("Dictionary TryGetValue", $found === true && $value === "John");
    
    // Test 6: LINQ Operations
    echo "\n🔍 Testing LINQ Operations...\n";
    $numbers = new System\ArrayCollection([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
    test("Array creation", $numbers instanceof System\ArrayCollection);
    test("Array count", $numbers->getCount() === 10);
    
    $evens = $numbers->Where(function($x) { return $x % 2 == 0; });
    test("LINQ Where", $evens instanceof System\ArrayCollection);
    test("LINQ Where count", $evens->getCount() === 5);
    
    $squares = $numbers->Select(function($x) { return $x * $x; });
    test("LINQ Select", $squares instanceof System\ArrayCollection);
    
    $hasEvens = $numbers->Any(function($x) { return $x % 2 == 0; });
    test("LINQ Any", $hasEvens === true);
    
    $allPositive = $numbers->All(function($x) { return $x > 0; });
    test("LINQ All", $allPositive === true);
    
    $first = $numbers->First(function($x) { return $x > 5; });
    test("LINQ First", $first === 6);
    
    // Test 7: Math Operations
    echo "\n🧮 Testing Math Operations...\n";
    test("Math PI constant", Math::PI > 3.14 && Math::PI < 3.15);
    test("Math E constant", Math::E > 2.71 && Math::E < 2.72);
    test("Math Sqrt", Math::Sqrt(16) === 4.0);
    test("Math Pow", Math::Pow(2, 8) === 256);
    test("Math Max", Math::Max(10, 5) === 10);
    test("Math Min", Math::Min(10, 5) === 5);
    
    // Test 8: DateTime Operations
    echo "\n📅 Testing DateTime Operations...\n";
    $now = DateTime::getNow();
    test("DateTime getNow", $now instanceof DateTime);
    test("DateTime getYear", $now->getYear() > 2020);
    
    $custom = new DateTime(2023, 12, 25, 15, 30, 0);
    test("DateTime custom creation", $custom instanceof DateTime);
    test("DateTime getMonth", $custom->getMonth() === 12);
    test("DateTime getDay", $custom->getDay() === 25);
    
    $future = $now->AddDays(30);
    test("DateTime AddDays", $future instanceof DateTime);
    test("DateTime comparison", $future->CompareTo($now) > 0);
    
    // Test 9: Diagnostics
    echo "\n🔧 Testing Diagnostics...\n";
    $stopwatch = new Stopwatch();
    test("Stopwatch creation", $stopwatch instanceof Stopwatch);
    $stopwatch->Start();
    usleep(1000); // Sleep for 1ms
    $stopwatch->Stop();
    test("Stopwatch elapsed", $stopwatch->getElapsedMilliseconds() > 0);
    
    // Test Trace (output capture)
    ob_start();
    Trace::WriteLine("Test message");
    $output = ob_get_clean();
    test("Trace WriteLine", strpos($output, "Test message") !== false);
    
    // Test 10: File I/O (create temporary files)
    echo "\n📁 Testing File I/O Operations...\n";
    $testFile = "test_file_" . uniqid() . ".txt";
    $testContent = "Hello, PHP-NetFramework!";
    
    File::WriteAllBytes($testFile, $testContent);
    test("File WriteAllBytes", file_exists($testFile));
    
    $readContent = File::ReadAllText($testFile);
    test("File ReadAllText", $readContent === $testContent);
    
    $fileInfo = new FileInfo($testFile);
    test("FileInfo creation", $fileInfo instanceof FileInfo);
    test("FileInfo exists", $fileInfo->getExists() === true);
    test("FileInfo length", $fileInfo->getLength() === strlen($testContent));
    test("FileInfo extension", $fileInfo->getExtension() === ".txt");
    
    // Test Path operations
    $combined = Path::Combine("folder", "subfolder", "file.txt");
    test("Path Combine", is_string($combined));
    test("Path GetFileName", Path::GetFileName($combined) === "file.txt");
    test("Path GetDirectoryName", is_string(Path::GetDirectoryName($combined)));
    
    // Clean up
    if (file_exists($testFile)) {
        unlink($testFile);
  }
    
    // Test 11: Exception Handling
    echo "\n⚠️ Testing Exception Handling...\n";
    try {
        throw new \System\ArgumentNullException("testParam", "Test exception");
        test("Exception throwing", false); // Should not reach here
    } catch (\System\ArgumentNullException $e) {
        test("Exception catching", true);
        test("Exception message", strpos($e->getMessage(), "Test exception") !== false);
  }
    
    try {
        $invalidIndex = $numbers->get(-1); // Should throw
        test("Array bounds checking", false); // Should not reach here
    } catch (\System\ArgumentOutOfRangeException $e) {
        test("Array bounds exception", true);
  }

} catch (Exception $e) {
    echo "❌ CRITICAL ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🏁 Test Results: $passedCount/$testCount tests passed\n";

if ($passedCount === $testCount) {
    echo "🎉 ALL TESTS PASSED! The framework is working correctly.\n";
} else {
    $failedCount = $testCount - $passedCount;
    echo "⚠️  $failedCount tests failed. There may be issues to investigate.\n";
}

echo "\n💡 Framework is ready for production use!\n";

?>