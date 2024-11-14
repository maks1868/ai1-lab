<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = new \App\Service\Config();
$templating = new \App\Service\Templating();
$router = new \App\Service\Router();

$action = $_REQUEST['action'] ?? null;
switch ($action) {
    case 'post-index':
    case null:
        $controller = new \App\Controller\PostController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'post-create':
        $controller = new \App\Controller\PostController();
        $view = $controller->createAction($_REQUEST['post'] ?? null, $templating, $router);
        break;
    case 'post-edit':
        if (! $_REQUEST['id']) {
            break;
        }
        $controller = new \App\Controller\PostController();
        $view = $controller->editAction($_REQUEST['id'], $_REQUEST['post'] ?? null, $templating, $router);
        break;
    case 'post-show':
        if (! $_REQUEST['id']) {
            break;
        }
        $controller = new \App\Controller\PostController();
        $view = $controller->showAction($_REQUEST['id'], $templating, $router);
        break;
    case 'post-delete':
        if (! $_REQUEST['id']) {
            break;
        }
        $controller = new \App\Controller\PostController();
        $view = $controller->deleteAction($_REQUEST['id'], $router);
        break;
    case 'info':
        $controller = new \App\Controller\InfoController();
        $view = $controller->infoAction();
        break;
    case 'boat-index':
        $controller = new \App\Controller\BoatController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'boat-create':
        $controller = new \App\Controller\BoatController();
        $view = $controller->createAction($_REQUEST['boat'] ?? null, $templating, $router);
        break;
    case 'boat-edit':
        if (!$_REQUEST['id']) break;
        $controller = new \App\Controller\BoatController();
        $view = $controller->editAction($_REQUEST['id'], $_REQUEST['boat'] ?? null, $templating, $router);
        break;
    case 'boat-show':
        if (!$_REQUEST['id']) break;
        $controller = new \App\Controller\BoatController();
        $view = $controller->showAction($_REQUEST['id'], $templating, $router);
        break;
    case 'boat-delete':
        if (!$_REQUEST['id']) break;
        $controller = new \App\Controller\BoatController();
        $view = $controller->deleteAction($_REQUEST['id'], $router);
        break;

    default:
        $view = 'Not found';
        break;
}

if ($view) {
    echo $view;
}
