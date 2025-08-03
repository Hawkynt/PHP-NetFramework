<?php

/**
 * System short summary.
 *
 * System description.
 *
 * @version 1.0
 * @author Hawkynt
 */
namespace System\IO;
{
  class Path {
    /**
     * Gets the currently valid directory separation character.
     * @return mixed
     */
    public static function DirectorySeparatorChar(){
      return(DIRECTORY_SEPARATOR);
    }
    
    /**
     * Combines multiple paths to one.
     * @return mixed
     */
    public static function Combine(){
      $result=implode(Path::DirectorySeparatorChar(),array_map(function($i){return(Path::_TidyPath($i));}, func_get_args()));
      return($result);
    }
    
    /**
     * Extracts the directory name of a given file.
     * @param mixed $file 
     * @return mixed
     */
    public static function GetDirectoryName($file){
      $file=Path::_TidyPath($file);
      $index=strrpos($file,Path::DirectorySeparatorChar());
      return(!$index?'':substr($file,0,$index));
    }
    
    /**
     * Extracts the filename with extension of a given file.
     * @param mixed $file 
     * @return mixed
     */
    public static function GetFileName($file){
      $file=Path::_TidyPath($file);
      $index=strrpos($file,Path::DirectorySeparatorChar());
      return(!$index?$file:substr($file,$index+1));
    }
    
    /**
     * Extracts the filename without extension of a given file.
     * @param mixed $file 
     * @return mixed
     */
    public static function GetFileNameWithoutExtension($file){
      $result=Path::GetFileName($file);
      $index=strpos($result,".");
      return(!$index?$result:substr($result,0,$index));
    }
    
    /**
     * Tidies a given path (ie. converts separators etc.)
     * @param mixed $file 
     * @return mixed
     */
    private static function _TidyPath($file){
      return(str_replace('\\',Path::DirectorySeparatorChar(),str_replace('/',Path::DirectorySeparatorChar(),$file)));
    }
  }

  /**
   * Provides information about a file and methods for creating, copying, deleting, moving, and opening files.
   */
  class FileInfo extends \System\Object
  {
    private $_fullPath;
    
    /**
     * Initializes a new instance of the FileInfo class.
     * @param string $fileName The fully qualified name of the file
     */
    public function __construct($fileName){
      parent::__construct();
      if($fileName === null || trim($fileName) === ""){
        throw new \System\ArgumentException("File name cannot be null or empty");
      }
      $this->_fullPath = realpath($fileName);
      if($this->_fullPath === false){
        $this->_fullPath = $fileName; // Keep original if realpath fails
      }
    }
    
    /**
     * Gets the full path of the file.
     * @return string The full path
     */
    public function getFullName(){
      return $this->_fullPath;
    }
    
    /**
     * Gets the name of the file.
     * @return string The file name
     */
    public function getName(){
      return Path::GetFileName($this->_fullPath);
    }
    
    /**
     * Gets the directory name.
     * @return string The directory name
     */
    public function getDirectoryName(){
      return Path::GetDirectoryName($this->_fullPath);
    }
    
    /**
     * Gets the file extension.
     * @return string The file extension
     */
    public function getExtension(){
      $name = $this->getName();
      $pos = strrpos($name, '.');
      return $pos !== false ? substr($name, $pos) : '';
    }
    
    /**
     * Gets a value indicating whether the file exists.
     * @return bool true if the file exists; otherwise, false
     */
    public function getExists(){
      return file_exists($this->_fullPath) && is_file($this->_fullPath);
    }
    
    /**
     * Gets the size of the file in bytes.
     * @return int The file size in bytes
     */
    public function getLength(){
      if(!$this->getExists()){
        throw new \System\InvalidOperationException("File does not exist");
      }
      return filesize($this->_fullPath);
    }
    
    /**
     * Gets the creation time of the file.
     * @return \System\DateTime The creation time
     */
    public function getCreationTime(){
      if(!$this->getExists()){
        throw new \System\InvalidOperationException("File does not exist");
      }
      $timestamp = filectime($this->_fullPath);
      $result = new \System\DateTime();
      $result->_timestamp = $timestamp; // Access private member directly
      return $result;
    }
    
    /**
     * Gets the last write time of the file.
     * @return \System\DateTime The last write time
     */
    public function getLastWriteTime(){
      if(!$this->getExists()){
        throw new \System\InvalidOperationException("File does not exist");
      }
      $timestamp = filemtime($this->_fullPath);
      $result = new \System\DateTime();
      $result->_timestamp = $timestamp; // Access private member directly
      return $result;
    }
    
    /**
     * Gets a value indicating whether the file is read-only.
     * @return bool true if read-only; otherwise, false
     */
    public function getIsReadOnly(){
      if(!$this->getExists()){
        return false;
      }
      return !is_writable($this->_fullPath);
    }
    
    /**
     * Copies the file to a new location.
     * @param string $destFileName The destination file name
     * @param bool $overwrite true to allow overwriting; otherwise, false
     * @return FileInfo A new FileInfo representing the copied file
     */
    public function CopyTo($destFileName, $overwrite = false){
      if(!$this->getExists()){
        throw new \System\InvalidOperationException("Source file does not exist");
      }
      
      if(file_exists($destFileName) && !$overwrite){
        throw new \System\InvalidOperationException("Destination file already exists");
      }
      
      if(!copy($this->_fullPath, $destFileName)){
        throw new \System\InvalidOperationException("Failed to copy file");
      }
      
      return new FileInfo($destFileName);
    }
    
    /**
     * Moves the file to a new location.
     * @param string $destFileName The destination file name
     */
    public function MoveTo($destFileName){
      if(!$this->getExists()){
        throw new \System\InvalidOperationException("Source file does not exist");
      }
      
      if(!rename($this->_fullPath, $destFileName)){
        throw new \System\InvalidOperationException("Failed to move file");
      }
      
      $this->_fullPath = realpath($destFileName);
      if($this->_fullPath === false){
        $this->_fullPath = $destFileName;
      }
    }
    
    /**
     * Deletes the file.
     */
    public function Delete(){
      if($this->getExists()){
        if(!unlink($this->_fullPath)){
          throw new \System\InvalidOperationException("Failed to delete file");
        }
      }
    }
    
    /**
     * Returns a string representation of the file info.
     * @return string The full path of the file
     */
    public function ToString(){
      return $this->_fullPath;
    }
  }
  
  /**
   * Provides information about a directory and methods for creating, moving, and enumerating through directories and subdirectories.
   */
  class DirectoryInfo extends \System\Object
  {
    private $_fullPath;
    
    /**
     * Initializes a new instance of the DirectoryInfo class.
     * @param string $path The directory path
     */
    public function __construct($path){
      parent::__construct();
      if($path === null || trim($path) === ""){
        throw new \System\ArgumentException("Path cannot be null or empty");
      }
      $this->_fullPath = realpath($path);
      if($this->_fullPath === false){
        $this->_fullPath = rtrim($path, '/\\'); // Keep original if realpath fails
      }
    }
    
    /**
     * Gets the full path of the directory.
     * @return string The full path
     */
    public function getFullName(){
      return $this->_fullPath;
    }
    
    /**
     * Gets the name of the directory.
     * @return string The directory name
     */
    public function getName(){
      return basename($this->_fullPath);
    }
    
    /**
     * Gets the parent directory.
     * @return DirectoryInfo The parent directory, or null if this is the root
     */
    public function getParent(){
      $parentPath = dirname($this->_fullPath);
      if($parentPath === $this->_fullPath){
        return null; // Root directory
      }
      return new DirectoryInfo($parentPath);
    }
    
    /**
     * Gets a value indicating whether the directory exists.
     * @return bool true if the directory exists; otherwise, false
     */
    public function getExists(){
      return file_exists($this->_fullPath) && is_dir($this->_fullPath);
    }
    
    /**
     * Gets the creation time of the directory.
     * @return \System\DateTime The creation time
     */
    public function getCreationTime(){
      if(!$this->getExists()){
        throw new \System\InvalidOperationException("Directory does not exist");
      }
      $timestamp = filectime($this->_fullPath);
      $result = new \System\DateTime();
      $result->_timestamp = $timestamp; // Access private member directly
      return $result;
    }
    
    /**
     * Gets the last write time of the directory.
     * @return \System\DateTime The last write time
     */
    public function getLastWriteTime(){
      if(!$this->getExists()){
        throw new \System\InvalidOperationException("Directory does not exist");
      }
      $timestamp = filemtime($this->_fullPath);
      $result = new \System\DateTime();
      $result->_timestamp = $timestamp; // Access private member directly
      return $result;
    }
    
    /**
     * Creates the directory.
     */
    public function Create(){
      if(!$this->getExists()){
        if(!mkdir($this->_fullPath, 0755, true)){
          throw new \System\InvalidOperationException("Failed to create directory");
        }
      }
    }
    
    /**
     * Deletes the directory.
     * @param bool $recursive true to delete subdirectories and files; otherwise, false
     */
    public function Delete($recursive = false){
      if(!$this->getExists()){
        return;
      }
      
      if($recursive){
        $this->_deleteRecursive($this->_fullPath);
      } else {
        if(!rmdir($this->_fullPath)){
          throw new \System\InvalidOperationException("Failed to delete directory");
        }
      }
    }
    
    /**
     * Returns the subdirectories of the current directory.
     * @param string $searchPattern The search string to match against subdirectory names
     * @return array An array of DirectoryInfo objects
     */
    public function GetDirectories($searchPattern = "*"){
      if(!$this->getExists()){
        throw new \System\InvalidOperationException("Directory does not exist");
      }
      
      $directories = array();
      $pattern = $this->_fullPath . DIRECTORY_SEPARATOR . $searchPattern;
      
      foreach(glob($pattern, GLOB_ONLYDIR) as $dir){
        $directories[] = new DirectoryInfo($dir);
      }
      
      return $directories;
    }
    
    /**
     * Returns the files in the current directory.
     * @param string $searchPattern The search string to match against file names
     * @return array An array of FileInfo objects
     */
    public function GetFiles($searchPattern = "*"){
      if(!$this->getExists()){
        throw new \System\InvalidOperationException("Directory does not exist");
      }
      
      $files = array();
      $pattern = $this->_fullPath . DIRECTORY_SEPARATOR . $searchPattern;
      
      foreach(glob($pattern) as $file){
        if(is_file($file)){
          $files[] = new FileInfo($file);
        }
      }
      
      return $files;
    }
    
    /**
     * Moves the directory to a new location.
     * @param string $destDirName The destination directory name
     */
    public function MoveTo($destDirName){
      if(!$this->getExists()){
        throw new \System\InvalidOperationException("Source directory does not exist");
      }
      
      if(!rename($this->_fullPath, $destDirName)){
        throw new \System\InvalidOperationException("Failed to move directory");
      }
      
      $this->_fullPath = realpath($destDirName);
      if($this->_fullPath === false){
        $this->_fullPath = $destDirName;
      }
    }
    
    /**
     * Returns a string representation of the directory info.
     * @return string The full path of the directory
     */
    public function ToString(){
      return $this->_fullPath;
    }
    
    /**
     * Recursively deletes a directory and its contents.
     * @param string $dir The directory to delete
     */
    private function _deleteRecursive($dir){
      if(!is_dir($dir)) return;
      
      $files = array_diff(scandir($dir), array('.', '..'));
      foreach($files as $file){
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if(is_dir($path)){
          $this->_deleteRecursive($path);
        } else {
          unlink($path);
        }
      }
      rmdir($dir);
    }
  }

  class File
  {
    /**
     * Reads a whole binary file into memory.
     * @param mixed $fileName 
     * @throws System\IO\Exception 
     * @return mixed
     */
    public static function ReadAllBytes($fileName){
      $handle=null;
      try{
        if (!$handle = fopen($fileName, 'rb'))
          throw new Exception("Cannot open file ($fileName)",0);
        
        $data="";
        while(!feof($handle)){
          $data.=fread($handle,(1<<13));
        }
        
        # HACK: faking finally for PHP <v5.5
        if($handle!=null)    
          fclose($handle);
      }catch(Exception $e){
        
        # HACK: faking finally for PHP <v5.5
        if($handle!=null)    
          fclose($handle);
        throw($e);
      }
      return($data);
    }
    
    /**
     * Writes a binary file from memory.
     * @param mixed $fileName 
     * @param mixed $data 
     * @throws System\IO\Exception 
     */
    public static function WriteAllBytes($fileName,$data){
      $handle=null;
      try{
        if (!$handle = fopen($fileName, 'wb'))
          throw new Exception("Cannot open file ($fileName)",0);
        
        if (!fwrite($handle, $data))
          throw new Exception("Cannot write to file ($fileName)",0);
        
        # HACK: faking finally for PHP <v5.5
        if($handle!=null)    
          fclose($handle);
      }catch(Exception $e){
      
        # HACK: faking finally for PHP <v5.5
        if($handle!=null)    
          fclose($handle);
          
        throw($e);
      }
    }
    
    /**
      * Checks whether a file is writeable.
      * @param mixed $fileName 
      */
    public static function IsFileWriteable($fileName){
      $handle=null;
      try{
        if (!$handle = fopen($fileName, 'cb'))
          return(false);
        
        # HACK: faking finally for PHP <v5.5
        if($handle!=null)    
          fclose($handle);
          
        return(true);
      }catch(Exception $e){
      
        # HACK: faking finally for PHP <v5.5
        if($handle!=null)    
          fclose($handle);
          
        return(false);
      }
    }
    
    /**
     * Reads a whole text file into memory.
     * @param mixed $fileName 
     * @return mixed
     */
    public static function ReadAllText($fileName){
      return(file_get_contents($fileName));
    }
    
    /**
     * Checks whether a file exists or not.
     * @param mixed $fileName 
     * @return mixed
     */
    public static function Exists($fileName){
      return(file_exists($fileName));
    }
    
    /**
     * Delete a file
     * @param mixed $fileName
     */
    public static function Delete($fileName){
      unlink($fileName);
    }
    
    /**
     * Copies a file.
     * @param mixed $source 
     * @param mixed $target 
     */
    public static function Copy($source,$target){
      copy($source,$target);
    }
  }
}
