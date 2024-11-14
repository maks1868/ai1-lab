<?php
namespace App\Controller;

use App\Model\Boat;
use App\Service\Router;
use App\Service\Templating;
use App\Exception\NotFoundException;

class BoatController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $boats = Boat::findAll();
        return $templating->render('boat/index.html.php', ['boats' => $boats, 'router' => $router]);
    }

    public function createAction(?array $requestBoat, Templating $templating, Router $router): ?string
    {
        if ($requestBoat) {
            $boat = Boat::fromArray($requestBoat);
            $boat->save();

            $path = $router->generatePath('boat-index');
            $router->redirect($path);
            return null;
        }
        return $templating->render('boat/create.html.php', ['router' => $router]);
    }

    public function editAction(int $boatId, ?array $requestBoat, Templating $templating, Router $router): ?string
    {
        $boat = Boat::find($boatId);
        if (!$boat) throw new NotFoundException("Boat with id $boatId not found");

        if ($requestBoat) {
            $boat->fill($requestBoat);
            $boat->save();

            $path = $router->generatePath('boat-index');
            $router->redirect($path);
            return null;
        }
        return $templating->render('boat/edit.html.php', ['boat' => $boat, 'router' => $router]);
    }

    public function showAction(int $boatId, Templating $templating, Router $router): ?string
    {
        $boat = Boat::find($boatId);
        if (!$boat) throw new NotFoundException("Boat with id $boatId not found");

        return $templating->render('boat/show.html.php', ['boat' => $boat, 'router' => $router]);
    }

    public function deleteAction(int $boatId, Router $router): ?string
    {
        $boat = Boat::find($boatId);
        if (!$boat) throw new NotFoundException("Boat with id $boatId not found");

        $boat->delete();
        $router->redirect($router->generatePath('boat-index'));
        return null;
    }
}
