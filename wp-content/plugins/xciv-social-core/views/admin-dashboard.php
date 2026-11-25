<?php
/**
 * Admin dashboard hub.
 *
 * @package XCIV_Social_Core
 * @var int                                 $pending_admissions
 * @var int                                 $waitlist_total
 * @var int                                 $member_count
 * @var array<string, mixed>                $settings
 * @var array<string, mixed>                $event
 * @var list<array<string, mixed>>          $tickets
 * @var list<array<string, mixed>>          $addons
 * @var list<array<string, mixed>>          $upsells
 * @var array<string, mixed>                $briefing
 * @var list<array{label: string, fix: string}> $gaps
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap xciv-admin">
	<header class="xciv-admin__hero">
		<div>
			<p class="xciv-admin__eyebrow"><?php esc_html_e( 'Operations', 'xciv-social-core' ); ?></p>
			<h1><?php esc_html_e( 'XCIV Social', 'xciv-social-core' ); ?></h1>
			<p class="xciv-admin__lede">
				<?php esc_html_e( 'Admissions, waitlists, ticket commerce, and member briefing — one control room.', 'xciv-social-core' ); ?>
			</p>
		</div>
		<div class="xciv-admin__hero-actions">
			<a class="button button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-settings' ) ); ?>">
				<?php esc_html_e( 'Open settings', 'xciv-social-core' ); ?>
			</a>
			<a class="button" href="<?php echo esc_url( home_url( '/event-sales/' ) ); ?>" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'View sales page', 'xciv-social-core' ); ?>
			</a>
		</div>
	</header>

	<section class="xciv-admin__stats" aria-label="<?php esc_attr_e( 'Snapshot', 'xciv-social-core' ); ?>">
		<article class="xciv-admin__stat">
			<p class="xciv-admin__stat-label"><?php esc_html_e( 'Pending admissions', 'xciv-social-core' ); ?></p>
			<p class="xciv-admin__stat-value"><?php echo esc_html( (string) $pending_admissions ); ?></p>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-admissions' ) ); ?>">
				<?php esc_html_e( 'Review queue', 'xciv-social-core' ); ?>
			</a>
		</article>
		<article class="xciv-admin__stat">
			<p class="xciv-admin__stat-label"><?php esc_html_e( 'Waitlist signups', 'xciv-social-core' ); ?></p>
			<p class="xciv-admin__stat-value"><?php echo esc_html( (string) $waitlist_total ); ?></p>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-waitlists' ) ); ?>">
				<?php esc_html_e( 'Open waitlists', 'xciv-social-core' ); ?>
			</a>
		</article>
		<article class="xciv-admin__stat">
			<p class="xciv-admin__stat-label"><?php esc_html_e( 'Members', 'xciv-social-core' ); ?></p>
			<p class="xciv-admin__stat-value"><?php echo esc_html( (string) $member_count ); ?></p>
			<a href="<?php echo esc_url( admin_url( 'users.php?role=xciv_member' ) ); ?>">
				<?php esc_html_e( 'View members', 'xciv-social-core' ); ?>
			</a>
		</article>
		<article class="xciv-admin__stat">
			<p class="xciv-admin__stat-label"><?php esc_html_e( 'Ticket tiers', 'xciv-social-core' ); ?></p>
			<p class="xciv-admin__stat-value"><?php echo esc_html( (string) count( $tickets ) ); ?></p>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-settings&tab=tickets' ) ); ?>">
				<?php esc_html_e( 'Edit tickets', 'xciv-social-core' ); ?>
			</a>
		</article>
	</section>

	<div class="xciv-admin__grid">
		<section class="xciv-admin__card">
			<header class="xciv-admin__card-head">
				<h2><?php esc_html_e( 'Missing requirements', 'xciv-social-core' ); ?></h2>
				<p><?php esc_html_e( 'Theme gaps that block a production-ready funnel.', 'xciv-social-core' ); ?></p>
			</header>
			<?php if ( empty( $gaps ) ) : ?>
				<p class="xciv-admin__ok"><?php esc_html_e( 'Core settings look complete.', 'xciv-social-core' ); ?></p>
			<?php else : ?>
				<ul class="xciv-admin__gaps">
					<?php foreach ( $gaps as $gap ) : ?>
						<li>
							<span><?php echo esc_html( $gap['label'] ); ?></span>
							<a class="button button-small" href="<?php echo esc_url( $gap['fix'] ); ?>">
								<?php esc_html_e( 'Fix', 'xciv-social-core' ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</section>

		<section class="xciv-admin__card">
			<header class="xciv-admin__card-head">
				<h2><?php esc_html_e( 'Online event', 'xciv-social-core' ); ?></h2>
				<p><?php echo esc_html( (string) $event['title'] ); ?></p>
			</header>
			<dl class="xciv-admin__dl">
				<div>
					<dt><?php esc_html_e( 'When', 'xciv-social-core' ); ?></dt>
					<dd><?php echo esc_html( (string) $event['date_label'] . ' · ' . (string) $event['time_label'] ); ?></dd>
				</div>
				<div>
					<dt><?php esc_html_e( 'Capacity', 'xciv-social-core' ); ?></dt>
					<dd>
						<?php
						printf(
							/* translators: 1: seats left, 2: capacity */
							esc_html__( '%1$d seats left of %2$d', 'xciv-social-core' ),
							(int) $event['seats_left'],
							(int) $event['capacity']
						);
						?>
					</dd>
				</div>
				<div>
					<dt><?php esc_html_e( 'Meet', 'xciv-social-core' ); ?></dt>
					<dd><code><?php echo esc_html( (string) $event['meet_url'] ); ?></code></dd>
				</div>
			</dl>
			<p class="xciv-admin__card-actions">
				<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-settings&tab=event' ) ); ?>">
					<?php esc_html_e( 'Edit event', 'xciv-social-core' ); ?>
				</a>
				<a class="button" href="<?php echo esc_url( home_url( (string) $event['broadcast_path'] ) ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Open broadcast', 'xciv-social-core' ); ?>
				</a>
			</p>
		</section>

		<section class="xciv-admin__card">
			<header class="xciv-admin__card-head">
				<h2><?php esc_html_e( 'Commerce stack', 'xciv-social-core' ); ?></h2>
				<p><?php esc_html_e( 'Tickets, add-ons, and upsells on the sales funnel.', 'xciv-social-core' ); ?></p>
			</header>
			<div class="xciv-admin__commerce">
				<div>
					<strong><?php esc_html_e( 'Tickets', 'xciv-social-core' ); ?></strong>
					<ul>
						<?php foreach ( $tickets as $ticket ) : ?>
							<li>
								<?php echo esc_html( (string) $ticket['name'] ); ?>
								<span>$<?php echo esc_html( (string) $ticket['price'] ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div>
					<strong><?php esc_html_e( 'Add-ons', 'xciv-social-core' ); ?></strong>
					<ul>
						<?php foreach ( $addons as $addon ) : ?>
							<li>
								<?php echo esc_html( (string) $addon['name'] ); ?>
								<span>+$<?php echo esc_html( (string) $addon['price'] ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div>
					<strong><?php esc_html_e( 'Upsells', 'xciv-social-core' ); ?></strong>
					<ul>
						<?php foreach ( $upsells as $upsell ) : ?>
							<li>
								<?php echo esc_html( (string) $upsell['name'] ); ?>
								<span>
									<?php
									echo (float) $upsell['price'] > 0
										? esc_html( '+$' . (string) $upsell['price'] )
										: esc_html__( 'Free', 'xciv-social-core' );
									?>
								</span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<p class="xciv-admin__card-actions">
				<a class="button button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-settings&tab=tickets' ) ); ?>">
					<?php esc_html_e( 'Manage catalog', 'xciv-social-core' ); ?>
				</a>
			</p>
		</section>

		<section class="xciv-admin__card">
			<header class="xciv-admin__card-head">
				<h2><?php esc_html_e( 'Member briefing', 'xciv-social-core' ); ?></h2>
				<p><?php echo esc_html( (string) ( $briefing['briefing_title'] ?: __( 'Untitled briefing', 'xciv-social-core' ) ) ); ?></p>
			</header>
			<p class="xciv-admin__muted">
				<?php
				$url = (string) ( $briefing['briefing_url'] ?? '' );
				echo $url
					? esc_html( $url )
					: esc_html__( 'No YouTube / Vimeo / Bunny URL set — the dashboard player stays empty.', 'xciv-social-core' );
				?>
			</p>
			<p class="xciv-admin__card-actions">
				<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-settings&tab=dashboard' ) ); ?>">
					<?php esc_html_e( 'Set briefing video', 'xciv-social-core' ); ?>
				</a>
				<a class="button" href="<?php echo esc_url( home_url( '/dashboard/' ) ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Preview dashboard', 'xciv-social-core' ); ?>
				</a>
			</p>
		</section>
	</div>

	<section class="xciv-admin__shortcuts">
		<h2><?php esc_html_e( 'Quick links', 'xciv-social-core' ); ?></h2>
		<nav class="xciv-admin__shortcut-row">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-admissions' ) ); ?>"><?php esc_html_e( 'Admissions', 'xciv-social-core' ); ?></a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-waitlists' ) ); ?>"><?php esc_html_e( 'Event waitlists', 'xciv-social-core' ); ?></a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-settings&tab=addons' ) ); ?>"><?php esc_html_e( 'Ticket add-ons', 'xciv-social-core' ); ?></a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-settings&tab=upsells' ) ); ?>"><?php esc_html_e( 'Upsells', 'xciv-social-core' ); ?></a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-settings&tab=payments' ) ); ?>"><?php esc_html_e( 'Payments', 'xciv-social-core' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/request-admission/' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Admission form', 'xciv-social-core' ); ?></a>
		</nav>
	</section>
</div>
