<?php

/*
 * Plugin Name: Webservice plugin
 * Description: simple boilerplate for adding api mapper for your plugin
 * Version: 1.0
 * Author: Abolfazl Sabagh
 * Author URI: https://a-sabagh.ir
 * Text Domain: ODT
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once trailingslashit(__DIR__) . "includes/init.php";
$init = new odt\init(1.0, 'odt');