<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/src/include.php';

return ConsoleRunner::createHelperSet($entityManager);