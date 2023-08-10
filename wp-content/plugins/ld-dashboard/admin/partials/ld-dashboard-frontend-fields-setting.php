<?php
/**
 * Provide a admin area view for course fields setting.
 *
 * This file is used to markup the course fields setting aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com/plugins
 * @since      1.0.0
 *
 * @package    Ld_Dashboard
 * @subpackage Ld_Dashboard/admin/partials
 */

$function_obj               = Ld_Dashboard_Functions::instance();
$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
$default_field_labels       = get_option( 'ld_dashboard_frontend_form_default_labels' );
$course_settings            = $ld_dashboard_settings_data['course_fields_setting'];
$course_fields              = acf_get_fields( 'course-field-group' );

$lesson_settings = $ld_dashboard_settings_data['lesson_fields_setting'];
$lesson_fields   = acf_get_fields( 'lesson-field-group' );

$topic_settings = $ld_dashboard_settings_data['topic_fields_setting'];
$topic_fields   = acf_get_fields( 'topic-field-group' );

$quiz_settings = $ld_dashboard_settings_data['quiz_fields_setting'];
$quiz_fields   = acf_get_fields( 'quizz-field-group' );

$question_settings = $ld_dashboard_settings_data['question_fields_setting'];
$question_fields   = acf_get_fields( 'question-field-group' );
?>
<div class="wbcom-tab-content">
	<div class="ld-dashboard-frontend-field-settings ld-dashboard-settings">
		<div class="ld-dashboard-content container">
			<div class="filter-frontend-field ld-single-grid">
				<div class="ld-grid-label" scope="row">
					<h4 class="fields-setting-title"><?php echo esc_html__( 'Select Field Group', 'ld-dashboard' ); ?></h4>
				</div>
				<div class="ld-dashboard-field-setting-content">
					<label class="ld-dashboard-field-setting-switch">
						<select id="ld_dashboard_field_restriction" class="ld-dashoard-field-group-dropdown">
							<option value="course"><?php echo esc_html( LearnDash_Custom_Label::get_label( 'course' ) ); ?></option>
							<option value="lesson"><?php echo esc_html( LearnDash_Custom_Label::get_label( 'lesson' ) ); ?></option>
							<option value="topic"><?php echo esc_html( LearnDash_Custom_Label::get_label( 'topic' ) ); ?></option>
							<option value="quiz"><?php echo esc_html( LearnDash_Custom_Label::get_label( 'quiz' ) ); ?></option>
							<option value="question"><?php echo esc_html( LearnDash_Custom_Label::get_label( 'question' ) ); ?></option>
						</select>
					</label>
				</div>
			</div>  
			<div class="ld-courses-all-field-group">
			<div class="ld-dashboard-fields-form-container">
				<div class="ld-dashboard-wrapper-admin course-field-group-wrap ld-dashboard-fields-form-single" data-group="course">
					<h3 class="ld-dashboard-current-tab"><?php printf( '%1s %2s', esc_html( LearnDash_Custom_Label::get_label( 'course' ) ), esc_html__( 'Field Group', 'ld-dashboard' ) ); ?></h3>	
					<div class="enable-disable-all-fields ld-single-grid">
						<div class="ld-grid-label" scope="row">
							<label><?php echo esc_html__( 'Enable/Disable All Fields', 'ld-dashboard' ); ?></label>
						</div>
						<div class="ld-grid-content">
						<label class="ld-dashboard-setting-switch">
								<input type="checkbox" class="ld-dashboard-setting-switch-all" value="1">
								<div class="ld-dashboard-setting round"></div>
							</label>
						</div>
					</div>
					<form method="post" action="options.php" enctype="multipart/form-data">
						<?php
						settings_fields( 'ld_dashboard_course_form_settings' );
						do_settings_sections( 'ld_dashboard_course_form_settings' );
						?>
						<div class="form-table">
							<div class="ld-grid-view-wrapper">
								<div class="ld-dashboard-course-fields-setting">
									<?php
									foreach ( $course_fields as $field ) {
										?>
										<div class="ld-single-grid">
											<div class="ld-grid-label" scope="row">
												<label>
													<?php
													if ( isset( $field['label'] ) && '' != $field['label'] ) {
														echo esc_html( $field['label'] );
													} else {
														if ( isset( $default_field_labels[ $field['key'] ] ) ) {
															echo esc_html( $default_field_labels[ $field['key'] ] );
														} else {
															echo esc_html( $field['key'] );
														}
													}
													?>
												</label>
											</div>
											<div class="ld-grid-content">
												<label class="ld-dashboard-setting-switch">
													<input type="checkbox" class="ld-dashboard-checkbox ld-dashboard-form-field" name="ld_dashboard_course_form_settings[<?php echo esc_attr( $field['key'] ); ?>]" data-key="<?php echo esc_attr( $field['key'] ); ?>" value="1" <?php isset( $course_settings[ $field['key'] ] ) ? checked( $course_settings[ $field['key'] ], '1' ) : ''; ?>>
													<div class="ld-dashboard-setting round"></div>
												</label>
												<?php
												if ( isset( $field['conditional_logic'] ) && is_array( $field['conditional_logic'] ) ) {
													foreach ( $field['conditional_logic'] as $condtns ) {
														if ( is_array( $condtns ) ) {
															foreach ( $condtns as $condtn ) {
																?>
																	<input type="hidden" class="ld-dashboard-parent-<?php echo esc_attr( $condtn['field'] ); ?>" >
																	<?php
															}
														}
													}
												}
												?>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<?php submit_button(); ?>
						<?php wp_nonce_field( 'ld-dashboard-settings-submit', 'ld-dashboard-settings-submit' ); ?>
					</form>
				</div>
				<div class="ld-dashboard-wrapper-admin ld-dashboard-fields-form-single" data-group="lesson">
					<h3 class="ld-dashboard-current-tab"><?php printf( '%1s %2s', esc_html( LearnDash_Custom_Label::get_label( 'lesson' ) ), esc_html__( 'Field Group', 'ld-dashboard' ) ); ?></h3>	
					<div class="enable-disable-all-fields ld-single-grid">
						<div class="ld-grid-label" scope="row">
							<label><?php echo esc_html__( 'Enable/Disable All Fields', 'ld-dashboard' ); ?></label>
						</div>
						<div class="ld-grid-content">
						<label class="ld-dashboard-setting-switch">
								<input type="checkbox" class="ld-dashboard-setting-switch-all" value="1">
								<div class="ld-dashboard-setting round"></div>
							</label>
						</div>
					</div>
					<form method="post" action="options.php" enctype="multipart/form-data">
							<?php
							settings_fields( 'ld_dashboard_lesson_form_settings' );
							do_settings_sections( 'ld_dashboard_lesson_form_settings' );
							?>
							<div class="form-table">
						<div class="ld-grid-view-wrapper">
									<div class="ld-dashboard-course-fields-setting">
										<?php
										foreach ( $lesson_fields as $field ) {
											?>
										<div class="ld-single-grid">
											<div class="ld-grid-label" scope="row">
												<label>
												<?php
												if ( isset( $field['label'] ) && '' != $field['label'] ) {
													echo esc_html( $field['label'] );
												} else {
													if ( isset( $default_field_labels[ $field['key'] ] ) ) {
														echo esc_html( $default_field_labels[ $field['key'] ] );
													} else {
														echo esc_html( $field['key'] );
													}
												}
												?>
												</label>
											</div>
											<div class="ld-grid-content">
												<label class="ld-dashboard-setting-switch">
													<input type="checkbox" class="ld-dashboard-checkbox ld-dashboard-form-field" name="ld_dashboard_lesson_form_settings[<?php echo esc_attr( $field['key'] ); ?>]" data-key="<?php echo esc_attr( $field['key'] ); ?>" value="1" <?php isset( $lesson_settings[ $field['key'] ] ) ? checked( $lesson_settings[ $field['key'] ], '1' ) : ''; ?>>
													<div class="ld-dashboard-setting round"></div>
												</label>
												<?php
												if ( isset( $field['conditional_logic'] ) && is_array( $field['conditional_logic'] ) ) {
													foreach ( $field['conditional_logic'] as $condtns ) {
														if ( is_array( $condtns ) ) {
															foreach ( $condtns as $condtn ) {
																?>
																	<input type="hidden" class="ld-dashboard-parent-<?php echo esc_attr( $condtn['field'] ); ?>" >
																<?php
															}
														}
													}
												}
												?>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
						</div>
						<?php submit_button(); ?>
						<?php wp_nonce_field( 'ld-dashboard-settings-submit', 'ld-dashboard-settings-submit' ); ?>
					</form>
				</div>
				<div class="ld-dashboard-wrapper-admin ld-dashboard-fields-form-single" data-group="topic">
					<h3 class="ld-dashboard-current-tab"><?php printf( '%1s %2s', esc_html( LearnDash_Custom_Label::get_label( 'topic' ) ), esc_html__( 'Field Group', 'ld-dashboard' ) ); ?></h3>	
					<div class="enable-disable-all-fields ld-single-grid">
						<div class="ld-grid-label" scope="row">
							<label><?php echo esc_html__( 'Enable/Disable All Fields', 'ld-dashboard' ); ?></label>
						</div>
						<div class="ld-grid-content">
						<label class="ld-dashboard-setting-switch">
								<input type="checkbox" class="ld-dashboard-setting-switch-all" value="1">
								<div class="ld-dashboard-setting round"></div>
							</label>
						</div>
					</div>
					<form method="post" action="options.php" enctype="multipart/form-data">
						<?php
						settings_fields( 'ld_dashboard_topic_form_settings' );
						do_settings_sections( 'ld_dashboard_topic_form_settings' );
						?>
						<div class="form-table">
							<div class="ld-grid-view-wrapper">
								<div class="ld-dashboard-topic-fields-setting">
									<?php
									foreach ( $topic_fields as $field ) {
										?>
										<div class="ld-single-grid">
											<div class="ld-grid-label" scope="row">
												<label>
												<?php
												if ( isset( $field['label'] ) && '' != $field['label'] ) {
													echo esc_html( $field['label'] );
												} else {
													if ( isset( $default_field_labels[ $field['key'] ] ) ) {
														echo esc_html( $default_field_labels[ $field['key'] ] );
													} else {
														echo esc_html( $field['key'] );
													}
												}
												?>
												</label>
											</div>
											<div class="ld-grid-content">
												<label class="ld-dashboard-setting-switch">
													<input type="checkbox" class="ld-dashboard-checkbox ld-dashboard-form-field" name="ld_dashboard_topic_form_settings[<?php echo esc_attr( $field['key'] ); ?>]" data-key="<?php echo esc_attr( $field['key'] ); ?>" value="1" <?php isset( $topic_settings[ $field['key'] ] ) ? checked( $topic_settings[ $field['key'] ], '1' ) : ''; ?>>
													
													<div class="ld-dashboard-setting round"></div>
												</label>
												<?php
												if ( isset( $field['conditional_logic'] ) && is_array( $field['conditional_logic'] ) ) {
													foreach ( $field['conditional_logic'] as $condtns ) {
														if ( is_array( $condtns ) ) {
															foreach ( $condtns as $condtn ) {
																?>
																	<input type="hidden" class="ld-dashboard-parent-<?php echo esc_attr( $condtn['field'] ); ?>" >
																	<?php
															}
														}
													}
												}
												?>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
							<?php submit_button(); ?>
							<?php wp_nonce_field( 'ld-dashboard-settings-submit', 'ld-dashboard-settings-submit' ); ?>
						</div>
						<br /><br />
					</form>
				</div>
				<div class="ld-dashboard-wrapper-admin ld-dashboard-fields-form-single" data-group="quiz">
					<h3 class="ld-dashboard-current-tab"><?php printf( '%1s %2s', esc_html( LearnDash_Custom_Label::get_label( 'quiz' ) ), esc_html__( 'Field Group', 'ld-dashboard' ) ); ?></h3>	
					<div class="enable-disable-all-fields ld-single-grid">
						<div class="ld-grid-label" scope="row">
							<label><?php echo esc_html__( 'Enable/Disable All Fields', 'ld-dashboard' ); ?></label>
						</div>
						<div class="ld-grid-content">
						<label class="ld-dashboard-setting-switch">
								<input type="checkbox" class="ld-dashboard-setting-switch-all" value="1">
								<div class="ld-dashboard-setting round"></div>
							</label>
						</div>
					</div>
					<form method="post" action="options.php" enctype="multipart/form-data">
						<?php
						settings_fields( 'ld_dashboard_quiz_form_settings' );
						do_settings_sections( 'ld_dashboard_quiz_form_settings' );
						?>
						<div class="form-table">
							<div class="ld-grid-view-wrapper">
								<div class="ld-dashboard-quiz-fields-setting">
									<?php
									foreach ( $quiz_fields as $field ) {
										?>
										<div class="ld-single-grid">
											<div class="ld-grid-label" scope="row">
												<label>
												<?php
												if ( isset( $field['label'] ) && '' != $field['label'] ) {
													echo esc_html( $field['label'] );
												} else {
													if ( isset( $default_field_labels[ $field['key'] ] ) ) {
														echo esc_html( $default_field_labels[ $field['key'] ] );
													} else {
														echo esc_html( $field['key'] );
													}
												}
												?>
												</label>
											</div>
											<div class="ld-grid-content">
												<label class="ld-dashboard-setting-switch">
													<input type="checkbox" class="ld-dashboard-checkbox ld-dashboard-form-field" name="ld_dashboard_quiz_form_settings[<?php echo esc_attr( $field['key'] ); ?>]" data-key="<?php echo esc_attr( $field['key'] ); ?>" value="1" <?php isset( $quiz_settings[ $field['key'] ] ) ? checked( $quiz_settings[ $field['key'] ], '1' ) : ''; ?>>
													<div class="ld-dashboard-setting round"></div>
												</label>
												<?php
												if ( isset( $field['conditional_logic'] ) && is_array( $field['conditional_logic'] ) ) {
													foreach ( $field['conditional_logic'] as $condtns ) {
														if ( is_array( $condtns ) ) {
															foreach ( $condtns as $condtn ) {
																?>
																	<input type="hidden" class="ld-dashboard-parent-<?php echo esc_attr( $condtn['field'] ); ?>" >
																	<?php
															}
														}
													}
												}
												?>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
							<?php submit_button(); ?>
							<?php wp_nonce_field( 'ld-dashboard-settings-submit', 'ld-dashboard-settings-submit' ); ?>
						</div>
						<br /><br />
					</form>
				</div>
				<div class="ld-dashboard-wrapper-admin ld-dashboard-fields-form-single" data-group="question">
					<h3 class="ld-dashboard-current-tab"><?php printf( '%1s %2s', esc_html( LearnDash_Custom_Label::get_label( 'question' ) ), esc_html__( 'Field Group', 'ld-dashboard' ) ); ?></h3>
					<div class="enable-disable-all-fields ld-single-grid">
						<div class="ld-grid-label" scope="row">
							<label><?php echo esc_html__( 'Enable/Disable All Fields', 'ld-dashboard' ); ?></label>
						</div>
						<div class="ld-grid-content">
						<label class="ld-dashboard-setting-switch">
								<input type="checkbox" class="ld-dashboard-setting-switch-all" value="1">
								<div class="ld-dashboard-setting round"></div>
							</label>
						</div>
					</div>
					<form method="post" action="options.php" enctype="multipart/form-data">
						<?php
						settings_fields( 'ld_dashboard_question_form_settings' );
						do_settings_sections( 'ld_dashboard_question_form_settings' );
						?>
						<div class="form-table">
							<div class="ld-grid-view-wrapper">
								<div class="ld-dashboard-question-fields-setting">
									<?php
									foreach ( $question_fields as $field ) {
										?>
										<div class="ld-single-grid">
											<div class="ld-grid-label" scope="row">
												<label>
												<?php
												if ( isset( $field['label'] ) && '' != $field['label'] ) {
													echo esc_html( $field['label'] );
												} else {
													if ( isset( $default_field_labels[ $field['key'] ] ) ) {
														echo esc_html( $default_field_labels[ $field['key'] ] );
													} else {
														echo esc_html( $field['key'] );
													}
												}
												?>
												</label>
											</div>
											<div class="ld-grid-content">
												<label class="ld-dashboard-setting-switch">
													<input type="checkbox" class="ld-dashboard-checkbox ld-dashboard-form-field" name="ld_dashboard_question_form_settings[<?php echo esc_attr( $field['key'] ); ?>]" data-key="<?php echo esc_attr( $field['key'] ); ?>" value="1" <?php isset( $question_settings[ $field['key'] ] ) ? checked( $question_settings[ $field['key'] ], '1' ) : ''; ?>>
													<div class="ld-dashboard-setting round"></div>
												</label>
												<?php
												if ( isset( $field['conditional_logic'] ) && is_array( $field['conditional_logic'] ) ) {
													foreach ( $field['conditional_logic'] as $condtns ) {
														if ( is_array( $condtns ) ) {
															foreach ( $condtns as $condtn ) {
																?>
																	<input type="hidden" class="ld-dashboard-parent-<?php echo esc_attr( $condtn['field'] ); ?>" >
																	<?php
															}
														}
													}
												}
												?>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
							<?php submit_button(); ?>
							<?php wp_nonce_field( 'ld-dashboard-settings-submit', 'ld-dashboard-settings-submit' ); ?>
						</div>
					</form>
				</div>

			</div>
		</div>
		</div>
	</div>
</div>
