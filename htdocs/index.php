<?php
namespace Kemenyende\FactoryGame\htdocs;

// Load - Settings
$settings = parse_ini_file('../settings.ini', true);
if (false === $settings) die('Cannot load index.ini');
if (empty($settings)) die('index.ini is empty');
$FGDir = $settings['SatisfactoryApp']['directory'];
if (empty($FGDir)) die('Undefined property in index.ini - [SatisfactoryApp].directory');
$FGLng = $settings['SatisfactoryApp']['language_default'];
if (empty($FGLng)) $FGLng = 'en-US';

// Check - Dependances
if (!in_array('mbstring', get_loaded_extensions())) die('mbstring extension required');

// Install - Simple Class auto-loader
spl_autoload_register(function ($class_name) {
	$matches = array();
	if (1 === preg_match('@^Kemenyende\\\\(FactoryGame\\\\.+)$@', $class_name, $matches)) {
		require_once "..\\{$matches[1]}.php";
	}
});

// INIT: Récupération, analyse et injection du fichier Docs.json
\Kemenyende\FactoryGame\SToryJsonDocs::parseJsonFile($FGDir, $FGLng);
\Kemenyende\FactoryGame\Pattern::initialize();

// HTML
include('header.php');
$path = explode('/', $_SERVER['PATH_INFO']); // ["PATH_INFO"]=>string(20) "/php/phpinfo/"

if ('' !== reset($path)) {
	http_response_code(400);
} elseif (empty($lib = next($path))) {
	http_response_code(400);
} elseif (empty($func = next($path))) {
	http_response_code(400);
} elseif ('php' == $lib) {
	if ('phpinfo' == $func) {
		phpinfo();
	} else {
		http_response_code(400);
	}
} elseif ('FGElement' == $lib) {
	if ('show-all' == $func) {
		\Kemenyende\FactoryGame\View::showAllElements();
	} else {
		http_response_code(400);
	}
} elseif ('CustomScript' == $lib) {
	if ('require_once' == $func) {
		
		if (empty($script = next($path))) $script = $_REQUEST['script'] ?? null;
		
		if (!is_string($script)) $script = null;

		$files = scandir("../CustomScript");

		if (!isset($script)) echo '<form><select name="script" OnChange="this.form.submit();"><option value=""></option>';
		foreach($files as $file) {
			if (!preg_match('/^[a-zA-Z0-9\- \(\)]+\.php$/', $file)) continue;
			$file = substr($file, 0, strlen($file)-4);

			if (!isset($script)) {
				echo '<option value="'.htmlentities($file).'">'.htmlspecialchars($file).'</option>';
			} elseif ($script === $file) {
				require_once("../CustomScript/{$script}.php");
				break;
			}

		}
		if (!isset($script)) echo '</select></form>';
	} else {
		http_response_code(400);
	}
} else {
	http_response_code(400);
}

readfile('footer.html');
