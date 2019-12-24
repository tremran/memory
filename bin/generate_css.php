<?php 

ob_start();
include __DIR__ . '/../src/resources/css/memoire.css.php';
$cssContent = ob_get_contents();
ob_end_clean();

file_put_contents(__DIR__ . '/../front/css/memoire.css', $cssContent);