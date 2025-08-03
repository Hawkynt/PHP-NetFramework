<?php

/**
 * Test Runner for PHP-NetFramework
 * Executes all test files and provides comprehensive reporting
 */

echo "🧪 PHP-NetFramework Test Runner\n";
echo "===============================\n\n";

$testFiles = [
    'syntax_check.php' => 'Syntax Validation',
    'simple_test.php' => 'Basic Functionality', 
    'test_framework.php' => 'Comprehensive Integration'
];

$totalTests = 0;
$passedSuites = 0;
$results = [];

foreach ($testFiles as $file => $description) {
    echo "🔄 Running: $description ($file)\n";
    echo str_repeat("-", 50) . "\n";
    
    if (!file_exists($file)) {
        echo "❌ Test file not found: $file\n\n";
        $results[$file] = ['status' => 'missing', 'output' => 'File not found'];
        continue;
    }
    
    // Capture output
    ob_start();
    $startTime = microtime(true);
    
    try {
        include $file;
        $status = 'passed';
        $passedSuites++;
    } catch (Exception $e) {
        $status = 'failed';
        echo "❌ Exception: " . $e->getMessage() . "\n";
    } catch (Error $e) {
        $status = 'error';
        echo "💥 Fatal Error: " . $e->getMessage() . "\n";
    }
    
    $endTime = microtime(true);
    $output = ob_get_clean();
    $duration = round(($endTime - $startTime) * 1000, 2);
    
    echo $output;
    echo "\n⏱️  Duration: {$duration}ms\n";
    echo str_repeat("=", 50) . "\n\n";
    
    $results[$file] = [
        'status' => $status,
        'duration' => $duration,
        'output' => $output
    ];
    
    $totalTests++;
}

// Final Report
echo "📊 TEST SUMMARY\n";
echo "===============\n\n";

foreach ($results as $file => $result) {
    $statusIcon = [
        'passed' => '✅',
        'failed' => '❌', 
        'error' => '💥',
        'missing' => '⚠️'
    ][$result['status']];
    
    $duration = isset($result['duration']) ? " ({$result['duration']}ms)" : "";
    echo "$statusIcon $file$duration\n";
}

echo "\n📈 RESULTS\n";
echo "----------\n";
echo "Test Suites: $totalTests\n";
echo "Passed: $passedSuites\n";
echo "Failed: " . ($totalTests - $passedSuites) . "\n";

if ($passedSuites === $totalTests) {
    echo "\n🎉 ALL TEST SUITES PASSED!\n";
    echo "✅ PHP-NetFramework is working correctly.\n";
    echo "🚀 Framework is ready for production use!\n";
} else {
    echo "\n⚠️  SOME TESTS FAILED\n";
    echo "❌ Please check the test output above for details.\n";
    echo "🔧 Review and fix issues before using the framework.\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "Test run completed at " . date('Y-m-d H:i:s') . "\n";

?>