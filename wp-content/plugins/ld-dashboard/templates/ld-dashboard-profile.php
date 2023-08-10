<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $current_user;
$user_id      = get_current_user_id();
$current_user = wp_get_current_user();

$user_name                      = $current_user->user_firstname . ' ' . $current_user->user_lastname;
$user_name                      = ( $current_user->user_firstname == '' && $current_user->user_lastname == '' ) ? $current_user->user_login : $user_name;
$function_obj                   = Ld_Dashboard_Functions::instance();
$ld_dashboard_settings_data     = $function_obj->ld_dashboard_settings_data();
$welcome_screen                 = $ld_dashboard_settings_data['welcome_screen'];
$ld_dashboard_general_settings  = $ld_dashboard_settings_data['general_settings'];
$monetization_settings          = $ld_dashboard_settings_data['monetization_settings'];
$dashboard_page                 = $function_obj->ld_dashboard_get_url( 'dashboard' );
$dashboard_landing_cover        = '';
$enable_instructor_earning_logs = isset( $ld_dashboard_general_settings['enable-instructor-earning-logs'] ) ? $ld_dashboard_general_settings['enable-instructor-earning-logs'] : '';

if ( isset( $welcome_screen['welcomebar_image'] ) && $welcome_screen['welcomebar_image'] != '' ) {
	$dashboard_landing_cover = "background-image: url({$welcome_screen['welcomebar_image']});";
}
?>
<div class="ld-dashboard-profile-summary-container" style="max-width: 100%;width: 100%;">
	<div class="ld-dashboard-profile-summary" style="<?php echo esc_attr( $dashboard_landing_cover ); ?>">
		<div class="ld-dashboard-profile">
			<div class="ld-dashboard-profile-avatar">
				<?php echo wp_kses_post( get_avatar( $user_id ) ); ?>
			</div>
			<?php if ( $user_name != '' ) : ?>
				<div class="ld-dashboard-profile-info">
					<div class="ld-dashboard-display-name">
						<h4><strong><?php echo esc_html( $user_name ); ?></strong></h4>
					</div>
					<?php do_action( 'ld_dashboard_banner_content' ); ?>
					<?php endif; ?>
					<?php if ( ! empty( $current_user->user_email ) ) : ?>
						<div class="ld-dashboard-profile-email">
							<?php echo esc_html( $current_user->user_email ); ?>
						</div>
					<?php endif; ?>
				</div>
				<?php if ( ( ! learndash_is_group_leader_user( $user_id ) && in_array( 'ld_instructor', (array) $current_user->roles ) ) || ( learndash_is_admin_user( $user_id ) || ld_can_user_manage_courses() ) ) : ?>
					<div class="ld-dashboard-header-button">
						<?php $course_nonce = wp_create_nonce( 'course-nonce' ); ?>
						<a class="ld-dashboard-add-course ld-dashboard-btn-bg" href="<?php echo esc_url( get_permalink() ) . '?action=add-course&tab=my-courses&_lddnonce=' . esc_attr( $course_nonce ); ?>">
							<span class="material-symbols-outlined"><?php echo esc_html__( 'add', 'ld-dashboard' ); ?></span> <?php printf( esc_html__( 'Add a new %s', 'ld-dashboard' ), esc_html( LearnDash_Custom_Label::get_label( 'course' ) ) ); ?>
						</a>
					</div>
				<?php endif; ?>
				<?php if ( isset( $ld_dashboard_general_settings['become-instructor-button'] ) && 1 == $ld_dashboard_general_settings['become-instructor-button'] && ! learndash_is_group_leader_user( $user_id ) && ! learndash_is_admin_user( $user_id ) && ! in_array( 'ld_instructor', (array) $current_user->roles ) && ! in_array( 'ld_instructor_pending', (array) $current_user->roles ) ) : ?>
					<div class="ld-dashboard-header-button">
						<?php $instructor_nonce = wp_create_nonce( 'instructor-nonce' ); ?>
						<a class="ld-dashboard-add-course ld-dashboard-become-instructor-btn ld-dashboard-btn-bg" href="#">
							<img src="<?php echo esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/icons/user-tie.svg'; ?>"> <?php esc_html_e( 'Become An Instructor', 'ld-dashboard' ); ?>
						</a>
					</div>
				<?php endif; ?>
		</div>
		<?php
		if ( isset( $ld_dashboard['welcome-screen'] ) && $ld_dashboard['welcome-screen'] == 1 ) {
			?>
		<div class="ld-dashboard-landing-content">
			<?php do_action( 'ld_dashboard_before_welcome_message' ); ?>
			<div class="ld-dashboard-landing-text">
				<?php
				if ( isset( $welcome_screen['welcome-message'] ) && $welcome_screen['welcome-message'] != '' ) {
					echo sprintf( esc_html( $welcome_screen['welcome-message'] ), esc_html( trim( $user_name ) ) );
				} else {
					echo sprintf( esc_html__( 'Welcome back, %s', 'ld-dashboard' ), esc_html( trim( $user_name ) ) );
				}
				?>
			</div>
			<?php do_action( 'ld_dashboard_after_welcome_message' ); ?>
		</div>
		<?php } ?>
	</div>
</div>
<div class="ld-dashboard-content-wrapper">
	<div class="ld-dashboard-left-section ld-dashboard-sidebar-left">
		<?php do_action( 'ld_dashboard_before_profile_section' ); ?>
		<section id="ld-dashboard-profile" class="widget-ld-dashboard-profile ld-dashboard-profile">
			<div class="ld-dashboard-mobile">
				<div class="ld-dashboard-mobile-wrap">
					<?php if ( learndash_is_admin_user( $user_id ) || in_array( 'ld_instructor', (array) $current_user->roles ) ) : ?>
						<a class="mobile-menu-link" href="<?php echo esc_url( $dashboard_page ) . '?tab=my-courses'; ?>">
							<img src="<?php echo esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/icons/course.svg'; ?>">
							<span><?php echo esc_html__( 'My Courses', 'ld-dashboard' ); ?></span>
						</a>
					<?php else : ?>
						<a class="mobile-menu-link" href="<?php echo esc_url( $dashboard_page ) . '?tab=enrolled-courses'; ?>">
							<img src="<?php echo esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/icons/course.svg'; ?>">
							<span><?php echo esc_html__( 'Enrolled Courses', 'ld-dashboard' ); ?></span>
						</a>
					<?php endif; ?>
					<a class="mobile-menu-link" href="<?php echo esc_url( $dashboard_page ) . '?tab=profile'; ?>">
						<img src="<?php echo esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/icons/user-alt.svg'; ?>">
						<span><?php echo esc_html__( 'My Profile', 'ld-dashboard' ); ?></span>
					</a>
					<a id="ld-dashboard-menu" class="mobile-menu-link" href="#">
						<img src="<?php echo esc_url( LD_DASHBOARD_PLUGIN_URL ) . 'public/img/icons/bars.svg'; ?>">
						<span><?php echo esc_html__( 'Menu', 'ld-dashboard' ); ?></span>
					</a>
				</div>
			</div>
			<div class="ld-dashboard-location">
				<?php
				$menu_items = ld_dashboard_get_sidebar_tabs();
				if ( $menu_items && ! empty( $menu_items ) ) :
					echo '<ul class="ld-dashboard-left-panel">';
					$section = array();
					foreach ( $menu_items as $slug => $items ) :
						if ( ! in_array( $slug, array( 'all', 'both', 'instructor' ) ) ) {
							continue;
						}
						if ( ! empty( $section ) && ! in_array( $slug, $section ) ) {
							?>
								<li class="ld-dashboard-menu-divider"></li>
							<?php
						}
						if ( 'instructor' === $slug ) {
							$role_slug = '';
							if ( learndash_is_group_leader_user( $user_id ) && ! in_array( 'ld_instructor', (array) $current_user->roles ) ) {
								$role_slug = LearnDash_Custom_Label::get_label( 'group_leader' );
							} elseif ( in_array( 'ld_instructor', (array) $current_user->roles ) || learndash_is_admin_user( $user_id ) ) {
								$role_slug = esc_html__( 'Instructor', 'ld-dashboard' );
							}
							?>
								<li class="ld-dashboard-menu-divider-label ld-dashboard-label-color"><?php echo esc_html( $role_slug ); ?></li>
							<?php
						}
						foreach ( $items as $tb => $item ) :
							$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '';
							if ( apply_filters( 'ld_dashboard_sidebar_tab_set', false, $slug, $tb ) ) {
								continue;
							}
							?>
							<li class="ld-dashboard-menu-tab <?php echo ( $active_tab == $tb ) ? 'ld-dashboard-active' : ''; ?> <?php echo ( ! isset( $_GET['tab'] ) && 'my-dashboard' == $tb ) ? 'ld-dashboard-active' : ''; ?> "> 
								<a class="<?php echo esc_attr( 'ld-focus-menu-link ld-focus-menu-' . $slug ); ?>" href="<?php echo ( isset( $item['url'] ) ) ? esc_url( $item['url'] ) : ''; ?>">
									<div class="ld-dashboard-menu-icon"><?php echo ( isset( $item['icon'] ) ) ? wp_kses_post( $item['icon'] ) : ''; ?></div>
								<?php echo ( isset( $item['label'] ) ) ? esc_html( $item['label'] ) : ''; ?>
								</a>
							</li>
							<?php
						endforeach;
						$section[] = $slug;
					endforeach;
					echo '</ul>';
					endif;
				?>
			</div>
		</section>
		<?php do_action( 'ld_dashboard_after_profile_section' ); ?>
	</div>
