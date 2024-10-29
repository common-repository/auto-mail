<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Handle all pagination
 *
 * @since 1.0
 *
 * @param int $total - the total records
 * @param string $type - The type of page (listings or entries)
 *
 * @return string
 */
function auto_mail_list_pagination( $total, $type = 'listings' ) {
	$pagenum     = isset( $_REQUEST['paged'] ) ? absint( $_REQUEST['paged'] ) : 0; // phpcs:ignore
	$page_number = max( 1, $pagenum );
    $global_settings = get_option('auto_mail_global_settings');
    $per_page = isset($global_settings['auto-mail-campaign-per-page']) ? $global_settings['auto-mail-campaign-per-page'] : 10;
    if ( $total > $per_page ) {
		$removable_query_args = wp_removable_query_args();

		$current_url   = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		$current_url   = remove_query_arg( $removable_query_args, $current_url );
		$current       = $page_number + 1;
		$total_pages   = ceil( $total / $per_page );
		$total_pages   = absint( $total_pages );
		$disable_first = false;
		$disable_last  = false;
		$disable_prev  = false;
		$disable_next  = false;
		$mid_size      = 2;
		$end_size      = 1;
		$show_skip     = false;

		if ( $total_pages > 10 ) {
			$show_skip = true;
		}

		if ( $total_pages >= 4 ) {
			$disable_prev = true;
			$disable_next = true;
		}

		if ( 1 === $page_number ) {
			$disable_first = true;
		}

		if ( $page_number === $total_pages ) {
			$disable_last = true;

		}

		?>
		<ul class="auto-mail-pagination">

			<?php if ( ! $disable_first ) : ?>
				<?php
				$prev_url  = esc_url( add_query_arg( 'paged', min( $total_pages, $page_number - 1 ), $current_url ) );
				$first_url = esc_url( add_query_arg( 'paged', min( 1, $total_pages ), $current_url ) );
				?>
				<?php if ( $show_skip ) : ?>
					<li class="auto-mail-pagination--prev">
						<a href="<?php echo esc_attr( $first_url ); ?>"><i class="auto-mail-icon-arrow-skip-start" aria-hidden="true"></i></a>
					</li>
				<?php endif; ?>
				<?php if ( $disable_prev ) : ?>
					<li class="auto-mail-pagination--prev">
						<a href="<?php echo esc_attr( $prev_url ); ?>"><i class="auto-mail-icon-chevron-left" aria-hidden="true"></i></a>
					</li>
				<?php endif; ?>
			<?php endif; ?>
			<?php
			$dots = false;
			for ( $i = 1; $i <= $total_pages; $i ++ ) :
				$class = ( $page_number === $i ) ? 'auto-mail-active' : '';
				$url   = esc_url( add_query_arg( 'paged', ( $i ), $current_url ) );
				if ( ( $i <= $end_size || ( $current && $i >= $current - $mid_size && $i <= $current + $mid_size ) || $i > $total_pages - $end_size ) ) {
					?>
					<li class="<?php echo esc_attr( $class ); ?>"><a href="<?php echo esc_attr( $url ); ?>" class="<?php echo esc_attr( $class ); ?>"><?php echo esc_html( $i ); ?></a></li>
					<?php
					$dots = true;
				} elseif ( $dots ) {
					?>
					<li class="auto-mail-pagination-dots"><span><?php esc_html_e( '&hellip;' ); ?></span></li>
					<?php
					$dots = false;
				}

				?>

			<?php endfor; ?>

			<?php if ( ! $disable_last ) : ?>
				<?php
				$next_url = esc_url( add_query_arg( 'paged', min( $total_pages, $page_number + 1 ), $current_url ) );
				$last_url = esc_url( add_query_arg( 'paged', max( $total_pages, $page_number - 1 ), $current_url ) );
				?>
				<?php if ( $disable_next ) : ?>
					<li class="auto-mail-pagination--next">
						<a href="<?php echo esc_attr( $next_url ); ?>"><i class="auto-mail-icon-chevron-right" aria-hidden="true"></i></a>
					</li>
				<?php endif; ?>
				<?php if ( $show_skip ) : ?>
					<li class="auto-mail-pagination--next">
						<a href="<?php echo esc_attr( $last_url ); ?>"><i class="auto-mail-icon-arrow-skip-end" aria-hidden="true"></i></a>
					</li>
				<?php endif; ?>
			<?php endif; ?>
		</ul>
		<?php
	}
}

/**
 * Central per page for form view
 *
 * @since 1.0.0
 * @return int
 */
function auto_mail_form_view_per_page( $type = 'listings' ) {

    $global_settings = get_option('auto_mail_global_settings');
    $per_page = isset($global_settings['auto-mail-campaign-per-page']) ? $global_settings['auto-mail-campaign-per-page'] : 10;

	// force at least 1 data per page
	if ( $per_page < 1 ) {
		$per_page = 1;
	}
	return apply_filters( 'auto_mail_form_per_page', $per_page, $type );
}

/**
 * Central per page for form view
 *
 * @since 1.0.0
 * @return string
 */
function auto_mail_get_campaign_name($id){

	$model = Auto_Mail_Campaign_Model::model()->load( $id );

    // Return Campaign Name
	if ( ! empty( $model->name ) ) {
		return $model->name;
	}
}

/**
 * Central per page for form view
 *
 * @since 1.0.0
 * @return string
 */
function auto_mail_get_form_name($id){

	$model = Auto_Mail_Form_Model::model()->load( $id );

	$settings = $model->settings;

    // Return Campaign Name
	if ( ! empty( $settings['auto_mail_form_name'] ) ) {
		return $settings['auto_mail_form_name'];
	}
}

/**
 * Central per page for list view
 *
 * @since 1.0.0
 * @return string
 */
function auto_mail_get_list_name($id){

	$model = Auto_Mail_List_Model::model()->load( $id );

	$settings = $model->settings;

    // Return List Name
	if ( ! empty( $settings['auto_mail_list_name'] ) ) {
		return $settings['auto_mail_list_name'];
	}
}

/**
 * Get subscriber name
 *
 * @since 1.0.0
 * @return string
 */
function auto_mail_get_subscriber_email($id){

	$model = Auto_Mail_Subscriber_Model::model()->load( $id );

	$settings = $model->settings;

    // Return Campaign Name
	if ( ! empty( $settings['email_address'] ) ) {
		return $settings['email_address'];
	}
}

/**
 * Get subscriber name
 *
 * @since 1.0.0
 * @return string
 */
function auto_mail_get_subscriber_name($id){

	$model = Auto_Mail_Subscriber_Model::model()->load( $id );

	$settings = $model->settings;

    // Return Campaign Name
	if ( ! empty( $settings['first_name'] ) ) {
		return $settings['first_name'];
	}
}

/**
 * Get subscriber count by status
 *
 * @since 1.0.0
 * @return string
 */
function auto_mail_subscribers_count_by_status($status){
	$all_models = Auto_Mail_Subscriber_Model::model()->get_all_models( $status );
	return count($all_models['models']);
}

/**
 * Central per page for automation view
 *
 * @since 1.0.0
 * @return string
 */
function auto_mail_get_automation_name($id){

	$model = Auto_Mail_Automation_Model::model()->load( $id );

	$settings = $model->settings;

    // Return Automation Name
	if ( ! empty( $settings['am_automation_name'] ) ) {
		return $settings['am_automation_name'];
	}
}