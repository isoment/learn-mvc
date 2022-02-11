<?php
/** @var $exception \Exception */
?>

<div class="flex justify-center items-center">
    <div class="flex flex-col items-center justify-center h-screen -mt-14">
        <h1 class="text-2xl text-red-500 font-bold font-mono text-gray-800">
            <?php echo $exception->getCode() ?> - <?php echo $exception->getMessage() ?>
        </h1>
        <div class="mt-2">
            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
</div>
