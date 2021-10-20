<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// загрузочный файл проекта
require_once 'bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager);