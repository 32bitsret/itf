<?php
$dashboard_url = Ld_Dashboard_Functions::instance()->ld_dashboard_get_url( 'dashboard' );

if ( isset( $_POST['action'] ) && 'update-zoom-settings' === $_POST['action'] ) {
	if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'update-zoom-settings' ) ) {
		if ( isset( $_POST['zoom_api_key'] ) && '' != $_POST['zoom_api_key'] ) {
			update_user_meta( $current_user->ID, 'zoom_api_key', sanitize_text_field( wp_unslash( $_POST['zoom_api_key'] ) ) );
		} else {
			update_user_meta( $current_user->ID, 'zoom_api_key', '' );
		}
		if ( isset( $_POST['zoom_api_secret'] ) && '' != $_POST['zoom_api_secret'] ) {
			update_user_meta( $current_user->ID, 'zoom_api_secret', sanitize_text_field( wp_unslash( $_POST['zoom_api_secret'] ) ) );
		} else {
			update_user_meta( $current_user->ID, 'zoom_api_secret', '' );
		}
		if ( isset( $_POST['zoom_email'] ) && '' != $_POST['zoom_email'] ) {
			update_user_meta( $current_user->ID, 'zoom_email', sanitize_text_field( wp_unslash( $_POST['zoom_email'] ) ) );
		} else {
			update_user_meta( $current_user->ID, 'zoom_email', '' );
		}
		do_action( 'ld_dashboard_save_zoom_fields' );
	}
}
?>

<div class="ld-dashboard-content-inner">
<?php if ( ! is_user_logged_in() ) : ?>
<p class="warning ld-dashboard-warning">
	<?php esc_html_e( 'You must be logged in to edit your profile.', 'ld-dashboard' ); ?>
</p><!-- .warning -->
<?php else : ?>
	<?php do_action( 'ld_dashboard_before_zoom_setting_form' ); ?>
	<form method="post" class="ld-dashboard-profile-form " id="adduser" action="<?php echo esc_url( $dashboard_url ) . '?tab=settings&action=zoom'; ?>">
		<?php
		do_action( 'ld_dashboard_before_zoom_setting_fields' );

		$status_icon = '';
		if ( class_exists( 'Zoom_Api' ) && '' !== get_user_meta( $current_user->ID, 'zoom_api_key', true ) ) {
			$zoom_meeting = new Zoom_Api();
			$response     = $zoom_meeting->get_all_meetings( '?page_size=2&page_number=1' );
			if ( property_exists( $response, 'meetings' ) ) {
				$status_icon = '<span class="dashicons dashicons-yes-alt ld-dashboard-zoom-api-status zoom-api-active"></span>';
			} else {
				$status_icon = '<span class="dashicons dashicons-dismiss ld-dashboard-zoom-api-status zoom-api-inactive"></span>';
			}
		}

			$zoom_fields = array(
				'zoom_api_key'    => array(
					'title' => esc_html__( 'Zoom API key', 'ld-dashboard' ),
					'tag'   => 'input',
					'type'  => 'text',
					'name'  => 'zoom_api_key',
					'value' => get_user_meta( $current_user->ID, 'zoom_api_key', true ),
					'class' => 'form-url',
					'icon'  => ( '' !== $status_icon ) ? $status_icon : '',
				),
				'zoom_api_secret' => array(
					'title' => esc_html__( 'Zoom API Secret', 'ld-dashboard' ),
					'tag'   => 'input',
					'type'  => 'text',
					'name'  => 'zoom_api_secret',
					'value' => get_user_meta( $current_user->ID, 'zoom_api_secret', true ),
					'class' => 'form-url',
					'icon'  => ( '' !== $status_icon ) ? $status_icon : '',
				),
				'zoom_email'      => array(
					'title' => esc_html__( 'Zoom Email', 'ld-dashboard' ),
					'tag'   => 'input',
					'type'  => 'email',
					'name'  => 'zoom_email',
					'value' => get_user_meta( $current_user->ID, 'zoom_email', true ),
					'class' => 'form-url',
					'icon'  => ( '' !== $status_icon ) ? $status_icon : '',
				),
			);

			$zoom_fields = apply_filters( 'ld_dashboard_zoom_fields', $zoom_fields );
			?>
		<div class="ld-dashboard-profile-form-field-list">
			<?php
			do_action( 'ld_dashboard_before_zoom_setting_fields' );
			foreach ( $zoom_fields as $slug => $field ) {
				?>
				<div class="ld-dashboard-profile-form-field <?php echo esc_attr( $field['class'] ); ?>">
					<label for="first-name"><?php echo esc_html( $field['title'] ); ?> <?php echo ( isset( $field['icon'] ) && '' !== $field['icon'] ) ? wp_kses_post( $field['icon'] ) : ''; ?></label>
				<?php ld_dashboard_get_field_html( $field ); ?>
				</div>
				<?php
			}
			do_action( 'ld_dashboard_after_zoom_setting_fields' );
			?>
			<div class="ld-dashboard-profile-form-field field-full-width">
				<input name="updateuser" type="submit" id="updateuser" class="submit button ld-dashboard-btn-bg" value="<?php esc_html_e( 'Save', 'ld-dashboard' ); ?>" />
				<?php wp_nonce_field( 'update-zoom-settings' ); ?>
				<input name="action" type="hidden" id="action" value="update-zoom-settings" />
			</div>
		</div>
	</form>
	<?php do_action( 'ld_dashboard_after_zoom_setting_form' ); ?>
	<?php endif; ?>
</div>
