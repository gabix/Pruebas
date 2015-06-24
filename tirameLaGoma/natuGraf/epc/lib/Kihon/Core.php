<?php

//No errors at fucking all please.
//error_reporting(E_ERROR);
// Sitewide constants.
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(dirname(dirname(__FILE__))));
define('APP_DIR', ROOT_DIR.'/app');
define('LIB_DIR', ROOT_DIR.'/lib');

// Generic utilities
	function object_to_array($d) {
		if (is_object($d)) {
			$d = get_object_vars($d);
		}

		if (is_array($d)) {
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}

	function array_to_object(array $d) {
		if (is_array($d)) {
			return (object) array_map(__FUNCTION__, $d);
		}
		else {
			// Return object
			return $d;
		}
	}

// Exceptions
class SystemException extends Exception {}
class FileIOException extends SystemException {}
class FileNotFoundException extends FileIOException {}
class InvalidDSNException extends SystemException {}
class MalformedSQLException extends SystemException {}
class InexistentMethodException extends SystemException {}
// Interfaces
/**
 * Any object that handles coherent sets of data
 */
interface DataAccess {

  /**
    Returns or sets a value held by the map
    @param string $key value identifier
    @param mixed $value value to store. Function returns the value under $key if false.
    @param mixed null if not found or setting, $value elsewhere.
   */
  public function val($key, $value = null);

  /**
   * Returns any values held by the Map
   * @return array(mixed)
   */
  public function values();
}
/**
 * Any object that can be run like a function
 */
interface Runnable {

  /**
   * Magic method to allow running an object like a function
   * @param array(mixed) Any parameters that might be passed to it.
   */
  public function __invoke(array $parameters = array());
}
//Core abstract classes
/**
 * Singleton pattern implementation
 */
abstract class Singleton {

  public static function instance($parameters = false) {
    static $instance;
    if (empty($instance)) {
      $class = get_called_class();
      $instance = new $class($parameters);
    }
    return $instance;
  }
}
/**
 * Implementation of the strategy pattern
 */
abstract class Strategy implements Runnable {

  abstract public function payload(array $parameters);

  public function before(array &$parameters) {
    return true;
  }

  public function after(array $parameters) {
    return true;
  }

  public function execute(array $parameters = array()) {
    ob_start();
    $can = $this->before($parameters);
    if ($can) {
      $result = $this->payload($parameters);
      $this->after($parameters);
    }
    ob_get_clean();
    return $result;
  }

  public function __invoke(array $parameters = array()) {
    return $this->execute($parameters);
  }
}
/**
 * A generic Application. Does something through its
 */
abstract class Application extends Strategy {

  protected $config_path = '.';
  protected $commands = array();

  /**
   * Tries to run an MVC based app
   * @param array $parameters
   * @return string rendered contents
   */
  public function payload(array $parameters = array()) {
    $controllerViewParamsTriad = $this->extractExecutionMap($parameters);
    $controllerName = Inflector::capitalize($controllerViewParamsTriad['controller']['name']);
    $old_name = $controllerViewParamsTriad['controller']['name'];
    $method = $controllerViewParamsTriad['controller']['action'];
    ob_start();
    $controller = new $controllerName;
    array_shift($parameters);
    if (empty($controllerViewParamsTriad['params']) OR 0 === count($controllerViewParamsTriad['params'])) {
      $controllerViewParamsTriad['params'] = array();
    }
    elseif(!is_array($controllerViewParamsTriad['params'])){
      $controllerViewParamsTriad['params'] = array(
        $controllerViewParamsTriad['params']
      );
    }
    if (null === $method OR ! $method OR empty($method)) {
      $method = 'index';
    }
    $results = call_user_func_array(array($controller, $method), $controllerViewParamsTriad['params']);

    if (null !== $controller->getView())
      $render_contents = self::renderWithView($controller);
    else
      $render_contents = self::renderWithoutView($controller);
    if (null !== $controller->getLayout())
      $render_contents = self::renderWithLayout($controller->getLayout(), $render_contents);

    return $render_contents;
  }

  /**
   *
   * @param array $parameters
   * @return type
   */
  abstract public function extractExecutionMap(array $parameters);

  /**
   * Renders the values returned by the controller into a view
   * @param Controller $controller
   * @return string The result of rendering the view
   */
  protected static function renderWithView(Controller $controller) {
    $view = new View($controller->getView());
    $view->setBoundController($controller);
    $view->setParameters($controller->getViewParameters());
    return $view->render();
  }

  /**
   * Returns anything the controller has to say
   * @param Controller $controller
   * @return string The result of showing whatever the controller wants
   */
  protected static function renderWithoutView(Controller $controller) {
    $view = new View(null);
    $vars = $controller->getViewParameters();
    if(!isset($vars['output'])){
      $vars['output'] = '';
    }
    $view->setParameters(array('output' => $vars['output']));
    return $view->render();
  }

  /**
   * Renders a view into a layout
   * @param string $layout_file The layout file to decorate the view with
   * @param string $layout_contents The view contents to punch into the layout
   * @return string
   */
  function renderWithLayout($layout_file, $layout_contents) {
    $view = new View($layout_file);
    $view->setParameters(array('output' => $layout_contents));
    return $view->render();
  }
}
//Core concrete classes

class ErrorHandler{
  public static function exception(Exception $e){
    if($e instanceof SystemException){ //Only trap our exceptions.
      if(Config::value('app.mode') == 'debug'){
        $view_file = 'exceptions-debug';
      }
      else{
        $view_file = 'exceptions-business';
      }
      $view = new View($view_file);
      $view->setParameter('exception',$e);
      $view->setParameter('exception_type',get_class($e));
    }
    foreach(ob_list_handlers() as $buf){
      ob_clean();
    }
    echo $view->render();
  }
}

class LayoutBus extends Singleton {

  protected $map = null;

  protected function __construct(){
    $this->map = new Map;
  }

  public function add($type, $uri){
    $existing = $this->map->val("bus.uris.$type");
    if(!is_array($existing)){
      $existing = array();
    }
    $existing[] = $uri;
    $this->map->val("bus.uris.$type",$existing);
  }
  public function addBlock($type, $block){
    $existing = $this->map->val("bus.blocks.$type");
    if(!is_array($existing)){
      $existing = array();
    }
    $existing[] = $block;
    $this->map->val("bus.blocks.$type",$existing);
  }
  public function getBlocks($type){
    $blocks = $this->map->val("bus.blocks.$type");
    if(!$blocks){
      return array();
    }
    return $blocks;
  }
  public function get($type){
    $uris = $this->map->val("bus.uris.$type");
    if(!$uris){
      return array();
    }
    return $uris;
  }
  public function setTitle($string){
    $existing = $this->map->val("bus.title");
    if(!is_array($existing)){
      $existing = array();
    }
    $existing[] = $string;
    $this->map->val("bus.title",$existing);
  }
  public function title(){
    $val = $this->map->val("bus.title");
    if(!$val){
      $val = array();
    }
    return implode('|', array());
  }

  public static function addJS($uri){
    return self::instance()->add("script",$uri);
  }
  public static function addCSS($uri){
    return self::instance()->add("css",$uri);
  }
  public static function addJSBlock($block){
    return self::instance()->addBlock("script",$block);
  }
  public static function addCSSBlock($block){
    return self::instance()->addBlock("css",$block);
  }
  public static function getCSSBlocks(){
    return self::instance()->getBlocks("css");
  }
  public static function getJSBlocks(){
    return self::instance()->getBlocks("script");
  }
  public function getJS(){
    return self::instance()->get('script');
  }
  public function getCSS(){
    return self::instance()->get('css');
  }
  public static function addTitle($string){
    self::instance()->setTitle($string);
  }
  public static function getTitle(){
    return self::instance()->title();
  }
}

define('CRYPT_XXTEA_DELTA', 0x9E3779B9);
/**
 * XXTEA encryption
 *
 * @category   Encryption
 * @package    Crypt_XXTEA
 * @author     Wudi Liu <wudicgi@gmail.com>
 * @author     Ma Bingyao <andot@ujn.edu.cn>
 * @copyright  2005-2008 Coolcode.CN
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.9.0
 * @link       http://pear.php.net/package/Crypt_XXTEA
 */
class Crypt_XXTEA {

  /**
   * The long integer array of secret key
   *
   * @access private
   *
   * @var array
   */
  private $_key;

  /**
   * Sets the secret key
   *
   * The key must be non-empty, and not more than 16 characters or 4 long values
   *
   * @access public
   *
   * @param mixed $key  the secret key (string or long integer array)
   *
   * @return bool  true on success
   * @throws InvalidArgumentException
   */
  public function setKey($key) {
    if (is_string($key)) {
      $k = $this->_str2long($key, false);
    }
    elseif (is_array($key)) {
      $k = $key;
    }
    else {
      throw new InvalidArgumentException('The secret key must be a string or long integer array.');
    }
    if (count($k) > 4) {
      throw new InvalidArgumentException('The secret key cannot be more than 16 characters or 4 long values.');
    }
    elseif (count($k) == 0) {
      throw new InvalidArgumentException('The secret key cannot be empty.');
    }
    elseif (count($k) < 4) {
      for ($i = count($k); $i < 4; $i ++ ) {
        $k[$i] = 0;
      }
    }
    $this->_key = $k;
    return true;
  }

  /**
   * Encrypts a plain text
   *
   * As the XXTEA encryption algorithm is designed for encrypting and decrypting
   * the long integer array type of data, there is not a standard that defines
   * how to convert between long integer array and text or binary data for it.
   * So this package provides the ability to encrypt and decrypt the long integer
   * arrays directly to satisfy the requirement for working with other
   * implementations. And at the same time, for convenience, it also provides
   * the ability to process strings, which uses its own method to group the text
   * into array.
   *
   * @access public
   *
   * @param mixed $plaintext  the plain text (string or long integer array)
   *
   * @return mixed  the cipher text as the same type as the parameter $plaintext
   * @throws InvalidArgumentException
   */
  public function encrypt($plaintext) {
    if ($this->_key == null) {
      throw new InvalidArgumentException('Secret key is undefined.');
    }
    if (is_string($plaintext)) {
      return $this->_encryptString($plaintext);
    }
    elseif (is_array($plaintext)) {
      return $this->_encryptArray($plaintext);
    }
    else {
      throw new InvalidArgumentException('The plain text must be a string or long integer array.');
    }
  }

  /**
   * Decrypts a cipher text
   *
   * @access public
   *
   * @param mixed $chipertext  the cipher text (string or long integer array)
   *
   * @return mixed  the plain text as the same type as the parameter $chipertext
   * @throws InvalidArgumentException
   */
  public function decrypt($chipertext) {
    if ($this->_key == null) {
      throw new InvalidArgumentException('Secret key is undefined.');
    }
    if (is_string($chipertext)) {
      return $this->_decryptString($chipertext);
    }
    elseif (is_array($chipertext)) {
      return $this->_decryptArray($chipertext);
    }
    else {
      throw new InvalidArgumentException('The chiper text must be a string or long integer array.');
    }
  }

  /**
   * Encrypts a string
   *
   * @access private
   *
   * @param string $str  the string to encrypt
   *
   * @return string  the string type of the cipher text on success,
   * @throws InvalidArgumentException
   */
  private function _encryptString($str) {
    if ($str == '') {
      return '';
    }
    $v = $this->_str2long($str, true);
    $v = $this->_encryptArray($v);
    return $this->_long2str($v, false);
  }

  /**
   * Encrypts a long integer array
   *
   * @access private
   *
   * @param array $v  the long integer array to encrypt
   *
   * @return array  the array type of the cipher text on success,
   * @throws InvalidArgumentException
   */
  private function _encryptArray($v) {
    $n = count($v) - 1;
    $z = $v[$n];
    $y = $v[0];
    $q = floor(6 + 52 / ($n + 1));
    $sum = 0;
    while (0 < $q --) {
      $sum = $this->_int32($sum + CRYPT_XXTEA_DELTA);
      $e = $sum >> 2 & 3;
      for ($p = 0; $p < $n; $p ++ ) {
        $y = $v[$p + 1];
        $mx = $this->_int32((($z >> 5 & 0x07FFFFFF) ^ $y << 2) + (($y >> 3 & 0x1FFFFFFF) ^ $z << 4)) ^ $this->_int32(($sum ^ $y) + ($this->_key[$p & 3 ^ $e] ^ $z));
        $z = $v[$p] = $this->_int32($v[$p] + $mx);
      }
      $y = $v[0];
      $mx = $this->_int32((($z >> 5 & 0x07FFFFFF) ^ $y << 2) + (($y >> 3 & 0x1FFFFFFF) ^ $z << 4)) ^ $this->_int32(($sum ^ $y) + ($this->_key[$p & 3 ^ $e] ^ $z));
      $z = $v[$n] = $this->_int32($v[$n] + $mx);
    }
    return $v;
  }

  /**
   * Decrypts a string
   *
   * @access private
   *
   * @param string $str  the string to decrypt
   *
   * @return string  the string type of the plain text on success,
   * @throws InvalidArgumentException
   */
  private function _decryptString($str) {
    if ($str == '') {
      return '';
    }
    $v = $this->_str2long($str, false);
    $v = $this->_decryptArray($v);
    return $this->_long2str($v, true);
  }

  /**
   * Decrypts a long integer array
   *
   * @access private
   *
   * @param array $v  the long integer array to decrypt
   *
   * @return array  the array type of the plain text on success,
   * @throws InvalidArgumentException
   */
  private function _decryptArray($v) {
    $n = count($v) - 1;
    $z = $v[$n];
    $y = $v[0];
    $q = floor(6 + 52 / ($n + 1));
    $sum = $this->_int32($q * CRYPT_XXTEA_DELTA);
    while ($sum != 0) {
      $e = $sum >> 2 & 3;
      for ($p = $n; $p > 0; $p -- ) {
        $z = $v[$p - 1];
        $mx = $this->_int32((($z >> 5 & 0x07FFFFFF) ^ $y << 2) + (($y >> 3 & 0x1FFFFFFF) ^ $z << 4)) ^ $this->_int32(($sum ^ $y) + ($this->_key[$p & 3 ^ $e] ^ $z));
        $y = $v[$p] = $this->_int32($v[$p] - $mx);
      }
      $z = $v[$n];
      $mx = $this->_int32((($z >> 5 & 0x07FFFFFF) ^ $y << 2) + (($y >> 3 & 0x1FFFFFFF) ^ $z << 4)) ^ $this->_int32(($sum ^ $y) + ($this->_key[$p & 3 ^ $e] ^ $z));
      $y = $v[0] = $this->_int32($v[0] - $mx);
      $sum = $this->_int32($sum - CRYPT_XXTEA_DELTA);
    }
    return $v;
  }

  /**
   * Converts long integer array to string
   *
   * @access private
   *
   * @param array $v  the long integer array
   * @param bool  $w  whether the given array contains the length of
   *                   original plain text
   *
   * @return string  the string
   */
  private function _long2str($v, $w) {
    $len = count($v);
    $s = '';
    for ($i = 0; $i < $len; $i ++ ) {
      $s .= pack('V', $v[$i]);
    }
    if ($w) {
      return substr($s, 0, $v[$len - 1]);
    }
    else {
      return $s;
    }
  }

  /**
   * Converts string to long integer array
   *
   * @access private
   *
   * @param string $s  the string
   * @param bool   $w  whether to append the length of string to array
   *
   * @return string  the long integer array
   */
  private function _str2long($s, $w) {
    $v = array_values(unpack('V*', $s.str_repeat("\0", (4 - strlen($s) % 4) & 3)));
    if ($w) {
      $v[] = strlen($s);
    }
    return $v;
  }

  /**
   * Corrects long integer value
   *
   * Because a number beyond the bounds of the integer type will be automatically
   * interpreted as a float, the simulation of integer overflow is needed.
   *
   * @access private
   *
   * @param int $n  the integer
   *
   * @return int  the correct integer
   */
  private function _int32($n) {
    while ($n >= 2147483648)
      $n -= 4294967296;
    while ($n <= -2147483649)
      $n += 4294967296;
    return (int) $n;
  }
}
/**
 * Trivial implementation of an inflector.
 */
class Inflector {

  public static function splitByCase($string) {
    $string = preg_replace('@([A-Z])@', ' $0', $string);
    return explode(' ', $string);
  }

  public static function humanize($string) {
    $clean = str_replace(str_split('_-.'), ' ', $string);
    return $clean;
  }

  public static function dehumanize($string) {
    $string = implode(' ', self::splitByCase($string));
    $dirty = 'áéíóúÁÉÍÓÚ¿¡';
    $clean = '____________';
    $inhuman = strtolower(str_replace(str_split($dirty), str_split($clean), $string));
    return trim($inhuman, '-_ ');
  }

  public static function capitalize($string) {
    $human = self::humanize(self::dehumanize($string));
    $capital = ucwords($human);
    return str_replace(str_split("\t _"), '', $capital);
  }
}
/**
 * Trivial representation of a DataSourceName
 */
class DSN {

  public $engine;
  public $user;
  public $password;
  public $database;

  public function __construct($dsn_string) {
    $dsn = parse_url($dsn_string);
    if ( ! $dsn['scheme']) {
      throw new InvalidDSNException($dsn_string);
    }
    if ( ! $dsn['path']) {
      throw new InvalidDSNException($dsn_string);
    }
    if ( ! isset($dsn['user'])) {
      $ds['user'] = false;
    }
    if ( ! isset($dsn['pass'])) {
      $dsn['pass'] = false;
    }
    $this->engine = $dsn['scheme'];
    $this->user = $dsn['user'];
    $this->password = $dsn['pass'];
    $this->server = $dsn['host'];
    $this->database = trim($dsn['path'], '/ ');
  }

  public function __toString() {
    $tpl = "%s://%s:%s@%s/%s";
    return sprintf($tpl, $this->engine, $this->user, $this->password, $this->server, $this->database);
  }
}
class MySQLEngine extends mysqli {

  public function query($query) {
    $this->real_query($query);
    return new MySQLResult($this);
  }
}
class MySQLResult extends mysqli_result {

  public function all() {
    $res = array();
    while ($result = $this->fetch_object()) {
      $res[] = $result;
    }
    return $res;
  }
}
class DB extends Singleton {

  protected $dsn = null;
  protected $resource = null;

  protected function __construct($dbDSN = false) {
    if ( ! $dbDSN) {
      $dbDSN = Config::value('app.default_dsn');
    }
    $this->dsn = new DSN($dbDSN);
    $this->setDatabaseEngine('MySQLEngine');
    $this->resource = $this->getDatabaseEngine();
  }

  public function getDSN() {
    return $this->dsn;
  }

  public function getDatabaseEngine() {
    return $this->engine;
  }

  public function setDatabaseEngine($engine) {
    $this->engine = new $engine($this->dsn->server, $this->dsn->user, $this->dsn->password, $this->dsn->database);
  }

  public function query($sql) {
    $query = 'select call explain show describe';
    $dml = 'insert update delete';
    $ddl = 'create alter drop truncate rename';
    $sql_first_word = strtolower(array_shift(explode(' ', $sql)));
    $q = $this->engine->multi_query($sql);
    if ($q AND $this->engine->error == '') {
      if (strpos($query, $sql_first_word) !== false) {//type=query
        $buf = array();
        $res = $this->engine->use_result();
        do {
          if ($result = $res) {
            while ($row = $result->fetch_object()) {
              $buf[] = $row;
            }
            $result->close();
          }
        } while ($this->engine->next_result());
        return $buf;
      }
      if (strpos($dml, $sql_first_word) !== false) {//type=dml
        return $this->engine->affected_rows;
      }
      if (strpos($ddl, $sql_first_word) !== false) {//type=ddl
        return $q;
      }
      return $q;
    }
    else {
      throw new MalformedSQLException($this->engine->error);
    }
  }

  public function prepareValue($value) {
    if ( ! is_numeric($value)) {
      $value = "'".$this->engine->real_escape_string($value)."'";
    }
    return $value;
  }
  protected function killConnection(){
    $this->engine->close();
  }
  public static function factory($dsn){
    return new DB($dsn);
  }

}
class Session extends Singleton {

  protected function __construct() {
    if (session_id() == '') {
      session_start();
    }
  }

  public function wipe() {
    foreach ($_SESSION as $n => &$v) {
      unset($v);
      unset($_SESSION[$n]);
    }
    session_destroy();
  }

  public function val($key, $value = null, $default = false) {
    $me = self::instance();
    $vars = $_SESSION;
    $map = new Map($vars);
    $map->val($key, $value);

    if ( ! $vars) {
      $vars = array();
    }
    $_SESSION = Map::merge($vars, $map->values());
    return $map->val($key, $value);
  }
}
/**
 * Variables container
 */
class Map implements DataAccess {

  /**
   * Contains all variables held by the map
   * @static
   */
  protected $vars;

  public function __construct(array $original = array()) {
    $this->vars = $original;
  }

  public function val($key, $value = null) {
    $keys = explode('.', $key);
    $ptr = &$this->vars;
    if ( ! is_null($value)) {
      foreach ($keys as $key) {
        if ( ! isset($ptr[$key]))
          $ptr[$key] = array();
        $ptr = &$ptr[$key];
      }

      $ptr = $value;
    }
    else {
      foreach ($keys as $key) {
        if ( ! isset($ptr[$key]))
          $ptr[$key] = array();
        $ptr = &$ptr[$key];
      }
      $cp = $ptr;
      if (count($cp) > 0)
        return $ptr;
      else
        return false;
    }
  }

  public function values() {
    return $this->vars;
  }

  /**
   * Unifies two arrays into a third one
   * @param array $original
   * @param array $new
   * @return array $merged
   */
  public static function merge($original, $new) {
    foreach ($new as $key => $Value) {
      if (array_key_exists($key, $original) && is_array($Value))
        $original[$key] = self::merge($original[$key], $new[$key]);
      else
        $original[$key] = $Value;
    }
    return $original;
  }
}
/**
 * Loads and manages any configuration values possible needed ever.
 */
class Config extends Singleton implements DataAccess {

  protected static $map = null;
  protected static $config_dir = './cfg';

  public static function load($config_file) {
    self::$config_dir = dirname(realpath($config_file));
    require($config_file);
    self::$map->val('app', self::parseCfg($config));
  }

  protected function __construct() {
    self::$map = new Map;
  }

  public static function value($key, $value = null) {
    return self::instance()->val($key, $value);
  }

  protected static function parseCfg($configuration) {
    $buffer = array();
    foreach ($configuration as $key => $value) {
      if ( ! is_array($value) AND strpos($value, 'file:') === 0) {
        $file = substr($value, 5);
        require(self::$config_dir.DS.$file);
        $value = self::parseCfg($config);
      }
      $buffer = Map::merge($buffer, array(
          $key => $value
          )
      );
    }
    return $buffer;
  }

  public function val($key, $value = null) {
    return self::$map->val($key, $value);
  }

  public function values() {
    return self::$map->values();
  }
}
/**
 * Trivial autoloader
 */
class BaseAutoloader {

  /**
   * Autoload a class
   * @param string $class_name
   * @return boolean true if it could autoload the class, false otherwie
   */
  public static function autoload($class_name) {

    $app_path = self::getAppClassPath($class_name);
    $lib_path = self::getLibClassPath($class_name);

    $include_path = false;
    if(file_exists($lib_path))
      $include_path = $lib_path;
    if (file_exists($app_path))
      $include_path = $app_path;

    if ($include_path) {
      define(strtoupper($class_name).'_ROOT', dirname($include_path));
      require_once($include_path);
      return true;
    }
    return false;
  }

  /**
   * Cuts a class name into its component words
   * @param string $class_name
   * @return array
   */
  protected static function getClassParts($class_name) {
    $parts = preg_replace('@([A-Z])@', 'ǂ$0', $class_name);
    return explode('ǂ', $parts);
  }

  /**
   * Provides a path to a class in the /app directory
   * @param string $class_name
   * @return string
   */
  protected static function getAppClassPath($class_name) {
    return APP_DIR.implode(DS, self::getClassParts($class_name)).'.php';
  }

  /**
   * Provides a class in the /lib/Kihon directory
   * @param string $class_name
   * @return string
   */
  protected static function getLibClassPath($class_name) {
    return LIB_DIR.implode(DS, self::getClassParts($class_name)).'.php';
  }
}
/**
 * Trivial implementation of a model
 */
abstract class Model {

  protected $dsn = null;
  protected $table_name = null;
  protected $errors = array();

  protected function init($dsn) {
    $this->dsn = $dsn;
    $this->db = DB::instance($this->dsn);
  }

  public function add(array $fields) {
    foreach ($fields as $name => &$value) {
      $value = $this->db->prepareValue($value);
    }
    $field_names = array_keys($fields);
    $field_values = array_values($fields);
    $names = implode(',', $field_names);
    $values = implode(',', $field_values);
    return("INSERT INTO {$this->table_name}($names) VALUES($values);");
  }

  public function update($id, array $fields) {
    $kvps = array();
    foreach ($fields as $name => &$value) {
      $value = $this->db->prepareValue($value);
      $kvps[] = "$name = $value";
    }
    $kvps = implode(',', $kvps);
    return "UPDATE {$this->table_name} SET $kvps WHERE {$this->table_name}_id = $id;";
  }

  public function delete($id) {
    return "DELETE FROM {$this->table_name} WHERE {$this->table_name}_id = $id;";
  }

  public function get($id) {
    return $this->find(array(
        $this->table_name.'_id' => $id
        )
    );
  }

  public function find(array $criteria = array(), $fields = '*', array $joins = array()) {
    $conditions = array();
    foreach ($criteria as $field => $expected_value) {
      $conditions[] = "$field = ".$this->db->prepareValue($expected_value);
    }
    $compiled_joins = array();
    foreach ($joins as $type => $join) {
      foreach ($join as $triad) {
        $compiled_joins[] = strtoupper($type).' JOIN '.$triad['table'].' ON '.$triad[0].'='.$triad[1];
      }
    }
    if (is_array($fields)) {
      $fields = implode(',', $fields);
    }
    if (count($conditions) > 0) {
      $conditions = "WHERE ".implode(' AND ', $conditions);
    }
    else {
      $conditions = '';
    }
    $joins = implode("\n", $compiled_joins);
    return "SELECT $fields FROM {$this->table_name} $joins $conditions;";
  }

  public function asList($desc_field = 'description', array $criteria = array()) {
    $conditions = array();
    foreach ($criteria as $field => $expected_value) {
      $conditions[] = "$field = ".$this->db->prepareValue($expected_value);
    }
    if (count($conditions) > 0) {
      $conditions = "WHERE ".implode($conditions);
    }
    else {
      $conditions = '';
    }
    return "SELECT {$this->table_name}_id as id, $desc_field as description FROM {$this->table_name} $conditions;";
  }

  public function query($sql) {
    return $this->db->query(trim($sql));
  }

  protected function addError($field, $text) {
    $this->errors[$field][] = $text;
  }

  public function getErrors() {
    return $this->errors;
  }

  public function now() {
    return date('Y-m-d h:i:s');
  }
}

abstract class Plugin{
    protected function forward($internal_url) {
    if (dirname(Config::value('app.mvc.front_controller') == '.')) {
      $site_root = '';
    }
    $site_root = Config::value('app.mvc.front_controller');
    header('Location: '.$site_root.$internal_url);
  }
  protected function redirect($url){
    header("Location: $url");
  }
}

/**
 * Trivial implementation of a controller with its minimal methods
 */
abstract class Controller {
  private $registered_plugins = array();
  protected $plugins = array();
  protected $layout = null;
  protected $view = null;
  protected $view_variables = array();

  /**
   * Retrieve the layout this controller will use
   * @return string
   */
  public function getLayout() {
    return $this->layout;
  }

  /**
   * Retrieve the view this controller will use
   * @return string
   */
  public function getView() {
    return $this->view;
  }

  /**
   * Get all the view parameters set by the controller
   * @return array
   */
  public function getViewParameters() {
    return $this->view_variables;
  }

  public function getSession() {
    return Session::instance();
  }

  /**
   * Magic method to add view variables
   * @param string $key
   * @param mixed $value
   */
  public function __set($key, $value) {
    $this->view_variables[$key] = $value;
  }

  /**
   * Magic method to retrieve a view variable
   * @param type $key
   * @return string
   */
  public function __get($key) {
    return $this->view_variables[$key];
  }

  /**
   * Directs the user to an internal URI
   * @param string $internal_url
   */
  protected function forward($internal_url) {
    if (dirname(Config::value('app.mvc.front_controller') == '.')) {
      $site_root = '';
    }
    $site_root = Config::value('app.mvc.front_controller');
    header('Location: '.$site_root.$internal_url);
  }
  protected function init(){
    foreach($this->plugins as $plugin){
      $plugin_class = 'Plugin'.$plugin;
      $this->registered_plugins[$plugin] = new $plugin_class;
    }
  }
  public function __call($method, $arguments){
    foreach($this->registered_plugins as $plugin){
      if(method_exists($plugin, $method)){
        return call_user_func_array(array($plugin, $method), $arguments);
      }
    }
    throw new InexistentMethodException("$method cannot be handled by ".get_called_class());
  }
  public function getPlugin($name){
    return $this->registered_plugins[$name];
  }
}
/**
 * The console version of a controller
 */
abstract class ConsoleController extends Controller {

  public function ask($sentence) {
    file_put_contents('php://stdout', $sentence."\n\t");
    return trim(fgets(STDIN));
  }

  public function say($sentence) {
    fputs(STDOUT, $sentence."\n");
  }
}
/**
 * Trivial implementation of a view with its minimal actions
 */
class View {

  protected $view_name = null;
  protected $view_variables = array();
  protected $view_extension = '.php';
  protected $bound_controller = null;

  public function __construct($view_name = null) {
    if (null !== $view_name)
      $this->view_name = $view_name;
    else
      $this->view_name = 'empty';
    if ( ! Config::value('app.mvc.extensions.views'))
      Config::value('app.mvc.extensions.views', '.php');

    $this->view_extension = Config::value('app.mvc.extensions.views');
  }

  public function setBoundController(Controller $to) {
    $this->bound_controller = $to;
  }

  /**
   * Binds an array of variables to a view. They must be in key-value format
   * @param array $parameters
   */
  public function setParameters(array $parameters = array()) {
    $this->view_variables = Map::merge($this->view_variables, $parameters);
  }

  /**
   * Bind a variable to the view
   * @param string $key
   * @param mixed $value
   */
  public function setParameter($key, $value) {
    $this->view_variables[$key] = $value;
  }

  /**
   * Renders a view into a string
   * @return string
   */
  public function render() {
    ob_start();
    extract($this->view_variables);
    if (null === $this->view_name)
      echo $output;
    else {
      $app_path = Config::value('app.paths.views.app');
      $lib_path = Config::value('app.paths.views.default');
      $controller_path = false;
      if (defined(strtoupper(get_class($this->bound_controller)).'_ROOT')) {
        $controller_path = constant(
            strtoupper(
              get_class(
                $this->bound_controller
              )
            ).'_ROOT'
          ).
          '/Views';
        $controller_path.=DS.$this->view_name.$this->view_extension;
      }

      $app_path = ROOT_DIR.$app_path.DS.$this->view_name.$this->view_extension;
      $lib_path = ROOT_DIR.$lib_path.DS.$this->view_name.$this->view_extension;

      if (is_readable($controller_path))
        $include_path = $controller_path;
      elseif (is_readable($app_path))
        $include_path = $app_path;
      elseif (is_readable($lib_path))
        $include_path = $lib_path;
      else
        throw new FileNotFoundException($this->view_name.$this->view_extension);
      require($include_path);
    }
    return ob_get_clean();
  }

  public static function compose($view_name, array $variables = array()) {
    $composed_view = new View($view_name);
    $composed_view->setParameters($variables);
    return $composed_view->render();
  }
}
/**
 * A basic console launcher application. Tries to run console Controllers
 */
class ConsoleApplication extends Application {

  public function payload(array $parameters = array()) {
    array_shift($parameters);
    return parent::payload($parameters);
  }

  public function extractExecutionMap(array $from) {
    foreach ($from as &$el) {
      $el = trim($el, " \t");
    }
    if (count($from) === 0)
      throw new InvalidArgumentException("Insufficient parameters in call");
    $controllerName = array_shift($from);
    return array(
      'controller' => array(
        'name' => 'Console'.$controllerName.'Controller',
        'action' => array_shift($from),
      ),
      'view' => 'console',
      'params' => array_shift($from)
    );
  }
}
/**
 * Maps a URI to a controller-action-params triad
 */
class BaseUriMapper extends Strategy {

  public function payload(array $parameters = array()) {
    $uri = $parameters['uri'];
    if ( ! $uri OR null === $uri OR '/' == $uri) {
      return array(
        'controller' => array(
          'name' => 'PagesController',
          'action' => 'index'
        ),
        'params' => array()
      );
    }
    elseif ($uri == '/404') {
      return array(
        'controller' => array(
          'name' => 'PagesController',
          'action' => 'NotFound',
        ),
        'params' => array(
          'original_uri' => $_SERVER['REQUEST_URI']
        )
      );
    }
    else {
      $uri_pieces = array_filter(explode('/', $uri));
      return array(
        'controller' => array(
          'name' => ucwords(array_shift($uri_pieces)).'Controller',
          'action' => array_shift($uri_pieces),
        ),
        'params' => $uri_pieces
      );
    }
  }
}
/**
 * A basic front controller application. Tries to run web Controllers
 */
class WebApplication extends Application {

  protected $request = array();

  public function payload(array $parameters = array()) {
    if ( ! isset($parameters['method']) AND isset($parameters[0])) {
      $method = $parameters[0];
    }
    elseif ( ! isset($parameters['method']))
      throw new InvalidArgumentException("Method musts be provided to WebApplication");
    else
      $method = $parameters['method'];
    if ( ! isset($parameters['uri']) AND isset($parameters[1]))
      $uri = $parameters[1];
    elseif ( ! isset($parameters['uri']))
      throw new InvalidArgumentException("URI musts be provided to WebApplication");
    else
      $uri = $parameters['uri'];

    if ( ! Config::value('app.mvc.uri_mapper'))
      Config::value('app.mvc.uri_mapper', 'Base');
    $uri = str_replace(array(
      Config::value('app.mvc.front_controller'),
      dirname(Config::value('app.mvc.front_controller'))
      ), '', $uri);

    $this->request = array(
      'method' => $method,
      'uri' => $uri,
    );
    $parameters = $this->request;
    return parent::payload($parameters);
  }

  /**
   * Extracts the controller-action-params triad from the provided path
   * @param array $from
   * @return array
   */
  public function extractExecutionMap(array $from) {
    $mapper_name = Config::value('app.mvc.uri_mapper').'UriMapper';
    $mapper_object = new $mapper_name;
    return $mapper_object->execute(array(
        'method' => $this->request['method'],
        'uri' => $this->request['uri'],
        )
    );
  }
}
//any required initializing
spl_autoload_register('BaseAutoloader::autoload');
set_exception_handler('ErrorHandler::exception');
?>
