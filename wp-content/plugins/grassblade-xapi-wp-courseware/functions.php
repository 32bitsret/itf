<?php

/**
 * @package GrassBlade 
 * @version 2.3
 */
/*
Plugin Name: Experience API for WP Courseware by Grassblade
Plugin URI: https://www.nextsoftwaresolutions.com/experience-api-for-wp-courseware/
Description: This plugin enables the Experience API (xAPI) support on the WP Courseware LMS by integrating with GrassBlade xAPI Companion plugin. 
Author: Next Software Solutions
Version: 2.3
Author URI: https://www.nextsoftwaresolutions.com
*/

use WPCW\Models\Course;

class grassblade_wp_courseware {
	
	public $version = "2.3";
	public $install_link = "https://www.nextsoftwaresolutions.com/r/wpcourseware/addon_info_page";

	function __construct() {

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if(!class_exists('grassblade_addons'))
		require_once(dirname(__FILE__)."/addon_plugins/functions.php");

		add_action('admin_menu', array($this, 'menu'), 11);
		add_action( 'plugins_loaded', array($this, "plugins_loaded") );
	}

	function plugins_loaded() {
		load_plugin_textdomain( 'grassblade-xapi-wp-courseware', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );

		if ( defined("GRASSBLADE_VERSION") && version_compare(GRASSBLADE_VERSION, '3.1.11', '>=') && defined("WPCW_VERSION") && version_compare(WPCW_VERSION, '4.6.3', '>=') ) {
			$this->run();
		}
		else if(empty($_GET["page"]) || $_GET["page"] != "grassblade-wp-courseware")
			add_action( 'admin_notices', array($this, 'installation_notice') );
	}

	function run() {

		add_action( 'admin_enqueue_scripts', array($this,'custom_script_courseware') );

		if( is_plugin_active('wp-courseware/wp-courseware.php') && is_plugin_active('grassblade/grassblade.php') )
		$this->run_on_plugins_active();

		//add_filter("gb_profile_data", array($this,'user_profile'), 10, 2);   
	}
	function run_on_plugins_active() {

		add_action( 'wp_print_scripts', array($this, 'wpcw_hide_mark_complete_button_and_quiz'));

		add_filter( 'the_content', array($this,'wpcw_add_quiz_unit_post'),2,1);

		add_action( 'grassblade_completed', array($this, 'wpcw_content_completed'), 10, 3);

		add_filter( 'grassblade_is_show_hide_button', array($this, 'set_show_hide_button_status'), 10, 4);

		if (version_compare(WPCW_VERSION, '4.8.8', '<='))
		add_filter( 'wpcw_front_completion_box', array($this, 'disable_button_setting'), 10, 1 );
		else
		add_filter( 'wpcw_front_completion_box_pending', array($this, 'disable_button_setting'), 10, 1);

		add_filter( 'grassblade_advance_completion_data', array($this, 'set_unit_quiz_completion_data'), 10, 2 );

		add_filter( 'grassblade_post_completion_type', array($this, 'set_unit_quiz_completion_type'), 10, 2 );

		add_filter( 'grassblade_completion_tracking_enabled', array($this, 'set_unit_quiz_completion_tracking_enabled'), 10, 2 );

		add_filter( 'wpcw_quiz_pass_status_details', array($this, 'wpcw_quiz_change_quiz_pass_status_message'), 10, 3 );

		add_action( 'wp_ajax_wpcw_add_xapi_content', array($this,'wpcw_add_xapi_content' ));

		add_action( 'wp_ajax_wpcw_create_xapi_quiz', array($this,'wpcw_create_xapi_quiz' ));

		add_action( 'wp_ajax_wpcw_get_xapi_content_id', array($this,'wpcw_get_xapi_content_id' ));

		add_action('wpcw_user_completed_unit', array($this,'wpcw_unit_completed'), 1, 3);

		add_action('wpcw_user_completed_module', array($this,'wpcw_module_completed'), 1, 3);

		add_action('wpcw_user_completed_course', array($this,'wpcw_course_completed'), 1, 3);

		add_action('wpcw_enroll_user', array($this,'user_enrolled'), 1, 2);

		add_action('wpcw_unenroll_user', array($this,'user_unenrolled'), 1, 2);	

		add_action('grassblade_course_started', array($this, 'course_attempted_statement'), 10, 3);

		add_action('wpcw_unit_after_single_content', array($this, 'remove_the_unit_button_link_id'), 10 );

		add_filter("grassblade_lms_mark_complete_button_id",array($this,"get_mark_complete_btn_id"), 11, 2);
		add_filter("grassblade_lms_next_link",array($this,"get_next_link"), 11, 2);

		if( version_compare(GRASSBLADE_VERSION, '4.2.0', '>=') ) {
			add_filter("grassblade_get_courses", array($this, "get_courses"), 10, 2);

			add_filter("grassblade_get_course_content_ids", array($this, "add_course_content_ids"), 10, 2);

			add_filter("grassblade_get_course", array($this, "get_course"), 10, 2);

			add_filter("grassblade/reports/progress_snapshot/data", array($this, "get_progress_report_data"), 10, 2);
		}
	}
	function installation_notice() {
		?>
		<div class="error"><p>There are problems with <b>Experience API for WP Courseware</b> plugin dependencies. Please <a href="<?php echo admin_url("admin.php?page=grassblade-wp-courseware");?>">click here</a> to check for details.</p></div>
		<?php
	}
	/**
	 * Generate an activation URL for a plugin like the ones found in WordPress plugin administration screen.
	 *
	 * @param  string $plugin A plugin-folder/plugin-main-file.php path (e.g. "my-plugin/my-plugin.php")
	 *
	 * @return string         The plugin activation url
	 */
	function activate_plugin($plugin)
	{
		$activation_link = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . urlencode( $plugin ), 'activate-plugin_' . $plugin );

		$link = '<a href="#" onClick="return grassblade_wpcw_activate_plugin(\''.$activation_link.'\');">'.__("Activate").'</a>';
		return $link;
	}

	function gb_xapi_admin_menu() {
		if ( empty( $GLOBALS['admin_page_hooks']['grassblade-lrs-settings'] ) )
		{
		    add_menu_page("GrassBlade", "GrassBlade", "manage_options", "grassblade-wp-courseware", array($this, 'wp_courseware_menupage'), GRASSBLADE_WPCW_ICON, null);
		}
		else
	    add_submenu_page("grassblade-lrs-settings", "WP Courseware LMS", "WP Courseware LMS",'manage_options','grassblade-wp-courseware', array($this, 'wp_courseware_menupage') );
	}

	function menu() {

		global $submenu, $admin_page_hooks;
		$icon = plugin_dir_url(__FILE__)."img/icon-gb.png";

		if(empty( $admin_page_hooks[ "grassblade-lrs-settings" ] )) {
			add_menu_page("GrassBlade", "GrassBlade", "manage_options", "grassblade-lrs-settings", array($this, 'menu_page'), $icon, null);
		}

	    add_submenu_page("grassblade-lrs-settings", "WP Courseware LMS", "WP Courseware LMS",'manage_options','grassblade-wp-courseware', array($this, 'menu_page') );
	}
	function menu_page() {
		
	    if (!current_user_can('manage_options'))
	    {
	      wp_die( __('You do not have sufficient permissions to access this page.') );
	    }

		$grassblade_plugin_file_path = WP_PLUGIN_DIR . '/grassblade/grassblade.php';
		if(!defined("GRASSBLADE_VERSION") && file_exists($grassblade_plugin_file_path)) {
			$grassblade_plugin_data = get_plugin_data($grassblade_plugin_file_path);
			define('GRASSBLADE_VERSION', @$grassblade_plugin_data['Version']);
		}

		$wpcw_plugin_file_path = WP_PLUGIN_DIR . '/wp-courseware/wp-courseware.php';
		if(!defined("WPCW_VERSION") && file_exists($wpcw_plugin_file_path)) {
			$wpcw_plugin_data = get_plugin_data($wpcw_plugin_file_path);
			define('WPCW_VERSION', @$wpcw_plugin_data['Version']);
		}

	    if (!file_exists($grassblade_plugin_file_path) ) {
	    	$xapi_td = '<td><img src="'.plugin_dir_url(__FILE__).'img/no.png"/> '.(defined("GRASSBLADE_VERSION")? GRASSBLADE_VERSION:"").'</td>';
	    	$xapi_td .= '<td>
							<a class="buy-btn" href="https://www.nextsoftwaresolutions.com/grassblade-xapi-companion/">'.__("Buy Now", "grassblade-xapi-wp-courseware").'</a>
						</td>';
	    }
	    else if( version_compare(GRASSBLADE_VERSION, '2.0.4', '<' ) ) {
	    	$xapi_td = '<td colspan="2">
							<a class="buy-btn" href="https://www.nextsoftwaresolutions.com/grassblade-xapi-companion/">'.__("Get Latest Version", "grassblade-xapi-wp-courseware").'</a>
						</td>';   	
	    }
	    else {
	    	$xapi_td = '<td><img src="'.plugin_dir_url(__FILE__).'img/check.png"/> '.(defined("GRASSBLADE_VERSION")? GRASSBLADE_VERSION:"").'</td>';
	    	if ( !is_plugin_active('grassblade/grassblade.php') ) {
				$xapi_td .= '<td>'.$this->activate_plugin("grassblade/grassblade.php").'</td>';
			}else {
	    		$xapi_td .= '<td><img src="'.plugin_dir_url(__FILE__).'img/check.png"/></td>';
	    	}
	    }
	    
	    if (!file_exists( $wpcw_plugin_file_path ) ) {
	    	$wpcw_td = '<td><img src="'.plugin_dir_url(__FILE__).'img/no.png"/> '.(defined("WPCW_VERSION")? WPCW_VERSION:"").'</td>';
	    	$wpcw_td .= '<td colspan="2">
							<a class="buy-btn" href="'.$this->install_link.'">'.__("Buy Now", "grassblade-xapi-wp-courseware").'</a>
						</td>';
	    } 
	    else if( version_compare(WPCW_VERSION, '4.6.3', '<' ) ) {
	    	$wpcw_td = '<td><img src="'.plugin_dir_url(__FILE__).'img/check.png"/> '.(defined("WPCW_VERSION")? WPCW_VERSION:"").'</td>';
	    	$wpcw_td .= '<td>
							<a class="buy-btn" href="'.$this->install_link.'">'.__("Get Latest Version", "grassblade-xapi-wp-courseware").'</a>
						</td>';    	
	    }
	    else {
	    	$wpcw_td = '<td><img src="'.plugin_dir_url(__FILE__).'img/check.png"/> '.(defined("WPCW_VERSION")? WPCW_VERSION:"").'</td>';
	    	if ( !is_plugin_active('wp-courseware/wp-courseware.php') ) {
				$wpcw_td .= '<td>'.$this->activate_plugin("wp-courseware/wp-courseware.php").'</td>';
			} else {
	    		$wpcw_td .= '<td><img src="'.plugin_dir_url(__FILE__).'img/check.png"/></td>';
	    	}
	    }

	    if(function_exists("grassblade_settings")) {
			$grassblade_settings = grassblade_settings();	
			$endpoint = $grassblade_settings["endpoint"];
			if(!empty($endpoint)) {
				if(strpos($endpoint, "gblrs.com"))
					$lrs_html = '<img src="'.plugin_dir_url(__FILE__).'img/check.png"/>';
				else if(strpos($endpoint, "grassblade-lrs"))
					$lrs_html = "GrassBlade LRS Installed";
				else 
					$lrs_html = '<img src="'.plugin_dir_url(__FILE__).'img/no.png"/> Other LRS? <a class="buy-btn" href="https://www.nextsoftwaresolutions.com/grassblade-lrs-experience-api/">Buy GrassBlade Cloud LRS</a>';
			}
	    }
	    if(empty($lrs_html))
		$lrs_html = '<a class="buy-btn" href="https://www.nextsoftwaresolutions.com/grassblade-lrs-experience-api/">Buy GrassBlade Cloud LRS</a>';

		?>
	    <style>
	    	hr {
	    		max-width: 90%;
			    margin-left: 0px;
			    border-top: 1px solid #62A21D;
	    	}
			.text{
				font-weight: 400;
				font-size: 15px;
			}
			.requirements {
				font-weight: 500;
				font-size: 16px;
			}
			table {
				border-collapse: collapse;
				min-width: 40%;
				text-align: center;
			}
			thead {
				background-color: #83BA39;
			}
			table, td, th {
			  border: 1px solid #ddd;
			}
			td{
			 padding: 18px;
			}
			th {
			 padding: 8px;
			}
			.links {
				text-decoration: none;
				margin-top: 10px !important;
				color: #000000;
			}
			.buy-btn{
				margin: 10px 0px 5px 0px !important;
				text-transform: capitalize !important;
	    		border-top: 1px solid #e6c628 !important;
				background: -webkit-linear-gradient(top,#e6c628,#82ba39) !important;
				padding: 7.5px 15px !important;
				border-radius: 9px !important;
			    text-shadow: rgba(0,0,0,.4) 0 1px 0 !important;
			    color: white !important;
			    font-size: 14px !important;
			    font-weight: bold !important;
			    font-family: Arial,serif !important;
			    text-decoration: none !important;
			    vertical-align: middle !important;
			}
			#grassblade_wp_courseware {
				background: white;
			    margin: 20px;
			    padding: 20px 40px;
			}
			#grassblade_wp_courseware img {
				vertical-align: middle;
			}
		</style>
		<script type="text/javascript">
			function grassblade_wpcw_activate_plugin(url) {
				jQuery.get(url, function(data) {
					window.location.reload();
				});
				return false;
			}
		</script>
		<div id="grassblade_wp_courseware">
			<h2>
				<img style="margin-right: 10px;" src="<?php echo plugin_dir_url(__FILE__)."img/icon_30x30.png"; ?>"/>
				Experience API For WP Courseware
			</h2>
			<hr>
			<div>
				<p class="text">To use xAPI Content on your WP Courseware Unit and Quiz, you need to meet the following requirements. Then follow this one-time setup process.</p>
				<h2>Requirements:</h2>
				<table class="requirements-tbl">
					<thead>
						<tr>
							<th>SNo</th>
							<th>Requirements</th>
							<th>Installed</th>
							<th>Active</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1. </td>
							<td><a class="links" href="https://www.nextsoftwaresolutions.com/grassblade-xapi-companion/">GrassBlade xAPI Companion v2.0.4+</a></td>
							<?php echo $xapi_td; ?>
						</tr>
						<tr>
							<td>2. </td>
							<td><a class="links" href="<?php echo $this->install_link; ?>">WP Courseware LMS v4.6.3+</a></td>
							<?php echo $wpcw_td; ?>
						</tr>
						<tr>
							<td>3. </td>
							<td><a class="links" href="https://www.nextsoftwaresolutions.com/grassblade-lrs-experience-api/">GrassBlade Cloud LRS</a></td>
							<td colspan="2">
								<?php echo $lrs_html; ?>
							</td>
						</tr>
					</tbody>
				</table>
				<br>
				<h2>Useful Links:</h2>
				<ul>
					<li><a class="links" href="https://www.nextsoftwaresolutions.com/kbtopic/wp-courseware/" target="_blank">Getting started with Experience API Integration for WP Courseware.</a></li>
				</ul>
			</div>	
		</div>
	<?php }

	/**
	 * Unit Mark as Complete.
	 *
	 * @param int $unit_id The unit id.
	 * @param int $user_id The user id.
	 *
	 * @return bool True upon succesfull completion, false otherwise.
	 */
	function wpcw_unit_mark_as_complete( $unit_id, $user_id ) {
	    // Get Unit Parent Data.
	    $unit_parent_data = WPCW_units_getAssociatedParentData( $unit_id );
	    // Check to see if it's associated.
	    if ( is_null( $unit_parent_data ) || empty( $unit_parent_data ) ) {
	        return false;
	    }
	    // Save User Progress.
	    WPCW_units_saveUserProgress_Complete( $user_id, $unit_id, 'complete' );
	    /**
	     * Action: WPCW User Completed Unit.
	     *
	     * @param int    $user_id The user id.
	     * @param int    $unit_id The unit id.
	     * @param object $unit_parent_data The unit parent data.
	     */
	    do_action( 'wpcw_user_completed_unit', $user_id, $unit_id, $unit_parent_data );
	} //end of wpcw_unit_mark_as_complete

	/**
	 * Insert Quiz Result.
	 *
	 * @param array $args.
	 * @param int $course_id.
	 *
	 */
	function insert_quiz_result($args, $course_id){

		global $wpcwdb, $wpdb;
		$user_id = $args['user_id'];
		$unit_id = $args['unit_id'];
		$SQL = arrayToSQLInsert( $wpcwdb->user_progress_quiz, $args );
		$wpdb->query( $SQL );
	}

	/**
	 * Unit & Quiz Mark as Complete.
	 *
	 * @param array $args.
	 * @param int $course_id.
	 *
	 */
	function mark_unit_and_quiz_complete($args, $course_id){

		$user_id = $args['user_id'];
		$unit_id = $args['unit_id'];
		
		// Save User Progress.
		WPCW_units_saveUserProgress_Complete( $user_id, $unit_id );

		// Update User Course Progress.
		wpcw_update_student_progress( $user_id, $course_id );

		// Get Unit Parent Data.
	    $unit_parent_data = WPCW_units_getAssociatedParentData( $unit_id );

		/**
	     * Action: WPCW User Completed Unit.
	     *
	     * @param int    $user_id The user id.
	     * @param int    $unit_id The unit id.
	     * @param object $unit_parent_data The unit parent data.
	     */
	    do_action( 'wpcw_user_completed_unit', $user_id, $unit_id, $unit_parent_data );
	} //end of mark_unit_and_quiz_complete

	/**
	 * Grassblade Post Content Completion.
	 *
	 * @param mixed $post_completion Post Completion Data.
	 * @param int $post_id The unit id.
	 * @param int $user_id The user id.
	 *
	 * @return mixed post_completion upon succesful completion, false otherwise.
	 */
	/*
	function is_unit_quiz_content_completed( $post_completion, $post_id, $user_id ) {

		if(empty($post_id)) 
			return $post_completion;

		$post = get_post($post_id);

		if ($post->post_type != 'course_unit')
			return $post_completion;

		 
			return $post_completion;

		$args = array(
				    'post_type'              => array( 'gb_xapi_content' ),
				    'post_status'            => array( 'publish' ),
				    'meta_query'             => array(
				        array(
				            'key'       => 'wpcw_quiz',
				            'value'     => $quizzes[0]->get_id(),
				        ),
				    ),
				);

		$xapi_contents = get_posts($args);

		if (empty($xapi_contents[0]->ID))
			return $post_completion;

		$completed = get_user_meta($user_id, "completed_".$xapi_contents[0]->ID, true);

		if (empty($completed)) {
			return false;
		} else {
			return true;
		}
	}
	*/
	/**
	 *
	 * Hide Mark Complete Button And Native Quiz.
	 *
	 */
	function wpcw_hide_mark_complete_button_and_quiz(){
		global $post;
		if(empty($post->ID)) return;

		if ($post->post_type == 'course_unit') {
			$completed = grassblade_xapi_content::post_contents_completed($post->ID);

			if(empty($completed))
				$hide_mark_complete = true;
			else
			{
				$unit = wpcw_get_unit($post->ID);
				$quizzes = $unit->get_quizzes();



				if ($quizzes) {

					$args = array (
					    'post_type'              => array( 'gb_xapi_content' ),
					    'post_status'            => array( 'publish' ),
					    'meta_query'             => array(
					        array(
					            'key'       => 'wpcw_quiz',
					            'value'     => $quizzes[0]->get_id(),
					        ),
					    ),
					);

					$xapi_contents = get_posts($args);
					if(!empty($xapi_contents[0])) {
						$xapi_content_id = $xapi_contents[0]->ID;
						$tracking_status = grassblade_xapi_content::is_completion_tracking_enabled($xapi_content_id);
						if ($tracking_status) {
							$hide_mark_complete = true;
							$quiz_div_id = "wpcw_fe_quiz_complete_".$post->ID."_".$quizzes[0]->get_id();
							?>
							<style type="text/css">
								div[id^="<?php echo $quiz_div_id ?>"] {
								    display: none;
								}
							</style>
							<?php
						}
					}
				}
			}
			$completion_type = grassblade_xapi_content::post_completion_type($post->ID);
			$div_id = "wpcw_fe_unit_complete_".$post->ID;
			if(!empty($hide_mark_complete) && $completion_type == 'hide_button') {	//InComplete xAPI Content's, or No xAPI Content with Completion Tracking enabled.
				?>
				<style type="text/css">
					div[id^="<?php echo $div_id ?>"] {
					    display: none;
					}
				</style>
				<?php
			}
		}
	}

	/**
	 *
	 * Disable Mark Complete Button Setting.
	 *
	 * @param string $completionBox.
	 *
	 * @return string $completionBox.
	 */
	function disable_button_setting($completionBox) {
		global $post;

		//$html = htmlentities($completionBox);
		//var_dump($html); exit;

		if ( !empty($post->ID)  && $post->post_type == 'course_unit' ) {

			$completion_type = grassblade_xapi_content::post_completion_type($post->ID);

			$unit = wpcw_get_unit($post->ID);
			$quizzes = $unit->get_quizzes();

			$button_text = 'Mark as Complete';

			$user_id = get_current_user_id();
			$completed = grassblade_xapi_content::post_contents_completed($post->ID,$user_id);

			if( in_array($completion_type, array("hide_button", "hidden_until_complete", "completion_move_nextlevel")))
			$add_style = 'style="display:none"';
			else if($completion_type == "disable_until_complete")
			$add_style = 'disabled="disabled"';
			
			if (!empty($quizzes) && $xapi_content_id = $this->is_quiz_has_content($quizzes) ) {
				if (empty($completed)) {
					$completionBox = '<div class="wpcw_fe_progress_box_wrap" id="wpcw_fe_unit_complete_'.$post->ID.'" '.$add_style.'> <div class="wpcw_fe_progress_box wpcw_fe_progress_box_pending"> <div class="wpcw_fe_progress_box_text">Have you completed this unit? Then take Quiz of this unit.</div> <div class="wpcw_fe_progress_box_mark"> <button onclick="window.location.reload(true);" id="take_quiz_'.$post->ID.'" style="float:right; color:#fff; background-color: #7fbf4d;border: 1px solid #63a62f;text-decoration: underline;border-radius: 3px;padding: 8px 10px;text-align: center;font-weight: 700;font-size: 1em;line-height: 1em;">Take Quiz</button> </div> </div> </div>';
					$button_text = 'Take Quiz';
				} else {
					$quiz_id = $quizzes[0]->get_id();
					
					if (strpos($completionBox, 'class="wpcw_fe_quiz_retake"') !== false) { // Add refresh to re-take quiz button. 
						$completionBox = str_replace('href="#"','onclick="setTimeout( window.location.reload(true), 1000);"',$completionBox);
					} else if (!(strpos($completionBox, 'You have now completed this unit.') !== false)) {
						$quiz_completed =  get_user_meta($user_id, "completed_".$xapi_content_id, true);
						if( empty($quiz_completed) )						
						$completionBox .= '<div class="wpcw_fe_progress_box_wrap" id="wpcw_fe_unit_complete_'.$post->ID.'" '.$add_style.'> <div class="wpcw_fe_progress_box wpcw_fe_progress_box_pending wpcw_fe_progress_box_updating"> <div class="wpcw_fe_progress_box_text">Have you completed this unit? Then mark this unit as completed.</div> <div class="wpcw_fe_progress_box_mark"> <img src="'. esc_url( plugins_url( 'img/ajax_loader.gif', __FILE__) ).'" class="wpcw_loader" style="display: none;" /> <button onclick="window.location.reload(true);" style="float:right; color:#fff; background-color: #7fbf4d;border: 1px solid #63a62f;text-decoration: underline;border-radius: 3px;padding: 8px 10px;text-align: center;font-weight: 700;font-size: 1em;line-height: 1em;" id="unit_complete_'.$post->ID.'">Mark as Completed</button> </div> </div> </div>';
					}
				}
			} 

			if( empty($completed) )
			$completionBox = str_replace(array('id="wpcw_fe_unit_complete_'.$post->ID.'"', "id='wpcw_fe_unit_complete_".$post->ID."'"), 'id="wpcw_fe_unit_complete_'.$post->ID.'" '.$add_style, $completionBox);

			if( $completion_type == "disable_until_complete" ) {
				$el = array(
					"tag" => "div", 
					"attr" => "class",
					"attr_value" => "wpcw_fe_progress_box_mark"
				);
				$fake_button = '<button id="gb_wpcw_mark_complete" style="float: right;background-color: #ccc;border: 1px solid #888;text-decoration: underline;border-radius: 3px;padding: 8px 10px;text-align: center;font-weight: 700;font-size: 1em;line-height: 1em;">'.$button_text.'</button>';

				$completionBox = $this->add_before_element($completionBox, $el, $fake_button);

			}
		}
		$completionBox .= '<style type="text/css">div.wpcw_fe_progress_box_wrap[disabled="disabled"] #gb_wpcw_mark_complete {display: block;}div.wpcw_fe_progress_box_wrap #gb_wpcw_mark_complete {display: none;}div.wpcw_fe_progress_box_wrap[disabled="disabled"] .wpcw_fe_progress_box_mark {display: none;}div.wpcw_fe_progress_box_wrap .wpcw_fe_progress_box_mark {display: block;}div.wpcw_fe_progress_box_wrap[disabled="disabled"] .wpcw_fe_progress_box_pending {background: #ddd;border-color: #888;}</style>';

		return $completionBox;
	}

	function is_quiz_has_content($quizzes) {
		if(empty($quizzes) || empty($quizzes[0]))
		return false;

		$args = array(
				    'post_type'              => array( 'gb_xapi_content' ),
				    'post_status'            => array( 'publish' ),
				    'meta_query'             => array(
				        array(
				            'key'       => 'wpcw_quiz',
				            'value'     => $quizzes[0]->get_id(),
				        ),
				    ),
				);

		$xapi_contents = get_posts($args);

		if (!empty($xapi_contents[0]->ID)) {
			$tracking_status = grassblade_xapi_content::is_completion_tracking_enabled( $xapi_contents[0]->ID );
			return $tracking_status? $xapi_contents[0]->ID:false;
		}
		else
			return false;
	}

	function set_unit_quiz_completion_data($return, $post){

		if(empty($post->ID)) 
			return $return;

		if ($post->post_type == 'course_unit' ) {
			$unit = wpcw_get_unit($post->ID);
			$quizzes = $unit->get_quizzes();

			if (!empty($quizzes) &&  !empty($this->is_quiz_has_content($quizzes)) ){
				return true;
			}
		}
		return $return;
	}

	function set_unit_quiz_completion_type($completion_type, $post_id){

		if(empty($post_id)) 
			return $completion_type;

		$post = get_post($post_id);

		if ($post->post_type == 'course_unit' ) {
			$unit = wpcw_get_unit($post->ID);
			$quizzes = $unit->get_quizzes();

			$user_id = get_current_user_id();
			$completed = grassblade_xapi_content::post_contents_completed($post->ID,$user_id);

			if (!empty($quizzes) && !empty($completed) &&  $xapi_content_id = $this->is_quiz_has_content($quizzes) ) {
				return grassblade_xapi_content::get_completion_type( $xapi_content_id );
			}
		}
		return $completion_type;
	}

	function set_unit_quiz_completion_tracking_enabled($completion_tracking_enabled,$post_id){
		if(empty($post_id)) 
			return $completion_tracking_enabled;

		$post = get_post($post_id);

		if ($post->post_type == 'course_unit' ) {
			$unit = wpcw_get_unit($post->ID);
			$quizzes = $unit->get_quizzes();

			$user_id = get_current_user_id();
			$completed = grassblade_xapi_content::post_contents_completed($post->ID,$user_id);

			if (!empty($quizzes) && !empty($completed) &&  $xapi_content_id = $this->is_quiz_has_content($quizzes) ) {
				return grassblade_xapi_content::is_completion_tracking_enabled_by_post(  $xapi_content_id );
			}
		}
		return $completion_tracking_enabled;
	}

	/**
	 * Add Quiz xAPI content on Unit Post.
	 *
	 * @param string $content.
	 *
	 * @return string $content.
	 */
	function wpcw_add_quiz_unit_post($content) {
		global $post;
		if(empty($post->ID)) 
			return $content;

		if ($post->post_type == 'course_unit' ) {
			$unit = wpcw_get_unit($post->ID);
			$quizzes = $unit->get_quizzes();

			if ($quizzes) {

				$user_id = get_current_user_id();
				$completed = grassblade_xapi_content::post_contents_completed($post->ID,$user_id);

				if (empty($completed)) {

					//$view_quiz_msg = '<div class="wpcw_fe_progress_box wpcw_fe_progress_box_warning" >'.sprintf(__('You do not have access to the quiz. Please complete the content on this page and %s to view the quiz.', "grassblade-xapi-wp-courseware"), '<a href="javascript:window.location.reload()">'.__('click here', "grassblade-xapi-wp-courseware").'</a>').'</div>';
					//$content .= $view_quiz_msg;

					//$div_id = "wpcw_fe_unit_complete_".$post->ID;
					//$content .= '<style type="text/css"> div[id^="'.$div_id.'"] {display: none; } </style>';

					$quiz_div_id = "wpcw_fe_quiz_complete_".$post->ID."_".$quizzes[0]->get_id();
					$content .= '<style type="text/css"> div[id^="'.$quiz_div_id.'"] {display: none; } </style>';

				} else {
					$args = array(
					    'post_type'              => array( 'gb_xapi_content' ),
					    'post_status'            => array( 'publish' ),
					    'meta_query'             => array(
					        array(
					            'key'       => 'wpcw_quiz',
					            'value'     => $quizzes[0]->get_id(),
					        ),
					    ),
					);

					$xapi_contents = get_posts($args);
					if (!empty($xapi_contents[0]->ID)) {

						add_filter( 'wpcw_unit_quiz_allow_quiz_progress_without_questions', '__return_true');

						$obj_unitfrontend = new WPCW_UnitFrontend($post);

						$remainingAttempts = (int)$obj_unitfrontend->fetch_quizzes_getRemainingAttempts();
						$retake_allowed = $obj_unitfrontend->check_quizzes_areWeWaitingForUserToRetakeQuiz();
						$is_quiz_completed = $obj_unitfrontend->check_quizzes_hasUserCompletedQuiz();

						$is_show_quiz_content = $this->is_show_quiz_content($remainingAttempts,$retake_allowed,$is_quiz_completed);

						if ($is_show_quiz_content) {
							$content .= do_shortcode('[grassblade id='.$xapi_contents[0]->ID."]");
						} else {
							$content .= '<div><h3><strong>'.$xapi_contents[0]->post_title.'</strong></h3></div>';

							add_filter("grassblade_shortcode_return", array($this, "remove_content"), 8, 1);
							
							$content .= do_shortcode('[grassblade id='.$xapi_contents[0]->ID."]");

							remove_filter("grassblade_shortcode_return", array($this, "remove_content"), 8, 1);
						}
						$content .= '<style type="text/css">.wpcw_fe_quiz_box_full_answers {display: none;}.wpcw_fe_progress_download {display: none;}</style>';
					} // end of if
				} // end of else
			} // end of if			
		}  // end of if	

		return $content;
	} //end of wpcw_add_quiz_unit_post function

	function remove_content($r) {
		return "";
	}

	function is_show_quiz_content($remainingAttempts,$retake_allowed,$is_quiz_completed){

		if ( !$is_quiz_completed || $retake_allowed ) {
			return true;
		}
		if (!$retake_allowed && $is_quiz_completed || $remainingAttempts == 0 ) {
			return false;
		}
	}

	/**
	 * Content Completion.
	 *
	 *
	 * @param obj $statement.
	 * @param int|string $content_id xAPI Content ID.
	 * @param obj $user User Object.
	 *
	 */
	function wpcw_content_completed($statement, $content_id, $user) {

		grassblade_show_trigger_debug_messages( "wpcw_content_completed");

		$user_id = $user->ID;
		$xapi_content = get_post_meta($content_id, "xapi_content", true);

		if(empty($xapi_content["completion_tracking"])) {
			grassblade_show_trigger_debug_messages( "\nCompletion tracking not enabled. " );
			return true;
		}
		
		global $wpdb;

		$meta_post_ids = $wpdb->get_col( $wpdb->prepare("select post_id from $wpdb->postmeta where meta_key = 'show_xapi_content' AND meta_value = '%d'", $content_id) );
	    
	    $block_post_ids = $wpdb->get_col($wpdb->prepare("select post_id from $wpdb->postmeta where meta_key = 'show_xapi_content_blocks' AND meta_value = '%d' ORDER BY meta_id ASC ", $content_id ));

		$post_ids = array_merge($block_post_ids,$meta_post_ids);

		if (!empty($post_ids)) {
			foreach ($post_ids as $post_id) {

				$post_data = get_post($post_id);

				if ($post_data->post_type != 'course_unit') {
					continue;
				}

				$completed = grassblade_xapi_content::post_contents_completed($post_id, $user->ID);

				if(empty($completed)) {
					grassblade_show_trigger_debug_messages( "All Content is not completed user: ".$user->ID. " course_unit: " . $post_id );
					continue;

				} else {

					$unit = wpcw_get_unit($post_id);
					$quizzes = $unit->get_quizzes();

					if (empty($quizzes)) {

						$this->wpcw_unit_mark_as_complete($post_id, $user_id);
	
						$course_id = $unit->get_parent_course_id();
						$user_progress = new WPCW_UserProgress( $course_id, $user_id );
						$is_unit_completed = $user_progress->isUnitCompleted($unit->unit_id);

						grassblade_show_trigger_debug_messages( "wpcw_unit_mark_as_complete user_id: ".$user_id." course_unit: ".$post_id. " status: ".$is_unit_completed );
					}
				} // end of completed is not empty
			} // end of foreach
		} // end of if
			
		$quiz_ids = get_post_meta($content_id, 'wpcw_quiz', false );

		if (!empty($quiz_ids)) {

			$statement = json_decode($statement);
			foreach ($quiz_ids as $quiz_id) {

				$quiz_completion = true;
				$quiz = wpcw_get_quiz($quiz_id);
				$unit_id = $quiz->get_parent_unit_id();
				$course_id = $quiz->get_parent_course_id();

				if ($unit_id != 0) {

					$quiz_attempt_id = $this->get_quiz_attempt_id($user->ID,$unit_id,$quiz_id);

					$args = array(  'user_id' => $user->ID,
									'unit_id' => $unit_id,
									'quiz_id' => $quiz_id,
									'quiz_needs_marking' => 0,
									'quiz_attempt_id' => $quiz_attempt_id,
									'quiz_completed_date' => date('Y-m-d H:i:s',strtotime($statement->stored)),
									'quiz_grade' => isset($statement->result->score->raw)? $statement->result->score->raw:(!empty($statement->result->score->scaled)? $statement->result->score->scaled*100:0)
								 );

					$this->insert_quiz_result($args,$course_id);

					add_filter( 'wpcw_unit_quiz_allow_quiz_progress_without_questions', '__return_true');

					wp_set_current_user($user_id);
					$unit = get_post($unit_id); 
					$obj_unitfrontend = new WPCW_UnitFrontend($unit);

					$is_quiz_passed = $obj_unitfrontend->check_quizzes_hasUserPassedQuiz();

					$quiz_type = $quiz->get_quiz_type();

					if (!$is_quiz_passed && $quiz_type == 'quiz_block') {
						$quiz_completion = false;
					}

					if($quiz_completion){
						$this->mark_unit_and_quiz_complete($args,$course_id);
						$is_quiz_passed = $obj_unitfrontend->check_quizzes_hasUserPassedQuiz();
						grassblade_show_trigger_debug_messages( "mark_unit_and_quiz_complete user_id: ".$user_id." course_unit: ".$unit_id. " quiz_id: ".$quiz_id." status: ".$is_quiz_passed );

					}
				}
			}// end of foreach
			
		} // end of if 
	} //end of wpcw_content_completed function

	function set_show_hide_button_status($status,$post_id,$content_id,$user){
		if(empty($post_id)) 
			return $status;

		$post = get_post($post_id);

		if ($post->post_type == 'course_unit' ) {
			$unit = wpcw_get_unit($post->ID);
			$quizzes = $unit->get_quizzes();

			$completed = grassblade_xapi_content::post_contents_completed($post->ID,$user->ID);

			if (!empty($quizzes)  && !empty($completed) && !empty($content_id) && ($this->is_quiz_has_content($quizzes) == $content_id) ) {

				$quiz = wpcw_get_quiz($quizzes[0]->get_id());

				add_filter( 'wpcw_unit_quiz_allow_quiz_progress_without_questions', '__return_true');

				$obj_unitfrontend = new WPCW_UnitFrontend($post);

				$is_quiz_passed = $obj_unitfrontend->check_quizzes_hasUserPassedQuiz();

				if ($is_quiz_passed) {
					return true;
				}

				$quiz_type = $quiz->get_quiz_type();

				if (!$is_quiz_passed && $quiz_type == 'quiz_block') {
					return false;
				} else {
					return true;
				}
			}
		}
		return $status;
	}

	/**
	 * Get Quiz Attempted ID.
	 *
	 * @param int $user_id.
	 * @param int $unit_id.
	 * @param int $quiz_id.
	 *
	 * @return int quiz_attempt_id.
	 */
	function get_quiz_attempt_id($user_id,$unit_id,$quiz_id) {
		global $wpdb, $wpcwdb;

		$quiz_attempt_id = 0;

		$SQL = $wpdb->prepare( "
					SELECT * 
					FROM $wpcwdb->user_progress_quiz
					WHERE user_id = %d
					  AND unit_id = %d
					  AND quiz_id = %d
					ORDER BY quiz_attempt_id DESC 
					LIMIT 1
				", $user_id, $unit_id, $quiz_id );

		// if exists, so increment the quiz_attempt_id
		if ( $existingProgress = $wpdb->get_row( $SQL ) ) {
			// we got an existing complete quiz progress , so we need to update it as null instead of latest.
			$SQL = $wpdb->prepare( "
					UPDATE $wpcwdb->user_progress_quiz
					SET quiz_is_latest = ''
					WHERE user_id = %d
					  AND unit_id = %d
					  AND quiz_id = %d
				", $user_id, $unit_id, $quiz_id );
			$wpdb->query( $SQL );

			$quiz_attempt_id = $existingProgress->quiz_attempt_id + 1;
		} 
		return $quiz_attempt_id;
	}

	/**
	 * Quiz - Change Pass Status Message.
	 *
	 * @param array $status_details The quiz pass status details.
	 * @param object $quiz_progress The quiz progress object.
	 * @param object $quiz_details The quiz details object.
	 *
	 * @return array $status_details The quiz pass status details.
	 */
	function wpcw_quiz_change_quiz_pass_status_message( $status_details, $quiz_progress, $quiz_details ) {

	    if ( empty($quiz_progress->quiz_data) ) {
	        $status_details[0]['msg_overall_grade'] = sprintf(
	            __( 'Your grade for this quiz is <strong>%s%%</strong>.', 'grassblade-xapi-wp-courseware' ), $quiz_progress->quiz_grade
	        );
	    } else {
	        $status_details[0]['msg_overall_grade'] = sprintf(
	            __( 'You got %1$d out of %2$d questions <strong>(%3$s%%)</strong> correct!', 'grassblade-xapi-wp-courseware' ),
	            $quiz_progress->quiz_correct_questions,
	            $quiz_progress->quiz_question_total,
	            $quiz_progress->quiz_grade
	        );
	    }

	    return $status_details;
	}

	function remove_the_unit_button_link_id() {

		if(get_post_type() != "course_unit")
			return;

		$unit = get_post();
		$completed = grassblade_xapi_content::post_contents_completed($unit->ID);
		if(empty($completed)) {
		?>
			<script>
				if( jQuery("a.fe_btn_completion").length > 0 ) {
					var gb_change_id = jQuery("a.fe_btn_completion").attr("id");
					jQuery("a.fe_btn_completion").attr("id", gb_change_id.replace("unit_","unit_xapi_") + "_gb_disabled");
					jQuery("a.fe_btn_completion").on("click", function( event ) {
						event.preventDefault();
						window.location.reload();
					});
				}
			</script>
		<?php 
		}
	}

	function course_attempted_statement($user_id,$course_id,$data) {
		grassblade_debug('grassblade_wpcourseware_course_attempted');
		
		$grassblade_settings = grassblade_settings();
		$grassblade_tincan_endpoint = $grassblade_settings["endpoint"];
		$grassblade_tincan_user = $grassblade_settings["user"];
		$grassblade_tincan_password = $grassblade_settings["password"];
		$grassblade_tincan_track_guest = $grassblade_settings["track_guest"];

		$user = get_userdata( $user_id );

		$xapi = new NSS_XAPI($grassblade_tincan_endpoint, $grassblade_tincan_user, $grassblade_tincan_password);
		$actor = grassblade_getactor($grassblade_tincan_track_guest, "1.0", $user);

		if(empty($actor)){
			grassblade_debug("No Actor. Shutting Down.");
			return;
		}

		$course_post = get_post($course_id);
		$course_title = $course_post->post_title;
		$course_url = grassblade_post_activityid($course_id);
		//Course Attempted
		$xapi->set_verb('attempted');
		$xapi->set_actor_by_object($actor); 
		$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_object($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$statement = $xapi->build_statement();

		//grassblade_debug($statement);
		$xapi->new_statement(); 
		foreach($xapi->statements as $statement){
			$ret = $xapi->SendStatements(array($statement));
		}       
	}  // end of course_attempted_statement

	/**
	 * Send Unit Completion Statement.
	 *
	 * @param int $user_id.
	 * @param int $unit_id.
	 * @param Obj $unit_parent_data.
	 *
	 */
	function wpcw_unit_completed($user_id, $unit_id, $unit_parent_data) {
		grassblade_debug('grassblade_wpcw_unit_completed');
		
		$grassblade_settings = grassblade_settings();

	    $grassblade_tincan_endpoint = $grassblade_settings["endpoint"];
	    $grassblade_tincan_user = $grassblade_settings["user"];
	    $grassblade_tincan_password = $grassblade_settings["password"];
		$grassblade_tincan_track_guest = $grassblade_settings["track_guest"];

		$user = get_userdata( $user_id );

		$xapi = new NSS_XAPI($grassblade_tincan_endpoint, $grassblade_tincan_user, $grassblade_tincan_password);
		$actor = grassblade_getactor($grassblade_tincan_track_guest, "1.0", $user);

		if(empty($actor))
		{
			grassblade_debug("No Actor. Shutting Down.");
			return;
		}

		$unit = wpcw_get_unit($unit_id);

		$course_title = $unit_parent_data->course_title;
		$course_url = grassblade_post_activityid($unit_parent_data->course_post_id);
		$module_title = $unit_parent_data->module_title;
		//$module_url = grassblade_post_activityid($unit_parent_data->module_id);
		$unit_title = $unit->get_unit_title();
		$unit_url = grassblade_post_activityid($unit_parent_data->unit_id);

		$students = wpcw_get_student($user_id);
		$student_courses = wpcw()->students->get_student_courses($user_id);

		if ( $student_courses ) {
			foreach ( $student_courses as $course ) {
				if ( absint( $unit_parent_data->parent_course_id ) === absint( $course->course_id ) ) {
					$student_progress = $course->course_progress;
					$course_unit_count = $course->course_unit_count;
				}
			}
		}

		$data = array("timestamp" => time(), "post_id" => $unit_id);
		grassblade_lms::grassblade_course_started($user_id, $unit_parent_data->course_post_id, $data);

		$course = new WPCW\Models\Course($unit_parent_data->parent_course_id);
		$coures_units = $course->get_units();

		$unit_completion_count = 0;

		if ( $coures_units ) {
			$user_progress = new WPCW_UserProgress($unit_parent_data->parent_course_id, $user_id);
			foreach ( $coures_units as $unit ) {
				if ( absint( $unit_parent_data->parent_module_id ) === absint( $unit->parent_module_id ) ) {
					$is_unit_completed = $user_progress->isUnitCompleted($unit->unit_id);
					if ($is_unit_completed) {
						$unit_completion_count++;
					} 
				}
			}
		}

		if(!empty($unit_parent_data->module_id) && ($unit_completion_count <= 1)) {
	
			//Module Attempted
			$xapi->set_verb('attempted');
			$xapi->set_actor_by_object($actor);	
			$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
			$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
			$xapi->set_object($course_url, $module_title, $module_title, 'http://adlnet.gov/expapi/activities/module','Activity');
			$statement = $xapi->build_statement();
			//grassblade_debug($statement);
			$xapi->new_statement();
				
		} // end of if
		
		//Unit Attempted
		$xapi->set_verb('attempted');
		$xapi->set_actor_by_object($actor);	
		$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_object($unit_url, $unit_title, $unit_title, 'http://adlnet.gov/expapi/activities/unit','Activity');
		$statement = $xapi->build_statement();
		//grassblade_debug($statement);
		$xapi->new_statement();
		
		//Unit Completed
		$xapi->set_verb('completed');
		$xapi->set_actor_by_object($actor);	
		$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_object($unit_url, $unit_title, $unit_title, 'http://adlnet.gov/expapi/activities/unit','Activity');
		$result = array(
					'completion' => true
					);	
		$xapi->set_result_by_object($result);

		$statement = $xapi->build_statement();
		//grassblade_debug($statement);
		$xapi->new_statement();
		
		foreach($xapi->statements as $statement)
		{
			$ret = $xapi->SendStatements(array($statement));
		}
	}

	/**
	 * Send Module Completion Statement.
	 *
	 * @param int $user_id.
	 * @param int $unit_id.
	 * @param Obj $unit_parent_data.
	 *
	 */
	function wpcw_module_completed($user_id, $unit_id, $unit_parent_data) {
		grassblade_debug('grassblade_wpcw_module_completed');
		
		$grassblade_settings = grassblade_settings();

	    $grassblade_tincan_endpoint = $grassblade_settings["endpoint"];
	    $grassblade_tincan_user = $grassblade_settings["user"];
	    $grassblade_tincan_password = $grassblade_settings["password"];
		$grassblade_tincan_track_guest = $grassblade_settings["track_guest"];

		$user = get_userdata( $user_id );

		$xapi = new NSS_XAPI($grassblade_tincan_endpoint, $grassblade_tincan_user, $grassblade_tincan_password);
		$actor = grassblade_getactor($grassblade_tincan_track_guest, "1.0", $user);

		if(empty($actor))
		{
			grassblade_debug("No Actor. Shutting Down.");
			return;
		}
		
		$course_title = $unit_parent_data->course_title;
		$course_url = grassblade_post_activityid($unit_parent_data->course_post_id);
		$module_title = $unit_parent_data->module_title;
		//$module_url = grassblade_post_activityid($unit_parent_data->unit_id);
		
		//Module Completed
		$xapi->set_verb('completed');
		$xapi->set_actor_by_object($actor);	
		$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_object($course_url, $module_title, $module_title, 'http://adlnet.gov/expapi/activities/module','Activity');
		$result = array(
					'completion' => true
					);	

		$xapi->set_result_by_object($result);

		$statement = $xapi->build_statement();
		//grassblade_debug($statement);
		$xapi->new_statement();
		
		foreach($xapi->statements as $statement)
		{
			$ret = $xapi->SendStatements(array($statement));
		}	
	}

	/**
	 * Send Course Completion Statement.
	 *
	 * @param int $user_id.
	 * @param int $unit_id.
	 * @param Obj $unit_parent_data.
	 *
	 */
	function wpcw_course_completed($user_id, $unit_id, $unit_parent_data) {
		grassblade_debug('grassblade_wpcw_course_completed');
		
		$grassblade_settings = grassblade_settings();

	    $grassblade_tincan_endpoint = $grassblade_settings["endpoint"];
	    $grassblade_tincan_user = $grassblade_settings["user"];
	    $grassblade_tincan_password = $grassblade_settings["password"];
		$grassblade_tincan_track_guest = $grassblade_settings["track_guest"];

		$user = get_userdata( $user_id );

		$xapi = new NSS_XAPI($grassblade_tincan_endpoint, $grassblade_tincan_user, $grassblade_tincan_password);
		$actor = grassblade_getactor($grassblade_tincan_track_guest, "1.0", $user);

		if(empty($actor))
		{
			grassblade_debug("No Actor. Shutting Down.");
			return;
		}

		$course_title = $unit_parent_data->course_title;
		$course_url = grassblade_post_activityid($unit_parent_data->course_post_id);	
		//Course Completed
		$xapi->set_verb('completed');
		$xapi->set_actor_by_object($actor);	
		$xapi->set_parent($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_grouping($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$xapi->set_object($course_url, $course_title, $course_title, 'http://adlnet.gov/expapi/activities/course','Activity');
		$result = array(
					'completion' => true
					);	
		$xapi->set_result_by_object($result);	
		$statement = $xapi->build_statement();
		grassblade_debug($statement);
		$xapi->new_statement();	
		foreach($xapi->statements as $statement)
		{
			$ret = $xapi->SendStatements(array($statement));
		}		
	}  // end of wpcw_course_completed function

	/**
	 * Add xAPI content For Quiz.
	 *
	 */
	function wpcw_add_xapi_content() {
		$quiz_id = intVal($_POST['data']['quiz_id']);
		$xapi_content_id = intVal($_POST['data']['xapi_content_id']);

		$args = array(
		    'post_type'              => array( 'gb_xapi_content' ),
		    'post_status'            => array( 'publish' ),
		    'meta_query'             => array(
		        array(
		            'key'       => 'wpcw_quiz',
		            'value'     => $quiz_id,
		        ),
		    ),
		);

		$xapi_contents = get_posts($args);

		if(!empty($xapi_contents) && !empty($xapi_contents[0]) && !empty($xapi_contents[0]->ID) ) {
			$post_id = $xapi_contents[0]->ID;
			if($post_id == $xapi_content_id)
				return;

			delete_post_meta($post_id, 'wpcw_quiz', $quiz_id);
		}

		add_post_meta($xapi_content_id, 'wpcw_quiz', $quiz_id);
	} //end of wpcw_add_xapi_content function

	function wpcw_get_xapi_content_id() {
		$quiz_id = intVal($_POST['quiz_id']);

		$args = array(
		    'post_type'              => array( 'gb_xapi_content' ),
		    'post_status'            => array( 'publish' ),
		    'meta_query'             => array(
		        array(
		            'key'       => 'wpcw_quiz',
		            'value'     => $quiz_id,
		        ),
		    ),
		);

		$xapi_contents = get_posts($args);
		$return = array("xapi_content_id" => empty($xapi_contents[0])? 0:intVal($xapi_contents[0]->ID) );
		echo json_encode($return);
		die();
	} //end of wpcw_get_xapi_content_id function

	function wpcw_create_xapi_quiz(){
		$unit_id = intVal($_POST['data']["unit_id"]);
		$xapi_content_id = intVal($_POST['data']["xapi_content_id"]);

		$unit = wpcw_get_unit($unit_id);

		$xapi_post = get_post($xapi_content_id);

		$course_id = $unit->get_parent_course_id();
		$module_id = $unit->get_parent_module_id();
		$desc = '';
		$title = $xapi_post->post_title;

		$quiz_object = wpcw_insert_quiz( array(
							'parent_unit_id'   => absint( $unit_id ),
							'parent_course_id' => absint( $course_id ),
							'quiz_author'      => get_current_user_id(),
							'quiz_title'       => wp_kses_post( $title),
							'quiz_desc'        => wp_kses_post( $desc ),
						) );

		$quiz_id = $quiz_object->get_id();

		add_post_meta($xapi_content_id, 'wpcw_quiz', $quiz_id);

		$courses = new \WPCW\Controllers\Courses();

		$courses->invalidate_builder_cache( $course_id );
	} //end of wpcw_create_xapi_quiz function

	function custom_script_courseware() {
	  wp_enqueue_script( 'wp-courseware-script', plugin_dir_url( __FILE__ ) . '/script.js', array( 'jquery' ) , $this->version);
	  wp_localize_script( 'wp-courseware-script', 'wp_data', $this->gb_wpcw_data());
	} //end of custom_script_courseware function 

	function gb_wpcw_data(){
		global $wpdb;
		$post_content = array();
		$xapi_contents = $wpdb->get_results("SELECT ID, post_title, post_status FROM $wpdb->posts WHERE post_type = 'gb_xapi_content' AND post_status = 'publish' ORDER BY post_title ASC");
//		$xapi_contents = get_posts("post_type=gb_xapi_content&orderby=post_title&posts_per_page=-1");

		foreach ($xapi_contents as $xapi_content) { 

			$temp = array('content_id' => $xapi_content->ID,
						  'post_title' => $xapi_content->post_title
						 );

			array_push($post_content,$temp);

		} // end of for each 

		$arrayOfValues = array(
		    'admin_url'     => admin_url(),
		    'ajax_url' => admin_url( 'admin-ajax.php' ),
		    'post_content'  => $post_content
		);

		return $arrayOfValues;
	} // end of gb_wpcw_data

	function get_mark_complete_btn_id($return,$post){
		if(empty($post->ID))
			return $return;

		if(!in_array($post->post_type, array('course_unit'))){
			return $return;
		} else {
			return '#wpcw_fe_unit_complete_'.$post->ID;
		}
	}

	function get_next_link($return,$post){
		if(empty($post->ID))
			return $return;

		if(!in_array($post->post_type, array('course_unit'))){
			return $return;
		} else {
			$unit_id = $post->ID;
			$unit = wpcw_get_unit($unit_id);
			$course_id = $unit->get_parent_course_id();

			$user_id = get_current_user_id();

			// Get User Progress.
			$student_progress = new WPCW_UserProgress( $course_id, $user_id );

			// Get Next Unit.
			//$next_unit = $student_progress->getNextPendingUnit();
			$units = $student_progress->getNextAndPreviousUnit($unit_id);
			$next_unit = $units['next'];
			$next_unit_link = get_post_permalink($next_unit);

			return $next_unit_link;
		}
	}

	/**
	 * Course Enrollment.
	 *
	 *
	 * @param int $user_id.
	 * @param array $courses_enrolled Course_ids Array.
	 *
	 */
	function user_enrolled($user_id, $courses_enrolled){
		if (class_exists('grassblade_events_tracking')) { 
			foreach ($courses_enrolled as $key => $course_id) {
				$course_obj = new Course($course_id);
				grassblade_events_tracking::send_enrolled($user_id,$course_obj->course_post_id);
			}// end of foreach
		}// end of if grassblade_events_tracking class exists
	}

	/**
	 * Course Unenrollment.
	 *
	 *
	 * @param int $user_id.
	 * @param array $courseIDsToRemove Course_ids Array.
	 *
	 */
	function user_unenrolled($user_id, $courseIDsToRemove){
		if (!empty($user_id) && empty($courseIDsToRemove) && is_array($courseIDsToRemove) && class_exists('grassblade_events_tracking')) { 
			foreach ($courseIDsToRemove as $key => $course_id) {
				$course_obj = new Course($course_id);
				grassblade_events_tracking::send_unenrolled($user_id,$course_obj->course_post_id);
			}// end of foreach
		}// end of if grassblade_events_tracking class exists
	}

	/**
	 * User Profile Data.
	 *
	 * @param array $profile_data.
	 * @param int $user_id.
	 *
	 * @return array $profile_data Profile details.
	 */

	function user_profile($profile_data,$user_id) {

		$courses = array();
		$students = wpcw_get_student($user_id);
		$student_courses = wpcw()->students->get_student_courses($user_id);

		$completed = 0;
		foreach ($student_courses as $key => $course) {
			$course_obj = new Course($course->course_id);

			$courses[] = array( 'course_id'  => $course->course_post_id,
								'course_title'  => $course->course_title,
								'course_progress'  => $course->course_progress,
								'course_url' => get_permalink($course->course_post_id),
								'next_level'  => $course_obj->get_units()
							 );

			if ($course->course_progress == '100') {
				$completed++;
			}
		}

		$profile_data['courses'] = $courses;
		$profile_data['total_course'] = count($courses);
		$profile_data['total_completed'] = $completed;
		$profile_data['is_lms'] = true;

		return $profile_data;
	}

	function get_course($r, $course) {
		if(!empty($r))
			return $r;

		if(!empty($course) && is_numeric($course)) {
			$course = get_post($course);
		}

		if(!empty($course) && !empty($course->post_type) && $course->post_type == "wpcw_course")
			return $course;
		else
			return $r;
	}
	function get_courses($courses, $params) {

		if(isset($params["lms"]) && is_array($params["lms"]) && !in_array("wp-courseware", $params["lms"]))
			return $courses;

		if(empty($params["post_status"]))
			$params["post_status"] = "publish";

		$all_courses = get_posts("post_type=wpcw_course&post_status=".$params["post_status"]."&posts_per_page=-1");

		if(empty($all_courses))
			return $courses;

		foreach ($all_courses as $course) {
			if(isset($params["return"]) && $params["return"] == "object")
			$courses[$course->ID] = $course;
			else
			$courses[$course->ID] = $course->post_title;
		}
		return $courses;
	}
	function add_course_content_ids($content_ids, $course) {
		if(is_numeric($course))
			$course = get_post($course);

		if(!empty($course->ID) && $course->post_type == "wpcw_course")
		return $content_ids + $this->get_course_content_ids($course->ID);

		return $content_ids;
	}
	static function get_course_steps($course_id) {
		global $wpdb;
		$steps_ids = $module_ids = $unit_ids = $quiz_ids = array();
		$course  = wpcw_get_course( $course_id );
		$modules = $course->get_modules( );

		if(!empty($modules))
		foreach ($modules as $module) {
			$steps_ids[] = $module_ids[] = $module->get_id();
			$units = $module->get_units();

			if(!empty($units))
			foreach ($units as $unit) {
				$steps_ids[] = $unit_ids[] = $unit->get_id();
				$quizzes = $unit->get_quizzes();
				if(!empty($quizzes))
				foreach ($quizzes as $quiz) {
					$quiz_ids[] = $quiz->get_id();
				}
			}
		}

		return array("module_ids" => $module_ids, "unit_ids" => $unit_ids, "quiz_ids" => $quiz_ids, "steps_ids" => $steps_ids);
	}
	static function get_course_content_ids($course_id) {
		global $wpdb;

		$course = get_post($course_id);
		if(empty($course_id) || empty($course->post_type) || $course->post_type != "wpcw_course")
			return array();

		$steps = grassblade_wp_courseware::get_course_steps($course_id);
		$steps_ids = $steps["steps_ids"];
		$post_ids = $contents_on_quiz = array();

		if(!empty($steps_ids))
			$post_ids = grassblade_xapi_content::get_post_xapi_contents($steps_ids);

		if(!empty($steps["quiz_ids"])) {
			$quiz_ids = $steps["quiz_ids"];
			$contents_on_quiz = $wpdb->get_col("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'wpcw_quiz' AND meta_value IN (".implode(",", $quiz_ids).")");
		}

		return array_merge($post_ids, $contents_on_quiz);
	}

	function get_progress_report_data($r, $params) {
		global $wpdb;

		if(!empty($r))
			return $r;
		
		$course_id = intVal($params["course_id"]);
		$group_id = intVal($params["group_id"]);
		$course = get_post($course_id);

		if(empty($course) || empty($course->post_type) || $course->post_type != "wpcw_course")
			return $r;
		
		$modules_and_units = $this->get_modules_and_units($course_id);

		if( empty($modules_and_units["modules"]) || empty($modules_and_units["unit_ids"]) )
			return $r;

		$modules = $modules_and_units["modules"];
		$unit_ids = $modules_and_units["unit_ids"];

		$unit_completion_results = array();

		$users = array();

		$sql = "SELECT user_id, unit_id, unit_completed_status as status, unit_completed_date FROM {$wpdb->prefix}wpcw_user_progress WHERE unit_id IN (".implode(",", $unit_ids).") ORDER BY unit_completed_date ASC";

		$sql = grassblade_add_group_user_query($sql, $group_id);
		$unit_completion_results_raw = $wpdb->get_results($sql);

		if(!empty($unit_completion_results_raw))
		foreach ($unit_completion_results_raw as $key => $value) {
			if(empty($unit_completion_results[$value->user_id]))
			$unit_completion_results[$value->user_id] = array();

			if(empty($unit_completion_results[$value->user_id][$value->unit_id]))
			$unit_completion_results[$value->user_id][$value->unit_id] = array();

			$unit_completion_results[$value->user_id][$value->unit_id] = $value;

			$users[$value->user_id] = 1;
		}
		unset($unit_completion_results_raw);

		$k = 0;
		$ret = array();
		foreach ($users as $user_id => $v) {
			$user = get_user_by("id", $user_id);
			if(!empty($user->ID))
			{
				$data = array(
					"sno" 	=> $k,
					"name"	=> function_exists("gb_name_format")? gb_name_format($user) : $user->last_name.", ".$user->first_name, 
					"user_id" => $user->ID,
					"user_email" => $user->user_email,
				);
				foreach ($modules as $key => $module) {
					$user_module_results = array();// !empty($unit_completion_results[$user_id][$module->get_id()])? $unit_completion_results[$user_id][$module->get_id()]:array();
					$data[$module->get_id()] = $this->module_completion_date($module->module_units, $unit_completion_results[$user_id], $user_module_results);
				}
				$ret[$k++] = $data;
			}
		}
		$module_order = $modules_list = array();
		$k = 1;
		foreach ($modules as $key => $module) {
			$modules_list[$module->get_id()] = $module->get_module_title();
			$module_order[$k++] = $module->get_id();
		}
		$return = array("data" => $ret, "lessons" => $modules_list, 'lesson_order' => $module_order);
		return $return;
	}
	function get_modules_and_units($course_id) {
		global $wpdb;

		$course  = wpcw_get_course( $course_id );
		$modules = $course->get_modules();

		$unit_ids = array();
		foreach ($modules as $key => $module) {
			$module_units_obj = $module->get_units();
			$module_units = array();
			foreach ($module_units_obj as $unit) {
				$unit_ids[] = $module_units[] = $unit->get_id();
			}
			$modules[$key]->module_units = $module_units;
		}
		return array("modules" => $modules, "unit_ids" => $unit_ids);
	}
	function module_completion_date($module_units, $unit_completion_results_all = null, $user_module_results = null) {
		$date = "";
		$completed_count = 0;

		if(!empty($module_units))
		foreach ($module_units as $unit_id) {
			if(!empty($unit_completion_results_all) && !empty($unit_completion_results_all[$unit_id]) && !empty($unit_completion_results_all[$unit_id]->status) && $unit_completion_results_all[$unit_id]->status == 'complete') {
				if($unit_completion_results_all[$unit_id]->unit_completed_date > $date)
				$date = $unit_completion_results_all[$unit_id]->unit_completed_date;
				$completed_count++;
			}
		}

		if($completed_count == count($module_units) && !empty($date))
			return date("Y-m-d", strtotime($date));
		else
			return $completed_count."/".count($module_units);
	}
	function add_before_element($html, $el, $add_code) {
		$regex = "/(<\s*".$el["tag"]."[^>]*".$el["attr"]."\s*=\s*(\"|\')?\s*".$el["attr_value"]."\s*(\"|\')?[^>]*>)/s";
	
		$replace = $add_code."\r\n$1";
	
		$html = preg_replace($regex, $replace, $html);
	
		return $html;
	}
} // end of grassblade_wp_courseware class

$wpcw = new grassblade_wp_courseware();



