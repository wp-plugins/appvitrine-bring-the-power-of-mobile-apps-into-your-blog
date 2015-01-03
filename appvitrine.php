<?php
/*
Plugin Name: AppVitrine
Plugin URI: http://lookitap.com/appvitrine.php
Description: Easily and automatically embed apps related to your content or subjects you like into your blog posts. Earn affiliate revenue from Apple.
Version: 1.1
Author: Lookitap
Author URI: http://lookitap.com
License: GPLv2
Usage: [appvitrine size="normal" keywords="keyword1,keyword2,keyword3"]
*/

if ( ! function_exists( 'appvitrine_unqprfx_embed_shortcode' ) ) :

	function appvitrine_unqprfx_enqueue_script() {
		wp_enqueue_script( 'jquery' );
	}
	add_action( 'wp_enqueue_scripts', 'appvitrine_unqprfx_enqueue_script' );
	
	function wptuts_scripts_basic()
	{
        // Register easyXDM (http://easyxdm.net/wp/) Javascript. EasyXDM is used to dynamically resize the embedded content.
   		wp_register_script( 'easyXDM', plugins_url( './js/easyXDM.min.js', __FILE__ ) );
		wp_enqueue_script( 'easyXDM' );
	}
	add_action( 'wp_enqueue_scripts', 'wptuts_scripts_basic' );

	function appvitrine_unqprfx_embed_shortcode( $atts, $content = null ) {
		$defaults = array(
            	    'keywords' => '',
                    'keywords_only' => 'no',
                    'size' => 'normal',
		    'at' => '',
		    'type' => 'default'
 		);

        // Use the default value if the reffering attribute is not set
        foreach ( $defaults as $default => $value ) { 
			if ( ! @array_key_exists( $default, $atts ) ) { // hide warning with "@" when no params at all
				$atts[$default] = $value;
			}
		}

	$src = "http://appvitrine.lookitap.com/WebFront/frame?p=wp&pid=1&r=0";
        
		// Append parameter values to the src url
        $src .= '&s=' . $atts["size"];
        $src .= '&ko=' . $atts["keywords_only"];
        if ( $atts["keywords"] != '') {
			$src .= '&kw=' . $atts["keywords"];
		}
 
        if ( $atts["at"] != '') {
		$src .= '&at=' . $atts["at"];
	}

        $src .= "&q=" . wp_get_shortlink();
        $src .= "&h=" . md5(get_the_content());

        // Define a static counter to support multiple slider in one post, a postfix counter will be added to each element id. 
        static $i = 0;
	
wp_enqueue_script('jquery');

        $html .='<script type="text/javascript">
                    var transport'.$i.' = new easyXDM.Socket(/** The configuration */{
                        remote: "'.$src.'",
                        container: "embedded'.$i.'",
                        onMessage: function(message, origin){
                            this.container.getElementsByTagName("iframe")[0].style.height = message + "px";
                            this.container.getElementsByTagName("iframe")[0].style.width = "100%";
			this.container.getElementsByTagName("iframe")[0].style.marginBottom = "0px";';
			if ($atts["type"] == "button" || $atts["type"] == "link") {	
				$html .= 'document.getElementById("embedded'.$i.'").style.display = "none";';
			}
                     $html .= '   }
                    });

jQuery(document).ready(function() {
	
});

function toggleDisplay(j) {
    	document.getElementById(\'appVitrineButton\'+j).style.display = "none";
	jQuery(\'#embedded\'+j).animate({opacity: 1, height: \'toggle\'}, \'fast\', \'swing\');
	
}

                </script>';

	if ($atts["type"] == "button") {	
		$html .= '<button id="appVitrineButton'.$i.'" onclick="toggleDisplay('.$i.');">Show Related Apps</button>';
	}
	
	if ($atts["type"] == "link") { 
		$html .= '<a id="appVitrineButton'.$i.'" href="" onclick="toggleDisplay('.$i.');return false;">Show Related Apps</a>';
	}

    	 $html .= '<div style="" id="embedded'.$i.'"></div>';
        $i++;

		return $html;
	}
	add_shortcode( 'appvitrine', 'appvitrine_unqprfx_embed_shortcode' );

	
endif; // end of (function_exists('appvitrine_unqprfx_embed_shortcode'))