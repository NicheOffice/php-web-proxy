<?php

define('PROXY_START', microtime(true));

require(__DIR__ . "/vendor/autoload.php");

use Proxy\Config;
use Proxy\Http\Request;
use Proxy\Proxy;

if (!function_exists('curl_version')) {
    die("cURL extension is not loaded!");
}

// load config...
Config::load(__DIR__ . '/config.php');

// custom config file to be written to by a bash script or something
Config::load(__DIR__ . '/custom_config.php');

if (!Config::get('app_key')) {
    die("app_key inside config.php cannot be empty!");
}

// sessions are only needed for url_mode 3 - otherwise they just add cookies and no-cache headers to every proxied response
if (Config::get('url_mode') == 3) {
    session_start();
}

// how are our URLs be generated from this point? this must be set here so the proxify_url function below can make use of it
if (Config::get('url_mode') == 2) {
    Config::set('encryption_key', md5(Config::get('app_key') . $_SERVER['REMOTE_ADDR']));
} else if (Config::get('url_mode') == 3) {
    Config::set('encryption_key', md5(Config::get('app_key') . session_id()));

    // very important!!! otherwise requests are queued while waiting for session file to be unlocked
    session_write_close();
}

// form submit in progress...
if (isset($_POST['url']) && is_string($_POST['url']) && trim($_POST['url']) !== '') {

    $url = add_http(trim($_POST['url']));

    header("HTTP/1.1 302 Found");
    header('Location: ' . proxify_url($url));
    exit;

} else if (!isset($_GET['q']) || !is_string($_GET['q'])) {

    // must be at homepage - should we redirect somewhere else?
    if (Config::get('index_redirect')) {

        // redirect to...
        header("HTTP/1.1 302 Found");
        header("Location: " . Config::get('index_redirect'));

    } else if (isset($_GET['tos'])) {
        echo render_template(__DIR__ . "/templates/tos.php", array('version' => Proxy::VERSION));
    } else {
        echo render_template(__DIR__ . "/templates/main.php", array('version' => Proxy::VERSION));
    }

    exit;
}

// decode q parameter to get the real URL
$url = url_decrypt($_GET['q']);

$proxy = new Proxy();

// load plugins
foreach (Config::get('plugins', array()) as $plugin) {

    $plugin_class = $plugin . 'Plugin';

    if (file_exists(__DIR__ . '/plugins/' . $plugin_class . '.php')) {

        // use user plugin from /plugins/
        require_once(__DIR__ . '/plugins/' . $plugin_class . '.php');

    } else if (class_exists('\\Proxy\\Plugin\\' . $plugin_class)) {

        // does the native plugin from php-proxy package with such name exist?
        $plugin_class = '\\Proxy\\Plugin\\' . $plugin_class;
    }

    // otherwise plugin_class better be loaded already through composer.json and match namespace exactly \\Vendor\\Plugin\\SuperPlugin
    if (!class_exists($plugin_class)) {
        error_log("php-web-proxy: plugin '{$plugin}' not found, skipping");
        continue;
    }

    $proxy->getEventDispatcher()->addSubscriber(new $plugin_class());
}

try {

    // refuse anything that is not a public http(s) URL
    validate_target_url($url);

    // request sent to index.php
    $request = Request::createFromGlobals();

    // remove all GET parameters such as ?q=
    $request->get->clear();

    // forward it to some other URL
    $response = $proxy->forward($request, $url);

    // if that was a streaming response, then everything was already sent and script will be killed before it even reaches this line
    $response->send();

} catch (Throwable $ex) {

    // PHP errors may expose server paths - log them and show something generic instead
    if ($ex instanceof Exception) {
        $error_msg = $ex->getMessage();
    } else {
        error_log((string)$ex);
        $error_msg = "Internal error while loading this page.";
    }

    // if the site is on server2.proxy.com then you may wish to redirect it back to proxy.com
    if (Config::get("error_redirect")) {

        $url = render_string(Config::get("error_redirect"), array(
            'error_msg' => rawurlencode($error_msg)
        ));

        // Cannot modify header information - headers already sent
        header("HTTP/1.1 302 Found");
        header("Location: {$url}");

    } else {

        echo render_template(__DIR__ . "/templates/main.php", array(
            'url' => $url,
            'error_msg' => $error_msg,
            'version' => Proxy::VERSION
        ));

    }
}
