<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wbcomdesigns.com/plugins
 * @since             1.0.0
 * @package           Ld_Dashboard
 *
 * @wordpress-plugin
 * Plugin Name:       Learndash Dashboard
 * Plugin URI:        https://wbcomdesigns.com/downloads/learndash-dashboard/
 * Description:       This plugin creates a dashboard panel for Learndash instructors and students. The instructors can manage the courses, view their courses progress and student logs.
 * Version:           5.8.0
 * Author:            Wbcom Designs
 * Author URI:        https://wbcomdesigns.com/plugins
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ld-dashboard
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
update_site_option( 'edd_wbcom_ldd_license_key', 'a261347a-3dfa-4d4d-86e9-85bd442a2b50' );
update_site_option( 'edd_wbcom_ldd_license_status', 'valid' );
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LD_DASHBOARD_VERSION', '5.8.0' );

define( 'LD_DASHBOARD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LD_DASHBOARD_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
if ( ! defined( 'LD_DASHBOARD_PLUGIN_FILE' ) ) {
	define( 'LD_DASHBOARD_PLUGIN_FILE', __FILE__ );
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ld-dashboard-activator.php
 */
function activate_ld_dashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ld-dashboard-activator.php';
	Ld_Dashboard_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ld-dashboard-deactivator.php
 */
function deactivate_ld_dashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ld-dashboard-deactivator.php';
	Ld_Dashboard_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ld_dashboard' );
register_deactivation_hook( __FILE__, 'deactivate_ld_dashboard' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ld-dashboard.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ld_dashboard() {

	require plugin_dir_path( __FILE__ ) . 'edd-license/edd-plugin-license.php';
	$plugin = new Ld_Dashboard();
	$plugin->run();

}
// run_ld_dashboard();

/**
 * Include needed files if required plugin is active
 *
 *  @since   1.0.0
 *  @author  Wbcom Designs
 */
add_action( 'plugins_loaded', 'ld_dashboard_plugin_init' );
function ld_dashboard_plugin_init() {
	if ( ! class_exists( 'ACF' ) || ! class_exists( 'SFWD_LMS' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'ld_dashboard_admin_notice' );
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	} else {
		run_ld_dashboard();
	}
}

add_action( 'init', 'ld_dashboard_register_custom_post_type' );

function ld_dashboard_register_custom_post_type() {

	// Register Withdrawal post type
	$withdrawals_labels = array(
		'name'               => _x( 'Withdrawals', 'Post Type General Name', 'ld-dashboard' ),
		'singular_name'      => _x( 'Withdrawal', 'Post Type Singular Name', 'ld-dashboard' ),
		'menu_name'          => __( 'Withdrawals', 'ld-dashboard' ),
		'parent_item_colon'  => __( 'Parent Withdrawal', 'ld-dashboard' ),
		'all_items'          => __( 'All Withdrawals', 'ld-dashboard' ),
		'view_item'          => __( 'View Withdrawal', 'ld-dashboard' ),
		'add_new_item'       => __( 'Add New Withdrawal Request', 'ld-dashboard' ),
		'add_new'            => __( 'Add New', 'ld-dashboard' ),
		'edit_item'          => __( 'Edit Withdrawal Request', 'ld-dashboard' ),
		'update_item'        => __( 'Update Withdrawal Request', 'ld-dashboard' ),
		'search_items'       => __( 'Search Withdrawal', 'ld-dashboard' ),
		'not_found'          => __( 'Not Found', 'ld-dashboard' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'ld-dashboard' ),
	);

	$withdrawals_args = array(
		'label'              => __( 'withdrawals', 'ld-dashboard' ),
		'description'        => __( 'Withdrawals requests', 'ld-dashboard' ),
		'labels'             => $withdrawals_labels,
		'supports'           => array( 'title', 'editor', 'excerpt', 'author', 'revisions', 'custom-fields' ),
		'taxonomies'         => array(),
		'hierarchical'       => false,
		'public'             => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-money-alt',
		'publicly_queryable' => true,
		'capability_type'    => 'post',
		'show_in_rest'       => true,
	);
	register_post_type( 'withdrawals', $withdrawals_args );

	$announcements_labels = array(
		'name'               => _x( 'Announcements', 'Post Type General Name', 'ld-dashboard' ),
		'singular_name'      => _x( 'Announcement', 'Post Type Singular Name', 'ld-dashboard' ),
		'menu_name'          => __( 'Announcements', 'ld-dashboard' ),
		'parent_item_colon'  => __( 'Parent Movie', 'ld-dashboard' ),
		'all_items'          => __( 'All Announcements', 'ld-dashboard' ),
		'view_item'          => __( 'View Announcement', 'ld-dashboard' ),
		'add_new_item'       => __( 'Add New Announcement', 'ld-dashboard' ),
		'add_new'            => __( 'Add New', 'ld-dashboard' ),
		'edit_item'          => __( 'Edit Announcement', 'ld-dashboard' ),
		'update_item'        => __( 'Update Announcement', 'ld-dashboard' ),
		'search_items'       => __( 'Search Announcement', 'ld-dashboard' ),
		'not_found'          => __( 'Not Found', 'ld-dashboard' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'ld-dashboard' ),
	);

	$announcements_args = array(
		'label'              => __( 'announcements', 'ld-dashboard' ),
		'description'        => __( 'Announcements for students', 'ld-dashboard' ),
		'labels'             => $announcements_labels,
		'supports'           => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
		'taxonomies'         => array(),
		'hierarchical'       => false,
		'public'             => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-megaphone',
		'publicly_queryable' => true,
		'capability_type'    => 'post',
		'show_in_rest'       => true,
	);
	register_post_type( 'announcements', $announcements_args );

}

/**
 * Show admin notice when Learndash not active or install.
 *
 *  @since   1.0.0
 *  @author  Wbcom Designs
 */
function ld_dashboard_admin_notice() {
	?>
	<div class="error notice is-dismissible">
		<p><?php echo sprintf( __( 'The %1$s plugin requires %2$s and %3$s plugin to be installed and active.', 'ld-dashboard' ), '<b>LearnDash Dashboard</b>', '<b>LearnDash</b>', '<b><a href="https://wordpress.org/plugins/advanced-custom-fields/">Advanced Custom Fields</a></b>' ); ?></p>
	</div>
	<?php
	// The LearnDash Dashboard plugin requires LearnDash and Advanced Custom Fields plugin to be installed and active.
}

add_action( 'admin_init', 'ld_dashboard_update_admin_init' );
/*
 * Update To save wdm instructor id into ld instructor id.
 */
function ld_dashboard_update_admin_init() {
	global $wpdb, $pagenow;
	$update_ld_dashboard = get_option( 'update_ld_dashboard' );
	if ( ! $update_ld_dashboard && ( $pagenow == 'plugins.php' || ( isset( $_GET['page'] ) && $_GET['page'] == 'ld-dashboard-settings' ) ) ) {

		ld_dashboard_update_wdm_instructor_to_ld_instructor();
		update_option( 'update_ld_dashboard', true );
	}

	/*
	 * Update LearnDash Dashboard Setting with new update setting
	 */
	$update_ld_dashboard_4_3_0 = get_option( 'update_ld_dashboard_4_3_0' );

	if ( ! $update_ld_dashboard_4_3_0 && ( $pagenow == 'plugins.php' || ( isset( $_GET['page'] ) && $_GET['page'] == 'ld-dashboard-settings' ) ) ) {
		$general_settings = get_option( 'ld_dashboard_general_settings' );

		$tiles_options = array(
			'instructor-total-sales'         => ( isset( $general_settings['instructor-total-sales'] ) ) ? $general_settings['instructor-total-sales'] : 0,
			'instructor-total-sales-bgcolor' => ( isset( $general_settings['instructor-total-sales-bgcolor'] ) ) ? $general_settings['instructor-total-sales-bgcolor'] : '',
			'course-count'                   => ( isset( $general_settings['course-count'] ) ) ? $general_settings['course-count'] : '',
			'course-count-bgcolor'           => ( isset( $general_settings['course-count-bgcolor'] ) ) ? $general_settings['course-count-bgcolor'] : '',
			'quizzes-count'                  => ( isset( $general_settings['quizzes-count'] ) ) ? $general_settings['quizzes-count'] : '',
			'quizzes-count-bgcolor'          => ( isset( $general_settings['quizzes-count-bgcolor'] ) ) ? $general_settings['quizzes-count-bgcolor'] : '',
			'assignments-count'              => ( isset( $general_settings['assignments-count'] ) ) ? $general_settings['assignments-count'] : '',
			'assignments-completed-count'    => ( isset( $general_settings['assignments-completed-count'] ) ) ? $general_settings['assignments-completed-count'] : '',
			'assignments-count-bgcolor'      => ( isset( $general_settings['assignments-count-bgcolor'] ) ) ? $general_settings['assignments-count-bgcolor'] : '',
			'essays-pending-count'           => ( isset( $general_settings['essays-pending-count'] ) ) ? $general_settings['essays-pending-count'] : '',
			'essays-pending-count-bgcolor'   => ( isset( $general_settings['essays-pending-count-bgcolor'] ) ) ? $general_settings['essays-pending-count-bgcolor'] : '',
			'lessons-count'                  => ( isset( $general_settings['lessons-count'] ) ) ? $general_settings['lessons-count'] : '',
			'lessons-count-bgcolor'          => ( isset( $general_settings['lessons-count-bgcolor'] ) ) ? $general_settings['lessons-count-bgcolor'] : '',
			'topics-count'                   => ( isset( $general_settings['topics-count'] ) ) ? $general_settings['topics-count'] : '',
			'topics-count-bgcolor'           => ( isset( $general_settings['topics-count-bgcolor'] ) ) ? $general_settings['topics-count-bgcolor'] : '',
			'student-count'                  => ( isset( $general_settings['student-count'] ) ) ? $general_settings['student-count'] : '',
			'student-count-bgcolor'          => ( isset( $general_settings['student-count-bgcolor'] ) ) ? $general_settings['student-count-bgcolor'] : '',
		);

		update_option( 'ld_dashboard_tiles_options', $tiles_options );

		$welcome_screen['welcome-message']  = ( isset( $general_settings['welcome-message'] ) ) ? $general_settings['welcome-message'] : '';
		$welcome_screen['welcomebar_image'] = ( isset( $general_settings['welcomebar_image'] ) ) ? $general_settings['welcomebar_image'] : '';
		update_option( 'ld_dashboard_welcome_screen', $welcome_screen );

		$integration                                      = get_option( 'ld_dashboard_integration' );
		$general_settings['welcome-screen']               = 1;
		$general_settings['statistics-tiles']             = 1;
		$general_settings['enable-messaging-integration'] = ( isset( $integration['enable-messaging-integration'] ) ) ? $integration['enable-messaging-integration'] : '';
		$general_settings['enable-email-integration']     = ( isset( $integration['enable-email-integration'] ) ) ? $integration['enable-email-integration'] : '';
		$general_settings['display-to-do']                = ( isset( $integration['display-to-do'] ) ) ? $integration['display-to-do'] : '';
		update_option( 'ld_dashboard_general_settings', $general_settings );

		update_option( 'update_ld_dashboard_4_3_0', true );
	}
}

function ld_dashboard_update_wdm_instructor_to_ld_instructor() {
	$args   = array(
		'post_type'      => 'sfwd-courses',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_query'     => array(
			array(
				'key'     => 'ir_shared_instructor_ids',
				'value'   => '',
				'compare' => '!=',
			),
		),
	);
	$course = new WP_Query( $args );
	if ( $course->have_posts() ) {

		while ( $course->have_posts() ) {
			$course->the_post();
			$_ld_instructor_ids = get_post_meta( get_the_ID(), '_ld_instructor_ids', true );
			if ( empty( $_ld_instructor_ids ) ) {
				$_ld_instructor_ids = array();
			}
			$ir_shared_instructor_ids = get_post_meta( get_the_ID(), 'ir_shared_instructor_ids', true );

			if ( $ir_shared_instructor_ids != '' ) {
				$ir_shared_instructor_ids = explode( ',', $ir_shared_instructor_ids );

				foreach ( $ir_shared_instructor_ids as $user_id ) {
					$ld_user = new WP_User( $user_id );
					$ld_user->add_role( 'ld_instructor' );
				}
			} else {
				$ir_shared_instructor_ids = array();
			}

			$_ld_instructor_ids = array_merge( $ir_shared_instructor_ids, $_ld_instructor_ids );
			update_post_meta( get_the_ID(), '_ld_instructor_ids', array_unique( $_ld_instructor_ids ) );
		}
		wp_reset_postdata();
	}

	$args = array(
		'orderby'  => 'user_nicename',
		'role__in' => 'wdm_instructor',
		'order'    => 'ASC',
		'fields'   => array( 'ID', 'display_name' ),
	);

	$instructors = get_users( $args );
	if ( ! empty( $instructors ) ) {
		foreach ( $instructors as $instructor ) {
			$ld_user = new WP_User( $instructor->ID );
			$ld_user->add_role( 'ld_instructor' );
		}
	}
}

/*
 * Added Plugin settings Link
 */
function ld_dashboard_settings_link( $links ) {
	$links['settings'] = '<a href="' . admin_url( 'admin.php?page=ld-dashboard-settings&tab=ld-dashboard-general' ) . '">' . __( 'Settings', 'ld-dashboard' ) . '</a>';
	return $links;
}

add_filter( 'plugin_action_links_ld-dashboard/ld-dashboard.php', 'ld_dashboard_settings_link' );


/**
 * Find and replace usermeta.meta_key = 'course_{ to usermeta.meta_key LIKE 'course_{
 */
function ld_dashboard_user_queries( $user_query ) {
	global $wpdb;
	if ( strpos( $user_query->query_where, "usermeta.meta_key = 'course_{" ) ) {
		$user_query->query_fields = str_replace( "{$wpdb->prefix}users.ID", "DISTINCT {$wpdb->prefix}users.ID ", $user_query->query_fields );
		$user_query->query_where  = str_replace( "usermeta.meta_key = 'course_{", "usermeta.meta_key LIKE 'course_{", $user_query->query_where );
	}
}

add_action( 'activated_plugin', 'ld_dashboard_activation_redirect_settings' );

/**
 * Redirect to plugin settings page after activated
 *
 * @param plugin $plugin plugin.
 */
function ld_dashboard_activation_redirect_settings( $plugin ) {
	if ( ! isset( $_GET['plugin'] ) ) {
		return;
	}
	if ( $plugin == plugin_basename( __FILE__ ) && class_exists( 'ACF' ) && class_exists( 'SFWD_LMS' ) ) {
		wp_redirect( admin_url( 'admin.php?page=ld-dashboard-settings' ) );
		exit;
	}
}



/*
 * Create Instructor Commission Logs table
 *
 */

add_action( 'admin_init', 'ld_dashboard_create_instructor_commision_logs' );
function ld_dashboard_create_instructor_commision_logs() {
	global $wpdb, $pagenow;

	if ( $pagenow == 'plugins.php' || ( isset( $_GET['page'] ) && $_GET['page'] == 'ld-dashboard-settings' ) && isset( $_GET['tab'] ) && $_GET['tab'] == 'ld-dashboard-welcome' ) {

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$charset_collate = $wpdb->get_charset_collate();

		/* Create LearnDash Dashboard Email Logs table */
		$ld_dashboard_instructor_commission_logs = $wpdb->prefix . 'ld_dashboard_instructor_commission_logs';
		if ( $wpdb->get_var( "show tables like '$ld_dashboard_instructor_commission_logs'" ) != $ld_dashboard_instructor_commission_logs ) {

			$instructor_commission_logs_sql = "CREATE TABLE $ld_dashboard_instructor_commission_logs (
						id bigint(20) NOT NULL AUTO_INCREMENT,						
						user_id bigint(20) NOT NULL,
						course_id bigint(20) NOT NULL,
						course_price text NOT NULL,
						commission text NOT NULL,
						commission_rate text NOT NULL,
						commission_type text NOT NULL,
						fees_type text NOT NULL,
						fees_amount text NULL,
						source_type text NULL,
						reference text NULL,
						coupon text NULL,
						created DATETIME NOT NULL,
						UNIQUE KEY id (id)
			) $charset_collate;";
			dbDelta( $instructor_commission_logs_sql );
		}
	}
}