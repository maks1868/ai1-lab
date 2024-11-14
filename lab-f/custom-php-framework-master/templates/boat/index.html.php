<?php
/** @var \App\Model\Boat[] $boats */
/** @var \App\Service\Router $router */

$title = 'Boat List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Boat List</h1>
    <a href="<?= $router->generatePath('boat-create') ?>">Add a new Boat</a>

    <ul class="index-list"> <!-- Klasa index-list -->
        <?php foreach ($boats as $boat): ?>
            <li>
                <h3><?= htmlspecialchars($boat->getName()) ?></h3>
                <ul class="action-list"> <!-- Klasa action-list -->
                    <li><a href="<?= $router->generatePath('boat-show', ['id' => $boat->getId()]) ?>">View</a></li>
                    <li><a href="<?= $router->generatePath('boat-edit', ['id' => $boat->getId()]) ?>">Edit</a></li>
                    <li><a href="<?= $router->generatePath('boat-delete', ['id' => $boat->getId()]) ?>" onclick="return confirm('Are you sure?')">Delete</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . '/../base.html.php';
