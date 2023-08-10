<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$course_label = ( isset( $learndash_settings_custom_labels['course'] ) && $learndash_settings_custom_labels['course'] != '' ) ? $learndash_settings_custom_labels['course'] : 'Course';
?>
	<div class="ld-dashboard-sidebar-right">
		<?php do_action( 'ld_dashboard_before_course_activity_section' ); ?>

		<div class="ld-dashboard-feed-wrapper">
			<h3 class="ld-dashboard-feed-title"><?php echo sprintf( esc_html__( 'Live  %s Activity', 'ld-dashboard' ), $course_label ); ?></h3>
			<div id="ld-dashboard-feed" class="ld-dashboard-feed">
				<?php $this->ld_dashboard_activity_rows(); ?>
			</div>
		</div>

		<?php do_action( 'ld_dashboard_after_course_activity_section' ); ?>

	</div>
</div>
