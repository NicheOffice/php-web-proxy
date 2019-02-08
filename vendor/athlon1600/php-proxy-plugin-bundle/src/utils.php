<?php

function vid_player($url, $width, $height, $extension = false){

	$path = parse_url($url, PHP_URL_PATH);
	
	$html5 = false;
	
	if($path){
	
		$extension = $extension ? $extension : pathinfo($path, PATHINFO_EXTENSION);
		
		if($extension == 'mp4' || $extension == 'webm' || $extension == 'ogg'){
			$html5 = true;
		}
	}
	
	// this better be an absolute url and proxify_url function better already be included from somewhere
	$video_url = proxify_url($url);

	if($html5){
	
		$html = '<video width="100%" height="100%" controls autoplay>
			<source src="'.$video_url.'" type="video/'.$extension.'">
			Your browser does not support the video tag.
		</video>';
		
	} else {
	
		// encode before embedding it into player's parameters
		$video_url = rawurlencode($video_url);
	
		$html = '<object id="flowplayer" width="'.$width.'" height="'.$height.'" data="//releases.flowplayer.org/swf/flowplayer-3.2.18.swf" type="application/x-shockwave-flash">
 	 
       	<param name="allowfullscreen" value="true" />
		<param name="wmode" value="transparent" />
        <param name="flashvars" value=\'config={"clip":"'.$video_url.'", "plugins": {"controls": {"autoHide" : false} }}\' />
		
		</object>';
	}
	
	return $html;
}

?>