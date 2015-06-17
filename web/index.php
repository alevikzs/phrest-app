<?php

include __DIR__ . "/../vendor/autoload.php";

try {
    (new \App\Bootstrap\Web\Live())->go();
} catch (\Exception $exception) {
    (new \Rise\Http\Response\Error(
        new \Rise\Models\Response\Base\Exception($exception)
    ))->send();
}