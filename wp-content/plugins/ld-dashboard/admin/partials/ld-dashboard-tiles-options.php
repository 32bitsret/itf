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
$settings                   = $ld_dashboard_settings_data['tiles_options'];

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wbcom-tab-content">
	<div class="wrap ld-dashboard-settings">
		<div class="ld-dashboard-content container">
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php
				settings_fields( 'ld_dashboard_tiles_options' );
				do_settings_sections( 'ld_dashboard_tiles_options' );
				?>
				<div class="ld-dashboard-wrapper-admin form-table">
					<div class="ld-grid-view-wrapper">
						<div class="ld-dashboard-admin-title-section"><h3><?php esc_html_e( 'Dashboard Tiles', 'ld-dashboard' ); ?></h3></div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php printf( esc_html__( '%1s Count', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></label>
							</div>
							<div class="grid-full-size ld-grid-content">
							<div class="lavel-ld-dashboard-title">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[course-count]" value="1" <?php isset( $settings['course-count'] ) ? checked( $settings['course-count'], '1' ) : ''; ?>  data-id="course-count" />
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription">
									<?php printf( esc_html__( 'Enable this option if you want to show the total %s count.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?>
								</span>
							</div>
								<div id="course-count-bgcolor" class="ld-dashboard-colorpicker">
									<input type="text"  name="ld_dashboard_tiles_options[course-count-bgcolor]" class="ld-dashboard-color" value="<?php echo isset( $settings['course-count-bgcolor'] ) ? esc_attr( $settings['course-count-bgcolor'] ) : ''; ?>" />
									<label class="ld-decription"><?php printf( esc_html__( '%s Count Block Background Color', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></label>
								</div>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php printf( esc_html__( '%s Count', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'quizzes' ) ) ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[quizzes-count]" value="1" <?php isset( $settings['quizzes-count'] ) ? checked( $settings['quizzes-count'], '1' ) : ''; ?> data-id="quizzes-count"/>
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php printf( esc_html__( 'Enable this option if you want to show the total %s count.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'quizzes' ) ) ); ?></span>
								<div id="quizzes-count-bgcolor"class="ld-dashboard-colorpicker">
									<input type="text"  name="ld_dashboard_tiles_options[quizzes-count-bgcolor]" class="ld-dashboard-color" value="<?php echo isset( $settings['quizzes-count-bgcolor'] ) ? esc_attr( $settings['quizzes-count-bgcolor'] ) : ''; ?>" />
									<label class="ld-decription">
										<?php printf( esc_html__( '%s Count Block Background Color', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'quizzes' ) ) ); ?>
									</label>
								</div>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Assignments Count', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[assignments-count]" value="1" <?php isset( $settings['assignments-count'] ) ? checked( $settings['assignments-count'], '1' ) : ''; ?> data-id="assignments-count" />
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to show Assignments statistics.', 'ld-dashboard' ); ?></span>
							</div>
						</div>

						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Completed Assignments count', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
									<label class="ld-dashboard-setting-switch">
										<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[assignments-completed-count]" value="1" <?php isset( $settings['assignments-completed-count'] ) ? checked( $settings['assignments-completed-count'], '1' ) : ''; ?> />
										<div class="ld-dashboard-setting round"></div>
									</label>
									<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to show the total Completed Assignments count. Otherwise, display total pending Assignments count.', 'ld-dashboard' ); ?></span>
									<div id="assignments-count-bgcolor" class="ld-dashboard-colorpicker ld-assignments-count">
										<input type="text" name="ld_dashboard_tiles_options[assignments-count-bgcolor]" class="ld-dashboard-color" value="<?php echo isset( $settings['assignments-count-bgcolor'] ) ? esc_attr( $settings['assignments-count-bgcolor'] ) : ''; ?>" />
										<label class="ld-decription"><?php esc_html_e( 'Completed Assignments Count Block Background Color', 'ld-dashboard' ); ?></label>
									</div>
							</div>
						</div>

						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Essays Count', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[essays-pending-count]" value="1" <?php isset( $settings['essays-pending-count'] ) ? checked( $settings['essays-pending-count'], '1' ) : ''; ?> data-id="essays-pending-count" />
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to show the total pending Essays count.', 'ld-dashboard' ); ?></span>
								<div id="essays-pending-count-bgcolor"class="ld-dashboard-colorpicker">
									<input type="text" name="ld_dashboard_tiles_options[essays-pending-count-bgcolor]" class="ld-dashboard-color" value="<?php echo isset( $settings['essays-pending-count-bgcolor'] ) ? esc_attr( $settings['essays-pending-count-bgcolor'] ) : ''; ?>" />
									<label class="ld-decription"><?php esc_html_e( 'Essays Count Block Background Color', 'ld-dashboard' ); ?></label>
								</div>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label class="ld-decription"><?php printf( esc_html__( '%s Count', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'lessons' ) ) ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[lessons-count]" value="1" <?php isset( $settings['lessons-count'] ) ? checked( $settings['lessons-count'], '1' ) : ''; ?> data-id="lessons-count"/>
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php printf( esc_html__( 'Enable this option if you want to show the total %s count.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'lessons' ) ) ); ?></span>
								<div id="lessons-count-bgcolor" class="ld-dashboard-colorpicker">
									<input type="text" name="ld_dashboard_tiles_options[lessons-count-bgcolor]" class="ld-dashboard-color" value="<?php echo isset( $settings['lessons-count-bgcolor'] ) ? esc_attr( $settings['lessons-count-bgcolor'] ) : ''; ?>" />
									<label class="ld-decription"><?php printf( esc_html__( '%s Count Block Background Color', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'lessons' ) ) ); ?></label>
								</div>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php printf( esc_html__( '%s Count', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'topics' ) ) ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[topics-count]" value="1" <?php isset( $settings['topics-count'] ) ? checked( $settings['topics-count'], '1' ) : ''; ?> data-id="topics-count"/>
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php printf( esc_html__( 'Enable this option if you want to show the total %s count.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'topics' ) ) ); ?></span>
								<div id="topics-count-bgcolor" class="ld-dashboard-colorpicker">
									<input type="text" name="ld_dashboard_tiles_options[topics-count-bgcolor]" class="ld-dashboard-color" value="<?php echo isset( $settings['topics-count-bgcolor'] ) ? esc_attr( $settings['topics-count-bgcolor'] ) : ''; ?>" />
									<label class="ld-decription"><?php printf( esc_html__( '%s Count Block Background Color', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'topics' ) ) ); ?></label>
								</div>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Student Count', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[student-count]" value="1" <?php isset( $settings['student-count'] ) ? checked( $settings['student-count'], '1' ) : ''; ?> data-id="student-count"/>
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to show the total Student count.', 'ld-dashboard' ); ?></span>
								<div id="student-count-bgcolor" class="ld-dashboard-colorpicker">
									<input type="text" name="ld_dashboard_tiles_options[student-count-bgcolor]" class="ld-dashboard-color" value="<?php echo isset( $settings['student-count-bgcolor'] ) ? esc_attr( $settings['student-count-bgcolor'] ) : ''; ?>" />
									<label class="ld-decription"><?php esc_html_e( 'Total Student Count Block Background Color', 'ld-dashboard' ); ?></label>
								</div>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( sprintf( 'Enrolled %s Count', esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ), 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[enrolled_courses_count]" value="1" <?php isset( $settings['enrolled_courses_count'] ) ? checked( $settings['enrolled_courses_count'], '1' ) : ''; ?> data-id="enrolled_courses_count"/>
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php esc_html_e( sprintf( 'Enable this option if you want to show the total enrolled %s count.', esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ), 'ld-dashboard' ); ?></span>
								<div id="enrolled-courses-count-bgcolor" class="ld-dashboard-colorpicker">
									<input type="text" name="ld_dashboard_tiles_options[enrolled_courses_count_bgcolor]" class="ld-dashboard-color" value="<?php echo isset( $settings['enrolled_courses_count_bgcolor'] ) ? esc_attr( $settings['enrolled_courses_count_bgcolor'] ) : ''; ?>" />
									<label class="ld-decription"><?php esc_html_e( sprintf( 'Enrolled %s Count Block Background Color', esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ), 'ld-dashboard' ); ?></label>
								</div>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( sprintf( 'Active %s Count', esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ), 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[active_courses_count]" value="1" <?php isset( $settings['active_courses_count'] ) ? checked( $settings['active_courses_count'], '1' ) : ''; ?> data-id="active_courses_count"/>
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php esc_html_e( sprintf( 'Enable this option if you want to show the total active %s count.', esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ), 'ld-dashboard' ); ?></span>
								<div id="active-courses-count-bgcolor" class="ld-dashboard-colorpicker">
									<input type="text" name="ld_dashboard_tiles_options[active_courses_count_bgcolor]" class="ld-dashboard-color" value="<?php echo isset( $settings['active_courses_count_bgcolor'] ) ? esc_attr( $settings['active_courses_count_bgcolor'] ) : ''; ?>" />
									<label class="ld-decription"><?php esc_html_e( sprintf( 'Active %s Count Block Background Color', esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ), 'ld-dashboard' ); ?></label>
								</div>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( sprintf( 'Completed %s Count', esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ), 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[completed_courses_count]" value="1" <?php isset( $settings['completed_courses_count'] ) ? checked( $settings['completed_courses_count'], '1' ) : ''; ?> data-id="completed_courses_count"/>
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php esc_html_e( sprintf( 'Enable this option if you want to show the total completed %s count.', esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ), 'ld-dashboard' ); ?></span>
								<div id="completed-courses-count-bgcolor" class="ld-dashboard-colorpicker">
									<input type="text" name="ld_dashboard_tiles_options[completed_courses_count_bgcolor]" class="ld-dashboard-color" value="<?php echo isset( $settings['completed_courses_count_bgcolor'] ) ? esc_attr( $settings['completed_courses_count_bgcolor'] ) : ''; ?>" />
									<label class="ld-decription"><?php esc_html_e( sprintf( 'Completed %s Count Block Background Color', esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ), 'ld-dashboard' ); ?></label>
								</div>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Total Earnings', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_tiles_options[total-earning]" value="1" <?php isset( $settings['total-earning'] ) ? checked( $settings['total-earning'], '1' ) : ''; ?> data-id="total-earning"/>
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to show the total earnings of the instructor.', 'ld-dashboard' ); ?></span>
								<div id="completed-courses-count-bgcolor" class="ld-dashboard-colorpicker">
									<input type="text" name="ld_dashboard_tiles_options[total-earning-bgcolor]" class="ld-dashboard-color" value="<?php echo isset( $settings['total-earning-bgcolor'] ) ? esc_attr( $settings['total-earning-bgcolor'] ) : ''; ?>" />
									<label class="ld-decription"><?php esc_html_e( 'Total Earnings Block Background Color', 'ld-dashboard' ); ?></label>
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
