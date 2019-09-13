<?php
use api\AppCLI;
use testns\TestObject;

require_once ('api/AppCLI.php');

class TestCLI extends AppCLI
{

	/**
	 *
	 * @var TestObject
	 */
	public $obj = null;

	/**
	 *
	 * {@inheritdoc}
	 * @see \api\AppCLI::initParams()
	 */
	protected function initParams()
	{
		parent::initParams();
		$this->debug = true;
		$this->filePath = __DIR__ . DIRECTORY_SEPARATOR;
	}

	/**
	 *
	 * {@inheritdoc}
	 * @see \api\AppCLI::loadJSONX()
	 */
	public function loadJSONX(array &$json)
	{
		parent::loadJSONX($json);
		$this->obj = new TestObject($this->xjson);
	}
}

AppCLI::$INSTANCE = new TestCLI();

?>
