<?php
if ( isset( $monetization_settings['instructor-earning-report'] ) && 1 == $monetization_settings['instructor-earning-report'] && ld_if_commission_enabled() && ( in_array( 'administrator', $current_user->roles ) || in_array( 'ld_instructor', $current_user->roles ) ) ) {
	?>
	<div class="ld-dashboard-course-progress">
		<div class="ld-dashboard-instructor-earning-head-wrapper">
			<h3 class="ld-dashboard-instructor-earning-title"><?php esc_html_e( 'Instructor Earning', 'ld-dashboard' ); ?></h3>
			<div class="ld-dashboard-instructor-earning-filter-wrapper">
				<ul class="ld-dashboard-instructor-earning-filters-list" data-type="earning_chart">
					<li class="ld-dashboard-instructor-earning-filters-link filter-selected" data-filter="year"><?php echo esc_html__( 'Year', 'ld-dashboard' ); ?></li>
					<li class="ld-dashboard-instructor-earning-filters-link" data-filter="l_month"><?php echo esc_html__( 'Last Month', 'ld-dashboard' ); ?></li>
					<li class="ld-dashboard-instructor-earning-filters-link" data-filter="month"><?php echo esc_html__( 'This Month', 'ld-dashboard' ); ?></li>
					<li class="ld-dashboard-instructor-earning-filters-link" data-filter="week"><?php echo esc_html__( 'Last 7 Days', 'ld-dashboard' ); ?></li>
				</ul>
			</div>
		</div>
		<div class="ld-dashboard-instructor-earning-chart-wrapper"></div>
	</div>
	<?php
}

if ( isset( $ld_dashboard['course-completion-report'] ) && 1 == $ld_dashboard['course-completion-report'] && ( in_array( 'administrator', $current_user->roles ) || in_array( 'ld_instructor', $current_user->roles ) ) ) {
	?>
	<div class="ld-dashboard-course-progress">
		<div class="ld-dashboard-instructor-earning-head-wrapper">
			<h3 class="ld-dashboard-instructor-earning-title"><?php printf( '%1s %2s', esc_html( LearnDash_Custom_Label::get_label( 'course' ) ), esc_html__( 'Completion', 'ld-dashboard' ) ); ?></h3>
			<div class="ld-dashboard-instructor-earning-filter-wrapper">
				<ul class="ld-dashboard-instructor-earning-filters-list" data-type="course_completion_chart">
					<li class="ld-dashboard-instructor-earning-filters-link filter-selected" data-filter="year"><?php echo esc_html__( 'Year', 'ld-dashboard' ); ?></li>
					<li class="ld-dashboard-instructor-earning-filters-link" data-filter="l_month"><?php echo esc_html__( 'Last Month', 'ld-dashboard' ); ?></li>
					<li class="ld-dashboard-instructor-earning-filters-link" data-filter="month"><?php echo esc_html__( 'This Month', 'ld-dashboard' ); ?></li>
					<li class="ld-dashboard-instructor-earning-filters-link" data-filter="week"><?php echo esc_html__( 'Last 7 Days', 'ld-dashboard' ); ?></li>
				</ul>
			</div>
		</div>
		<div class="ld-dashboard-course-completion-report-wrapper"></div>
	</div>
	<?php
}
if ( isset( $ld_dashboard['top-courses-report'] ) && 1 == $ld_dashboard['top-courses-report'] && ( in_array( 'administrator', $current_user->roles ) || in_array( 'ld_instructor', $current_user->roles ) ) ) {
	?>
	<div class="ld-dashboard-course-progress">
		<div class="ld-dashboard-instructor-earning-head-wrapper">
			<h3 class="ld-dashboard-instructor-earning-title"><?php printf( '%1s %2s', esc_html__( 'Top', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ); ?></h3>
			<div class="ld-dashboard-instructor-earning-filter-wrapper">
				<ul class="ld-dashboard-instructor-earning-filters-list" data-type="top_courses_chart">
					<li class="ld-dashboard-instructor-earning-filters-link filter-selected" data-filter="year"><?php echo esc_html__( 'Year', 'ld-dashboard' ); ?></li>
					<li class="ld-dashboard-instructor-earning-filters-link" data-filter="l_month"><?php echo esc_html__( 'Last Month', 'ld-dashboard' ); ?></li>
					<li class="ld-dashboard-instructor-earning-filters-link" data-filter="month"><?php echo esc_html__( 'This Month', 'ld-dashboard' ); ?></li>
					<li class="ld-dashboard-instructor-earning-filters-link" data-filter="week"><?php echo esc_html__( 'Last 7 Days', 'ld-dashboard' ); ?></li>
				</ul>
			</div>
		</div>
		<div class="ld-dashboard-top-courses-report-wrapper"></div>
	</div>
	<?php
}
