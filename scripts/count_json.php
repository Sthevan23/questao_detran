<?php
$j = json_decode(file_get_contents(__DIR__ . '/questoes_100.json'), true);
echo is_array($j) ? count($j) : 0;
