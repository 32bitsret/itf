<?php

// Include Firebase Library and Dependencies.
require_once LD_DASHBOARD_PLUGIN_DIR . 'vendor/php-jwt/src/BeforeValidException.php';
require_once LD_DASHBOARD_PLUGIN_DIR . 'vendor/php-jwt/src/ExpiredException.php';
require_once LD_DASHBOARD_PLUGIN_DIR . 'vendor/php-jwt/src/SignatureInvalidException.php';
require_once LD_DASHBOARD_PLUGIN_DIR . 'vendor/php-jwt/src/JWT.php';

use \Firebase\JWT\JWT;


class Zoom_Api {

	/**
	 * Zoom_api_key.
	 *
	 * @var string
	 */
	private $zoom_api_key = '';

	/**
	 * Zoom_api_secret.
	 *
	 * @var string
	 */
	private $zoom_api_secret = '';

	/**
	 * Zoom_email.
	 *
	 * @var string
	 */
	private $zoom_email = '';

	/**
	 * Zoom_email.
	 *
	 * @var string
	 */
	private $using_admin_credentials = 'no';

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		$this->set_zoom_credentials();
		$this->hooks();
		$this->init_cron();
	}

	private function init_cron() {
		if ( ! wp_next_scheduled( 'ld_dashboard_fetch_zoom_recordings' ) ) {
			wp_schedule_event( time(), 'every_six_hours', 'ld_dashboard_fetch_zoom_recordings' );
		}
	}

	private function set_zoom_credentials() {
		$current_user          = wp_get_current_user();
		$this->zoom_api_key    = get_user_meta( $current_user->ID, 'zoom_api_key', true );
		$this->zoom_api_secret = get_user_meta( $current_user->ID, 'zoom_api_secret', true );
		$this->zoom_email      = get_user_meta( $current_user->ID, 'zoom_email', true );
		if ( '' === $this->zoom_api_key ) {
			$obj                        = Ld_Dashboard_Functions::instance();
			$ld_dashboard_settings_data = $obj->ld_dashboard_settings_data();
			$settings                   = $ld_dashboard_settings_data['zoom_meeting_settings'];
			if ( learndash_is_admin_user() || ( isset( $settings['use-admin-account'] ) && 1 == $settings['use-admin-account'] ) ) {
				$this->zoom_api_key            = isset( $settings['zoom-api-key'] ) ? $settings['zoom-api-key'] : '';
				$this->zoom_api_secret         = isset( $settings['zoom-api-secret'] ) ? $settings['zoom-api-secret'] : '';
				$this->zoom_email              = isset( $settings['zoom-email'] ) ? $settings['zoom-email'] : '';
				$this->using_admin_credentials = 'yes';
			}
		}
	}

	public function register_zoom_meeting_post_type() {
		if ( ! post_type_exists( 'zoom_meet' ) && ld_dashboard_check_if_zoom_credentials_exists() ) {
			$zoom_meet_labels = array(
				'name'               => _x( 'Zoom Meetings', 'Post Type General Name', 'ld-dashboard' ),
				'singular_name'      => _x( 'Zoom Meeting', 'Post Type Singular Name', 'ld-dashboard' ),
				'menu_name'          => __( 'Zoom Meetings', 'ld-dashboard' ),
				'parent_item_colon'  => __( 'Parent Meeting', 'ld-dashboard' ),
				'all_items'          => __( 'All Meetings', 'ld-dashboard' ),
				'view_item'          => __( 'View Meeting', 'ld-dashboard' ),
				'add_new_item'       => __( 'Add New Meeting', 'ld-dashboard' ),
				'add_new'            => __( 'Add New', 'ld-dashboard' ),
				'edit_item'          => __( 'Edit Meeting', 'ld-dashboard' ),
				'update_item'        => __( 'Update Meeting', 'ld-dashboard' ),
				'search_items'       => __( 'Search Meeting', 'ld-dashboard' ),
				'not_found'          => __( 'Not Found', 'ld-dashboard' ),
				'not_found_in_trash' => __( 'Not found in Trash', 'ld-dashboard' ),
			);

			$zoom_meet_args = array(
				'label'              => __( 'zoom_meet', 'ld-dashboard' ),
				'description'        => __( 'Zoom Meeting', 'ld-dashboard' ),
				'labels'             => $zoom_meet_labels,
				'supports'           => array( 'title', 'editor', 'excerpt', 'author', 'custom-fields' ),
				'taxonomies'         => array(),
				'hierarchical'       => false,
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_nav_menus'  => true,
				'show_in_admin_bar'  => true,
				'menu_position'      => 5,
				'menu_icon'          => 'dashicons-video-alt2',
				'publicly_queryable' => true,
				'capability_type'    => 'post',
				'show_in_rest'       => true,
			);
			register_post_type( 'zoom_meet', $zoom_meet_args );
		}
	}

	/**
	 * Zoom Integration Hooks
	 *
	 * @return void
	 */
	private function hooks() {
		add_action( 'save_post_zoom_meet', array( $this, 'update_zoom_meeting_data_on_save' ), 10, 2 );
		add_action( 'init', array( $this, 'register_zoom_meeting_post_type' ) );
		add_action( 'wp_ajax_ld_dashboard_create_meeting', array( $this, 'ld_dashboard_create_meeting_callback' ) );
		add_action( 'wp_ajax_ld_dashboard_load_meeting_form', array( $this, 'ld_dashboard_load_meeting_form_callback' ) );
		add_action( 'wp_ajax_ld_dashboard_get_meeting_recordings', array( $this, 'ld_dashboard_get_meeting_recordings_callback' ) );
		add_action( 'wp_ajax_ld_dashboard_delete_meeting', array( $this, 'ld_dashboard_delete_meeting_callback' ) );
		add_action( 'ld_dashboard_fetch_zoom_recordings', array( $this, 'ld_dashboard_fetch_zoom_recordings_callback' ) );
	}

	// Function to generate JWT.
	private function generateJWTKey() {
		$key    = $this->zoom_api_key;
		$secret = $this->zoom_api_secret;
		$token  = array(
			'iss' => $key,
			'exp' => time() + 3600, // 60 seconds as suggested
		);
		return JWT::encode( $token, $secret );
	}

	public function ld_dashboard_fetch_zoom_recordings_callback() {
		$meetings = get_posts(
			array(
				'post_type'   => 'zoom_meet',
				'post_status' => 'publish',
			)
		);
		if ( is_array( $meetings ) && ! empty( $meetings ) ) {
			foreach ( $meetings as $meeting ) {
				$author_id       = $meeting->post_author;
				$zoom_meeting_id = get_post_meta( $meeting->ID, 'zoom_meeting_id', true );
				$author_data     = get_user_by( 'id', $author_id );
				if ( in_array( 'administrator', $author_data->roles ) ) {
					$obj                        = Ld_Dashboard_Functions::instance();
					$ld_dashboard_settings_data = $obj->ld_dashboard_settings_data();
					$settings                   = $ld_dashboard_settings_data['zoom_meeting_settings'];
					$this->zoom_api_key         = isset( $settings['zoom-api-key'] ) ? $settings['zoom-api-key'] : '';
					$this->zoom_api_secret      = isset( $settings['zoom-api-secret'] ) ? $settings['zoom-api-secret'] : '';
					$this->zoom_email           = isset( $settings['zoom-email'] ) ? $settings['zoom-email'] : '';
				} elseif ( in_array( 'ld_instructor', $author_data->roles ) ) {
					$this->zoom_api_key    = get_user_meta( $author_data->ID, 'zoom_api_key', true );
					$this->zoom_api_secret = get_user_meta( $author_data->ID, 'zoom_api_secret', true );
					$this->zoom_email      = get_user_meta( $author_data->ID, 'zoom_email', true );
				}
				$recordings = $this->get_meeting_recordings( $zoom_meeting_id );
				if ( property_exists( $recordings, 'recording_files' ) ) {
					update_post_meta( $meeting->ID, 'ldd_meeting_has_recordings', 'yes' );
					update_post_meta( $meeting->ID, 'ldd_meeting_recordings', $recordings->recording_files );
				} else {
					update_post_meta( $meeting->ID, 'ldd_meeting_has_recordings', 'no' );
					update_post_meta( $meeting->ID, 'ldd_meeting_recordings', '' );
				}
			}
			$this->set_zoom_credentials();
		}
	}

	/**
	 * Update zoom meeting data on save.
	 *
	 * @param  mixed $post_id Meeting Id.
	 * @return void
	 */
	public function update_zoom_meeting_data_on_save( $post_id, $post ) {
		if ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			$meeting_id = get_post_meta( $post_id, 'zoom_meeting_id', true );

			if ( isset( $_POST['zoom_details'] ) ) {
				$meeting_data = wp_unslash( $_POST['zoom_details'] );
				update_post_meta( $post_id, 'zoom_details', $meeting_data );
				$data = array();
				if ( is_array( $meeting_data ) ) {
					foreach ( $meeting_data as $key => $value ) {
						if ( 'duration' === $key ) {
							$hr    = isset( $value['hr'] ) ? $value['hr'] * 60 : 0;
							$min   = isset( $value['min'] ) ? $value['min'] : 0;
							$value = ( (int) $value['hr'] * 60 ) + (int) $value['min'];
						}
						if ( 'settings' === $key ) {
							$value = array_map(
								function( $tmp ) {
									if ( is_int( $tmp ) && $tmp == 1 ) {
										$tmp = 'true';
									}
									return $tmp;
								},
								$value
							);
						}
						if ( 'participant_video' === $key && is_int( $value ) && 1 == $value ) {
							$value = true;
						}
						if ( 'mute_upon_entry' === $key && is_int( $value ) && 1 == $value ) {
							$value = true;
						}
						$data[ $key ] = $value;
					}
				}

				$data['topic']  = $post->post_title;
				$data['agenda'] = wp_strip_all_tags( $post->post_content );
				if ( '' !== $meeting_id ) {
					$data['meeting_id'] = $meeting_id;
					$response           = $this->update_meeting( $data );
				} else {
					$response = $this->create_meeting( $data );
				}
				if ( ! is_wp_error( $response ) ) {
					if ( is_object( $response ) ) {
						if ( property_exists( $response, 'id' ) ) {
							update_post_meta( $post->ID, 'zoom_meeting_id', $response->id );
							update_post_meta( $post->ID, 'zoom_meeting_response', $response );
							update_post_meta( $post->ID, 'using_admin_credentials', $this->using_admin_credentials );
						}
						if ( property_exists( $response, 'start_url' ) ) {
							update_post_meta( $post->ID, 'zoom_meeting_start_url', $response->start_url );
						}
						if ( property_exists( $response, 'join_url' ) ) {
							update_post_meta( $post->ID, 'zoom_meeting_join_url', $response->join_url );
						}
					}
				}
				do_action( 'ld_dashboard_after_save_meeting', $meeting_data );
			}
		}
	}

	public function ld_dashboard_create_meeting_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$data      = array();
		$form_data = wp_unslash( $_POST['formData'] );
		foreach ( $form_data as $key => $value ) {
			if ( '_wp_http_referer' === $key ) {
				continue;
			}
			$new_key          = str_replace( 'zoom_details[', '', $key );
			$data[ $new_key ] = $value;
		}
		$_POST['zoom_details'] = $data;
		unset( $_POST['formData'] );
		if ( isset( $data['post_id'] ) ) {
			$update_meeting = array(
				'ID'           => sanitize_text_field( wp_unslash( $data['post_id'] ) ),
				'post_title'   => $data['topic'],
				'post_content' => $data['agenda'],
			);

			// Insert the post into the database.
			wp_update_post( $update_meeting );
		} else {
			$new_meeting = array(
				'post_title'   => $data['topic'],
				'post_content' => $data['agenda'],
				'post_status'  => 'publish',
				'post_type'    => 'zoom_meet',
				'post_author'  => get_current_user_id(),
			);

			// Insert the post into the database.
			wp_insert_post( $new_meeting );
		}
		exit;
	}

	public function ld_dashboard_load_meeting_form_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$type    = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';
		$post_id = isset( $_POST['post_id'] ) ? sanitize_text_field( wp_unslash( $_POST['post_id'] ) ) : 0;
		if ( $post_id > 0 ) {
			$meeting_data = get_post_meta( $post_id, 'zoom_details', true );
		}
		ob_start();
		include LD_DASHBOARD_PLUGIN_DIR . 'zoom/ld-dashboard-meeting-form.php';
		$response = ob_get_clean();
		echo $response;
		exit;
	}

	public function ld_dashboard_delete_meeting_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$meeting_id = isset( $_POST['meeting'] ) ? sanitize_text_field( wp_unslash( $_POST['meeting'] ) ) : '';
		$post_id    = isset( $_POST['post_id'] ) ? sanitize_text_field( wp_unslash( $_POST['post_id'] ) ) : 0;
		if ( '' !== $meeting_id ) {

			wp_delete_post( $post_id );
			$data = array(
				'meeting_id' => $meeting_id,
			);
			$this->delete_meeting( $data );
		}
		exit();
	}

	public function ld_dashboard_get_meeting_recordings_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		}
		$meeting_id = isset( $_POST['meeting_id'] ) ? sanitize_text_field( wp_unslash( $_POST['meeting_id'] ) ) : '';
		if ( '' !== $meeting_id ) {
			$recordings = $this->get_meeting_recordings( $meeting_id );
			if ( property_exists( $recordings, 'recording_files' ) ) {
				ob_start();
				echo '<div class="ld-dashboard-meeting-recording-content">';
				foreach ( $recordings->recording_files as $file ) {
					?>
					<div class="ld-dashboard-meeting-recording-single">
						<span><?php echo esc_html( $file->file_extension ); ?></span>
						<a href="<?php echo esc_html( $file->play_url ); ?>" target="_blank"><span class="dashicons dashicons-controls-play"></span></a>
						<a href="<?php echo esc_html( $file->download_url ); ?>"><span class="dashicons dashicons-download"></span></a>
					</div>
					<?php
				}
				echo '</div>';
				$recordings_html = ob_get_clean();
				echo $recordings_html;
			}
		}
		exit();
	}

	/**
	 *  Function to create meeting.
	 *
	 * @param  mixed $data data.
	 */
	public function create_meeting( $data = array() ) {
		// Enter_Your_Email - Zoom Email.
		$request    = array(
			'url'    => 'https://api.zoom.us/v2/users/' . $this->zoom_email . '/meetings',
			'method' => 'POST',
		);
		$post_time  = $data['start_time'];
		$start_time = gmdate( 'Y-m-d\TH:i:s', strtotime( $post_time ) );

		$request_data = array();
		if ( ! empty( $data['alternative_host_ids'] ) ) {
			if ( count( $data['alternative_host_ids'] ) > 1 ) {
				$alternative_host_ids = implode( ',', $data['alternative_host_ids'] );
			} else {
				$alternative_host_ids = $data['alternative_host_ids'][0];
			}
		}

		$request_data['topic']      = $data['topic'];
		$request_data['agenda']     = ! empty( $data['agenda'] ) ? $data['agenda'] : '';
		$request_data['type']       = ! empty( $data['type'] ) ? $data['type'] : 2; // Scheduled.
		$request_data['start_time'] = $start_time;
		$request_data['timezone']   = $data['timezone'];
		$request_data['password']   = ! empty( $data['password'] ) ? $data['password'] : '';
		$request_data['duration']   = ! empty( $data['duration'] ) ? $data['duration'] : 60;

		$request_data['settings'] = array(
			'join_before_host'       => ! empty( $data['settings']['join_before_host'] ) ? true : false,
			'waiting_room'           => ! empty( $data['settings']['waiting_room'] ) ? false : true,
			'host_video'             => ! empty( $data['settings']['host_video'] ) ? true : false,
			'participant_video'      => ! empty( $data['participant_video'] ) ? true : false,
			'mute_upon_entry'        => ! empty( $data['mute_upon_entry'] ) ? true : false,
			'meeting_authentication' => ! empty( $data['settings']['meeting_authentication'] ) ? true : false,
			'auto_recording'         => ! empty( $data['settings']['auto_recording'] ) ? $data['settings']['auto_recording'] : 'none',
			'alternative_hosts'      => isset( $alternative_host_ids ) ? $alternative_host_ids : '',
		);

		return $this->sendRequest( $request_data, $request );
	}

	/**
	 *  Function to create meeting.
	 *
	 * @param  mixed $data data.
	 */
	public function update_meeting( $data = array() ) {
		$request    = array(
			'url'    => 'https://api.zoom.us/v2/meetings/' . $data['meeting_id'],
			'method' => 'PATCH',
		);
		$post_time  = $data['start_time'];
		$start_time = gmdate( 'Y-m-d\TH:i:s', strtotime( $post_time ) );

		$request_data = array();
		if ( ! empty( $data['alternative_host_ids'] ) ) {
			if ( count( $data['alternative_host_ids'] ) > 1 ) {
				$alternative_host_ids = implode( ',', $data['alternative_host_ids'] );
			} else {
				$alternative_host_ids = $data['alternative_host_ids'][0];
			}
		}

		$request_data['topic']      = $data['topic'];
		$request_data['agenda']     = ! empty( $data['agenda'] ) ? $data['agenda'] : '';
		$request_data['type']       = ! empty( $data['type'] ) ? $data['type'] : 2; // Scheduled.
		$request_data['start_time'] = $start_time;
		$request_data['timezone']   = $data['timezone'];
		$request_data['password']   = ! empty( $data['password'] ) ? $data['password'] : '';
		$request_data['duration']   = ! empty( $data['duration'] ) ? $data['duration'] : 60;

		$request_data['settings'] = array(
			'join_before_host'       => ! empty( $data['settings']['join_before_host'] ) ? true : false,
			'waiting_room'           => ! empty( $data['settings']['waiting_room'] ) ? false : true,
			'host_video'             => ! empty( $data['settings']['host_video'] ) ? true : false,
			'participant_video'      => ! empty( $data['participant_video'] ) ? true : false,
			'mute_upon_entry'        => ! empty( $data['mute_upon_entry'] ) ? true : false,
			'meeting_authentication' => ! empty( $data['settings']['meeting_authentication'] ) ? true : false,
			'auto_recording'         => ! empty( $data['settings']['auto_recording'] ) ? $data['settings']['auto_recording'] : 'none',
			'alternative_hosts'      => isset( $alternative_host_ids ) ? $alternative_host_ids : '',
		);
		return $this->sendRequest( $request_data, $request );
	}

	/**
	 *  Function to delete meeting.
	 *
	 * @param  mixed $data data.
	 */
	public function delete_meeting( $data = array() ) {
		$request = array(
			'url'    => 'https://api.zoom.us/v2/meetings/' . $data['meeting_id'],
			'method' => 'DELETE',
		);
		return $this->sendRequest( array(), $request );
	}

	public function get_all_users( $data = '' ) {
		$request = array(
			'url'    => 'https://api.zoom.us/v2/users',
			'method' => 'GET',
		);
		return $this->sendRequest( $data, $request );
	}

	public function create_user( $user_id ) {
		$user    = get_user_by( 'id', $user_id );
		$data    = array(
			'action'    => 'custCreate',
			'user_info' => array(
				'email'      => $user->data->user_email,
				'first_name' => get_user_meta( $user->ID, 'first_name', true ),
				'last_name'  => get_user_meta( $user->ID, 'last_name', true ),
				'type'       => 1,
			),
		);
		$request = array(
			'url'    => 'https://api.zoom.us/v2/users',
			'method' => 'POST',
		);
		return $this->sendRequest( $data, $request );
	}

	public function delete_user( $user_id ) {
		$user    = get_user_by( 'id', $user_id );
		$request = array(
			'url'    => 'https://api.zoom.us/v2/users/' . $user->data->user_email . '?action=delete',
			'method' => 'DELETE',
		);
		return $this->sendRequest( '', $request );
	}

	public function get_all_meetings( $data = '' ) {
		$request = array(
			'url'    => 'https://api.zoom.us/v2/users/' . $this->zoom_email . '/meetings' . $data,
			'method' => 'GET',
		);
		return $this->sendRequest( $data, $request );
	}

	public function get_meeting( $data ) {
		$request = array(
			'url'    => 'https://api.zoom.us/v2/meetings/' . $data,
			'method' => 'GET',
		);
		return $this->sendRequest( $data, $request );
	}

	public function get_meeting_recordings( $meeting_id ) {
		$request_data = array();
		$request      = array(
			'url'    => 'https://api.zoom.us/v2/meetings/' . $meeting_id . '/recordings',
			'method' => 'GET',
		);
		return $this->sendRequest( $request_data, $request );
	}

	// Function to send request.
	protected function sendRequest( $data, $request ) {

		$headers = array(
			'authorization: Bearer ' . $this->generateJWTKey(),
			'content-type: application/json',
			'Accept: application/json',
		);

		$post_fields = wp_json_encode( $data );

		$ch = curl_init();
		curl_setopt_array(
			$ch,
			array(
				CURLOPT_URL            => $request['url'],
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING       => '',
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_TIMEOUT        => 30,
				CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST  => $request['method'],
				CURLOPT_POSTFIELDS     => $post_fields,
				CURLOPT_HTTPHEADER     => $headers,
			)
		);

		$response = curl_exec( $ch );
		$err      = curl_error( $ch );
		curl_close( $ch );
		if ( ! $response ) {
			return $err;
		}

		return json_decode( $response );
	}
}
