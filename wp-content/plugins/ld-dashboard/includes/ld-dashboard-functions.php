<?php

/**
 * Function to return admin commuission on course.
 *
 * @since  1.0.0
 * @author Wbcom Designs
 */
function ld_get_admin_course_commission( $course_id ) {
	$value = get_post_meta( $course_id, 'admin-course-commission', true );
	return apply_filters( 'ld_get_admin_course_commission', (int) $value );
}

function ld_dashboard_set_cron_schedule( $schedules ) {
	$schedules['every_six_hours'] = array(
		'interval' => 21600,
		'display'  => esc_html__( 'Every 6 hours', 'ld-dashboard' ),
	);
	return $schedules;
}

add_filter( 'cron_schedules', 'ld_dashboard_set_cron_schedule' );

/**
 * Function to check if author is instructor.
 *
 * @since  1.0.0
 * @author Wbcom Designs
 */
function ld_check_if_author_is_instructor( $course_author ) {
	$course_author_data  = get_userdata( $course_author );
	$course_author_roles = $course_author_data->roles;
	if ( in_array( 'ld_instructor', (array) $course_author_roles ) ) {
		return apply_filters( 'ld_check_if_author_is_instructor', true );
	}
	return false;
}

function ld_dashboard_update_on_stripe_payment( $post_id, $post ) {
	$stripe_course_id = get_post_meta( $post_id, 'stripe_course_id', true );
	update_option( 'test_stripe_payment', $stripe_course_id );
}

if ( ! function_exists( 'ld_if_commission_enabled' ) ) {
	/**
	 * Check if monetization is enable
	 */
	function ld_if_commission_enabled() {
		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$settings                   = $ld_dashboard_settings_data['general_settings'];

		if ( isset( $settings['enable-revenue-sharing'] ) && '1' === $settings['enable-revenue-sharing'] ) {
			return true;
		}
		return false;
	}
}

function ld_dashboard_get_course_students( $course_id ) {
	$students       = array();
	$course_pricing = learndash_get_course_price( $course_id );
	if ( 'open' !== $course_pricing['type'] ) {
		$course_students = learndash_get_course_users_access_from_meta( $course_id );
		if ( ! empty( $course_students ) ) {
			$students = array_merge( $students, $course_students );
		}
		$course_group_ids = learndash_get_course_groups( $course_id );
		if ( ! empty( $course_group_ids ) ) {
			foreach ( $course_group_ids as $group_id ) {
				$group_users = learndash_get_groups_user_ids( $group_id );
				if ( ! empty( $group_users ) ) {
					$students = array_merge( $students, $group_users );
				}
			}
		}
	} else {
		$users = get_users();
		if ( ! empty( $users ) ) {
			foreach ( $users as $student ) {
				$students[] = $student->ID;
			}
		}
	}
	if ( ! empty( $students ) ) {
		$students = array_unique( $students );
	}
	return $students;
}

function ld_dashboard_check_if_zoom_credentials_exists() {
	$current_user               = wp_get_current_user();
	$function_obj               = Ld_Dashboard_Functions::instance();
	$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
	$settings                   = $ld_dashboard_settings_data['zoom_meeting_settings'];

	$has_set_zoom_credentials  = true;
	$can_use_admin_credentials = ( isset( $settings['use-admin-account'] ) && 1 == $settings['use-admin-account'] ) ? true : false;
	if ( in_array( 'ld_instructor', $current_user->roles ) ) {
		if ( '' === get_user_meta( $current_user->ID, 'zoom_api_key', true ) || empty( get_user_meta( $current_user->ID, 'zoom_api_key', true ) ) ) {
			$has_set_zoom_credentials = false;
		}
		if ( '' === get_user_meta( $current_user->ID, 'zoom_api_secret', true ) || empty( get_user_meta( $current_user->ID, 'zoom_api_secret', true ) ) ) {
			$has_set_zoom_credentials = false;
		}
		if ( '' === get_user_meta( $current_user->ID, 'zoom_email', true ) || empty( get_user_meta( $current_user->ID, 'zoom_email', true ) ) ) {
			$has_set_zoom_credentials = false;
		}
	}
	if ( $can_use_admin_credentials && ! $has_set_zoom_credentials ) {
		$has_set_zoom_credentials = true;
	}
	if ( in_array( 'administrator', $current_user->roles ) || $can_use_admin_credentials ) {
		if ( ! isset( $settings['zoom-api-key'] ) || ( isset( $settings['zoom-api-key'] ) && '' === $settings['zoom-api-key'] ) ) {
			$has_set_zoom_credentials = false;
		}
		if ( ! isset( $settings['zoom-api-secret'] ) || ( isset( $settings['zoom-api-secret'] ) && '' === $settings['zoom-api-secret'] ) ) {
			$has_set_zoom_credentials = false;
		}
		if ( ! isset( $settings['zoom-email'] ) || ( isset( $settings['zoom-email'] ) && '' === $settings['zoom-email'] ) ) {
			$has_set_zoom_credentials = false;
		}
	}
	return $has_set_zoom_credentials;
}

function ld_get_local_time_difference( $time ) {
	$local_timezone = get_option( 'gmt_offset' );
	$is_negative    = false;
	if ( $local_timezone < 0 ) {
		$local_timezone = -1 * $local_timezone;
		$is_negative    = true;
	}
	$new_local_timezone  = $local_timezone * 10;
	$min                 = $new_local_timezone % 10;
	$new_local_timezone -= $min;
	$hr                  = $new_local_timezone / 10;
	if ( $min === 5 ) {
		$min = 30;
	}
	$time_difference = ( ( $hr * 60 ) + $min ) * 60;
	if ( $is_negative ) {
		$time_difference = -1 * $time_difference;
	}
	$str = strtotime( $time ) + $time_difference;
	return $str;
}

function ld_dashboard_is_instructor_group_leader() {
	$current_user = wp_get_current_user();
	if ( learndash_is_group_leader_user( $current_user->ID ) && in_array( 'ld_instructor', (array) $current_user->roles ) ) {
		return true;
	}
	return false;
}

function ld_get_global_commission_rate() {
	$function_obj               = Ld_Dashboard_Functions::instance();
	$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
	$settings                   = $ld_dashboard_settings_data['monetization_settings'];
	$global_commission          = ( isset( $settings['sharing-percentage-instructor'] ) ) ? $settings['sharing-percentage-instructor'] : 0;
	return apply_filters( 'ld_get_global_commission_rate', (int) $global_commission );
}

function ld_dashboard_get_instructor_earnings() {
	global $wpdb;
	$user_id          = get_current_user_id();
	$total_earnings   = get_user_meta( $user_id, 'instructor_total_earning', true );
	$total_commission = $wpdb->prepare( 'SELECT sum(commission) as commission FROM ' . $wpdb->prefix . 'ld_dashboard_instructor_commission_logs WHERE user_id = %d order by ID DESC', $user_id );
	$total_earnings   = $wpdb->get_var( $total_commission );

	return $total_earnings;
}

function ld_dashboard_get_sidebar_tabs() {
	$current_user                   = wp_get_current_user();
	$user_id                        = $current_user->ID;
	$function_obj                   = Ld_Dashboard_Functions::instance();
	$ld_dashboard_settings_data     = $function_obj->ld_dashboard_settings_data();
	$welcome_screen                 = $ld_dashboard_settings_data['welcome_screen'];
	$ld_dashboard_general_settings  = $ld_dashboard_settings_data['general_settings'];
	$monetization_settings          = $ld_dashboard_settings_data['monetization_settings'];
	$feed_settings                  = $ld_dashboard_settings_data['ld_dashboard_feed_settings'];
	$dashboard_page                 = $function_obj->ld_dashboard_get_url( 'dashboard' );
	$enable_instructor_earning_logs = isset( $ld_dashboard_general_settings['enable-instructor-earning-logs'] ) ? $ld_dashboard_general_settings['enable-instructor-earning-logs'] : '';
	$match_userroles                = array();
	if ( ! empty( $settings['disable_user_roles_live_feed'] ) ) {
		$match_userroles = array_intersect( $current_user_role, $settings['disable_user_roles_live_feed'] );
	}
	$enable_live_feed = false;
	if ( ( ! isset( $settings['disable-live-feed'] ) || $settings['disable-live-feed'] != 1 ) && ( empty( $match_userroles ) ) ) {
		$enable_live_feed = true;
	}
	$menu_items                        = array();
	$menu_items['all']['my-dashboard'] = array(
		'url'   => ( '' != $dashboard_page ) ? $dashboard_page : get_the_permalink(),
		'icon'  => '<span class="material-symbols-outlined">dashboard</span>',
		'label' => esc_html__( 'Dashboard', 'ld-dashboard' ),
	);

	$menu_items['all']['profile'] = array(
		'url'   => $dashboard_page . '?tab=profile',
		'icon'  => '<span class="material-symbols-outlined">account_circle</span>',
		'label' => esc_html__( 'My Profile', 'ld-dashboard' ),
	);

	$menu_items['all']['enrolled-courses'] = array(
		'url'   => $dashboard_page . '?tab=enrolled-courses',
		'icon'  => '<span class="material-symbols-outlined">school</span>',
		'label' => sprintf( '%1s %2s', esc_html__( 'Enrolled', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'courses' ) ),
	);

	$menu_items['all']['my-quiz-attempts'] = array(
		'url'   => $dashboard_page . '?tab=my-quiz-attempts',
		'icon'  => '<span class="material-symbols-outlined">lan</span>',
		'label' => sprintf( '%1s %2s %3s', esc_html__( 'My', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'quiz' ), esc_html__( 'Attempts', 'ld-dashboard' ) ),
	);
	if ( $enable_live_feed ) {
		$menu_items['all']['my-activity'] = array(
			'url'   => $dashboard_page . '?tab=my-activity',
			'icon'  => '<span class="material-symbols-outlined">notification_important</span>',
			'label' => sprintf( '%1s %2s %3s', esc_html__( 'My', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'course' ), esc_html__( 'Activity', 'ld-dashboard' ) ),
		);
	}
	if ( $ld_dashboard_general_settings['enable-announcements'] == 1 ) {
		$menu_items['all']['announcements'] = array(
			'url'   => $dashboard_page . '?tab=announcements',
			'icon'  => '<span class="material-symbols-outlined">campaign</span>',
			'label' => esc_html__( 'Announcements', 'ld-dashboard' ),
		);
	}
	$theme_locations = get_nav_menu_locations();
	if ( isset( $theme_locations['ld-dashboard-profile-menu'] ) ) {
		$menu_obj = get_term( $theme_locations['ld-dashboard-profile-menu'], 'nav_menu' );
		if ( is_object( $menu_obj ) && isset( $menu_obj->term_id ) ) {
			$custom_menu_items = wp_get_nav_menu_items( $menu_obj->term_id );
			if ( ! empty( $custom_menu_items ) ) {
				foreach ( $custom_menu_items as $menu_item ) :
					$menu_items['all'][ $menu_item->post_name ] = array(
						'url'   => $menu_item->url,
						'icon'  => '<img src="' . esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/icons/external-link-alt.svg">',
						'label' => $menu_item->title,
					);
				endforeach;
			}
		}
	}

	if ( learndash_is_admin_user( $user_id ) || ld_can_user_manage_courses() || ld_dashboard_is_instructor_group_leader() ) {
		$menu_items['instructor']['my-courses']   = array(
			'url'   => $dashboard_page . '?tab=my-courses',
			'icon'  => '<span class="material-symbols-outlined">local_library</span>',
			'label' => sprintf( esc_html__( 'My %s', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'courses' ) ),
		);
		$menu_items['instructor']['my-lessons']   = array(
			'url'   => $dashboard_page . '?tab=my-lessons',
			'icon'  => '<span class="material-symbols-outlined">cast_for_education</span>',
			'label' => sprintf( esc_html__( 'My %s', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'lessons' ) ),
		);
		$menu_items['instructor']['my-topics']    = array(
			'url'   => $dashboard_page . '?tab=my-topics',
			'icon'  => '<span class="material-symbols-outlined">topic</span>',
			'label' => sprintf( esc_html__( 'My %s', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'topics' ) ),
		);
		$menu_items['instructor']['my-quizzes']   = array(
			'url'   => $dashboard_page . '?tab=my-quizzes',
			'icon'  => '<span class="material-symbols-outlined">extension</span>',
			'label' => sprintf( esc_html__( 'My %s', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'quizzes' ) ),
		);
		$menu_items['instructor']['my-questions'] = array(
			'url'   => $dashboard_page . '?tab=my-questions',
			'icon'  => '<span class="material-symbols-outlined">live_help</span>',
			'label' => sprintf( esc_html__( 'My %s', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'questions' ) ),
		);
		$menu_items['instructor']['assignments']  = array(
			'url'   => $dashboard_page . '?tab=assignments',
			'icon'  => '<span class="material-symbols-outlined">rate_review</span>',
			'label' => esc_html__( 'Assignments', 'ld-dashboard' ),
		);
		if ( isset( $ld_dashboard_general_settings['enable-zoom'] ) && 1 == $ld_dashboard_general_settings['enable-zoom'] && apply_filters( 'ld_dashboard_zoom_meetings_tab', true ) ) {
			$menu_items['instructor']['meetings'] = array(
				'url'   => $dashboard_page . '?tab=meetings',
				'icon'  => '<span class="material-symbols-outlined">video_camera_front</span>',
				'label' => esc_html__( 'Meetings', 'ld-dashboard' ),
			);
		}
		if ( ld_if_commission_enabled() ) {
			$menu_items['instructor']['withdrawal'] = array(
				'url'   => $dashboard_page . '?tab=withdrawal',
				'icon'  => '<span class="material-symbols-outlined">account_balance_wallet</span>',
				'label' => esc_html__( 'Withdrawals', 'ld-dashboard' ),
			);
		}
		if ( $enable_instructor_earning_logs == 1 ) {
			$menu_items['instructor']['earnings'] = array(
				'url'   => $dashboard_page . '?tab=earnings',
				'icon'  => '<span class="material-symbols-outlined">receipt_long</span>',
				'label' => esc_html__( 'Earning Logs', 'ld-dashboard' ),
			);
		}
		$menu_items['instructor']['certificates'] = array(
			'url'   => $dashboard_page . '?tab=certificates',
			'icon'  => '<span class="material-symbols-outlined">workspace_premium</span>',
			'label' => esc_html__( 'Certificates', 'ld-dashboard' ),
		);
		if ( $ld_dashboard_general_settings['enable-announcements'] == 1 ) {
			$menu_items['instructor']['my-announcements'] = array(
				'url'   => $dashboard_page . '?tab=my-announcements',
				'icon'  => '<span class="material-symbols-outlined">volume_up</span>',
				'label' => esc_html__( 'My Announcements', 'ld-dashboard' ),
			);
		}
	}
	if ( learndash_is_admin_user( $user_id ) || in_array( 'ld_instructor', (array) $current_user->roles ) || learndash_is_group_leader_user( $user_id ) ) {
		$menu_items['instructor']['groups'] = array(
			'url'   => $dashboard_page . '?tab=groups',
			'icon'  => '<span class="material-symbols-outlined">groups</span>',
			'label' => LearnDash_Custom_Label::get_label( 'groups' ),
		);
	}
	$menu_items['instructor']['quiz-attempts'] = array(
		'url'   => $dashboard_page . '?tab=quiz-attempts',
		'icon'  => '<span class="material-symbols-outlined">quiz</span>',
		'label' => sprintf( '%1s %2s', LearnDash_Custom_Label::get_label( 'quiz' ), esc_html__( 'Attempts', 'ld-dashboard' ) ),
	);
	if ( learndash_is_admin_user( $user_id ) || ( $enable_live_feed && ( learndash_is_group_leader_user( $user_id ) || in_array( 'ld_instructor', (array) $current_user->roles ) ) ) ) {
		$menu_items['instructor']['activity'] = array(
			'url'   => $dashboard_page . '?tab=activity',
			'icon'  => '<span class="material-symbols-outlined">notifications_active</span>',
			'label' => sprintf( esc_html__( '%s Activity', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'course' ) ),
		);
	}
	if ( isset( $ld_dashboard_general_settings['enable-email-integration'] ) && $ld_dashboard_general_settings['enable-email-integration'] == 1 ) {
		$menu_items['instructor']['notification'] = array(
			'url'   => $dashboard_page . '?tab=notification',
			'icon'  => '<span class="material-symbols-outlined">outgoing_mail</span>',
			'label' => esc_html__( 'Send Mail', 'ld-dashboard' ),
		);
	}
	if ( isset( $ld_dashboard_general_settings['enable-messaging-integration'] ) && $ld_dashboard_general_settings['enable-messaging-integration'] == 1 && class_exists( 'BuddyPress' ) && bp_is_active( 'messages' ) ) {
		$menu_items['instructor']['private-messages'] = array(
			'url'   => $dashboard_page . '?tab=private-messages',
			'icon'  => '<span class="material-symbols-outlined">near_me</span>',
			'label' => esc_html__( 'Private Messages', 'ld-dashboard' ),
		);
	}
	$menu_items['both']['settings'] = array(
		'url'   => $dashboard_page . '?tab=settings',
		'icon'  => '<span class="material-symbols-outlined">manage_accounts</span>',
		'label' => esc_html__( 'Settings', 'ld-dashboard' ),
	);
	$menu_items['both']['logout']   = array(
		'url'   => wp_logout_url( get_the_permalink() ),
		'icon'  => '<span class="material-symbols-outlined">logout</span>',
		'label' => __( 'Logout', 'ld-dashboard' ),
	);

	if ( ! learndash_is_group_leader_user( $user_id ) && ! learndash_is_admin_user( $user_id ) && ! in_array( 'ld_instructor', (array) $current_user->roles ) ) {
		unset( $menu_items['instructor'] );
	}
	return apply_filters( 'learndash_dashboard_nav_menu', $menu_items );
}

/**
 * Ld_dashboard_can_user_start_meeting
 *
 * @param  mixed $meeting_id meeting id.
 */
function ld_dashboard_can_user_start_meeting( $meeting_id ) {
	$current_user               = wp_get_current_user();
	$function_obj               = Ld_Dashboard_Functions::instance();
	$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
	$settings                   = $ld_dashboard_settings_data['zoom_meeting_settings'];
	$meeting_post               = get_post( $meeting_id );
	$using_admin_credentials    = get_post_meta( $meeting_id, 'using_admin_credentials', true );
	$is_author                  = ( $meeting_post->post_author == $current_user->ID ) ? true : false;
	if ( in_array( 'administrator', $current_user->roles ) && 'yes' === $using_admin_credentials ) {
		$is_author = true;
	}
	if ( $is_author && in_array( 'ld_instructor', $current_user->roles ) && 'yes' === $using_admin_credentials ) {
		if ( empty( $settings['zoom-co-hosts'] ) || ( ! empty( $settings['zoom-co-hosts'] ) && ! in_array( $current_user->ID, $settings['zoom-co-hosts'] ) ) ) {
			$is_author = false;
		}
	}
	return $is_author;
}

function ld_group_leader_has_admin_cap() {
	$current_user = wp_get_current_user();
	if ( is_multisite() ) {
		$group_settings = get_site_option( 'learndash_groups_group_leader_user' );
	} else {
		$group_settings = get_option( 'learndash_groups_group_leader_user' );
	}
	if ( learndash_is_group_leader_user( $current_user->ID ) && isset( $group_settings['manage_courses_capabilities'] ) && 'advanced' === $group_settings['manage_courses_capabilities'] ) {
		return true;
	}
	return false;
}

function ld_can_user_manage_courses() {
	$current_user = wp_get_current_user();
	if ( is_multisite() ) {
		$group_settings = get_site_option( 'learndash_groups_group_leader_user' );
	} else {
		$group_settings = get_option( 'learndash_groups_group_leader_user' );
	}
	if ( in_array( 'ld_instructor', $current_user->roles ) ) {
		return true;
	}
	if ( learndash_is_group_leader_user( $current_user->ID ) && isset( $group_settings['manage_courses_enabled'] ) && 'yes' == $group_settings['manage_courses_enabled'] ) {
		return true;
	}
	return false;
}

function ld_dashboard_check_course_transaction_exists( $user_id, $course_id ) {
	$course_price       = learndash_get_setting( $course_id, 'course_price' );
	$course_access_type = learndash_get_setting( $course_id, 'course_price_type' );
	$settinf            = learndash_get_setting( $course_id );
	$key                = 'course_' . $course_id . '_access_from';

	$payed             = false;
	$transaction_query = array(
		'post_type'   => 'sfwd-transactions',
		'post_status' => 'publish',
		'meta_query'  => array(
			array(
				'key'     => 'user_id',
				'value'   => $user_id,
				'compare' => '==',
			),
			array(
				'key'     => 'course_id',
				'value'   => $course_id,
				'compare' => '==',
			),
		),
	);

	$transactions = get_posts( $transaction_query );

	if ( 'closed' !== $course_access_type && is_array( $transactions ) && ! empty( $transactions ) ) {

		$payed               = true;
		list( $transaction ) = $transactions;
		$payment_processor   = get_post_meta( $transaction->ID, 'ld_payment_processor', true );

	} elseif ( 'closed' === $course_access_type ) {

		$product_url = isset( $settinf['custom_button_url'] ) ? $settinf['custom_button_url'] : '';
		if ( '' !== $product_url ) {
			$product_slugs = explode( '/', $product_url );
			$count         = count( $product_slugs ) - 1;
			$slug          = '';
			while ( '' === $slug ) {
				if ( isset( $product_slugs[ $count ] ) && '' !== $product_slugs[ $count ] ) {
					$slug = $product_slugs[ $count ];
				}
				$count--;
			}

			$args     = array(
				'name'        => $slug,
				'post_type'   => 'product',
				'post_status' => 'publish',
				'numberposts' => 1,
			);
			$products = get_posts( $args );
			if ( is_array( $products ) && ! empty( $products ) ) {
				list( $product ) = $products;
				$order_args      = array(
					'customer_id' => $user_id,
					'type'        => 'shop_order',
					'limit'       => - 1,
				);
				$orders          = wc_get_orders( $order_args );
				if ( is_array( $orders ) && ! empty( $orders ) ) {
					foreach ( $orders as $order ) {
						if ( $payed ) {
							break;
						}
						$current_order = wc_get_order( $order->get_id() );
						foreach ( $current_order->get_items() as $item_key => $item_values ) {
							$order_product_id = $item_values->get_product_id();
							if ( $product->ID === $order_product_id ) {
								$payed = true;
								break;
							}
						}
					}
				}
			}
		}
	}
	return $payed;
}

/**
 * Function to find source of commission for admin.
 *
 * @since  1.0.0
 * @author Wbcom Designs
 */
function ld_if_instructor_course_commission_set( $instrcutor_id ) {
	$value = get_user_meta( $instrcutor_id, 'instructor-course-commission', true );
	if ( $value ) {
		return apply_filters( 'ld_if_instructor_course_commission_set', (int) $value );
	}
	return false;
}

function ld_bptodo_get_course_list( $course_id, $user_id, $group_id, $can_modify ) {
	$args               = array(
		'post_type'      => 'bp-todo',
		'post_status'    => 'publish',
		'author'         => $user_id,
		'posts_per_page' => -1,
		'meta_key'       => 'todo_group_id',
		'meta_value'     => $group_id,
	);
	$todos              = get_posts( $args );
	$todo_list          = array();
	$all_todo_count     = 0;
	$all_completed_todo = 0;
	$all_remaining_todo = 0;
	$completed_todo_ids = array();
	foreach ( $todos as $todo ) {
		$curr_date   = date_create( date( 'Y-m-d' ) );
		$due_date    = date_create( get_post_meta( $todo->ID, 'todo_due_date', true ) );
		$todo_status = get_post_meta( $todo->ID, 'todo_status', true );
		$diff        = date_diff( $curr_date, $due_date );
		$diff_days   = $diff->format( '%R%a' );
		if ( $diff_days < 0 ) {
			$todo_list['past'][] = $todo->ID;
		} elseif ( 0 == $diff_days ) {
			$todo_list['today'][] = $todo->ID;
		} elseif ( 1 == $diff_days ) {
			$todo_list['tomorrow'][] = $todo->ID;
		} else {
			$todo_list['future'][] = $todo->ID;
		}
	}
	return apply_filters( 'alter_ld_bptodo_get_course_list', $todo_list );
}

function ld_generate_tbody_for_ld_course_todos( $todo_list, $can_modify, $group_id ) {
	global $bptodo;
	$profile_menu_slug = $bptodo->profile_menu_slug;

	$group       = groups_get_group( array( 'group_id' => $group_id ) );
	$groups_link = bp_get_group_permalink( $group );
	$admin_link  = trailingslashit( $groups_link . $profile_menu_slug );

	$all_remaining_todo = 0;
	$all_completed_todo = 0;
	ob_start();
	?>

	<!-- PAST TASKS -->
	<?php
	if ( ! empty( $todo_list['past'] ) ) {
		$count = 1;
		foreach ( $todo_list['past'] as $tid ) {
			?>
			<?php
			$todo          = get_post( $tid );
			$todo_title    = $todo->post_title;
			$todo_edit_url = $admin_link . '/add?args=' . $tid;

			$todo_status    = get_post_meta( $todo->ID, 'todo_status', true );
			$todo_priority  = get_post_meta( $todo->ID, 'todo_priority', true );
			$due_date_str   = $due_date_td_class = '';
			$curr_date      = date_create( date( 'Y-m-d' ) );
			$due_date       = date_create( get_post_meta( $todo->ID, 'todo_due_date', true ) );
			$diff           = date_diff( $curr_date, $due_date );
			$diff_days      = $diff->format( '%R%a' );
			$priority_class = '';
			if ( $diff_days < 0 ) {
				$due_date_str      = sprintf( esc_html__( 'Expired %d days ago!', 'wb-todo' ), abs( $diff_days ) );
				$due_date_td_class = 'bptodo-expired';
			} elseif ( 0 == $diff_days ) {
				$due_date_str      = esc_html__( 'Today is the last day to complete. Hurry Up!', 'wb-todo' );
				$due_date_td_class = 'bptodo-expires-today';
			} else {
				if ( $diff_days == 1 ) {
					$day_string = __( 'day', 'wb-todo' );
				} else {
					$day_string = __( 'days', 'wb-todo' );
				}
				$due_date_str = sprintf( esc_html__( '%1$d %2$s left to complete the task!', 'wb-todo' ), abs( $diff_days ), $day_string );
										// $all_remaining_todo++;
			}
			if ( 'complete' == $todo_status ) {
				$due_date_str      = esc_html__( 'Completed!', 'wb-todo' );
				$due_date_td_class = '';
				$all_completed_todo++;
			}
			if ( ! empty( $todo_priority ) ) {
				if ( 'critical' == $todo_priority ) {
					$priority_class = 'bptodo-priority-critical';
					$priority_text  = esc_html__( 'Critical', 'wb-todo' );
				} elseif ( 'high' == $todo_priority ) {
					$priority_class = 'bptodo-priority-high';
					$priority_text  = esc_html__( 'High', 'wb-todo' );
				} else {
					$priority_class = 'bptodo-priority-normal';
					$priority_text  = esc_html__( 'Normal', 'wb-todo' );
				}
			}
			?>
			<tr id="bptodo-row-<?php echo esc_attr( $tid ); ?>">
				<td class="bptodo-priority"><span class="<?php echo esc_attr( $priority_class ); ?>"><?php echo $priority_text; ?></span></td>
				<td class="
				<?php
				if ( 'complete' == $todo_status ) {
					echo esc_attr( $class );
				}
				?>
				"><?php echo esc_html( $todo_title ); ?></td>
				<td class="
				<?php
				echo esc_attr( $due_date_td_class );
				if ( 'complete' == $todo_status ) {
					echo esc_attr( $class );
				}
				?>
				"><?php echo $due_date_str; ?></td>
				<td class="bp-to-do-actions">
					<ul>
						<?php if ( $can_modify ) { ?>
							<li><a href="javascript:void(0);" class="bptodo-remove-todo" data-tid="<?php echo esc_attr( $tid ); ?>"    title="<?php echo sprintf( esc_html__( 'Remove: %s', 'wb-todo' ), $todo_title ); ?>"
								><i class="fa fa-times"></i></a></li>
							<?php } ?>
							<?php if ( 'complete' !== $todo_status ) { ?>
								<?php if ( $can_modify ) { ?>
									<li><a href="<?php echo esc_attr( $todo_edit_url ); ?>" title="<?php echo sprintf( esc_html__( 'Edit: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-edit"></i></a></li>
								<?php } ?>
								<li id="bptodo-complete-li-<?php echo esc_attr( $tid ); ?>"><a href="javascript:void(0);" class="bptodo-complete-todo" data-tid="<?php echo esc_attr( $tid ); ?>" title="<?php echo sprintf( esc_html__( 'Complete: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-check"></i></a></li>
							<?php } else { ?>
								<li><a href="javascript:void(0);" class="bptodo-undo-complete-todo" data-tid="<?php echo esc_attr( $tid ); ?>" title="<?php echo sprintf( esc_html__( 'Undo Complete: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-undo"></i></a></li>
							<?php } ?>
						</ul>
					</td>
				</tr>
			<?php } ?>

		<?php } ?>

		<?php if ( ! empty( $todo_list['today'] ) ) { ?>
			<?php $count = 1; ?>
			<?php foreach ( $todo_list['today'] as $tid ) { ?>
				<?php
				$todo          = get_post( $tid );
				$todo_title    = $todo->post_title;
				$todo_edit_url = $admin_link . '/add?args=' . $tid;

				$todo_status   = get_post_meta( $todo->ID, 'todo_status', true );
				$todo_priority = get_post_meta( $todo->ID, 'todo_priority', true );
				$due_date_str  = $due_date_td_class  = '';
				$curr_date     = date_create( date( 'Y-m-d' ) );
				$due_date      = date_create( get_post_meta( $todo->ID, 'todo_due_date', true ) );
				$diff          = date_diff( $curr_date, $due_date );
				$diff_days     = $diff->format( '%R%a' );
				if ( $diff_days < 0 ) {
					$due_date_str      = sprintf( esc_html__( 'Expired %d days ago!', 'wb-todo' ), abs( $diff_days ) );
					$due_date_td_class = 'bptodo-expired';
				} elseif ( 0 == $diff_days ) {
					$due_date_str      = esc_html__( 'Today is the last day to complete. Hurry Up!', 'wb-todo' );
					$due_date_td_class = 'bptodo-expires-today';
					$all_remaining_todo++;
				} else {
					if ( $diff_days == 1 ) {
						$day_string = esc_html__( 'day', 'wb-todo' );
					} else {
						$day_string = esc_html__( 'days', 'wb-todo' );
					}
					$due_date_str = sprintf( esc_html__( '%1$d %2$s left to complete the task!', 'wb-todo' ), abs( $diff_days ), $day_string );
					$all_remaining_todo++;
				}
				if ( 'complete' == $todo_status ) {
					$due_date_str      = esc_html__( 'Completed!', 'wb-todo' );
					$due_date_td_class = '';
					$all_completed_todo++;
				}
				if ( ! empty( $todo_priority ) ) {
					if ( 'critical' == $todo_priority ) {
						$priority_class = 'bptodo-priority-critical';
						$priority_text  = esc_html__( 'Critical', 'wb-todo' );
					} elseif ( 'high' == $todo_priority ) {
						$priority_class = 'bptodo-priority-high';
						$priority_text  = esc_html__( 'High', 'wb-todo' );
					} else {
						$priority_class = 'bptodo-priority-normal';
						$priority_text  = esc_html__( 'Normal', 'wb-todo' );
					}
				}
				?>
				<tr id="bptodo-row-<?php echo esc_attr( $tid ); ?>">
					<td class="bptodo-priority"><span class="<?php echo esc_attr( $priority_class ); ?>"><?php echo $priority_text; ?></span></td>
					<td class="
					<?php
					if ( 'complete' == $todo_status ) {
						echo esc_attr( $class );
					}
					?>
					"><?php echo esc_html( $todo_title ); ?></td>
					<td class="
					<?php
					echo esc_attr( $due_date_td_class );
					if ( 'complete' == $todo_status ) {
						echo esc_attr( $class );
					}
					?>
					"><?php echo $due_date_str; ?></td>
					<td class="bp-to-do-actions">
						<ul>
							<?php if ( $can_modify ) { ?>
								<li><a href="javascript:void(0);" class="bptodo-remove-todo" data-tid="<?php echo esc_attr( $tid ); ?>" title="<?php echo sprintf( esc_html__( 'Remove: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-times"></i></a></li>
							<?php } ?>
							<?php if ( 'complete' !== $todo_status ) { ?>
								<?php if ( $can_modify ) { ?>
									<li><a href="<?php echo esc_attr( $todo_edit_url ); ?>" title="<?php echo sprintf( esc_html__( 'Edit: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-edit"></i></a></li>
								<?php } ?>
								<li id="bptodo-complete-li-<?php echo esc_attr( $tid ); ?>"><a href="javascript:void(0);" class="bptodo-complete-todo" data-tid="<?php echo esc_attr( $tid ); ?>" title="<?php echo sprintf( esc_html__( 'Complete: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-check"></i></a></li>
							<?php } else { ?>
								<li><a href="javascript:void(0);" class="bptodo-undo-complete-todo" data-tid="<?php echo esc_attr( $tid ); ?>" title="<?php echo sprintf( esc_html__( 'Undo Complete: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-undo"></i></a></li>
							<?php } ?>
						</ul>
					</td>
				</tr>
			<?php } ?>

		<?php } ?>
		<!-- TASKS FOR TOMORROW -->
		<?php if ( ! empty( $todo_list['tomorrow'] ) ) { ?>

			<?php $count = 1; ?>
			<?php foreach ( $todo_list['tomorrow'] as $tid ) { ?>
				<?php
				$todo          = get_post( $tid );
				$todo_title    = $todo->post_title;
				$todo_edit_url = $admin_link . '/add?args=' . $tid;

				$todo_status   = get_post_meta( $todo->ID, 'todo_status', true );
				$todo_priority = get_post_meta( $todo->ID, 'todo_priority', true );
				$due_date_str  = $due_date_td_class = '';
				$curr_date     = date_create( date( 'Y-m-d' ) );
				$due_date      = date_create( get_post_meta( $todo->ID, 'todo_due_date', true ) );
				$diff          = date_diff( $curr_date, $due_date );
				$diff_days     = $diff->format( '%R%a' );
				if ( $diff_days < 0 ) {
					$due_date_str      = sprintf( esc_html__( 'Expired %d days ago!', 'wb-todo' ), abs( $diff_days ) );
					$due_date_td_class = 'bptodo-expired';
				} elseif ( 0 == $diff_days ) {
					$due_date_str      = esc_html__( 'Today is the last day to complete. Hurry Up!', 'wb-todo' );
					$due_date_td_class = 'bptodo-expires-today';
					$all_remaining_todo++;
				} else {
					if ( $diff_days == 1 ) {
						$day_string = esc_html__( 'day', 'wb-todo' );
					} else {
						$day_string = esc_html__( 'days', 'wb-todo' );
					}
					$due_date_str = sprintf( esc_html__( '%1$d %2$s left to complete the task!', 'wb-todo' ), abs( $diff_days ), $day_string );
					$all_remaining_todo++;
				}
				if ( 'complete' == $todo_status ) {
					$due_date_str      = esc_html__( 'Completed!', 'wb-todo' );
					$due_date_td_class = '';
					$all_completed_todo++;
				}
				if ( ! empty( $todo_priority ) ) {
					if ( 'critical' == $todo_priority ) {
						$priority_class = 'bptodo-priority-critical';
						$priority_text  = esc_html__( 'Critical', 'wb-todo' );
					} elseif ( 'high' == $todo_priority ) {
						$priority_class = 'bptodo-priority-high';
						$priority_text  = esc_html__( 'High', 'wb-todo' );
					} else {
						$priority_class = 'bptodo-priority-normal';
						$priority_text  = esc_html__( 'Normal', 'wb-todo' );
					}
				}
				?>
				<tr id="bptodo-row-<?php echo esc_attr( $tid ); ?>">
					<td class="bptodo-priority"><span class="<?php echo esc_attr( $priority_class ); ?>"><?php echo $priority_text; ?></span></td>
					<td class="
					<?php
					if ( 'complete' == $todo_status ) {
						echo esc_attr( $class );
					}
					?>
					"><?php echo esc_html( $todo_title ); ?></td>
					<td class="
					<?php
					echo esc_attr( $due_date_td_class );
					if ( 'complete' == $todo_status ) {
						echo esc_attr( $class );
					}
					?>
					"><?php echo $due_date_str; ?></td>
					<td class="bp-to-do-actions">
						<ul>
							<?php if ( $can_modify ) { ?>
								<li><a href="javascript:void(0);" class="bptodo-remove-todo" data-tid="<?php echo esc_attr( $tid ); ?>" title="<?php echo sprintf( esc_html__( 'Remove: %s ', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-times"></i></a></li>
							<?php } ?>
							<?php if ( 'complete' !== $todo_status ) { ?>
								<?php if ( $can_modify ) { ?>
									<li><a href="<?php echo esc_attr( $todo_edit_url ); ?>" title="<?php echo sprintf( esc_html__( 'Edit: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-edit"></i></a></li>
								<?php } ?>
								<li id="bptodo-complete-li-<?php echo esc_attr( $tid ); ?>"><a href="javascript:void(0);" class="bptodo-complete-todo" data-tid="<?php echo esc_attr( $tid ); ?>" title="<?php echo sprintf( esc_html__( 'Complete: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-check"></i></a></li>
							<?php } else { ?>
								<li><a href="javascript:void(0);" class="bptodo-undo-complete-todo" data-tid="<?php echo esc_attr( $tid ); ?>" title="<?php echo sprintf( esc_html__( 'Undo Complete: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-undo"></i></a></li>
							<?php } ?>
						</ul>
					</td>
				</tr>
			<?php } ?>

		<?php } ?>

		<!-- TASKS FOR SOMEDAY. -->
		<?php if ( ! empty( $todo_list['future'] ) ) { ?>
			<?php $count = 1; ?>
			<?php foreach ( $todo_list['future'] as $tid ) { ?>
				<?php
				$todo          = get_post( $tid );
				$todo_title    = $todo->post_title;
				$todo_edit_url = $admin_link . '/add?args=' . $tid;

				$todo_status   = get_post_meta( $todo->ID, 'todo_status', true );
				$todo_priority = get_post_meta( $todo->ID, 'todo_priority', true );
				$due_date_str  = $due_date_td_class    = '';
				$curr_date     = date_create( date( 'Y-m-d' ) );
				$due_date      = date_create( get_post_meta( $todo->ID, 'todo_due_date', true ) );
				$diff          = date_diff( $curr_date, $due_date );
				$diff_days     = $diff->format( '%R%a' );
				if ( $diff_days < 0 ) {
					$due_date_str      = sprintf( esc_html__( 'Expired %d days ago!', 'wb-todo' ), abs( $diff_days ) );
					$due_date_td_class = 'bptodo-expired';
				} elseif ( 0 == $diff_days ) {
					$due_date_str      = esc_html__( 'Today is the last day to complete. Hurry Up!', 'wb-todo' );
					$due_date_td_class = 'bptodo-expires-today';
					$all_remaining_todo++;
				} else {
					if ( $diff_days == 1 ) {
						$day_string = esc_html__( 'day', 'wb-todo' );
					} else {
						$day_string = esc_html__( 'days', 'wb-todo' );
					}
					$due_date_str = sprintf( esc_html__( '%1$d %2$s left to complete the task!', 'wb-todo' ), abs( $diff_days ), $day_string );
					$all_remaining_todo++;
				}
				if ( 'complete' == $todo_status ) {
					$due_date_str      = esc_html__( 'Completed!', 'wb-todo' );
					$due_date_td_class = '';
					$all_completed_todo++;
				}
				if ( ! empty( $todo_priority ) ) {
					if ( 'critical' == $todo_priority ) {
						$priority_class = 'bptodo-priority-critical';
						$priority_text  = esc_html__( 'Critical', 'wb-todo' );
					} elseif ( 'high' == $todo_priority ) {
						$priority_class = 'bptodo-priority-high';
						$priority_text  = esc_html__( 'High', 'wb-todo' );
					} else {
						$priority_class = 'bptodo-priority-normal';
						$priority_text  = esc_html__( 'Normal', 'wb-todo' );
					}
				}
				?>
				<tr id="bptodo-row-<?php echo esc_attr( $tid ); ?>">
					<td class="bptodo-priority"><span class="<?php echo esc_attr( $priority_class ); ?>"><?php echo $priority_text; ?></span></td>
					<td class="
					<?php
					if ( 'complete' == $todo_status ) {
						echo esc_attr( $class );
					}
					?>
					"><?php echo esc_html( $todo_title ); ?></td>
					<td class="
					<?php
					echo esc_attr( $due_date_td_class );
					if ( 'complete' == $todo_status ) {
						echo esc_attr( $class );
					}
					?>
					"><?php echo $due_date_str; ?></td>
					<td class="bp-to-do-actions">
						<ul>
							<?php if ( $can_modify ) { ?>
								<li><a href="javascript:void(0);" class="bptodo-remove-todo" data-tid="<?php echo esc_attr( $tid ); ?>" title="<?php echo sprintf( esc_html__( 'Remove: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-times"></i></a></li>
							<?php } ?>
							<?php if ( 'complete' != $todo_status ) { ?>
								<?php if ( $can_modify ) { ?>
									<li><a href="<?php echo esc_attr( $todo_edit_url ); ?>" title="<?php echo sprintf( esc_html__( 'Edit: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-edit"></i></a></li>
								<?php } ?>
								<li id="bptodo-complete-li-<?php echo esc_attr( $tid ); ?>"><a href="javascript:void(0);" class="bptodo-complete-todo" data-tid="<?php echo esc_attr( $tid ); ?>" title="<?php echo sprintf( esc_html__( 'Complete: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-check"></i></a></li>
							<?php } else { ?>
								<li><a href="javascript:void(0);" class="bptodo-undo-complete-todo" data-tid="<?php echo esc_attr( $tid ); ?>" title="<?php echo sprintf( esc_html__( 'Undo Complete: %s', 'wb-todo' ), $todo_title ); ?>"><i class="fa fa-undo"></i></a></li>
							<?php } ?>
						</ul>
					</td>
				</tr>
			<?php } ?>

		<?php } ?>
	<?php
	$tbody_html = ob_get_clean();
	return apply_filters( 'alter_ld_generate_tbody_for_ld_course_todos', $tbody_html );
}

function ld_generate_course_group_to_do_list_table( $todo_tbody ) {
	$tbody  = '<tbody>';
	$tbody .= $todo_tbody;
	$tbody .= '</tbody>';

	$thead  = '<thead>';
	$thead .= '<tr>';
	$thead .= '<th>' . __( 'Priority', 'ld-dashboard' ) . '</th>';
	$thead .= '<th>' . __( 'Task', 'ld-dashboard' ) . '</th>';
	$thead .= '<th>' . __( 'Due Date', 'ld-dashboard' ) . '</th>';
	$thead .= '<th>' . __( 'Actions', 'ld-dashboard' ) . '</th>';
	$thead .= '</tr>';
	$thead .= '</thead>';

	$html  = '';
	$html .= '<div id="bptodo-all">';
	$html .= '<div class="bptodo-admin-row">';
	$html .= '<div class="todo-panel">';
	$html .= '<div class="todo-detail">';
	$html .= '<table class="bp-todo-reminder">';
	$html .= $thead;
	$html .= $tbody;
	$html .= '</table>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	return $html;
}

function ld_is_envt_ready_for_to_do() {
	if ( class_exists( 'BuddyPress' ) && bp_is_active( 'groups' ) && class_exists( 'Bptodo_Profile_Menu' ) ) {
		return true;
	}
	return false;
}

/**
 * Function to find if learndash groups is enabled.
 *
 * @since  1.0.0
 * @author Wbcom Designs
 */
function ld_if_display_to_do_enabled() {
	$function_obj               = Ld_Dashboard_Functions::instance();
	$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
	$settings                   = $ld_dashboard_settings_data['general_settings'];
	$ld_dashboard_integration   = $ld_dashboard_settings_data['ld_dashboard_integration'];
	$display_todo               = ( isset( $ld_dashboard_integration['display-to-do'] ) ) ? $ld_dashboard_integration['display-to-do'] : '';
	if ( $display_todo == '1' && class_exists( 'BuddyPress' ) && function_exists( 'bp_is_active' ) && bp_is_active( 'groups' ) && class_exists( 'Bptodo_Profile_Menu' ) ) {
		return apply_filters( 'ld_if_display_to_do_enabled', true );
	}
	return false;
}

if ( ! function_exists( 'ld_todo_get_user_average_todos' ) ) {
	/**
	 * Display average todo percentage of each member
	 *
	 * @param  integer $todoID  The id of post(TO DO)
	 * @return float         Average percentage of todo
	 */
	function ld_todo_get_user_average_todos( $todoID ) {
		global $bp, $post;
		$group_id        = get_post_meta( $todoID, 'todo_group_id', true );
		$todo_primary_id = get_post_meta( $todoID, 'todo_primary_id', true );

		$total_args = array(
			'post_type'      => 'bp-todo',
			'posts_per_page' => -1,
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'todo_group_id',
					'value'   => $group_id,
					'compare' => '=',
				),
				array(
					'key'     => 'todo_primary_id',
					'value'   => $todo_primary_id,
					'compare' => '=',
				),
			),
		);

		$todos       = get_posts( $total_args );
		$total_count = 0;
		if ( ! empty( $todos ) ) {
			$total_count = count( $todos );
		}

		$args = array(
			'group_id'            => $group_id,
			'exclude_admins_mods' => true,
		);

		$group_members_result = groups_get_group_members( $args );
		$group_members_ids    = array();

		foreach ( $group_members_result['members'] as $member ) {
			$group_members_ids[] = $member->ID;
		}

		$member_count = count( $group_members_ids );

		$completed_count = ld_todo_completed_todo_count( $group_id, $todo_primary_id );

		$avg_rating = 0;

		if ( ! empty( $member_count ) ) {
			$avg_rating = ( $completed_count * 100 ) / $member_count;
			$avg_rating = round( $avg_rating, 2 ) . '% ';
		}
		return $avg_rating;

		wp_reset_postdata();

	}
}

if ( ! function_exists( 'ld_todo_completed_todo_count' ) ) {
	/**
	 * Get the completed to do count
	 *
	 * @param  [int] $group_id        Accosiated group id
	 * @param  [int] $todo_primary_id Primary to-do id
	 * @return [float]                Count of completed to-dos
	 */
	function ld_todo_completed_todo_count( $group_id, $todo_primary_id ) {
		$associated_todo = get_post_meta( $todo_primary_id, 'botodo_associated_todo', true );

		$completed_args  = array(
			'post_type'      => 'bp-todo',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => 'todo_status',
					'value'   => 'complete',
					'compare' => '=',
				),
				array(
					'key'     => 'todo_group_id',
					'value'   => $group_id,
					'compare' => '=',
				),
				array(
					'key'     => 'todo_primary_id',
					'value'   => $todo_primary_id,
					'compare' => '=',
				),
			),
		);
		$completed_todos = get_posts( $completed_args );
		$completed_count = 0;
		if ( ! empty( $completed_todos ) ) {
			$completed_count = count( $completed_todos );
		}
		return $completed_count;
		wp_reset_postdata();
	}
}

if ( ! function_exists( 'ld_dashboard_get_course_excerpt' ) ) {
	function ld_dashboard_get_course_excerpt( $content, $num_words = 50 ) {

		$original_text = $content;
		$num_words     = (int) $num_words;

		/*
		 * translators: If your word count is based on single characters (e.g. East Asian characters),
		 * enter 'characters_excluding_spaces' or 'characters_including_spaces'. Otherwise, enter 'words'.
		 * Do not translate into your own language.
		 */
		if ( strpos( _x( 'words', 'Word count type. Do not translate!', 'ld-dashboard' ), 'characters' ) === 0 && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
			$content = trim( preg_replace( "/[\n\r\t ]+/", ' ', $content ), ' ' );
			preg_match_all( '/./u', $content, $words_array );
			$words_array = array_slice( $words_array[0], 0, $num_words + 1 );
			$sep         = '';
		} else {
			$words_array = preg_split( "/[\n\r\t ]+/", $content, $num_words + 1, PREG_SPLIT_NO_EMPTY );
			$sep         = ' ';
		}

		if ( count( $words_array ) > $num_words ) {
			array_pop( $words_array );
			$content = implode( $sep, $words_array );
		} else {
			$content = implode( $sep, $words_array );
		}

		/**
		 * Filters the text content after words have been trimmed.
		 *
		 * @since 5.3.0
		 *
		 * @param string $text          The trimmed text.
		 * @param int    $num_words     The number of words to trim the text to. Default 55.
		 * @param string $original_text The text before it was trimmed.
		 */
		return apply_filters( 'wp_trim_words', $content, $num_words, $original_text );
	}
}

if ( ! function_exists( 'ld_dashboard_most_popular_course_enable_for' ) ) {
	function ld_dashboard_most_popular_course_enable_for( $user_role ) {
		$options        = Ld_Dashboard_Functions::instance()->ld_dashboard_settings_data();
		$genral_options = $options['general_settings'];
		$enable         = false;

		if ( 'student' === $user_role && $user_role == $genral_options['enable-popular-courses-student'] ) {
			$enable = true;
		} elseif ( 'group-leader' === $user_role && $user_role == $genral_options['enable-popular-courses-group-leader'] ) {
			$enable = true;
		}
		return apply_filters( 'ld_dashboard_most_popular_course_enable_for', $enable, $user_role );

	}
}


function ld_dashboard_instrictor_paid_earnings( $instructor_id, $withdrawal_status = 1 ) {
	global $wpdb;
	if ( $withdrawal_status == 1 ) {
		$query = "SELECT sum(mt1.meta_value) as total_paid_earnings FROM {$wpdb->prefix}posts p INNER JOIN {$wpdb->prefix}postmeta mt ON ( p.ID = mt.post_id ) INNER JOIN {$wpdb->prefix}postmeta AS mt1 ON ( p.ID = mt1.post_id ) WHERE 1=1 AND p.post_author={$instructor_id} AND ( ( mt.meta_key = 'withdrawal_status' AND mt.meta_value = '1' ) AND mt1.meta_key = 'withdrawal_amount' ) AND ((p.post_type = 'withdrawals' AND (p.post_status = 'publish' ))) GROUP BY p.ID ORDER BY p.post_date DESC ";
	} else {
		$query = "SELECT sum(mt1.meta_value) as total_paid_earnings FROM {$wpdb->prefix}posts p INNER JOIN {$wpdb->prefix}postmeta mt ON ( p.ID = mt.post_id ) INNER JOIN {$wpdb->prefix}postmeta AS mt1 ON ( p.ID = mt1.post_id ) WHERE 1=1 AND p.post_author={$instructor_id} AND ( ( mt.meta_key = 'withdrawal_status' AND mt.meta_value != '2' ) AND mt1.meta_key = 'withdrawal_amount' ) AND ((p.post_type = 'withdrawals' AND (p.post_status = 'publish' ))) GROUP BY p.ID ORDER BY p.post_date DESC ";
	}

	$instructor_earning_data = $wpdb->get_results( $query, ARRAY_A );

	return ( ! empty( $instructor_earning_data ) ) ? $instructor_earning_data[0]['total_paid_earnings'] : 0;
}
