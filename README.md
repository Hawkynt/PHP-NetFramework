# 🐘 PHP-NetFramework

[![License](https://img.shields.io/github/license/Hawkynt/PHP-NetFramework)](https://github.com/Hawkynt/PHP-NetFramework/blob/main/LICENSE)
[![Language](https://img.shields.io/github/languages/top/Hawkynt/PHP-NetFramework?color=8957D5)](https://github.com/Hawkynt/PHP-NetFramework)

[![CI](https://github.com/Hawkynt/PHP-NetFramework/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/Hawkynt/PHP-NetFramework/actions/workflows/ci.yml)
![Last Commit](https://img.shields.io/github/last-commit/Hawkynt/PHP-NetFramework?branch=main)
![Activity](https://img.shields.io/github/commit-activity/m/Hawkynt/PHP-NetFramework)

[![Stars](https://img.shields.io/github/stars/Hawkynt/PHP-NetFramework?color=FFD700)](https://github.com/Hawkynt/PHP-NetFramework/stargazers)
[![Forks](https://img.shields.io/github/forks/Hawkynt/PHP-NetFramework?color=008080)](https://github.com/Hawkynt/PHP-NetFramework/network/members)
[![Issues](https://img.shields.io/github/issues/Hawkynt/PHP-NetFramework)](https://github.com/Hawkynt/PHP-NetFramework/issues)
![Code Size](https://img.shields.io/github/languages/code-size/Hawkynt/PHP-NetFramework?color=4CAF50)
![Repo Size](https://img.shields.io/github/repo-size/Hawkynt/PHP-NetFramework?color=FF9800)

> 🚀 A comprehensive clone of the .NET Framework Base Class Library (BCL) implemented in pure PHP.

## 📖 Overview

PHP-NetFramework brings the familiar .NET programming model to PHP, providing a rich set of classes and APIs that mirror the .NET Framework's Base Class Library. This project enables developers to write PHP code using .NET-style patterns, object-oriented design, and familiar APIs, making it easier for .NET developers to transition to PHP while maintaining consistent programming practices.

## ✨ Features

### ✅ Fully Implemented
- **🏗️ Object Hierarchy**: Complete object-oriented hierarchy starting from System\Object
- **⚠️ Exception Handling**: Comprehensive exception hierarchy with custom exception types
- **📝 Enhanced String Operations**: System\String class with comprehensive manipulation methods (Contains, IndexOf, Replace, Split, Trim, etc.)
- **💰 High-Precision Decimal**: System\Decimal for accurate financial and scientific calculations with BCMath support
- **⏱️ Time Intervals**: System\TimeSpan for representing and manipulating time durations
- **📁 File I/O Operations**: System\IO\File for file manipulation (binary/text read/write, existence checks)
- **🛤️ Path Utilities**: System\IO\Path for cross-platform path manipulation and validation
- **📄 File Information**: System\IO\FileInfo for detailed file metadata and operations
- **📂 Directory Information**: System\IO\DirectoryInfo for directory management and enumeration
- **📦 Collections**: Hashtable, Array, and enumerable collections with .NET-compatible APIs
- **🔍 LINQ-to-Objects**: Full implementation including Select, Where, OrderBy, First, Any, All, Count
- **📋 Generic Collections**: System\Collections\Generic\List and Dictionary with type-safe operations
- **🧮 Mathematical Operations**: System\Math class with mathematical functions and constants
- **📅 Date/Time**: System\DateTime with parsing, formatting, and arithmetic operations
- **🔧 Diagnostics**: Stopwatch for high-precision timing and Trace for debug output

### 🚧 Future Enhancements
- **🧵 Threading Support**: Advanced threading capabilities and synchronization primitives
- **🖥️ GUI Components**: MessageBox and dialog functionality
- **🏢 Directory Services**: Active Directory integration and authentication

## 📂 Project Structure

```
PHP-NetFramework/
├── System.php                     # Enhanced String class with comprehensive methods
├── System.Object.php              # Base Object class for all objects
├── System.Exception.php           # Complete exception hierarchy
├── System.Math.php                # Mathematical functions and constants
├── System.Decimal.php             # High-precision decimal arithmetic
├── System.TimeSpan.php            # Time interval representation
├── System.DateTime.php            # Date/time functionality
├── System.Collections.php         # Hashtable, IEnumerable, IEnumerator
├── System.Collections.Generic.php # Generic List and Dictionary
├── System.Array.php               # Enhanced Array with LINQ methods
├── System.Diagnostics.php         # Stopwatch and Trace classes
├── System.IO.php                  # File/Directory operations (File, Path, FileInfo, DirectoryInfo)
├── tests/                         # Comprehensive test suite
│   ├── test_framework.php         # Complete integration tests
│   ├── simple_test.php            # Basic functionality verification
│   ├── syntax_check.php           # PHP syntax validation
│   ├── TestRunner.php             # Automated test execution
│   └── README.md                  # Test documentation
└── [Future expansions]
    ├── System.Threading.php        # Threading support
    ├── System.Windows.Forms.php    # GUI components
    └── System.DirectoryServices.php # Directory services
```

## 💡 Usage Examples

### 🏗️ Object Hierarchy and Basic Operations
```php
<?php
require_once 'System.Object.php';
require_once 'System.Exception.php';
use System\Object;
use System\ArgumentNullException;

// All classes inherit from Object
$obj = new Object();
echo $obj->ToString();        // "System\Object"
echo $obj->GetType();         // "System\Object"
$hash = $obj->GetHashCode();  // Unique hash for object

// Exception handling
try {
    throw new ArgumentNullException("paramName", "Value cannot be null");
} catch (ArgumentNullException $e) {
    echo $e->getMessage();
}
?>
```

### 📝 Enhanced String Operations
```php
<?php
require_once 'System.php';
use System\String;

// Create string instances
$str = new String("Hello, World!");
echo $str->getLength();           // 13
echo $str->get(0);               // "H"
echo $str->Contains("World");    // true
echo $str->IndexOf("o");         // 4

// String manipulation
$upper = $str->ToUpper();        // "HELLO, WORLD!"
$parts = $str->Split(", ");      // Array of String objects
$trimmed = $str->Trim();         // Removes whitespace
$replaced = $str->Replace("World", "PHP"); // "Hello, PHP!"

// Substring operations
$sub = $str->Substring(7, 5);    // "World"
echo $str->StartsWith("Hello"); // true
echo $str->EndsWith("!");       // true

// Static methods
$formatted = String::Format("Hello {0}, you have {1} messages!", "John", 5);
$joined = String::Join(", ", ["apple", "banana", "cherry"]);
echo String::IsNullOrEmpty("");  // true
?>
```

### 📦 Collections and LINQ Operations
```php
<?php
require_once 'System.Collections.php';
require_once 'System.Collections.Generic.php';
require_once 'System.Array.php';
use System\Collections\Hashtable;
use System\Collections\Generic\List;
use System\Collections\Generic\Dictionary;
use System\Array;

// Generic List operations
$list = new List();
$list->Add("apple");
$list->Add("banana");
$list->Add("cherry");
$list->Insert(1, "blueberry");
echo $list->getCount();          // 4
echo $list->get(0);             // "apple"
$list->Remove("banana");
$array = $list->ToArray();

// Generic Dictionary operations  
$dict = new Dictionary();
$dict->Add("name", "John");
$dict->Add("age", 30);
$dict->set("city", "New York");
echo $dict->get("name");        // "John"
$hasKey = $dict->ContainsKey("age");
$value = null;
$found = $dict->TryGetValue("city", $value);

// LINQ operations on Arrays
$numbers = new Array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
$evenSquares = $numbers
    ->Where(function($x) { return $x % 2 == 0; })
    ->Select(function($x) { return $x * $x; })
    ->OrderByDescending()
    ->ToArray();
// Result: [100, 64, 36, 16, 4]

// More LINQ examples
$hasEvens = $numbers->Any(function($x) { return $x % 2 == 0; });
$allPositive = $numbers->All(function($x) { return $x > 0; });
$first = $numbers->First(function($x) { return $x > 5; });
?>
```

### 🧮 Mathematical and Decimal Operations
```php
<?php
require_once 'System.Math.php';
require_once 'System.Decimal.php';
use System\Math;
use System\Decimal;

// Mathematical constants and functions
echo Math::PI;                    // 3.14159...
echo Math::E;                     // 2.71828...
$result = Math::Sqrt(16);         // 4
$power = Math::Pow(2, 8);         // 256
$rounded = Math::Round(3.7);      // 4
$max = Math::Max(10, 5);          // 10

// High-precision decimal arithmetic
$price = new Decimal("19.99", 2);
$tax = new Decimal("0.08", 2);
$total = $price->Add($price->Multiply($tax));
echo $total->ToString(2);         // "21.59"

// Financial calculations with precision
$principal = new Decimal("1000.00");
$rate = new Decimal("0.05");
$compound = $principal->Multiply($rate)->Add($principal);
echo $compound->ToString();       // Precise calculation without floating-point errors

// Decimal comparisons and operations
$a = new Decimal("10.50");
$b = new Decimal("10.49");
echo $a->CompareTo($b);          // 1 (greater than)
echo $a->Equals($b);             // false
?>
```

### 📅 Date/Time and TimeSpan Operations
```php
<?php
require_once 'System.DateTime.php';
require_once 'System.TimeSpan.php';
use System\DateTime;
use System\TimeSpan;

// Date/time creation and manipulation
$now = DateTime::getNow();
$today = DateTime::getToday();
$birthday = new DateTime(1990, 12, 25);

// Date arithmetic
$futureDate = $now->AddDays(30);
$pastDate = $now->AddHours(-5);

// Formatting and parsing
echo $now->ToString("yyyy-MM-dd HH:mm:ss");
$parsed = DateTime::Parse("2023-12-25 15:30:00");

// TimeSpan for time intervals
$duration = new TimeSpan(1, 2, 30, 45);  // 1 day, 2 hours, 30 minutes, 45 seconds
echo $duration->getTotalHours();          // Total hours in the timespan
echo $duration->ToString();               // "1.02:30:45.000"

// TimeSpan arithmetic
$start = DateTime::getNow();
$end = $start->AddHours(5);
// $elapsed = $end->Subtract($start);     // Would return TimeSpan

// Creating TimeSpans from different units
$hours = TimeSpan::FromHours(2.5);       // 2.5 hours
$minutes = TimeSpan::FromMinutes(90);    // 90 minutes  
$seconds = TimeSpan::FromSeconds(3600);  // 3600 seconds (1 hour)

// TimeSpan parsing
$parsed = TimeSpan::Parse("1.05:30:00"); // 1 day, 5 hours, 30 minutes
?>
```

### 🔧 Diagnostics and Performance
```php
<?php
require_once 'System.Diagnostics.php';
use System\Diagnostics\Stopwatch;
use System\Diagnostics\Trace;

// High-precision timing
$stopwatch = Stopwatch::StartNew();
// ... some operation ...
$stopwatch->Stop();
echo $stopwatch->getElapsedMilliseconds(); // Elapsed time in ms

// Debug tracing
Trace::WriteLine("Application started");
Trace::Assert(true, "This should not fail");
Trace::WriteLineFormat("User {0} logged in at {1}", "John", $now->ToString());
?>
```

### 📁 File and Directory Operations
```php
<?php
require_once 'System.IO.php';
use System\IO\File;
use System\IO\Path;
use System\IO\FileInfo;
use System\IO\DirectoryInfo;

// Static file operations
$content = File::ReadAllText("example.txt");
File::WriteAllBytes("output.bin", $binaryData);

// Path manipulation
$combined = Path::Combine("folder", "subfolder", "file.txt");
$directory = Path::GetDirectoryName($combined);
$filename = Path::GetFileNameWithoutExtension($combined);

// FileInfo for detailed file operations
$fileInfo = new FileInfo("document.pdf");
if ($fileInfo->getExists()) {
    echo $fileInfo->getLength();         // File size in bytes
    echo $fileInfo->getExtension();      // ".pdf"
    echo $fileInfo->getName();           // "document.pdf"
    echo $fileInfo->getLastWriteTime()->ToString();
    
    // Copy, move, delete operations
    $copy = $fileInfo->CopyTo("backup.pdf");
    $fileInfo->MoveTo("archive/document.pdf");
    $fileInfo->Delete();
}

// DirectoryInfo for directory operations
$dirInfo = new DirectoryInfo("MyFolder");
if (!$dirInfo->getExists()) {
    $dirInfo->Create();
}

// Enumerate files and subdirectories
$files = $dirInfo->GetFiles("*.txt");
$subdirs = $dirInfo->GetDirectories();

foreach ($files as $file) {
    echo $file->getName() . " - " . $file->getLength() . " bytes\n";
}

// Directory operations
$dirInfo->MoveTo("NewLocation");
$dirInfo->Delete(true); // Recursive delete
?>
```

## 🧪 Testing

The framework includes a comprehensive test suite to verify functionality:

### Quick Testing
```bash
# Run basic functionality test
php tests/simple_test.php

# Verify syntax of all files
php tests/syntax_check.php
```

### Comprehensive Testing
```bash
# Run complete test suite
php tests/test_framework.php

# Run all tests with reporting
php tests/TestRunner.php
```

See [`tests/README.md`](tests/README.md) for detailed testing documentation.

## 📦 Installation and Dependencies

This is a pure PHP implementation requiring no compilation or external dependencies beyond standard PHP.

### 📋 Requirements
- PHP 5.3+ (designed for broad compatibility)
- No external dependencies required

### ⚡ Installation
```bash
# Clone the repository
git clone https://github.com/Hawkynt/PHP-NetFramework.git

# Include required files in your PHP project
require_once 'path/to/PHP-NetFramework/System.Object.php';
require_once 'path/to/PHP-NetFramework/System.Exception.php';
require_once 'path/to/PHP-NetFramework/System.php';                    # Enhanced String
require_once 'path/to/PHP-NetFramework/System.Decimal.php';            # High-precision decimals
require_once 'path/to/PHP-NetFramework/System.TimeSpan.php';           # Time intervals
require_once 'path/to/PHP-NetFramework/System.Collections.php';        # Basic collections
require_once 'path/to/PHP-NetFramework/System.Collections.Generic.php'; # Generic List/Dictionary
require_once 'path/to/PHP-NetFramework/System.Array.php';              # LINQ arrays
require_once 'path/to/PHP-NetFramework/System.Math.php';               # Math functions
require_once 'path/to/PHP-NetFramework/System.DateTime.php';           # Date/time
require_once 'path/to/PHP-NetFramework/System.Diagnostics.php';        # Diagnostics
require_once 'path/to/PHP-NetFramework/System.IO.php';                 # File/Directory I/O

# Or include only what you need for your specific use case
```

## 🤝 Sister Projects

This project is part of a multi-language effort to bring .NET Framework functionality to various programming languages:

- **🐪 [Perl-NetFramework](https://github.com/Hawkynt/Perl-NetFramework)** - .NET BCL implementation in Perl
- **🐘 [PHP-NetFramework](https://github.com/Hawkynt/PHP-NetFramework)** - .NET BCL implementation in PHP

## 🛠️ Development and Contributing

### 🏛️ Architecture Principles
- **Object-Oriented Design**: Classes follow .NET naming conventions and design patterns
- **Namespace Organization**: Mirrors .NET Framework namespace hierarchy
- **Cross-Platform Compatibility**: Handles platform differences (e.g., directory separators)
- **Backward Compatibility**: Targets older PHP versions where possible

### 📝 Contributing Guidelines
When contributing to this project:

1. Maintain compatibility with .NET BCL APIs and naming conventions
2. Follow the established namespace hierarchy (System\, System\IO\, etc.)
3. Include comprehensive PHPDoc documentation
4. Ensure cross-platform compatibility
5. Add appropriate error handling and exceptions
6. Write examples demonstrating new functionality

### 🎨 Code Style
- Use .NET-style PascalCase for public methods and properties
- Use PHP-style camelCase for private methods (prefixed with underscore)
- Include comprehensive documentation following PHPDoc standards
- Maintain namespace organization matching .NET Framework structure

## 🗺️ Roadmap

### ✅ **Phase 1: Core Foundation (COMPLETED)**
1. **🏗️ Core Types**: Object, String, Math, DateTime ✅
2. **📦 Collections**: Array, Hashtable, IEnumerable/IEnumerator ✅
3. **🔍 LINQ**: Query operators and enumerable extensions ✅
4. **📁 I/O**: File system and path operations ✅
5. **⚠️ Exceptions**: Comprehensive exception hierarchy ✅
6. **🔧 Diagnostics**: Stopwatch and Trace functionality ✅

### 🚧 **Phase 2: Advanced Features (FUTURE)**
1. **🧵 Threading**: Advanced thread support and synchronization primitives
2. **🖥️ GUI Components**: MessageBox and dialog functionality
3. **🏢 Directory Services**: Active Directory integration and authentication
4. **📊 Data Access**: Database connectivity and ORM-like features
5. **🌐 Networking**: HTTP client and web service functionality
6. **🔐 Security**: Cryptography and authentication frameworks

## 📄 License

This project is licensed under the GNU Lesser General Public License v3.0 or later. This ensures the code remains free and open source while allowing integration into proprietary applications. See the LICENSE file for complete details.

## 🆘 Support

- **🐛 Issues**: Report bugs and feature requests on the project's issue tracker
- **📚 Documentation**: Comprehensive examples and API documentation
- **👥 Community**: Open source community-driven development
