<?php
namespace api;

class AppCLI
{

	/**
	 *
	 * @var AppCLI
	 */
	public static $INSTANCE = null;

	/**
	 *
	 * @var array
	 */
	protected $argv = null;

	/**
	 *
	 * @var string
	 */
	protected $filePath = "";

	/**
	 *
	 * @var string
	 */
	protected $libPath = "";

	/**
	 *
	 * @var array
	 */
	protected $xjson = null;

	/**
	 *
	 * @var bool
	 */
	public $debug = false;

	/**
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 */
	protected function init()
	{
		$this->initParams();
		$this->initAutoLoader();
		$this->initConsole();
	}

	/**
	 */
	protected function initParams()
	{
		$this->filePath = __DIR__ . DIRECTORY_SEPARATOR;
		$this->argv = $_SERVER['argv'];
	}

	/**
	 */
	protected function initAutoLoader()
	{
		spl_autoload_register(array(
			$this,
			'onAutoLoad'
		));
	}

	/**
	 *
	 * @param string $className
	 */
	protected function onAutoLoad(string $className)
	{
		$classSplit = explode('\\', $className);
		$api = array_pop($classSplit);
		$dir = $this->libPath . implode(DIRECTORY_SEPARATOR, $classSplit) . DIRECTORY_SEPARATOR;
		$pfile = $this->filePath . $dir . $api . '.php';
		if (is_file($pfile))
			require_once ($pfile);
	}

	/**
	 */
	protected function initConsole()
	{
		if ($this->argv && count($this->argv) > 1) {
			$this->load($this->argv[1]);
		}
		$this->endConsole();
	}

	/**
	 */
	protected function endConsole()
	{
		if ($this->debug) {
			echo ("loaded json:" . PHP_EOL);
			echo (json_encode($this->xjson));
			echo (PHP_EOL);
		}
	}

	/**
	 *
	 * @param string $args
	 */
	public function load(string $args)
	{
		$inputjson = is_file($args) ? $args : null;
		$json = null;
		if ($inputjson) {
			$jsond = file_get_contents($inputjson);
			if ($jsond) {
				$json = json_decode($jsond, true);
			}
		}
		if ($json) {
			$this->loadJSONX($json);
		}
	}

	/**
	 *
	 * @param array $json
	 */
	public function loadJSONX(array &$json)
	{
		$this->xjson = $json;
	}
}

?>
