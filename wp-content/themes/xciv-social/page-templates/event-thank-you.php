<?php
/**
 * Template Name: Event Thank You
 * Post-purchase confirmation with broadcast access + upsell offers.
 *
 * @package XCIV_Social
 */

use XCIV\Theme\Support\OnlineEventFunnel;

get_header();

$event   = OnlineEventFunnel::event();
$upsells = OnlineEventFunnel::upsells();
$tickets = OnlineEventFunnel::tickets();

// phpcs:disable WordPress.Security.NonceVerification.Recommended
$name    = isset( $_GET['name'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['name'] ) ) : '';
$email   = isset( $_GET['email'] ) ? sanitize_email( wp_unslash( (string) $_GET['email'] ) ) : '';
$ticket  = isset( $_GET['ticket'] ) ? sanitize_key( wp_unslash( (string) $_GET['ticket'] ) ) : 'vip';
$addons  = isset( $_GET['addons'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['addons'] ) ) : '';
$upsell_q = isset( $_GET['upsells'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['upsells'] ) ) : '';
$total   = isset( $_GET['total'] ) ? (float) $_GET['total'] : 0;
// phpcs:enable WordPress.Security.NonceVerification.Recommended

$ticket_name = __( 'General Admission', 'xciv-social' );
foreach ( $tickets as $row ) {
	if ( (string) $row['id'] === $ticket ) {
		$ticket_name = (string) $row['name'];
		break;
	}
}

$first = $name ? explode( ' ', $name )[0] : __( 'there', 'xciv-social' );
$broadcast = add_query_arg(
	array(
		'name'  => $name,
		'ticket'=> $ticket,
	),
	home_url( (string) $event['broadcast_path'] )
);
if ( $event['meet_url'] ) {
	$broadcast = add_query_arg( 'meet', $event['meet_url'], $broadcast );
}

$sales = home_url( (string) $event['sales_path'] );
?>
<main id="main" class="xciv-shell xciv-funnel xciv-funnel--thanks" data-xciv-event-thanks>
	<header class="xciv-funnel__hero xciv-funnel__hero--center">
		<p class="xciv-funnel__eyebrow"><?php esc_html_e( 'You’re confirmed', 'xciv-social' ); ?></p>
		<h1>
			<?php
			printf(
				/* translators: %s: first name */
				esc_html__( 'Thank you, %s', 'xciv-social' ),
				esc_html( $first )
			);
			?>
		</h1>
		<p class="xciv-funnel__lede">
			<?php
			printf(
				/* translators: %s: event title */
				esc_html__( 'Your spot for %s is locked. Save your broadcast link — that’s where Meet, polls, live feed, and Q&A live.', 'xciv-social' ),
				esc_html( (string) $event['title'] )
			);
			?>
		</p>
	</header>

	<div class="xciv-funnel__thanks-grid">
		<section class="xciv-panel xciv-thanks-card" aria-labelledby="xciv-order-heading">
			<header class="xciv-panel__head">
				<h2 id="xciv-order-heading" class="xciv-panel__title"><?php esc_html_e( 'Order summary', 'xciv-social' ); ?></h2>
			</header>
			<div class="xciv-panel__body">
				<dl class="xciv-thanks-dl">
					<div>
						<dt><?php esc_html_e( 'Event', 'xciv-social' ); ?></dt>
						<dd><?php echo esc_html( (string) $event['title'] ); ?></dd>
					</div>
					<div>
						<dt><?php esc_html_e( 'When', 'xciv-social' ); ?></dt>
						<dd><?php echo esc_html( (string) $event['date_label'] . ' · ' . (string) $event['time_label'] ); ?></dd>
					</div>
					<div>
						<dt><?php esc_html_e( 'Ticket', 'xciv-social' ); ?></dt>
						<dd><?php echo esc_html( $ticket_name ); ?></dd>
					</div>
					<?php if ( $addons ) : ?>
						<div>
							<dt><?php esc_html_e( 'Add-ons', 'xciv-social' ); ?></dt>
							<dd><?php echo esc_html( str_replace( ',', ', ', $addons ) ); ?></dd>
						</div>
					<?php endif; ?>
					<?php if ( $upsell_q ) : ?>
						<div>
							<dt><?php esc_html_e( 'Upsells', 'xciv-social' ); ?></dt>
							<dd><?php echo esc_html( str_replace( ',', ', ', $upsell_q ) ); ?></dd>
						</div>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<div>
							<dt><?php esc_html_e( 'Confirmation email', 'xciv-social' ); ?></dt>
							<dd><?php echo esc_html( $email ); ?></dd>
						</div>
					<?php endif; ?>
					<div>
						<dt><?php esc_html_e( 'Total', 'xciv-social' ); ?></dt>
						<dd>$<?php echo esc_html( number_format( $total, 0 ) ); ?> <span class="xciv-muted"><?php esc_html_e( '(demo)', 'xciv-social' ); ?></span></dd>
					</div>
				</dl>
			</div>
		</section>

		<section class="xciv-panel xciv-thanks-card xciv-thanks-card--accent" aria-labelledby="xciv-broadcast-heading">
			<header class="xciv-panel__head">
				<h2 id="xciv-broadcast-heading" class="xciv-panel__title"><?php esc_html_e( 'Your broadcast room', 'xciv-social' ); ?></h2>
				<p class="xciv-panel__desc"><?php esc_html_e( 'Join when the event goes live. Google Meet opens from the video block — polls, live feed, and Q&A stay beside it.', 'xciv-social' ); ?></p>
			</header>
			<div class="xciv-panel__body">
				<a class="xciv-btn xciv-btn--primary" href="<?php echo esc_url( $broadcast ); ?>"><?php esc_html_e( 'Open broadcast', 'xciv-social' ); ?></a>
				<p class="xciv-muted xciv-funnel__calendar-note">
					<?php echo esc_html( (string) $event['date_label'] . ' · ' . (string) $event['time_label'] ); ?>
				</p>
			</div>
		</section>
	</div>

	<section class="xciv-panel xciv-funnel__upsell-band" aria-labelledby="xciv-thanks-upsell-heading">
		<header class="xciv-panel__head">
			<h2 id="xciv-thanks-upsell-heading" class="xciv-panel__title"><?php esc_html_e( 'While you wait — add more', 'xciv-social' ); ?></h2>
			<p class="xciv-panel__desc"><?php esc_html_e( 'Thank-you upsells for membership and the next paid trip. Send buyers back to your sales link anytime.', 'xciv-social' ); ?></p>
		</header>
		<div class="xciv-panel__body xciv-thanks-upsells">
			<?php foreach ( $upsells as $upsell ) : ?>
				<article class="xciv-thanks-upsell">
					<div>
						<h3><?php echo esc_html( (string) $upsell['name'] ); ?></h3>
						<p class="xciv-muted"><?php echo esc_html( (string) $upsell['desc'] ); ?></p>
					</div>
					<div class="xciv-thanks-upsell__actions">
						<span class="xciv-thanks-upsell__price">
							<?php
							echo (int) $upsell['price'] > 0
								? esc_html( '$' . (string) $upsell['price'] )
								: esc_html__( 'Free', 'xciv-social' );
							?>
						</span>
						<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( $sales ); ?>"><?php echo esc_html( (string) $upsell['cta'] ); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
</main>
<?php
get_footer();
