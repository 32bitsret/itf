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
$settings                   = $ld_dashboard_settings_data['monetization_settings'];
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wbcom-tab-content">
	<div class="wrap ld-dashboard-settings">
		<div class="ld-dashboard-content container">
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php
				settings_fields( 'ld_dashboard_manage_monetization' );
				do_settings_sections( 'ld_dashboard_manage_monetization' );
				?>
				<div class="ld-dashboard-wrapper-admin form-table">
					<div class="monetization-wrapper ld-grid-view-wrapper">
						<div class="ld-dashboard-admin-title-section"><h3><?php esc_html_e( 'Options', 'ld-dashboard' ); ?></h3></div>	
						<?php if ( class_exists( 'WooCommerce' ) && class_exists( 'Learndash_WooCommerce' ) ) : ?>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Enable Selling through WooCommerce', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" class="ld-dashboard-setting" name="ld_dashboard_manage_monetization[monetize_by]" value="1" <?php ( isset( $settings['monetize_by'] ) ) ? checked( $settings['monetize_by'], '1' ) : ''; ?> data-id="monetize_by"/>
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php printf( esc_html__( 'Allow %s to sell through the WooCommerce marketplace.', 'ld-dashboard' ), esc_html( strtolower( LearnDash_Custom_Label::get_label( 'courses' ) ) ) ); ?></span>
							</div>
						</div>
						<?php endif; ?>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Sharing Percentage', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<div class="takes_wrapper">
								<div class="instructor_takes">
								<span><?php echo esc_html__( 'Instructor Takes', 'ld-dashboard' ); ?></span>
								<input type="number" class="ld-dashboard-sharing-percentage-input ld-dashboard-sharing-percentage-instructor" name="ld_dashboard_manage_monetization[sharing-percentage-instructor]" value="<?php echo ( isset( $settings['sharing-percentage-instructor'] ) ) ? esc_attr( $settings['sharing-percentage-instructor'] ) : 0; ?>" />
								</div>
								<div class="instructor_takes">
								<span><?php echo esc_html__( 'Admin Takes', 'ld-dashboard' ); ?></span>
								<input type="number" class="ld-dashboard-sharing-percentage-input ld-dashboard-sharing-percentage-admin" name="ld_dashboard_manage_monetization[sharing-percentage-admin]" value="<?php echo ( isset( $settings['sharing-percentage-admin'] ) ) ? esc_attr( $settings['sharing-percentage-admin'] ) : 0; ?>" />
								</div>
								</div>
								<span class="ld-decription"><?php esc_html_e( 'Set how the sales revenue will be shared among admins and instructors.', 'ld-dashboard' ); ?></span>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Show Statement Per Page', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<input type="number" name="ld_dashboard_manage_monetization[statement-per-page]" value="<?php echo ( isset( $settings['statement-per-page'] ) ) ? esc_attr( $settings['statement-per-page'] ) : 0; ?>" />
								<span class="ld-decription"><?php esc_html_e( 'Define the number of statements to show.', 'ld-dashboard' ); ?></span>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Instructor Earning Chart', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" name="ld_dashboard_manage_monetization[instructor-earning-report]" value="1" <?php ( isset( $settings['instructor-earning-report'] ) ) ? checked( $settings['instructor-earning-report'], '1' ) : ''; ?> />
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php esc_html_e( 'Enable this option if you want to display the instructor earning report on dashboard.', 'ld-dashboard' ); ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="ld-dashboard-wrapper-admin form-table">
					<div class="ld-grid-view-wrapper Welcome-Message-Pannel">
						<div class="ld-dashboard-admin-title-section"><h3><?php esc_html_e( 'Fees', 'ld-dashboard' ); ?></h3></div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Deduct Fees', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<label class="ld-dashboard-setting-switch">
									<input type="checkbox" name="ld_dashboard_manage_monetization[enable-deduct-fees]" value="1" <?php ( isset( $settings['enable-deduct-fees'] ) ) ? checked( $settings['enable-deduct-fees'], '1' ) : ''; ?> />
									<div class="ld-dashboard-setting round"></div>
								</label>
								<span class="ld-decription"><?php esc_html_e( 'Fees are charged from the entire sales amount. The remaining amount will be divided among admin and instructors.', 'ld-dashboard' ); ?></span>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Fee Description', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<textarea name="ld_dashboard_manage_monetization[fee-description]" /><?php echo ( isset( $settings['fee-description'] ) ) ? esc_html( $settings['fee-description'] ) : ''; ?></textarea>
								<span class="ld-decription"><?php esc_html_e( 'Set a description for the fee that you are deducting. Make sure to give a reasonable explanation to maintain transparency with your site`s instructors', 'ld-dashboard' ); ?></span>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Fee Amount & Type', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<div class="ld-fee-type-grid">
								<div class="ld-fee-type">
								<select name="ld_dashboard_manage_monetization[fee-type]">
									<option value="" <?php ( isset( $settings['fee-type'] ) ) ? selected( $settings['fee-type'], '' ) : ''; ?>><?php echo esc_html__( 'Select', 'ld-dashboard' ); ?></option>
									<option value="percent" <?php ( isset( $settings['fee-type'] ) ) ? selected( $settings['fee-type'], 'percent' ) : ''; ?>><?php echo esc_html__( 'Percent', 'ld-dashboard' ); ?></option>
									<option value="fixed" <?php ( isset( $settings['fee-type'] ) ) ? selected( $settings['fee-type'], 'fixed' ) : ''; ?>><?php echo esc_html__( 'Fixed', 'ld-dashboard' ); ?></option>
								</select>
								</div>
								<div class="ld-fee-type">
								<input type="number" name="ld_dashboard_manage_monetization[fee-amount]" value="<?php echo ( isset( $settings['fee-amount'] ) ) ? esc_html( $settings['fee-amount'] ) : 0; ?>" />
								</div>
								</div>

								<span class="ld-decription"><?php esc_html_e( 'Select the fee type and add fee amount/percentage', 'ld-dashboard' ); ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="ld-dashboard-wrapper-admin form-table">
					<div class="ld-grid-view-wrapper Welcome-Message-Pannel">
						<div class="ld-dashboard-admin-title-section"><h3><?php esc_html_e( 'Withdraw', 'ld-dashboard' ); ?></h3></div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Minimum Withdrawal Amount', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<input type="number" name="ld_dashboard_manage_monetization[minimum-withdrawal-amount]" value="<?php echo ( isset( $settings['minimum-withdrawal-amount'] ) ) ? esc_attr( $settings['minimum-withdrawal-amount'] ) : 0; ?>" />
								<span class="ld-decription"><?php esc_html_e( 'Instructors should earn equal to or above this amount to make a withdrawal request.', 'ld-dashboard' ); ?></span>
							</div>
						</div>
						<?php
						/*
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Minimum Days Before Balance is Available', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<input type="number" name="ld_dashboard_manage_monetization[minimum-days-show-balance]" value="<?php echo ( isset( $settings['minimum-days-show-balance'] ) ) ? esc_attr( $settings['minimum-days-show-balance'] ) : 0; ?>" />
								<span class="ld-decription"><?php esc_html_e( 'Any income has to remain this many days in the platform before it is available for withdrawal.', 'ld-dashboard' ); ?></span>
							</div>
						</div>
						*/
						?>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Enable Withdrawal Method', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<div class="withdrawal_options ld-dashboard-setting-sub-fields">
									<div class="ld-dashboard-setting-sub-field-single">										
										<div class="ld-grid-content">											
											<label class="ld-dashboard-setting-switch">
												<input type="checkbox" name="ld_dashboard_manage_monetization[enable-bank-transfer-method]" value="1" <?php ( isset( $settings['enable-bank-transfer-method'] ) ) ? checked( $settings['enable-bank-transfer-method'], '1' ) : ''; ?> />
												<div class="ld-dashboard-setting round"></div>
											</label>
										</div>
										<span class="ld-dashboard-setting-title"><?php echo esc_html__( 'Bank Transfer', 'ld-dashboard' ); ?></span>
									</div>
									<div class="ld-dashboard-setting-sub-field-single">										
										<div class="ld-grid-content">
											<label class="ld-dashboard-setting-switch">
												<input type="checkbox" name="ld_dashboard_manage_monetization[enable-e-check-method]" value="1" <?php ( isset( $settings['enable-e-check-method'] ) ) ? checked( $settings['enable-e-check-method'], '1' ) : ''; ?> />
												<div class="ld-dashboard-setting round"></div>
											</label>
										</div>
										<span class="ld-dashboard-setting-title"><?php echo esc_html__( 'E-Check', 'ld-dashboard' ); ?></span>								
									</div>
									<div class="ld-dashboard-setting-sub-field-single">										
										<div class="ld-grid-content">
											<label class="ld-dashboard-setting-switch">
												<input type="checkbox" name="ld_dashboard_manage_monetization[enable-paypal-method]" value="1" <?php ( isset( $settings['enable-paypal-method'] ) ) ? checked( $settings['enable-paypal-method'], '1' ) : ''; ?> />
												<div class="ld-dashboard-setting round"></div>
											</label>
										</div>
										<span class="ld-dashboard-setting-title"><?php echo esc_html__( 'Paypal', 'ld-dashboard' ); ?></span>								
									</div>
								</div>
								<span class="ld-decription"><?php esc_html_e( 'Set how you would like to withdraw money from the website.', 'ld-dashboard' ); ?></span>
							</div>
						</div>
						<div class="ld-single-grid">
							<div class="ld-grid-label" scope="row">
								<label><?php esc_html_e( 'Bank Instructions', 'ld-dashboard' ); ?></label>
							</div>
							<div class="ld-grid-content">
								<textarea name="ld_dashboard_manage_monetization[bank-instructions]"><?php echo ( isset( $settings['bank-instructions'] ) ) ? esc_html( $settings['bank-instructions'] ) : ''; ?></textarea>
								<span class="ld-decription"><?php esc_html_e( 'Write bank instructions for the instructors to conduct withdrawals.', 'ld-dashboard' ); ?></span>
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
