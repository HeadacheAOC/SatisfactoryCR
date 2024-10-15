<!doctype html>
<html lang="en">
<head>
<title>Google</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="/index.css">
<style>
/* CSS DEVONLY */
</style>
</head>
<body style="background-color:#999999">
<?php
use FactoryGame\SToryJsonDocs;
use FactoryGame\View;
use FactoryGame\Pattern;

// Load - Settings
$settings = parse_ini_file('../settings.ini', true);
if (false === $settings) die('Cannot load index.ini');
if (empty($settings)) die('index.ini is empty');
$FGDir = $settings['SatisfactoryApp']['directory'];
if (empty($FGDir)) die('Undefined property in index.ini - [SatisfactoryApp].directory');
$FGLng = $settings['SatisfactoryApp']['language_default'];
if (empty($FGLng)) $FGLng = 'en-US';

// Check - Dependances
if (!in_array('mbstring', get_loaded_extensions())) die('mbstring not load');

// Install - Simple Class auto-loader
spl_autoload_register(function ($class_name) {
    if (($dir = 'FactoryGame\\') == substr($class_name, 0, strlen($dir))) {
        require_once "../{$class_name}.php";
    }
});

function html_body() {
    if ('/index.php' !== $_SERVER['SCRIPT_NAME']) return;
    
    $path = explode('/', $_SERVER['PATH_INFO']); // ["PATH_INFO"]=>string(20) "/php/phpinfo/"
    if ('' !== reset($path)) return;
    
    $lib = next($path);
    if (empty($lib)) return;
    
    $func = next($path);
    
    if ('php' == $lib) {
        if ('phpinfo' == $func) {
            phpinfo();
        }
    } elseif ('FGElement' == $lib) {
        if ('show-all' == $func) {
            View::showAllElements();
        }
    } elseif ('CustomScript' == $lib) {
        if ('require_once' == $func) {
            $script = next($path);
            if (empty($script)) $script = $_REQUEST['script'] ?? null;
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
        }
    }
}

// INIT: Récupération, analyse et injection du fichier Docs.json
SToryJsonDocs::parseJsonFile($FGDir, $FGLng);
Pattern::initialize();

html_body();

?>
</body>
</html>