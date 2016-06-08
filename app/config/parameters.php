<?php

$web_dir = getenv('EXTERNAL_WEB_DIR') ?: "%kernel.root_dir%/../public_html";
$container->setParameter('external.web_dir', $web_dir);