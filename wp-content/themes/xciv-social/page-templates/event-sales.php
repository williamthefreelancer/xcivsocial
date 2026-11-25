<?php
/**
 * Template Name: Event Sales
 * Public ticket / upsell sales page — share this link when ready to sell.
 *
 * @package XCIV_Social
 */

use XCIV\Theme\Support\OnlineEventFunnel;

get_header();

$event   = OnlineEventFunnel::event();
$tickets = OnlineEventFunnel::tickets();
$addons  = OnlineEventFunnel::addons();
$upsells = OnlineEventFunnel::upsells();
$thanks  = home_url( (string) $event['thanks_path'] );
$share   = home_url( (string) $event['sales_path'] );
?>
<main id="main" class="xciv-shell xciv-funnel xciv-funnel--sales" data-xciv-event-sales data-thanks-url="<?php echo esc_url( $thanks ); ?>">
	<header class="xciv-funnel__hero">
		<p class="xciv-funnel__eyebrow"><?php esc_html_e( 'Online event · Ticket sales', 'xciv-social' ); ?></p>
		<h1><?php echo esc_html( (string) $event['title'] ); ?></h1>
		<p class="xciv-funnel__lede"><?php echo esc_html( (string) $event['subtitle'] ); ?></p>
		<ul class="xciv-funnel__meta" aria-label="<?php esc_attr_e( 'Event details', 'xciv-social' ); ?>">
			<li><?php echo esc_html( (string) $event['date_label'] ); ?></li>
			<li><?php echo esc_html( (string) $event['time_label'] ); ?></li>
			<li><?php echo esc_html( (string) $event['format'] ); ?></li>
			<li>
				<?php
				printf(
					/* translators: %d: seats remaining */
					esc_html__( '%d seats left', 'xciv-social' ),
					(int) $event['seats_left']
				);
				?>
			</li>
		</ul>
		<div class="xciv-funnel__share">
			<label class="xciv-funnel__share-label" for="xciv-sales-share-url"><?php esc_html_e( 'Share your sales link', 'xciv-social' ); ?></label>
			<div class="xciv-funnel__share-row">
				<input id="xciv-sales-share-url" type="url" readonly value="<?php echo esc_attr( $share ); ?>" data-share-url>
				<button type="button" class="xciv-btn xciv-btn--ghost" data-copy-share><?php esc_html_e( 'Copy link', 'xciv-social' ); ?></button>
			</div>
			<p class="xciv-muted xciv-funnel__share-hint" data-copy-status hidden></p>
		</div>
	</header>

	<div class="xciv-funnel__layout">
		<div class="xciv-funnel__primary">
			<section class="xciv-panel" aria-labelledby="xciv-tickets-heading">
				<header class="xciv-panel__head">
					<h2 id="xciv-tickets-heading" class="xciv-panel__title"><?php esc_html_e( 'Choose your ticket', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Pick a tier — add-ons and upsells stack on the next step.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body xciv-ticket-grid" data-ticket-grid role="radiogroup" aria-labelledby="xciv-tickets-heading">
					<?php foreach ( $tickets as $ticket ) : ?>
						<label class="xciv-ticket<?php echo ! empty( $ticket['popular'] ) ? ' xciv-ticket--popular' : ''; ?>">
							<input
								type="radio"
								name="ticket"
								value="<?php echo esc_attr( (string) $ticket['id'] ); ?>"
								data-ticket-id="<?php echo esc_attr( (string) $ticket['id'] ); ?>"
								data-ticket-name="<?php echo esc_attr( (string) $ticket['name'] ); ?>"
								data-ticket-price="<?php echo esc_attr( (string) $ticket['price'] ); ?>"
								<?php checked( ! empty( $ticket['popular'] ) ); ?>
							>
							<span class="xciv-ticket__body">
								<?php if ( ! empty( $ticket['popular'] ) ) : ?>
									<span class="xciv-ticket__badge"><?php esc_html_e( 'Most selected', 'xciv-social' ); ?></span>
								<?php endif; ?>
								<span class="xciv-ticket__name"><?php echo esc_html( (string) $ticket['name'] ); ?></span>
								<span class="xciv-ticket__price">$<?php echo esc_html( (string) $ticket['price'] ); ?></span>
								<span class="xciv-ticket__desc"><?php echo esc_html( (string) $ticket['desc'] ); ?></span>
							</span>
						</label>
					<?php endforeach; ?>
				</div>
			</section>

			<section class="xciv-panel" aria-labelledby="xciv-addons-heading">
				<header class="xciv-panel__head">
					<h2 id="xciv-addons-heading" class="xciv-panel__title"><?php esc_html_e( 'Ticket add-ons', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Optional extras that attach to any ticket.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body xciv-addon-list" data-addon-list>
					<?php foreach ( $addons as $addon ) : ?>
						<label class="xciv-addon">
							<input
								type="checkbox"
								name="addons[]"
								value="<?php echo esc_attr( (string) $addon['id'] ); ?>"
								data-addon-id="<?php echo esc_attr( (string) $addon['id'] ); ?>"
								data-addon-name="<?php echo esc_attr( (string) $addon['name'] ); ?>"
								data-addon-price="<?php echo esc_attr( (string) $addon['price'] ); ?>"
							>
							<span class="xciv-addon__body">
								<span class="xciv-addon__name"><?php echo esc_html( (string) $addon['name'] ); ?></span>
								<span class="xciv-addon__price">+$<?php echo esc_html( (string) $addon['price'] ); ?></span>
								<span class="xciv-addon__desc"><?php echo esc_html( (string) $addon['desc'] ); ?></span>
							</span>
						</label>
					<?php endforeach; ?>
				</div>
			</section>

			<section class="xciv-panel" aria-labelledby="xciv-upsells-heading">
				<header class="xciv-panel__head">
					<h2 id="xciv-upsells-heading" class="xciv-panel__title"><?php esc_html_e( 'Upsells', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Offer these when you send the sales link — or surface them on the thank-you page.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body xciv-upsell-list" data-upsell-list>
					<?php foreach ( $upsells as $upsell ) : ?>
						<label class="xciv-upsell">
							<input
								type="checkbox"
								name="upsells[]"
								value="<?php echo esc_attr( (string) $upsell['id'] ); ?>"
								data-upsell-id="<?php echo esc_attr( (string) $upsell['id'] ); ?>"
								data-upsell-name="<?php echo esc_attr( (string) $upsell['name'] ); ?>"
								data-upsell-price="<?php echo esc_attr( (string) $upsell['price'] ); ?>"
							>
							<span class="xciv-upsell__body">
								<span class="xciv-upsell__name"><?php echo esc_html( (string) $upsell['name'] ); ?></span>
								<span class="xciv-upsell__price">
									<?php
									echo (int) $upsell['price'] > 0
										? esc_html( '+$' . (string) $upsell['price'] )
										: esc_html__( 'Free hold', 'xciv-social' );
									?>
								</span>
								<span class="xciv-upsell__desc"><?php echo esc_html( (string) $upsell['desc'] ); ?></span>
							</span>
						</label>
					<?php endforeach; ?>
				</div>
			</section>
		</div>

		<aside class="xciv-funnel__aside">
			<section class="xciv-panel xciv-checkout" data-checkout aria-labelledby="xciv-checkout-heading">
				<header class="xciv-panel__head">
					<h2 id="xciv-checkout-heading" class="xciv-panel__title"><?php esc_html_e( 'Your order', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php echo esc_html( (string) $event['host_short'] ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<ul class="xciv-checkout__lines" data-checkout-lines></ul>
					<div class="xciv-checkout__total">
						<span><?php esc_html_e( 'Total', 'xciv-social' ); ?></span>
						<strong data-checkout-total>$0</strong>
					</div>
					<form class="xciv-checkout__form" data-checkout-form action="<?php echo esc_url( $thanks ); ?>" method="get">
						<label>
							<span><?php esc_html_e( 'Full name', 'xciv-social' ); ?></span>
							<input type="text" name="name" required autocomplete="name" placeholder="<?php esc_attr_e( 'Your name', 'xciv-social' ); ?>">
						</label>
						<label>
							<span><?php esc_html_e( 'Email', 'xciv-social' ); ?></span>
							<input type="email" name="email" required autocomplete="email" placeholder="<?php esc_attr_e( 'you@email.com', 'xciv-social' ); ?>">
						</label>
						<input type="hidden" name="ticket" data-checkout-ticket value="">
						<input type="hidden" name="addons" data-checkout-addons value="">
						<input type="hidden" name="upsells" data-checkout-upsells value="">
						<input type="hidden" name="total" data-checkout-total-input value="0">
						<button type="submit" class="xciv-btn xciv-btn--primary xciv-checkout__submit"><?php esc_html_e( 'Continue to confirmation', 'xciv-social' ); ?></button>
					</form>
					<p class="xciv-muted xciv-checkout__note"><?php esc_html_e( 'Demo checkout — no payment processed. Confirmation opens the thank-you page with your broadcast link.', 'xciv-social' ); ?></p>
				</div>
			</section>
		</aside>
	</div>
</main>
<?php
get_footer();
