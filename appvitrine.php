<?php /*
 Plugin Name:AppVitrine
 Plugin URI: http://lookitap.com/appvitrine.php
 Description: Use AppVitrine plugin to add the app install ads as an extra source of revenue into your blog.
 Version: 2.3.1
 Author: Quantaad
 Author URI: http://quantaad.com
 License: GPLv2
 Usage: [appvitrine size="normal" keywords="keyword1,keyword2,keyword3"]
 */

/********************************************************************************/
// set default parameters
if (get_option("appvitrine_plugin_initiated") != "true") {

	//general settings
	update_option('appvitrine_gs_onlyMobile', "1");
	update_option('appvitrine_gs_useCategoriesByDefault', "1"); //not used for now

	//show in all pages settings
	update_option('appvitrine_df_enable', "on");
	update_option('appvitrine_df_type', "slider");
	update_option('appvitrine_df_format', "icon-f1");
	update_option('appvitrine_df_postContentTag', "3");
	
	//shortcode settings
	update_option('appvitrine_sc_defaultFormat', "icon-f1");
	update_option('appvitrine_sc_defaultType', "slider");
	update_option('appvitrine_sc_useTagsByDefault', "1");

	update_option("appvitrine_plugin_initiated", "true");
}

/********************************************************************************/
add_filter('the_content', 'appvitrine_filter_backend_scraper_handler');
function appvitrine_filter_backend_scraper_handler($content) {
	$header = getallheaders();
	if ($header['AV-TOKEN'] == 'true') {
		$custom_content = '<div id="av_token_content" style="display:none;">';
		$custom_content .= "<div id='av_token_content_body'>" . get_the_content('Read more') . "</div>";
		$custom_content .= "<div id='av_token_content_title'>" . get_the_title() . "</div>";
		$custom_content .= "<div id='av_token_content_date'>" . get_the_date() . "</div>";
		$custom_content .= "<div id='av_token_content_category'>";
		foreach ((get_the_category()) as $category) {
			$custom_content .= "<span>" . $category -> cat_name . "</span>";
		}
		$custom_content .= "</div>";
		$custom_content .= '</div>';
		return $custom_content . $content;
	}
	return $content;
}

/********************************************************************************/
if (get_option("appvitrine_df_enable") == "on") {
	add_filter('the_content', 'appvitrine_filter_renderDefaultShortcode');
	function appvitrine_filter_renderDefaultShortcode($content) {

		$type = get_option("appvitrine_df_type");
		$format = get_option("appvitrine_df_format");
		$onlyMobile = (get_option("appvitrine_gs_onlyMobile") == "1") ? "yes" : "no";
		$keywordsOnly = "no";
		$keywords = "";
		$categories = "";

		$postcat = get_the_category();
		if ($postcat && $postcat[0] -> cat_name != 'Uncategorized') {
			foreach ($postcat as $cat) {
				if ($categories != "")
					$categories .= ",";
				$categories .= $cat -> cat_name;
			}
		}

		if (get_option("appvitrine_df_postContentTag") == "2") {
			$posttags = get_the_tags();
			$keywordsOnly = "yes";
			if ($posttags && sizeof($posttags) > 0) {
				foreach ($posttags as $tag) {
					if ($keywords != "")
						$keywords .= ",";
					$keywords .= $tag -> name;
				}
			} else {
				$keywordsOnly = "no";
			}
		}

		if (get_option("appvitrine_df_postContentTag") == "3") {
			$keywordsOnly = "no";
			if ($posttags && sizeof($posttags) > 0) {
				foreach ($posttags as $tag) {
					if ($keywords != "")
						$keywords .= ",";
					$keywords .= $tag -> name;
				}
			}
		}

		$arr = array("type" => $type, "format" => $format, "mobile-only" => $onlyMobile, 'keywords' => $keywords, 'categories' => $categories, 'keywords_only' => $keywordsOnly, );
		return $content . appvitrine_shortcode($arr);
	}

}
/********************************************************************************/
add_action('wp_enqueue_scripts', 'appvitrine_action_managescripts');
function appvitrine_action_managescripts() {
	wp_enqueue_script('jquery');
}

/********************************************************************************/
function appvitrine_action_adminHead() {
	$siteurl = get_option('siteurl');
	$url = WP_PLUGIN_URL . '/' . basename(__DIR__) . '/css/style.css';
	echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

add_action('admin_head', 'appvitrine_action_adminHead');
/********************************************************************************/
add_shortcode('appvitrine', 'appvitrine_shortcode');
function appvitrine_shortcode($atts, $content = null, $format = "show_ad") {

	//Generate private and public key and register it on server
	//-------------------------------------------------------------------------
	if (get_option('appvitrine_app_initiated') != "true") {
		$publicationId = substr(md5(uniqid(get_site_url(), true)), 0, 32);
		update_option('appvitrine_publication_id', "");
		update_option('appvitrine_default_publication_id', $publicationId);
		update_option('appvitrine_private_key', substr(md5(uniqid(rand(), true)), 0, 32));
		update_option('appvitrine_app_initiated', 'true');
	}

	//indicating default values
	//-------------------------------------------------------------------------
	$at = get_option("appvitrine_gs_iTunes_affiliate_id");
	$type = get_option("appvitrine_sc_defaultType");
	$format = get_option("appvitrine_sc_defaultFormat");
	$onlyMobile = (get_option("appvitrine_gs_onlyMobile") == "1") ? "yes" : "no";
	$keywordsOnly = "no";
	$keywords = "";
	$categories = "";

	if (get_option("appvitrine_sc_useTagsByDefault") == "1") {
		$posttags = get_the_tags();
		if ($posttags && sizeof($posttags) > 0) {
			foreach ($posttags as $tag) {
				if ($keywords != "")
					$keywords .= ",";
				$keywords .= $tag -> name;
			}
		}
	}
	$postcat = get_the_category();
	if ($postcat && $postcat[0] -> cat_name != 'Uncategorized') {
		foreach ($postcat as $cat) {
			if ($categories != "")
				$categories .= ",";
			$categories .= $cat -> cat_name;
		}
	}
	//-------------------------------------------------------------------------

	$defaults = array('keywords' => $keywords, 'categories' => $categories, 'keywords_only' => $keywordsOnly, 'at' => $at, 'type' => $type, 'format' => $format, "mobile-only" => $onlyMobile);

	// Use the default value if the reffering attribute is not set
	foreach ($defaults as $default => $value) {
		if (!@array_key_exists($default, $atts)) {// hide warning with "@" when no params at all
			$atts[$default] = $value;
		}
	}

	$src = "http://appvitrine.lookitap.com/4s/frame?p=wp&r=0";

	// Append parameter values to the src url

	// Create Tiny Url
	// {
	$url = get_permalink();
	$tinyurl = str_replace("http://", "", $url);
	$tinyurl = substr($tinyurl, 0, 32) . md5(substr($tinyurl, 32, strlen($tinyurl)));

	// }

	$src .= "&tinyurl=" . urlencode($tinyurl);
	$src .= "&siteurl=" . urlencode(get_site_url());
	$src .= '&pid=' . get_option("appvitrine_publication_id");
	$src .= '&dpid=' . get_option("appvitrine_default_publication_id");

	$src .= '&om=' . $atts["mobile-only"];
	$src .= '&ko=' . $atts["keywords_only"];

	if ($atts["keywords"] != '')
		;
	$src .= '&kw=' . urlencode($atts["keywords"]);

	if ($atts["categories"] != '')
		;
	$src .= '&cat=' . urlencode($atts["categories"]);

	if ($atts["format"] != '')
		$src .= '&format=' . $atts["format"];

	if ($atts["at"] != '')
		$src .= '&at=' . $atts["at"];

	$src .= "&q=" . urlencode(wp_get_shortlink());
	$src .= "&perma=" . urlencode(get_permalink());
	$src .= "&title=" . urlencode(get_the_title());	
	$src .= '&pv=' . "AV2.3.1";  //plugin version. this must be changed when version is changed.
	$src .= "&h=" . md5(get_the_content());

	// Define a static counter to support multiple slider in one post, a postfix counter will be added to each element id.
	static $appvitrine_slider_counter = 1;
	
	$src .= "&dn=" . $appvitrine_slider_counter;  //div number in page

	wp_enqueue_script('jquery');

	$max_number_of_sliders_in_one_page  = 3;
	
	if( $appvitrine_slider_counter <=  $max_number_of_sliders_in_one_page ){
		$appVitrineJSURL = '://cdn.appvitrine.com/js/appvitrine_v1.min.js';
		$html .= '<div id="appvitrine_div_' . $appvitrine_slider_counter . '" ></div>';
		$html .= "<script>
					if (typeof(appvitrine_executer) == 'undefined'){
						var jsUrl= (('https:' == document.location.protocol)? 'https': 'http') + '".$appVitrineJSURL."';
						jQuery.getScript(jsUrl,function(){
							appvitrine_executer('appvitrine_div_$appvitrine_slider_counter','$src',".json_encode($atts).");	
						});
					}
					else{
						appvitrine_executer('appvitrine_div_$appvitrine_slider_counter','$src',".json_encode($atts).");
					}
				</script>";
	}
	
	$appvitrine_slider_counter++;
	return $html;
}

/********************************************************************************/
add_action('admin_menu', 'appvitrin_menu');
function appvitrin_menu() {
	add_menu_page("AppVitrine", "AppVitrine", "manage_options", "appvitrin", "appvitrine_menu_options", 'dashicons-editor-unlink', 81);
	add_submenu_page("appvitrin", "Settings", "Settings", "manage_options", "appvitrin", "appvitrine_menu_options", 'dashicons-editor-unlink', 81);
	add_submenu_page("appvitrin", "Help", "Help", "manage_options", "appvitrine_help", "appvitrine_help");
	add_submenu_page("appvitrin", "Subscription", "Subscription", "manage_options", "appvitrine_subscription", "appvitrine_subscription");
}

function appvitrine_menu_options() {
	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	wp_enqueue_style('options_style');
	include ("settings.php");
}

function appvitrine_help() {
	include ('help.php');
}

function appvitrine_subscription() {
	include ('subscription.php');
}
