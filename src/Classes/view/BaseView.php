<?php

namespace Classes\View;

class BaseView
{
	protected $path, $controller, $action, $vars = [];

	/**
	 * @param string $path           Basepath of the views.
	 * @param string $controllerName Current controller.
	 * @param string $actionName     Current action.
	 */
	public function __construct($path, $controllerName, $actionName)
	{
		$this->path       = $path;
		$this->controller = $controllerName;
		$this->action     = $actionName;
	}

	/**
	 * Set view vars. The keys will be added, to existing keys.
	 *
	 * @param array $vars
	 */
	public function setVars(array $inputVars)
	{
		foreach ($inputVars as $key => $val) {
			$this->vars[$key] = $val;
		}
		//print_r($this->vars);
	}

	/**
	 * Render the view.
	 *
	 * @throws NotFoundException
	 */
	
	public function render()
	{
		$fileName = $this->path.DIRECTORY_SEPARATOR.$this->controller.DIRECTORY_SEPARATOR.$this->action.'.phtml';

		// spare the view the bloat of using "$this->vars[]" for every variable
		foreach ($this->vars as $key => $val) {
			$$key = $val;
		}

		include $fileName;
	}
}