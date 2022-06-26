<?php

$wp_load = realpath("wp-load.php");

while(!file_exists($wp_load)) {
$wp_load = '../' . $wp_load;
}

//require_once($wp_load);
echo "Com realpath wp_load=" . $wp_load;

echo "<br>Com ABSPATH=" . ABSPATH;

//include wp-config or wp-load.php
$root = dirname(dirname(dirname(dirname(__FILE__))));
echo "<br>Com dirname wp_load=" . $root;
$wp_load = $root . "/../wp-load.php";
if (file_exists($wp_load)) {
	echo "  <--Achou!!";
}

echo "<br>-----------<br>";

$root = dirname(__FILE__);
echo "<br>caminho deste test.php=" . $root;
$root = dirname(dirname(__FILE__));
echo "<br>" . $root;
$root = dirname(dirname(dirname(__FILE__)));
echo "<br>" . $root;

$root = dirname(dirname(dirname(dirname(__FILE__))));
echo "<br>" . $root;

$root = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
echo "<br>caminho do wp-load.php=" . $root;

//https://developer.wordpress.org/reference/functions/plugin_dir_path/
//https://developer.wordpress.org/plugins/plugin-basics/determining-plugin-and-content-directories/

