<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

try {

    // Регистрируем автозагрузчик
    $loader = new Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/'
    ))->register();

    // Создаем DI
    $di = new FactoryDefault();

    $router = new \Phalcon\Mvc\Router(false);
    $router->add("/", [
        "controller" => "account",
        "action" => "index"
    ]);

    $router->add("/user/signin", [
        "controller" => "user",
        "action" => "signin"
    ]);

    $router->add("/user/logout", [
        "controller" => "user",
        "action" => "logout"
    ]);

    $router->add("/transactions", [
        "controller" => "transaction",
        "action" => "index"
    ]);

    $router->add("/transactions/{id}/edit", [
        "controller" => "transaction",
        "action" => "edit"
    ]);

    $router->add("/transactions/create", [
        "controller" => "transaction",
        "action" => "create"
    ]);

    $router->add("/transactions/{id}/remove", [
        "controller" => "transaction",
        "action" => "remove"
    ]);

    $router->add("/account/show", [
        "controller" => "account",
        "action" => "show"
    ]);

    $router->add("/account/{id}/edit", [
        "controller" => "account",
        "action" => "edit"
    ]);

    $router->notFound([
        "controller" => "exception",
        "action" => "notFound"
    ]);

    $di->set('router', $router);

    $assets = $di->get('assets');
    $assets->addCss('assets/plugins/pace/pace-theme-flash.css')
        ->addCss('assets/plugins/boostrapv3/css/bootstrap.min.css')
        ->addCss('assets/plugins/boostrapv3/css/bootstrap-theme.min.css')
        ->addCss('assets/plugins/font-awesome/css/font-awesome.css')
        ->addCss('assets/css/animate.min.css')
        ->addCss('assets/css/style.css')
        ->addCss('assets/css/responsive.css')
        ->addCss('assets/css/custom-icon-set.css')
        ->addJs('assets/plugins/jquery-1.8.3.min.js')
        ->addJs('assets/plugins/bootstrap/js/bootstrap.min.js')
        ->addJs('assets/plugins/pace/pace.min.js');

    // Настраиваем сервис для работы с БД
    $di->set('db', function () {
        return new DbAdapter(array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "314",
            "dbname"   => "account",
            "charset" => "utf8"
        ));
    });

    $eventsManager = new \Phalcon\Events\Manager();
    $eventsManager->attach('dispatch', function (\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher) {
        if ($event->getType() == 'beforeExecuteRoute') {
            $controller_name = $dispatcher->getControllerName();
            if ($controller_name == 'account' || $controller_name == 'transaction') {
                $assets = \Phalcon\Di::getDefault()->get('assets');
                $assets->addCss('assets/css/magic_space.css')
                    ->addCss('assets/plugins/jquery-scrollbar/jquery.scrollbar.css')
                    ->addCss('assets/plugins/Mapplic/mapplic/mapplic.css')
                    ->addCss('assets/plugins/jquery-scrollbar/jquery.scrollbar.css')
                    ->addJs('assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js')
                    ->addJs('assets/plugins/breakpoints.js')
                    ->addJs('assets/plugins/jquery-lazyload/jquery.lazyload.min.js')
                    ->addJs('assets/plugins/jquery-unveil/jquery.unveil.min.js')
                    ->addJs('assets/plugins/jquery-block-ui/jqueryblockui.js')
                    ->addJs('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js')
                    ->addJs('assets/plugins/Mapplic/js/jquery.easing.js')
                    ->addJs('assets/js/core.js')
                    ->addJs('assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js');
            }
        }
    });

    $dispatcher = $di->get('dispatcher');
    $dispatcher->setEventsManager($eventsManager);

    $di->setShared('session', function () {
        $session = new Session();
        $session->start();
        return $session;
    });

    // Настраиваем компонент View
    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir('../app/views/');
        $view->setPartialsDir('partial/');
        $view->registerEngines(
            [
                ".volt" => View\Engine\Volt::class
            ]
        );
        return $view;

    });

    // Настраиваем базовый URI так, чтобы все генерируемые URI содержали директорию "tutorial"
    $di->set('url', function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    });

    // Обрабатываем запрос
    $application = new Application($di);

    $response = $application->handle();

    $response->send();

} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage(), "FILE: ", $e->getFile(), " LINE: ", $e->getLine();
}