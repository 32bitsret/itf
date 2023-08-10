<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com/plugins
 * @since      1.0.0
 *
 * @package    Ld_Dashboard
 * @subpackage Ld_Dashboard/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ld_Dashboard
 * @subpackage Ld_Dashboard/public
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Ld_Dashboard_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ld_Dashboard_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ld_Dashboard_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$rtl_css = is_rtl() ? '-rtl' : '';
		wp_enqueue_style( 'jquery-ui-datepicker-style', plugin_dir_url( __FILE__ ) . 'css/jquery.ui.datepicker.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'select2-css', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css' . $rtl_css . '/ld-dashboard-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'ld-dashboard-zoom', plugin_dir_url( __FILE__ ) . 'css/ld-dashboard-public-zoom.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'ld-dashboard-googleapis', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined', array(), $this->version, 'all' );
		$custom_css = $this->get_inline_css_script();
		wp_add_inline_style( $this->plugin_name, $custom_css );
		wp_enqueue_style( $this->plugin_name . '-shortcodes-rtl', LEARNDASH_LMS_PLUGIN_URL . 'assets/css/learndash-admin-shortcodes-rtl.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-shortcodes', LEARNDASH_LMS_PLUGIN_URL . 'assets/css/learndash-admin-shortcodes.css', array(), $this->version, 'all' );

	}

	public function get_inline_css_script() {
		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$settings                   = $ld_dashboard_settings_data['design_options'];

		$color       = $settings['color'];
		$hover_color = $settings['hover_color'];
		$text_color  = $settings['text_color'];
		$background  = $settings['background'];
		$border      = $settings['border'];
		$custom_css  = "
				.zoom-meeting-filter-link a.create-meeting.ld-create-meeting-btn {
					background: {$color};
				}
				.zoom-meeting-filter-link a.create-meeting.ld-create-meeting-btn {
					background-color: {$color};
				}
				.zoom-meeting-filter-link a.ld-dashboard-meeting-filter.ld-dashboard-meeting-filter-active {
					color: {$color};
				}
				.ld-dashboard-form-group-row .ld-dashboard-meeting-row-group input[type=checkbox]:checked {
					background-color:{$color};
					border-color:{$color};
				}
				.ld-dashboard-create-meeting-form-row.ld-create-meeting-btn input[type='submit'] {
					background: {$color};
				}
				div.ld-dashboard-course-builder-lesson.ldd-active-lesson {
					border-color: {$border};
				}
				.ld-dashboard-header-button .ld-dashboard-add-course {
					background: {$color};
				}
				.ld-dashboard-location ul li a:hover {
					color: {$color};
				}
				.ld-dashboard-location li.ld-dashboard-menu-tab.ld-dashboard-active a.ld-focus-menu-link {
					background: {$color};
				}
				.ld-dashboard-feed .activity-item.course {
					border-left: 3px solid {$border} !important;
				}
				.ld-dashboard-report-pager-info button.ld-dashboard-button {
					border: 1px {$border} solid !important;
					color: {$color};
				}
				.ld-dashboard-location ul li.ld-dashboard-menu-divider-label {
					color: {$color};
				}
				.ld-dashboard-loader p,
				.ld-dashboard-student-loader p {
					color: {$color} !important;
				}
				button#ld-buddypress-message-send,
				button#ld-email-send {
					background: {$color};
				}
				#ld-instructor-reg-form .ld-dashboard-form-group button.ld-dashboard-button {
					background: {$color};
				}
				.ld-dashboard-btn {
					background: {$color};
				}
				.ld-dashboard-inline-links ul li.course-nav-active a,
				.ld-dashboard-inline-links ul li:hover a {
					color: {$color};
				}
				.ld-dashboard-inline-links ul li.course-nav-active:before {
					border-top-color: {$color};
				}
				.ld-dashboard-inline-links ul li.course-nav-active {
					border-color: {$color};
				}
				.ld-dashboard-course-filter button.ld-dashboard-course-filter-submit {
					background: {$color};
				}
				.ld-dashboard-course-filter-reset {
					background: {$color};
				}
				.ld-dashboard-enrolled-course-status.in-progress {
					background: {$color};
				}
				.ld-quiz-progress-content-container p a {
					color: {$color};
				}
				.ld-dashboard-profile-form input[type='text']:focus,
				.ld-dashboard-profile-form input[type='email']:focus,
				.ld-dashboard-profile-form input[type='url']:focus,
				.ld-dashboard-profile-form input[type='password']:focus,
				.ld-dashboard-profile-form input[type='search']:focus,
				.ld-dashboard-profile-form input[type='tel']:focus,
				.ld-dashboard-profile-form input[type='number']:focus,
				.ld-dashboard-profile-form input[type='text']:focus-visible,
				.ld-dashboard-profile-form input[type='email']:focus-visible,
				.ld-dashboard-profile-form input[type='url']:focus-visible,
				.ld-dashboard-profile-form input[type='password']:focus-visible,
				.ld-dashboard-profile-form input[type='search']:focus-visible,
				.ld-dashboard-profile-form input[type='tel']:focus-visible,
				.ld-dashboard-profile-form input[type='number']:focus-visible,
				.ld-dashboard-profile-form textarea:focus-visible,
				.ld-dashboard-profile-form-field input[type='password']:focus-visible,
				.ld-dashboard-profile-form select:focus {
					border: 1px solid {$color};
				}
				.ld-dashboard-profile-form-field-list .form-submit .submit,
				.ld-dashboard-profile-form input[type=submit].submit.button.ld-dashboard-btn-bg {
					background: {$color};
					border-color: {$color};
				}
				.ld-dashborad-add-edit-course .acf-form .acf-radio-list li label.selected:before {
					border-color: {$color};
				}
				.ld-dashborad-add-edit-course .acf-form .acf-true-false input[type='checkbox']:checked {
					background-color: {$color};
					border-color: {$border} !important;
				}
				.ld-dashborad-add-edit-course .acf-form-submit input.acf-button {
					background: {$color};
				}
				.ld-dashboard-content form#acf-form .add-course-featured-img .acf-image-uploader .acf-button {
					border: 1px {$color} solid;
					color: {$color};
				}
				.ld-dashborad-add-edit-course .acf-input .acf-input-append {
					background: {$color};
				}
				.correct-singleContent-bottom .add-media-ques-ans,
				.correct-singleContent-bottom .move-ques-ans {
					background: {$color} !important;
					border-color: {$color} !important;
					color:#fff !important;
				}
				.ld-dashboard-single-wrap.ld-dashboard-course-builder-lesson .ld-dashboard-crate-topics-quiz button,
				.ld-dashboard-crate-lesson button.ld_dashboard_builder_new_lesson,
				.ld-dashboard-crate-lesson button.ld_dashboard_builder_new_section_heading {
					background: {$color};
				}
				.ld-dashboard-crate-lesson button.ld_dashboard_builder_new_lesson,
				.ld-dashboard-single-wrap.ld-dashboard-course-builder-lesson .ld-dashboard-crate-topics-quiz button,
				.ld-dashboard-crate-lesson button.ld_dashboard_builder_new_section_heading {
					color: {$color};
				}
				.ld-dashboard-single-wrap.ld-dashboard-course-builder-lesson .ld-dashboard-crate-topics-quiz span input[type='submit'],
				.ld-dashboard-single-wrap.ld-dashboard-course-builder-lesson .ld-dashboard-crate-topics-quiz span input[type='button'],
				.ld-dashboard-crate-lesson span input[type='submit'],
				.ld-dashboard-crate-lesson span input[type='button'] {
					background: {$color};
					border-color: {$color};
				}
				.ld-dashboard-course-builder-wrapper .ld-dashboard-course-builder-lesson:hover {
					border-color: {$color};
				}
				button.ld-dashboard-share-post-add {
					background: {$color};
				}
				.ld-dashboard-home-btn-container a.ld-dashboard-home-btn {
					background: {$color};
				}
				.ld-dashboard-announcement-field-single button.ld-dashboard-create-announcement-btn {
					background: {$color};
				}
				.ld-dashboard-withdraw-method-fields input[type='number']:focus-visible,
				.ld-dashboard-withdraw-method-fields input[type='text']:focus-visible,
				.ld-dashboard-withdraw-method-fields input[type=email]:focus-visible {
					border: 1px solid {$color};
				}
				.ld-dashboard-add-withdraw-method-form form#add_withdraw button#ldd_save_withdraw_method {
					background: {$color};
					border-color: {$color};
				}
				button.ld-dashboard-withdraw-modal-btn {
					background: {$color};
				}
				.ld-dashboard-bak-instructions {
					color: {$color};
				}
				.ld-dashboard-add-withdraw-method-form .ld-dashboard-withdraw-messages {
					color: {$color};
					border-left: 3px solid {$color};
				}
				button.ld-dashboard-submit-withdrawal-request,
				button.ld-dashboard-cancel-withdrawal-request {
					background: {$color};
				}
				ul.ld-dashboard-instructor-earning-filters-list li.ld-dashboard-instructor-earning-filters-link.filter-selected,
				ul.ld-dashboard-instructor-earning-filters-list li.ld-dashboard-instructor-earning-filters-link:hover {
					box-shadow: inset 0 -3px 0 0 {$color};
					color: {$color};
				}
				.ld-dashboard-earning-logs-head .ld-dashboard-search-field input[type='submit'],
				.ld-dashboard-earning-logs-head .ld-dashboard-search-field a.button.ld-dashboard-export-csv {
					background: {$color};
				}
				.custom-learndash-pagination-nav .page-numbers {
					color: {$color};
				}
				.custom-learndash-pagination-nav .page-numbers.current {
					background-color: {$color};
					border-color: {$color};
				}
				.ld-dashboard-single-group-actions span.ld-dashboard-single-group-edit a,
				.ld-dashboard-group-back-btn-wrapper a.ld-dashboard-group-back-btn {
					background: {$color};
				}
				.ld-dashboard-content-wrapper{
					background: {$background};
    				border-color:{$border};
				}
				.ld-dashboard-content,
				.ld-dashboard-inline-links ul,				
				.ld-dashboard-seperator span:after{
					border-color:{$border};
				}				
				.ld-dashboard-menu-divider{
					background-color: {$border};
				}
				.ld-dashboard-location ul li a,
				.ld-dashboard-profile-form-field-list label,
				.ld-dashboard-student-courses li a,
				.ld-dashboard-info-table td a,
				.table_content_ld tr td{
					color: {$text_color};
				}
				.custom-learndash-course-form.ld-dashboard-form-settings-data-tab button.ld_dashboard_builder_new_feature,
				.ld-container.ld-mx-auto button.button.button-primary{
					background: {$color} !important;
				}
				.ld-dashboard-header-button .ld-dashboard-add-course:hover, 
				.ld-dashboard-course-filter button.ld-dashboard-course-filter-submit:hover,
				button#ld-buddypress-message-send:hover, button#ld-email-send:hover,
				.ld-dashborad-add-edit-course .acf-form-submit input.acf-button:hover,
				.ld-dashboard-profile-form-field-list .form-submit .submit:hover,
				.ld-dashboard-profile-form input[type=submit].submit.button.ld-dashboard-btn-bg:hover {
					background: {$hover_color};
					border-color:{$hover_color};
				}
				.ld-dashboard-btn:hover,
				.ld-dashboard-earning-logs-head .ld-dashboard-search-field.ld-dashboard-export-btn input:hover,
				.ld-dashboard-single-group-actions span.ld-dashboard-single-group-edit a:hover,
				.ld-dashboard-group-back-btn-wrapper a.ld-dashboard-group-back-btn:hover,
				.custom-learndash-course-form.ld-dashboard-form-settings-data-tab button.ld_dashboard_builder_new_feature:hover,
				.ld-dashboard-wrapper .acf-relationship .list .acf-rel-item:hover,
				.ld-container.ld-mx-auto button.button.button-primary:hover,
				.ld-container.ld-mx-auto input.button.button-primary:hover,
				button.ld-dashboard-course-filter-reset.ld-dashboard-btn-bg:hover,
				.ld-dashboard-earning-logs-head .ld-dashboard-search-field a.button.ld-dashboard-export-csv:hover {
					background: {$hover_color} !important;
				}
				.ld-mycourse-content .mycourse-footer a,
				.ld-mycourse-content .mycourse-footer a.ld-dashboard-element-delete-btn:hover,
				.zoom-meeting-filter-link a.ld-dashboard-meeting-filter:hover{
					color: {$color};
				}
				.ld-dashboard-withdraw-method-single.ld-dashboard-withdraw-method-active::after,
				.ld-dashboard-withdraw-method-single.ld-dashboard-withdraw-method-active::before{
					border-color:{$color};
				}
				.ld-mycourse-content h3 a,
				.ld-dashboard-section-head-title h3,
				.ld-dashboard-seperator span,
				h3.ld-dashboard-tab-heading,
				h3.ld-dashboard-feed-title,
				.ld-dashboard-groups-content-wrapper .ld-dashboard-group-edit-heading h3,
				.ld-dashborad-add-edit-course .acf-form .acf-label label,
				.ld-mycourse-content .ld-meta.ld-course-metadata ul li span,
				h3.ld-dashboard-instructor-earning-title,
				.ld-dashboard-location ul li a, .ld-dashboard-profile-form-field-list label,
				.ld-dashboard-student-courses li a, .ld-dashboard-info-table td a,
				.table_content_ld tr td {
					color: {$text_color};
				}
				.ld-dashboard-create-video-playlist-section,
				.ld-dashboard-video-playlist-create-course-form form#ld_cw_create_course_form{
					border:1px solid {$border};
				}
				.ld-dashboard-video-playlist-select-item input[type=radio]:checked::before,
				.ld-container.ld-mx-auto input.button.button-primary{
					background: {$color};
				}
				.ld-dashboard-video-playlist-select-wrap-section{
					border-color:{$border};
				}
				
				.correct-singleContent-bottom .add-media-ques-ans:hover,
				.correct-singleContent-bottom .move-ques-ans:hover,
				.sfwd-answer-input-type .add-new-ques-btn:hover,
				.correct-singleContent-bottom .delete-ques-ans:hover {
					background: {$hover_color} !important;
					border-color:{$hover_color} !important;
				}
				";
		return $custom_css;
	}

	/**
	 * Ld_dashboard_load_acf_styles
	 *
	 * @return void
	 */
	public function ld_dashboard_set_acf_header() {
		// acf_enqueue_scripts();
		if ( isset( $_GET['tab'] ) && isset( $_GET['action'] ) ) {
			acf_form_head();
		}
	}

	/**
	 * Ld_dashboard_prepare_acf_fields
	 *
	 * @param  mixed $field field.
	 */
	public function ld_dashboard_prepare_acf_fields( $field ) {
		global $current_user;
		$restrict_field      = false;
		$user_id             = $current_user->ID;
		$is_course_form_page = false;
		if ( isset( $_GET['action'] ) && $_GET['action'] == 'edit-course' && isset( $_GET['ld-course'] ) && $_GET['ld-course'] != '' ) {
			$is_course_form_page = true;
			$course_id           = $_GET['ld-course'];
			$course_user_id      = get_post_field( 'post_author', $course_id );
		}

		$function_obj  = Ld_Dashboard_Functions::instance();
		$settings_data = $function_obj->ld_dashboard_settings_data();

		if ( 'course-field-group' === $field['parent'] ) {
			$fields_setting = ( isset( $settings_data['course_fields_setting'] ) ) ? $settings_data['course_fields_setting'] : array();
		} elseif ( 'lesson-field-group' === $field['parent'] ) {
			$fields_setting = ( isset( $settings_data['lesson_fields_setting'] ) ) ? $settings_data['lesson_fields_setting'] : array();
		} elseif ( 'topic-field-group' === $field['parent'] ) {
			$fields_setting = ( isset( $settings_data['topic_fields_setting'] ) ) ? $settings_data['topic_fields_setting'] : array();
		} elseif ( 'quizz-field-group' === $field['parent'] ) {
			$fields_setting = ( isset( $settings_data['quiz_fields_setting'] ) ) ? $settings_data['quiz_fields_setting'] : array();
		} elseif ( 'question-field-group' === $field['parent'] ) {
			$fields_setting = ( isset( $settings_data['question_fields_setting'] ) ) ? $settings_data['question_fields_setting'] : array();
		} else {
			return $field;
		}

		if ( $is_course_form_page && $field['key'] == 'field_61b887732a65b' && ( $course_user_id != $user_id && in_array( 'ld_instructor', (array) $current_user->roles ) ) ) {
			$restrict_field = true;
		}

		if ( ! empty( $fields_setting ) ) {
			if ( ! isset( $fields_setting[ $field['key'] ] ) ) {
				$restrict_field = true;
			}
		} else {
			$restrict_field = true;
		}
		if ( apply_filters( 'ld_dashboard_restrict_acf_field', $restrict_field, $field ) ) {
			return false;
		}
		return $field;
	}

	public function ld_dashboard_get_avatar_data( $args, $id_or_email ) {
		if ( ! empty( $args['force_default'] ) || is_admin() || ( is_object( $id_or_email ) && 'wapuu@wordpress.example' === $id_or_email->comment_author_email ) ) {
			return $args;
		}
		if ( is_numeric( $id_or_email ) ) {
			$user_id = (int) $id_or_email;
		} elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) ) {
			$user_id = $user->ID;
		} elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ) {
			$user_id = (int) $id_or_email->user_id;
		} elseif ( $id_or_email instanceof WP_Post && ! empty( $id_or_email->post_author ) ) {
			$user_id = (int) $id_or_email->post_author;
		} else {
			$user_id = get_current_user_id();
		}
		$size       = 'ld-medium';
		$ld_avatars = get_user_meta( $user_id, 'ld_dashboard_avatar_sizes', true );

		if ( $ld_avatars && ! empty( $ld_avatars ) ) {
			if ( array_key_exists( $size, $ld_avatars ) ) {
				$args['url'] = $ld_avatars[ $size ];
			} elseif ( array_key_exists( 'medium', $ld_avatars ) ) {
				$args['url'] = $ld_avatars['medium'];
			}

			if ( ! empty( $args['url'] ) ) {
				$args['found_avatar'] = true;
			}
		}
		if ( ! isset( $args['url'] ) ) {
			$args['url'] = LD_DASHBOARD_PLUGIN_URL . 'public/img/img_avatar.png';
		}
		$args['url'] = apply_filters( 'ld_dashboard_user_avatar', $args['url'], $args );
		return $args;
	}

	public function ld_dashboard_set_bb_avatar_callback( $avatar_url, $params ) {
		$user_id    = get_current_user_id();
		$size       = 'ld-medium';
		$ld_avatars = get_user_meta( $user_id, 'ld_dashboard_avatar_sizes', true );

		if ( $ld_avatars && ! empty( $ld_avatars ) ) {
			if ( array_key_exists( $size, $ld_avatars ) ) {
				$url = $ld_avatars[ $size ];
			} elseif ( array_key_exists( 'medium', $ld_avatars ) ) {
				$url = $ld_avatars['medium'];
			}

			if ( ! empty( $url ) ) {
				$avatar_url = $url;
			}
		}

		$avatar_url = apply_filters( 'ld_dashboard_user_avatar', $avatar_url, $params );
		return $avatar_url;
	}

	/**
	 * Ld_dashboard_set_avatar_sizes
	 *
	 * @return void
	 */
	public function ld_dashboard_set_avatar_sizes() {
		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'ld-medium', 320, 320, true );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ld_Dashboard_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ld_Dashboard_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		global $post;
		if ( function_exists( 'learndash_is_learndash_license_valid' ) && learndash_is_learndash_license_valid() ) {
			$course_playlist = new Ld_Dashboard_Course_Playlist();
			$course_playlist->init();
		}
		$dashboard_page     = (int) Ld_Dashboard_Functions::instance()->ld_dashboard_get_page_id( 'dashboard' );
		$dashboard_page_url = Ld_Dashboard_Functions::instance()->ld_dashboard_get_url( 'dashboard' );
		if ( is_a( $post, 'WP_Post' ) && ( ! has_shortcode( $post->post_content, 'ld_dashboard' )
			&& ! has_shortcode( $post->post_content, 'ld_instructor_registration' )
			&& ! has_shortcode( $post->post_content, 'ld_course_details' )
			&& ! has_shortcode( $post->post_content, 'ld_student_details' )
			&& ! has_shortcode( $post->post_content, 'ld_email' )
			&& ! has_shortcode( $post->post_content, 'ld_message' )
			&& $post->ID !== $dashboard_page
			) ) {
			return;
		}

		wp_enqueue_script( 'ld-dashboard-chart', plugin_dir_url( __FILE__ ) . 'js/chart-js/dist/chart.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'ld-dashboard-chart-script', plugin_dir_url( __FILE__ ) . 'js/ld-dashboard-charts.js', array( 'ld-dashboard-chart', 'wp-i18n' ), $this->version, false );
		wp_set_script_translations( 'ld-dashboard-chart-script', 'ld-dashboard', LD_DASHBOARD_PLUGIN_DIR . 'languages/' );
		$ld_dashboard_chart_object = array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'ajax-nonce' ),
			'nonce'      => wp_create_nonce( 'ld-dashboard' ),
		);
		wp_localize_script( 'ld-dashboard-chart-script', 'ld_dashboard_chart_object', $ld_dashboard_chart_object );

		wp_enqueue_media();
		$ld_shortcode_type = '';
		if ( isset( $_GET['tab'] ) && isset( $_GET['action'] ) ) {
			$current_tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );

			$course_types      = array(
				'my-courses'   => 'sfwd-courses',
				'my-lessons'   => 'sfwd-lessons',
				'my-topics'    => 'sfwd-topic',
				'my-quizzes'   => 'sfwd-quiz',
				'my-questions' => 'sfwd-question',
				'certificates' => 'sfwd-certificates',
			);
			$ld_shortcode_type = ( isset( $course_types[ $current_tab ] ) ) ? $course_types[ $current_tab ] : '';

		}
		$atts = array(
			'popup_title' => __( 'LearnDash Shortcodes', 'ld-dashboard' ),
			'popup_type'  => 'jQuery-dialog',
			'typenow'     => $ld_shortcode_type,
			'pagenow'     => 'post.php',
			'nonce'       => wp_create_nonce( 'learndash_admin_shortcodes_assets_nonce_' . get_current_user_id() . '_post.php' ),
		);

		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );

		wp_enqueue_script( 'select2-js', plugin_dir_url( __FILE__ ) . 'js/select2.full.min.js', array( 'jquery' ), $this->version, false );
		if ( isset( $_GET['tab'] ) && 'my-questions' === $_GET['tab'] ) {
			wp_enqueue_script( 'ld-dashboard-answers', plugin_dir_url( __FILE__ ) . 'js/ld-dashboard-answers.js', array( 'jquery', 'wp-i18n' ), $this->version, false );
			wp_set_script_translations( 'ld-dashboard-answers', 'ld-dashboard', LD_DASHBOARD_PLUGIN_DIR . 'languages/' );
		}

		wp_enqueue_script( 'ld-dashboard-chart', plugin_dir_url( __FILE__ ) . 'js/chart.js/dist/chart.js', array( 'jquery' ), $this->version, false );

		if ( isset( $_GET['tab'] ) && isset( $_GET['action'] ) ) {
			wp_enqueue_script( 'learndash_admin_shortcodes_script' );
			wp_enqueue_script( 'ld-dashboard-shortcodes', plugin_dir_url( __FILE__ ) . 'js/ld-dashboard-shortcodes.js', array( 'jquery', 'jquery-ui-dialog' ), $this->version, false );
			wp_localize_script( 'ld-dashboard-shortcodes', 'learndash_admin_shortcodes_assets', $atts );
		}

		if ( function_exists( 'get_woocommerce_currency_symbol' ) ) {
			$currency = get_woocommerce_currency_symbol();
		} else {
			$currency = '$';
		}
		$user                = wp_get_current_user();
		$set_credentials_url = '';
		if ( in_array( 'administrator', (array) $user->roles ) ) {
			$set_credentials_url = admin_url( 'admin.php?page=ld-dashboard-settings&tab=ld-dashboard-zoom-setting' );

		} elseif ( in_array( 'ld_instructor', (array) $user->roles ) ) {
			$set_credentials_url = $dashboard_page_url . '?tab=settings&action=zoom';
		}
		$set_credentials_link   = '<a href="' . esc_url( $set_credentials_url ) . '">' . esc_html__( 'here', 'ld-dashboard' ) . '</a>';
		$set_credentials_text   = sprintf( esc_attr__( 'Please set zoom credentials %s in order to create a zoom meeting.', 'ld-dashboard' ), $set_credentials_link );
		$ld_dashboard_js_object = array(
			'ajaxurl'                             => admin_url( 'admin-ajax.php' ),
			'ajax_nonce'                          => wp_create_nonce( 'ajax-nonce' ),
			'nonce'                               => wp_create_nonce( 'ld-dashboard' ),
			'ins_curreny_symbol'                  => $currency,
			'ld_default_avatar'                   => LD_DASHBOARD_PLUGIN_URL . 'public/img/img_avatar.png',
			'not_started'                         => esc_html__( 'Not Started', 'ld-dashboard' ),
			'in_progress'                         => esc_html__( 'In Progress', 'ld-dashboard' ),
			'completed'                           => esc_html__( 'Completed', 'ld-dashboard' ),
			'paid'                                => esc_html__( 'Paid', 'ld-dashboard' ),
			'unpaid'                              => esc_html__( 'Unpaid', 'ld-dashboard' ),
			'unapproved_assignment'               => esc_html__( 'Unapproved Assignment', 'ld-dashboard' ),
			'pending_assignment'                  => esc_html__( 'Pending Assignment', 'ld-dashboard' ),
			'approved_assignment'                 => esc_html__( 'Approved Assignment', 'ld-dashboard' ),
			'completed_auizzes'                   => sprintf( esc_html__( 'Completed %s', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'quizzes' ) ),
			'uncompleted_quizzes'                 => sprintf( esc_html__( 'Uncompleted %s', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'quizzes' ) ),
			'no_quiz_started'                     => sprintf( esc_html__( 'No %s Started', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'quiz' ) ),
			'earning'                             => esc_html__( 'Earning', 'ld-dashboard' ),
			'course_progress'                     => sprintf( esc_html__( '%s Progress', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'course' ) ),
			'quiz_progress'                       => sprintf( esc_html__( '%s Progress', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'quiz' ) ),
			'assignment_progress'                 => esc_html__( 'Assignment Progress', 'ld-dashboard' ),
			'course_earnings'                     => sprintf( esc_html__( '%s Earnings', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'course' ) ),
			'instructor_earnings'                 => esc_html__( 'Instructor Earning', 'ld-dashboard' ),
			'instructor_earnings_during_one_year' => esc_html__( 'Instructor earning during one year', 'ld-dashboard' ),
			'is_instructor'                       => ( ! learndash_is_group_leader_user() && in_array( 'ld_instructor', (array) $user->roles ) ) ? true : false,
			'set_credentials_text'                => $set_credentials_text,
		);
		$ld_dashboard_js_labels = array(
			'course'     => LearnDash_Custom_Label::get_label( 'course' ),
			'courses'    => LearnDash_Custom_Label::get_label( 'courses' ),
			'lesson'     => LearnDash_Custom_Label::get_label( 'lesson' ),
			'lessons'    => LearnDash_Custom_Label::get_label( 'lessons' ),
			'topic'      => LearnDash_Custom_Label::get_label( 'topic' ),
			'topics'     => LearnDash_Custom_Label::get_label( 'topics' ),
			'quiz'       => LearnDash_Custom_Label::get_label( 'quiz' ),
			'quizzes'    => LearnDash_Custom_Label::get_label( 'quizzes' ),
			'question'   => LearnDash_Custom_Label::get_label( 'question' ),
			'questions'  => LearnDash_Custom_Label::get_label( 'questions' ),
			'statistics' => esc_html__( 'Statistics', 'ld-dashboard' ),
		);
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ld-dashboard-public.js', array( 'jquery', 'wp-i18n', 'jquery-ui-datepicker' ), time(), false );
		wp_set_script_translations( $this->plugin_name, 'ld-dashboard', LD_DASHBOARD_PLUGIN_DIR . 'languages/' );
		wp_localize_script( $this->plugin_name, 'ld_dashboard_js_object', $ld_dashboard_js_object );
		wp_localize_script( $this->plugin_name, 'ld_dashboard_js_labels', $ld_dashboard_js_labels );

	}

	public function ld_dashboard_set_course_grid_courses( $args ) {
		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$settings                   = $ld_dashboard_settings_data['general_settings'];
		$instructor_username        = get_query_var( 'instructor_id', '' );
		$instructor                 = get_user_by( 'login', $instructor_username );
		if ( is_object( $instructor ) ) {
			$instructor_courses = self::get_instructor_courses_list( $instructor->ID );
			$course_ids         = array_map(
				function( $course ) {
					return $course->ID;
				},
				$instructor_courses
			);
			if ( ! empty( $course_ids ) ) {
				$args['post__in'] = $course_ids;
			} else {
				$args['user_id'] = $instructor->ID;
			}
			if ( isset( $settings['ld-course-grid-columns'] ) && $settings['ld-course-grid-columns'] > 0 ) {
				$args['col'] = $settings['ld-course-grid-columns'];
			}
			if ( isset( $settings['ld-course-grid-progress-bar'] ) && 1 == $settings['ld-course-grid-progress-bar'] ) {
				$args['progress_bar'] = 'true';
			}
			if ( isset( $settings['ld-course-grid-course-content'] ) && 1 == $settings['ld-course-grid-course-content'] ) {
				$args['show_content'] = 'true';
			}
		}
		return $args;
	}

	public function ld_dashboard_set_user_password_callback() {
		$data         = array(
			'error' => 0,
		);
		$field_exists = true;
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			$error_msg = esc_html__( 'Invalid nonce.', 'ld-dashboard' );
			$data      = array(
				'error'     => 1,
				'error_msg' => $error_msg,
			);
		}
		if ( ! isset( $_POST['oldpass'] ) && ! isset( $_POST['newpass'] ) && ! isset( $_POST['confirmnewpass'] ) ) {
			$error_msg    = esc_html__( 'Fields not found.', 'ld-dashboard' );
			$data         = array(
				'error'     => 1,
				'error_msg' => $error_msg,
			);
			$field_exists = false;
		}
		if ( $field_exists ) {
			$current_user     = wp_get_current_user();
			$old_pass         = sanitize_text_field( wp_unslash( $_POST['oldpass'] ) );
			$new_pass         = sanitize_text_field( wp_unslash( $_POST['newpass'] ) );
			$confirm_new_pass = sanitize_text_field( wp_unslash( $_POST['confirmnewpass'] ) );
			$check            = wp_check_password( $old_pass, $current_user->user_pass, $current_user->ID );
			if ( $check ) {
				if ( $new_pass == $confirm_new_pass ) {
					wp_update_user(
						array(
							'ID'        => $current_user->ID,
							'user_pass' => sanitize_text_field( wp_unslash( $new_pass ) ),
						)
					);
					wp_clear_auth_cookie();
					wp_set_auth_cookie( $current_user->ID );
					wp_set_current_user( $current_user->ID );
					do_action( 'wp_login', $current_user->user_login, $current_user );
					$data['error_msg'] = esc_html__( 'Your password is updated.', 'ld-dashboard' );
				} else {
					$error_msg = esc_html__( 'The passwords you entered did not match. Your password was not updated.', 'ld-dashboard' );
					$data      = array(
						'error'     => 1,
						'error_msg' => $error_msg,
					);
				}
			} else {
				$error_msg = esc_html__( 'The passwords you entered did not match. Your password was not updated.', 'ld-dashboard' );
				$data      = array(
					'error'     => 1,
					'error_msg' => $error_msg,
				);
			}
		}
		echo wp_json_encode( $data );
		wp_die();
	}

	/*
	 * Update author earning on course access.
	 */
	public function ld_dashboard_update_author_earning( $user_id, $course_id, $access_list, $remove ) {

		if ( $remove ) {
			return;
		}
		$transaction_exists = ld_dashboard_check_course_transaction_exists( $user_id, $course_id );
		if ( ! $transaction_exists ) {
			return;
		}

		$course_pricing = learndash_get_course_price( $course_id );
		$course_price   = (int) $course_pricing['price'];

		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$monetization_setting       = $ld_dashboard_settings_data['monetization_settings'];
		$fees                       = 0;
		if ( isset( $monetization_setting['enable-deduct-fees'] ) && 1 == $monetization_setting['enable-deduct-fees'] ) {
			$fee_amount = isset( $monetization_setting['fee-amount'] ) ? $monetization_setting['fee-amount'] : 0;
			$fee_type   = isset( $monetization_setting['fee-type'] ) ? $monetization_setting['fee-type'] : '';
			if ( 'fixed' === $fee_type ) {
				$course_price -= $fee_amount;
			} elseif ( 'percent' === $fee_type ) {
				$course_price = $course_price - ( ( $fee_amount * $course_price ) / 100 );
			}
		}

		if ( $course_pricing['type'] == 'paynow' || $course_pricing['type'] == 'closed' || $course_pricing['type'] == 'subscribe' ) {
			$course = get_post( $course_id );
			if ( $course && isset( $course->post_author ) ) {
				$course_author      = $course->post_author;
				$check_instrucor    = ld_check_if_author_is_instructor( $course_author );
				$commission_enabled = ld_if_commission_enabled();
				$_commission        = 0;
				if ( $check_instrucor ) {
					if ( $commission_enabled ) {
						$_commission = ld_if_instructor_course_commission_set( $course_author );
						if ( false === $_commission ) {
							$_commission = ld_get_global_commission_rate();
						}
					}
				}
				if ( $_commission > 0 ) {
					// cep - course earning percentage.
					$instructor_cep = $_commission;
					// ce - instructor course earning.
					$course_price = ( $course_price * $instructor_cep ) / 100;
				}
			}
			$instructor_total_earning = (int) get_user_meta( $course_author, 'instructor_total_earning', true );
			if ( $instructor_total_earning ) {
				$total_earning = $instructor_total_earning + $course_price;
				update_user_meta( $course_author, 'instructor_total_earning', $total_earning );
			} else {
				update_user_meta( $course_author, 'instructor_total_earning', $course_price );
			}
			$instructor_wallet_balance = (int) get_user_meta( $course_author, 'instructor_wallet_balance', true );
			if ( $instructor_wallet_balance ) {
				$total_earning = $instructor_wallet_balance + $course_price;
				update_user_meta( $course_author, 'instructor_wallet_balance', $total_earning );
			} else {
				update_user_meta( $course_author, 'instructor_wallet_balance', $course_price );
			}
		}
	}

	/**
	 * Template_override_exists
	 *
	 * @param  mixed $file file.
	 */
	public static function template_override_exists( $file ) {
		$theme_dir = get_stylesheet_directory();
		$template  = $theme_dir . '/ld-dashboard/' . $file;
		$template  = apply_filters( 'ld_dashboard_before_template_load', $template );
		if ( file_exists( $template ) ) {
			return $template;
		}
		return false;
	}

	public function ld_dashboard_earning_chart_default_data( $filter_by ) {
		$default_data = array();
		$current_m    = gmdate( 'F Y' );
		$current_d    = gmdate( 'd M' );

		if ( 'year' === $filter_by ) {
			$current_year_iterated = false;
			$prev_year             = array();
			for ( $m = 1; $m <= 12; $m++ ) {
				if ( $current_year_iterated ) {
					$month = gmdate( 'F Y', mktime( 0, 0, 0, $m, 1, gmdate( 'Y', strtotime( '-1 year' ) ) ) );
				} else {
					$month = gmdate( 'F Y', mktime( 0, 0, 0, $m, 1, gmdate( 'Y' ) ) );
				}
				if ( ! $current_year_iterated ) {
					$default_data[] = $month;
				} else {
					$prev_year[] = $month;
				}
				if ( $current_m == $month && ! $current_year_iterated ) {
					$current_year_iterated = true;
				}
			}
			$default_data = array_merge( $prev_year, $default_data );

		} elseif ( 'l_month' === $filter_by ) {
			for ( $i = 1; $i <= gmdate( 't', strtotime( 'last month' ) ); $i++ ) {
				$default_data[] = str_pad( $i, 2, '0', STR_PAD_LEFT ) . ' ' . gmdate( 'M', strtotime( 'last month' ) );
			}
		} elseif ( 'month' === $filter_by ) {
			for ( $i = 1; $i <= gmdate( 't' ); $i++ ) {
				if ( in_array( $current_d, $default_data ) ) {
					break;
				}
				$default_data[] = str_pad( $i, 2, '0', STR_PAD_LEFT ) . ' ' . gmdate( 'M' );
			}
		} elseif ( 'week' === $filter_by ) {
			$week_days = array();
			for ( $i = 6; $i >= 0; $i-- ) {
				$temp = array();
				if ( $i > 0 ) {
					$temp['date']  = gmdate( 'd', strtotime( '-' . $i . ' days' ) );
					$temp['month'] = gmdate( 'M', strtotime( '-' . $i . ' days' ) );
				} else {
					$temp['date']  = gmdate( 'd' );
					$temp['month'] = gmdate( 'M' );
				}
				$week_days[] = $temp;
			}
			foreach ( $week_days as $dat ) {
				$default_data[] = str_pad( $dat['date'], 2, '0', STR_PAD_LEFT ) . ' ' . $dat['month'];
			}
		}

		$temp = array();
		foreach ( $default_data as $data ) {
			$temp[ $data ] = 0;
		}
		$default_data = $temp;
		return $default_data;
	}

	public function ld_dashboard_get_instructor_earning_chart_data_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		global $wpdb;
		$filter             = ( isset( $_POST['filter'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter'] ) ) : 'year';
		$user_id            = get_current_user_id();
		$user               = wp_get_current_user();
		$commission_enabled = ld_if_commission_enabled();
		$date_format        = ( 'year' === $filter ) ? 'F Y' : 'd M';
		$data               = $this->ld_dashboard_earning_chart_default_data( $filter );
		$earning_data       = array();

		$query                = $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'ld_dashboard_instructor_commission_logs WHERE user_id = %d order by ID DESC', $user_id );
		$course_purchase_data = $wpdb->get_results( $query, ARRAY_A );

		if ( ! empty( $course_purchase_data ) ) {
			foreach ( $course_purchase_data as $key => $value ) {
				$month_yr = gmdate( $date_format, strtotime( $value['created'] ) );
				if ( isset( $data[ $month_yr ] ) ) {
					$data[ $month_yr ] += $value['commission'];
				}
			}
		}
		if ( 'year' === $filter ) {
			$temp = array();
			foreach ( $data as $mt => $total ) {
				$new_key             = explode( ' ', $mt );
				$temp[ $new_key[0] ] = $total;
			}
			$data = $temp;
		}

		$default_data   = array(
			'keys'   => array_keys( $data ),
			'values' => array_values( $data ),
		);
		$total_earnings = 0;
		foreach ( $default_data['values'] as $value ) {
			$total_earnings += (int) $value;
		}
		$default_data['total'] = $total_earnings;
		echo wp_json_encode( $default_data );
		exit;
	}

	public function ld_dashboard_get_course_completion_chart_data_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$filter             = ( isset( $_POST['filter'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter'] ) ) : 'year';
		$user_id            = get_current_user_id();
		$user               = wp_get_current_user();
		$commission_enabled = ld_if_commission_enabled();
		$courses            = '';

		if ( in_array( 'ld_instructor', $user->roles ) || in_array( 'administrator', $user->roles ) ) {
			$ins_courses = self::get_instructor_courses_list( $user_id );
			$courses     = ( ! empty( $ins_courses ) && is_array( $ins_courses ) ) ? $ins_courses : array();
		}

		$date_format = ( 'year' === $filter ) ? 'F Y' : 'd M';
		$data        = $this->ld_dashboard_earning_chart_default_data( $filter );

		if ( is_array( $courses ) && ! empty( $courses ) ) {
			$purchase_data = array();
			foreach ( $courses as $pcs ) {
				$paid_times        = 0;
				$settinf           = learndash_get_setting( $pcs->ID );
				$current_str       = strtotime( 'now' );
				$course_user_query = learndash_get_users_for_course( intval( $pcs->ID ), array(), true );
				if ( $course_user_query instanceof WP_User_Query ) {
					$total_course_users = $course_user_query->get_results();

					if ( ! empty( $total_course_users ) ) {
						foreach ( $total_course_users as $index => $total_course_user ) {
							$course_data = learndash_user_get_course_progress( $total_course_user, intval( $pcs->ID ), 'summary' );
							if ( 'completed' === $course_data['status'] ) {
								$key          = 'course_completed_' . $pcs->ID;
								$completed_on = get_user_meta( $total_course_user, $key, true );
								$month_yr     = gmdate( $date_format, (int) $completed_on );
								if ( isset( $data[ $month_yr ] ) ) {
									$data[ $month_yr ] += 1;
								}
							}
						}
					}
				}
			}
		}
		if ( 'year' === $filter ) {
			$temp = array();
			foreach ( $data as $mt => $total ) {
				$new_key             = explode( ' ', $mt );
				$temp[ $new_key[0] ] = $total;
			}
			$data = $temp;
		}

		$default_data   = array(
			'keys'   => array_keys( $data ),
			'values' => array_values( $data ),
		);
		$total_earnings = 0;
		foreach ( $default_data['values'] as $value ) {
			$total_earnings += (int) $value;
		}
		$default_data['total'] = $total_earnings;
		echo wp_json_encode( $default_data );
		exit;
	}

	public function ld_dashboard_get_top_courses_chart_data_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$filter             = ( isset( $_POST['filter'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter'] ) ) : 'year';
		$user_id            = get_current_user_id();
		$user               = wp_get_current_user();
		$commission_enabled = ld_if_commission_enabled();
		$courses            = '';

		if ( in_array( 'ld_instructor', $user->roles ) || in_array( 'administrator', $user->roles ) ) {
			$ins_courses = self::get_instructor_courses_list( $user_id );
			$courses     = ( ! empty( $ins_courses ) && is_array( $ins_courses ) ) ? $ins_courses : array();
		}

		$date_format = ( 'year' === $filter ) ? 'F Y' : 'd M';
		$data        = $this->ld_dashboard_earning_chart_default_data( $filter );
		$course_arr  = array();
		if ( is_array( $courses ) && ! empty( $courses ) ) {
			foreach ( $courses as $pcs ) {
				$paid_times        = 0;
				$settinf           = learndash_get_setting( $pcs->ID );
				$current_str       = strtotime( 'now' );
				$course_user_query = learndash_get_users_for_course( intval( $pcs->ID ), array(), true );

				if ( $course_user_query instanceof WP_User_Query ) {
					$total_course_users = $course_user_query->get_results();

					if ( ! empty( $total_course_users ) ) {
						foreach ( $total_course_users as $index => $total_course_user ) {
							$course_data = learndash_user_get_course_progress( $total_course_user, $pcs->ID, 'summary' );
							if ( 'completed' === $course_data['status'] ) {
								$key          = 'course_completed_' . $pcs->ID;
								$completed_on = get_user_meta( $total_course_user, $key, true );
								$month_yr     = gmdate( $date_format, (int) $completed_on );
								if ( isset( $data[ $month_yr ] ) ) {
									if ( isset( $course_arr[ $pcs->post_title ] ) ) {
										$course_arr[ $pcs->post_title ] += 1;
									} else {
										$course_arr[ $pcs->post_title ] = 1;
									}
								}
							}
						}
					}
				}
			}
		}

		if ( is_array( $course_arr ) && ! empty( $course_arr ) ) {
			arsort( $course_arr );
			$course_arr = array_slice( $course_arr, 0, 5 );
		}

		$default_data = array(
			'keys'   => array_keys( $course_arr ),
			'values' => array_values( $course_arr ),
		);
		echo wp_json_encode( $default_data );
		exit;
	}

	public function ld_dashboard_request_withdrawal_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$withdrawal_data = get_user_meta( get_current_user_id(), 'ld_withdrawals_data', true );
		$amount          = ( isset( $_POST['amount'] ) ) ? sanitize_text_field( wp_unslash( $_POST['amount'] ) ) : 0;
		$method          = ( isset( $withdrawal_data['ldd_withdraw_method'] ) ) ? $withdrawal_data['ldd_withdraw_method'] : '';
		$new_withdrawal  = array(
			'post_title'  => 'request_' . strtotime( 'now' ),
			'post_status' => 'publish',
			'post_author' => get_current_user_id(),
			'post_type'   => 'withdrawals',
		);

		$post_id = wp_insert_post( $new_withdrawal );
		update_post_meta( $post_id, 'withdrawal_status', 0 );
		update_post_meta( $post_id, 'withdrawal_amount', $amount );
		update_post_meta( $post_id, 'withdrawal_method', $method );
		update_post_meta( $post_id, 'withdrawal_data', $withdrawal_data );
		echo esc_html( $post_id );
		exit();
	}

	public function ld_dashboard_save_withdraw_method_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$form_data     = array();
		$form_raw_data = ( isset( $_POST['form_data'] ) ) ? wp_unslash( $_POST['form_data'] ) : array();
		foreach ( $form_raw_data as $value ) {
			if ( '' !== $value['value'] && false !== strpos( $value['name'], 'ldd_' ) ) {
				$form_data[ $value['name'] ] = $value['value'];
			}
		}
		update_user_meta( get_current_user_id(), 'ld_withdrawals_data', $form_data );
		wp_die();
	}

	/**
	 * Ld_dashboard_get_student_quiz_attempt_callback
	 *
	 * @return void
	 */
	public function ld_dashboard_get_student_quiz_attempt_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$user_id       = ( isset( $_POST['user_id'] ) ) ? sanitize_text_field( wp_unslash( $_POST['user_id'] ) ) : false;
		$quiz_progress = get_user_meta( $user_id, '_sfwd-quizzes', true );
		if ( $quiz_progress && is_array( $quiz_progress ) && ! empty( $quiz_progress ) ) {
			$atts = array(
				'user_id'          => $user_id,
				'progress_orderby' => 'title',
				'progress_order'   => 'ASC',
				'type'             => 'quiz',
				'quiz_orderby'     => 'taken',
				'quiz_order'       => 'DESC',
			);
			echo learndash_course_info_shortcode( $atts );
			$quiz_progress_hidden_field = '';
			foreach ( $quiz_progress as $pgs ) {
				$nonce                       = wp_create_nonce( 'statistic_nonce_' . $pgs['statistic_ref_id'] . '_' . get_current_user_id() . '_' . $user_id );
				$quiz_progress_hidden_field .= '<input type="hidden" class="ldd_user_statistic_hidden_field" data-id="ld-quiz-' . $pgs['time'] . '" data-statistic_nonce="' . $nonce . '" data-user_id="' . $user_id . '" data-quiz_id="' . $pgs['pro_quizid'] . '" data-ref_id="' . $pgs['statistic_ref_id'] . '" >';
			}
			echo $quiz_progress_hidden_field;
		} else {
			$msg = sprintf( '%1s %2s %3s', esc_html__( 'No', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'quiz' ), esc_html__( 'attempts found.', 'ld-dashboard' ) );
			echo "<p class='ld-dashboard-warning'>" . esc_html( $msg ) . '</p>';
		}
		wp_die();
	}

	/**
	 * Ld_dashboard_get_course_lessons_callback
	 *
	 * @return void
	 */
	public function ld_dashboard_get_course_lessons_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		if ( ! isset( $_POST['course_id'] ) ) {
			wp_die();
		}
		$course_id = sanitize_text_field( wp_unslash( $_POST['course_id'] ) );
		$args      = array(
			'post_type'      => 'sfwd-lessons',
			'post_status'    => array( 'publish', 'pending', 'draft' ),
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => 'course_id',
					'value'   => $course_id,
					'compare' => '==',
				),
			),
		);
		$lessons   = get_posts( $args );
		$content   = '<option value=""></option>';
		if ( count( $lessons ) > 0 ) {
			foreach ( $lessons as $lesson ) {
				$content .= '<option value="' . $lesson->ID . '">' . $lesson->post_title . '</option>';
			}
		}
		echo $content;
		wp_die();
	}

	public function ld_dashboard_get_course_lesson_quizzes_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		if ( ! isset( $_POST['course_id'] ) || ! isset( $_POST['lesson_id'] ) ) {
			wp_die();
		}
		$course_id = sanitize_text_field( wp_unslash( $_POST['course_id'] ) );
		$lesson_id = sanitize_text_field( wp_unslash( $_POST['lesson_id'] ) );
		$args      = array(
			'post_type'      => 'sfwd-quiz',
			'post_status'    => array( 'publish', 'pending', 'draft' ),
			'posts_per_page' => -1,
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'course_id',
					'value'   => $course_id,
					'compare' => '==',
				),
				array(
					'key'     => 'lesson_id',
					'value'   => $lesson_id,
					'compare' => '==',
				),
			),
		);
		$quizzes   = get_posts( $args );
		$content   = '<option value=""></option>';
		if ( count( $quizzes ) > 0 ) {
			foreach ( $quizzes as $quiz ) {
				$content .= '<option value="' . $quiz->ID . '">' . $quiz->post_title . '</option>';
			}
		}
		echo $content;
		wp_die();
	}

	public function get_admin_lessons_content() {
		$lesson_args     = array(
			'post_type'      => 'sfwd-lessons',
			'post_status'    => array( 'publish', 'pending', 'draft' ),
			'posts_per_page' => -1,
		);
		$topic_args      = array(
			'post_type'      => 'sfwd-topic',
			'post_status'    => array( 'publish', 'pending', 'draft' ),
			'posts_per_page' => -1,
		);
		$quiz_args       = array(
			'post_type'      => 'sfwd-quiz',
			'post_status'    => array( 'publish', 'pending', 'draft' ),
			'posts_per_page' => -1,
		);
		$question_args   = array(
			'post_type'      => 'sfwd-question',
			'post_status'    => array( 'publish', 'pending', 'draft' ),
			'posts_per_page' => -1,
		);
		$assignment_args = array(
			'post_type'      => 'sfwd-assignment',
			'post_status'    => array( 'publish', 'pending', 'draft' ),
			'posts_per_page' => -1,
		);
		$data            = array(
			'lessons'     => get_posts( $lesson_args ),
			'topics'      => get_posts( $topic_args ),
			'quizzes'     => get_posts( $quiz_args ),
			'questions'   => get_posts( $question_args ),
			'assignments' => get_posts( $assignment_args ),
		);
		return $data;
	}

	/**
	 * Ld_dashboard_approve_assignment_callback
	 *
	 * @return void
	 */
	public function ld_dashboard_approve_assignment_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		if ( ! isset( $_POST['assignment_id'] ) ) {
			wp_die();
		}
		$assignment_id = sanitize_text_field( wp_unslash( $_POST['assignment_id'] ) );
		$res           = 0;
		if ( ! empty( $assignment_id ) ) {
			update_post_meta( $assignment_id, 'approval_status', 1 );
			$res = 1;
		}
		echo $res;
		exit();
	}

	/**
	 * Ld_dashboard_get_instructor_tab_content_callback
	 *
	 * @return void
	 */
	public function ld_dashboard_get_instructor_tab_content_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		if ( ! isset( $_POST['post_type'] ) || ! isset( $_POST['course_id'] ) || ! isset( $_POST['page'] ) ) {
			wp_die();
		}
		$data               = array();
		$course_id          = sanitize_text_field( wp_unslash( $_POST['course_id'] ) );
		$lesson_id          = ( isset( $_POST['lesson_id'] ) ) ? sanitize_text_field( wp_unslash( $_POST['lesson_id'] ) ) : 0;
		$quiz_id            = ( isset( $_POST['quiz_id'] ) ) ? sanitize_text_field( wp_unslash( $_POST['quiz_id'] ) ) : 0;
		$post_type          = sanitize_text_field( wp_unslash( $_POST['post_type'] ) );
		$page               = sanitize_text_field( wp_unslash( $_POST['page'] ) );
		$dashboard_page_url = Ld_Dashboard_Functions::instance()->ld_dashboard_get_url( 'dashboard' );
		if ( learndash_is_admin_user() || ld_group_leader_has_admin_cap() ) {
			$contents = $this->get_admin_lessons_content();
		} else {
			$contents = $this->get_instructor_lessons_contents( '' );
		}
		$content = '';
		if ( 'lesson' === $post_type ) {
			$include_lesson_ids = array( 0 );
			if ( isset( $contents['lessons'] ) ) {
				foreach ( $contents['lessons'] as $lsn ) {
					if ( ! in_array( $lsn->ID, $include_lesson_ids ) ) {
						$include_lesson_ids[] = $lsn->ID;
					}
				}
			}
			$args = array(
				'post_type'      => 'sfwd-lessons',
				'post_status'    => array( 'publish', 'pending', 'draft' ),
				'paged'          => $page,
				'posts_per_page' => 5,
				'post__in'       => $include_lesson_ids,
			);
			if ( $course_id > 0 ) {
				$args['meta_query'] = array(
					array(
						'key'     => 'course_id',
						'value'   => $course_id,
						'compare' => '==',
					),
				);
				unset( $args['post__in'] );
			}
			$lessons       = get_posts( $args );
			$lessons_query = new WP_Query( $args );
			$lesson_nonce  = wp_create_nonce( 'lesson-nonce' );
			if ( count( $lessons_query->posts ) > 0 ) {
				foreach ( $lessons_query->posts as $lesson ) {
					$image_id       = get_post_meta( $lesson->ID, '_thumbnail_id', true );
					$feat_image_url = wp_get_attachment_url( $image_id );
					$feat_image_url = ( $feat_image_url ) ? esc_url( $feat_image_url ) : esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/course-default.png';
					$content       .= '<div id="ld-dashboard-course-' . $lesson->ID . '" class="ld-mycourse-wrap ld-mycourse-' . $lesson->ID . ' __web-inspector-hide-shortcut__">
										<div class="ld-mycourse-thumbnail" style="background-image: url(' . $feat_image_url . ');"></div>
									<div class="ld-mycourse-content">
										<h3><a href="' . get_permalink( $lesson->ID ) . '">' . $lesson->post_title . '</a></h3>
										<div class="ld-meta ld-course-metadata ld-course-metadata-item">
											<ul class="post_status">
												<li>Status:<span>' . $lesson->post_status . '</span></li>
											</ul>
											<div class="mycourse-footer">
												<div class="ld-mycourses-stats">
													<a href="' . get_permalink( $lesson->ID ) . '" class="ld-mycourse-view">
														<span class="material-symbols-outlined visibility-icon">' . esc_html__( 'visibility', 'ld-dashboard' ) . '</span>' . esc_html__( 'View', 'ld-dashboard' ) . '</a>
													<a href="' . esc_url( $dashboard_page_url ) . '?action=edit-lesson&ld-lesson=' . $lesson->ID . '&tab=my-lessons&_lddnonce=' . esc_attr( $lesson_nonce ) . '" class="ld-mycourse-edit">
														<span class="material-symbols-outlined edit_square">' . esc_html__( 'edit_square', 'ld-dashboard' ) . '</span>' . esc_html__( 'Edit', 'ld-dashboard' ) . '</a>
													<a href="' . esc_url( $dashboard_page_url ) . '?action=delete-lesson&ld-lesson=' . $lesson->ID . '&tab=my-lessons" class="ld-dashboard-element-delete-btn" data-type="lesson" data-type_id="' . $lesson->ID . '">
														<div class="delete-icons-material material-symbols-outlined">' . esc_html__( 'delete', 'ld-dashboard' ) . ' </div> ' . esc_html__( 'Delete', 'ld-dashboard' ) . '</a>
												</div>
											</div>
										</div>
									</div>
								</div>';
				}
			} else {
				$content .= '<p class="ld-dashboard-warning">' . sprintf( esc_html__( 'No %s found.', 'ld-dashboard' ), esc_html( strtolower( LearnDash_Custom_Label::get_label( 'lessons' ) ) ) ) . '</p>';
			}
			$data['content'] = $content;
			$data['next']    = ( $page < $lessons_query->max_num_pages ) ? true : false;
			$data['prev']    = ( $page > 1 ) ? true : false;
			echo wp_json_encode( $data );

		} elseif ( 'topic' === $post_type ) {
			$include_topic_ids = array( 0 );
			if ( isset( $contents['topics'] ) ) {
				foreach ( $contents['topics'] as $lsn ) {
					if ( ! in_array( $lsn->ID, $include_topic_ids ) ) {
						$include_topic_ids[] = $lsn->ID;
					}
				}
			}
			$args = array(
				'post_type'      => 'sfwd-topic',
				'post_status'    => array( 'publish', 'pending', 'draft' ),
				'paged'          => $page,
				'posts_per_page' => 5,
				'post__in'       => $include_topic_ids,
			);
			if ( $course_id > 0 ) {
				$args['meta_query'] = array(
					array(
						'key'     => 'course_id',
						'value'   => $course_id,
						'compare' => '==',
					),
				);
				unset( $args['post__in'] );
			}
			if ( $lesson_id > 0 ) {
				$args['meta_query']['relation'] = 'AND';
				$args['meta_query'][]           = array(
					'key'     => 'lesson_id',
					'value'   => $lesson_id,
					'compare' => '==',
				);
			}
			$topics       = get_posts( $args );
			$topics_query = new WP_Query( $args );
			$topic_nonce  = wp_create_nonce( 'topic-nonce' );
			if ( count( $topics_query->posts ) > 0 ) {
				foreach ( $topics_query->posts as $topic ) {
					$image_id       = get_post_meta( $topic->ID, '_thumbnail_id', true );
					$feat_image_url = wp_get_attachment_url( $image_id );
					$feat_image_url = ( $feat_image_url ) ? esc_url( $feat_image_url ) : esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/course-default.png';
					$content       .= '<div id="ld-dashboard-course-' . $topic->ID . '" class="ld-mycourse-wrap ld-mycourse-' . $topic->ID . ' __web-inspector-hide-shortcut__">
									<div class="ld-mycourse-thumbnail" style="background-image: url(' . $feat_image_url . ');"></div>
									<div class="ld-mycourse-content">
										<h3><a href="' . get_permalink( $topic->ID ) . '">' . $topic->post_title . '</a></h3>
										<div class="ld-meta ld-course-metadata ld-course-metadata-item">
											<ul class="post_status">
												<li>Status:<span>' . $topic->post_status . '</span></li>
											</ul>
											<div class="mycourse-footer">
												<div class="ld-mycourses-stats">
													<a href="' . get_permalink( $topic->ID ) . '" class="ld-mycourse-view">
														<span class="material-symbols-outlined visibility-icon">' . esc_html__( 'visibility', 'ld-dashboard' ) . '</span>' . esc_html__( 'View', 'ld-dashboard' ) . '</a>
													<a href="' . esc_url( $dashboard_page_url ) . '?action=edit-topic&ld-topic=' . $topic->ID . '&tab=my-topics&_lddnonce=' . esc_attr( $topic_nonce ) . '" class="ld-mycourse-edit">
														<span class="material-symbols-outlined edit_square">' . esc_html__( 'edit_square', 'ld-dashboard' ) . '</span>' . esc_html__( 'Edit', 'ld-dashboard' ) . '</a>
													<a href="' . esc_url( $dashboard_page_url ) . '?action=delete-topic&ld-topic=' . $topic->ID . '&tab=my-topics" class="ld-dashboard-element-delete-btn" data-type="topic" data-type_id="' . $topic->ID . '">
													<div class="delete-icons-material material-symbols-outlined">' . esc_html__( 'delete', 'ld-dashboard' ) . ' </div> ' . esc_html__( 'Delete', 'ld-dashboard' ) . '</a>
												</div>
											</div>
										</div>
									</div>
								</div>';
				}
			} else {
				$content .= '<p class="ld-dashboard-warning">' . sprintf( esc_html__( 'No %s found.', 'ld-dashboard' ), esc_html( strtolower( LearnDash_Custom_Label::get_label( 'topics' ) ) ) ) . '</p>';
			}
			$data['content'] = $content;
			$data['next']    = ( $page < $topics_query->max_num_pages ) ? true : false;
			$data['prev']    = ( $page > 1 ) ? true : false;
			echo wp_json_encode( $data );
		} elseif ( 'quiz' === $post_type ) {
			$include_quiz_ids = array( 0 );
			if ( isset( $contents['quizzes'] ) ) {
				foreach ( $contents['quizzes'] as $lsn ) {
					if ( ! in_array( $lsn->ID, $include_quiz_ids ) ) {
						$include_quiz_ids[] = $lsn->ID;
					}
				}
			}
			$args = array(
				'post_type'      => 'sfwd-quiz',
				'post_status'    => array( 'publish', 'pending', 'draft' ),
				'paged'          => $page,
				'posts_per_page' => 5,
				'post__in'       => $include_quiz_ids,
			);
			if ( $course_id > 0 ) {
				$args['meta_query'] = array(
					array(
						'key'     => 'course_id',
						'value'   => $course_id,
						'compare' => '==',
					),
				);
				unset( $args['post__in'] );
			}
			if ( $lesson_id > 0 ) {
				$args['meta_query']['relation'] = 'AND';
				$args['meta_query'][]           = array(
					'key'     => 'lesson_id',
					'value'   => $lesson_id,
					'compare' => '==',
				);
			}
			$quizzes       = get_posts( $args );
			$quizzes_query = new WP_Query( $args );
			$quiz_nonce    = wp_create_nonce( 'quiz-nonce' );
			if ( count( $quizzes_query->posts ) > 0 ) {
				foreach ( $quizzes_query->posts as $quiz ) {
					$image_id       = get_post_meta( $quiz->ID, '_thumbnail_id', true );
					$feat_image_url = wp_get_attachment_url( $image_id );
					$feat_image_url = ( $feat_image_url ) ? esc_url( $feat_image_url ) : esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/course-default.png';
					$content       .= '<div id="ld-dashboard-course-' . $quiz->ID . '" class="ld-mycourse-wrap ld-mycourse-' . $quiz->ID . ' __web-inspector-hide-shortcut__">
									<div class="ld-mycourse-thumbnail" style="background-image: url(' . $feat_image_url . ');"></div>
									<div class="ld-mycourse-content">
										<h3><a href="' . get_permalink( $quiz->ID ) . '">' . $quiz->post_title . '</a></h3>
										<div class="ld-meta ld-course-metadata ld-course-metadata-item">
											<ul class="post_status">
												<li>Status:<span>' . $quiz->post_status . '</span></li>
											</ul>
											<div class="mycourse-footer">
												<div class="ld-mycourses-stats">
													<a href="' . get_permalink( $quiz->ID ) . '" class="ld-mycourse-view">
														<span class="material-symbols-outlined visibility-icon">' . esc_html__( 'visibility', 'ld-dashboard' ) . '</span>' . esc_html__( 'View', 'ld-dashboard' ) . '</a>
													<a href="' . esc_url( $dashboard_page_url ) . '?action=edit-quiz&ld-quiz=' . $quiz->ID . '&tab=my-quizzes&_lddnonce=' . esc_attr( $quiz_nonce ) . '" class="ld-mycourse-edit">
														<span class="material-symbols-outlined edit_square">' . esc_html__( 'edit_square', 'ld-dashboard' ) . '</span>' . esc_html__( 'Edit', 'ld-dashboard' ) . '</a>
													<a href="' . esc_url( $dashboard_page_url ) . '?action=delete-quiz&ld-quiz=' . $quiz->ID . '&tab=my-quizzes" class="ld-dashboard-element-delete-btn" data-type="quiz" data-type_id="' . $quiz->ID . '">
														<div class="delete-icons-material material-symbols-outlined">' . esc_html__( 'delete', 'ld-dashboard' ) . ' </div> ' . esc_html__( 'Delete', 'ld-dashboard' ) . '</a>
												</div>
											</div>
										</div>
									</div>
								</div>';
				}
			} else {
				$content .= '<p class="ld-dashboard-warning">' . sprintf( esc_html__( 'No %s found.', 'ld-dashboard' ), strtolower( LearnDash_Custom_Label::get_label( 'quizzes' ) ) ) . '</p>';
			}
			$data['content'] = $content;
			$data['next']    = ( $page < $quizzes_query->max_num_pages ) ? true : false;
			$data['prev']    = ( $page > 1 ) ? true : false;
			echo wp_json_encode( $data );
		} elseif ( 'question' === $post_type ) {
			$include_question_ids = array( 0 );
			if ( isset( $contents['questions'] ) ) {
				foreach ( $contents['questions'] as $lsn ) {
					if ( is_object( $lsn ) && ! in_array( $lsn->ID, $include_question_ids ) ) {
						$include_question_ids[] = $lsn->ID;
					}
				}
			}
			$args = array(
				'post_type'      => 'sfwd-question',
				'post_status'    => array( 'publish', 'pending', 'draft' ),
				'paged'          => $page,
				'posts_per_page' => 5,
				'post__in'       => $include_question_ids,
			);
			if ( $quiz_id > 0 ) {
				$args['meta_query'] = array(
					array(
						'key'     => 'quiz_id',
						'value'   => $quiz_id,
						'compare' => '==',
					),
				);
				unset( $args['post__in'] );
			}
			$questions       = get_posts( $args );
			$questions_query = new WP_Query( $args );
			$question_nonce  = wp_create_nonce( 'question-nonce' );
			if ( count( $questions_query->posts ) > 0 ) {
				foreach ( $questions_query->posts as $question ) {
					$image_id       = get_post_meta( $question->ID, '_thumbnail_id', true );
					$feat_image_url = wp_get_attachment_url( $image_id );
					$feat_image_url = ( $feat_image_url ) ? esc_url( $feat_image_url ) : esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/course-default.png';
					$content       .= '<div id="ld-dashboard-course-' . $question->ID . '" class="ld-mycourse-wrap ld-mycourse-' . $question->ID . ' __web-inspector-hide-shortcut__">
									<div class="ld-mycourse-thumbnail" style="background-image: url(' . $feat_image_url . ');"></div>
									<div class="ld-mycourse-content">
										<h3><a href="' . get_permalink( $question->ID ) . '">' . $question->post_title . '</a></h3>
										<div class="ld-meta ld-course-metadata ld-course-metadata-item">
											<ul class="post_status">
												<li>Status:<span>' . $question->post_status . '</span></li>
											</ul>
											<div class="mycourse-footer">
												<div class="ld-mycourses-stats">
													<a href="' . esc_url( $dashboard_page_url ) . '?action=edit-question&ld-question=' . $question->ID . '&tab=my-questions&_lddnonce=' . esc_attr( $question_nonce ) . '" class="ld-mycourse-edit">
														<span class="material-symbols-outlined edit_square">' . esc_html__( 'edit_square', 'ld-dashboard' ) . '</span>' . esc_html__( 'Edit', 'ld-dashboard' ) . '</a>
													<a href="' . esc_url( $dashboard_page_url ) . '?action=delete-question&ld-question=' . $question->ID . '&tab=my-questions" class="ld-dashboard-element-delete-btn" data-type="question" data-type_id="' . $question->ID . '">
														<div class="delete-icons-material material-symbols-outlined">' . esc_html__( 'delete', 'ld-dashboard' ) . ' </div> ' . esc_html__( 'Delete', 'ld-dashboard' ) . '</a>
												</div>
											</div>
										</div>
									</div>
								</div>';
				}
			} else {
				$content .= '<p class="ld-dashboard-warning">' . sprintf( esc_html__( 'No %s found.', 'ld-dashboard' ), strtolower( LearnDash_Custom_Label::get_label( 'questions' ) ) ) . '</p>';
			}
			$data['content'] = $content;
			$data['next']    = ( $page < $questions_query->max_num_pages ) ? true : false;
			$data['prev']    = ( $page > 1 ) ? true : false;
			echo wp_json_encode( $data );
		} elseif ( 'assignment' === $post_type ) {
			$include_assignment_ids = array( 0 );
			if ( isset( $contents['assignments'] ) ) {
				foreach ( $contents['assignments'] as $lsn ) {
					if ( ! in_array( $lsn->ID, $include_assignment_ids ) ) {
						$include_assignment_ids[] = $lsn->ID;
					}
				}
			}
			$args = array(
				'post_type'      => 'sfwd-assignment',
				'post_status'    => array( 'publish', 'pending', 'draft' ),
				'paged'          => $page,
				'posts_per_page' => 5,
				'post__in'       => $include_assignment_ids,
			);
			if ( $course_id > 0 ) {
				$args['meta_query'] = array(
					array(
						'key'     => 'course_id',
						'value'   => $course_id,
						'compare' => '==',
					),
				);
				unset( $args['post__in'] );
			}
			if ( $lesson_id > 0 ) {
				$args['meta_query']['relation'] = 'AND';
				$args['meta_query'][]           = array(
					'key'     => 'lesson_id',
					'value'   => $lesson_id,
					'compare' => '==',
				);
			}
			$assignments       = get_posts( $args );
			$assignments_query = new WP_Query( $args );
			if ( count( $assignments_query->posts ) > 0 ) {
				foreach ( $assignments_query->posts as $assignment ) {
					$approval_status         = get_post_meta( $assignment->ID, 'approval_status', true );
					$assignment_status       = ( $approval_status && 1 == $approval_status ) ? 'Approved' : 'Not Approved';
					$assignment_status_class = ( $approval_status && 1 == $approval_status ) ? 'assignment-approved' : 'assignment-pending';
					$approve_btn_html        = ( $approval_status && 1 == $approval_status ) ? '' : '<a href="#" class="ld-mycourse-view ld-dashboard-approve-assignment-btn" data-id="' . $assignment->ID . '"><img src="' . LD_DASHBOARD_PLUGIN_URL . 'public/img/icons/file-check-alt.svg"> Approve </a>';
					$content                .= '<div id="ld-dashboard-course-' . $assignment->ID . '" class="ld-mycourse-wrap ld-mycourse-' . $assignment->ID . ' __web-inspector-hide-shortcut__">
									<div class="ld-mycourse-content">
										<h3><a href="' . get_permalink( $assignment->ID ) . '">' . $assignment->post_title . '</a></h3>
										<div class="ld-meta ld-course-metadata ld-course-metadata-item">
											<ul class="post_status">
												<li><div class="ld-dashboard-assignment-status-wrapper ' . $assignment_status_class . '-wrapper"><span class="ld-dashboard-assignment-status ' . $assignment_status_class . '">' . $assignment_status . '</span></div></li>
											</ul>
											<div class="mycourse-footer">
												<div class="ld-mycourses-stats">
													<a href="' . get_permalink( $assignment->ID ) . '" class="ld-mycourse-view">
														<span class="material-symbols-outlined visibility-icon"> visibility </span> View </a>
														' . $approve_btn_html . '
												</div>
											</div>
										</div>
									</div>
								</div>';
				}
			} else {
				$content .= '<p class="ld-dashboard-warning">' . esc_html__( 'No assignments found.', 'ld-dashboard' ) . '</p>';
			}
			$data['content'] = $content;
			$data['next']    = ( $page < $assignments_query->max_num_pages ) ? true : false;
			$data['prev']    = ( $page > 1 ) ? true : false;
			echo wp_json_encode( $data );
		}
		wp_die();
	}

	/**
	 * Ld_dashboard_acf_on_save
	 *
	 * @param  mixed $post_id Post ID.
	 * @return void
	 */
	public function ld_dashboard_acf_on_save( $post_id ) {
		if ( isset( $_POST['_acf_form'] ) ) {
			$form = json_decode( acf_decrypt( $_POST['_acf_form'] ), true );
			if ( empty( $form['record'] ) ) {
				$form['record'] = array(
					'fields' => false,
				);
			}
			if ( ! empty( $_POST ) ) {
				$post_data                = get_post( $post_id );
				$post_type                = $post_data->post_type;
				$form['record']['fields'] = array();
				foreach ( $_POST as $key => $value ) {
					if ( $key == 'acf' ) {
						foreach ( $value as $k => $inputs ) {
							$field = acf_get_field( $k );
							if ( isset( $field['name'] ) ) {
								$form['record']['fields']['post'][ $field['name'] ] = array( 'value' => $inputs );
							}
						}
					}
				}
				// Save post meta ACF.
				$this->ld_dashboard_acf_save_post_meta( $form, $post_id, $post_type );
			}
		}

	}

	public function ld_dashboard_tab_content_filter_callback() {
		if ( isset( $_GET['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			$page   = ( isset( $_GET['page'] ) ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : 1;
			$offset = ( $page - 1 ) * 10;
			$limit  = 200;
			$user   = wp_get_current_user();
			$filter = false;
			if ( isset( $_GET['search'] ) && '' !== $_GET['search'] ) {
				$filter = true;
			}
			if ( learndash_is_admin_user() ) {
				$my_args = array(
					'post_type'      => 'sfwd-courses',
					'post_status'    => array( 'publish', 'pending', 'draft' ),
					'posts_per_page' => -1,
				);
				$courses = get_posts( $my_args );
			} elseif ( in_array( 'ld_instructor', (array) $user->roles ) ) {
				$courses = self::get_instructor_courses_list();
			}
			$data    = array();
			$results = array(
				array(
					'id'   => 0,
					'text' => sprintf( esc_html__( 'Select %s', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'course' ) ),
				),
			);
			foreach ( $courses as $course ) {
				if ( $filter ) {
					$s = wp_unslash( $_GET['search'] );
					if ( false === strpos( $course->post_title, $s ) && false === strpos( $course->post_title, strtolower( $s ) ) && false === strpos( $course->post_title, strtoupper( $s ) ) ) {
						continue;
					}
				}
				$tmp       = array(
					'id'   => $course->ID,
					'text' => $course->post_title,
				);
				$results[] = $tmp;
			}
			$data['count']   = count( $results );
			$data['results'] = array_slice( $results, $offset, $limit );

			echo wp_json_encode( $data );
		}
		exit;
	}

	public function ld_dashboard_acf_save_post_meta( $form, $post_id, $post_type ) {
		if ( isset( $form['record']['fields']['post'] ) ) {
			global $wpdb;
			$ques_pro_id        = '';
			$dashboard_page_url = Ld_Dashboard_Functions::instance()->ld_dashboard_get_url( 'dashboard' );
			$function_obj       = Ld_Dashboard_Functions::instance()->ld_dashboard_settings_data();
			$settings           = $function_obj['monetization_settings'];

			$fields    = $form['record']['fields']['post'];
			$post_data = array(
				'ID' => $post_id,
			);

			$post_saved_transient_name = 'ld_dashboard_post_' . $post_id . '_saved';
			if ( false !== get_transient( $post_saved_transient_name ) ) {
				delete_transient( $post_saved_transient_name );
			}

			foreach ( $fields as $key => $field ) {
				$value = $field['value'];
				if ( strpos( $key, 'ldd_' ) !== false && '' != $value ) {
					if ( strpos( $key, 'title' ) !== false ) {
						$post_data['post_title'] = $value;
						$post_name               = strtolower( $value );
						$post_name               = str_replace( ' ', '-', $post_name );
						$post_data['post_name']  = $post_name;
					} elseif ( strpos( $key, 'status' ) !== false ) {
						$post_data['post_status'] = $value;
					} elseif ( strpos( $key, 'content' ) !== false ) {
						$post_data['post_content'] = $value;
					}
				}
			}
			if ( count( $post_data ) > 1 ) {
				wp_update_post( $post_data );
			}

			$field_types = array();
			if ( isset( $_POST['acf'] ) ) {
				foreach ( $_POST['acf'] as $fkey => $val ) {
					$field_data                         = get_field_object( $fkey );
					$field_types[ $field_data['name'] ] = $field_data['type'];
				}
			}
			if ( 'sfwd-courses' === $post_type ) {
				$data                    = array();
				$steps                   = array(
					'h' => array(
						'sfwd-lessons' => array(),
						'sfwd-quiz'    => array(),
					),
				);
				$data['ld_course_steps'] = array(
					'steps'                       => $steps,
					'course_id'                   => $post_id,
					'version'                     => '3.4.2.1',
					'empty'                       => '',
					'course_builder_enabled'      => '',
					'course_shared_steps_enabled' => '',
					'steps_count'                 => 1,
				);
				foreach ( $fields as $key => $field ) {

					if ( strpos( $key, 'sfwd-' ) !== false ) {
						$new_key = str_replace( '_cld', '', $key );
						$value   = $field['value'];
						if ( 'sfwd-courses_course_lesson_per_page' === $new_key ) {
							$value = ( $field['value'] == 1 ) ? 'CUSTOM' : '';
						}

						if ( 'sfwd-courses_course_disable_content_table' === $new_key ) {
							$value = ( $field['value'] == 'after' ) ? '' : 'on';
						}

						if ( 'sfwd-courses_course_disable_lesson_progression' === $new_key ) {
							$value = ( $field['value'] == 'sfwd_linear' ) ? '' : 'on';
						}

						if ( 'sfwd-courses_ir_shared_instructor_ids' === $new_key ) {
							$data['_ld_instructor_ids'] = $value;
						}

						if ( 'sfwd-courses_course_billing_cycle' === $new_key ) {
							if ( is_array( $value ) ) {
								$data['course_price_billing_p3'] = ( isset( $value['field_622201dca91fa'] ) ) ? $value['field_622201dca91fa'] : 0;
								$data['course_price_billing_t3'] = ( isset( $value['field_622201f2a91fb'] ) ) ? $value['field_622201f2a91fb'] : '';
							}
						}

						if ( 'sfwd-courses_course_prerequisite_compare' === $new_key ) {
							$data['courses_course_prerequisite_compare'] = $value;
						}

						if ( 'sfwd-courses_course_prerequisite' === $new_key ) {
							$data['courses_course_prerequisite'][] = $value;
						}

						if ( 'true_false' === $field_types[ $key ] ) {
							$data['_sfwd-courses'][ $new_key ] = ( 1 == $value ) ? 'on' : $value;
						} else {
							$data['_sfwd-courses'][ $new_key ] = $value;
						}

						$data['_ld_course_steps_count'] = 1;

						if ( 'sfwd-courses_certificate' === $new_key ) {
							$data['_ld_certificate'] = $value;
						}
						if ( 'sfwd-courses_course_price_type' === $new_key ) {
							$data['_ld_price_type'] = $value;
						}
						if ( 'sfwd-courses_course_points' === $new_key ) {
							$data['course_points'] = $value;
						}
						if ( 'sfwd-courses_course_price_billing_p3' === $new_key ) {
							$data['course_price_billing_p3'] = $value;
						}
						if ( 'sfwd-courses_course_price_billing_t3' === $new_key ) {
							$data['course_price_billing_t3'] = ( '' !== $value ) ? $value : 'D';
						}
						if ( 'sfwd-courses_course_trial_duration_p1' === $new_key ) {
							$data['course_trial_duration_p1'] = $value;
						}
						if ( 'sfwd-courses_course_trial_duration_t1' === $new_key ) {
							$data['course_trial_duration_t1'] = $value;
						}
					}
				}

				foreach ( $data as $meta_key => $meta_value ) {
					update_post_meta( $post_id, $meta_key, $meta_value );
				}
				$ld_course_steps_object = LDLMS_Factory_Post::course_steps( $post_id );
				$ld_course_steps        = $ld_course_steps_object->get_steps( 'h' );
				if ( isset( $_POST['ld_dashboard_course_builder'] ) ) {

					if ( isset( $ld_course_steps['sfwd-lessons'] ) ) {
						$lessons         = $ld_course_steps['sfwd-lessons'];
						$course_progress = wp_unslash( $_POST['ld_dashboard_course_builder'] );

						$new_course_progress = array();
						foreach ( $course_progress as $lesson_id ) {
							$temp = array();
							$new_course_progress['sfwd-lessons'][ $lesson_id ] = isset( $lessons[ $lesson_id ] ) ? $lessons[ $lesson_id ] : '';
							if ( isset( $_POST['ld_dashboard_lesson_builder'] ) ) {
								$topics  = ( isset( $_POST['ld_dashboard_lesson_builder'][ $lesson_id ]['topic'] ) ) ? wp_unslash( $_POST['ld_dashboard_lesson_builder'][ $lesson_id ]['topic'] ) : array();
								$quizzes = ( isset( $_POST['ld_dashboard_lesson_builder'][ $lesson_id ]['quiz'] ) ) ? wp_unslash( $_POST['ld_dashboard_lesson_builder'][ $lesson_id ]['quiz'] ) : array();

								if ( ! empty( $topics ) ) {

									foreach ( $topics as $topic ) :
										$get_topic_meta = get_post_meta( $topic, '_sfwd-topic', true );
										$get_topic_meta = ( is_array( $get_topic_meta ) && ! empty( $get_topic_meta ) ) ? $get_topic_meta : array();
										if ( array_key_exists( 'sfwd-topic_course', $get_topic_meta ) && isset( $get_topic_meta['sfwd-topic_course'] ) ) {
											$get_topic_meta['sfwd-topic_course'] = $post_id;
										} else {
											$get_topic_meta['sfwd-topic_course'] = $post_id;
										}

										if ( array_key_exists( 'sfwd-topic_lesson', $get_topic_meta ) && isset( $get_topic_meta['sfwd-topic_lesson'] ) ) {
											$get_topic_meta['sfwd-topic_lesson'] = $lesson_id;
										} else {
											$get_topic_meta['sfwd-topic_lesson'] = $lesson_id;
										}

										update_post_meta( $topic, '_sfwd-topic', $get_topic_meta );
										update_post_meta( $topic, 'course_id', $post_id );
										update_post_meta( $topic, 'lesson_id', $lesson_id );
										$temp['sfwd-topic'][ $topic ] = isset( $lessons[ $lesson_id ]['sfwd-topic'][ $topic ] ) ? $lessons[ $lesson_id ]['sfwd-topic'][ $topic ] : '';
									endforeach;
								} else {
									$temp['sfwd-topic'] = array();
								}
								if ( ! empty( $quizzes ) ) {

									foreach ( $quizzes as $quiz ) :
										$get_quiz_meta  = get_post_meta( $quiz, '_sfwd-quiz', true );
										$get_topic_meta = ( is_array( $get_quiz_meta ) && ! empty( $get_quiz_meta ) ) ? $get_quiz_meta : array();
										if ( array_key_exists( 'sfwd-quiz_course', $get_quiz_meta ) && isset( $get_quiz_meta['sfwd-quiz_course'] ) ) {
											$get_quiz_meta['sfwd-quiz_course'] = $post_id;
										} else {
											$get_quiz_meta['sfwd-quiz_course'] = $post_id;
										}

										if ( array_key_exists( 'sfwd-quiz_lesson', $get_quiz_meta ) && isset( $get_quiz_meta['sfwd-quiz_lesson'] ) ) {
											$get_quiz_meta['sfwd-quiz_lesson'] = $lesson_id;
										} else {
											$get_quiz_meta['sfwd-quiz_lesson'] = $lesson_id;
										}

										update_post_meta( $quiz, '_sfwd-quiz', $get_quiz_meta );
										update_post_meta( $quiz, 'course_id', $post_id );
										update_post_meta( $quiz, 'lesson_id', $lesson_id );

										$temp['sfwd-quiz'][ $quiz ] = isset( $lessons[ $lesson_id ]['sfwd-quiz'][ $quiz ] ) ? $lessons[ $lesson_id ]['sfwd-quiz'][ $quiz ] : '';

									endforeach;
								} else {
									$temp['sfwd-quiz'] = array();
								}
								$new_course_progress['sfwd-lessons'][ $lesson_id ] = $temp;

							} else {
								$new_course_progress['sfwd-lessons'][ $lesson_id ] = array();
							}
						}
						$new_course_progress['sfwd-quiz'] = $ld_course_steps['sfwd-quiz'];
						$ld_course_steps_object->set_steps( $new_course_progress );
					}
				} else {
					$new_course_progress = array(
						'sfwd-lessons' => array(),
						'sfwd-quiz'    => array(),
					);
					$ld_course_steps_object->set_steps( $new_course_progress );
				}

				/* Add Course Section */
				$sections = array();
				if ( isset( $_POST['course_sections'] ) ) {
					foreach ( $_POST['course_sections'] as $section_key => $section_value ) {
						$sections[] = array(
							'order'      => $section_key,
							'ID'         => rand( 1111111111111, 9999999999999 ),
							'post_title' => $section_value,
							'url'        => '',
							'edit_link'  => '',
							'tree'       => array(),
							'expanded'   => false,
							'type'       => 'section-heading',
						);
					}
				}
				if ( ! empty( $sections ) ) {
					$sections_json = wp_slash( wp_json_encode( array_values( $sections ), JSON_UNESCAPED_UNICODE ) );
					update_post_meta( $post_id, 'course_sections', $sections_json );
				} else {
					delete_post_meta( $post_id, 'course_sections' );
				}
				/*  Finish Course Section */
				$_course_price      = get_post_meta( $post_id, 'sfwd-courses_course_price_cld', true );
				$_course_price_type = get_post_meta( $post_id, 'sfwd-courses_course_price_type_cld', true );
				$course_product_id  = get_post_meta( $post_id, 'sfwd-courses_course_product_id', true );

				if ( $_course_price != '' && $_course_price_type == 'closed' && class_exists( 'WooCommerce' ) && class_exists( 'Learndash_WooCommerce' ) && isset( $settings['monetize_by'] ) && $settings['monetize_by'] == '1' ) {

					$is_update = false;
					if ( $course_product_id ) {
						$is_update = true;
					}
					$course = get_post( $post_id );

					$_sfwd_courses = get_post_meta( $post_id, '_sfwd-courses', true );

					if ( $is_update ) {
						$productObj = wc_get_product( $course_product_id );
						$productObj->set_description( $course->post_content ); // set product description
						$productObj->set_short_description( ld_dashboard_get_course_excerpt( $course->post_content ) ); // set product description
						$productObj->set_price( $_course_price ); // set product price
						$productObj->set_regular_price( $_course_price ); // set product regular price
						$productObj->set_sold_individually( true );
						$product_id = $productObj->save();
						if ( $productObj->is_type( 'subscription' ) ) {
							update_post_meta( $course_product_id, '_subscription_price', $_course_price );
						}

						$_sfwd_courses['sfwd-courses_custom_button_url'] = get_permalink( $product_id );
						update_post_meta( $post_id, '_sfwd-courses', $_sfwd_courses );

						$term = get_term_by( 'slug', 'course', 'product_type' );
						if ( ! empty( $term ) ) {
							$term_id = $term->term_id;
							wp_set_object_terms( $product_id, $term_id, 'product_type' );
						}
					} else {

						$productObj = new \WC_Product();
						$productObj->set_name( $course->post_title );
						$productObj->set_description( $course->post_content ); // set product description
						$productObj->set_short_description( ld_dashboard_get_course_excerpt( $course->post_content ) ); // set product short description
						$productObj->set_status( 'publish' );
						$productObj->set_price( $_course_price ); // set product price
						$productObj->set_regular_price( $_course_price ); // set product regular price
						$productObj->set_sold_individually( true );

						$product_id = $productObj->save();
						if ( $product_id ) {
							update_post_meta( $post_id, 'sfwd-courses_course_product_id', $product_id );
							// Mark product for woocommerce
							update_post_meta( $product_id, '_sfwd-courses_product', 'yes' );

							$coursePostThumbnail = get_post_meta( $post_id, '_thumbnail_id', true );
							if ( $coursePostThumbnail ) {
								set_post_thumbnail( $product_id, $coursePostThumbnail );
							}
						}

						$_sfwd_courses['sfwd-courses_custom_button_url'] = get_permalink( $product_id );
						update_post_meta( $post_id, '_sfwd-courses', $_sfwd_courses );

						$_related_course   = array();
						$_related_course[] = $post_id;
						update_post_meta( $product_id, '_related_course', $_related_course );

						$term = get_term_by( 'slug', 'course', 'product_type' );
						if ( ! empty( $term ) ) {
							$term_id = $term->term_id;
							wp_set_object_terms( $product_id, $term_id, 'product_type' );
						}
					}
				}
			} elseif ( 'sfwd-lessons' === $post_type ) {
				$data = array();
				foreach ( $fields as $key => $field ) {
					if ( strpos( $key, 'sfwd-' ) !== false ) {
						$new_key = str_replace( '_cld', '', $key );

						if ( 'true_false' === $field_types[ $key ] ) {
							$value = ( $field['value'] == 1 ) ? 'on' : $field['value'];
						} else {
							$value = $field['value'];
						}

						if ( 'sfwd-lessons_auto_approve_assignment' == $new_key ) {
							$value = ( $value == 'off' ) ? '' : $value;
						}
						if ( 'sfwd-lessons_course' == $new_key ) {
							$data['course_id'] = $value;
						}

						if ( 'sfwd-lessons_schedule_visible_after' == $new_key ) {
							if ( 'immediate' === $value ) {
								$value = '';
								$data['sfwd-lessons_visible_after_specific_date'] = '';
							} elseif ( 'enroll' === $value ) {
								$value = $fields['sfwd-lessons_visible_after']['value'];
								$data['sfwd-lessons_visible_after_specific_date'] = '';
							} elseif ( 'specific' === $value ) {
								$value = '';
							}
						}

						if ( 'sfwd-lessons_visible_after_specific_date' == $new_key && 'specific' === $fields['sfwd-lessons_visible_after']['value'] ) {
							$value = strtotime( $value );
						}

						$data['_sfwd-lessons'][ $new_key ] = $value;
					}
				}
				foreach ( $data as $meta_key => $meta_value ) {
					update_post_meta( $post_id, $meta_key, $meta_value );
				}
				// Delete lesson transient.
				$transient_name = 'ldd_instructor_' . get_current_user_id() . '_lessons';
				if ( false !== get_transient( $transient_name ) ) {
					delete_transient( $transient_name );
				}
			} elseif ( 'sfwd-topic' === $post_type ) {
				$data = array();
				foreach ( $fields as $key => $field ) {
					if ( strpos( $key, 'sfwd-' ) !== false ) {
						$new_key = str_replace( '_cld', '', $key );

						if ( 'true_false' === $field_types[ $key ] ) {
							$value = ( $field['value'] == 1 ) ? 'on' : $field['value'];
						} else {
							$value = $field['value'];
						}

						if ( 'sfwd-topic_auto_approve_assignment' == $new_key ) {
							$value = ( $value == 'off' ) ? '' : $value;
						}

						if ( 'sfwd-topic_course' === $new_key ) {
							$data['course_id'] = $value;
						}

						if ( 'sfwd-topic_lesson' === $new_key ) {
							$data['lesson_id'] = $value;
						}
						$data['_sfwd-topic'][ $new_key ] = $value;
					}
				}
				if ( isset( $_POST['sfwd-topic_lesson_cld'] ) ) {
					$data['_sfwd-topic']['sfwd-topic_lesson'] = sanitize_text_field( wp_unslash( $_POST['sfwd-topic_lesson_cld'] ) );
					$data['lesson_id']                        = sanitize_text_field( wp_unslash( $_POST['sfwd-topic_lesson_cld'] ) );
				}
				foreach ( $data as $meta_key => $meta_value ) {
					update_post_meta( $post_id, $meta_key, $meta_value );
				}
				// Delete topic transient.
				$transient_name = 'ldd_instructor_' . get_current_user_id() . '_lessons_content';
				if ( false !== get_transient( $transient_name ) ) {
					delete_transient( $transient_name );
				}
			} elseif ( 'sfwd-quiz' === $post_type ) {
				global $wpdb;
				$data = array();

				foreach ( $fields as $key => $field ) {
					if ( strpos( $key, 'sfwd-' ) !== false ) {
						$new_key = str_replace( '_cld', '', $key );
						$value   = $field['value'];

						if ( 'sfwd-quiz_threshold' == $new_key ) {
							$value = $value / 100;
						}

						if ( 'sfwd-quiz_timeLimit' == $new_key ) {
							$tm    = explode( ':', $value );
							$value = ( $tm[0] * 3600 ) + ( $tm[1] * 60 ) + $tm[2];
						}
						if ( 'sfwd-quiz_course' == $new_key ) {
							$value = ( $field['value'] == '' ) ? 0 : $field['value'];
						}

						if ( 'sfwd-quiz_lesson' == $new_key ) {
							$value = ( $field['value'] == '' ) ? 0 : $field['value'];
						}

						if ( 'sfwd-quiz_certificate' == $new_key ) {
							$data['_ld_certificate'] = $value;
						}
						if ( 'sfwd-quiz_certificate' == $new_key && $field['value'] == '' ) {
							$value = ( $field['value'] == '' ) ? '' : $field['value'];
						}
						if ( 'sfwd-quiz_threshold' == $new_key ) {
							$data['_ld_certificate_threshold'] = $value;
						}
						if ( 'sfwd-quiz_certificate' == $new_key && $field['value'] == '' ) {
							$data['_sfwd-quiz']['sfwd-quiz_threshold'] = $value;
						}

						if ( 'sfwd-quiz_quiz_time_limit_enabled' == $new_key ) {
							$value = ( $field['value'] == 1 ) ? 'on' : $field['value'];
						}

						if ( 'sfwd-quiz_email_enabled' == $new_key ) {
							$value = ( $field['value'] == 1 ) ? 'on' : $field['value'];
						}
						if ( 'sfwd-quiz_emailNotification' == $new_key ) {
							$value = ( $field['value'] == 'registered_user_only' ) ? 1 : $field['value'];
						}
						if ( 'sfwd-quiz_email_enabled_admin' == $new_key ) {
							$value = ( $field['value'] == 1 ) ? 'on' : $field['value'];
						}
						if ( 'sfwd-quiz_advanced_settings' == $new_key ) {
							$value = ( $field['value'] == 1 ) ? 'on' : $field['value'];
						}
						if ( 'sfwd-quiz_timeLimitCookie_enabled' == $new_key ) {
							$value = ( $field['value'] == 1 ) ? 'on' : $field['value'];
						}
						if ( 'sfwd-quiz_toplistDataShowIn_enabled' == $new_key ) {
							$value = ( $field['value'] == 1 ) ? 'on' : $field['`value'];
						}

						if ( 'sfwd-quiz_quiz_time_limit_enabled' == $new_key ) {
							$value     = ( $field['value'] == 1 ) ? 'on' : $field['value'];
							$total_sec = 0;
							if ( 'on' == $value ) {
								$total_sec += ( $fields['quiz_timeLimit_timer_hr']['value'] * 3600 );
								$total_sec += ( $fields['quiz_timeLimit_timer_min']['value'] * 60 );
								$total_sec += $fields['quiz_timeLimit_timer_sec']['value'];
							}
							$data['_sfwd-quiz']['sfwd-quiz_timeLimit'] = $total_sec;
						}

						if ( 'sfwd-quiz_timeLimit' == $new_key ) {
							continue;
						}
						if ( 'sfwd-quiz_course' === $new_key ) {
							$data['course_id'] = $value;
						}

						$data['_sfwd-quiz'][ $new_key ] = $value;
					}
				}

				if ( isset( $_POST['sfwd-quiz_lesson_cld'] ) ) {
					$data['_sfwd-quiz']['sfwd-quiz_lesson'] = sanitize_text_field( wp_unslash( $_POST['sfwd-quiz_lesson_cld'] ) );
					$data['lesson_id']                      = sanitize_text_field( wp_unslash( $_POST['sfwd-quiz_lesson_cld'] ) );
				}
				$result_text            = array();
				$result_text['text']    = array( '' );
				$result_text['prozent'] = array( 0 );
				$result_text['activ']   = array( 1 );
				$toplist_data           = array(
					'toplistDataAddPermissions' => 1,
					'toplistDataSort'           => 1,
					'toplistDataAddMultiple'    => '',
					'toplistDataAddBlock'       => 0,
					'toplistDataShowLimit'      => 0,
					'toplistDataShowIn'         => 0,
					'toplistDataCaptcha'        => '',
					'toplistDataAddAutomatic'   => '',
				);

				if ( isset( $_POST['ld_quiz_builder_remove'] ) ) {
					$remove_questions = wp_unslash( $_POST['ld_quiz_builder_remove'] );
					if ( count( $remove_questions ) > 0 ) {
						foreach ( $remove_questions as $question_id ) {
							$remove_ques_data = get_post_meta( $question_id, '_sfwd-question', true );
							if ( is_array( $remove_ques_data ) && isset( $remove_ques_data['sfwd-question_quiz'] ) ) {
								unset( $remove_ques_data['sfwd-question_quiz'] );
							}
							$remove_ques_data['sfwd-question_quiz'] = 0;
							update_post_meta( $question_id, 'quiz_id', 0 );
							update_post_meta( $question_id, 'sfwd-question_quiz_cld', 0 );
							update_post_meta( $question_id, '_sfwd-question', $remove_ques_data );
						}
					}
				}
				if ( isset( $_POST['ld_quiz_builder'] ) ) {
					$quiz_builder = array();
					$questions    = wp_unslash( $_POST['ld_quiz_builder'] );
					if ( count( $questions ) > 0 ) {
						foreach ( $questions as $question_id ) {
							$ques_pro_id   = get_post_meta( $question_id, 'question_pro_id', true );
							$question_data = get_post_meta( $question_id, '_sfwd-question', true );
							if ( is_array( $question_data ) && isset( $question_data['sfwd-question_quiz'] ) ) {
								unset( $question_data['sfwd-question_quiz'] );
							}
							$question_data['sfwd-question_quiz'] = $post_id;
							update_post_meta( $question_id, 'quiz_id', $post_id );
							update_post_meta( $question_id, 'sfwd-question_quiz_cld', $post_id );
							update_post_meta( $question_id, '_sfwd-question', $question_data );
							$quiz_builder[ $question_id ] = $ques_pro_id;
						}
					}
					$data['ld_quiz_questions'] = $quiz_builder;
				} else {
					$data['ld_quiz_questions'] = array();
				}
				$learndash_data_settings = get_option( 'learndash_data_settings' );
				$quiz_prefixes           = $learndash_data_settings['rename-wpproquiz-tables']['prefixes']['current'];
				$quiz_pro_id             = get_post_meta( $post_id, 'quiz_pro_id', true );
				if ( $quiz_pro_id == '' ) {
					$wpdb->insert(
						$wpdb->prefix . $quiz_prefixes . 'pro_quiz_master',
						array(
							'name'                         => $fields['ldd_post_title']['value'],
							'text'                         => 'ABCD',
							'result_text'                  => serialize( $result_text ),
							'result_grade_enabled'         => 1,
							'title_hidden'                 => 1,
							'btn_restart_quiz_hidden'      => 0,
							'btn_view_question_hidden'     => 0,
							'question_random'              => 0,
							'answer_random'                => 0,
							'time_limit'                   => ( isset( $data['_sfwd-quiz']['sfwd-quiz_timeLimit'] ) ) ? $data['_sfwd-quiz']['sfwd-quiz_timeLimit'] : 0,
							'statistics_on'                => 1,
							'statistics_ip_lock'           => 0,
							'show_points'                  => 0,
							'quiz_run_once'                => 0,
							'quiz_run_once_type'           => 0,
							'quiz_run_once_cookie'         => 0,
							'quiz_run_once_time'           => 0,
							'numbered_answer'              => 0,
							'hide_answer_message_box'      => 0,
							'disabled_answer_mark'         => 0,
							'show_max_question'            => 0,
							'show_max_question_value'      => 0,
							'show_max_question_percent'    => 0,
							'toplist_activated'            => 0,
							'toplist_data'                 => serialize( $toplist_data ),
							'show_average_result'          => 0,
							'prerequisite'                 => 0,
							'quiz_modus'                   => ( isset( $data['_sfwd-quiz']['sfwd-quiz_quizModus'] ) ) ? $data['_sfwd-quiz']['sfwd-quiz_quizModus'] : 0,
							'show_review_question'         => 0,
							'quiz_summary_hide'            => 1,
							'skip_question_disabled'       => 1,
							'email_notification'           => 0,
							'user_email_notification'      => 0,
							'show_category_score'          => 0,
							'hide_result_correct_question' => 0,
							'hide_result_quiz_time'        => 0,
							'hide_result_points'           => 0,
							'autostart'                    => 0,
							'forcing_question_solve'       => 0,
							'hide_question_position_overview' => 1,
							'hide_question_numbering'      => 1,
							'form_activated'               => 0,
							'form_show_position'           => 0,
							'start_only_registered_user'   => 0,
							'questions_per_page'           => ( isset( $data['_sfwd-quiz']['sfwd-quiz_quizModus_multiple_questionsPerPage'] ) ) ? $data['_sfwd-quiz']['sfwd-quiz_quizModus_multiple_questionsPerPage'] : 0,
							'sort_categories'              => 0,
							'show_category'                => 0,
						)
					);
					$quiz_pro_id = $wpdb->insert_id;
				} else {
					$wpdb->update(
						$wpdb->prefix . $quiz_prefixes . 'pro_quiz_master',
						array(
							'time_limit'         => ( isset( $data['_sfwd-quiz']['sfwd-quiz_timeLimit'] ) ) ? $data['_sfwd-quiz']['sfwd-quiz_timeLimit'] : 0,
							'quiz_modus'         => ( isset( $data['_sfwd-quiz']['sfwd-quiz_quizModus'] ) ) ? $data['_sfwd-quiz']['sfwd-quiz_quizModus'] : 0,
							'questions_per_page' => ( isset( $data['_sfwd-quiz']['sfwd-quiz_quizModus_multiple_questionsPerPage'] ) ) ? $data['_sfwd-quiz']['sfwd-quiz_quizModus_multiple_questionsPerPage'] : 0,
						),
						array(
							'id' => $quiz_pro_id,
						)
					);
				}
				$data['_sfwd-quiz']['sfwd-quiz_quiz_pro']   = $quiz_pro_id;
				$data[ 'quiz_pro_primary_' . $quiz_pro_id ] = $quiz_pro_id;
				$data['quiz_pro_id']                        = $quiz_pro_id;
				$data[ 'quiz_pro_id_' . $quiz_pro_id ]      = $quiz_pro_id;
				foreach ( $data as $meta_key => $meta_value ) {
					update_post_meta( $post_id, $meta_key, $meta_value );
				}
				// Delete quiz transient.
				$transient_name = 'ldd_instructor_' . get_current_user_id() . '_lessons_content';
				if ( false !== get_transient( $transient_name ) ) {
					delete_transient( $transient_name );
				}
			} elseif ( 'sfwd-question' === $post_type ) {
				$data = array();
				foreach ( $fields as $key => $field ) {
					if ( strpos( $key, 'sfwd-' ) !== false ) {
						$new_key = str_replace( '_cld', '', $key );
						$value   = $field['value'];
						if ( 'sfwd-question_points' === $new_key ) {
							$data['question_points'] = $value;
						}
						if ( 'sfwd-question_quiz' === $new_key ) {
							$quiz_builder = get_post_meta( $value, 'ld_quiz_questions', true );
							if ( is_array( $quiz_builder ) && ! empty( $quiz_builder ) ) {
								if ( ! array_key_exists( $post_id, $quiz_builder ) ) {
									$quiz_builder[ $post_id ] = $ques_pro_id;
								}
							} else {
								$quiz_builder             = array();
								$quiz_builder[ $post_id ] = $ques_pro_id;
							}
							$ques_pro_id     = get_post_meta( $post_id, 'question_pro_id', true );
							$data['quiz_id'] = $value;
							update_post_meta( $value, 'ld_quiz_questions', $quiz_builder );
						}
						$data['_sfwd-question'][ $new_key ] = $value;
					}
				}

				foreach ( $data as $meta_key => $meta_value ) {
					update_post_meta( $post_id, $meta_key, $meta_value );
				}
				$this->ld_dashboard_question_answer_field( $form, $_POST, $post_id );
				$transient_name = 'ldd_instructor_' . get_current_user_id() . '_lessons_content';
				if ( false !== get_transient( $transient_name ) ) {
					delete_transient( $transient_name );
				}
			} elseif ( 'sfwd-certificates' === $post_type ) {
				$data = array();
				foreach ( $fields as $key => $field ) {
					$value = $field['value'];
					if ( 'pdf_page_format' === $key ) {
						$data['pdf_page_format'] = $value;
					}
					if ( 'pdf_page_orientation' === $key ) {
						$data['pdf_page_orientation'] = $value;
					}
				}
				update_post_meta( $post_id, 'learndash_certificate_options', $data );
			} elseif ( 'groups' === $post_type ) {
				$data = array();
				foreach ( $fields as $key => $field ) {
					$new_key = str_replace( '_cld', '', $key );
					$value   = $field['value'];
					if ( in_array( $new_key, array( 'groups_group_materials_enabled', 'groups_group_courses_order_enabled' ) ) ) {
						$value = ( $value == 1 ) ? 'on' : $value;
					}
					if ( 'groups_group_courses_per_page_enabled' === $new_key ) {
						$value = ( $value == 1 ) ? 'CUSTOM' : '';
					}
					if ( 'groups_group_price_billing_p3' === $new_key ) {
						update_post_meta( $post_id, 'group_price_billing_p3', $value );
					}
					if ( 'groups_group_price_billing_t3' === $new_key ) {
						update_post_meta( $post_id, 'group_price_billing_t3', $value );
					}
					if ( 'groups_group_trial_duration_p1' === $new_key ) {
						update_post_meta( $post_id, 'group_trial_duration_p1', $value );
					}
					if ( 'groups_group_trial_duration_t1' === $new_key ) {
						update_post_meta( $post_id, 'group_trial_duration_t1', $value );
					}
					if ( 'group_courses' === $new_key ) {
						$group_course_ids = learndash_group_enrolled_courses( $post_id );
						$current_str      = strtotime( 'now' );
						if ( ! empty( $group_course_ids ) ) {
							foreach ( $group_course_ids as $course_id ) {
								delete_post_meta( $course_id, 'learndash_group_enrolled_' . $post_id );
							}
						}
						if ( is_array( $value ) && ! empty( $value ) ) {
							foreach ( $value as $course_id ) {
								update_post_meta( $course_id, 'learndash_group_enrolled_' . $post_id, $current_str );
							}
						}
						continue;
					}
					if ( 'group_users' === $new_key ) {
						$temp           = array();
						$group_user_ids = learndash_get_groups_user_ids( $post_id );
						if ( is_array( $group_user_ids ) && ! empty( $group_user_ids ) ) {
							foreach ( $group_user_ids as $user_id ) {
								delete_user_meta( $user_id, 'learndash_group_users_' . $post_id );
							}
						}
						if ( is_array( $value ) && ! empty( $value ) ) {
							foreach ( $value as $user_id ) {
								update_user_meta( $user_id, 'learndash_group_users_' . $post_id, $post_id );
							}
						}
						continue;
					}
					if ( 'group_leaders' === $new_key ) {
						$group_leader_ids = learndash_get_groups_administrator_ids( $post_id );
						if ( is_array( $group_leader_ids ) && ! empty( $group_leader_ids ) ) {
							foreach ( $group_leader_ids as $user_id ) {
								delete_user_meta( $user_id, 'learndash_group_leaders_' . $post_id );
							}
						}
						if ( is_array( $value ) && ! empty( $value ) ) {
							foreach ( $value as $user_id ) {
								update_user_meta( $user_id, 'learndash_group_leaders_' . $post_id, $post_id );
							}
						}
						continue;
					}
					$data[ $new_key ] = $value;
				}

				update_post_meta( $post_id, '_groups', $data );
			}
		}
	}

	public function ld_dashboard_question_answer_field( $form, $post_data, $post_id ) {
		$fields        = get_post( $post_id );
		$new_post_data = array();
		$form_fields   = $form['record']['fields']['post'];
		$answer_type   = $form['record']['fields']['post']['sfwd-question_answer_type']['value'];
		foreach ( $fields as $key => $field ) {
			$new_post_data[ $key ] = $field;
		}
		if ( isset( $post_data['sfwd-question_single_answer_cld'] ) ) {
			$quiz_id      = get_post_meta( $post_id, 'quiz_id', true );
			$answers      = $post_data['sfwd-question_single_answer_cld'];
			$answer_order = ( isset( $_POST['answer_sort_order'] ) && '' !== $_POST['answer_sort_order'] ) ? wp_unslash( $_POST['answer_sort_order'] ) : false;
			foreach ( $answers as $key1 => $answer ) {
				$answers[ $key1 ]['points'] = 0;
				if ( isset( $answer['correct'] ) ) {
					unset( $answers[ $key1 ]['correct'] );
					$answers[ $key1 ]['correct'] = 1;
				}
				if ( isset( $answer['allow_html'] ) && 'on' == $answer['allow_html'] ) {
					$answers[ $key1 ]['html'] = 1;
				}
				if ( isset( $answer['sort_string_html'] ) && 'on' == $answer['sort_string_html'] ) {
					$answers[ $key1 ]['sortStringHtml'] = 1;
				}
				$answers[ $key1 ]['graded'] = 1;
			}
			if ( false !== $answer_order ) {
				$answer_order  = str_replace( '[', '', $answer_order );
				$answer_order  = str_replace( ']', '', $answer_order );
				$sequence      = explode( ',', $answer_order );
				$ordered_array = array();
				if ( count( $sequence ) > 1 ) {
					foreach ( $sequence as $pos ) {
						$ordered_array[] = $answers[ $pos ];
					}
					$answers = $ordered_array;
				}
			}
			update_post_meta( $post_id, 'ld_dashboard_answer', $answers );
			$new_post_data['answerData']                    = $answers;
			$new_post_data['matrixSortAnswerCriteriaWidth'] = 20;
			$new_post_data['action']                        = 'editpost';
			$new_post_data['post_ID']                       = $post_id;
			$new_post_data['quizId']                        = $quiz_id;
			$new_post_data['originalaction']                = 'editpost';
			$new_post_data['visibility']                    = 'public';
			$new_post_data['answerType']                    = $answer_type;
			$new_post_data['_thumbnail_id']                 = 1;
			$new_post_data['original_post_status']          = 'auto-draft';
			$new_post_data['auto_draft']                    = '';
			$new_post_data['points']                        = $form_fields['sfwd-question_points_cld']['value'];
			$new_post_data['ld_post_edit_current_tab]']     = '';
			$new_post_data['samplepermalinknonce]']         = '';
			$new_post_data['_acf_screen]']                  = 'POST';
			$new_post_data['correctMsg']                    = $form_fields['sfwd-question_correct_answer_cld']['value'];
			$new_post_data['incorrectMsg']                  = $form_fields['sfwd-question_incorrect_answer_cld']['value'];
			$new_post_data['tipEnabled']                    = ( isset( $form_fields['sfwd-question_hint_optional_cld']['value'][0] ) && 'on' == $form_fields['sfwd-question_hint_optional_cld']['value'][0] ) ? 1 : 0;
			$new_post_data['tipMsg']                        = isset( $form_fields['sfwd-question_hint_optional_content_cld']['value'] ) ? $form_fields['sfwd-question_hint_optional_content_cld']['value'] : '';
		}
		foreach ( $new_post_data as $key => $value ) {
			$_POST[ $key ] = $value;
		}

			$question_pro_id = get_post_meta( $post_id, 'question_pro_id', true );
		if ( ! empty( $question_pro_id ) ) {
			$question_pro_id = absint( $question_pro_id );
		} else {
			$question_pro_id = 0;
		}

			$question_pro_id_new = learndash_update_pro_question( $question_pro_id, $new_post_data );

		if ( ( ! empty( $question_pro_id_new ) ) && ( ( absint( $question_pro_id_new ) ) !== ( absint( $question_pro_id ) ) ) ) {
			update_post_meta( $post_id, 'question_pro_id', absint( $question_pro_id_new ) );
			learndash_set_question_quizzes_dirty( $post_id );
		}
		learndash_proquiz_sync_question_fields( $post_id, $question_pro_id_new );
		learndash_proquiz_sync_question_category( $post_id, $question_pro_id_new );
	}


	public function ld_dashboard_learndash_settings_fields( $setting_option_fields, $settings_metabox_key ) {
		if ( isset( $_GET['post'] ) ) {
			$post_id    = sanitize_text_field( wp_unslash( $_GET['post'] ) );
			$_sfwd_quiz = get_post_meta( $post_id, '_sfwd-quiz', true );
			if ( isset( $setting_option_fields['forcingQuestionSolve']['value'] ) && $setting_option_fields['forcingQuestionSolve']['value'] == '' ) {
				$setting_option_fields['forcingQuestionSolve']['value'] = ( isset( $_sfwd_quiz['sfwd-quiz_forcingQuestionSolve'] ) && $_sfwd_quiz['sfwd-quiz_forcingQuestionSolve'] == 1 ) ? 'on' : '';
			}
			if ( isset( $setting_option_fields['quizRunOnceType']['value'] ) ) {
				$setting_option_fields['quizRunOnceType']['value'] = ( isset( $_sfwd_quiz['sfwd-quiz_quizRunOnceType'] ) ) ? $_sfwd_quiz['sfwd-quiz_quizRunOnceType'] : $setting_option_fields['quizRunOnceType']['value'];
			}
			if ( isset( $setting_option_fields['toplistActivated']['value'] ) ) {
				$setting_option_fields['toplistActivated']['value']               = ( isset( $_sfwd_quiz['sfwd-quiz_toplistActivated'] ) && $_sfwd_quiz['sfwd-quiz_toplistActivated'] == 1 ) ? $_sfwd_quiz['sfwd-quiz_toplistActivated'] : $setting_option_fields['toplistActivated']['value'];
				$setting_option_fields['toplistActivated']['child_section_state'] = ( isset( $_sfwd_quiz['sfwd-quiz_toplistActivated'] ) && $_sfwd_quiz['sfwd-quiz_toplistActivated'] == 1 ) ? 'open' : 'closed';
			}
			if ( isset( $setting_option_fields['toplistDataAddPermissions']['value'] ) ) {
				$setting_option_fields['toplistDataAddPermissions']['value'] = ( isset( $_sfwd_quiz['sfwd-quiz_toplistDataAddPermissions'] ) ) ? $_sfwd_quiz['sfwd-quiz_toplistDataAddPermissions'] : $setting_option_fields['toplistDataAddPermissions']['value'];
			}
			if ( isset( $setting_option_fields['toplistDataShowLimit']['value'] ) ) {
				$setting_option_fields['toplistDataShowLimit']['value'] = ( isset( $_sfwd_quiz['sfwd-quiz_toplistDataShowLimit'] ) ) ? $_sfwd_quiz['sfwd-quiz_toplistDataShowLimit'] : $setting_option_fields['toplistDataShowLimit']['value'];
			}
			if ( isset( $setting_option_fields['toplistDataAddMultiple']['value'] ) ) {
				$setting_option_fields['toplistDataAddMultiple']['value'] = ( isset( $_sfwd_quiz['sfwd-quiz_toplistDataAddMultiple'] ) && $_sfwd_quiz['sfwd-quiz_toplistDataAddMultiple'] == 1 ) ? 'on' : $setting_option_fields['toplistDataAddMultiple']['value'];
			}
			if ( isset( $setting_option_fields['toplistDataSort']['value'] ) ) {
				$setting_option_fields['toplistDataSort']['value'] = ( isset( $_sfwd_quiz['sfwd-quiz_toplistDataSort'] ) ) ? $_sfwd_quiz['sfwd-quiz_toplistDataSort'] : $setting_option_fields['toplistDataSort']['value'];
			}
			if ( isset( $setting_option_fields['toplistDataShowIn_enabled']['value'] ) ) {
				$setting_option_fields['toplistDataShowIn_enabled']['value'] = ( isset( $_sfwd_quiz['sfwd-quiz_toplistDataShowIn_enabled'] ) ) ? $_sfwd_quiz['sfwd-quiz_toplistDataShowIn_enabled'] : $setting_option_fields['toplistDataShowIn_enabled']['value'];
			}
			if ( isset( $setting_option_fields['toplistDataAddAutomatic']['value'] ) ) {
				$setting_option_fields['toplistDataAddAutomatic']['value'] = ( isset( $_sfwd_quiz['sfwd-quiz_toplistDataAddAutomatic'] ) && $_sfwd_quiz['sfwd-quiz_toplistDataAddAutomatic'] == 1 ) ? 'on' : $setting_option_fields['toplistDataAddAutomatic']['value'];
			}
			if ( isset( $setting_option_fields['custom_question_elements']['value'] ) ) {
				$setting_option_fields['custom_question_elements']['value']               = ( isset( $_sfwd_quiz['sfwd-quiz_custom_question_elements'] ) && $_sfwd_quiz['sfwd-quiz_custom_question_elements'] == 1 ) ? 'on' : $setting_option_fields['custom_question_elements']['value'];
				$setting_option_fields['custom_question_elements']['child_section_state'] = ( isset( $_sfwd_quiz['sfwd-quiz_custom_question_elements'] ) && $_sfwd_quiz['sfwd-quiz_custom_question_elements'] == 1 ) ? 'open' : 'closed';
			}
			if ( isset( $setting_option_fields['answerRandom']['value'] ) ) {
				$setting_option_fields['answerRandom']['value'] = ( isset( $_sfwd_quiz['sfwd-quiz_randomize_answers'] ) && $_sfwd_quiz['sfwd-quiz_randomize_answers'] == 1 ) ? 'on' : $setting_option_fields['answerRandom']['value'];
			}
			if ( isset( $setting_option_fields['custom_sorting']['value'] ) ) {
				$setting_option_fields['custom_sorting']['value']               = ( isset( $_sfwd_quiz['sfwd-quiz_custom_sorting'] ) && $_sfwd_quiz['sfwd-quiz_custom_sorting'] == 1 ) ? 'on' : $setting_option_fields['custom_sorting']['value'];
				$setting_option_fields['custom_sorting']['child_section_state'] = ( isset( $_sfwd_quiz['sfwd-quiz_custom_sorting'] ) && $_sfwd_quiz['sfwd-quiz_custom_sorting'] == 1 ) ? 'open' : 'closed';
			}
			if ( isset( $setting_option_fields['questionRandom']['value'] ) ) {
				$setting_option_fields['questionRandom']['value']               = ( isset( $_sfwd_quiz['sfwd-quiz_randomize_order'] ) && $_sfwd_quiz['sfwd-quiz_randomize_order'] == 1 ) ? 'on' : $setting_option_fields['questionRandom']['value'];
				$setting_option_fields['questionRandom']['child_section_state'] = ( isset( $_sfwd_quiz['sfwd-quiz_randomize_order'] ) && $_sfwd_quiz['sfwd-quiz_randomize_order'] == 1 ) ? 'open' : 'closed';
			}
			if ( isset( $setting_option_fields['showMaxQuestion']['value'] ) ) {
				$setting_option_fields['showMaxQuestion']['value']                                = ( isset( $_sfwd_quiz['sfwd-quiz_showMaxQuestion'] ) && $_sfwd_quiz['sfwd-quiz_showMaxQuestion'] == 'display_subset_of_questions' ) ? 'on' : $setting_option_fields['showMaxQuestion']['value'];
				$setting_option_fields['showMaxQuestion']['options']['on']['inner_section_state'] = ( isset( $_sfwd_quiz['sfwd-quiz_showMaxQuestion'] ) && $_sfwd_quiz['sfwd-quiz_showMaxQuestion'] == 'display_subset_of_questions' ) ? 'open' : 'closed';
			}
			if ( isset( $setting_option_fields['quizModus']['value'] ) && isset( $_sfwd_quiz['sfwd-quiz_quizModus'] ) ) {
				if ( $_sfwd_quiz['sfwd-quiz_quizModus'] == 0 ) {
					$setting_option_fields['quizModus']['value']                                      = 'single';
					$setting_option_fields['quizModus']['options']['single']['inner_section_state']   = 'open';
					$setting_option_fields['quizModus']['options']['multiple']['inner_section_state'] = 'closed';
				} elseif ( $_sfwd_quiz['sfwd-quiz_quizModus'] == 3 ) {
					$setting_option_fields['quizModus']['value']                                      = 'multiple';
					$setting_option_fields['quizModus']['options']['multiple']['inner_section_state'] = 'open';
					$setting_option_fields['quizModus']['options']['single']['inner_section_state']   = 'closed';
				}
			}
			if ( isset( $setting_option_fields['quizModus']['options']['single']['inline_fields']['quizModus_single']['quizModus_single_feedback']['args'] ) ) {
				if ( isset( $_sfwd_quiz['sfwd-quiz_quizModus_single_feedback'] ) ) {
					$setting_option_fields['quizModus']['options']['single']['inline_fields']['quizModus_single']['quizModus_single_feedback']['args']['value'] = $_sfwd_quiz['sfwd-quiz_quizModus_single_feedback'];
					if ( 'each' == $_sfwd_quiz['sfwd-quiz_quizModus_single_feedback'] ) {
						$setting_option_fields['quizModus']['options']['single']['inline_fields']['quizModus_single']['quizModus_single_feedback']['args']['options']['end']['inner_section_state'] = 'closed';
					} elseif ( 'end' == $_sfwd_quiz['sfwd-quiz_quizModus_single_feedback'] ) {
						$setting_option_fields['quizModus']['options']['single']['inline_fields']['quizModus_single']['quizModus_single_feedback']['args']['options']['end']['inner_section_state'] = 'open';
					}
				}
				if ( isset( $_sfwd_quiz['sfwd-quiz_quizModus_single_back_button'] ) && $_sfwd_quiz['sfwd-quiz_quizModus_single_back_button'] == 1 ) {
					$setting_option_fields['quizModus']['options']['single']['inline_fields']['quizModus_single']['quizModus_single_feedback']['args']['options']['end']['inline_fields']['quizModus_single']['quizModus_single_back_button']['args']['value'] = 'on';
				}
			}
			if ( isset( $setting_option_fields['quizModus']['options']['multiple']['inline_fields']['quizModus_multiple']['quizModus_multiple_questionsPerPage']['args'] ) ) {
				if ( isset( $_sfwd_quiz['sfwd-quiz_quizModus_multiple_questionsPerPage'] ) ) {
					$setting_option_fields['quizModus']['options']['multiple']['inline_fields']['quizModus_multiple']['quizModus_multiple_questionsPerPage']['args']['value'] = $_sfwd_quiz['sfwd-quiz_quizModus_multiple_questionsPerPage'];
				}
			}
		}
		return $setting_option_fields;
	}

	public static function get_instructor_courses_list( $user_id = 0, $id = false ) {
		if ( 0 == $user_id ) {
			$user_id = get_current_user_id();
		}
		$course_args        = array(
			'post_type'      => 'sfwd-courses',
			'author'         => $user_id,
			'post_status'    => array( 'publish', 'pending', 'draft' ),
			'posts_per_page' => -1,
		);
		$shared_course_args = array(
			'post_type'      => 'sfwd-courses',
			'post_status'    => array( 'publish', 'pending', 'draft' ),
			'meta_query'     => array(
				array(
					'key'     => '_ld_instructor_ids',
					'value'   => '"' . $user_id . '"',
					'compare' => 'LIKE',
				),
			),
			'posts_per_page' => -1,
		);
		$courses            = get_posts( $course_args );

		$shared_courses = get_posts( $shared_course_args );
		if ( count( $shared_courses ) > 0 ) {
			$courses = array_merge( $courses, $shared_courses );
		}
		$unique_ids     = array();
		$unique_array   = array();
		$not_course_tab = true;
		if ( isset( $_GET['tab'] ) && 'my-courses' === $_GET['tab'] ) {
			$not_course_tab = false;
		}
		if ( $not_course_tab && learndash_is_group_leader_user( $user_id ) ) {
			$group_courses     = learndash_get_group_leader_groups_courses();
			$group_courses     = ( is_array( $group_courses ) && ! empty( $group_courses ) ) ? $group_courses : array( 0 );
			$group_course_args = array(
				'post_type'      => 'sfwd-courses',
				'post_status'    => array( 'publish', 'pending', 'draft' ),
				'post__in'       => $group_courses,
				'posts_per_page' => -1,
			);
			$group_courses     = get_posts( $group_course_args );
			if ( count( $group_courses ) > 0 ) {
				$courses = array_merge( $courses, $group_courses );
			}
		}

		if ( count( $courses ) > 0 ) {
			foreach ( $courses as $crs ) {
				if ( in_array( $crs->ID, $unique_ids ) ) {
					continue;
				}
				$unique_array[] = $crs;
				$unique_ids[]   = $crs->ID;
			}
			$courses = $unique_array;

			if ( $id ) {
				return $unique_ids;
			} else {
				return $courses;
			}
		} else {
			return array();
		}
	}

	public function get_instructor_lessons_list() {
		$lessons        = array();
		$transient_name = 'ldd_instructor_' . get_current_user_id() . '_lessons';
		if ( false !== get_transient( $transient_name ) ) {
			$lessons = get_transient( $transient_name );
			return $lessons;
		}
		$courses = $this->get_instructor_courses_list();

		$exclude_ids = array();
		// Intructor's lessons associated to courses.
		if ( is_array( $courses ) && ! empty( $courses ) ) {
			foreach ( $courses as $crs ) {
				$course_lessons = learndash_get_course_lessons_list( $crs->ID );
				if ( is_array( $course_lessons ) && ! empty( $course_lessons ) ) {
					foreach ( $course_lessons as $course_lesson ) {
						if ( in_array( $course_lesson['id'], $exclude_ids ) ) {
							continue;
						}
						$exclude_ids[] = $course_lesson['id'];
						$lessons[]     = $course_lesson['post'];
					}
				}
			}
		}
		// Intructor's lessons not associated to any course.
		$args               = array(
			'post_type'    => 'sfwd-lessons',
			'numberposts'  => -1,
			'author'       => get_current_user_id(),
			'post__not_in' => $exclude_ids,
		);
		$instructor_lessons = get_posts( $args );
		if ( is_array( $instructor_lessons ) && ! empty( $instructor_lessons ) ) {
			$lessons = array_merge( $lessons, $instructor_lessons );
		}
		if ( false === get_transient( $transient_name ) ) {
			set_transient( $transient_name, $lessons, 30 );
		}
		return $lessons;

	}

	public function get_instructor_lessons_contents( $type = '' ) {
		$data           = array();
		$transient_name = 'ldd_instructor_' . get_current_user_id() . '_lessons_content';
		if ( false !== get_transient( $transient_name ) ) {
			$data = get_transient( $transient_name );
			if ( '' !== $type ) {
				return $data[ $type ];
			} else {
				return $data;
			}
		}
		$lessons = $this->get_instructor_lessons_list();

		$topics         = array();
		$exclude_topics = array();

		$quizzes         = array();
		$exclude_quizzes = array();

		$questions        = array();
		$exclude_question = array();

		$assignments = array();

		if ( is_array( $lessons ) && ! empty( $lessons ) ) {
			foreach ( $lessons as $lsn ) {
				$course_id          = get_post_meta( $lsn->ID, 'course_id', true );
				$course_topics      = learndash_course_get_topics( $course_id, $lsn->ID );
				$course_quizzes     = learndash_course_get_quizzes( $course_id, $lsn->ID );
				$assignment_args    = array(
					'post_type'      => 'sfwd-assignment',
					'posts_per_page' => - 1,
					'meta_query'     => array(
						'relation' => 'AND',
						array(
							'key'     => 'lesson_id',
							'value'   => $lsn->ID,
							'compare' => '=',
						),
						array(
							'key'     => 'course_id',
							'value'   => $course_id,
							'compare' => '=',
						),
					),
				);
				$course_assignments = get_posts( $assignment_args );
				if ( is_array( $course_assignments ) && ! empty( $course_assignments ) ) {
					$assignments = array_merge( $assignments, $course_assignments );
				}
				if ( is_array( $course_topics ) && ! empty( $course_topics ) ) {
					foreach ( $course_topics as $course_topic ) {
						$exclude_topics[] = $course_topic->ID;
					}
					$topics = array_merge( $topics, $course_topics );
				}
				if ( is_array( $course_quizzes ) && ! empty( $course_quizzes ) ) {
					foreach ( $course_quizzes as $course_quiz ) {
						$exclude_quizzes[] = $course_quiz->ID;
					}
					$quizzes = array_merge( $quizzes, $course_quizzes );
				}
			}
		}

		$topic_args        = array(
			'post_type'   => 'sfwd-topic',
			'numberposts' => -1,
			'author'      => get_current_user_id(),
			'exclude'     => $exclude_topics,
		);
		$instructor_topics = get_posts( $topic_args );

		if ( is_array( $instructor_topics ) && ! empty( $instructor_topics ) ) {
			$topics = array_merge( $topics, $instructor_topics );
		}

		$quiz_args          = array(
			'post_type'   => 'sfwd-quiz',
			'numberposts' => -1,
			'author'      => get_current_user_id(),
			'exclude'     => $exclude_quizzes,
		);
		$instructor_quizzes = get_posts( $quiz_args );

		if ( is_array( $instructor_quizzes ) && ! empty( $instructor_quizzes ) ) {
			$quizzes = array_merge( $quizzes, $instructor_quizzes );
		}

		if ( is_array( $quizzes ) && ! empty( $quizzes ) ) {
			foreach ( $quizzes as $quiz ) {
				$questions_object = learndash_get_quiz_questions( $quiz->ID );
				if ( is_array( $questions_object ) && ! empty( $questions_object ) ) {
					$quiz_question_ids = array_keys( $questions_object );
					$exclude_question  = array_merge( $exclude_question, $quiz_question_ids );
				}
			}
		}
		if ( ! empty( $exclude_question ) ) {
			foreach ( $exclude_question as $question_id ) {
				$question    = get_post( $question_id );
				$questions[] = $question;
			}
		}
		$question_args        = array(
			'post_type'   => 'sfwd-question',
			'numberposts' => -1,
			'author'      => get_current_user_id(),
			'exclude'     => $exclude_question,
		);
		$instructor_questions = get_posts( $question_args );

		if ( is_array( $instructor_questions ) && ! empty( $instructor_questions ) ) {
			$questions = array_merge( $questions, $instructor_questions );
		}

		$data['lessons']     = $lessons;
		$data['topics']      = $topics;
		$data['quizzes']     = $quizzes;
		$data['questions']   = $questions;
		$data['assignments'] = $assignments;
		if ( false === get_transient( $transient_name ) ) {
			set_transient( $transient_name, $data, 30 );
		}
		if ( '' !== $type ) {
			return $data[ $type ];
		} else {
			return $data;
		}
	}

	public function get_group_leader_courses_lessons() {
		$lessons = array();
		$courses = learndash_get_group_leader_groups_courses();
		if ( is_array( $courses ) && ! empty( $courses ) ) {
			foreach ( $courses as $crs ) {
				$course_lessons = learndash_get_course_lessons_list( $crs );
				if ( is_array( $course_lessons ) && ! empty( $course_lessons ) ) {
					$lessons = array_merge( $lessons, $course_lessons );
				}
			}
		}
		return $lessons;
	}

	public function get_group_leader_lessons_contents( $type = '' ) {
		$lessons = $this->get_group_leader_courses_lessons();
		$data    = array();
		$topics  = array();
		$quizzes = array();
		if ( is_array( $lessons ) && ! empty( $lessons ) ) {
			foreach ( $lessons as $lsn ) {
				$course_id      = get_post_meta( $lsn['id'], 'course_id', true );
				$course_topics  = learndash_course_get_topics( $course_id, $lsn['id'] );
				$course_quizzes = learndash_course_get_quizzes( $course_id, $lsn['id'] );
				if ( is_array( $course_topics ) && ! empty( $course_topics ) ) {
					$topics = array_merge( $topics, $course_topics );
				}
				if ( is_array( $course_quizzes ) && ! empty( $course_quizzes ) ) {
					$quizzes = array_merge( $quizzes, $course_quizzes );
				}
			}
		}
		$data['topics']  = $topics;
		$data['quizzes'] = $quizzes;
		if ( '' !== $type ) {
			return $data[ $type ];
		} else {
			return $data;
		}
	}

	public function ld_dashboard_acf_render_field( $field ) {
		$question_id = ( isset( $_GET['question'] ) ) ? sanitize_text_field( wp_unslash( $_GET['question'] ) ) : '';
		$answers     = get_post_meta( $question_id, 'ld_dashboard_answer', true );
		$sort_array  = '';
		if ( is_array( $answers ) && ! empty( $answers ) ) {
			$tmp        = array();
			$count      = 0;
			$sort_array = '[';
			foreach ( $answers as $ans ) {
				$sort_array .= $count;
				if ( $count < count( $answers ) - 1 ) {
					$sort_array .= ',';
				}
				$tmp[] = $ans;
				$count++;
			}
			$sort_array .= ']';
			$answers     = $tmp;
		}
		$answer_type     = ( get_post_meta( $question_id, 'sfwd-question_answer_type', true ) ) ? get_post_meta( $question_id, 'sfwd-question_answer_type', true ) : 'single';
		$answer_template = $answer_type;
		$allow_repeater  = array( 'single', 'multiple', 'sort_answer', 'matrix_sort_answer', '' );
		$display_btn     = 'display:none;';
		if ( strpos( $answer_type, '_answer' ) !== false ) {
			$answer_template = str_replace( '_answer', '', $answer_type );
			if ( strpos( $answer_template, '_' ) !== false ) {
				$answer_template = str_replace( '_', '-', $answer_template );
			}
		}
		$single_iteration_ans = array( 'free_answer', 'assessment_answer', 'essay', 'cloze_answer' );
		$answers_count        = ( is_array( $answers ) && ! empty( $answers ) ) ? count( $answers ) : 0;
		echo '<div id="custom_ld_answer_field" data-post_id="' . esc_attr( $question_id ) . '" data-type ="' . esc_attr( $answer_type ) . '" data-answers="' . esc_attr( $answers_count ) . '" ><div id="FirstDiv">';
		if ( is_array( $answers ) && ! empty( $answers ) && '' != $answer_type ) {
			if ( false !== $this->template_override_exists( 'ld-dashboard-' . $answer_template . '-answer-content.php' ) ) {
				include $this->template_override_exists( 'ld-dashboard-' . $answer_template . '-answer-content.php' );
			} else {
				include LD_DASHBOARD_PLUGIN_DIR . '/templates/ld-dashboard-' . $answer_template . '-answer-content.php';
			}
		}
		if ( in_array( $answer_type, $allow_repeater, true ) || ! is_array( $answers ) || empty( $answers ) ) {
			$display_btn = '';
		}
		echo '</div><div id="SecondDiv"><button class="add-new-user-btn add-new-ques-btn" data-type="' . esc_attr( $answer_type ) . '">' . esc_html__( 'Add new answer', 'ld-dashboard' ) . '</button></div>';
		echo '<input type="hidden" name="answer_sort_order" class="ld-dashboard-answer-order" value="' . $sort_array . '">';
		echo '</div>';
	}

	public function ld_dashboard_custom_course_object_query( $args, $field, $post_id ) {
		$user_id = get_current_user_id();

		if ( 'field_61d7fda3a6578' === $field['key'] || 'field_61b73957c2d55' === $field['key'] || 'field_61b720eebf8a9' === $field['key'] ) {

			$course_ids = array( 0 );
			$courses    = $this->get_instructor_courses_list( $user_id );

			if ( is_array( $courses ) && count( $courses ) > 0 ) {
				$temp = array();
				foreach ( $courses as $course ) {
					$course_ids[] = $course->ID;
					$temp[]       = $course->post_title;
				}
			}
			if ( count( $course_ids ) > 0 ) {
				$args['post__in'] = $course_ids;
			}
		}
		if ( 'field_61b6e3f6065a0' === $field['key'] ) {
			$args['author'] = $user_id;
		}

		return $args;
	}

	public function ld_dashboard_acf_render_associated_lesson_field( $field ) {
		$slug      = '';
		$course_id = false;
		if ( isset( $_GET['tab'] ) ) {
			if ( 'my-topics' === $_GET['tab'] ) {
				$slug = 'topic';
				if ( isset( $_GET['ld-topic'] ) ) {
					$topic_id  = wp_unslash( $_GET['ld-topic'] );
					$course_id = get_post_meta( $topic_id, 'course_id', true );
					$lesson_id = get_post_meta( $topic_id, 'lesson_id', true );
				}
			}
			if ( 'my-quizzes' === $_GET['tab'] ) {
				$slug = 'quiz';
				if ( isset( $_GET['ld-quiz'] ) ) {
					$quiz_id   = wp_unslash( $_GET['ld-quiz'] );
					$course_id = get_post_meta( $quiz_id, 'course_id', true );
					$lesson_id = get_post_meta( $quiz_id, 'lesson_id', true );
				}
			}
		}
		$lessons = array();
		if ( $course_id && '' !== $course_id ) {
			$args    = array(
				'post_type'      => 'sfwd-lessons',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'key'     => 'course_id',
						'value'   => $course_id,
						'compare' => '==',
					),
				),
			);
			$lessons = get_posts( $args );
		}
		?>
		<div class="ld-dashboard-associates-lesson-field-wrapper">
			<select id="ld_dashboard_associated_lesson" name="sfwd-<?php echo esc_attr( $slug ); ?>_lesson_cld">
				<option value=""><?php esc_html_e( 'Select', 'ld-dashboard' ); ?></option>
				<?php
				if ( count( $lessons ) > 0 ) {
					foreach ( $lessons as $lesson ) {
						?>
						<option value="<?php echo esc_attr( $lesson->ID ); ?>" <?php selected( $lesson_id, $lesson->ID ); ?>><?php echo esc_html( $lesson->post_title ); ?></option>
						<?php
					}
				}
				?>
			</select>
		</div>
		<?php
	}

	public function ld_dashboard_acf_render_course_builder_field( $field ) {
		if ( isset( $_GET['tab'] ) && isset( $_GET['ld-course'] ) && 'my-courses' === $_GET['tab'] ) {
			$course_id              = sanitize_text_field( wp_unslash( $_GET['ld-course'] ) );
			$lessons                = learndash_get_course_lessons_list( $course_id );
			$ld_course_steps_object = LDLMS_Factory_Post::course_steps( $course_id );
			$sections               = learndash_30_get_course_sections( $course_id );
			$sections_raw           = get_post_meta( $course_id, 'course_sections', true );
			$temp_sections          = ! empty( $sections_raw ) ? json_decode( $sections_raw, true ) : array();
			$ld_course_steps        = $ld_course_steps_object->get_steps( 'h' );

			$course_builder_wrap_classes = 'ld-dashboard-course-builder-wrapper';
			if ( is_multisite() ) {
				$share_course_settings = get_site_option( 'learndash_settings_courses_management_display' );
			} else {
				$share_course_settings = get_option( 'learndash_settings_courses_management_display' );
			}
			$share_course_steps_enabled = false;
			if ( isset( $share_course_settings['course_builder_shared_steps'] ) && 'yes' === $share_course_settings['course_builder_shared_steps'] ) {
				$share_course_steps_enabled   = true;
				$course_builder_wrap_classes .= ' ld-dashboard-shareable-course-steps-enabled';
			}

			?>
				<div class="<?php echo esc_attr( $course_builder_wrap_classes ); ?>">
					<div class="ld-dashboard-course-builder-content">
						<?php
						if ( isset( $ld_course_steps['sfwd-lessons'] ) ) {
							if ( ! empty( $lessons ) ) {
								$count = 0;
								foreach ( $ld_course_steps['sfwd-lessons'] as $id => $value ) {
									$lesson = get_post( $id );
									?>
									<!-- Set Section -->
									<?php if ( ! empty( $sections ) && isset( $sections[ $id ] ) && ! empty( $sections[ $id ] ) ) : ?>
										<div class="ld-dashboard-single-wrap ld-dashboard-course-builder-lesson" data-item_key="<?php echo esc_attr( $count ); ?>" data-id="<?php echo esc_attr( $id ); ?>" data-value="<?php echo esc_attr( $sections[ $id ]->post_title ); ?>">
											<span class="ld-dashboard-sortable-input-section">
												<input type="hidden"  name="course_sections[<?php echo esc_attr( $count ); ?>]" value="<?php echo esc_attr( $sections[ $id ]->post_title ); ?>">
											</span>
											<div class="ld-dashboard-course-builder-section-title">
												<h4><?php echo esc_html( $sections[ $id ]->post_title ); ?></h4>
											</div>
											<div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-remove"><?php esc_html_e( 'Remove', 'ld-dashboard' ); ?></div>
										</div>
										<?php
										unset( $sections[ $id ] );
										$count++;
									endif;
									?>
									<!-- End Section -->
									<div class="ld-dashboard-single-wrap ld-dashboard-course-builder-lesson" data-item_key="<?php echo esc_attr( $count ); ?>" data-name="<?php echo esc_attr( $lesson->post_title ); ?>" data-type="lesson" data-id="<?php echo esc_attr( $id ); ?>" data-value="<?php echo esc_attr( $id ); ?>">
										<span class="ld-dashboard-sortable-input">
											<input type="hidden" data-lesson="<?php echo esc_attr( $lesson->post_title ); ?>" name="ld_dashboard_course_builder[<?php echo esc_attr( $count ); ?>]" value="<?php echo esc_attr( $id ); ?>">
										</span>
										<div class="ld-dashboard-course-builder-lesson-title">
											<h4><?php echo esc_html( $lesson->post_title ); ?></h4>
										</div>
										<div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-remove"><?php esc_html_e( 'Remove', 'ld-dashboard' ); ?></div>
										<div class="ld-dashboard-course-builder-lesson-dropdown ld-dashboard-accordian ld-dashboard-accordian-closed">
											<span class="ld-dashboard-accordian-icon ld-dashboard-accordian-open"></span>
											<span class="ld-dashboard-accordian-icon ld-dashboard-accordian-close"></span>
										</div>
										<div class="ld-dashboard-lesson-builder-wrapper">
												<div class="ld-dashboard-course-lesson-builder-topic-wrapper">
													<div class="ld-dashboard-course-builder-topic-header">
														<h4><?php echo esc_html( LearnDash_Custom_Label::get_label( 'topics' ) ); ?></h4>
													</div>
													<div class="ld-dashboard-is-sortable ld-dashboard-topics-is-sortable ld-dashboard-course-lesson-builder-quiz-content">
														<?php
														if ( isset( $value['sfwd-topic'] ) && ! empty( $value['sfwd-topic'] ) ) {
															$topic_count = 0;
															?>
															<?php
															foreach ( $value['sfwd-topic'] as $topic_id => $val ) :
																$topic = get_post( $topic_id );
																?>
															<div class="ld-dashboard-single-wrap ld-dashboard-is-sortable-item ld-dashboard-course-lesson-builder-topic-single" data-name="<?php echo esc_attr( $topic->post_title ); ?>" data-type="topic" data-item_key="<?php echo esc_attr( $topic_count ); ?>" data-id="<?php echo esc_attr( $id ); ?>" data-value="<?php echo esc_attr( $topic_id ); ?>">
																<span class="ld-dashboard-sortable-input">
																	<input type="hidden" name="ld_dashboard_lesson_builder[<?php echo esc_attr( $id ); ?>][topic][<?php echo esc_attr( $topic_count ); ?>]" value="<?php echo esc_attr( $topic_id ); ?>">
																</span>
																<div class="ld-dashboard-course-builder-topic-title">
																	<?php echo esc_html( $topic->post_title ); ?>
																</div>
																<div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-topic-remove"><?php esc_html_e( 'Remove', 'ld-dashboard' ); ?></div>
															</div>
																<?php
																$topic_count++;
														endforeach;

														}
														?>
													</div>
													<div class="ld-dashboard-share-steps-dropper"><?php printf( esc_html__( 'Drop %s Here', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'topics' ) ) ); ?></div>
												</div>
												<div class="ld-dashboard-course-lesson-builder-quiz-wrapper">
													<div class="ld-dashboard-course-builder-topic-header">
														<h4><?php echo esc_html( LearnDash_Custom_Label::get_label( 'quizzes' ) ); ?></h4>
													</div>
													<div class="ld-dashboard-is-sortable ld-dashboard-quizzes-is-sortable ld-dashboard-course-lesson-builder-quiz-content">
														<?php
														if ( isset( $value['sfwd-quiz'] ) && ! empty( $value['sfwd-quiz'] ) ) {
															$quiz_count = 0;
															foreach ( $value['sfwd-quiz'] as $quiz_id => $val ) :
																$quiz = get_post( $quiz_id );
																?>
															<div class="ld-dashboard-single-wrap ld-dashboard-is-sortable-item ld-dashboard-course-lesson-builder-quiz-single" data-name="<?php echo esc_attr( $quiz->post_title ); ?>" data-type="quiz" data-item_key="<?php echo esc_attr( $quiz_count ); ?>" data-id="<?php echo esc_attr( $id ); ?>" data-value="<?php echo esc_attr( $quiz_id ); ?>">
																<span class="ld-dashboard-sortable-input">
																	<input type="hidden" name="ld_dashboard_lesson_builder[<?php echo esc_attr( $id ); ?>][quiz][<?php echo esc_attr( $quiz_count ); ?>]" value="<?php echo esc_attr( $quiz_id ); ?>">
																</span>
																<div class="ld-dashboard-course-builder-quiz-title">
																	<?php echo esc_html( $quiz->post_title ); ?>
																</div>
																<div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-quiz-remove"><?php esc_html_e( 'Remove', 'ld-dashboard' ); ?></div>
															</div>
																<?php
																$quiz_count++;
														endforeach;
														}
														?>
													</div>
													<div class="ld-dashboard-share-steps-dropper"><?php printf( esc_html__( 'Drop %s Here', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'quizzes' ) ) ); ?></div>
												</div>
												<?php
												if ( empty( $value['sfwd-topic'] ) && empty( $value['sfwd-quiz'] ) ) {
													?>
												<!--div class="ld-dashboard-share-steps-dropper"><?php printf( esc_html__( 'Drop %1$1s or %2$2s Here', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'topics' ) ), esc_html( LearnDash_Custom_Label::get_label( 'quizzes' ) ) ); ?></div-->
											<?php } ?>
										</div>
										<div class="ld-dashboard-crate-topics-quiz">
											<button class="ld_dashboard_builder_new_topic"><?php printf( '%1s %2s', esc_html__( 'New', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'topic' ) ) ); ?></button>
											<button class="ld_dashboard_builder_new_quiz"><?php printf( '%1s %2s', esc_html__( 'New', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'quiz' ) ) ); ?></button>
										</div>
									</div>
									<?php
									$count++;
								}

								if ( ! empty( $sections ) ) {
									foreach ( $sections as $section ) {
										$count = $section['order'];
										?>
										<div class="ld-dashboard-single-wrap ld-dashboard-course-builder-lesson" data-item_key="<?php echo esc_attr( $count ); ?>" data-id="<?php echo esc_attr( $id ); ?>" data-value="<?php echo esc_attr( $section['post_title'] ); ?>">
											<span class="ld-dashboard-sortable-input-section">
												<input type="hidden"  name="course_sections[<?php echo esc_attr( $count ); ?>]" value="<?php echo esc_attr( $section['post_title'] ); ?>">
											</span>
											<div class="ld-dashboard-course-builder-section-title">
												<h4><?php echo esc_html( $section['post_title'] ); ?></h4>
											</div>
											<div class="ld-dashboard-remove-wrapper ld-dashboard-course-lesson-remove"><?php esc_html_e( 'Remove', 'ld-dashboard' ); ?></div>
										</div>
										<?php
									}
								}
							} else {
								if ( $share_course_steps_enabled ) {
									?>
									<div class="ld-dashboard-share-steps-dropper"><?php printf( esc_html__( 'Add %s here.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'lessons' ) ) ); ?></div>
									<?php
								} else {
									?>
									<p class="ld-dashboard-warning"><?php printf( esc_html__( 'Please create the %1$1s and %2$2s by navigating to the respective sections.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'lessons' ) ), esc_html( LearnDash_Custom_Label::get_label( 'topics' ) ) ); ?></p>
									<?php
								}
							}
						}
						?>
						</div>
					</div>
					<div class="ld-dashboard-crate-lesson">
						<button class="ld_dashboard_builder_new_lesson"><?php printf( esc_html__( 'New %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'lesson' ) ) ); ?></button>
						<button class="ld_dashboard_builder_new_section_heading"><?php esc_html_e( 'New Section Heading', 'ld-dashboard' ); ?></button>
					</div>
				<?php

		}
	}

	public function ld_dashboard_acf_render_quiz_builder_field( $field ) {
		if ( isset( $_GET['tab'] ) && 'my-quizzes' === $_GET['tab'] ) {
			$exclude_questions  = array();
			$assigned_questions = array();
			$args               = array(
				'post_type'   => 'sfwd-question',
				'post_status' => 'publish',
				'numberposts' => -1,
			);
			if ( isset( $_GET['ld-quiz'] ) ) {
				$quiz_id            = sanitize_text_field( wp_unslash( $_GET['ld-quiz'] ) );
				$assigned_questions = get_post_meta( $quiz_id, 'ld_quiz_questions', true );
				$course_id          = get_post_meta( $quiz_id, 'course_id', true );
				if ( $course_id && '' !== $course_id ) {
					$course_data               = get_post( $course_id );
					$shared_course_instructors = get_post_meta( $course_id, '_ld_instructor_ids', true );
					$authors                   = array( get_current_user_id() );
					if ( is_array( $shared_course_instructors ) ) {
						$authors = array_merge( $authors, $shared_course_instructors );
					}
					$args['author__in'] = $authors;
				}
			}
			if ( ! isset( $args['author__in'] ) ) {
				$args['author'] = get_current_user_id();
			}
			$questions = get_posts( $args );
			?>
			<div class="ld-dashboard-quiz-builder-wrapper">
			<?php
			if ( ! empty( $questions ) ) {
				?>
					<div class="ld-dashboard-quiz-builder-content">
						<div class="ld-dashboard-assigned-questions-wrapper" >
							<ul id="ldd_assigned_questions" class="ld-dashboard-quiz-builder-list-wrapper ld-dashboard-assigned-questions-list">
								<?php
								if ( $assigned_questions && ! empty( $assigned_questions ) ) {
									$count = 0;
									foreach ( $assigned_questions as $ques_id => $asn_ques ) {
										$exclude_questions[] = $ques_id;
										$question_data       = get_post( $ques_id );
										if ( is_object( $question_data ) ) {
											echo '<li><span class="ld-dashboard-sortable-input"></span><div class="ld-dashboard-course-builder-question-single" data-question="' . esc_attr( $ques_id ) . '">' . esc_html( $question_data->post_title ) . '</div><input type="hidden" name="ld_quiz_builder[' . esc_attr( $count ) . ']" value="' . esc_attr( $ques_id ) . '"><span class="remove-question"></span></li>';
										}
										$count += 1;
									}
								}
								?>
							</ul>
							<div class="ld-dashboard-assigned-question-default"><?php printf( esc_html__( 'Drop %s here', 'ld-dashboard' ), esc_html( strtolower( LearnDash_Custom_Label::get_label( 'question' ) ) ) ); ?></div>
						</div>
						<div class="ld-dashboard-quiz-builder-question">
							<ul id="ldd_questions_list" class="ld-dashboard-quiz-builder-list-wrapper ld-dashboard-questions-list">
						<?php foreach ( $questions as $ques ) : ?>
							<?php
							if ( in_array( $ques->ID, $exclude_questions ) ) {
								continue;
							}
							$quiz_assigned = get_post_meta( $ques->ID, 'quiz_id', true );
							if ( $quiz_assigned && '' !== $quiz_assigned ) {
								continue;
							}
							?>
							<li data-question="<?php echo esc_attr( $ques->ID ); ?>">
								<span class="ld-dashboard-sortable-input"></span>
								<div class="ld-dashboard-course-builder-question-single" data-question="<?php echo esc_attr( $ques->ID ); ?>">
									<?php echo esc_html( $ques->post_title ); ?>
								</div>
							</li>
						<?php endforeach; ?>
						</ul>
						</div>
					</div>
				<?php
			} else {
				?>
				<p class="ld-dashboard-warning"><?php printf( esc_html__( 'No %s found.', 'ld-dashboard' ), esc_html( strtolower( LearnDash_Custom_Label::get_label( 'questions' ) ) ) ); ?></p>
				<?php
			}
			?>
			</div>
			<?php
		}
	}

	/*
	* Exclude admin users
	*/
	public function ld_dashboard_exclude_admin_users() {
		$reports_exclude_admin_users = false;

		if ( version_compare( LEARNDASH_VERSION, '2.4.0' ) >= 0 ) {
			$reports_exclude_admin_users = LearnDash_Settings_Section::get_section_setting( 'LearnDash_Settings_Section_General_Admin_User', 'reports_include_admin_users' );
			if ( $reports_exclude_admin_users == 'yes' ) {
				$reports_exclude_admin_users = false;
			} else {
				$reports_exclude_admin_users = true;
			}
		}

		return apply_filters( 'ld_dashboard_exclude_admin_users', $reports_exclude_admin_users );
	}

	/**
	 * Auto enroll admin users
	 */
	public function ld_dashboard_auto_enroll_admin_users() {
		$auto_enroll_admin_users = false;

		if ( version_compare( LEARNDASH_VERSION, '2.4.0' ) >= 0 ) {
			$auto_enroll_admin_users = LearnDash_Settings_Section::get_section_setting( 'LearnDash_Settings_Section_General_Admin_User', 'courses_autoenroll_admin_users' );
			if ( $auto_enroll_admin_users == 'yes' ) {
				$auto_enroll_admin_users = true;
			} else {
				$auto_enroll_admin_users = false;
			}
		}

		return apply_filters( 'ld_dashboard_auto_enroll_admin_users', $auto_enroll_admin_users );
	}

	/*
	* Get admin user ids
	*/

	public function ld_dashboard_get_admin_user_ids( $return_count = false ) {
		$admin_user_query_args = array(
			'fields' => 'ID',
			'role'   => 'administrator',
		);

		if ( $return_count === true ) {
			$admin_user_query_args['count_total'] = true;
		}

		$admin_user_query = new WP_User_Query( $admin_user_query_args );
		if ( $return_count === true ) {
			return $admin_user_query->get_total();
		} else {
			$admin_user_ids = $admin_user_query->get_results();
			if ( ! empty( $admin_user_ids ) ) {
				$admin_user_ids = array_map( 'intval', $admin_user_ids );
			}
			return $admin_user_ids;
		}
	}

	/*
	* Count Post Type
	*/
	public function ld_dashboard_count_post_type( $post_type ) {
		global $wpdb;
		if ( ! empty( $post_type ) ) {
			global $current_user;
			$user_id = get_current_user_id();
			if ( in_array( 'administrator', (array) $current_user->roles ) ) {
				$query_args = array(
					'post_type'   => $post_type,
					'post_status' => array( 'publish', 'pending', 'draft' ),
					'numberposts' => -1,
				);

			} else {
				/* Post Type Not Courses */

				$get_courses_sql = "select ID from {$wpdb->prefix}posts INNER JOIN {$wpdb->prefix}postmeta pm6 ON ( {$wpdb->prefix}posts.ID = pm6.post_id ) where ( post_author={$user_id} OR ( pm6.meta_key = '_ld_instructor_ids' AND pm6.meta_value REGEXP '.*;s:[0-9]+:\"{$user_id}\"*' ) ) AND post_type='sfwd-courses' AND {$wpdb->prefix}posts.post_status = 'publish' Group By {$wpdb->prefix}posts.ID";

				$cousres    = $wpdb->get_results( $get_courses_sql );
				$course_ids = array();
				if ( ! empty( $cousres ) ) {
					$course_ids = array();
					foreach ( $cousres as $course ) {
						$course_ids[] = $course->ID;
					}
				}

				$query_args = array(
					'post_type'   => $post_type,
					'post_status' => 'publish',
					'author__in'  => array( $user_id ),
					'post__in'    => $course_ids,
				);
				if ( $post_type != 'sfwd-courses' ) {
					unset( $query_args['post__in'] );
					if ( ! empty( $course_ids ) ) {
						$query_args['meta_key'] = 'course_id';
						$query_args['orderby']  = 'meta_value_num';
						$query_args['order']    = 'ASC';
						unset( $query_args['author__in'] );
						$query_args['meta_query'] = array(
							'key'     => 'course_id',
							'value'   => $course_ids,
							'compare' => 'IN',
						);
					}
				} else {
					unset( $query_args['author__in'] );
				}
				if ( empty( $course_ids ) && isset( $query_args['post__in'] ) ) {
					$query_args['post__in'] = array( 0 );
				}
			}
			return learndash_get_courses_count( $query_args );
		}
	}

	public function ld_set_user_avatar_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_POST['user_id'] ) ) {
				exit();
			}
			$user_id   = sanitize_text_field( wp_unslash( $_POST['user_id'] ) );
			$sizes_arr = $_POST['sizes'];
			$sizes     = array();
			foreach ( $sizes_arr as $key => $sz ) {
				foreach ( $sz as $size => $value ) {
					$sizes[ $size ] = $value;
				}
			}
			update_user_meta( $user_id, 'ld_dashboard_avatar_sizes', $sizes );
			wp_die();
		}
	}

	/**
	 * Remove user avatar callback
	 *
	 * @return void
	 */
	public function ld_remove_user_avatar_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_POST['user_id'] ) ) {
				exit();
			}
			$user_id = sanitize_text_field( wp_unslash( $_POST['user_id'] ) );
			update_user_meta( $user_id, 'ld_dashboard_avatar_id', '' );
			update_user_meta( $user_id, 'ld_dashboard_avatar_sizes', array() );
			echo '1';
			wp_die();
		}
	}

	/**
	 * Remove post callback
	 *
	 * @return void
	 */
	public function ld_dashboard_remove_post_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_POST['post_id'] ) ) {
				exit();
			}
			$post_id = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
			wp_delete_post( $post_id, false );
			exit();
		}
	}

	/**
	 * Get Total Users Count
	 */
	public function ld_dashboard_get_users_count() {
		global $wpdb, $current_user;
		$all_user_ids = array();

		$return_total_users = 0;

		$exclude_admin_users     = $this->ld_dashboard_exclude_admin_users();
		$auto_enroll_admin_users = $this->ld_dashboard_auto_enroll_admin_users();

		$ld_open_courses = learndash_get_open_courses();
		$admin_user_ids  = $this->ld_dashboard_get_admin_user_ids();
		if ( $this->ld_dashboard_count_post_type( 'sfwd-courses' ) ) {
			// If we have any OPEN courses then we just use the WP_User_Query to get all users.
			if ( ! empty( $ld_open_courses ) && ! in_array( 'ld_instructor', (array) $current_user->roles ) ) {
				$user_query_args = array(
					'count_total' => true,
					'fields'      => 'ID',
				);

				$user_query_args = apply_filters( 'ld_dashboard_overview_students_count_args', $user_query_args );
				if ( ! empty( $user_query_args ) ) {
					$user_query = new WP_User_Query( $user_query_args );
					if ( $user_query instanceof WP_User_Query ) {
						$all_user_ids = $user_query->get_results();
					}
				}
			} else {

				// Else if there are no open courses we the query users with 'learndash_group_users_%' OR 'course_%_access_from' meta_keys.

				$user_id = get_current_user_id();
				if ( in_array( 'ld_instructor', (array) $current_user->roles ) ) {

					$get_courses_sql = "select ID from {$wpdb->prefix}posts INNER JOIN {$wpdb->prefix}postmeta pm6 ON ( {$wpdb->prefix}posts.ID = pm6.post_id ) where ( post_author={$user_id} OR ( pm6.meta_key = '_ld_instructor_ids' AND pm6.meta_value REGEXP '.*;s:[0-9]+:\"{$user_id}\"*' ) ) AND post_type='sfwd-courses' AND {$wpdb->prefix}posts.post_status = 'publish' Group By {$wpdb->prefix}posts.ID";

					$users_courses_sql = "SELECT DISTINCT users.ID FROM {$wpdb->users} as users
					LEFT JOIN {$wpdb->usermeta} as um1 ON ( users.ID = um1.user_id )
					LEFT JOIN {$wpdb->usermeta} as um2 ON ( users.ID = um2.user_id )
					WHERE 1=1
					AND (
						um1.meta_key = '{$wpdb->prefix}capabilities'
						AND ( um2.meta_key IN
							(
								SELECT DISTINCT CONCAT('course_', p.ID, '_access_from') FROM {$wpdb->prefix}posts p INNER JOIN {$wpdb->prefix}postmeta pm6 ON ( p.ID = pm6.post_id ) WHERE p.post_type='sfwd-courses' AND p.post_status='publish' AND ( p.post_author = '" . $user_id . "' OR ( pm6.meta_key = '_ld_instructor_ids' AND pm6.meta_value REGEXP '.*;s:[0-9]+:\"{$user_id}\"*' ) )								
							)
						)
					)";

					$users_courses_results = $wpdb->get_col( $users_courses_sql );

					$users_courses_sql = "SELECT DISTINCT users.ID FROM {$wpdb->users} as users
					LEFT JOIN {$wpdb->usermeta} as um1 ON ( users.ID = um1.user_id )
					LEFT JOIN {$wpdb->usermeta} as um2 ON ( users.ID = um2.user_id )
					WHERE 1=1
					AND (
						um1.meta_key = '{$wpdb->prefix}capabilities'
						AND ( um2.meta_key IN
							(								
								SELECT DISTINCT CONCAT('course_completed_', p.ID, '') FROM {$wpdb->prefix}posts p INNER JOIN {$wpdb->prefix}postmeta pm6 ON ( p.ID = pm6.post_id ) WHERE p.post_type='sfwd-courses' AND p.post_status='publish' AND ( p.post_author = '" . $user_id . "' OR ( pm6.meta_key = '_ld_instructor_ids' AND pm6.meta_value REGEXP '.*;s:[0-9]+:\"{$user_id}\"*' ) )
							
							)
						)
					)";

					$users_course_completed_results = $wpdb->get_col( $users_courses_sql );

					$users_courses_sql = "SELECT DISTINCT users.ID FROM {$wpdb->users} as users
					LEFT JOIN {$wpdb->usermeta} as um1 ON ( users.ID = um1.user_id )
					LEFT JOIN {$wpdb->usermeta} as um2 ON ( users.ID = um2.user_id )
					WHERE 1=1
					AND (
						um1.meta_key = '{$wpdb->prefix}capabilities'
						AND ( um2.meta_key IN
							(
								SELECT DISTINCT CONCAT('learndash_course_expired_', p.ID, '') FROM {$wpdb->prefix}posts p INNER JOIN {$wpdb->prefix}postmeta pm6 ON ( p.ID = pm6.post_id ) WHERE p.post_type='sfwd-courses' AND p.post_status='publish' AND ( p.post_author = '" . $user_id . "' OR ( pm6.meta_key = '_ld_instructor_ids' AND pm6.meta_value REGEXP '.*;s:[0-9]+:\"{$user_id}\"*' ) )
							)
						)
					)";

					$users_course_expired_results = $wpdb->get_col( $users_courses_sql );

					$users_groups_sql = "SELECT DISTINCT users.ID FROM {$wpdb->users} users
					LEFT JOIN {$wpdb->usermeta} as um1 ON ( users.ID = um1.user_id )
					LEFT JOIN {$wpdb->usermeta} as um2 ON ( users.ID = um2.user_id )
					WHERE 1=1
					AND (
						um1.meta_key = '{$wpdb->prefix}capabilities'
						AND ( um2.meta_key IN
								(
									SELECT CONCAT('learndash_group_users_', p.ID, '') FROM {$wpdb->prefix}posts p WHERE p.post_type='groups' AND p.post_status='publish' AND p.post_author = '" . $user_id . "'
								)
							)
						)";

					$users_groups_results = $wpdb->get_col( $users_groups_sql );

					$all_user_ids = array_unique( array_merge( $users_courses_results, $users_course_completed_results, $users_course_expired_results, $users_groups_results ) );

				} else {
					// Else if there are no open courses we the query users with 'learndash_group_users_%' OR 'course_%_access_from' meta_keys.
					$users_courses_sql = "SELECT DISTINCT users.ID FROM {$wpdb->users} as users
					LEFT JOIN {$wpdb->usermeta} as um1 ON ( users.ID = um1.user_id )
					LEFT JOIN {$wpdb->usermeta} as um2 ON ( users.ID = um2.user_id )
					WHERE 1=1
					AND (
						um1.meta_key = '{$wpdb->prefix}capabilities'
						AND ( um2.meta_key IN
							(
								SELECT DISTINCT CONCAT('course_', p.ID, '_access_from') FROM {$wpdb->prefix}posts p WHERE p.post_type='sfwd-courses' AND p.post_status='publish'
								UNION ALL
								SELECT DISTINCT CONCAT('course_completed_', p.ID, '') FROM {$wpdb->prefix}posts p WHERE p.post_type='sfwd-courses' AND p.post_status='publish'
								UNION ALL
								SELECT DISTINCT CONCAT('learndash_course_expired_', p.ID, '') FROM {$wpdb->prefix}posts p WHERE p.post_type='sfwd-courses' AND p.post_status='publish'
							)
						)
					)";

					$users_courses_results = $wpdb->get_col( $users_courses_sql );

					$users_groups_sql = "SELECT DISTINCT users.ID FROM {$wpdb->users} users
					LEFT JOIN {$wpdb->usermeta} as um1 ON ( users.ID = um1.user_id )
					LEFT JOIN {$wpdb->usermeta} as um2 ON ( users.ID = um2.user_id )
					WHERE 1=1
					AND (
						um1.meta_key = '{$wpdb->prefix}capabilities'
						AND ( um2.meta_key IN
								(
									SELECT CONCAT('learndash_group_users_', p.ID, '') FROM {$wpdb->prefix}posts p WHERE p.post_type='groups' AND p.post_status='publish'
								)
							)
						)";

					$users_groups_results = $wpdb->get_col( $users_groups_sql );

					$all_user_ids = array_merge( $users_courses_results, $users_groups_results );
				}
			}

			if ( ( $exclude_admin_users !== true ) && ( $auto_enroll_admin_users === true ) && ( ! empty( $admin_user_ids ) ) ) {
				$all_user_ids = array_merge( $all_user_ids, $admin_user_ids );
			} elseif ( ( $exclude_admin_users === true ) && ( ! empty( $admin_user_ids ) ) ) {
				$all_user_ids = array_diff( $all_user_ids, $admin_user_ids );
			}

			if ( ( ! empty( $all_user_ids ) ) && ( is_array( $all_user_ids ) ) ) {
				$all_user_ids       = array_map( 'intval', $all_user_ids );
				$all_user_ids       = array_unique( $all_user_ids );
				$return_total_users = count( $all_user_ids );
			}
		}

		return $return_total_users;
	}

	/*
	* Get  Students by Insttuctor ID
	*/

	public function ld_dashboard_get_instructor_students_by_id( $user_id, $course_id = '' ) {
		if ( empty( $user_id ) ) {
			return;
		}
		global $wpdb;
		$total_students = array();
		if ( $course_id != '' ) {
			$get_courses_sql = "select ID from {$wpdb->prefix}posts INNER JOIN {$wpdb->prefix}postmeta pm6 ON ( {$wpdb->prefix}posts.ID = pm6.post_id ) where ( post_author={$user_id} OR ( pm6.meta_key = '_ld_instructor_ids' AND pm6.meta_value REGEXP '.*;s:[0-9]+:\"{$user_id}\"*' ) ) AND post_type='sfwd-courses' AND ID = " . $course_id . " AND {$wpdb->prefix}posts.post_status = 'publish' Group By {$wpdb->prefix}posts.ID";

		} else {
			$get_courses_sql = "select ID from {$wpdb->prefix}posts INNER JOIN {$wpdb->prefix}postmeta pm6 ON ( {$wpdb->prefix}posts.ID = pm6.post_id ) where ( post_author={$user_id} OR ( pm6.meta_key = '_ld_instructor_ids' AND pm6.meta_value REGEXP '.*;s:[0-9]+:\"{$user_id}\"*' ) ) AND post_type='sfwd-courses' AND {$wpdb->prefix}posts.post_status = 'publish' Group By {$wpdb->prefix}posts.ID";
		}
		$cousres        = $wpdb->get_results( $get_courses_sql );
		$course_ids     = array( 0 );
		$total_students = array();
		$arg            = array(
			// 'meta_key'     => 'is_student',
			// 'meta_value' => true,
			'fields' => array( 'ID', 'display_name' ),
		);
		if ( ! empty( $cousres ) ) {
			$course_ids = array();
			foreach ( $cousres as $course ) {
				$course_ids[] = $course->ID;
				$ins_student  = learndash_get_users_for_course( $course->ID, $arg, true );
				if ( ! is_array( $ins_student ) ) {
					$total_restudents = $ins_student->get_results();
					if ( ! empty( $total_restudents ) ) {
						foreach ( $total_restudents as $key => $total_restudent ) {
							$total_students[] = $total_restudent;
						}
					}
				}
			}
		}

		if ( ! empty( $total_students ) ) {
			$total_students = array_unique( $total_students, SORT_REGULAR );
			$total_students = array_values( $total_students );
		}

		$args = array(
			'post_type'      => 'sfwd-courses',
			'post_status'    => 'publish',
			'fields'         => 'ids',
			// 'author'       => $user_id,
			'post__in'       => $course_ids,
			'posts_per_page' => -1,
		);
		// $my_courses        = get_posts( $args );
		$my_courses     = new WP_Query( $args );
		$total_students = array();
		$arg            = array(
			// 'meta_key'     => 'is_student',
			// 'meta_value' => true,
			'fields' => array( 'ID', 'display_name' ),
		);

		if ( $my_courses->have_posts() ) {
			while ( $my_courses->have_posts() ) {
					$my_courses->the_post();
				$ins_student = learndash_get_users_for_course( get_the_ID(), $arg, true );
				if ( ! is_array( $ins_student ) ) {
					$total_restudents = $ins_student->get_results();
					if ( ! empty( $total_restudents ) ) {
						foreach ( $total_restudents as $key => $total_restudent ) {
							$total_students[] = $total_restudent;
						}
					}
				}
			}
		}
		wp_reset_postdata();

		if ( ! empty( $total_students ) ) {
			$total_students = array_unique( $total_students, SORT_REGULAR );
			$total_students = array_values( $total_students );
		}
		return apply_filters( 'ld_dashboard_get_instructor_students_by_id', $total_students );
	}

	/*
	* Get Groups Query vars
	*/
	public function ld_dashboard_get_groups_query_vars() {
		$vars                    = array();
		$user                    = wp_get_current_user();
		$get_group_leader_groups = learndash_get_administrators_group_ids( $user->ID );
		if ( ! empty( $get_group_leader_groups ) ) {
			foreach ( $get_group_leader_groups as $key => $group_id ) {
				$group                     = get_post( $group_id );
				$vars[ $group->post_name ] = $group_id;
			}
		}
		return $vars;
	}

	/*
	* Get Course ost Items
	*/
	public function ld_dashboard_get_course_post_items( $course_id = 0,
	$post_types = array( 'sfwd-courses', 'sfwd-quiz', 'sfwd-lessons', 'sfwd-topic' ) ) {
		if ( ! empty( $course_id ) ) {
			$query_course_args = array(
				'post_type'      => $post_types,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_query'     => array(
					'relation' => 'OR',
					array(
						'key'     => 'course_id',
						'value'   => $course_id,
						'compare' => '=',
					),
				),
			);

			if ( version_compare( LEARNDASH_VERSION, '2.4.9.9' ) >= 0 ) {
				$query_course_args['meta_query'][] = array(
					'key'     => 'ld_course_' . $course_id,
					'value'   => $course_id,
					'compare' => '=',
				);
			}
			$query_course = new WP_Query( $query_course_args );
			if ( ! empty( $query_course->posts ) ) {
				return $query_course->posts;
			}
		}
	}

	/**
	 * @param $activity
	 *
	 * @return array|null|WP_Post
	 */
	public function ld_dashboard_get_activity_course( $activity ) {
		if ( ( isset( $activity->activity_course_id ) ) && ( ! empty( $activity->activity_course_id ) ) ) {
			$course_id = intval( $activity->activity_course_id );
		} else {
			$course_id = learndash_get_course_id( $activity->post_id );
		}

		if ( ! empty( $course_id ) ) {
			$course = get_post( $course_id );
			if ( ( $course ) && ( $course instanceof WP_Post ) ) {
				return $course;
			}
		}
	}

	/**
	 * @param $activity
	 *
	 * @return bool
	 */
	public function ld_dashboard_quiz_activity_is_pending( $activity ) {
		if ( ( ! empty( $activity ) ) && ( property_exists( $activity, 'activity_meta' ) ) ) {

			if ( ( isset( $activity->activity_meta['has_graded'] ) ) && ( true === $activity->activity_meta['has_graded'] ) && ( true === LD_QuizPro::quiz_attempt_has_ungraded_question( $activity->activity_meta ) ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param $activity
	 *
	 * @return bool
	 */
	public function ld_dashboard_quiz_activity_is_passing( $activity ) {
		if ( ( ! empty( $activity ) ) && ( property_exists( $activity, 'activity_meta' ) ) ) {

			if ( isset( $activity->activity_meta['pass'] ) ) {
				return (bool) $activity->activity_meta['pass'];
			}
		}

		return false;
	}

	public function ld_dashboard_get_quiz_statistics_link( $activity ) {
		$stats_url = '';

		if ( ( $activity->user_id == get_current_user_id() ) || ( learndash_is_admin_user() ) || ( learndash_is_group_leader_user() ) ) {
			if ( ( isset( $activity->activity_meta['statistic_ref_id'] ) ) && ( ! empty( $activity->activity_meta['statistic_ref_id'] ) ) ) {

				if ( apply_filters(
					'show_user_profile_quiz_statistics',
					get_post_meta( $activity->activity_meta['quiz'], '_viewProfileStatistics', true ),
					$activity->user_id,
					$activity->activity_meta,
					'learndash-dashboard-activity'
				) ) {
					$stats_url = '<a class="user_statistic" data-statistic_nonce="' . wp_create_nonce( 'statistic_nonce_' . $activity->activity_meta['statistic_ref_id'] . '_' . get_current_user_id() . '_' . $activity->user_id ) . '" data-user_id="' . $activity->user_id . '" data-quiz_id="' . $activity->activity_meta['pro_quizid'] . '" data-ref_id="' . intval( $activity->activity_meta['statistic_ref_id'] ) . '" href="#" title="' . sprintf( esc_html__( 'View %s Statistics', 'ld-dashboard' ), LearnDash_Custom_Label::get_label( 'quiz' ) ) . '">' . esc_html__( 'Statistics', 'ld-dashboard' ) . '</a>';
				}
			}
		}

		return $stats_url;
	}

	/**
	 * @param $activity
	 *
	 * @return int
	 */
	public function ld_dashboard_quiz_activity_points_percentage( $activity ) {
		$awarded_points = intval( $this->ld_dashboard_quiz_activity_awarded_points( $activity ) );
		$total_points   = intval( $this->ld_dashboard_quiz_activity_total_points( $activity ) );
		if ( ( ! empty( $awarded_points ) ) && ( ! empty( $total_points ) ) ) {
			return round( 100 * ( intval( $awarded_points ) / intval( $total_points ) ) );
		}
	}

	/**
	 * @param $activity
	 *
	 * @return mixed
	 */
	public function ld_dashboard_quiz_activity_total_points( $activity ) {
		if ( ( ! empty( $activity ) ) && ( property_exists( $activity, 'activity_meta' ) ) ) {
			if ( isset( $activity->activity_meta['total_points'] ) ) {
				return intval( $activity->activity_meta['total_points'] );
			}
		}
	}

	/**
	 * @param $activity
	 *
	 * @return mixed
	 */
	public function ld_dashboard_quiz_activity_awarded_points( $activity ) {
		if ( ( ! empty( $activity ) ) && ( property_exists( $activity, 'activity_meta' ) ) ) {
			if ( isset( $activity->activity_meta['points'] ) ) {
				return intval( $activity->activity_meta['points'] );
			}
		}
	}

	public function ld_dashboard_activity_rows_ajax() {
		global $wp;
		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$activities_settings        = $ld_dashboard_settings_data['activities_settings'];

		$act_limit = $activities_settings['activity-limit'];
		$output    = '';
		$user      = wp_get_current_user();

		/**
		 * Build $activity_query_args from info passed as AJAX
		 */
		$activity_query_args = array(
			'per_page'       => $act_limit,
			'activity_types' => array( 'course', 'quiz', 'lesson', 'topic', 'access' ),
			'post_types'     => array( 'sfwd-courses', 'sfwd-quiz', 'sfwd-lessons', 'sfwd-topic' ),
			'post_status'    => 'publish',
			'orderby_order'  => 'ld_user_activity.activity_updated DESC',
			'date_format'    => 'Y-m-d H:i:s',
			'export_buttons' => true,
			'nav_top'        => true,
		);
		ob_start();
		$paged = 1;
		if ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) {
			$activity_query_args['paged'] = abs( intval( $_GET['paged'] ) );
			$paged                        = intval( $_GET['paged'] );
		} else {
			$activity_query_args['paged'] = $paged;
		}

		// If specific post_ids are provided we want to inlcude in all the lessons, topics, quizzes for display.
		if ( ( isset( $activity_query_args['post_ids'] ) ) && ( ! empty( $activity_query_args['post_ids'] ) ) ) {
			if ( version_compare( LEARNDASH_VERSION, '2.4.9.9' ) >= 0 ) {
				$activity_query_args['course_ids'] = $activity_query_args['post_ids'];
				$activity_query_args['post_ids']   = '';
			} else {
				$post_ids = $activity_query_args['post_ids'];
				foreach ( $post_ids as $course_id ) {
					$course_post_status = get_post_status( $course_id );
					if ( $course_post_status == 'publish' ) {
						$course_post_ids = ld_dashboard_get_course_post_items( $course_id, $activity_query_args['post_types'] );
						if ( ! empty( $course_post_ids ) ) {
							$activity_query_args['post_ids'] = array_merge( $activity_query_args['post_ids'], $course_post_ids );
							$activity_query_args['post_ids'] = array_unique( $activity_query_args['post_ids'] );
						}
					}
				}
			}
		}
		$activity_query_args['activity_status'] = array( 'IN_PROGRESS', 'COMPLETED' );
		add_filter(
			'learndash_user_activity_query_where',
			function ( $sql_str_where ) {
				$sql_str_where = str_replace( 'ld_user_activity.activity_status IN (0,1)', ' ( ld_user_activity.activity_status IS NULL OR ld_user_activity.activity_status IN (0,1))', $sql_str_where );
				return $sql_str_where;
			}
		);
		if ( in_array( 'ld_instructor', (array) $user->roles ) ) {
			$course_students    = array();
			$course_student_ids = array();
			$course_students    = $this->ld_dashboard_get_instructor_students_by_id( $user->ID );

			if ( ! empty( $course_students ) ) {
				foreach ( $course_students as $key => $course_student ) {
					$course_student_ids[] = $course_student->ID;
				}
			}
			array_push( $course_student_ids, $user->ID );
			/* Get The Insttuctor Course */
			$args       = array(
				'post_type'      => array( 'sfwd-courses' ),
				'author'         => $user->ID,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			);
			$courses    = get_posts( $args );
			$course_ids = array();
			foreach ( $courses as $index => $course ) {
				$course_ids[] = $course->ID;
			}
			$activity_query_args['per_page']    = $act_limit;
			$activity_query_args['user_ids']    = $course_student_ids;
			$activity_query_args['course_ids']  = $course_ids;
			$activity_query_args['is_post_ids'] = true;
			$activity_query_args['post_ids']    = true;
		}
		if ( learndash_is_group_leader_user() ) {
			$group_courses                     = learndash_get_group_leader_groups_courses();
			$group_users                       = learndash_get_group_leader_groups_users();
			$activity_query_args['per_page']   = $act_limit;
			$activity_query_args['user_ids']   = ( ! empty( $group_users ) ) ? $group_users : array( 0 );
			$activity_query_args['course_ids'] = ( ! empty( $group_courses ) ) ? $group_courses : array( 0 );
		}

		if ( get_user_meta( $user->ID, 'is_student', true ) || ( ! learndash_is_group_leader_user() && ! learndash_is_admin_user() && ! in_array( 'ld_instructor', (array) $user->roles ) ) ) {
				$activity_query_args['user_ids']    = $user->ID;
				$activity_query_args['per_page']    = $act_limit;
				$activity_query_args['post_ids']    = array();
				$activity_query_args['is_post_ids'] = true;
		}

		add_filter( 'learndash_user_activity_query_where', array( $this, 'ld_dashboard_user_activity_query_where' ), 10, 2 );

		$activities = learndash_reports_get_activity( $activity_query_args );

		$activity_row_date_time_format = apply_filters( 'ld_dashboard_activity_row_date_time_format', get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) );
		foreach ( $activities['results'] as $activity ) {
			$activity->activity_started_formatted = get_date_from_gmt( date( 'Y-m-d H:i:s', $activity->activity_started ), 'Y-m-d H:i:s' );
			$activity->activity_started_formatted = date_i18n( $activity_row_date_time_format, strtotime( $activity->activity_started_formatted ), false );

			$activity->activity_completed_formatted = get_date_from_gmt( date( 'Y-m-d H:i:s', $activity->activity_completed ), 'Y-m-d H:i:s' );
			$activity->activity_completed_formatted = date_i18n( $activity_row_date_time_format, strtotime( $activity->activity_completed_formatted ), false );

			$activity->activity_updated_formatted = get_date_from_gmt( date( 'Y-m-d H:i:s', $activity->activity_updated ), 'Y-m-d H:i:s' );
			$activity->activity_updated_formatted = date_i18n( $activity_row_date_time_format, strtotime( $activity->activity_updated_formatted ), false );

			include LD_DASHBOARD_PLUGIN_DIR . 'templates/ld-dashboard-activity-rows.php';
		}
		if ( isset( $activities['pager'] ) ) {
			$activities['pager']['current_page'] = $activity_query_args['paged'];
			include LD_DASHBOARD_PLUGIN_DIR . 'templates/ld-dashboard-activity-pagination.php';
		}

		echo $html = ob_get_clean();

		wp_die();
	}
	/*
	* Learndash dashboard activity Row
	*/

	public function ld_dashboard_activity_rows() {
		global $wp,$wpdb;

		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$activities_settings        = $ld_dashboard_settings_data['activities_settings'];

		$act_limit = $activities_settings['activity-limit'];
		$output    = '';
		$user      = wp_get_current_user();

		/**
		 * Build $activity_query_args from info passed as AJAX
		 */
		$activity_query_args = array(
			'per_page'       => $act_limit,
			'activity_types' => array( 'course', 'quiz', 'lesson', 'topic', 'access' ),
			'post_types'     => array( 'sfwd-courses', 'sfwd-quiz', 'sfwd-lessons', 'sfwd-topic' ),
			'post_status'    => 'publish',
			'orderby_order'  => 'ld_user_activity.activity_updated DESC',
			'date_format'    => 'Y-m-d H:i:s',
			'export_buttons' => true,
			'nav_top'        => true,
		);

		$paged = 1;
		if ( isset( $_GET['args']['paged'] ) && ! empty( $_GET['args']['paged'] ) ) {
			$activity_query_args['paged'] = abs( intval( $_GET['args']['paged'] ) );
			$paged                        = intval( $_GET['args']['paged'] );
		} else {
			$activity_query_args['paged'] = $paged;
		}

		if ( ! empty( $activity_query_args ) ) {

			// If specific post_ids are provided we want to include in all the lessons, topics, quizzes for display.
			if ( ( isset( $activity_query_args['post_ids'] ) ) && ( ! empty( $activity_query_args['post_ids'] ) ) ) {
				if ( version_compare( LEARNDASH_VERSION, '2.4.9.9' ) >= 0 ) {
					$activity_query_args['course_ids'] = $activity_query_args['post_ids'];
					$activity_query_args['post_ids']   = '';
				} else {
					$post_ids = $activity_query_args['post_ids'];
					foreach ( $post_ids as $course_id ) {
						$course_post_status = get_post_status( $course_id );
						if ( $course_post_status == 'publish' ) {
							$course_post_ids = ld_dashboard_get_course_post_items( $course_id, $activity_query_args['post_types'] );
							if ( ! empty( $course_post_ids ) ) {
								$activity_query_args['post_ids'] = array_merge( $activity_query_args['post_ids'], $course_post_ids );
								$activity_query_args['post_ids'] = array_unique( $activity_query_args['post_ids'] );
							}
						}
					}
				}
			}
			$activity_query_args['activity_status'] = array( 'IN_PROGRESS', 'COMPLETED' );
			add_filter(
				'learndash_user_activity_query_where',
				function ( $sql_str_where ) {
					$sql_str_where = str_replace( 'ld_user_activity.activity_status IN (0,1)', ' ( ld_user_activity.activity_status IS NULL OR ld_user_activity.activity_status IN (0,1))', $sql_str_where );
					return $sql_str_where;
				}
			);

			if ( in_array( 'ld_instructor', (array) $user->roles ) ) {
				$course_students    = array();
				$course_student_ids = array();
				$course_students    = $this->ld_dashboard_get_instructor_students_by_id( $user->ID );

				if ( ! empty( $course_students ) ) {
					foreach ( $course_students as $key => $course_student ) {
						$course_student_ids[] = $course_student->ID;
					}
				}
				array_push( $course_student_ids, $user->ID );
				/* Get The Instuctor Course */
				$get_courses_sql = "select ID from {$wpdb->prefix}posts INNER JOIN {$wpdb->prefix}postmeta pm6 ON ( {$wpdb->prefix}posts.ID = pm6.post_id ) where ( post_author={$user->ID} OR ( pm6.meta_key = '_ld_instructor_ids' AND pm6.meta_value REGEXP '.*;s:[0-9]+:\"{$user->ID}\"*' ) ) AND post_type='sfwd-courses' AND {$wpdb->prefix}posts.post_status = 'publish' Group By {$wpdb->prefix}posts.ID";

				$cousres    = $wpdb->get_results( $get_courses_sql );
				$course_ids = array();
				if ( ! empty( $cousres ) ) {
					$course_ids = array();
					foreach ( $cousres as $course ) {
						$course_ids[] = $course->ID;
					}
				}
				$args = array(
					'post_type'      => array( 'sfwd-courses' ),
					'author'         => $user->ID,
					'post_status'    => 'publish',
					'posts_per_page' => -1,
				);
				if ( ! empty( $course_ids ) ) {
					unset( $args['author'] );
					$args['post__in'] = $course_ids;
				}

				$courses    = get_posts( $args );
				$course_ids = array();
				foreach ( $courses as $index => $course ) {
					$course_ids[] = $course->ID;
				}

				$activity_query_args['per_page']    = $act_limit;
				$activity_query_args['user_ids']    = $course_student_ids;
				$activity_query_args['course_ids']  = $course_ids;
				$activity_query_args['is_post_ids'] = true;
				$activity_query_args['post_ids']    = true;
			}
			if ( learndash_is_group_leader_user() && ! in_array( 'ld_instructor', (array) $user->roles ) ) {
				$group_courses                     = learndash_get_group_leader_groups_courses();
				$group_users                       = learndash_get_group_leader_groups_users();
				$activity_query_args['per_page']   = $act_limit;
				$activity_query_args['user_ids']   = ( ! empty( $group_users ) ) ? $group_users : array( 0 );
				$activity_query_args['course_ids'] = ( ! empty( $group_courses ) ) ? $group_courses : array( 0 );
			}
			if ( ( isset( $_GET['tab'] ) && 'my-activity' === $_GET['tab'] ) || get_user_meta( $user->ID, 'is_student', true ) || ( ! learndash_is_group_leader_user() && ! learndash_is_admin_user() && ! in_array( 'ld_instructor', (array) $user->roles ) ) ) {
				$activity_query_args['user_ids']    = $user->ID;
				$activity_query_args['per_page']    = $act_limit;
				$activity_query_args['post_ids']    = array();
				$activity_query_args['is_post_ids'] = true;
			}
			add_filter( 'learndash_user_activity_query_where', array( $this, 'ld_dashboard_user_activity_query_where' ), 10, 2 );
			$activities = learndash_reports_get_activity( $activity_query_args );
			if ( empty( $activities['results'] ) ) {
				?>
				<div class="ld-dashboard-activity-empty">
					<?php
					if ( ( isset( $_GET['tab'] ) && 'my-activity' === $_GET['tab'] ) || get_user_meta( $user->ID, 'is_student', true ) || ( ! learndash_is_group_leader_user() && ! learndash_is_admin_user() && ! in_array( 'ld_instructor', (array) $user->roles ) ) ) {

						echo apply_filters( 'ld_dashboard_no_activity_text', sprintf( esc_html__( 'Sorry, We are not able to find any %1$s related activities, Please complete some %2$s, %3$s or %4$s.', 'ld-dashboard' ), strtolower( LearnDash_Custom_Label::get_label( 'course' ) ), strtolower( LearnDash_Custom_Label::get_label( 'lessons' ) ), strtolower( LearnDash_Custom_Label::get_label( 'topics' ) ), strtolower( LearnDash_Custom_Label::get_label( 'quizzes' ) ) ) );
					} else {

						echo apply_filters( 'ld_dashboard_no_activity_text', sprintf( esc_html__( 'Sorry, We are not able to find any %1$s related activities, Please encourage your students to complete some %2$s, %3$s or %4$s. ', 'ld-dashboard' ), strtolower( LearnDash_Custom_Label::get_label( 'course' ) ), strtolower( LearnDash_Custom_Label::get_label( 'lessons' ) ), strtolower( LearnDash_Custom_Label::get_label( 'topics' ) ), strtolower( LearnDash_Custom_Label::get_label( 'quizzes' ) ) ) );
					}
					?>
				</div>
				<?php
			} else {
				$activity_row_date_time_format = apply_filters( 'ld_dashboard_activity_row_date_time_format', get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) );
				foreach ( $activities['results'] as $activity ) {
					$activity->activity_started_formatted = get_date_from_gmt( date( 'Y-m-d H:i:s', $activity->activity_started ), 'Y-m-d H:i:s' );
					$activity->activity_started_formatted = date_i18n( $activity_row_date_time_format, strtotime( $activity->activity_started_formatted ), false );

					$activity->activity_completed_formatted = get_date_from_gmt( date( 'Y-m-d H:i:s', $activity->activity_completed ), 'Y-m-d H:i:s' );
					$activity->activity_completed_formatted = date_i18n( $activity_row_date_time_format, strtotime( $activity->activity_completed_formatted ), false );

					$activity->activity_updated_formatted = get_date_from_gmt( date( 'Y-m-d H:i:s', $activity->activity_updated ), 'Y-m-d H:i:s' );
					$activity->activity_updated_formatted = date_i18n( $activity_row_date_time_format, strtotime( $activity->activity_updated_formatted ), false );

					include LD_DASHBOARD_PLUGIN_DIR . 'templates/ld-dashboard-activity-rows.php';
				}
				if ( isset( $activities['pager'] ) ) {
					$activities['pager']['current_page'] = $activity_query_args['paged'];
					include LD_DASHBOARD_PLUGIN_DIR . 'templates/ld-dashboard-activity-pagination.php';
				}
			}
		} else {
			?>
			<div class="ld-dashbard-activity-empty">
				<?php
				if ( get_user_meta( $user->ID, 'is_student', true ) || ( ! learndash_is_group_leader_user() && ! learndash_is_admin_user() && ! in_array( 'ld_instructor', (array) $user->roles ) ) ) {

					echo apply_filters( 'ld_dashboard_no_activity_text', sprintf( esc_html__( 'Sorry, We are not able to find any %1$s related activities, Please complete some %2$s, %3$s or %.', 'ld-dashboard' ), strtolower( LearnDash_Custom_Label::get_label( 'course' ) ), strtolower( LearnDash_Custom_Label::get_label( 'lessons' ) ), strtolower( LearnDash_Custom_Label::get_label( 'topics' ) ), strtolower( LearnDash_Custom_Label::get_label( 'quizzes' ) ) ) );
				} else {

					echo apply_filters( 'ld_dashboard_no_activity_text', sprintf( esc_html__( 'Sorry, We are not able to find any %1$s related activities, Please encourage your students to complete some %2$s, %3$s or %4$s. ', 'ld-dashboard' ), strtolower( LearnDash_Custom_Label::get_label( 'course' ) ), strtolower( LearnDash_Custom_Label::get_label( 'lessons' ) ), strtolower( LearnDash_Custom_Label::get_label( 'topics' ) ), strtolower( LearnDash_Custom_Label::get_label( 'quizzes' ) ) ) );
				}
				?>
			</div>
			<?php
		}
	}

	/*
	* Get the Insttuctor Overview statistic
	*/

	public function ld_get_overview_instructor_states() {

		$user                          = wp_get_current_user();
		$ld_dashboard_instructors_stds = get_users(
			array(
				'fields'   => array( 'ID', 'display_name' ),
				'role__in' => array( 'ld_instructor', 'administrator' ),
			)
		);
		if ( in_array( 'ld_instructor', (array) $user->roles ) ) {
			$ld_dashboard_instructors_stds   = array();
			$obj                             = new stdClass();
			$obj->ID                         = $user->ID;
			$obj->display_name               = $user->display_name;
			$ld_dashboard_instructors_stds[] = $obj;
		}
		$instructor_stat_data = array();
		if ( ! empty( $ld_dashboard_instructors_stds ) ) {
			foreach ( $ld_dashboard_instructors_stds as $udata ) {
				$temp                  = array();
				$temp['instructor_id'] = $udata->ID;
				$temp['display_name']  = $udata->display_name;
				/**
				 * Count Courses
				 */
				$course_count = 0;
				$course_args  = array(
					'post_type'      => 'sfwd-courses',
					'posts_per_page' => -1,
					'author'         => $udata->ID,
					'post_status'    => 'publish',
				);
				$courses      = get_posts( $course_args );
				if ( ! empty( $courses ) ) {
					$course_count = count( $courses );
				}
				$temp['course_count'] = $course_count;
				/**
				 * Count Lessons
				 */
				$lesson_count = 0;
				$lesson_args  = array(
					'post_type'      => 'sfwd-lessons',
					'posts_per_page' => -1,
					'author'         => $udata->ID,
					'post_status'    => 'publish',
				);
				$lessons      = get_posts( $lesson_args );
				if ( ! empty( $lessons ) ) {
					$lesson_count = count( $lessons );
				}
				$temp['lesson_count'] = $lesson_count;
				/**
				 * Count Topics
				 */
				$topic_count = 0;
				$topic_args  = array(
					'post_type'      => 'sfwd-topic',
					'posts_per_page' => -1,
					'author'         => $udata->ID,
					'post_status'    => 'publish',
				);
				$topics      = get_posts( $topic_args );
				if ( ! empty( $topics ) ) {
					$topic_count = count( $topics );
				}
				$temp['topic_count'] = $topic_count;
				/**
				 * Count Quizzes
				 */
				$quiz_count = 0;
				$quiz_args  = array(
					'post_type'      => 'sfwd-quiz',
					'posts_per_page' => -1,
					'author'         => $udata->ID,
					'post_status'    => 'publish',
				);
				$quizzes    = get_posts( $quiz_args );
				if ( ! empty( $quizzes ) ) {
					$quiz_count = count( $quizzes );
				}
				$temp['quiz_count'] = $quiz_count;
				/**
				 * Count Assignments
				 */
				$assignment_count = 0;
				$assignment_args  = array(
					'post_type'      => 'sfwd-assignment',
					'posts_per_page' => -1,
					'author'         => $udata->ID,
					'post_status'    => 'publish',
				);
				$assignments      = get_posts( $assignment_args );
				if ( ! empty( $assignments ) ) {
					$assignment_count = count( $assignments );
				}
				$temp['assignment_count'] = $assignment_count;
				$instructor_stat_data[]   = $temp;
			}
		}
		return $instructor_stat_data;
	}

	/**
	 * Retrieve the complete details of the student.
	 */
	public function ld_dashboard_get_student_data( $user_id ) {
		$sfwd_course_progress = get_user_meta( $user_id, '_sfwd-course_progress', true );
		$student_data         = array();
		$course_completed     = 0;
		if ( ! empty( $sfwd_course_progress ) ) {
			foreach ( $sfwd_course_progress as $cid => $data ) {
				if ( get_user_meta( $user_id, 'course_completed_' . $cid, true ) ) {
					$course_completed ++;
				}
			}
		}

		$sfwd_quizzes   = get_user_meta( $user_id, '_sfwd-quizzes', true );
		$quiz_completed = 0;
		if ( ! empty( $sfwd_quizzes ) ) {
			foreach ( $sfwd_quizzes as $key => $quiz ) {
				$quiz_completed += learndash_get_user_quiz_attempts_count( $user_id, $quiz['quiz'] );
			}
		}

		$assignment_args = array(
			'post_type'   => 'sfwd-assignment',
			'post_status' => 'publish',
			'author'      => $user_id,
			'meta_key'    => 'approval_status',
			'meta_value'  => 1,
		);
		$assignment      = get_posts( $assignment_args );
		$course_count    = 0;
		if ( count( $assignment ) > 0 ) {
			$course_count = count( $assignment );
		}

		$student_data['course_completed']     = $course_completed;
		$student_data['quiz_completed']       = $quiz_completed;
		$student_data['assignment_completed'] = $course_count;
		return $student_data;
	}

	/*
	* Add shortcode functuon
	*/

	public function ld_dashboard_register_shortcodes() {
		add_shortcode( 'ld_dashboard', array( $this, 'ld_dashboard_functions' ) );
		add_shortcode( 'ld_email', array( $this, 'ld_dashboard_email_functions' ) );
		add_shortcode( 'ld_message', array( $this, 'ld_dashboard_message_functions' ) );
		add_shortcode( 'ld_instructor_registration', array( $this, 'ld_instructor_registration_functions' ) );

		add_shortcode( 'ld_course_details', array( $this, 'ld_dashboard_course_details_functions' ) );
		add_shortcode( 'ld_student_details', array( $this, 'ld_dashboard_student_details_functions' ) );
	}

	public function ld_dashboard_functions( $atts, $content ) {

		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$ld_dashboard               = $ld_dashboard_settings_data['general_settings'];

		$user_id    = get_current_user_id();
		$is_student = get_user_meta( $user_id, 'is_student', true );

		ob_start();
		if ( ! is_user_logged_in() ) {
			?>

			<p><?php esc_html_e( 'Please try to login to website to access dashboard. Dashboard are disabled for logout members. ', 'ld-dashboard' ); ?></p>
			<?php
			return ob_get_clean();
		}
		include LD_DASHBOARD_PLUGIN_DIR . 'templates/ld-dashboard.php';

		return ob_get_clean();
	}

	/**
	 * Check and return course progress data
	 *
	 * @param type $user_id
	 * @param type $course_id
	 * @return array
	 */
	public function ld_dashboard_check_course_progress_data( $user_id, $course_id ) {
		if ( empty( $user_id ) || empty( $course_id ) ) {
			return;
		}

		$percentage           = 0;
		$cours_completed_date = '-';
		$user_meta            = get_user_meta( $user_id, '_sfwd-course_progress', true );
		$user_quizze          = get_user_meta( $user_id, '_sfwd-quizzes', true );
		if ( ! empty( $user_meta ) ) {
			if ( isset( $user_meta[ $course_id ] ) ) {
				$percentage           = floor( ( $user_meta[ $course_id ]['completed'] / $user_meta[ $course_id ]['total'] ) * 100 );
				$cours_completed_meta = get_user_meta( $user_id, 'course_completed_' . $course_id, true );
				$cours_completed_date = ( ! empty( $cours_completed_meta ) ) ? date_i18n( 'F j, Y H:i:s', $cours_completed_meta ) : '';
			}
			$ld_course_steps = get_post_meta( $course_id, 'ld_course_steps', true );
			$lessons_ids     = $topic_ids = array();
			if ( ! empty( $ld_course_steps ) && isset( $ld_course_steps['h']['sfwd-lessons'] ) ) {

				foreach ( $ld_course_steps['h']['sfwd-lessons'] as $key => $topic ) {
					$lessons_ids[] = $key;
					foreach ( $topic['sfwd-topic'] as $topic_id => $quiz ) {
						$topic_ids[] = $topic_id;
					}
				}
			}

			/* Get the Number of Assignments from Leasson */
			$query_lessons_args = array(
				'post_type'      => 'sfwd-lessons',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_query'     => array(
					'relation' => 'OR',
					array(
						'key'     => 'course_id',
						'value'   => $course_id,
						'compare' => '=',
					),
				),
			);
			if ( ! empty( $lessons_ids ) ) {
				unset( $query_lessons_args['meta_query'] );
				$query_lessons_args['post__in'] = $lessons_ids;
			}
			$query_lessons            = new WP_Query( $query_lessons_args );
			$course_assignment_counts = 0;
			$total_assignment_counts  = 0;
			if ( $query_lessons->have_posts() ) {
				while ( $query_lessons->have_posts() ) {
					$query_lessons->the_post();
					$_sfwd_lessons = get_post_meta( get_the_ID(), '_sfwd-lessons', true );
					if ( isset( $_sfwd_lessons['sfwd-lessons_lesson_assignment_upload'] ) && $_sfwd_lessons['sfwd-lessons_lesson_assignment_upload'] == 'on' ) {
						$total_assignment_counts = ++$course_assignment_counts;
					}
				}
			}
			wp_reset_postdata();

			/* Get the Number of Assignments from sfwd-topic */
			$query_topic_args = array(
				'post_type'      => 'sfwd-topic',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_query'     => array(
					'relation' => 'OR',
					array(
						'key'     => 'course_id',
						'value'   => $course_id,
						'compare' => '=',
					),
				),
			);
			if ( ! empty( $topic_ids ) ) {
				unset( $query_topic_args['meta_query'] );
				$query_topic_args['post__in'] = $topic_ids;
			}
			$query_topic = new WP_Query( $query_topic_args );
			if ( $query_topic->have_posts() ) {
				while ( $query_topic->have_posts() ) {
					$query_topic->the_post();
					$_sfwd_topic = get_post_meta( get_the_ID(), '_sfwd-topic', true );
					if ( isset( $_sfwd_topic['sfwd-topic_lesson_assignment_upload'] ) && $_sfwd_topic['sfwd-topic_lesson_assignment_upload'] == 'on' ) {
						$total_assignment_counts = ++$course_assignment_counts;
					}
				}
			}
			wp_reset_postdata();

			/* Get the Number of Assignments From user uploaded */
			$query_assignment_args = array(
				'post_type'      => 'sfwd-assignment',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_query'     => array(
					'relation' => 'AND',
					array(
						'key'     => 'course_id',
						'value'   => $course_id,
						'compare' => '=',
					),
					array(
						'key'     => 'user_id',
						'value'   => $user_id,
						'compare' => '=',
					),
				),
			);
			$query_assignment      = new WP_Query( $query_assignment_args );

			$number_of_assignment_counts         = 0;
			$number_of_approve_assignment_counts = 0;
			$assignment_percentage               = 0;
			if ( $query_assignment->have_posts() ) {
				while ( $query_assignment->have_posts() ) {
					$query_assignment->the_post();
					$number_of_assignment_counts = ++$number_of_assignment_counts;
					if ( get_post_meta( get_the_ID(), 'approval_status', true ) == 1 ) {
						$number_of_approve_assignment_counts = ++$number_of_approve_assignment_counts;
					}
				}
				$assignment_percentage = floor( ( $number_of_approve_assignment_counts / $total_assignment_counts ) * 100 );
			}
			wp_reset_postdata();

			/* User Quize Progress */
			$quizze_percentage = 0;

			$query_quizze_args      = array(
				'post_type'      => 'sfwd-quiz',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_query'     => array(
					'relation' => 'AND',
					array(
						'key'     => 'course_id',
						'value'   => $course_id,
						'compare' => '=',
					),
				),
			);
			$query_quizze           = new WP_Query( $query_quizze_args );
			$total_quizze           = $query_quizze->post_count;
			$total_completed_quizze = 0;
			if ( ! empty( $user_quizze ) ) {
				$quizze_lesson = array();
				foreach ( $user_quizze as $quizze ) {
					if ( $course_id == $quizze['course'] ) {
						if ( $quizze['pass'] == 1 && ! in_array( $quizze['lesson'], $quizze_lesson ) ) {
							$quizze_percentage = $quizze['percentage'];
							++$total_completed_quizze;
							$quizze_lesson[] = $quizze['lesson'];
						}
					}
				}
			}
			wp_reset_postdata();

			$course_arr = array(
				'total_steps'              => learndash_get_course_steps_count( $course_id ),
				'completed_steps'          => isset( $user_meta[ $course_id ]['completed'] ) ? $user_meta[ $course_id ]['completed'] : '0',
				'percentage'               => $percentage,
				'course_completed_on'      => $cours_completed_date,
				'total_course_assignment'  => $total_assignment_counts,
				'total_assignment'         => $number_of_assignment_counts,
				'total_approve_assignment' => $number_of_approve_assignment_counts,
				'assignment_percentage'    => $assignment_percentage,
				'quizze_percentage'        => ( $total_quizze != 0 && $total_completed_quizze != 0 ) ? ( $total_completed_quizze / $total_quizze ) * 100 : 0,
				'total_quizze'             => $total_quizze,
				'total_completed_quizze'   => $total_completed_quizze,
			);
			return $course_arr;
		} else {
			$course_arr = array(
				'total_steps'              => learndash_get_course_steps_count( $course_id ),
				'completed_steps'          => learndash_course_get_completed_steps( $user_id, $course_id ),
				'percentage'               => $percentage,
				'course_completed_on'      => '',
				'total_course_assignment'  => 0,
				'total_assignment'         => 0,
				'total_approve_assignment' => 0,
				'assignment_percentage'    => 0,
				'quizze_percentage'        => 0,
			);
			return $course_arr;
		}
	}

	/**
	 * Check course progress data is set for single course
	 *
	 * @param type $course_progress_data
	 * @param type $course_id
	 * @return int
	 */
	function ld_dashboard_check_isset( $course_progress_data, $course_id = null ) {
		if ( isset( $course_progress_data ) ) {
			return $course_progress_data;
		} elseif ( $course_id != '' ) {
			$total_steps   = 0;
			$total_quizs   = learndash_get_global_quiz_list( $course_id );
			$total_lessons = learndash_get_lesson_list( $course_id );
			if ( ! empty( $total_quizs ) ) {
				$total_steps = 1;
			}
			if ( ! empty( $total_lessons ) ) {
				$total_steps += count( $total_lessons );
			}

			return $total_steps;
		}
		return 0;
	}

	/**
	 * Get all users ids for course
	 *
	 * @param type $course_id
	 * @return array
	 */
	public function ld_dashboard_get_user_info( $user_id, $course_id ) {
		$ld_dashboard_course_users               = array();
		$user_meta                               = get_userdata( $user_id );
		$ld_dashboard_course_users['userid']     = $user_id;
		$ld_dashboard_course_users['user_name']  = $user_meta->data->display_name;
		$ld_dashboard_course_users['username']   = $user_meta->data->user_login;
		$ld_dashboard_course_users['user_email'] = $user_meta->data->user_email;

		$course_progress = $this->ld_dashboard_check_course_progress_data( $user_id, $course_id );

		$ld_dashboard_course_users['completed_per']       = $this->ld_dashboard_check_isset( $course_progress['percentage'] );
		$ld_dashboard_course_users['total_steps']         = $this->ld_dashboard_check_isset( $course_progress['total_steps'], $course_id );
		$ld_dashboard_course_users['completed_steps']     = $this->ld_dashboard_check_isset( $course_progress['completed_steps'] );
		$ld_dashboard_course_users['course_completed_on'] = ( isset( $course_progress['course_completed_on'] ) && $course_progress['course_completed_on'] != '' ) ? $course_progress['course_completed_on'] : esc_html__( 'Not Completed', 'ld-dashboard' );

		return $ld_dashboard_course_users;
	}

	/**
	 * Single user chart data for single course
	 *
	 * @param type $user_id
	 * @param type $course_id
	 * @return array
	 */
	public function ld_dashboard_get_student_info_chart( $user_id, $course_id ) {
		$ld_dashboard_course_users                        = array();
		$user_meta                                        = get_userdata( $user_id );
		$ld_dashboard_course_users['user_id']             = $user_id;
		$ld_dashboard_course_users['name']                = $user_meta->data->user_login;
		$ld_dashboard_course_users['email']               = $user_meta->data->user_email;
		$ld_dashboard_course_users['course_id']           = $course_id;
		$course_progress                                  = $this->ld_dashboard_check_course_progress_data( $user_id, $course_id );
		$ld_dashboard_course_users['total_steps']         = $this->ld_dashboard_check_isset( $course_progress['total_steps'], $course_id );
		$ld_dashboard_course_users['completed_steps']     = $this->ld_dashboard_check_isset( $course_progress['completed_steps'] );
		$ld_dashboard_course_users['course_completed_on'] = ( isset( $course_progress['course_completed_on'] ) ? $course_progress['course_completed_on'] : '-' );
		return $ld_dashboard_course_users;
	}

	/**
	 * Percentage Calculate
	 *
	 * @param type $completed
	 * @param type $total
	 * @return int
	 */
	function ld_dashboard_calculate_percentage_completion( $completed, $total ) {
		if ( empty( $completed ) ) {
			return 0;
		}

		$percentage = intVal( $completed * 100 / $total );
		$percentage = ( $percentage > 100 ) ? 100 : $percentage;
		return $percentage;
	}

	/**
	 * Return selected course data
	 *
	 * @param type $data
	 * @return array
	 */
	function ld_dashboard_rearrange_course_progress_data( $data ) {
		$course_progress_data = array();

		if ( ! empty( $data ) ) {
			foreach ( $data as $d ) {
				$course_id = $d['course_id'];
				$user_id   = $d['user_id'];

				if ( empty( $course_progress_data[ $course_id ] ) ) {
					$course_progress_data[ $course_id ] = array(
						'course_title' => get_the_title( $course_id ),
						'users'        => array(),
						'not_started'  => 0,
						'progress'     => 0,
						'completed'    => 0,
					);
				}

				if ( empty( $course_progress_data[ $course_id ]['users'][ $user_id ] ) ) {
					$d['percentage'] = $this->ld_dashboard_calculate_percentage_completion( $d['completed_steps'], $d['total_steps'] );
					if ( empty( $d['percentage'] ) ) {
						$course_progress_data[ $course_id ]['not_started'] ++;
					} elseif ( $d['percentage'] > 0 && $d['percentage'] < 100 ) {
						$course_progress_data[ $course_id ]['progress'] ++;
					} elseif ( $d['percentage'] >= 100 ) {
						$course_progress_data[ $course_id ]['completed'] ++;
					} else {
						$course_progress_data[ $course_id ]['not_started'] ++;
					}

					$course_progress_data[ $course_id ]['users'][ $user_id ] = $d;
				}
			}
		}

		if ( ! empty( $course_progress_data ) ) {
			foreach ( $course_progress_data as $key => $value ) {
				if ( $count = count( $course_progress_data[ $key ]['users'] ) ) {
					$course_progress_data[ $key ]['not_started'] = $course_progress_data[ $key ]['not_started'] * 100 / $count;
					$course_progress_data[ $key ]['progress']    = $course_progress_data[ $key ]['progress'] * 100 / $count;
					$course_progress_data[ $key ]['completed']   = $course_progress_data[ $key ]['completed'] * 100 / $count;
				}
			}
		}

		return $course_progress_data;
	}

	/**
	 * Get all users ids for course
	 *
	 * @param type $course_id
	 * @return array
	 */
	public function ld_dashboard_course_selected( $course_id ) {
		$data                = array();
		$course_access_users = get_users(
			array(
				'fields'     => 'ID',
				'meta_key'   => 'is_student',
				'meta_value' => true,
			)
		);
		if ( ! empty( $course_access_users ) ) {
			foreach ( $course_access_users as $key => $id ) {
				$data[] = $this->ld_dashboard_get_student_info_chart( $id, $course_id );
			}
		}
		return $this->ld_dashboard_rearrange_course_progress_data( $data );
	}

	/**
	 * Get the Course Details from ajax
	 */
	public function ld_dashboard_course_details() {
		check_ajax_referer( 'ld-dashboard', 'nonce' );

		$course_id = sanitize_text_field( $_POST['course_id'] );
		$sort_by   = sanitize_text_field( $_POST['sort_by'] );
		$user      = wp_get_current_user();

		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$general_settings           = $ld_dashboard_settings_data['general_settings'];

		$users_per_page = isset( $general_settings['student-per-page-count'] ) ? $general_settings['student-per-page-count'] : 10;

		$course_pricing = learndash_get_course_price( $course_id );
		if ( 'open' !== $course_pricing['type'] ) {
			$course_student   = learndash_get_course_users_access_from_meta( $course_id );
			$course_group_ids = learndash_get_course_groups( $course_id );
			if ( is_array( $course_group_ids ) && ! empty( $course_group_ids ) ) {
				foreach ( $course_group_ids as $grp_id ) {
					$group_users = learndash_get_groups_user_ids( $grp_id );
					if ( ! empty( $group_users ) ) {
						$course_student = array_unique( array_merge( $course_student, $group_users ) );
					}
				}
			}
		} else {
			$course_student = array();
			$users          = get_users();
			if ( ! empty( $users ) ) {
				foreach ( $users as $student ) {
					$course_student[] = $student->ID;
				}
			}
		}
		$student_ids = $course_student;
		if ( learndash_is_group_leader_user() && ! in_array( 'ld_instructor', (array) $user->roles ) ) {
			$group_student_ids = learndash_get_group_leader_groups_users();
			$course_count      = learndash_get_group_leader_groups_courses();
			$student_ids       = array_intersect( $student_ids, $group_student_ids );
		}
		$args = array(
			'fields'   => array( 'ID', 'display_name' ),
			'meta_key' => 'course_' . $course_id . '_access_from',
			'include'  => $student_ids,
		);
		if ( ! empty( $student_ids ) ) {
			unset( $args['meta_key'] );
		}
		$price_type = get_post_meta( $course_id, '_ld_price_type', true );
		if ( in_array( 'administrator', (array) $user->roles ) && 'open' === $price_type && isset( $args['meta_key'] ) ) {
			unset( $args['meta_key'] );
		}
		$course_access_users = get_users( $args );

		$course_userInfo = array();
		$uids            = array();
		$user_data       = array();
		if ( ! empty( $course_access_users ) ) {
			add_filter( 'posts_clauses', array( $this, 'ld_dashboard_remove_course_author_posts_clauses' ), 99 );
			foreach ( $course_access_users as $uid ) {
				$course_userInfo[] = $this->ld_dashboard_get_user_info( $uid->ID, $course_id );
				$uids[]            = $uid->ID;
				$user_data[]       = $this->ld_dashboard_get_student_info_chart( $uid->ID, $course_id );
			}
		}

		/* Sorft By Progress % */
		if ( $sort_by == 'progress_percentage' ) {
			usort(
				$course_userInfo,
				function( $a, $b ) {
					if ( $a['completed_per'] == $b['completed_per'] ) {
						return 0;
					}
					return ( $a['completed_per'] > $b['completed_per'] ) ? -1 : 1;
				}
			);
		}

		/* Sorft By Completed Date wise */
		if ( $sort_by == 'completed_date' ) {
			usort(
				$course_userInfo,
				function( $a, $b ) {
					if ( strtotime( $a['course_completed_on'] ) == strtotime( $b['course_completed_on'] ) ) {
						return 0;
					}
					return ( strtotime( $a['course_completed_on'] ) > strtotime( $b['course_completed_on'] ) ) ? -1 : 1;
				}
			);
		}

		$page        = ! empty( $_POST['page'] ) ? (int) $_POST['page'] : 1;
		$total       = count( $course_userInfo ); // Total items in array.
		$limit       = apply_filters( 'ld_dashboard_course_details_per_page', $users_per_page );
		$total_pages = ceil( $total / $limit ); // Calculate total pages.
		$page        = max( $page, 1 ); // Get 1 page when $_GET['page'] <= 0.
		$page        = min( $page, $total_pages ); // Get last page when $_GET['page'] > $total_pages.
		$offset      = ( $page - 1 ) * $limit;
		if ( $offset < 0 ) {
			$offset = 0;
		}

		$course_userInfo     = array_slice( $course_userInfo, $offset, $limit );
		$user_data           = array_slice( $user_data, $offset, $limit );
		$student_report_html = '';

		if ( ! empty( $course_userInfo ) ) {
			$student_report_html .= '<tbody>';
			foreach ( $course_userInfo as $key => $data ) {
				$email               = $data['user_email'];
				$user_name           = isset( $data['user_name'] ) ? $data['user_name'] : '-';
				$username            = isset( $data['username'] ) ? $data['username'] : '-';
				$user_email          = isset( $data['user_email'] ) ? $data['user_email'] : '-';
				$completed_per       = isset( $data['completed_per'] ) ? $data['completed_per'] : '-';
				$total_steps         = isset( $data['total_steps'] ) ? $data['total_steps'] : '-';
				$completed_steps     = isset( $data['completed_steps'] ) ? $data['completed_steps'] : '-';
				$course_completed_on = isset( $data['course_completed_on'] ) ? $data['course_completed_on'] : '-';
				$user_id             = $data['userid'];

				$student_report_html .= '<tr>';
				$student_report_html .= '<td>' . $user_name . '</td>';
				$student_report_html .= '<td>' . $total_steps . '</td>';
				$student_report_html .= '<td>' . $completed_steps . '</td>';
				$student_report_html .= '<td>' . $completed_per . '%<div class="ld-dashboard-progress progress_bar_wrap" data-course="' . $course_id . '"><div class="ld-dashboard-progressbar ld-dashboard-animate ld-dashboard-stretch-right" data-percentage-value="' . $completed_per . '" style="background-color:#1d76da; width: ' . $completed_per . '%"></div></div></td>';
				$student_report_html .= '<td>' . $course_completed_on . '</td>';
				$student_report_html .= '</tr>';
			}
			$student_report_html .= '</tbody>';
		}
		$data          = $this->ld_dashboard_rearrange_course_progress_data( $user_data );
		$progress_data = ( isset( $data[ $course_id ] ) ) ? $data[ $course_id ] : array();
		$not_started   = isset( $progress_data['not_started'] ) ? $progress_data['not_started'] : 100;
		$progress      = isset( $progress_data['progress'] ) ? $progress_data['progress'] : 0;
		$complete      = isset( $progress_data['completed'] ) ? $progress_data['completed'] : 0;

		/* Start Page Container */
		$page_container = '';
		if ( $total_pages != 0 ) {
			$link = 'index.php?page=%d';

			$loader         = includes_url( 'images/spinner-2x.gif' );
			$page_container = '<div class="ld-dashboard-loader" style="display:none;">
		<img src="' . apply_filters( 'ld_dashboard_loader_img_url', $loader ) . '">
		<p>' . apply_filters( 'ld_dashboard_waiting_text', __( 'Please wait, while details are loading...', 'ld-dashboard' ) ) . '</p>
	</div>';

			$page_container .= '<div class="ld-course-details ld-dashboard-pagination">';
			if ( $page == 1 ) {
				$page_container .= '';
			} else {
				$page_container .= sprintf( '<a class="ld-pagination" href="#"  data-page="%d" data-course="%d"> ' . esc_html__( '&#171; prev', 'ld-dashboard' ) . '</a>', $page - 1, $course_id );
			}
			$page_container .= ' <span>' . esc_html__( 'page', 'ld-dashboard' ) . ' <strong>' . $page . '</strong> ' . esc_html__( 'from', 'ld-dashboard' ) . ' ' . $total_pages . '</span> ';
			if ( $page == $total_pages ) {
				$page_container .= '';
			} else {
				$page_container .= sprintf( '<a class="ld-pagination" href="#"  data-page="%d" data-course="%d">' . esc_html__( 'next &#187;', 'ld-dashboard' ) . '</a>', $page + 1, $course_id );
			}
			$page_container .= '</div>';
		}

		$ld_dashboard_page_mapping = get_option( 'ld_dashboard_page_mapping' );
		$my_dashboard_page         = Ld_Dashboard_Functions::instance()->ld_dashboard_get_url( 'dashboard' );
		$html                      = '';
		$html                     .= '
			<div class="ld-dashboard-course-chart">
				<div id="ld-dashboard-chart-data">
					<input id="ld-dashboard-not-started" value="' . $not_started . '" type="hidden">
					<input id="ld-dashboard-progress" value="' . $progress . '" type="hidden">
					<input id="ld-dashboard-complete" value="' . $complete . '" type="hidden">
				</div>
				<canvas id="ld-dashboard-instructor-highchart-student-progress" style="width: 100%; height: 400px;"></canvas>
			</div>
			<div class="ld-dashboard-overview-course-students">
				<h3>' . __( 'Student Information', 'ld-dashboard' ) . '</h3>
				<div class="ld-dashboard-overview-course-sort-by"><select name="sort_by" id="ld-dashboard-sort-by"><option value="">' . esc_html__( 'Sort By...', 'ld-dashboard' ) . '</option><option value="completed_date" ' . selected( 'completed_date', $sort_by, false ) . '>' . esc_html__( 'Completed Date', 'ld-dashboard' ) . '</option><option value="progress_percentage" ' . selected( 'progress_percentage', $sort_by, false ) . '>' . esc_html__( 'Progress %', 'ld-dashboard' ) . '</option></select></div>
				<table id="ld-dashboard-overview-course-students">
					<thead>
						<tr>
							<th>' . __( 'Name', 'ld-dashboard' ) . '</th>
							<th>' . __( 'Total Steps', 'ld-dashboard' ) . '</th>
							<th>' . __( 'Completed Steps', 'ld-dashboard' ) . '</th>
							<th>' . __( 'Progress %', 'ld-dashboard' ) . '</th>
							<th>' . __( 'Completed On', 'ld-dashboard' ) . '</th>
						</tr>
					</thead>
					' . $student_report_html . '
				</table>
				' . $page_container . '
				<span class="ld-dashboard-export"><a class="ld-dashboard-export-course ld-dashboard-btn" href="' . $my_dashboard_page . '?ld-export=course-progress&course-id=' . $course_id . '&export-format=csv" target="Blank">' . __( 'Export CSV', 'ld-dashboard' ) . '</a></span>
			</div>
		';
		$check_instrucor           = false;
		$course                    = get_post( $course_id );

		$_instructor_chart_display = false;

		$response = array(
			'html'                     => $html,
			'instructor_chart_display' => $_instructor_chart_display,
		);
		wp_send_json_success( $response );
		wp_die();
	}

	/**
	 * Get the student wise details report
	 */
	public function ld_dashboard_student_details() {
		global $current_user, $wpdb;

		$user_id = get_current_user_id();
		check_ajax_referer( 'ld-dashboard', 'nonce' );
		$function_obj = Ld_Dashboard_Functions::instance();
		$course_ids   = array();
		$student_id   = ( isset( $_POST['student_id'] ) ) ? sanitize_text_field( $_POST['student_id'] ) : 0;
		if ( learndash_is_group_leader_user() && ! in_array( 'ld_instructor', (array) $current_user->roles ) ) {
			$group_course_ids   = learndash_get_group_leader_groups_courses();
			$student_course_ids = learndash_user_get_enrolled_courses( $student_id );

			// Only display student courses assigned to the group.
			$course_ids = array_intersect( $group_course_ids, $student_course_ids );

		} elseif ( in_array( 'ld_instructor', (array) $current_user->roles ) ) {
			// $get_courses_sql = "select ID from {$wpdb->prefix}posts INNER JOIN {$wpdb->prefix}postmeta pm6 ON ( {$wpdb->prefix}posts.ID = pm6.post_id ) where ( post_author={$user_id} OR ( pm6.meta_key = '_ld_instructor_ids' AND pm6.meta_value REGEXP '.*;s:[0-9]+:\"{$user_id}\"*' ) ) AND post_type='sfwd-courses' AND {$wpdb->prefix}posts.post_status = 'publish' Group By {$wpdb->prefix}posts.ID";
			// $cousres    = $wpdb->get_results( $get_courses_sql );

			$course_ids = array();
			$courses    = self::get_instructor_courses_list();
			$course_ids = array();
			if ( ! empty( $courses ) ) {
				foreach ( $courses as $course ) {
					$course_ids[] = $course->ID;
				}
			}

			add_filter( 'posts_clauses', array( $this, 'ld_dashboard_remove_course_author_posts_clauses' ), 99 );
			$student_course_ids = learndash_user_get_enrolled_courses( $student_id );
			$course_ids         = array_intersect( $course_ids, $student_course_ids );

		} else {
			add_filter( 'posts_clauses', array( $this, 'ld_dashboard_remove_course_author_posts_clauses' ), 99 );
			$course_ids = learndash_user_get_enrolled_courses( $student_id );
		}
		$page        = ! empty( $_POST['page'] ) ? (int) $_POST['page'] : 1;
		$total       = count( $course_ids ); // total items in array.
		$limit       = apply_filters( 'ld_dashboard_student_course_details_per_page', 10 );
		$total_pages = ceil( $total / $limit ); // calculate total pages.
		$page        = max( $page, 1 ); // get 1 page when $_POST['page'] <= 0.
		$page        = min( $page, $total_pages ); // get last page when $_POST['page'] > $total_pages.
		$offset      = ( $page - 1 ) * $limit;
		if ( $offset < 0 ) {
			$offset = 0;
		}

		$course_ids = array_slice( $course_ids, $offset, $limit );

		$student_courses               = $course_ids;
		$total_courses                 = count( $student_courses );
		$completed_course              = 0;
		$in_progress_course            = 0;
		$not_started_course            = 0;
		$completed_assignment          = 0;
		$total_assignment              = 0;
		$approved_assignment           = 0;
		$unapproved_assignment         = 0;
		$pending_assignment_percentage = 0;
		$completed_quizze              = 0;
		$total_quizze                  = 0;
		$student_courses_html          = '';
		$ld_dashboard_page_mapping     = get_option( 'ld_dashboard_page_mapping' );
		$my_dashboard_page             = $function_obj->ld_dashboard_get_url( 'dashboard' );
		if ( ! empty( $student_courses ) ) :
			$student_courses_html = '
			<ul class="ld-dashboard-student-courses">';
			foreach ( $student_courses as $course_id ) :

				$course_progress_data = $this->ld_dashboard_check_course_progress_data( $student_id, $course_id );
				$course_progress      = ( isset( $course_progress_data['percentage'] ) ) ? $course_progress_data['percentage'] : 0;
				$total_steps          = ( isset( $course_progress_data['total_steps'] ) ) ? $course_progress_data['total_steps'] : 0;
				$completed_steps      = ( isset( $course_progress_data['completed_steps'] ) ) ? $course_progress_data['completed_steps'] : 0;

				/* Course Progress */
				if ( $course_progress_data['completed_steps'] == 0 ) {
					++$not_started_course;
				} elseif ( $course_progress_data['total_steps'] == $course_progress_data['completed_steps'] ) {
					++$completed_course;
				} else {
					++$in_progress_course;
				}

				/* Course Assignments */
				$total_assignment      += ( isset( $course_progress_data['total_course_assignment'] ) ) ? $course_progress_data['total_course_assignment'] : 0;
				$approved_assignment   += ( isset( $course_progress_data['total_approve_assignment'] ) ) ? $course_progress_data['total_approve_assignment'] : 0;
				$unapproved_assignment += $course_progress_data['total_assignment'] - $course_progress_data['total_approve_assignment'];

				/* Quize Progress */
				$total_quizze     += ( isset( $course_progress_data['total_quizze'] ) ) ? $course_progress_data['total_quizze'] : 0;
				$completed_quizze += ( isset( $course_progress_data['total_completed_quizze'] ) ) ? $course_progress_data['total_completed_quizze'] : 0;

				$student_courses_html .= '<li>
					<strong>
						<a href="' . get_the_permalink( $course_id ) . '">' . get_the_title( $course_id ) . '</a>&nbsp;
						<span class="ld-dashboard-progress-percentage">' . sprintf(
							__(
								'
                %1$s%% Complete',
								'ld-dashboard'
							),
							$course_progress
						) . '</span>
					<span class="ld-dashboard-progress-steps">' . sprintf(
							__(
								'
                %1$s/%2$s Steps',
								'ld-dashboard'
							),
							$completed_steps,
							$total_steps
						) . '</span>
					</strong>
					<div class="ld-dashboard-progress progress_bar_wrap" data-course="' . $course_id . '">
						<div class="ld-dashboard-progressbar ld-dashboard-animate ld-dashboard-stretch-right" data-percentage-value="' . esc_attr( $course_progress ) . '" style="background-color:#1d76da; width:0;"></div>
					</div>
				</li>';

			endforeach;
		endif;

		$completed_course_percentage   = ( $completed_course != 0 && $total_courses != 0 ) ? ( $completed_course / $total_courses ) * 100 : 0;
		$in_progress_course_percentage = ( $in_progress_course != 0 && $total_courses != 0 ) ? ( $in_progress_course / $total_courses ) * 100 : 0;
		$not_started_course_percentage = ( $not_started_course != 0 && $total_courses != 0 ) ? ( $not_started_course / $total_courses ) * 100 : 0;
		// echo $not_started_course . " == " . $total_courses;
		if ( $total_assignment != 0 ) {
			$approved_assignment_percentage   = ( $approved_assignment / $total_assignment ) * 100;
			$unapproved_assignment_percentage = ( $unapproved_assignment / $total_assignment ) * 100;
			$pending_assignment_percentage    = ( ( $total_assignment - $approved_assignment - $unapproved_assignment ) / $total_assignment ) * 100;
		} else {
			$approved_assignment_percentage   = 0;
			$unapproved_assignment_percentage = 0;
			$pending_assignment_percentage    = 100;
		}

		if ( $total_quizze != 0 ) {
			$completed_quizze_percentage   = ( $completed_quizze / $total_quizze ) * 100;
			$uncompleted_quizze_percentage = ( ( $total_quizze - $completed_quizze ) / $total_quizze ) * 100;
		} else {
			$completed_quizze_percentage   = 0;
			$uncompleted_quizze_percentage = 0;
		}
		/*
		 Pagination */
		/* Start Page Container */
		$page_container = '';
		if ( $total_pages != 0 ) {
			$link            = 'index.php?page=%d';
			$loader          = includes_url( 'images/spinner-2x.gif' );
			$page_container  = '<div class="ld-dashboard-student-loader" style="display:none;">
				<img src="' . apply_filters( 'ld_dashboard_loader_img_url', $loader ) . '">
				<p>' . apply_filters( 'ld_dashboard_waiting_text', __( 'Please wait, while details are loading...', 'ld-dashboard' ) ) . '</p>
			</div>';
			$page_container .= '<div class="ld-student-course-details ld-dashboard-pagination">';
			if ( $page == 1 ) {
				$page_container .= '';
			} else {
				$page_container .= sprintf( '<a class="ld-pagination" href="#"  data-page="%d" data-student="%d"> ' . esc_html__( '&#171; prev', 'ld-dashboard' ) . '</a>', $page - 1, $student_id );
			}
			$page_container .= ' <span>' . esc_html__( 'page', 'ld-dashboard' ) . ' <strong>' . $page . '</strong> ' . esc_html__( 'from', 'ld-dashboard' ) . ' ' . $total_pages . '</span> ';
			if ( $page == $total_pages ) {
				$page_container .= '';
			} else {
				$page_container .= sprintf( '<a class="ld-pagination" href="#"  data-page="%d" data-student="%d">' . esc_html__( 'next &#187;', 'ld-dashboard' ) . '</a>', $page + 1, $student_id );
			}
			$page_container .= '</div>';
		}

		$html     = '<div>
					<div id="ld-dashboard-chart-data">
						<input id="ld-dashboard-student-course-not-started" value="' . $not_started_course_percentage . '" type="hidden">
						<input id="ld-dashboard-student-course-progress" value="' . $in_progress_course_percentage . '" type="hidden">
						<input id="ld-dashboard-student-course-complete" value="' . $completed_course_percentage . '" type="hidden">

						<input id="ld-dashboard-student-approved-assignment" value="' . $approved_assignment_percentage . '" type="hidden">
						<input id="ld-dashboard-student-unapproved-assignment" value="' . $unapproved_assignment_percentage . '" type="hidden">
						<input id="ld-dashboard-student-pending-assignment" value="' . $pending_assignment_percentage . '" type="hidden">

						<input id="ld-dashboard-student-completed-quizze" value="' . $completed_quizze_percentage . '" type="hidden">
						<input id="ld-dashboard-student-uncompleted-quizze" value="' . $uncompleted_quizze_percentage . '" type="hidden">
					</div>
					<div class="ld-dashboard-student-course-wrapper">
						<canvas id="ld-dashboard-student-course-progress-highchart" style="margin-bottom: 20px;"></canvas>
						<canvas id="ld-dashboard-student-course-assignment-progress-highchart" style="margin-bottom: 20px;"></canvas>
						<canvas id="ld-dashboard-student-course-quizze-progress-highchart" style="margin-bottom: 20px;"></canvas>
					</div>
					' . $student_courses_html . '
					' . $page_container . '
					<span class="ld-dashboard-export"><a class="ld-dashboard-export-users ld-dashboard-btn" href="' . $my_dashboard_page . '?ld-export=student-progress&student-id=' . $student_id . '&export-format=csv" target="Blank">' . __( 'Export CSV', 'ld-dashboard' ) . '</a></span>
			</div>';
		$response = array(
			'html' => $html,
		);
		wp_send_json_success( $response );
		wp_die();
	}

	/*
	* Update instructor course order on stripe payment.
	*/
	public function ld_dashboard_update_instructor_course_purchase( $post_ID, $post, $update ) {
		if ( $update ) {
			return;
		}
		if ( $post && isset( $post->post_type ) && $post->post_type == 'sfwd-transactions' ) {
			ld_dashboard_update_on_stripe_payment( $post_ID, $post );
		}
	}

	public function ld_get_course_data() {
		$course_purchase_data = get_user_meta( '32', 'course_purchase_data', true );
	}


	public function ld_update_instructor_meta_wc_course_order( $order_id ) {
		global $wpdb;
		$order = wc_get_order( $order_id );
		if ( $order !== false ) {
			$products = $order->get_items();
			$coupon   = $order->get_coupon_codes();
			foreach ( $products as $product ) {
				if ( isset( $product['variation_id'] ) && ! empty( $product['variation_id'] ) ) {
					$courses_id = get_post_meta( $product['variation_id'], '_related_course', true );
				} else {
					$courses_id = get_post_meta( $product['product_id'], '_related_course', true );
				}

				if ( $courses_id && is_array( $courses_id ) ) {
					$ld_dashboard_manage_monetization = get_option( 'ld_dashboard_manage_monetization' );
					$fees_type                        = '';
					$fees_amount                      = 0;
					if ( $ld_dashboard_manage_monetization['enable-deduct-fees'] ) {
						$fees_type   = $ld_dashboard_manage_monetization['fee-type'];
						$fees_amount = $ld_dashboard_manage_monetization['fee-amount'];
					}
					foreach ( $courses_id as $cid ) {
						$course = get_post( $cid );
						if ( $course && isset( $course->post_author ) ) {
							$course_author = $course->post_author;

							$_sfwd_courses         = get_post_meta( $cid, '_sfwd-courses', true );
							$course_price          = ( $_sfwd_courses['sfwd-courses_course_price'] && $_sfwd_courses['sfwd-courses_course_price'] != '' ) ? $_sfwd_courses['sfwd-courses_course_price'] : $product['total'];
							$instructor_commission = $course_price;

							// Deduct processing fee.
							if ( 'fixed' === $fees_type ) {
								$instructor_commission -= $fees_amount;
							} elseif ( 'percent' === $fees_type ) {
								$instructor_commission = $instructor_commission - ( ( $fees_amount * $instructor_commission ) / 100 );
							}

							$check_instrucor    = ld_check_if_author_is_instructor( $course_author );
							$commission_enabled = ld_if_commission_enabled();

							$_commission = 0;
							if ( $check_instrucor ) {
								if ( $commission_enabled ) {
									$_commission = ld_if_instructor_course_commission_set( $course_author );
									if ( ! $_commission ) {
										$_commission = ld_get_global_commission_rate();
									}
								}

								/* Commission Calculation */
								if ( $_commission > 0 ) {
									$instructor_commission = ( $instructor_commission * $_commission ) / 100;
								}

								$ld_dashboard_instructor_commission_logs                    = array();
								$ld_dashboard_instructor_commission_logs['user_id']         = $course_author;
								$ld_dashboard_instructor_commission_logs['course_id']       = $cid;
								$ld_dashboard_instructor_commission_logs['course_price']    = $course_price;
								$ld_dashboard_instructor_commission_logs['commission']      = $instructor_commission;
								$ld_dashboard_instructor_commission_logs['commission_rate'] = $_commission;
								$ld_dashboard_instructor_commission_logs['commission_type'] = 'percentage';
								$ld_dashboard_instructor_commission_logs['fees_type']       = $fees_type;
								$ld_dashboard_instructor_commission_logs['fees_amount']     = $fees_amount;
								$ld_dashboard_instructor_commission_logs['source_type']     = 'WC';
								$ld_dashboard_instructor_commission_logs['reference']       = $order_id;
								$ld_dashboard_instructor_commission_logs['coupon']          = serialize( $coupon );
								$ld_dashboard_instructor_commission_logs['created']         = date( 'Y-m-d H:i:s' );

								$query = $wpdb->prepare( 'SELECT id FROM ' . $wpdb->prefix . 'ld_dashboard_instructor_commission_logs WHERE user_id = %d and course_id = %d and reference = %d', $course_author, $cid, $order_id );

								$commiossion_log_id = $wpdb->get_var( $query );

								if ( $commiossion_log_id == 0 || $commiossion_log_id == '' ) {
									$wpdb->insert( $wpdb->prefix . 'ld_dashboard_instructor_commission_logs', $ld_dashboard_instructor_commission_logs, array( '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ) );
								}
							}
						}
					}
				}
			}
		}
	}

	public function ld_update_instructor_meta_learndash_paypal_course_order( $transaction_post_id ) {
		global $wpdb;

		$transaction_exists = $transaction_post_id;

		$course_id = get_post_meta( $transaction_post_id, 'course_id', true );
		$user_id   = get_post_meta( $transaction_post_id, 'user_id', true );

		if ( ! $transaction_exists ) {
			return;
		}

		$course_pricing             = learndash_get_course_price( $course_id );
		$course_price               = (int) $course_pricing['price'];
		$instructor_commission      = (int) $course_price;
		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$monetization_setting       = $ld_dashboard_settings_data['monetization_settings'];
		$fees                       = 0;
		$fee_type                   = '';
		$fee_amount                 = 0;
		if ( isset( $monetization_setting['enable-deduct-fees'] ) && 1 == $monetization_setting['enable-deduct-fees'] ) {
			$fee_amount = isset( $monetization_setting['fee-amount'] ) ? $monetization_setting['fee-amount'] : 0;
			$fee_type   = isset( $monetization_setting['fee-type'] ) ? $monetization_setting['fee-type'] : '';
			if ( 'fixed' === $fee_type ) {
				$instructor_commission -= $fee_amount;
			} elseif ( 'percent' === $fee_type ) {
				$instructor_commission = $instructor_commission - ( ( $fee_amount * $instructor_commission ) / 100 );
			}
		}

		$course = get_post( $course_id );
		if ( $course && isset( $course->post_author ) ) {
			$course_author      = $course->post_author;
			$check_instrucor    = ld_check_if_author_is_instructor( $course_author );
			$commission_enabled = ld_if_commission_enabled();
			$_commission        = 0;

			if ( $check_instrucor ) {
				if ( $commission_enabled ) {
					$_commission = ld_if_instructor_course_commission_set( $course_author );
					if ( false === $_commission ) {
						$_commission = ld_get_global_commission_rate();
					}

					if ( $_commission > 0 ) {
						// cep - course earning percentage.
						$instructor_cep = $_commission;
						// ce - instructor course earning.
						$instructor_commission = ( $instructor_commission * $instructor_cep ) / 100;
					}

					$ld_dashboard_instructor_commission_logs                    = array();
					$ld_dashboard_instructor_commission_logs['user_id']         = $course_author;
					$ld_dashboard_instructor_commission_logs['course_id']       = $course_id;
					$ld_dashboard_instructor_commission_logs['course_price']    = $course_price;
					$ld_dashboard_instructor_commission_logs['commission']      = $instructor_commission;
					$ld_dashboard_instructor_commission_logs['commission_rate'] = $_commission;
					$ld_dashboard_instructor_commission_logs['commission_type'] = 'percentage';
					$ld_dashboard_instructor_commission_logs['fees_type']       = $fee_type;
					$ld_dashboard_instructor_commission_logs['fees_amount']     = $fee_amount;
					$ld_dashboard_instructor_commission_logs['source_type']     = 'learndash';
					$ld_dashboard_instructor_commission_logs['reference']       = $transaction_post_id;
					$ld_dashboard_instructor_commission_logs['coupon']          = '';
					$ld_dashboard_instructor_commission_logs['created']         = date( 'Y-m-d H:i:s' );

					$query = $wpdb->prepare( 'SELECT id FROM ' . $wpdb->prefix . 'ld_dashboard_instructor_commission_logs WHERE user_id = %d and course_id = %d and reference = %d', $course_author, $course_id, $transaction_post_id );

					$commiossion_log_id = $wpdb->get_var( $query );

					if ( $commiossion_log_id == 0 || $commiossion_log_id == '' ) {
						$wpdb->insert( $wpdb->prefix . 'ld_dashboard_instructor_commission_logs', $ld_dashboard_instructor_commission_logs, array( '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ) );
					}
				}
			}
		}
	}

	public function ld_remove_course_order_from_instructor_meta( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( $order !== false ) {
			$products = $order->get_items();

			foreach ( $products as $product ) {
				$courses_id = get_post_meta( $product['product_id'], '_related_course', true );
				if ( $courses_id && is_array( $courses_id ) ) {
					foreach ( $courses_id as $cid ) {
						$course = get_post( $cid );
						if ( $course && isset( $course->post_author ) ) {
							$course_author   = $course->post_author;
							$check_instrucor = ld_check_if_author_is_instructor( $course_author );
							if ( $check_instrucor ) {
								$course_purchase_data = get_user_meta( $course_author, 'course_purchase_data', true );
								if ( is_array( $course_purchase_data ) ) {
									if ( array_key_exists( $order_id, $course_purchase_data ) ) {
										unset( $course_purchase_data[ $order_id ] );
									}
								}
								update_user_meta( $course_author, 'course_purchase_data', $course_purchase_data );
							}
						}
					}
				}
			}
		}
	}

	/*
	* Post IDS pass empty array when student loggedin
	*
	*/
	public function ld_dashboard_get_activity_query_args( $query_args ) {
		if ( isset( $query_args['is_post_ids'] ) && $query_args['is_post_ids'] == true && isset( $query_args['post_ids'] ) && ! empty( $query_args['post_ids'] ) ) {
			$query_args['post_ids'] = array();
		}
		return $query_args;
	}

	/*
	* Display LD Email Integation section on Dashboard
	*/
	public function ld_dashboard_email_functions() {
		global $current_user;

		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$ld_dashboard               = $ld_dashboard_settings_data['general_settings'];
		$is_student                 = 0;
		if ( ! learndash_is_group_leader_user() && ! learndash_is_admin_user() && ! in_array( 'ld_instructor', (array) $current_user->roles ) ) {
			$is_student = 1;
		}
		ob_start();
		if ( $is_student != 1 && isset( $ld_dashboard['enable-email-integration'] ) && $ld_dashboard['enable-email-integration'] == 1 ) {
			if ( false !== $this->template_override_exists( 'ld-dashboard-email-integration.php' ) ) {
				include $this->template_override_exists( 'ld-dashboard-email-integration.php' );
			} else {
				include LD_DASHBOARD_PLUGIN_DIR . 'templates/ld-dashboard-email-integration.php';
			}
		}

		return ob_get_clean();
	}

	public function ld_dashboard_message_functions() {
		global $current_user;

		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$ld_dashboard               = $ld_dashboard_settings_data['general_settings'];
		$is_student                 = 0;
		if ( ! learndash_is_group_leader_user() && ! learndash_is_admin_user() && ! in_array( 'ld_instructor', (array) $current_user->roles ) ) {
			$is_student = 1;
		}
		ob_start();
		if ( $is_student != 1 && isset( $ld_dashboard['enable-messaging-integration'] ) && $ld_dashboard['enable-messaging-integration'] == 1 && is_plugin_active( 'buddypress/bp-loader.php' ) ) {
			if ( false !== $this->template_override_exists( 'ld-dashboard-message-integration.php' ) ) {
				include $this->template_override_exists( 'ld-dashboard-message-integration.php' );
			} else {
				include LD_DASHBOARD_PLUGIN_DIR . 'templates/ld-dashboard-message-integration.php';
			}
		}

		return ob_get_clean();
	}

	/*
	* return course wise studnets lists
	*
	*/
	public function ld_dashboard_couse_students() {
		check_ajax_referer( 'ld-dashboard', 'nonce' );
		$curr_user                  = wp_get_current_user();
		$is_group_leader            = false;
		$is_instructor_group_leader = false;
		$assigned_users             = array();
		if ( learndash_is_group_leader_user() && ! in_array( 'ld_instructor', $curr_user->roles ) ) {
			$is_group_leader = true;
			$assigned_users  = learndash_get_group_leader_groups_users();
		} elseif ( learndash_is_group_leader_user() && in_array( 'ld_instructor', $curr_user->roles ) ) {
			$is_instructor_group_leader = true;
			$assigned_users             = learndash_get_group_leader_groups_users();
		}
		$course_ids = ( isset( $_POST['course_id'] ) ) ? wp_unslash( $_POST['course_id'] ) : array();

		$user             = wp_get_current_user();
		$course_user_info = array();
		$uids             = array();
		if ( is_array( $course_ids ) && count( $course_ids ) > 0 ) {
			foreach ( $course_ids as $course_id ) {
				$course_pricing = learndash_get_course_price( $course_id );
				if ( 'open' !== $course_pricing['type'] ) {
					$course_user_ids  = learndash_get_course_users_access_from_meta( $course_id );
					$course_group_ids = learndash_get_course_groups( $course_id );
					if ( is_array( $course_group_ids ) && ! empty( $course_group_ids ) ) {
						foreach ( $course_group_ids as $grp_id ) {
							$group_users = learndash_get_groups_user_ids( $grp_id );
							if ( ! empty( $group_users ) ) {
								$course_user_ids = array_unique( array_merge( $course_user_ids, $group_users ) );
							}
						}
					}
					$students = $course_user_ids;
					if ( $is_instructor_group_leader && is_array( $assigned_users ) ) {
						$students = array_merge( $students, $assigned_users );
					}
					if ( is_array( $students ) && ! empty( $students ) ) {
						foreach ( $students as $std ) {
							if ( $is_group_leader && ! in_array( $std, $assigned_users ) ) {
								continue;
							}
							$uid = get_userdata( $std );
							if ( in_array( $uid->ID, $uids ) || $user->ID == $std ) {
								continue;
							}
							$uids[]             = $uid->ID;
							$course_user_info[] = array(
								'user_id'   => $uid->ID,
								'user_name' => $uid->display_name,
							);
						}
					}
				} else {
					$users = get_users();
					if ( ! empty( $users ) ) {
						foreach ( $users as $student ) {
							if ( $is_group_leader && ! in_array( $student->ID, $assigned_users ) ) {
								continue;
							}

							if ( in_array( $student->ID, $uids ) || $user->ID == $student->ID ) {
								continue;
							}
							$uids[]             = $student->ID;
							$course_user_info[] = array(
								'user_id'   => $student->ID,
								'user_name' => $student->data->display_name,
							);
						}
					}
				}
			}
		}

		wp_send_json_success( $course_user_info );
		wp_die();
	}

	public function ld_dashboard_group_id_course_student() {
		check_ajax_referer( 'ld-dashboard', 'nonce' );
		$group_id      = $_POST['group_id'];
		$group_courses = learndash_group_enrolled_courses( $group_id );
		if ( ( empty( $group_courses ) ) || ( ! is_array( $group_courses ) ) ) {
			$group_courses = array();
		}
		$course_info = array();
		if ( ! empty( $group_courses ) ) {
			foreach ( $group_courses as $course_id ) {
				$course_info[] = array(
					'course_id'   => $course_id,
					'course_name' => get_the_title( $course_id ),
				);
			}
		}

		$group_users = learndash_get_groups_user_ids( $group_id );
		if ( ( empty( $group_users ) ) || ( ! is_array( $group_users ) ) ) {
			$group_users = array();
		}
		$user_info = array();
		if ( ! empty( $group_users ) ) {
			foreach ( $group_users as $user_id ) {
				$user        = get_user_by( 'id', $user_id );
				$user_info[] = array(
					'user_id'   => $user_id,
					'user_name' => $user->display_name,
				);
			}
		}
		wp_send_json_success(
			array(
				'course_info' => $course_info,
				'user_info'   => $user_info,
			)
		);
		wp_die();
	}
	/*
	* Email Send base on selected course wise students & also selcted students
	*/
	public function ld_dashboard_email_send() {
		check_ajax_referer( 'ld-dashboard', 'nonce' );
		global $wpdb, $current_user;
		$user_id = get_current_user_id();

		/* Email Subject blank then return error message  */
		if ( isset( $_POST['ld-email-subject'] ) && $_POST['ld-email-subject'] == '' ) {
			$results = array(
				'error'   => 1,
				'message' => esc_html__( 'Please add email subject', 'ld-dashboard' ),
			);
			wp_send_json_success( $results );
			wp_die();
		}

		/* Email Body blank then return error message  */
		if ( isset( $_POST['ld-email-message'] ) && $_POST['ld-email-message'] == '' ) {
			$results = array(
				'error'   => 1,
				'message' => esc_html__( 'Please add email message', 'ld-dashboard' ),
			);
			wp_send_json_success( $results );
			wp_die();
		}

		$email_subject = $_POST['ld-email-subject'];
		$email_message = $_POST['ld-email-message'];

		if ( ! isset( $_POST['ld-email-students'] ) ) {
			/*
			 * Get Loggedin users lists
			 */
			if ( learndash_is_group_leader_user() ) {
				$group_student = learndash_get_group_leader_groups_users();

				$args = array(
					'orderby' => 'user_nicename',
					'order'   => 'ASC',
					'fields'  => array( 'ID', 'display_name' ),
					'include' => $group_student,
				);

			} elseif ( learndash_is_admin_user() ) {
				$args = array(
					'orderby' => 'user_nicename',
					'order'   => 'ASC',
					'fields'  => array( 'ID', 'display_name' ),
				);
			} else {
				$instructor_students = $this->ld_dashboard_get_instructor_students_by_id( $user_id );
				$course_student_ids  = array();
				if ( ! empty( $instructor_students ) ) {
					foreach ( $instructor_students as $key => $course_student ) {
						$course_student_ids[] = $course_student->ID;
					}
				}
				$args = array(
					'orderby' => 'user_nicename',
					'order'   => 'ASC',
					'fields'  => array( 'ID', 'display_name' ),
					'include' => $course_student_ids,
				);
			}
			$students = get_users( $args );
		}

		/* Course and students both selected then get the selected Students  */
		if ( isset( $_POST['ld-email-cource'] ) && isset( $_POST['ld-email-students'] ) ) {

			$course_ids  = $_POST['ld-email-cource'];
			$student_ids = $_POST['ld-email-students'];

		} elseif ( isset( $_POST['ld-email-cource'] ) && ! isset( $_POST['ld-email-students'] ) ) {
			/* Only Course selected all get the selected course enrolled students */

			$course_ids  = $_POST['ld-email-cource'];
			$student_ids = array();
			add_filter( 'posts_clauses', array( $this, 'ld_dashboard_remove_course_author_posts_clauses' ), 99 );
			foreach ( $students as $student ) {
				$courseids       = learndash_user_get_enrolled_courses( $student->ID );
				$match_courseids = array_intersect( $course_ids, $courseids );
				if ( ! empty( $match_courseids ) ) {
					$student_ids[] = $student->ID;
				}
			}
		} else {
			/* Course and Student not selected then get the loggedin users students and send message to all students */

			/*
			 * Get Loggedin User Course Lists
			 */
			if ( learndash_is_admin_user() ) {
				$args = array(
					'post_type'      => 'sfwd-courses',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
				);
			} elseif ( learndash_is_group_leader_user() ) {
				$group_course = learndash_get_group_leader_groups_courses();

				$args = array(
					'post_type'      => 'sfwd-courses',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'post__in'       => $group_course,
				);
			} else {
				$args = array(
					'post_type'      => 'sfwd-courses',
					'author'         => $user_id,
					'post_status'    => 'publish',
					'posts_per_page' => -1,
				);
			}

			$courses    = get_posts( $args );
			$course_ids = array();
			foreach ( $courses as $course ) {
				$course_ids[] = $course->ID;
			}

			$student_ids = array();
			add_filter( 'posts_clauses', array( $this, 'ld_dashboard_remove_course_author_posts_clauses' ), 99 );
			foreach ( $students as $student ) {
				$courseids       = learndash_user_get_enrolled_courses( $student->ID );
				$match_courseids = array_intersect( $course_ids, $courseids );
				if ( ! empty( $match_courseids ) ) {
					$student_ids[] = $student->ID;
				}
			}
		}

		/* Insert Email logs */
		$wpdb->insert(
			$wpdb->prefix . 'ld_dashboard_emails',
			array(
				'user_id'       => $user_id,
				'email_subject' => $email_subject,
				'email_message' => $email_message,
				'course_ids'    => wp_json_encode( $course_ids ),
				'student_ids'   => wp_json_encode( $student_ids ),
				'created'       => date( 'Y-m-d H:i:s' ),
			),
			array( '%d', '%s', '%s', '%s', '%s', '%s' )
		);

		$from_name = apply_filters( 'ld_dashboard_email_from_name', get_option( 'blogname' ) );
		$from_mail = apply_filters( 'ld_dashboard_email_from_email', get_option( 'admin_email' ) );

		$current_user_name  = $current_user->display_name;
		$current_user_email = $current_user->user_email;
		$headers[]          = 'MIME-Version: 1.0' . "\r\n";
		$headers[]          = 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers[]          = "X-Mailer: PHP \r\n";
		$headers[]          = 'From: ' . $from_name . ' < ' . $from_mail . '>' . "\r\n";
		$headers[]          = 'Reply-to: ' . $current_user_name . ' < ' . $current_user_email . '>' . "\r\n";
		$current_time       = time();
		foreach ( $student_ids as $student ) {
			$student_info   = get_userdata( $student );
			$to_email       = $student_info->user_email;
			$student_name   = $student_info->user_firstname . ' ' . $student_info->user_lastname;
			$student_name   = ( $student_info->user_firstname == '' && $student_info->user_lastname == '' ) ? $student_info->user_login : $student_name;
			$search_string  = array( '{student-name}' );
			$replace_string = array( $student_name );

			$emailmessage = str_replace( $search_string, $replace_string, wpautop( $email_message ) );

			$current_time += 10;
			wp_schedule_single_event( $current_time, 'ld_dashboard_send_email', array( $to_email, $email_subject, $emailmessage, $headers ) );
		}

		wp_send_json_success( array( 'email_sent' => esc_html__( 'Email Sent Successfully.', 'ld-dashboard' ) ) );
		wp_die();
	}

	/*
	* Send email on single event schedule
	*/
	public function ld_dashboard_send_single_email( $to_email, $email_subject, $email_message, $headers ) {
		wp_mail( $to_email, $email_subject, $email_message, $headers );
	}

	/*
	* Message Send base on selected students wise
	*/
	public function ld_dashboard_buddypress_message_send() {
		check_ajax_referer( 'ld-dashboard', 'nonce' );
		global $wpdb, $current_user;
		$user_id = get_current_user_id();
		/* Email Subject blank then return error message  */
		if ( ! isset( $_POST['ld-buddypress-message-students'] ) || ( isset( $_POST['ld-buddypress-message-students'] ) && $_POST['ld-buddypress-message-students'] == '' ) ) {
			$results = array(
				'error'   => 1,
				'message' => esc_html__( 'Please add at least one recipient.', 'ld-dashboard' ),
			);
			wp_send_json_success( $results );
			wp_die();
		}
		/* Email Subject blank then return error message  */
		if ( isset( $_POST['ld-buddypress-message-subject'] ) && $_POST['ld-buddypress-message-subject'] == '' ) {
			$results = array(
				'error'   => 1,
				'message' => esc_html__( 'Please add a subject to your message.', 'ld-dashboard' ),
			);
			wp_send_json_success( $results );
			wp_die();
		}

		/* Email Body blank then return error message  */
		if ( isset( $_POST['ld-buddypress-message-message'] ) && $_POST['ld-buddypress-message-message'] == '' ) {
			$results = array(
				'error'   => 1,
				'message' => esc_html__( 'Please add some content to your message.', 'ld-dashboard' ),
			);
			wp_send_json_success( $results );
			wp_die();
		}

		$recipients  = array();
		$student_ids = $_POST['ld-buddypress-message-students'];
		foreach ( $student_ids as $student ) {
			$student_info = get_userdata( $student );
			$recipients[] = $student_info->user_login;
		}

		$send = messages_new_message(
			array(
				'recipients' => $recipients,
				'subject'    => $_POST['ld-buddypress-message-subject'],
				'content'    => $_POST['ld-buddypress-message-message'],
				'error_type' => 'wp_error',
			)
		);

		// Send the message and redirect to it.
		if ( true === is_int( $send ) ) {
			$success  = true;
			$feedback = __( 'Message successfully sent.', 'ld-dashboard' );

			// Message could not be sent.
		} else {
			$success  = false;
			$feedback = $send->get_error_message();
		}
		wp_send_json_success(
			array(
				'success'      => $success,
				'message_sent' => $feedback,
			)
		);
		wp_die();
	}

	/*
	* get the student Course wise Progress report
	*/

	public function ld_dashboard_student_course_progress() {
		check_ajax_referer( 'ld-dashboard', 'nonce' );

		$course_id            = sanitize_text_field( $_POST['course_id'] );
		$user_id              = get_current_user_id();
		$course_progress_data = $this->ld_dashboard_check_course_progress_data( $user_id, $course_id );
		$course_name          = get_the_title( $course_id );
		$course_progress      = $course_progress_data['percentage'];
		$quizze_progress      = $course_progress_data['quizze_percentage'];
		$assignment_progress  = $course_progress_data['assignment_percentage'];

		$html     = '<input id="ld-dashboard-student-course" value="' . $course_name . '" type="hidden">
				<input id="ld-dashboard-student-course-progress" value="' . $course_progress . '" type="hidden">
				<input id="ld-dashboard-student-quizee-progress" value="' . $quizze_progress . '" type="hidden">
				<input id="ld-dashboard-student-assignment-progress" value="' . $assignment_progress . '" type="hidden">';
		$values   = array(
			'course_progress'     => round( $course_progress ),
			'quizze_progress'     => round( $quizze_progress ),
			'assignment_progress' => round( $assignment_progress ),
		);
		$response = array(
			'html'   => $html,
			'values' => $values,
			'title'  => $course_name,
		);
		wp_send_json_success( $response );
		wp_die();
	}

	/*
	* LD Instructor Registration Form to Register Instructor
	*
	*/
	public function ld_instructor_registration_functions( $atts, $content ) {
		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$ld_dashboard               = $ld_dashboard_settings_data['general_settings'];

		$user_id = get_current_user_id();
		ob_start();
		if ( false !== $this->template_override_exists( 'ld-instructor-registration.php' ) ) {
			include $this->template_override_exists( 'ld-instructor-registration.php' );
		} else {
			include LD_DASHBOARD_PLUGIN_DIR . 'templates/ld-instructor-registration.php';
		}

		return ob_get_clean();
	}

	public function ld_dashboard_add_new_announcement_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$form_data     = array();
		$form_raw_data = ( isset( $_POST['form_data'] ) ) ? wp_unslash( $_POST['form_data'] ) : array();
		foreach ( $form_raw_data as $value ) {
			$form_data[ $value['name'] ] = $value['value'];
		}

		$new_announcement = array(
			'post_title'   => $form_data['post_title'],
			'post_content' => $form_data['post_content'],
			'post_status'  => 'publish',
			'post_author'  => get_current_user_id(),
			'post_type'    => 'announcements',
		);

		$post_id = wp_insert_post( $new_announcement );
		update_post_meta( $post_id, 'course_id', $form_data['course'] );
		echo esc_html( $post_id );
		exit();
	}

	public function ld_dashboard_display_announcement_content_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$announcement_id = ( isset( $_POST['announcement'] ) ) ? wp_unslash( $_POST['announcement'] ) : 0;
		$response        = array(
			'content' => '',
			'status'  => 'error',
		);
		if ( $announcement_id > 0 ) {
			$announcement = get_post( $announcement_id );
			$content      = $announcement->post_content;
			$response     = array(
				'title'   => $announcement->post_title,
				'content' => $announcement->post_content,
				'status'  => 'success',
			);
		}
		wp_send_json_success( $response, 200 );
		exit();
	}

	public function ld_dashboard_set_as_instructor_pending_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$user_id = get_current_user_id();
		$user    = new WP_User( $user_id );
		$user->add_cap( 'ld_instructor_pending' );
		exit();
	}

	/*
	* Create LD Instructor Registration process as pending
	*
	*/
	public function ld_dashboard_register_instructor() {
		if ( ! isset( $_POST['ld_instructor_reg_action'] ) || $_POST['ld_instructor_reg_action'] !== 'ld_dashboard_instructor_registration' ) {
			return;
		}

		global $ld_instructor_error_msgs;
		$first_name = sanitize_text_field( $_POST['first_name'] );
		$last_name  = sanitize_text_field( $_POST['last_name'] );
		$email      = sanitize_text_field( $_POST['email'] );
		$user_login = sanitize_text_field( $_POST['user_login'] );
		$password   = sanitize_text_field( $_POST['password'] );

		$userdata = array(
			'user_login' => $user_login,
			'user_email' => $email,
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'role'       => 'ld_instructor_pending',
			'user_pass'  => $password,
		);

		$user_id = wp_insert_user( $userdata );
		if ( ! is_wp_error( $user_id ) ) {
			do_action( 'ld_dashboard_new_instructor_after', $user_id );

			$user = get_user_by( 'id', $user_id );
			if ( $user ) {
				wp_set_current_user( $user_id, $user->user_login );
				wp_set_auth_cookie( $user_id );
			}
		} else {
			$ld_instructor_error_msgs = $user_id->get_error_messages();
		}
	}

	public function ld_dashboard_user_activity_query_where( $sql_str_where, $query_args ) {
		$sql_str_where .= ' AND ( ld_user_activity.activity_completed != 0 OR  ld_user_activity.activity_completed IS NULL) ';
		return $sql_str_where;
	}

	public function ld_dashboard_auto_enroll_instructor_courses( $access, $post_id, $user_id ) {
		if ( ! is_user_logged_in() || ! $post_id ) {
			return $access;
		}

		global $current_user;

		if ( empty( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		// Check if instructor.

		if ( ! in_array( 'ld_instructor', (array) $current_user->roles ) ) {
			return $access;
		}

		$post          = get_post( $post_id );
		$ld_post_types = array( 'sfwd-courses', 'sfwd-lessons', 'sfwd-question', 'sfwd-quiz', 'sfwd-topic' );

		if ( ! in_array( $post->post_type, $ld_post_types ) ) {
			return $access;
		}

		// Check if shared course
		$course_id = $post_id;
		if ( 'sfwd-courses' != $post->post_type ) {
			$course_id = learndash_get_course_id( $post_id );
		}
		$_ld_instructor_ids = get_post_meta( $post_id, '_ld_instructor_ids', true );

		if ( ! empty( $shared_courses ) && in_array( $course_id, $_ld_instructor_ids ) ) {
			return true;
		}

		if ( $user_id == $post->post_author ) {
			return true;
		}

		return $access;
	}

	/*
	* Edd Points for ess single order.
	*
	* @since    3.1.0
	*/

	public function add_endpoint() {

		add_rewrite_endpoint( 'my-course', EP_PAGES );

	}

	public function query_vars( $vars ) {

		$this->query_vars = array(
			'my-course',
		);

		$this->query_vars = apply_filters( 'ld_dashboard_query_vars', $this->query_vars );

		foreach ( $this->query_vars as $var ) {
			$vars[] = $var;
		}

		return $vars;
	}

	public function ld_dashboard_apply_instructor() {
		if ( ! isset( $_POST['ld_dashboard_action'] ) || $_POST['ld_dashboard_action'] !== 'ld_apply_instructor' ) {
			return;
		}
		$user_id = get_current_user_id();

		if ( $user_id && ( isset( $_POST['ld_dashboard_action'] ) && $_POST['ld_dashboard_action'] == 'ld_apply_instructor' ) ) {
			$user = get_user_by( 'id', $user_id );
			$user->add_role( 'ld_instructor_pending' );
		} else {
			die( __( 'Permission denied', 'ld-dashboard' ) );
		}
	}

	public function ld_dashboard_group_course_student() {
		if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'ld_dashboard_group_course_student' && isset( $_REQUEST['group_id'] ) && $_REQUEST['group_id'] != 'all' ) {
			$course_ids = explode( ',', $_REQUEST['course_ids'] );

			$group_id = $_REQUEST['group_id'];
			// $group_user_meta_key = 'learndash_group_users_'. $group_id;
			// $group_users = get_post_meta( $group_id, $group_user_meta_key, true);
			$group_users = learndash_get_groups_user_ids( $group_id );
			$user_lists  = '';
			if ( ! empty( $group_users ) ) {

				add_filter( 'posts_clauses', array( $this, 'ld_dashboard_remove_course_author_posts_clauses' ), 99 );
				foreach ( $group_users as $student ) {
					$student_course_ids = learndash_user_get_enrolled_courses( $student );

					$courseids = array_intersect( $course_ids, $student_course_ids );
					if ( ! empty( $courseids ) ) {
						$student_info = get_userdata( $student );
						$user_lists  .= '<option value="' . $student . '">' . $student_info->display_name . '</option>';
					}
				}
			} else {
				$user_lists .= '<option value="">' . __( 'No users are enrolled', 'ld-dashboard' ) . '</option>';
			}
		} else {
			$curr_user_id        = get_current_user_id();
			$instructor_students = $this->ld_dashboard_get_instructor_students_by_id( $curr_user_id );
			$course_student_ids  = array( 0 );
			if ( ! empty( $instructor_students ) ) {
				$course_student_ids = array();
				foreach ( $instructor_students as $key => $course_student ) {
					$course_student_ids[] = $course_student->ID;
				}
			}
			$args     = array(
				'orderby' => 'user_nicename',
				'order'   => 'ASC',
				'fields'  => array( 'ID', 'display_name' ),
				'include' => $course_student_ids,
			);
			$students = get_users( $args );
			if ( ! empty( $students ) ) {
				add_filter( 'posts_clauses', array( $this, 'ld_dashboard_remove_course_author_posts_clauses' ), 99 );
				$user_lists = '';
				foreach ( $students as $student ) {
					$course_ids = learndash_user_get_enrolled_courses( $student->ID );
					if ( ! empty( $course_ids ) ) :
						$user_lists .= '<option value="' . esc_attr( $student->ID ) . '" >' . esc_html( $student->display_name ) . '</option>';

						endif;
				}
			}
		}
		echo $user_lists;
		exit;
	}

	public function ld_dashboard_remove_course_author_posts_clauses( $clauses ) {
		global $wpdb;
		if ( is_user_logged_in() ) {
			$user_id          = get_current_user_id();
			$clauses['where'] = str_replace( "AND {$wpdb->prefix}posts.post_author IN ({$user_id})", '', $clauses['where'] );
		}
		return $clauses;
	}

	public function ld_dashboard_course_details_functions( $atts, $content ) {

		global $current_user, $wpdb, $wp;
		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$ld_dashboard               = $ld_dashboard_settings_data['general_settings'];

		$user_id    = get_current_user_id();
		$is_student = get_user_meta( $user_id, 'is_student', true );

		if ( ! learndash_is_group_leader_user() && ! learndash_is_admin_user() && ! in_array( 'ld_instructor', (array) $current_user->roles ) ) {
			$is_student = 1;
		}

		ob_start();
		if ( ! is_user_logged_in() ) {
			?>

			<p><?php printf( esc_html__( 'Please try to login to website to access %s details. This page are disabled for logout members. ', 'ld-dashboard' ), esc_html( strtolower( LearnDash_Custom_Label::get_label( 'course' ) ) ) ); ?></p>
			<?php
			return ob_get_clean();
		}

		if ( $is_student != 1 ) {
			/* Course Progress Report */
			if ( false !== $this->template_override_exists( 'ld-dashboard-course-report.php' ) ) {
				include $this->template_override_exists( 'ld-dashboard-course-report.php' );
			} else {
				include LD_DASHBOARD_PLUGIN_DIR . 'templates/ld-dashboard-course-report.php';
			}
		} else {
			if ( false !== $this->template_override_exists( 'ld-dashboard-student-course-report.php' ) ) {
				include $this->template_override_exists( 'ld-dashboard-student-course-report.php' );
			} else {
				include LD_DASHBOARD_PLUGIN_DIR . 'templates/ld-dashboard-student-course-report.php';
			}
		}

		return ob_get_clean();
	}

	public function ld_dashboard_student_details_functions( $atts, $content ) {
		global $current_user, $wpdb, $wp;
		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$ld_dashboard               = $ld_dashboard_settings_data['general_settings'];

		$user_id    = get_current_user_id();
		$is_student = get_user_meta( $user_id, 'is_student', true );

		if ( ! learndash_is_group_leader_user() && ! learndash_is_admin_user() && ! in_array( 'ld_instructor', (array) $current_user->roles ) ) {
			$is_student = 1;
		}

		ob_start();
		if ( ! is_user_logged_in() ) {
			?>

			<p><?php esc_html_e( 'Please try to login to website to access student details. This page are disabled for logout members. ', 'ld-dashboard' ); ?></p>
			<?php
			return ob_get_clean();
		}

		if ( $is_student != 1 ) {
			/* Course Progress Report */
			if ( false !== $this->template_override_exists( 'ld-dashboard-student-status.php' ) ) {
				include $this->template_override_exists( 'ld-dashboard-student-status.php' );
			} else {
				include LD_DASHBOARD_PLUGIN_DIR . 'templates/ld-dashboard-student-status.php';
			}
		}

		return ob_get_clean();
	}

	public function ld_dashboard_assignment_permissions_redirect_url( $url ) {
		global $post;

		$user_id            = get_current_user_id();
		$course_id          = get_post_meta( $post->ID, 'course_id', true );
		$_ld_instructor_ids = get_post_meta( $course_id, '_ld_instructor_ids', true );
		$course_author_id   = get_post_field( 'post_author', $course_id );

		if ( is_user_logged_in() && absint( $user_id ) === absint( $course_author_id ) ) {
			return;
		}

		if ( is_user_logged_in() && in_array( $user_id, $_ld_instructor_ids ) ) {
			return;
		}

		return $url;
	}

	/**
	 * Allow instructor pending role to upload media.
	 */
	public function ld_dashboard_allow_instructor_pending_role() {
		$contributor = get_role( 'ld_instructor_pending' );
		if ( ! empty( $contributor ) ) {
			$contributor->add_cap( 'upload_files' );
		}
	}

	public function ld_dashboard_save_course_lesson() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			wp_die();
		}

		$new_title = sanitize_text_field( wp_unslash( $_POST['new_title'] ) );
		$course_id = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
		$post_type = sanitize_text_field( wp_unslash( $_POST['post_type'] ) );

		$edit_post     = array(
			'post_title'  => $new_title,
			'post_name'   => '',
			'post_type'   => $post_type,
			'post_status' => 'publish',
		);
		$new_lesson_id = wp_insert_post( $edit_post );

		$_sfwd_lessons                        = array();
		$_sfwd_lessons['sfwd-lessons_course'] = $course_id;

		update_post_meta( $new_lesson_id, '_wp_old_slug', 'lesson' );
		update_post_meta( $new_lesson_id, 'course_id', $course_id );
		update_post_meta( $new_lesson_id, '_sfwd-lessons', $_sfwd_lessons );

		$_ld_course_steps_count = get_post_meta( $course_id, '_ld_course_steps_count', true );
		update_post_meta( $course_id, '_ld_course_steps_count', $_ld_course_steps_count + 1 );

		$ld_course_steps = get_post_meta( $course_id, 'ld_course_steps', true );

		$ld_course_steps['steps']['h']['sfwd-lessons'][ $new_lesson_id ] = array(
			'sfwd-topic' => array(),
			'sfwd-quiz'  => array(),
		);
		$ld_course_steps['steps_count']                                  = $_ld_course_steps_count + 1;

		update_post_meta( $course_id, 'ld_course_steps', $ld_course_steps );

		$lesson_data                 = array();
		$lesson_data['lesson_id']    = $new_lesson_id;
		$lesson_data['lesson_title'] = $new_title;

		wp_send_json_success( $lesson_data );
		wp_die();
	}

	public function ld_dashboard_save_course_lesson_topic() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			wp_die();
		}

		$new_title = sanitize_text_field( wp_unslash( $_POST['new_title'] ) );
		$course_id = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
		$lesson_id = sanitize_text_field( wp_unslash( $_POST['lesson_id'] ) );
		$post_type = sanitize_text_field( wp_unslash( $_POST['post_type'] ) );

		$edit_post = array(
			'post_title'  => $new_title,
			'post_name'   => '',
			'post_type'   => $post_type,
			'post_status' => 'publish',
		);

		$new_topic_id = wp_insert_post( $edit_post );

		$_sfwd_topic                      = array();
		$_sfwd_topic['sfwd-topic_course'] = $course_id;

		update_post_meta( $new_topic_id, '_wp_old_slug', 'topic' );
		update_post_meta( $new_topic_id, 'course_id', $course_id );
		update_post_meta( $new_topic_id, '_sfwd-topic', $_sfwd_topic );

		$_ld_course_steps_count = get_post_meta( $course_id, '_ld_course_steps_count', true );
		update_post_meta( $course_id, '_ld_course_steps_count', $_ld_course_steps_count + 1 );

		$ld_course_steps = get_post_meta( $course_id, 'ld_course_steps', true );

		if ( ! isset( $ld_course_steps['steps']['h']['sfwd-lessons'][ $lesson_id ]['sfwd-topic'] ) ) {
			$ld_course_steps['steps']['h']['sfwd-lessons'][ $lesson_id ] = array( 'sfwd-topic' => array( $new_topic_id => array( 'sfwd-quiz' => array() ) ) );
		} else {
			$ld_course_steps['steps']['h']['sfwd-lessons'][ $lesson_id ]['sfwd-topic'][ $new_topic_id ] = array( 'sfwd-quiz' => array() );
		}

		$ld_course_steps['steps_count'] = $_ld_course_steps_count + 1;

		update_post_meta( $course_id, 'ld_course_steps', $ld_course_steps );

		$topic_data                = array();
		$topic_data['topic_id']    = $new_topic_id;
		$topic_data['topic_title'] = $new_title;

		wp_send_json_success( $topic_data );
		wp_die();
	}

	public function ld_dashboard_save_course_lesson_quiz() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			wp_die();
		}
		global $wpdb;
		$learndash_data_settings = get_option( 'learndash_data_settings' );
		$quiz_prefixes           = $learndash_data_settings['rename-wpproquiz-tables']['prefixes']['current'];
		$new_title               = sanitize_text_field( wp_unslash( $_POST['new_title'] ) );
		$course_id               = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
		$lesson_id               = sanitize_text_field( wp_unslash( $_POST['lesson_id'] ) );
		$post_type               = sanitize_text_field( wp_unslash( $_POST['post_type'] ) );

		$edit_post = array(
			'post_title'  => $new_title,
			'post_name'   => '',
			'post_type'   => $post_type,
			'post_status' => 'publish',
		);

		$new_quiz_id = wp_insert_post( $edit_post );

		$quiz_pro_id = get_post_meta( $new_quiz_id, 'quiz_pro_id', true );
		if ( $quiz_pro_id == '' ) {
			$result_text            = array();
			$result_text['text']    = array( '' );
			$result_text['prozent'] = array( 0 );
			$result_text['activ']   = array( 1 );

			$toplist_data = array(
				'toplistDataAddPermissions' => 1,
				'toplistDataSort'           => 1,
				'toplistDataAddMultiple'    => '',
				'toplistDataAddBlock'       => 0,
				'toplistDataShowLimit'      => 0,
				'toplistDataShowIn'         => 0,
				'toplistDataCaptcha'        => '',
				'toplistDataAddAutomatic'   => '',
			);
			$wpdb->insert(
				$wpdb->prefix . $quiz_prefixes . 'pro_quiz_master',
				array(
					'name'                            => $new_title,
					'text'                            => 'AAZZAAZZ',
					'result_text'                     => serialize( $result_text ),
					'result_grade_enabled'            => 1,
					'title_hidden'                    => 1,
					'btn_restart_quiz_hidden'         => 0,
					'btn_view_question_hidden'        => 0,
					'question_random'                 => 0,
					'answer_random'                   => 0,
					'time_limit'                      => 0,
					'statistics_on'                   => 1,
					'statistics_ip_lock'              => 0,
					'show_points'                     => 0,
					'quiz_run_once'                   => 0,
					'quiz_run_once_type'              => 0,
					'quiz_run_once_cookie'            => 0,
					'quiz_run_once_time'              => 0,
					'numbered_answer'                 => 0,
					'hide_answer_message_box'         => 0,
					'disabled_answer_mark'            => 0,
					'show_max_question'               => 0,
					'show_max_question_value'         => 0,
					'show_max_question_percent'       => 0,
					'toplist_activated'               => 0,
					'toplist_data'                    => serialize( $toplist_data ),
					'show_average_result'             => 0,
					'prerequisite'                    => 0,
					'quiz_modus'                      => 0,
					'show_review_question'            => 0,
					'quiz_summary_hide'               => 1,
					'skip_question_disabled'          => 1,
					'email_notification'              => 0,
					'user_email_notification'         => 0,
					'show_category_score'             => 0,
					'hide_result_correct_question'    => 0,
					'hide_result_quiz_time'           => 0,
					'hide_result_points'              => 0,
					'autostart'                       => 0,
					'forcing_question_solve'          => 0,
					'hide_question_position_overview' => 1,
					'hide_question_numbering'         => 1,
					'form_activated'                  => 0,
					'form_show_position'              => 0,
					'start_only_registered_user'      => 0,
					'questions_per_page'              => 0,
					'sort_categories'                 => 0,
					'show_category'                   => 0,
				)
			);
			$quiz_pro_id = $wpdb->insert_id;
		}

		$_sfwd_quiz                       = array();
		$_sfwd_quiz['sfwd-quiz_course']   = $course_id;
		$_sfwd_quiz['sfwd-quiz_lesson']   = $lesson_id;
		$_sfwd_quiz['sfwd-quiz_quiz_pro'] = $quiz_pro_id;

		update_post_meta( $new_quiz_id, '_wp_old_slug', 'quiz' );
		update_post_meta( $new_quiz_id, 'course_id', $course_id );
		update_post_meta( $new_quiz_id, '_sfwd-quiz', $_sfwd_quiz );
		update_post_meta( $new_quiz_id, 'quiz_pro_id', $quiz_pro_id );
		update_post_meta( $new_quiz_id, 'quiz_pro_id_' . $quiz_pro_id, $quiz_pro_id );
		update_post_meta( $new_quiz_id, 'quiz_pro_primary_' . $quiz_pro_id, $quiz_pro_id );

		$_ld_course_steps_count = get_post_meta( $course_id, '_ld_course_steps_count', true );
		update_post_meta( $course_id, '_ld_course_steps_count', $_ld_course_steps_count + 1 );

		$ld_course_steps = get_post_meta( $course_id, 'ld_course_steps', true );

		if ( ! isset( $ld_course_steps['steps']['h']['sfwd-lessons'][ $lesson_id ]['sfwd-quiz'] ) ) {
			$ld_course_steps['steps']['h']['sfwd-lessons'][ $lesson_id ] = array( 'sfwd-quiz' => array( $new_quiz_id => array() ) );
		} else {
			$ld_course_steps['steps']['h']['sfwd-lessons'][ $lesson_id ]['sfwd-quiz'][ $new_quiz_id ] = array();
		}
		$ld_course_steps['steps_count'] = $_ld_course_steps_count + 1;

		update_post_meta( $course_id, 'ld_course_steps', $ld_course_steps );

		$quiz_data               = array();
		$quiz_data['quiz_id']    = $new_quiz_id;
		$quiz_data['quiz_title'] = $new_title;

		wp_send_json_success( $quiz_data );
		wp_die();
	}

}
