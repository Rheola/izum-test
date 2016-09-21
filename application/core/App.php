<? class App{

    const SecondInDay = 86400;

    /**
     *
     */
    public static function start(){
        $baseDir = __DIR__.'/../../application/';

        $controllerName = 'User';
        $actionName = 'index';

        $tail = explode('?', $_SERVER['REQUEST_URI']);

        $routes = explode('/', $tail[0]);

        if(!empty($routes[1])){
            $controllerName = $routes[1];
        }

        if(!empty($routes[2])){
            $actionName = $routes[2];
        }

        if($controllerName === 'index.php'){
            header('Location: /', true, 302);
        }
        $model = ucfirst($controllerName);

        $controllerName = ucfirst($controllerName).'Controller';
        $actionName = 'action'.ucfirst($actionName);


        $model_file = $model.'.php';
        $model_path = $baseDir.'models/'.$model_file;
        if(file_exists($model_path)){
            include $model_path;
        }

        $controller_file = $controllerName.'.php';
        $controller_path = $baseDir.'controllers/'.$controller_file;
        if(file_exists($controller_path)){
            include $controller_path;
        } else{
            include_once $baseDir.'controllers/SiteController.php';
            $error = new SiteError(404);
            $error->message = sprintf('Контроллер %s не найден', $controllerName);
            $controller = new SiteController();
            $controller->actionError($error);
            exit;
        }

        $controller = new $controllerName;
        $action = $actionName;

        if(method_exists($controller, $action)){
            $controller->$action();
        } else{
            include_once $baseDir.'controllers/SiteController.php';
            $error = new SiteError(404);
            $error->message = sprintf('Метод %s в контроллере %s не найден', $action, $controllerName);
            $controller = new SiteController();
            $controller->actionError($error);
        }
    }

    /**
     * @return string
     */
    public static function getLanguage(){
        $language = 'ru';
        if(isset($_COOKIE['language'])){
            if($_COOKIE['language'] === 'en'){
                $language = 'en';
            }
        }
        return $language;
    }
}
