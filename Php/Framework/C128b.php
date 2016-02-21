<?php

require_once __DIR__ . '/../../../phpOMS/Autoloader.php';

$C128a = new \phpOMS\Utils\Barcode\C128b('Test');
$image = $C128a->get();

header ('Content-type: image/png');
imagepng($image);
imagedestroy($image);
