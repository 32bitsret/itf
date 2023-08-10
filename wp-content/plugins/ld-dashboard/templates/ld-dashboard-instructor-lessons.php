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

$shared_lesson_ids  = array();
$dashboard_page_url = Ld_Dashboard_Functions::instance()->ld_dashboard_get_url( 'dashboard' );
?>

<div class="wbcom-front-end-course-dashboard-my-courses-content">
	<div class="custom-learndash-list custom-learndash-my-courses-list">
			<div class="ld-dashboard-course-content instructor-courses-list"> 
				<div class="ld-dashboard-section-head-title">
					<h3 class="ld-dashboard-nav-title"><?php printf( esc_html__( 'My %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'lessons' ) ) ); ?></h3>
					<div class="ld-dashboard-header-button ld-dashboard-add-new-button-container">
						<?php $lesson_nonce = wp_create_nonce( 'lesson-nonce' ); ?>
						<a class="ld-dashboard-add-course ld-dashboard-add-new-button ld-dashboard-btn-bg" href="<?php echo esc_url( $dashboard_page_url ); ?>?action=add-lesson&tab=my-lessons&_lddnonce=<?php echo esc_attr( $lesson_nonce ); ?>">
						<span class="material-symbols-outlined edit_square"><?php esc_html_e( 'add', 'ld-dashboard' ); ?></span> <?php printf( esc_html__( 'Add A New %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'lesson' ) ) ); ?></a>
					</div>
				</div>
				<?php do_action( 'ld_dashboard_before_lessons_filter' ); ?>
				<div class="ld-dashboard-content-inner">
					<div class="ld-dashboard-course-filter my-lessons-filter">
						<div class="ld-dashboard-actions-iteam">
						<label><?php printf( esc_html__( 'All %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'courses' ) ) ); ?></label>
						<select class="ld-dashboard-tab-content-filter ld-dashboard-course-filter-select">
							<option value="0"><?php printf( esc_html__( 'Select %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?></option>
						</select>
						</div>
						<button class="ld-dashboard-course-filter-submit ld-dashboard-btn-bg" data-type="lesson"><?php esc_html_e( 'Filter', 'ld-dashboard' ); ?></button>
					</div>
					<?php do_action( 'ld_dashboard_before_lessons_content' ); ?>
					<div class="ld-dashboard-tab-content-wrapper"></div>
					<?php do_action( 'ld_dashboard_after_lessons_content' ); ?>
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
