<?php
/**
 * Fired during plugin activation
 *
 * @link       https://wbcomdesigns.com/plugins
 * @since      1.0.0
 *
 * @package    Ld_Dashboard
 * @subpackage Ld_Dashboard/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ld_Dashboard
 * @subpackage Ld_Dashboard/includes
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Ld_Dashboard_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		if ( ! class_exists( 'LearnDash_Custom_Label' ) ) {
			return;
		}
		/* Check My Dashboard page exists or not */
		$my_dashboard_page = get_page_by_title( 'My Dashboard' );
		if ( empty( $my_dashboard_page ) ) {
			// Manage Order Page.
			$my_dashboard_page = wp_insert_post(
				array(
					'post_title'     => 'My Dashboard',
					'post_content'   => '[ld_dashboard]',
					'post_status'    => 'publish',
					'post_author'    => 1,
					'post_type'      => 'page',
					'comment_status' => 'closed',
				)
			);

			$reign_wbcom_metabox_data = array(
				'layout'        => array(
					'site_layout'       => 'full_width',
					'primary_sidebar'   => '0',
					'secondary_sidebar' => '0',
				),
				'header_footer' => array(
					'elementor_topbar' => '0',
					'elementor_header' => '0',
					'elementor_footer' => '0',
				),
			);
			update_post_meta( $my_dashboard_page, 'reign_wbcom_metabox_data', $reign_wbcom_metabox_data );
		}

		/* Check My Dashboard page exists or not */
		$instructor_listing_page = get_page_by_title( 'Instructors' );
		if ( empty( $instructor_listing_page ) ) {
			// Manage Order Page.
			$instructor_listing_page = wp_insert_post(
				array(
					'post_title'     => 'Instructors',
					'post_content'   => '[ld_dashboard_instructors_list]',
					'post_status'    => 'publish',
					'post_author'    => 1,
					'post_type'      => 'page',
					'comment_status' => 'closed',
				)
			);

			$reign_wbcom_metabox_data = array(
				'layout'        => array(
					'site_layout'       => 'full_width',
					'primary_sidebar'   => '0',
					'secondary_sidebar' => '0',
				),
				'header_footer' => array(
					'elementor_topbar' => '0',
					'elementor_header' => '0',
					'elementor_footer' => '0',
				),
			);
			update_post_meta( $instructor_listing_page, 'reign_wbcom_metabox_data', $reign_wbcom_metabox_data );
		}

		/* Check Instructor Registration page exists or not */
		$instructor_registration_page = get_page_by_title( 'Instructor Registration' );
		if ( empty( $instructor_registration_page ) ) {
			// Manage Order Page.
			$instructor_registration_page = wp_insert_post(
				array(
					'post_title'     => 'Instructor Registration',
					'post_content'   => '[ld_instructor_registration]',
					'post_status'    => 'publish',
					'post_author'    => 1,
					'post_type'      => 'page',
					'comment_status' => 'closed',
				)
			);

			$reign_wbcom_metabox_data = array(
				'layout'        => array(
					'site_layout'       => 'full_width',
					'primary_sidebar'   => '0',
					'secondary_sidebar' => '0',
				),
				'header_footer' => array(
					'elementor_topbar' => '0',
					'elementor_header' => '0',
					'elementor_footer' => '0',
				),
			);
			update_post_meta( $instructor_registration_page, 'reign_wbcom_metabox_data', $reign_wbcom_metabox_data );
		}
		$fields = array();

		$fields['ld_dashboard_course_form_settings'] = array(
			'field_61b6e2e70659b' => 1,
			'field_61b6e3040659c' => 1,
			'field_61b6e31f0659d' => 1,
			'field_61fcef414383d' => 1,
			'field_61b6e3390659e' => 1,
			'field_61b6e3840659f' => 1,
			'field_61b6e3f6065a0' => 1,
			'field_61b6e448065a1' => 1,
			'field_61b6e4c4065a2' => 1,
			'field_61b6e4ed065a3' => 1,
			'field_61b6e52b065a4' => 1,
			'field_61b6e561065a5' => 1,
			'field_61b6e7a0065a6' => 1,
			'field_62220196a91f9' => 1,
			'field_61b6e7d5065a7' => 1,
			'field_61b6e7fb065a8' => 1,
			'field_61b6e827065a9' => 1,
			'field_61b6e85a065aa' => 1,
			'field_61b6e880065ab' => 1,
			'field_61b6ecf1065ac' => 1,
			'field_61b6ed3b065ad' => 1,
			'field_61b6ed70065ae' => 1,
			'field_61b6edb1065af' => 1,
			'field_61b6ede2065b0' => 1,
			'field_61b887732a65b' => 1,
			'field_61f90e3dad31b' => 1,
			'field_61f910155bb7c' => 1,
			'field_620239860ddd2' => 1,
			'field_622201dca91fa' => 1,
			'field_622201f2a91fb' => 1,
			'field_622201122211'  => 1,
			'field_6222131233123' => 1,
			'field_6233323221'    => 1,
			'field_122324242445'  => 1,
			'field_623973542370e' => 1,
			'field_623973d72370f' => 1,
			'field_62220111111'   => 1,
			'field_62397c3323710' => 1,
		);

		$fields['ld_dashboard_lesson_form_settings'] = array(
			'field_61b6f86826e91' => 1,
			'field_61b6fae326e92' => 1,
			'field_61b6fbb326e93' => 1,
			'field_61fceqweqwqqe' => 1,
			'field_61b6fc0726e94' => 1,
			'field_61b6fca926e95' => 1,
			'field_61b6fe3b26e96' => 1,
			'field_61b7001e26e97' => 1,
			'field_61b7009526e98' => 1,
			'field_61b700e526e99' => 1,
			'field_61b7013626e9a' => 1,
			'field_61b7017c26e9b' => 1,
			'field_61b701b626e9c' => 1,
			'field_61b701ea26e9d' => 1,
			'field_61b7037426e9e' => 1,
			'field_61b703d526e9f' => 1,
			'field_61b7040e26ea0' => 1,
			'field_61b7045326ea2' => 1,
			'field_61b7110e26ea3' => 1,
			'field_61b7114726ea4' => 1,
			'field_61b71f4f26ea5' => 1,
			'field_61b71f7d26ea6' => 1,
			'field_61b71fd4bf8a4' => 1,
			'field_61b72017bf8a5' => 1,
			'field_61b7204fbf8a6' => 1,
			'field_61b72091bf8a8' => 1,
			'field_61b720eebf8a9' => 1,
			'field_61b72132bf8aa' => 1,
			'field_61b7215bbf8ab' => 1,
			'field_61b72188bf8ac' => 1,
			'field_6215e03fe3d27' => 1,
			'field_621dbf8aababe' => 1,
		);

		$fields['ld_dashboard_topic_form_settings'] = array(
			'field_61b72a9cc2d3a'   => 1,
			'field_61b72abfc2d3b'   => 1,
			'field_61b72fe6c2d3c'   => 1,
			'field_61lloiu654xd'    => 1,
			'field_61b73007c2d3d'   => 1,
			'field_61b7302ac2d3e'   => 1,
			'field_61b7304bc2d3f'   => 1,
			'field_61b7308ec2d40'   => 1,
			'field_61b73442c2d41'   => 1,
			'field_61b73475c2d42'   => 1,
			'field_61b734b3c2d43'   => 1,
			'field_61b734e5c2d44'   => 1,
			'field_61b73512c2d45'   => 1,
			'field_61b73544c2d46'   => 1,
			'field_61b7366dc2d47'   => 1,
			'field_61b736a9c2d48'   => 1,
			'field_61b736d9c2d49'   => 1,
			'field_61b7372dc2d4b'   => 1,
			'field_61b7375ec2d4c'   => 1,
			'field_61b73782c2d4d'   => 1,
			'field_61b737b9c2d4e'   => 1,
			'field_61b737e1c2d4f'   => 1,
			'field_61b73825c2d50'   => 1,
			'field_61b738b0c2d51'   => 1,
			'field_61b738f0c2d52'   => 1,
			'field_61b73922c2d54'   => 1,
			'field_61b73957c2d55'   => 1,
			'field_61b7398cc2d56'   => 1,
			'field_6215e03fe3d2711' => 1,
			'field_621dbf8aaaaaa'   => 1,
		);

		$fields['ld_dashboard_quiz_form_settings'] = array(
			'field_61d7fd69a6576' => 1,
			'field_61d7fd8ba6577' => 1,
			'field_61lkjhgf321'   => 1,
			'field_61d7fda3a6578' => 1,
			'field_61d7fdc7a6579' => 1,
			'field_61d7fde3a657a' => 1,
			'field_61d7fdffa657b' => 1,
			'field_61d7fe28a657c' => 1,
			'field_61d7fe3ea657d' => 1,
			'field_61d8070ea657e' => 1,
			'field_61d807e9a657f' => 1,
			'field_61d80813a6580' => 1,
			'field_61d8083fa6581' => 1,
			'field_61d8089d0be2a' => 1,
			'field_61d808b30be2b' => 1,
			'field_61d808e00be2c' => 1,
			'field_61d809610be2d' => 1,
			'field_61d809930be2e' => 1,
			'field_61d809be0be2f' => 1,
			'field_61d80a03926c1' => 1,
			'field_61d80a47926c2' => 1,
			'field_61d80a66926c3' => 1,
			'field_61d80b24926c4' => 1,
			'field_61d80b4d926c5' => 1,
			'field_61d80b61926c6' => 1,
			'field_61d80b88926c7' => 1,
			'field_61d80ba2926c8' => 1,
			'field_61d80bc2926c9' => 1,
			'field_61d80be2926ca' => 1,
			'field_61d80c05926cb' => 1,
			'field_61d80c21926cc' => 1,
			'field_61d80c37926cd' => 1,
			'field_61d80c5a926ce' => 1,
			'field_61d80c76926cf' => 1,
			'field_620239860eee2' => 1,
			'field_61deee122'     => 1,
			'field_623849ad640c2' => 1,
			'field_62384a65a2cfa' => 1,
			'field_61b6e7d5065a7' => 1,
			'field_62384a9ea2cfb' => 1,
		);

		$fields['ld_dashboard_question_form_settings'] = array(
			'field_61c02f72a9f61' => 1,
			'field_61c030b7a9f62' => 1,
			'field_61fqq121wz'    => 1,
			'field_61c030e4a9f63' => 1,
			'field_61c03f745cb04' => 1,
			'field_61c032a3a9f64' => 1,
			'field_61c032eba9f66' => 1,
			'field_61c032cda9f65' => 1,
			'field_61c036017c96f' => 1,
			'field_61c037e5b9ca4' => 1,
			'field_61c0365f6f1bf' => 1,
			'field_61c036af6f1c0' => 1,
			'field_61c55098dc3c6' => 1,
		);

		foreach ( $fields as $key => $value ) {
			$registered_fields = get_option( $key );
			if ( false === $registered_fields ) {
				update_option( $key, $value );
			}
		}

		$ld_dashboard_design_settings = get_option( 'ld_dashboard_design_settings' );
		if ( false === $ld_dashboard_design_settings ) {
			$ld_dashboard_design_settings = array(
				'preset'      => 'default',
				'color'       => '#156AE9',
				'hover_color' => '#1d76da',
				'text_color'  => '#515b67',
				'background'  => '#F8F8FB',
				'border'      => '#dcdfe5',
			);
			update_option( 'ld_dashboard_design_settings', $ld_dashboard_design_settings );
		}

		$default_design_settings = get_option( 'ld_dashboard_default_design_settings' );
		if ( false === $default_design_settings ) {
			$default_design_settings = array(
				'preset'      => 'default',
				'color'       => '#156AE9',
				'hover_color' => '#1d76da',
				'text_color'  => '#515b67',
				'background'  => '#F8F8FB',
				'border'      => '#dcdfe5',
			);
			update_option( 'ld_dashboard_default_design_settings', $default_design_settings );
		}

		$default_field_label_settings = get_option( 'ld_dashboard_frontend_form_default_labels' );
		if ( false === $default_field_label_settings ) {
			$label_settings = array(
				'field_61b72091bf8a8' => sprintf( esc_html__( 'Forced %s time', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'lesson' ) ),
				'field_61b72188bf8ac' => esc_html__( 'Number of Days', 'ld-dashboard' ),
				'field_61d808b30be2b' => sprintf( esc_html__( '%s Material Content', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'quiz' ) ),
				'field_61d809610be2d' => esc_html__( 'Display result position', 'ld-dashboard' ),
				'field_61d809930be2e' => sprintf( esc_html__( '%s per page', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'questions' ) ),
				'field_61d80a66926c3' => esc_html__( 'Randomize order type', 'ld-dashboard' ),
				'field_61d80b24926c4' => sprintf( esc_html__( 'Number of %s in subset', 'ld-dashboard' ), strtolower( LearnDash_Custom_Label::get_label( 'questions' ) ) ),
				'field_61d80c76926cf' => esc_html__( 'Leaderboard position', 'ld-dashboard' ),
				'field_61c032eba9f66' => esc_html__( 'Points type', 'ld-dashboard' ),
				'field_61c032cda9f65' => esc_html__( 'Display points scored in message', 'ld-dashboard' ),
				'field_61c036af6f1c0' => esc_html__( 'Hint content', 'ld-dashboard' ),
				'field_622201dca91fa' => esc_html__( 'Billing Cycle Number', 'ld-dashboard' ),
				'field_622201f2a91fb' => esc_html__( 'Billing Cycle Type', 'ld-dashboard' ),
				'field_622201122211'  => esc_html__( 'Trial Duration Number', 'ld-dashboard' ),
				'field_6222131233123' => esc_html__( 'Trial Duration Type', 'ld-dashboard' ),
			);
			update_option( 'ld_dashboard_frontend_form_default_labels', $label_settings );
		}

		$general_settings = get_option( 'ld_dashboard_general_settings' );
		if ( false === $general_settings ) {
			$general_settings = array(
				'welcome-screen'               => 1,
				'statistics-tiles'             => 1,
				'course-progress'              => 1,
				'student-details'              => 1,
				'enable-announcements'         => 1,
				'instructor-statistics'        => 1,
				'enable-email-integration'     => 0,
				'enable-messaging-integration' => 0,
				'display-to-do'                => 0,
				'become-instructor-button'     => 1,
				'my_dashboard_page'            => ( is_object( $my_dashboard_page ) ) ? $my_dashboard_page->ID : $my_dashboard_page,
				'instructor_registration_page' => ( is_object( $instructor_registration_page ) ) ? $instructor_registration_page->ID : $instructor_registration_page,
				'instructor_listing_page'      => ( is_object( $instructor_listing_page ) ) ? $instructor_listing_page->ID : $instructor_listing_page,
			);
			update_option( 'ld_dashboard_general_settings', $general_settings );
		}

		$tiles_options = get_option( 'ld_dashboard_tiles_options' );
		if ( false === $tiles_options ) {
			$tiles_options = array(
				'instructor-total-sales'          => '1',
				'instructor-total-sales-bgcolor'  => '#00A2E8',
				'course-count'                    => '1',
				'course-count-bgcolor'            => '#00A2E8',
				'quizzes-count'                   => '1',
				'quizzes-count-bgcolor'           => '#00A2E8',
				'assignments-count'               => '1',
				'assignments-completed-count'     => '1',
				'assignments-count-bgcolor'       => '#00A2E8',
				'essays-pending-count'            => '1',
				'essays-pending-count-bgcolor'    => '#00A2E8',
				'lessons-count'                   => '1',
				'lessons-count-bgcolor'           => '#00A2E8',
				'topics-count'                    => '1',
				'topics-count-bgcolor'            => '#00A2E8',
				'student-count'                   => '1',
				'student-count-bgcolor'           => '#00A2E8',
				'ins-earning'                     => '1',
				'ins-earning-bgcolor'             => '#00A2E8',
				'total-earning'                   => '1',
				'total-earning-bgcolor'           => '#00A2E8',
				'enrolled_courses_count'          => 1,
				'enrolled_courses_count_bgcolor'  => '#00A2E8',
				'active_courses_count'            => 1,
				'active_courses_count_bgcolor'    => '#00A2E8',
				'completed_courses_count'         => 1,
				'completed_courses_count_bgcolor' => '#00A2E8',
			);
			update_option( 'ld_dashboard_tiles_options', $tiles_options );
		}

		$menu_options = get_option( 'ld_dashboard_menu_options' );
		if ( false === $menu_options ) {
			$menu_options = array(
				'all'        => array(
					'my-dashboard'     => 1,
					'profile'          => 1,
					'enrolled-courses' => 1,
					'my-quiz-attempts' => 1,
					'my-activity'      => 1,
					'announcements'    => 1,
				),
				'instructor' => array(
					'my-courses'       => 1,
					'my-lessons'       => 1,
					'my-topics'        => 1,
					'my-quizzes'       => 1,
					'my-questions'     => 1,
					'assignments'      => 1,
					'meetings'         => 1,
					'certificates'     => 1,
					'my-announcements' => 1,
					'groups'           => 1,
					'quiz-attempts'    => 1,
					'activity'         => 1,
					'notification'     => 1,
				),
				'both'       => array(
					'settings' => 1,
					'logout'   => 1,
				),
			);
			update_option( 'ld_dashboard_menu_options', $menu_options );
		}

		$monetization_options = get_option( 'ld_dashboard_manage_monetization' );
		if ( false === $monetization_options ) {
			$monetization_options = array(
				'sharing-percentage-instructor' => 80,
				'sharing-percentage-admin'      => 20,
				'statement-per-page'            => 20,
			);
			update_option( 'ld_dashboard_manage_monetization', $monetization_options );
		}

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$charset_collate = $wpdb->get_charset_collate();

		/* Create LearnDash Dashboard Email Logs table */
		$ld_dashboard_emails = $wpdb->prefix . 'ld_dashboard_emails';
		if ( $wpdb->get_var( "show tables like '$ld_dashboard_emails'" ) != $ld_dashboard_emails ) {

			$edd_sql = "CREATE TABLE $ld_dashboard_emails (
						id mediumint(9) NOT NULL AUTO_INCREMENT,						
						user_id mediumint(9) NOT NULL,
						email_subject text NOT NULL,
						email_message text NOT NULL,
						course_ids text NOT NULL,
						student_ids text NOT NULL,						
						created DATETIME NOT NULL,
						UNIQUE KEY id (id)
			) $charset_collate;";
			dbDelta( $edd_sql );
		}

		ld_dashboard_update_wdm_instructor_to_ld_instructor();

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


