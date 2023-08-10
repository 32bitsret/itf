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
$settings                   = $ld_dashboard_settings_data['menu_options'];
$sections                   = ld_dashboard_get_sidebar_tabs();

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wbcom-tab-content">
	<div class="wrap ld-dashboard-settings">
		<div class="ld-dashboard-content container">
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php
				settings_fields( 'ld_dashboard_menu_options' );
				do_settings_sections( 'ld_dashboard_menu_options' );
				$instructor_menu    = '<div class="ld-dashboard-menu-settings-role-section role-instructor">';
				$group_leader_menu  = '<div class="ld-dashboard-menu-settings-role-section role-group_leader">';
				$other_menu         = '<div class="ld-dashboard-menu-settings-role-section role-others">';
				$group_exclude_tabs = array( 'my-courses', 'my-lessons', 'my-topics', 'my-quizzes', 'my-questions', 'assignments', 'meetings', 'certificates', 'my-announcements' );
				foreach ( $sections as $section_key => $section ) :
					foreach ( $section as $menu_key => $menu ) :
						ob_start();
						?>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php echo esc_html( $menu['label'] ); ?></label>
							</div>
							<div class="grid-full-size ld-grid-content">
								<div class="lavel-ld-dashboard-title">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" class="ld-dashboard-setting ld-dashboard-menu-tab-checkbox" name="ld_dashboard_menu_options[instructor][<?php echo esc_attr( $section_key ); ?>][<?php echo esc_attr( $menu_key ); ?>]" value="1" data-id="<?php echo esc_attr( $menu_key ); ?>" />
										<div class="ld-dashboard-setting round"></div>
									</label>
									<input type="hidden" class="ld-dashboard-menu-tab-checkbox-hidden" name="ld_dashboard_menu_options[instructor][<?php echo esc_attr( $section_key ); ?>][<?php echo esc_attr( $menu_key ); ?>]" value="<?php echo isset( $settings['instructor'][ $section_key ][ $menu_key ] ) ? $settings['instructor'][ $section_key ][ $menu_key ] : '0'; ?>" />
									<span class="ld-decription">
										<?php printf( esc_html__( 'Enable this option if you want to show the `%s` tab in sidebar.', 'ld-dashboard' ), esc_html( $menu['label'] ) ); ?>
									</span>
								</div>
							</div>
						</div>
						<?php
						$instructor_menu .= ob_get_clean();
						if ( ! in_array( $menu_key, $group_exclude_tabs ) ) {
							ob_start();
							?>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php echo esc_html( $menu['label'] ); ?></label>
								</div>
								<div class="grid-full-size ld-grid-content">
									<div class="lavel-ld-dashboard-title">
										<label class="ld-dashboard-setting-switch">
											<input type="checkbox" class="ld-dashboard-setting ld-dashboard-menu-tab-checkbox" name="ld_dashboard_menu_options[group_leader][<?php echo esc_attr( $section_key ); ?>][<?php echo esc_attr( $menu_key ); ?>]" value="1" data-id="<?php echo esc_attr( $menu_key ); ?>" />
											<div class="ld-dashboard-setting round"></div>
										</label>
										<input type="hidden" class="ld-dashboard-menu-tab-checkbox-hidden" name="ld_dashboard_menu_options[group_leader][<?php echo esc_attr( $section_key ); ?>][<?php echo esc_attr( $menu_key ); ?>]" value="<?php echo isset( $settings['group_leader'][ $section_key ][ $menu_key ] ) ? $settings['group_leader'][ $section_key ][ $menu_key ] : '0'; ?>" />
										<span class="ld-decription">
											<?php printf( esc_html__( 'Enable this option if you want to show the `%s` tab in sidebar.', 'ld-dashboard' ), esc_html( $menu['label'] ) ); ?>
										</span>
									</div>
								</div>
							</div>
							<?php
							$group_leader_menu .= ob_get_clean();
						}
						if ( in_array( $section_key, array( 'all', 'both' ) ) ) {
							ob_start();
							?>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php echo esc_html( $menu['label'] ); ?></label>
								</div>
								<div class="grid-full-size ld-grid-content">
									<div class="lavel-ld-dashboard-title">
										<label class="ld-dashboard-setting-switch">
											<input type="checkbox" class="ld-dashboard-setting ld-dashboard-menu-tab-checkbox" name="ld_dashboard_menu_options[others][<?php echo esc_attr( $section_key ); ?>][<?php echo esc_attr( $menu_key ); ?>]" value="1" data-id="<?php echo esc_attr( $menu_key ); ?>" />
											<div class="ld-dashboard-setting round"></div>
										</label>
										<input type="hidden" class="ld-dashboard-menu-tab-checkbox-hidden" name="ld_dashboard_menu_options[others][<?php echo esc_attr( $section_key ); ?>][<?php echo esc_attr( $menu_key ); ?>]" value="<?php echo isset( $settings['others'][ $section_key ][ $menu_key ] ) ? $settings['others'][ $section_key ][ $menu_key ] : '0'; ?>" />
										<span class="ld-decription">
											<?php printf( esc_html__( 'Enable this option if you want to show the `%s` tab in sidebar.', 'ld-dashboard' ), esc_html( $menu['label'] ) ); ?>
										</span>
									</div>
								</div>
							</div>
							<?php
							$other_menu .= ob_get_clean();
						}
					endforeach;
				endforeach;
				$instructor_menu   .= '</div>';
				$group_leader_menu .= '</div>';
				$other_menu        .= '</div>';

				?>
				<div class="ld-dashboard-wrapper-admin form-table">
					<div class="ld-grid-view-wrapper">
						<div class="ld-dashboard-admin-title-section"><h3><?php esc_html_e( 'Dashboard Menu', 'ld-dashboard' ); ?></h3></div>
					</div>
					<div class="ld-dashboard-menu-setting-role-filter-wrapper">
						<select class="ld-dashboard-menu-setting-role-filter">
							<option value="instructor"><?php echo esc_html__( 'Instructor', 'ld-dashboard' ); ?></option>
							<option value="group_leader"><?php echo esc_html__( 'Group Leader', 'ld-dashboard' ); ?></option>
							<option value="others"><?php echo esc_html__( 'Others', 'ld-dashboard' ); ?></option>
						</select>
					</div>
					<?php
					echo $instructor_menu;
					echo $group_leader_menu;
					echo $other_menu;
					?>
				</div>
				<?php submit_button(); ?>
				<?php wp_nonce_field( 'ld-dashboard-settings-submit', 'ld-dashboard-settings-submit' ); ?>
			</form>
		</div>
	</div>
</div>


