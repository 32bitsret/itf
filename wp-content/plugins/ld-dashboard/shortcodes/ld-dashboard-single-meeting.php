<?php

function ld_dashboard_meeting_single_callback( $atts ) {
	ob_start();
	if ( false !== Ld_Dashboard_Public::template_override_exists( 'ld-dashboard-single-meeting.php' ) ) {
		include Ld_Dashboard_Public::template_override_exists( 'ld-dashboard-single-meeting.php' );
		return ob_get_clean();
	}
	if ( isset( $atts['id'] ) ) {
		$current_user               = wp_get_current_user();
		$function_obj               = Ld_Dashboard_Functions::instance();
		$ld_dashboard_settings_data = $function_obj->ld_dashboard_settings_data();
		$settings                   = $ld_dashboard_settings_data['zoom_meeting_settings'];
		$meeting_id                 = $atts['id'];
		$title                      = ( isset( $atts['title'] ) && '' !== $atts['title'] ) ? $atts['title'] : esc_html__( 'Details', 'ld-dashboard' );
		$zoom_meeting_id            = get_post_meta( $meeting_id, 'zoom_meeting_id', true );
		$meeting                    = get_post_meta( $meeting_id, 'zoom_meeting_response', true );
		$start_url                  = get_post_meta( $meeting_id, 'zoom_meeting_start_url', true );

		if ( is_object( $meeting ) && property_exists( $meeting, 'id' ) ) {
			$start_time     = gmdate( 'M d Y h:i A', ld_get_local_time_difference( $meeting->start_time ) );
			$date_input_val = gmdate( 'F d, Y h:i:s', strtotime( $start_time ) );
			$current_time   = gmdate( 'M d Y h:i A' );
			if ( $meeting->duration > 59 ) {
				$min = $meeting->duration % 60;
				$hr  = $meeting->duration - $min;
				$hr  = $meeting->duration / 60;
			} else {
				$hr  = 0;
				$min = $meeting->duration;
			}
			?>
			<div class="ld-dashboard-single-meeting-shortcode-wrapper">
				<div class="ld-dashboard-single-meeting-shortcode-content-left-area">
					<div class="ld-dashboard-meeting-sidebar-tile">
						<?php echo esc_html( $meeting->agenda ); ?>
					</div>
				</div>
				<div class="ld-dashboard-single-meeting-shortcode-content-right-area">
					<div class="ld-dashboard-single-meeting-shortcode-content">
						<?php if ( strtotime( $current_time ) < strtotime( $start_time ) ) : ?>
						<div class="ld-dashboard-meeting-countdown-wrap">
							<div class="ld-dashboard-meeting-countdown-grid"><span class="ld-dashboard-meeting-countdown-days">0</span><span><?php echo esc_html__( 'Days', 'ld-dashboard' ); ?></span></div>
							<div class="ld-dashboard-meeting-countdown-grid"><span class="ld-dashboard-meeting-countdown-hours">0</span><span><?php echo esc_html__( 'Hours', 'ld-dashboard' ); ?></span></div>
							<div class="ld-dashboard-meeting-countdown-grid"><span class="ld-dashboard-meeting-countdown-minutes">0</span><span><?php echo esc_html__( 'Minutes', 'ld-dashboard' ); ?></span></div>
							<div class="ld-dashboard-meeting-countdown-grid"><span class="ld-dashboard-meeting-countdown-seconds">0</span><span><?php echo esc_html__( 'Seconds', 'ld-dashboard' ); ?></span></div>
						</div>
						<?php endif; ?>
						<div class="ld-dashboard-meeting-hosted-by-list-wrap">
							<div class="ld-dashboard-meeting-hosted-details">
								<div class="ld-dashboard-meeting-hosted-by-list-item">
									<span><strong><?php echo esc_html__( 'Topic:', 'ld-dashboard' ); ?></strong></span>
									<span><?php echo esc_html( $meeting->topic ); ?></span>
								</div>
								<div class="ld-dashboard-meeting-hosted-by-list-item">
									<span><strong><?php echo esc_html__( 'Start:', 'ld-dashboard' ); ?></strong></span>
									<input type="hidden" class="ld-dashboard-single-meeting-end-time" value="<?php echo esc_attr( $date_input_val ); ?>">
									<span><?php echo esc_html( $start_time ); ?></span>
								</div>
								<div class="ld-dashboard-meeting-hosted-by-list-item">
									<span><strong><?php echo esc_html__( 'Duration:', 'ld-dashboard' ); ?></strong></span>
									<span><?php printf( '%d hrs %d min', esc_html( $hr ), esc_html( $min ) ); ?></span>
								</div>
								<div class="ld-dashboard-meeting-hosted-by-list-item">
									<span><strong><?php echo esc_html__( 'Timezone:', 'ld-dashboard' ); ?></strong></span>
									<span><?php echo esc_html( $meeting->timezone ); ?></span>
								</div>
								<div class="ld-dashboard-meeting-actions">
								<?php if ( property_exists( $meeting, 'start_url' ) && ( in_array( 'administrator', $current_user->roles ) || in_array( 'ld_instructor', $current_user->roles ) ) && ld_dashboard_can_user_start_meeting( $meeting_id ) ) : ?>
									<div class="ld-dashboard-meeting-action">
										<a href="<?php echo esc_url( $start_url ); ?>"><?php echo esc_html__( 'Start', 'ld-dashboard' ); ?></a>
									</div>
									<?php endif; ?>
								<?php if ( property_exists( $meeting, 'join_url' ) ) : ?>
									<div class="ld-dashboard-meeting-action">
										<a href="<?php echo esc_url( $meeting->join_url ); ?>"><?php echo esc_html__( 'Join', 'ld-dashboard' ); ?></a>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
				if ( jQuery('.ld-dashboard-single-meeting-end-time').length ) {
					let endDate = jQuery('.ld-dashboard-single-meeting-end-time').val();
					var countDownDate = new Date(endDate).getTime();
					var zoom_meeting_countdown = setInterval(function() {
						var now = new Date().getTime();
						var timeleft = countDownDate - now;
						var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
						var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
						var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
						var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

						jQuery(".ld-dashboard-meeting-countdown-days").html(days);
						jQuery(".ld-dashboard-meeting-countdown-hours").html(hours);
						jQuery(".ld-dashboard-meeting-countdown-minutes").html(minutes);
						jQuery(".ld-dashboard-meeting-countdown-seconds").html(seconds);
						if (timeleft < 0) {
							clearInterval(zoom_meeting_countdown);
						}
					}, 1000);
				}
			</script>
			<?php
		} else {
			?>
				<p class="ld-dashboard-warning"><?php echo esc_html__( 'Invalid meeting Id.', 'ld-dashboard' ); ?></p>
			<?php
		}
	} else {
		?>
			<p class="ld-dashboard-warning"><?php echo esc_html__( 'Invalid meeting Id.', 'ld-dashboard' ); ?></p>
		<?php
	}
	return ob_get_clean();
}

add_shortcode( 'ld_dashboard_meeting_single', 'ld_dashboard_meeting_single_callback' );
