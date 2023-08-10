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
$settings                   = $ld_dashboard_settings_data['general_settings'];
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wbcom-tab-content">
	<div class="wrap ld-dashboard-settings">
		<div class="ld-dashboard-content container">
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php
				settings_fields( 'ld_dashboard_general_settings' );
				do_settings_sections( 'ld_dashboard_general_settings' );
				?>
				<div class="ld-dashboard-wrapper-admin form-table ld-dashboard-setting-accordian-wrapper">
					<div class="ld-grid-view-wrapper">
						<div class="ld-dashboard-admin-title-section"><h3><?php esc_html_e( 'General Settings', 'ld-dashboard' ); ?></h3></div>
						<div class="ld-dashboard-general-setting-accordian-content">
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php esc_html_e( 'Welcome Screen Message', 'ld-dashboard' ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" name="ld_dashboard_general_settings[welcome-screen]" value="1" <?php checked( $settings['welcome-screen'], '1' ); ?> />
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to show the welcome screen on my dashboard page.', 'ld-dashboard' ); ?></span>
								</div>
							</div>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php esc_html_e( 'Statistics Tiles', 'ld-dashboard' ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" name="ld_dashboard_general_settings[statistics-tiles]" value="1" <?php checked( $settings['statistics-tiles'], '1' ); ?> />
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to show Statistics on dashboard page.', 'ld-dashboard' ); ?></span>
								</div>
							</div>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php printf( esc_html__( '%s Progress', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" name="ld_dashboard_general_settings[course-progress]" value="1" <?php checked( $settings['course-progress'], '1' ); ?> />
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php printf( esc_html__( 'Enable this option if you want to show %s progress.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></span>
								</div>
							</div>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php esc_html_e( 'Student Details', 'ld-dashboard' ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_general_settings[student-details]" value="1" <?php checked( $settings['student-details'], '1' ); ?> data-id="student-details"/>
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to show student details.', 'ld-dashboard' ); ?></span>
								</div>
							</div>
						
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php esc_html_e( 'Announcements', 'ld-dashboard' ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_general_settings[enable-announcements]" value="1" <?php checked( $settings['enable-announcements'], '1' ); ?> data-id="enable-announcements"/>
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to enable the announcement feature.', 'ld-dashboard' ); ?></span>
								</div>
							</div>

							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php printf( esc_html__( 'Most Popular %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" class="ld-dashboard-setting ld-dashboard-popular-course-checkbox" name="ld_dashboard_general_settings[popular-course-report]" value="1" <?php checked( $settings['popular-course-report'], '1' ); ?> data-id="popular-course-report"/>
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php printf( esc_html__( 'Enable this option if you want to display most popular %s report.', 'ld-dashboard' ), esc_html( strtolower( LearnDash_Custom_Label::get_label( 'course' ) ) ) ); ?></span>
								</div>
							</div>

							

							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php printf( esc_html__( '%s Completion chart', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_general_settings[course-completion-report]" value="1" <?php checked( $settings['course-completion-report'], '1' ); ?> data-id="course-completion-report"/>
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php printf( esc_html__( 'Enable this option if you want to display %s completion report.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></span>
								</div>
							</div>

							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php printf( esc_html__( 'Top %s Chart', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_general_settings[top-courses-report]" value="1" <?php checked( $settings['top-courses-report'], '1' ); ?> data-id="top-courses-report"/>
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php printf( esc_html__( 'Enable this option if you want to display the top %s report.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ); ?></span>
								</div>
							</div>

							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php esc_html_e( 'Email integration', 'ld-dashboard' ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" name="ld_dashboard_general_settings[enable-email-integration]" value="1" <?php checked( $settings['enable-email-integration'], '1' ); ?> />
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to enable email integration.', 'ld-dashboard' ); ?></span>
								</div>
							</div>

							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php esc_html_e( 'Zoom integration', 'ld-dashboard' ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" name="ld_dashboard_general_settings[enable-zoom]" value="1" <?php checked( $settings['enable-zoom'], '1' ); ?> />
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to enable zoom meetings.', 'ld-dashboard' ); ?></span>
								</div>
							</div>

							<?php if ( class_exists( 'BuddyPress' ) && bp_is_active( 'messages' ) ) { ?>
								<div class="ld-single-grid">
									<div class="ld-grid-label" scope="row">
										<label><?php esc_html_e( 'BuddyPress Messaging integration', 'ld-dashboard' ); ?></label>
									</div>
									<div class="ld-grid-content">
										<label class="ld-dashboard-setting-switch">
											<input type="checkbox" name="ld_dashboard_general_settings[enable-messaging-integration]" value="1" <?php checked( $settings['enable-messaging-integration'], '1' ); ?>/>
											<div class="ld-dashboard-setting round"></div>
										</label>
										<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to enable BuddyPress messaging integration.', 'ld-dashboard' ); ?></span>
									</div>
								</div>
							<?php } ?>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php printf( esc_html__( 'Allow instructors to publish %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" name="ld_dashboard_general_settings[enable-instructor-course-publish]" value="1" <?php checked( $settings['enable-instructor-course-publish'], '1' ); ?> />
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php printf( esc_html__( 'Enable this option if you want to allow instructors to publish %s.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ); ?></span>
								</div>
							</div>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php printf( esc_html__( 'Allow instructors to create %s tags', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" name="ld_dashboard_general_settings[enable-instructor-course-tags]" value="1" <?php checked( $settings['enable-instructor-course-tags'], '1' ); ?> />
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php printf( esc_html__( 'Enable this option if you want to allow instructors to create %s tags.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></span>
								</div>
							</div>
							<?php if ( ld_is_envt_ready_for_to_do() ) { ?>
								<div class="ld-single-grid">
									<div class="ld-grid-label" scope="row">
										<label><?php printf( esc_html__( 'Display %s To Do', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></label>
									</div>
									<div class="ld-grid-content">
										<label class="ld-dashboard-setting-switch">
											<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_general_settings[display-to-do]" value="1" <?php checked( $settings['display-to-do'], '1' ); ?> />
											<div class="ld-dashboard-setting round"></div>
										</label>
										<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to display To Do widget at dashboard page.', 'ld-dashboard' ); ?></span>
									</div>
								</div>
							<?php } ?>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php esc_html_e( 'Become Instructor Button', 'ld-dashboard' ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" name="ld_dashboard_general_settings[become-instructor-button]" value="1" <?php checked( $settings['become-instructor-button'], '1' ); ?> />
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php esc_html_e( 'Enable this option to display the button on the student dashboard.', 'ld-dashboard' ); ?></span>
								</div>
							</div>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php esc_html_e( 'Monetization', 'ld-dashboard' ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_general_settings[enable-revenue-sharing]" value="1" <?php ( isset( $settings['enable-revenue-sharing'] ) ) ? checked( $settings['enable-revenue-sharing'], '1' ) : ''; ?> data-id="enable-revenue-sharing"/>
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php printf( esc_html__( 'Allow revenue generated from selling %1$1s to be shared with %2$2s creators.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></span>
								</div>
							</div>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php esc_html_e( 'Instructor Earning Logs', 'ld-dashboard' ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_general_settings[enable-instructor-earning-logs]" value="1" <?php ( isset( $settings['enable-revenue-sharing'] ) ) ? checked( $settings['enable-instructor-earning-logs'], '1' ) : ''; ?> data-id="enable-revenue-sharing"/>
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php esc_html_e( 'Allow instructor earining logs on instructor dashboard.', 'ld-dashboard' ); ?></span>
								</div>
							</div>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php esc_html_e( 'Number of Students', 'ld-dashboard' ); ?></label>
								</div>
								<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch ld-dashboard-setting-input-field">
									<input type="number" class="ld-dashboard-setting" min="1" max="100" name="ld_dashboard_general_settings[student-per-page-count]" value="<?php echo ( isset( $settings['student-per-page-count'] ) ) ? esc_attr( $settings['student-per-page-count'] ) : '10'; ?>" data-id="student-per-page-count"/>
								</label>
									<span class="ld-decription"><?php esc_html_e( 'Set students per page in Student Information section on Instructor dashboard.', 'ld-dashboard' ); ?></span>
								</div>
							</div>
							<?php if ( class_exists( 'BuddyPress' ) ) : ?>
							<div class="ld-single-grid">
								<div class="ld-grid-label" scope="row">
									<label><?php esc_html_e( 'User Avatar', 'ld-dashboard' ); ?></label>
								</div>
								<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_general_settings[default-avatar]" value="1" <?php ( isset( $settings['default-avatar'] ) ) ? checked( $settings['default-avatar'], '1' ) : ''; ?> data-id="default-avatar"/>
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php esc_html_e( 'Set BuddyPress/BuddyBoss avatar as default.', 'ld-dashboard' ); ?></span>
								</div>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="ld-dashboard-wrapper-admin form-table ld-dashboard-popular-course-toggle" style="<?php echo ( isset( $settings['popular-course-report'] ) && 1 == $settings['popular-course-report'] ) ? '' : 'display:none'; ?>">
					<div class="ld-grid-view-wrapper Welcome-Message-Pannel">
						<div class="ld-dashboard-admin-title-section"><h3><?php printf( esc_html__( 'Popular %s Settings', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></h3></div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php printf( esc_html__( 'Popular %s Tag', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></label>
							</div>	
							<div class="ld-grid-content">
								<select name="ld_dashboard_general_settings[popular_course_tag]">
									<option value=""><?php echo esc_html__( ' Select Tag ', 'ld-dashboard' ); ?></option>
								<?php
								$terms = get_terms(
									array(
										'taxonomy'   => 'ld_course_tag',
										'hide_empty' => false,
									)
								);
								if ( count( $terms ) > 0 ) {
									foreach ( $terms as $term ) {
										?>
										<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php ( isset( $settings['popular_course_tag'] ) ) ? selected( $settings['popular_course_tag'], $term->term_id ) : ''; ?> ><?php echo esc_html( $term->name ); ?></option>
										<?php
									}
								}
								?>
								</select>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php printf( esc_html__( 'Enable Most Popular %s For', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ); ?></label>
							</div>
							<div class="ld-grid-content">
								<div class="ld-dashboard-mpo">
									<div class="ld-dashboard-mpo-item">
										<small for="most-popular-courses-students"><?php esc_html_e( 'Students', 'ld-dashboard' ); ?></small>
										<label class="ld-dashboard-setting-switch">
											<input type="checkbox" id="most-popular-courses-students" class="ld-dashboard-setting" name="ld_dashboard_general_settings[enable-popular-courses-student]" value="student" <?php ( isset( $settings['enable-popular-courses-student'] ) ) ? checked( $settings['enable-popular-courses-student'], 'student' ) : ''; ?> />
											<div class="ld-dashboard-setting round"></div>
										</label>
									</div>
									<div class="ld-dashboard-mpo-item">
										<small for="most-popular-courses-group-leader"><?php echo esc_html( LearnDash_Custom_Label::get_label( 'group_leader' ) ); ?></small>
										<label class="ld-dashboard-setting-switch">
											<input type="checkbox" id="most-popular-courses-group-leader" class="ld-dashboard-setting" name="ld_dashboard_general_settings[enable-popular-courses-group-leader]" value="group-leader" <?php ( isset( $settings['enable-popular-courses-group-leader'] ) ) ? checked( $settings['enable-popular-courses-group-leader'], 'group-leader' ) : ''; ?> />
											<div class="ld-dashboard-setting round"></div>
										</label>
									</div>
								</div>
								<span class="ld-decription"><?php printf( esc_html__( 'Manage who can view most popular %s by enabling.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ); ?></span>
							</div>
						</div>
					</div>
				</div>

				<?php if ( isset( $settings['welcome-screen'] ) && $settings['welcome-screen'] == 1 ) { ?>
				<div class="ld-dashboard-wrapper-admin form-table">
					<div class="ld-grid-view-wrapper Welcome-Message-Pannel">
						<div class="ld-dashboard-admin-title-section"><h3><?php esc_html_e( 'Welcome Screen Settings', 'ld-dashboard' ); ?></h3></div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Welcome Message', 'ld-dashboard' ); ?></label>
							</div>	
							<div class="ld-grid-content">
								<input type="text" name="ld_dashboard_general_settings[welcome-message]" value="<?php echo isset( $settings['welcome-message'] ) ? $settings['welcome-message'] : ''; ?>" placeholder="Welcome Back, Admin" />
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Welcome Screen Cover Image', 'ld-dashboard' ); ?></label>
							</div>

							<div class="ld-grid-content">
								<label class="ld-dashboard-welcomebar-image">
									<input type="button" data-slug="welcomebar_image" class="button-secondary ld_dashboard_upload_image" value="<?php esc_attr_e( 'Upload Welcome Cover Image', 'ld-dashboard' ); ?>" />
									<input type="hidden" id="welcomebar_image" name="ld_dashboard_general_settings[welcomebar_image]" value="<?php echo isset( $settings['welcomebar_image'] ) ? esc_url( $settings['welcomebar_image'] ) : ''; ?>" >
								</label>
								<p class="description"><?php esc_html_e( 'Change Image For Welcome cover Message.', 'ld-dashboard' ); ?></p>

								<div class="ld-dashboard-welcomebar-image ld-display-welcomebar_image" 
								<?php
								if ( empty( $settings['welcomebar_image'] ) ) :
									?>
									style="display:none;" <?php endif; ?> >
									<img class="welcomebar_image" src="
									<?php
									if ( ! empty( $settings['welcomebar_image'] ) ) :
										echo esc_url( $settings['welcomebar_image'] );
									endif;
									?>
									" height="150" width="150"/>
									<span class="ld-dashboard-image-close" data-slug="welcomebar_image">x</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>

				<div class="ld-dashboard-wrapper-admin form-table">
					<div class="ld-grid-view-wrapper Welcome-Message-Pannel">
						<div class="ld-dashboard-admin-title-section"><h3><?php printf( esc_html__( 'Single Instructor %s Grid', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></h3></div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Grid Columns', 'ld-dashboard' ); ?></label>
							</div>	
							<div class="ld-grid-content">
								<input type="number" name="ld_dashboard_general_settings[ld-course-grid-columns]" value="<?php echo isset( $settings['ld-course-grid-columns'] ) ? $settings['ld-course-grid-columns'] : '4'; ?>" />
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Progress Bar', 'ld-dashboard' ); ?></label>
							</div>	
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_general_settings[ld-course-grid-progress-bar]" value="1" <?php ( isset( $settings['ld-course-grid-progress-bar'] ) ) ? checked( $settings['ld-course-grid-progress-bar'], '1' ) : ''; ?> data-id="ld-course-grid-progress-bar"/>
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php printf( esc_html__( 'Enable %1$s progress bar in %2$s Grid.', 'ld-dashboard' ), esc_html( strtolower( LearnDash_Custom_Label::get_label( 'course' ) ) ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></span>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php printf( esc_html__( '%s Content', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></label>
							</div>	
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_general_settings[ld-course-grid-course-content]" value="1" <?php ( isset( $settings['ld-course-grid-course-content'] ) ) ? checked( $settings['ld-course-grid-course-content'], '1' ) : ''; ?> data-id="ld-course-grid-course-content"/>
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php printf( esc_html__( 'Enable %1$s content in %2$s Grid.', 'ld-dashboard' ), esc_html( strtolower( LearnDash_Custom_Label::get_label( 'course' ) ) ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="ld-dashboard-wrapper-admin form-table">
					<div class="ld-grid-view-wrapper ld-page-mapping-tab-content">
						<div class="ld-dashboard-admin-title-section"><h3><?php esc_html_e( 'Page Mapping Settings', 'ld-dashboard' ); ?></h3></div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'My Dashboard Page', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<?php
								$args = array(
									'name'             => 'ld_dashboard_general_settings[my_dashboard_page]',
									'id'               => 'my_dashboard_page',
									'sort_column'      => 'menu_order',
									'sort_order'       => 'ASC',
									'show_option_none' => ' ',
									'class'            => 'my_dashboard_page',
									'echo'             => false,
									'selected'         => absint( ( isset( $settings['my_dashboard_page'] ) ) ? $settings['my_dashboard_page'] : 0 ),
									'post_status'      => 'publish',
								);

								if ( isset( $value['args'] ) ) {
									$args = wp_parse_args( $value['args'], $args );
								}

								echo wp_dropdown_pages( $args ); // WPCS: XSS ok.
								?>

								<?php if ( isset( $settings['my_dashboard_page'] ) && $settings['my_dashboard_page'] != 0 ) : ?>
									<a href="<?php echo esc_url( get_permalink( $settings['my_dashboard_page'] ) ); ?>" class="button-secondary" target="_bp">
										<?php esc_html_e( 'View', 'ld-dashboard' ); ?>
										<span class="dashicons dashicons-external" aria-hidden="true"></span>
										<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'ld-dashboard' ); ?></span>
									</a>
								<?php endif; ?>
								<p class="description"><?php esc_html_e( 'It will set the page used for the LearnDash user dashboard. This page should contain the following shortcode. [ld_dashboard]', 'ld-dashboard' ); ?></p>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Instructor Registration Page', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<?php
								$args = array(
									'name'             => 'ld_dashboard_general_settings[instructor_registration_page]',
									'id'               => 'instructor_registration_page',
									'sort_column'      => 'menu_order',
									'sort_order'       => 'ASC',
									'show_option_none' => ' ',
									'class'            => 'instructor_registration_page',
									'echo'             => false,
									'selected'         => absint( ( isset( $settings['instructor_registration_page'] ) ) ? $settings['instructor_registration_page'] : 0 ),
									'post_status'      => 'publish',
								);

								if ( isset( $value['args'] ) ) {
									$args = wp_parse_args( $value['args'], $args );
								}

								echo wp_dropdown_pages( $args ); // WPCS: XSS ok.
								?>
								<?php if ( isset( $settings['instructor_registration_page'] ) && $settings['instructor_registration_page'] != 0 ) : ?>
									<a href="<?php echo esc_url( get_permalink( $settings['instructor_registration_page'] ) ); ?>" class="button-secondary" target="_bp">
										<?php esc_html_e( 'View', 'ld-dashboard' ); ?>
										<span class="dashicons dashicons-external" aria-hidden="true"></span>
										<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'ld-dashboard' ); ?></span>
									</a>
								<?php endif; ?>

								<p class="description"><?php esc_html_e( 'It will set the page used to register the Instructor user. This page should contain the following shortcode. [ld_instructor_registration]', 'ld-dashboard' ); ?></p>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Instructors Listing Page', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<?php
								$args = array(
									'name'             => 'ld_dashboard_general_settings[instructor_listing_page]',
									'id'               => 'instructor_listing_page',
									'sort_column'      => 'menu_order',
									'sort_order'       => 'ASC',
									'show_option_none' => ' ',
									'class'            => 'instructor_listing_page',
									'echo'             => false,
									'selected'         => absint( ( isset( $settings['instructor_listing_page'] ) ) ? $settings['instructor_listing_page'] : 0 ),
									'post_status'      => 'publish',
								);

								if ( isset( $value['args'] ) ) {
									$args = wp_parse_args( $value['args'], $args );
								}

								echo wp_dropdown_pages( $args ); // WPCS: XSS ok.
								?>
								<?php if ( isset( $settings['instructor_listing_page'] ) && $settings['instructor_listing_page'] != 0 ) : ?>
									<a href="<?php echo esc_url( get_permalink( $settings['instructor_listing_page'] ) ); ?>" class="button-secondary" target="_bp">
										<?php esc_html_e( 'View', 'ld-dashboard' ); ?>
										<span class="dashicons dashicons-external" aria-hidden="true"></span>
										<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'ld-dashboard' ); ?></span>
									</a>
								<?php endif; ?>

								<p class="description"><?php esc_html_e( 'It will set the page used to list all the Instructors. This page should contain the following shortcode. [ld_dashboard_instructors_list col="4"]', 'ld-dashboard' ); ?></p>
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
