# 🧪 PHP-NetFramework Tests

This directory contains comprehensive tests for the PHP-NetFramework implementation.

## 📁 Test Files

### Core Test Suites
- **`test_framework.php`** - Comprehensive integration test covering all major components
- **`simple_test.php`** - Quick verification test for basic functionality  
- **`syntax_check.php`** - PHP syntax validation for all framework files

### Individual Component Tests
- **`ObjectTests.php`** - Tests for System\Object base class
- **`StringTests.php`** - Tests for enhanced System\String operations
- **`MathTests.php`** - Tests for System\Math mathematical functions
- **`DecimalTests.php`** - Tests for System\Decimal high-precision arithmetic
- **`TimeSpanTests.php`** - Tests for System\TimeSpan time intervals
- **`DateTimeTests.php`** - Tests for System\DateTime functionality
- **`CollectionsTests.php`** - Tests for collection classes
- **`LinqTests.php`** - Tests for LINQ operations
- **`IOTests.php`** - Tests for file and directory operations
- **`DiagnosticsTests.php`** - Tests for diagnostic tools

### Test Utilities
- **`TestRunner.php`** - Test runner and reporting utilities
- **`TestBase.php`** - Base class for unit tests

## 🚀 Running Tests

### Quick Verification
```bash
# Run basic functionality test
php tests/simple_test.php

# Check syntax of all files
php tests/syntax_check.php
```

### Comprehensive Testing
```bash
# Run full test suite
php tests/test_framework.php

# Run individual test files
php tests/ObjectTests.php
php tests/StringTests.php
# ... etc
```

### All Tests
```bash
# Run all tests with reporting
php tests/TestRunner.php
```

## 📊 Test Coverage

The test suite covers:
- ✅ **Core Classes**: Object hierarchy, exceptions, string operations
- ✅ **Mathematical**: Math functions, decimal arithmetic  
- ✅ **Date/Time**: DateTime creation, parsing, arithmetic, TimeSpan intervals
- ✅ **Collections**: Hashtables, generic collections, LINQ operations
- ✅ **File I/O**: File operations, directory management, path utilities
- ✅ **Diagnostics**: Performance timing, debug tracing
- ✅ **Integration**: Cross-component functionality and compatibility

## 🎯 Expected Results

All tests should pass for a properly functioning framework. Failed tests indicate:
- Implementation bugs
- PHP version compatibility issues  
- Missing dependencies
- Environment configuration problems

## 🔧 Troubleshooting

If tests fail:
1. Check PHP version (5.3+ required)
2. Verify all framework files are present
3. Check file permissions
4. Review error messages for specific issues
5. Run `syntax_check.php` to identify syntax errors

## 📝 Adding New Tests

When adding new framework features:
1. Create corresponding test file in this directory
2. Follow existing test patterns and naming conventions
3. Update this README with new test descriptions
4. Add new tests to the TestRunner for automated execution