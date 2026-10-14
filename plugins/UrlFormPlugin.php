<?php

use Proxy\Plugin\AbstractPlugin;
use Proxy\Event\ProxyEvent;

class UrlFormPlugin extends AbstractPlugin {

	public function onCompleted(ProxyEvent $event){
	
		$request = $event['request'];
		$response = $event['response'];
		
		$url = $request->getUri();
		
		// we attach url_form only if this is a html response
		if(!is_html($response->headers->get('content-type'))){
			return;
		}
		
		// toolbar shown on top of every proxied page
		$url_form = render_template(__DIR__ . "/../templates/url_form.php", array(
			'url' => $url
		));
		
		$output = $response->getContent();
		
		// does the html page contain <body> tag, if so insert our form right after <body> tag starts
		// a callback so that $1 or \1 inside the URL are not treated as backreferences
		$result = preg_replace_callback('@<body.*?>@is', function($matches) use ($url_form){
			return $matches[0].PHP_EOL.$url_form;
		}, $output, 1, $count);
		
		// preg_* returns null on failure (e.g. backtrack limit on huge pages) - never blank out the page
		if($result !== null){
			$output = $result;
		}
		
		// <body> tag was not found, just put the form at the top of the page
		if(!$count){
			$output = $url_form.$output;
		}
		
		$response->setContent($output);
	}
}
