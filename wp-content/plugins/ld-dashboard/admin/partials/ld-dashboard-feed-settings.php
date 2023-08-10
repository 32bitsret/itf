<?php
/**
 * Provide a admin area view for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com/plugins
 * @since      1.0.0
 *
 * @package    Ld_Dashboard
 * @subpackage Ld_Dashboard/admin/partials
 */

global $wp_roles;
$function_obj                     = Ld_Dashboard_Functions::instance();
$ld_dashboard_settings_data       = $function_obj->ld_dashboard_settings_data();
$settings                         = $ld_dashboard_settings_data['ld_dashboard_feed_settings'];
$settings['disable-live-feed']    = ( isset( $settings['disable-live-feed'] ) ) ? $settings['disable-live-feed'] : '';
$learndash_settings_custom_labels = get_option( 'learndash_settings_custom_labels' );

$course_label = ( isset( $learndash_settings_custom_labels['course'] ) && $learndash_settings_custom_labels['course'] != '' ) ? $learndash_settings_custom_labels['course'] : 'Course';
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wbcom-tab-content">
	<div class="wrap ld-dashboard-settings">
		<div class="ld-dashboard-content container">
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php
				settings_fields( 'ld_dashboard_feed_settings' );
				do_settings_sections( 'ld_dashboard_feed_settings' );
				?>
				<div class="ld-dashboard-activity-settings ld-dashboard-wrapper-admin">
				<div class="form-table">
					<div class="ld-grid-view-wrapper">
						<div class="ld-dashboard-admin-title-section"><h3><?php esc_html_e( 'Student Activity', 'ld-dashboard' ); ?></h3></div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php echo sprintf( esc_html__( 'Disable live %s activity? ', 'ld-dashboard' ), $course_label ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" name="ld_dashboard_feed_settings[disable-live-feed]" value="1" <?php checked( $settings['disable-live-feed'], '1' ); ?> />
									<div class="ld-dashboard-setting round"></div>
								</label>
								<p class="ld-decription"><?php echo sprintf( esc_html__( 'Enable this option to hide live %s activity for all users.', 'ld-dashboard' ), $course_label ); ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="form-table">
					<div class="ld-grid-view-wrapper">
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php echo sprintf( esc_html__( 'Disable user role-wise live %s activity? ', 'ld-dashboard' ), $course_label ); ?></label>
							</div>
							<div class="ld-grid-content">
								<select id="wb_wss_seller_user_roles" name="ld_dashboard_feed_settings[disable_user_roles_live_feed][]" multiple>
									<?php
									$roles = $wp_roles->get_names();
									foreach ( $roles as $role => $role_name ) {
										if ( 'administrator' === $role ) {
											continue;
										}
										$selected = ( ! empty( $settings['disable_user_roles_live_feed'] ) && in_array( $role, $settings['disable_user_roles_live_feed'] ) ) ? 'selected' : '';
										?>
									<option value="<?php echo esc_attr( $role ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_html( $role_name ); ?></option>
									<?php } ?>
								</select>
								<p class="description"><?php echo sprintf( esc_html__( 'Select user roles to hide live %s activity for particular users role-wise.', 'ld-dashboard' ), $course_label ); ?></p>
							</div>
						</div>
					</div>
				</div>
				</div>
				<?php submit_button(); ?>
				<?php wp_nonce_field( 'ld-dashboard-settings-submit', 'ld-dashboard-settings-submit' ); ?>
			</form>
		</div>
	</div>
</div>
