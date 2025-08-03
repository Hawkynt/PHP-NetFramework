<?php

// Basic syntax verification
echo "🔍 PHP Syntax Verification\n";
echo "=========================\n\n";

$files = [
    '../System.Object.php',
    '../System.Exception.php', 
    '../System.php',
    '../System.Decimal.php',
    '../System.TimeSpan.php',
    '../System.Math.php',
    '../System.DateTime.php',
    '../System.Collections.php',
    '../System.Collections.Generic.php',
    '../System.Array.php',
    '../System.Diagnostics.php',
    '../System.IO.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $result = shell_exec("php -l $file 2>&1");
        if (strpos($result, 'No syntax errors detected') !== false) {
            echo "✅ $file - Syntax OK\n";
        } else {
            echo "❌ $file - Syntax Error: $result\n";
        }
    } else {
        echo "⚠️  $file - File not found\n";
    }
}

echo "\n🎯 Now testing basic instantiation...\n";

try {
    // Test each class can be instantiated
    require_once '../System.Object.php';
    $obj = new System\BaseObject();
    echo "✅ System\\Object instantiated\n";
    
    require_once '../System.Exception.php';
    echo "✅ System\\Exception classes loaded\n";
    
    require_once '../System.php';
    $str = new System\StringObject("test");
    echo "✅ System\\String instantiated\n";
    
    require_once '../System.Math.php';
    echo "✅ System\\Math loaded: PI = " . System\Math::PI . "\n";
    
    echo "\n🎉 Basic framework components are working!\n";
    
} catch (Error $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}

?>