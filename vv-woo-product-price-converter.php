<?php defined('ABSPATH') || exit('No direct script access allowed');

	/*
		* Plugin Name: VVerner - Woocommerce Product Price Converter
		* Description: Realiza a conversão do preço dos produtos para o dólar na cotação atual
		* Author: VVerner
		* Author: https://vverner.com
		* Version: 0.1
		* Requires at least: 6.0
		* Tested up to: 6.0
		* Requires PHP: 7.2
		*/

	define('VVWPPC_FILE', __FILE__);
	define('VVWPPC_APP', __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
	require_once VVWPPC_APP . 'App.php';