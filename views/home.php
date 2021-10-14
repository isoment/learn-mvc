<?php use app\core\Application; ?>

<div class="my-4 mx-4">
        <h1 class="text-2xl font-bold font-mono text-gray-800">
                Welcome <?php echo Application::$app->user->getDisplayName()?>
        </h1>
</div>