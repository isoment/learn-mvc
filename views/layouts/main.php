<?php 

use app\core\Application;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tailwind.css">
    <title>Simple MVC</title>
</head>
<body>
    <nav class="px-4 py-3 flex items-center justify-between border-b font-mono">
        <div>
            <a href="/" class="text-green-400 font-bold">SimpleMVC</a>
        </div>
        <div class="flex items-center">
            <a href="/contact" class="mr-4 font-bold text-sm tracking-widest">Contact</a>
            <a href="/about" class="mr-4 font-bold text-sm tracking-widest">About</a>
            <?php if (Application::isGuest()): ?>
                <div>
                    <a href="/register" class="mr-4 font-bold text-sm tracking-widest">Register</a>
                    <a href="/login" class="font-bold text-sm tracking-widest">Login</a>
                </div>
            <?php else: ?>
                <div class="ml-2 text-red-500">
                    <a class="font-bold text-sm tracking-widest" href="/logout">
                        Logout
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <?php if (Application::$app->session->getFlash('success')): ?>
        <div class="alert alert-success mx-4 my-3 px-3 py-2 border rounded-sm text-bold text-green-500 bg-green-100 border-green-500">
            <?php echo Application::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    {{content}}
</body>
</html>