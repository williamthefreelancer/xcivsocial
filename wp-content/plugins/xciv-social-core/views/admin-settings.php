<?php
/**
 * Settings form with tabs.
 *
 * @package XCIV_Social_Core
 * @var array<string, mixed>  $settings
 * @var string                $tab
 * @var array<string, string> $tabs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$option = \XCIV\Core\Admin\SettingsStore::OPTION_KEY;
$g      = $settings['general'];
$e      = $settings['event'];
$d      = $settings['dashboard'];
$p      = $settings['payments'];
?>
<div class="wrap xciv-admin xciv-admin--settings">
	<header class="xciv-admin__hero xciv-admin__hero--compact">
		<div>
			<p class="xciv-admin__eyebrow"><?php esc_html_e( 'XCIV Social', 'xciv-social-core' ); ?></p>
			<h1><?php esc_html_e( 'Settings', 'xciv-social-core' ); ?></h1>
			<p class="xciv-admin__lede">
				<?php esc_html_e( 'Configure the online event funnel, ticket catalog, member briefing, and payments.', 'xciv-social-core' ); ?>
			</p>
		</div>
		<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social' ) ); ?>">
			<?php esc_html_e( '← Dashboard', 'xciv-social-core' ); ?>
		</a>
	</header>

	<?php settings_errors(); ?>

	<nav class="xciv-admin__tabs" aria-label="<?php esc_attr_e( 'Settings sections', 'xciv-social-core' ); ?>">
		<?php foreach ( $tabs as $slug => $label ) : ?>
			<a
				class="xciv-admin__tab<?php echo $tab === $slug ? ' is-active' : ''; ?>"
				href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-settings&tab=' . rawurlencode( $slug ) ) ); ?>"
			>
				<?php echo esc_html( $label ); ?>
			</a>
		<?php endforeach; ?>
	</nav>

	<form method="post" action="options.php" class="xciv-admin__form" data-xciv-settings-form>
		<?php settings_fields( 'xciv_social_settings_group' ); ?>
		<input type="hidden" name="<?php echo esc_attr( $option ); ?>[_active_tab]" value="<?php echo esc_attr( $tab ); ?>">

		<?php if ( 'general' === $tab ) : ?>
			<section class="xciv-admin__card">
				<header class="xciv-admin__card-head">
					<h2><?php esc_html_e( 'General', 'xciv-social-core' ); ?></h2>
					<p><?php esc_html_e( 'Brand and support defaults used across the theme.', 'xciv-social-core' ); ?></p>
				</header>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="xciv-community-name"><?php esc_html_e( 'Community name', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" id="xciv-community-name" name="<?php echo esc_attr( $option ); ?>[general][community_name]" value="<?php echo esc_attr( (string) $g['community_name'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-host-company"><?php esc_html_e( 'Host company', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" id="xciv-host-company" name="<?php echo esc_attr( $option ); ?>[general][host_company]" value="<?php echo esc_attr( (string) $g['host_company'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-host-short"><?php esc_html_e( 'Host short name', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" id="xciv-host-short" name="<?php echo esc_attr( $option ); ?>[general][host_short]" value="<?php echo esc_attr( (string) $g['host_short'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-support-email"><?php esc_html_e( 'Support email', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" type="email" id="xciv-support-email" name="<?php echo esc_attr( $option ); ?>[general][support_email]" value="<?php echo esc_attr( (string) $g['support_email'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-currency"><?php esc_html_e( 'Currency symbol', 'xciv-social-core' ); ?></label></th>
						<td><input class="small-text" id="xciv-currency" name="<?php echo esc_attr( $option ); ?>[general][currency_symbol]" value="<?php echo esc_attr( (string) $g['currency_symbol'] ); ?>" maxlength="3"></td>
					</tr>
				</table>
			</section>
		<?php endif; ?>

		<?php if ( 'event' === $tab ) : ?>
			<section class="xciv-admin__card">
				<header class="xciv-admin__card-head">
					<h2><?php esc_html_e( 'Online event', 'xciv-social-core' ); ?></h2>
					<p><?php esc_html_e( 'Powers sales, thank-you, and broadcast pages.', 'xciv-social-core' ); ?></p>
				</header>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="xciv-event-title"><?php esc_html_e( 'Title', 'xciv-social-core' ); ?></label></th>
						<td><input class="large-text" id="xciv-event-title" name="<?php echo esc_attr( $option ); ?>[event][title]" value="<?php echo esc_attr( (string) $e['title'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-subtitle"><?php esc_html_e( 'Subtitle', 'xciv-social-core' ); ?></label></th>
						<td><textarea class="large-text" rows="3" id="xciv-event-subtitle" name="<?php echo esc_attr( $option ); ?>[event][subtitle]"><?php echo esc_textarea( (string) $e['subtitle'] ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-date"><?php esc_html_e( 'Date label', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" id="xciv-event-date" name="<?php echo esc_attr( $option ); ?>[event][date_label]" value="<?php echo esc_attr( (string) $e['date_label'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-time"><?php esc_html_e( 'Time label', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" id="xciv-event-time" name="<?php echo esc_attr( $option ); ?>[event][time_label]" value="<?php echo esc_attr( (string) $e['time_label'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-format"><?php esc_html_e( 'Format', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" id="xciv-event-format" name="<?php echo esc_attr( $option ); ?>[event][format]" value="<?php echo esc_attr( (string) $e['format'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-meet"><?php esc_html_e( 'Google Meet URL', 'xciv-social-core' ); ?></label></th>
						<td>
							<input class="large-text" type="url" id="xciv-event-meet" name="<?php echo esc_attr( $option ); ?>[event][meet_url]" value="<?php echo esc_attr( (string) $e['meet_url'] ); ?>" placeholder="https://meet.google.com/...">
							<p class="description"><?php esc_html_e( 'Used on the broadcast room. Replace the demo lookup link before go-live.', 'xciv-social-core' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-capacity"><?php esc_html_e( 'Capacity', 'xciv-social-core' ); ?></label></th>
						<td><input class="small-text" type="number" min="0" id="xciv-event-capacity" name="<?php echo esc_attr( $option ); ?>[event][capacity]" value="<?php echo esc_attr( (string) $e['capacity'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-seats"><?php esc_html_e( 'Seats left', 'xciv-social-core' ); ?></label></th>
						<td><input class="small-text" type="number" min="0" id="xciv-event-seats" name="<?php echo esc_attr( $option ); ?>[event][seats_left]" value="<?php echo esc_attr( (string) $e['seats_left'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-id"><?php esc_html_e( 'Event ID', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" id="xciv-event-id" name="<?php echo esc_attr( $option ); ?>[event][id]" value="<?php echo esc_attr( (string) $e['id'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-slug"><?php esc_html_e( 'Slug', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" id="xciv-event-slug" name="<?php echo esc_attr( $option ); ?>[event][slug]" value="<?php echo esc_attr( (string) $e['slug'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-sales"><?php esc_html_e( 'Sales path', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" id="xciv-event-sales" name="<?php echo esc_attr( $option ); ?>[event][sales_path]" value="<?php echo esc_attr( (string) $e['sales_path'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-thanks"><?php esc_html_e( 'Thank-you path', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" id="xciv-event-thanks" name="<?php echo esc_attr( $option ); ?>[event][thanks_path]" value="<?php echo esc_attr( (string) $e['thanks_path'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-event-broadcast"><?php esc_html_e( 'Broadcast path', 'xciv-social-core' ); ?></label></th>
						<td><input class="regular-text" id="xciv-event-broadcast" name="<?php echo esc_attr( $option ); ?>[event][broadcast_path]" value="<?php echo esc_attr( (string) $e['broadcast_path'] ); ?>"></td>
					</tr>
				</table>
			</section>
		<?php endif; ?>

		<?php if ( 'tickets' === $tab ) : ?>
			<section class="xciv-admin__card">
				<header class="xciv-admin__card-head">
					<div>
						<h2><?php esc_html_e( 'Ticket tiers', 'xciv-social-core' ); ?></h2>
						<p><?php esc_html_e( 'Shown as the primary choice on the event sales page.', 'xciv-social-core' ); ?></p>
					</div>
					<button type="button" class="button" data-xciv-add-row data-type="tickets"><?php esc_html_e( 'Add ticket', 'xciv-social-core' ); ?></button>
				</header>
				<div class="xciv-admin__repeater" data-xciv-repeater="tickets">
					<?php foreach ( $settings['tickets'] as $i => $ticket ) : ?>
						<?php include XCIV_CORE_DIR . 'views/partials/settings-ticket-row.php'; ?>
					<?php endforeach; ?>
				</div>
				<template id="xciv-tpl-tickets">
					<?php
					$i      = '{{INDEX}}';
					$ticket = array(
						'id'      => '',
						'name'    => '',
						'price'   => 0,
						'desc'    => '',
						'popular' => false,
					);
					include XCIV_CORE_DIR . 'views/partials/settings-ticket-row.php';
					?>
				</template>
			</section>
		<?php endif; ?>

		<?php if ( 'addons' === $tab ) : ?>
			<section class="xciv-admin__card">
				<header class="xciv-admin__card-head">
					<div>
						<h2><?php esc_html_e( 'Ticket add-ons', 'xciv-social-core' ); ?></h2>
						<p><?php esc_html_e( 'Optional extras that stack onto any ticket.', 'xciv-social-core' ); ?></p>
					</div>
					<button type="button" class="button" data-xciv-add-row data-type="addons"><?php esc_html_e( 'Add add-on', 'xciv-social-core' ); ?></button>
				</header>
				<div class="xciv-admin__repeater" data-xciv-repeater="addons">
					<?php foreach ( $settings['addons'] as $i => $addon ) : ?>
						<?php include XCIV_CORE_DIR . 'views/partials/settings-addon-row.php'; ?>
					<?php endforeach; ?>
				</div>
				<template id="xciv-tpl-addons">
					<?php
					$i     = '{{INDEX}}';
					$addon = array(
						'id'    => '',
						'name'  => '',
						'price' => 0,
						'desc'  => '',
					);
					include XCIV_CORE_DIR . 'views/partials/settings-addon-row.php';
					?>
				</template>
			</section>
		<?php endif; ?>

		<?php if ( 'upsells' === $tab ) : ?>
			<section class="xciv-admin__card">
				<header class="xciv-admin__card-head">
					<div>
						<h2><?php esc_html_e( 'Upsells', 'xciv-social-core' ); ?></h2>
						<p><?php esc_html_e( 'Offers on the sales page and thank-you confirmation.', 'xciv-social-core' ); ?></p>
					</div>
					<button type="button" class="button" data-xciv-add-row data-type="upsells"><?php esc_html_e( 'Add upsell', 'xciv-social-core' ); ?></button>
				</header>
				<div class="xciv-admin__repeater" data-xciv-repeater="upsells">
					<?php foreach ( $settings['upsells'] as $i => $upsell ) : ?>
						<?php include XCIV_CORE_DIR . 'views/partials/settings-upsell-row.php'; ?>
					<?php endforeach; ?>
				</div>
				<template id="xciv-tpl-upsells">
					<?php
					$i      = '{{INDEX}}';
					$upsell = array(
						'id'    => '',
						'name'  => '',
						'price' => 0,
						'desc'  => '',
						'cta'   => 'Add',
					);
					include XCIV_CORE_DIR . 'views/partials/settings-upsell-row.php';
					?>
				</template>
			</section>
		<?php endif; ?>

		<?php if ( 'dashboard' === $tab ) : ?>
			<section class="xciv-admin__card">
				<header class="xciv-admin__card-head">
					<h2><?php esc_html_e( 'Member dashboard', 'xciv-social-core' ); ?></h2>
					<p><?php esc_html_e( 'Featured briefing video on /dashboard/.', 'xciv-social-core' ); ?></p>
				</header>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="xciv-briefing-url"><?php esc_html_e( 'Briefing video URL', 'xciv-social-core' ); ?></label></th>
						<td>
							<input class="large-text" type="url" id="xciv-briefing-url" name="<?php echo esc_attr( $option ); ?>[dashboard][briefing_url]" value="<?php echo esc_attr( (string) $d['briefing_url'] ); ?>" placeholder="https://www.youtube.com/watch?v=… or Bunny embed URL">
							<p class="description"><?php esc_html_e( 'YouTube, Vimeo, or Bunny Stream watch / share / embed URL.', 'xciv-social-core' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-briefing-title"><?php esc_html_e( 'Briefing title', 'xciv-social-core' ); ?></label></th>
						<td><input class="large-text" id="xciv-briefing-title" name="<?php echo esc_attr( $option ); ?>[dashboard][briefing_title]" value="<?php echo esc_attr( (string) $d['briefing_title'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-briefing-desc"><?php esc_html_e( 'Briefing description', 'xciv-social-core' ); ?></label></th>
						<td><textarea class="large-text" rows="3" id="xciv-briefing-desc" name="<?php echo esc_attr( $option ); ?>[dashboard][briefing_desc]"><?php echo esc_textarea( (string) $d['briefing_desc'] ); ?></textarea></td>
					</tr>
				</table>
			</section>
		<?php endif; ?>

		<?php if ( 'payments' === $tab ) : ?>
			<section class="xciv-admin__card">
				<header class="xciv-admin__card-head">
					<h2><?php esc_html_e( 'Payments', 'xciv-social-core' ); ?></h2>
					<p><?php esc_html_e( 'Checkout currently supports demo mode; Stripe keys are stored for go-live.', 'xciv-social-core' ); ?></p>
				</header>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Mode', 'xciv-social-core' ); ?></th>
						<td>
							<label>
								<input type="radio" name="<?php echo esc_attr( $option ); ?>[payments][mode]" value="demo" <?php checked( (string) $p['mode'], 'demo' ); ?>>
								<?php esc_html_e( 'Demo (no charge — current funnel)', 'xciv-social-core' ); ?>
							</label><br>
							<label>
								<input type="radio" name="<?php echo esc_attr( $option ); ?>[payments][mode]" value="stripe" <?php checked( (string) $p['mode'], 'stripe' ); ?>>
								<?php esc_html_e( 'Stripe (keys required)', 'xciv-social-core' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-stripe-pub"><?php esc_html_e( 'Stripe publishable key', 'xciv-social-core' ); ?></label></th>
						<td><input class="large-text" id="xciv-stripe-pub" name="<?php echo esc_attr( $option ); ?>[payments][stripe_publishable]" value="<?php echo esc_attr( (string) $p['stripe_publishable'] ); ?>" autocomplete="off"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-stripe-sec"><?php esc_html_e( 'Stripe secret key', 'xciv-social-core' ); ?></label></th>
						<td><input class="large-text" type="password" id="xciv-stripe-sec" name="<?php echo esc_attr( $option ); ?>[payments][stripe_secret]" value="<?php echo esc_attr( (string) $p['stripe_secret'] ); ?>" autocomplete="off"></td>
					</tr>
					<tr>
						<th scope="row"><label for="xciv-checkout-note"><?php esc_html_e( 'Checkout note', 'xciv-social-core' ); ?></label></th>
						<td><textarea class="large-text" rows="2" id="xciv-checkout-note" name="<?php echo esc_attr( $option ); ?>[payments][checkout_success_note]"><?php echo esc_textarea( (string) $p['checkout_success_note'] ); ?></textarea></td>
					</tr>
				</table>
			</section>
		<?php endif; ?>

		<?php submit_button( __( 'Save settings', 'xciv-social-core' ) ); ?>
	</form>
</div>
