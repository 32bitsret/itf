<?php
if ( learndash_is_admin_user() ) {
	$args    = array(
		'post_type'      => 'sfwd-courses',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	);
	$courses = get_posts( $args );
} elseif ( in_array( 'ld_instructor', $current_user->roles ) ) {
	$courses = Ld_Dashboard_Public::get_instructor_courses_list();
}
?>
<div class="my-announcements-wrapper">
	<div class="ld-dashboard-section-head-title">
		<h3 class="ld-dashboard-nav-title"><?php esc_html_e( 'My Announcements', 'ld-dashboard' ); ?></h3>
	</div>
	<div class="ld-dashboard-content-inner">
		<div class="ld-dashboard-announcement-container">
			<div class="ld-dashboard-announcement-content">
				<form id="ld-dashboard-new-announcement-form" method="POST">
					<div class="ld-dashboard-announcement-courses-dropdown ld-dashboard-course-filter">
						<div class="ld-dashboard-actions-iteam">
							<label><?php echo esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ); ?></label>
							<select class="ld-dashboard-announcement-course-dropdown" name="course">
								<?php
								echo '<option value="">' . sprintf( esc_html__( 'Select %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ) . '</option>';
								foreach ( $courses as $course ) {
									echo '<option value="' . esc_attr( $course->ID ) . '">' . esc_html( $course->post_title ) . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="ld-dashboard-announcement-fields-wrapper" style="display:none">
						<div class="ld-dashboard-announcement-field-single">
							<label><?php echo esc_html__( 'Title', 'ld-dashboard' ); ?> <small class="ldd-required-field">*</small></label>
							<input type="text" name="post_title" />
							<span class="ld-dashboard-msg-box announcement-title"></span>
						</div>
						<div class="ld-dashboard-announcement-field-single">
							<label><?php echo esc_html__( 'Content', 'ld-dashboard' ); ?></label>
							<?php
							$args = array(
								'textarea_name' => 'post_content', // Set custom name.
							);
							wp_editor( '', 'announcementeditor', $args );
							?>
						</div>
						<div class="ld-dashboard-announcement-field-single">
							<button class="ld-dashboard-create-announcement-btn"><?php echo esc_html__( 'Create Announcement', 'ld-dashboard' ); ?></button>
							<span class="ld-dashboard-msg-box announcement-submit"></span>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
