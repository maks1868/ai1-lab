<?php
/** @var \App\Model\Boat $boat */
/** @var \App\Service\Router $router */

$title = 'Boat Details';
ob_start(); ?>
<h1>Boat Details</h1>
<p><strong>Name:</strong> <?= htmlspecialchars($boat->getName()) ?></p>
<p><strong>Length:</strong> <?= htmlspecialchars($boat->getLength()) ?> m</p>
<p><strong>Width:</strong> <?= htmlspecialchars($boat->getWidth()) ?> m</p>
<p><strong>Height:</strong> <?= htmlspecialchars($boat->getHeight()) ?> m</p>
<p><strong>Number of Sails:</strong> <?= htmlspecialchars($boat->getNumberOfSails()) ?></p>
<a href="<?= $router->generatePath('boat-index') ?>">Back to list</a>
<?php $main = ob_get_clean(); include __DIR__ . '/../base.html.php'; ?>
