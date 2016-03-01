<?php

require_once __DIR__ . '/../../../phpOMS/Autoloader.php';

$C128a = new \phpOMS\Utils\Barcode\C128b('+HSDG1234561/$$8120216123546548978965/16D20160201%', 40);
$image = $C128a->get();

header ('Content-type: image/png');
imagepng($image);
imagedestroy($image);
