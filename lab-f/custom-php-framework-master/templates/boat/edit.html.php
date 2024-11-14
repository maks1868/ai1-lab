<?php
/** @var \App\Model\Boat $boat */
/** @var \App\Service\Router $router */

$title = 'Edit Boat';
ob_start(); ?>
<h1>Edit Boat</h1>
<form action="<?= $router->generatePath('boat-edit', ['id' => $boat->getId()]) ?>" method="post">
    <?php include __DIR__ . '/_form.html.php'; ?>
</form>
<?php $main = ob_get_clean(); include __DIR__ . '/../base.html.php'; ?>
