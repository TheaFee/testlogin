   <?php
// simple autoloader
spl_autoload_register(function ($className) {
	if (substr($className, 0, 8) !== 'Classes\\') {
        // not our business
        echo $className;
		return;
	}
    //echo "className: " . $className;
	$fileName = __DIR__.'/'.'src/Classes/'.str_replace('\\', '/', substr($className, 8)).'.php';

    //echo "\nfileName: " . $fileName;

	if (file_exists($fileName)) {
		include $fileName;
	}
});

 \Classes\Service\SessionService::automaticLogout();

    // get the requested url

    
$url = (isset($_GET['_url']) ? $_GET['_url'] : '');

// echo "url " . $url;

$urlParts = explode('/', $url);


// build the controller class
$controllerName      = (isset($urlParts[0]) && $urlParts[0] ? $urlParts[0] : 'Index');
$controllerClassName = '\\Classes\\Controller\\'.ucfirst($controllerName).'Controller';

// build the action method
$actionName       = (isset($urlParts[1]) && $urlParts[1] ? $urlParts[1] : 'index');
$actionMethodName = $actionName.'Action';


$controller = new $controllerClassName();
//echo $controllerClassName;

$view = new \Classes\View\BaseView(__DIR__.DIRECTORY_SEPARATOR.'src/Classes/View/', $controllerName, $actionName); 
	
$controller->setView($view);

$controller->$actionMethodName();
	
$view->render();

