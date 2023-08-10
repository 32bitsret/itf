<?php
$active_tab    = '';
$user_id       = get_current_user_id();
$dashboard_url = Ld_Dashboard_Functions::instance()->ld_dashboard_get_url( 'dashboard' );

if ( ! isset( $_GET['sub'] ) ) {
	$active_tab   = 'all-courses';
	$active_title = sprintf( esc_html__( 'All %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) );
} elseif ( isset( $_GET['sub'] ) && 'active-courses' == $_GET['sub'] ) {
	$active_tab   = 'active-courses';
	$active_title = sprintf( esc_html__( 'Active %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) );
} elseif ( isset( $_GET['sub'] ) && 'completed-courses' == $_GET['sub'] ) {
	$active_tab   = 'completed-courses';
	$active_title = sprintf( esc_html__( 'Completed %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) );
}
?>
<div class="ld-dashboard-enrolled-course instructor-courses-list">
	<h3 class="ld-dashboard-tab-heading"><?php echo esc_html( $active_title ); ?></h3>
	<div class="ld-dashboard-enrolled-course-inner">
		<div class="ld-dashboard-inline-links">
			<ul>
				<li class="<?php echo ( ! isset( $_GET['sub'] ) ) ? 'course-nav-active' : ''; ?>"><a href="<?php echo esc_url( $dashboard_url ) . '?tab=enrolled-courses'; ?>"> <?php printf( esc_html__( 'All %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ); ?></a> </li>
				<li class="<?php echo ( isset( $_GET['sub'] ) && 'active-courses' === $_GET['sub'] ) ? 'course-nav-active' : ''; ?>"><a href="<?php echo esc_url( $dashboard_url ) . '?tab=enrolled-courses&sub=active-courses'; ?>"> <?php printf( esc_html__( 'Active %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ); ?> </a></li>
				<li class="<?php echo ( isset( $_GET['sub'] ) && 'completed-courses' === $_GET['sub'] ) ? 'course-nav-active' : ''; ?>"><a href="<?php echo esc_url( $dashboard_url ) . '?tab=enrolled-courses&sub=completed-courses'; ?>"><?php printf( esc_html__( 'Completed %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ); ?> </a></li>
			</ul>
		</div>
		<div class="my-courses ld-dashboard-enrolled-course-wrap">
			<?php do_action( 'ld_dashboard_before_enrolled_courses_content' ); ?>
			<div class="ld-dashboard-enrolled-course-content ld-dashboard-content-inner">
				<?php
				$active_course_filter    = false;
				$completed_course_filter = false;
				if ( 'active-courses' === $active_tab ) {
					$active_course_filter = true;
				} elseif ( 'completed-courses' === $active_tab ) {
					$completed_course_filter = true;
				}
				$enrolled_courses = learndash_user_get_enrolled_courses( $user_id, array(), true );
				if ( is_array( $enrolled_courses ) && count( $enrolled_courses ) > 0 ) :
					foreach ( $enrolled_courses as $course_id ) :
						$course              = get_post( $course_id );
						$author_id           = $course->post_author;
						$image_id            = get_post_meta( $course_id, '_thumbnail_id', true );
						$feat_image_url      = wp_get_attachment_url( $image_id );
						$lessons             = learndash_get_course_lessons_list( $course_id );
						$associated_lessons  = count( $lessons );
						$course_data         = learndash_user_get_course_progress( $user_id, $course_id, 'summary' );
						$course_status_text  = '';
						$course_status_class = '';
						if ( $active_course_filter && $course_data['completed'] == $course_data['total'] ) {
							continue;
						}
						if ( $completed_course_filter && $course_data['completed'] < $course_data['total'] ) {
							continue;
						}

						$progress_percentage = ( $course_data['total'] > 0 ) ? ( $course_data['completed'] * 100 ) / $course_data['total'] : 0;
						$progress_percentage = ( ( 0 == $course_data['total'] && 0 == $course_data['completed'] ) ) ? 0 : round( $progress_percentage );
						$last_activity       = learndash_activity_course_get_latest_completed_step( $user_id, $course_id );
						if ( 0 == $progress_percentage ) {
							$course_status_text  = esc_html__( 'Start Course', 'ld-dashboard' );
							$course_status_class = 'start-course';
						} elseif ( $progress_percentage < 100 ) {
							$course_status_text  = esc_html__( 'In Progress', 'ld-dashboard' );
							$course_status_class = 'in-progress';
						} elseif ( 100 == $progress_percentage ) {
							$course_status_text  = esc_html__( 'Complete', 'ld-dashboard' );
							$course_status_class = 'complete';
						}
						if ( is_array( $last_activity ) && isset( $last_activity['activity_completed'] ) ) {
							$activity_date      = gmdate( 'F d, Y', $last_activity['activity_completed'] );
							$last_activity_text = sprintf( esc_html__( 'Last activity on %s', 'ld-dashboard' ), $activity_date );
						} else {
							$last_activity_text = '';
						}
						?>
						<div id="ld-dashboard-course-<?php echo esc_html( $course->ID ); ?>" class="ld-mycourse-wrap ld-mycourse-<?php echo esc_html( $course->ID ); ?> __web-inspector-hide-shortcut__">
							<div class="ld-mycourse-thumbnail" style="background-image: url(<?php echo ( $feat_image_url ) ? esc_url( $feat_image_url ) : esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/course-default.png'; ?>);"></div>
							<div class="ld-mycourse-content">
							<?php do_action( 'ld_add_course_content_before' ); ?>
								<div class="ld-dashboard-enrolled-course-status <?php echo esc_html( $course_status_class ); ?>"><?php echo esc_html( $course_status_text ); ?></div>
								<h3><a href="<?php echo esc_url( get_permalink( $course->ID ) ); ?>"><?php echo esc_html( $course->post_title ); ?></a></h3>
								<div class="ld-meta ld-course-metadata">
									<ul>
										<li><span class="ld-dashboard-progress-percent"><?php echo esc_html( $progress_percentage ) . '%  Complete'; ?></span></li>
										<li><span><?php echo esc_html( $course_data['completed'] . '/' . $course_data['total'] ); ?> <?php printf( esc_html__( 'Steps', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'lessons' ) ) ); ?></span></li>
									</ul>
								</div>
								<div class="ld-dashboard-course-last-activity-time">
									<div class="ld-dashboard-last-activity"><?php echo esc_html( $last_activity_text ); ?></div>
									<?php if ( $progress_percentage < 100 ) : ?>
										<div class="ld-dashboard-enrolled-course-resume-btn"><?php // echo do_shortcode( '[ld_course_resume course_id="' . $course_id . '" user_id="' . $user_id . '"]' ); ?></div>
									<?php endif; ?>
								</div>
								<div class="ld-dashboard-enrolled-course-author-content-user"><img class="ld-dashboard-course-author-avatar" src="<?php echo esc_url( get_avatar_url( $author_id, 320 ) ); ?>"><span class="ld-dashboard-course-author-name"> <?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></span></div>
							</div>
						</div>
					<?php endforeach; else : ?>
						<div class="ld-dashboard-all-courses-content"><p class="ld-dashboard-warning"><?php printf( esc_html__( 'You haven\'t purchased any %s.', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></p></div>
					<?php endif; ?>
			</div>
			<?php do_action( 'ld_dashboard_after_enrolled_courses_content' ); ?>
		</div>
	</div>
</div>




