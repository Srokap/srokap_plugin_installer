<?php

$name = get_input('name');

var_dump($name);


$composerCommand = dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor/bin/composer';

//TODO need proc_open here to capture stderr properly

var_dump($composerCommand . ' install ' . escapeshellarg($name));

echo '<pre>';
passthru($composerCommand . ' --version');
passthru($composerCommand . ' -vvv require ' . escapeshellarg($name), $return);
echo '</pre>';

var_dump($return);



die('done');
