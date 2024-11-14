<?php
/** @var \App\Service\Router $router */

$title = 'Add Boat';
ob_start(); ?>
<h1>Add Boat</h1>
<form action="<?= $router->generatePath('boat-create') ?>" method="post">
    <?php include __DIR__ . '/_form.html.php'; ?>
</form>
<?php $main = ob_get_clean(); include __DIR__ . '/../base.html.php'; ?>
