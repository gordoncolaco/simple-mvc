<?php
class classAutoLoader
{
  private static $loader;

  public static function init()
  {
    if(self::$loader == NULL)
    self::$loader = new self();

    return self::$loader;
  }

  public function __construct()
  {
    spl_autoload_register(array($this, "library"));
    spl_autoload_register(array($this, "model"));
  }

  private function library($class_name)
  {
    $class_path = _LIBRARY_PATH_.strtolower($class_name).".class.php";

    if(is_file($class_path))
      require_once($class_path);
  }

  private function model($class_name)
  {
    $class_path = _CLASS_PATH_.strtolower($class_name).".class.php";

    if(is_file($class_path))
      require_once($class_path);
  }
}

classAutoLoader::init();
