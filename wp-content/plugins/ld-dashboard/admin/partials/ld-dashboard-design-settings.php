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

$function_obj               = Ld_Dashboard_Functions::instance();
$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
$settings                   = $ld_dashboard_settings_data['design_options'];
$default_settings           = $ld_dashboard_settings_data['default_design_options'];
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wbcom-tab-content">
	<div class="wrap ld-dashboard-settings">
		<div class="ld-dashboard-content container">
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php
				settings_fields( 'ld_dashboard_design_settings' );
				do_settings_sections( 'ld_dashboard_design_settings' );

				?>
				<div class="ld-dashboard-wrapper-admin form-table">
					<div class="ld-grid-view-wrapper">
						<div class="ld-dashboard-admin-title-section"><h3><?php esc_html_e( 'Preset Colors Options', 'ld-dashboard' ); ?></h3></div>
					</div>
					<div class="ld-dashboard-design-settings-section">
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php echo esc_html__( 'Preset Colors', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-dashboard-grid-full-size ld-grid-content">
								<div class="ld-dashboard-color-preset-grid">
									<label class="ld-dashboard-setting-switch">
										<input type="radio" class="ld-dashboard-setting ld-dashboard-menu-tab-checkbox" name="ld_dashboard_design_settings[preset]" value="default" <?php echo ( isset( $settings['preset'] ) ) ? checked( $settings['preset'], 'default' ) : ''; ?> <?php echo ( false === $settings ) ? 'checked' : ''; ?> data-id="preset" />
										<div class="ld-dashboard-preset-item">
											<div class="ld-dashboard-design-header">
												<span data-preset="primary" style="background-color: <?php echo esc_attr( $default_settings['color'] ); ?>;"></span>
												<span data-preset="hover" style="background-color: <?php echo esc_attr( $default_settings['hover_color'] ); ?>;"></span>
												<span data-preset="text" style="background-color: <?php echo esc_attr( $default_settings['text_color'] ); ?>;"></span>
												<span data-preset="gray" style="background-color: <?php echo esc_attr( $default_settings['background'] ); ?>;"></span>
											</div>
											<div class="ld-dashboard-design-footer">
												<div class="ld-dashboard-color-title"><?php echo esc_html__( 'Default', 'ld-dashboard' ); ?></div>
												<div class="ld-dashboard-check-icon"></div>
											</div>
										</div>
									</label>

									<label class="ld-dashboard-setting-switch">
										<input type="radio" class="ld-dashboard-setting ld-dashboard-menu-tab-checkbox" name="ld_dashboard_design_settings[preset]" value="custom" <?php echo ( isset( $settings['preset'] ) ) ? checked( $settings['preset'], 'custom' ) : ''; ?> data-id="preset" />
										<div class="ld-dashboard-preset-item">
											<div class="ld-dashboard-design-header custom-preset-designs">
												<span data-preset="primary" data-id="color" style="background-color: <?php echo esc_attr( $settings['color'] ); ?>;"></span>
												<span data-preset="hover" data-id="hover_color" style="background-color: <?php echo esc_attr( $settings['hover_color'] ); ?>;"></span>
												<span data-preset="text" data-id="text_color" style="background-color: <?php echo esc_attr( $settings['text_color'] ); ?>;"></span>
												<span data-preset="gray" data-id="background" style="background-color: <?php echo esc_attr( $settings['background'] ); ?>;"></span>
											</div>
											<div class="ld-dashboard-design-footer">
												<div class="ld-dashboard-color-title"><?php echo esc_html__( 'Custom', 'ld-dashboard' ); ?></div>
												<div class="ld-dashboard-check-icon"></div>
											</div>
										</div>
									</label>
								</div>
								<span class="ld-decription">
									<?php echo esc_html__( 'These colors will be used throughoit your website. Choose between these presets or create your own custom palette.', 'ld-dashboard' ); ?>
								</span>
							</div>
						</div>
						<div class="custom-preset-container"></div>
					<div>
				</div>
				<?php submit_button(); ?>
				<?php wp_nonce_field( 'ld-dashboard-settings-submit', 'ld-dashboard-settings-submit' ); ?>
			</form>
		</div>
	</div>
</div>


