<?php 

ob_start();
include __DIR__ . '/../src/resources/css/memoire.css.php';
$cssContent = ob_get_contents();
ob_end_clean();
$cssDir = __DIR__ . '/../front/css/';

if (! file_exists($cssDir))
{
    mkdir($cssDir);
}
file_put_contents(__DIR__ . '/../front/css/memoire.css', $cssContent);