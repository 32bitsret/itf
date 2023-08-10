<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Custom_Learndash
 * @subpackage Custom_Learndash/public/partials
 */

$shared_topic_ids = array();
?>
<div class="wbcom-front-end-course-dashboard-my-courses-content">
	<div class="custom-learndash-list custom-learndash-my-courses-list">
		<div class="ld-dashboard-course-content ld-dashboard-assignment-content instructor-courses-list">
			<div class="ld-dashboard-section-head-title">
				<h3 class="ld-dashboard-nav-title"><?php esc_html_e( 'Assignments', 'ld-dashboard' ); ?></h3>
			</div>
			<div class="ld-dashboard-content-inner">
			<?php do_action( 'ld_dashboard_before_topic_filter' ); ?>
				<div class="ld-dasboard-my-filter ld-dashboard-course-filter">
					<div class="ld-dashboard-actions-iteam">
						<label><?php printf( esc_html__( 'All %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></label>
						<select class="ld-dashboard-tab-content-filter ld-dashboard-course-filter-select">
							<option value="0"><?php printf( esc_html__( 'Select %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></option>
						</select>
					</div>
					<div class="ld-dashboard-actions-iteam">
						<label><?php printf( esc_html__( 'All %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'lesson' ) ) ); ?></label>
						<select class="ld-dashboard-sec-filter ld-dashboard-lesson-filter-select"></select>
					</div>
					<button class="ld-dashboard-course-filter-submit ld-dashboard-btn-bg" data-type="assignment"><?php esc_html_e( 'Filter', 'ld-dashboard' ); ?></button>
				</div>
				<?php do_action( 'ld_dashboard_before_topics_content' ); ?>

				<div class="ld-dashboard-tab-content-wrapper"></div>

				<?php do_action( 'ld_dashboard_after_topics_content' ); ?>
			</div>
		</div>
		<nav class="custom-learndash-pagination-nav">
			<ul class="custom-learndash-pagination">
				<li class="custom-learndash-pagination-prev"><button class="ld-dashboard-pagination-btn ld-dashboard-prev-btn" data-page="0"><img src="<?php echo esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/angle-left-b.svg'; ?>"></button></li> 
				<li class="custom-learndash-pagination-next"><button class="ld-dashboard-pagination-btn ld-dashboard-next-btn" data-page="1"><img src="<?php echo esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/angle-right-b.svg'; ?>"></button></li>
			</ul>
		</nav>
	</div>
</div>
