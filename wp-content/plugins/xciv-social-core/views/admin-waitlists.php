<?php
/**
 * Event waitlist audience view.
 *
 * @package XCIV_Social_Core
 * @var array<int,array<string,mixed>>|null $rows
 * @var array<string,int>                   $count_map
 * @var string                              $filter
 * @var int                                 $total
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$series_labels = array(
	'harrisburg-to-lynn'      => __( 'Harrisburg to Lynn', 'xciv-social-core' ),
	'township-backways-route' => __( 'The Township Backways Route', 'xciv-social-core' ),
);

$filter_total = '' === $filter
	? $total
	: (int) ( $count_map[ $filter ] ?? 0 );
?>
<div class="wrap xciv-admin xciv-admin--waitlists">
	<header class="xciv-admin__hero">
		<div>
			<p class="xciv-admin__eyebrow"><?php esc_html_e( 'Audience', 'xciv-social-core' ); ?></p>
			<h1><?php esc_html_e( 'Event waitlists', 'xciv-social-core' ); ?></h1>
			<p class="xciv-admin__lede">
				<?php esc_html_e( 'Pre-sale interest for Super Ninety Four Experiences — export-ready signup lists by series.', 'xciv-social-core' ); ?>
			</p>
		</div>
		<div class="xciv-admin__hero-actions">
			<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social' ) ); ?>">
				<?php esc_html_e( '← Dashboard', 'xciv-social-core' ); ?>
			</a>
			<a class="button button-primary" href="<?php echo esc_url( home_url( '/events/' ) ); ?>" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'View events', 'xciv-social-core' ); ?>
			</a>
		</div>
	</header>

	<section class="xciv-admin__stats xciv-admin__stats--3" aria-label="<?php esc_attr_e( 'Waitlist snapshot', 'xciv-social-core' ); ?>">
		<article class="xciv-admin__stat">
			<p class="xciv-admin__stat-label"><?php esc_html_e( 'Total signups', 'xciv-social-core' ); ?></p>
			<p class="xciv-admin__stat-value"><?php echo esc_html( (string) $total ); ?></p>
			<span class="xciv-admin__stat-hint"><?php esc_html_e( 'Across all series', 'xciv-social-core' ); ?></span>
		</article>
		<?php foreach ( $series_labels as $series_id => $label ) : ?>
			<article class="xciv-admin__stat">
				<p class="xciv-admin__stat-label"><?php echo esc_html( $label ); ?></p>
				<p class="xciv-admin__stat-value"><?php echo esc_html( (string) ( $count_map[ $series_id ] ?? 0 ) ); ?></p>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-waitlists&series=' . rawurlencode( $series_id ) ) ); ?>">
					<?php esc_html_e( 'Filter list', 'xciv-social-core' ); ?>
				</a>
			</article>
		<?php endforeach; ?>
	</section>

	<nav class="xciv-admin__tabs" aria-label="<?php esc_attr_e( 'Waitlist filters', 'xciv-social-core' ); ?>">
		<a
			class="xciv-admin__tab<?php echo '' === $filter ? ' is-active' : ''; ?>"
			href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-waitlists' ) ); ?>"
		>
			<?php
			printf(
				/* translators: %d: signup count */
				esc_html__( 'All (%d)', 'xciv-social-core' ),
				(int) $total
			);
			?>
		</a>
		<?php foreach ( $series_labels as $series_id => $label ) : ?>
			<a
				class="xciv-admin__tab<?php echo $filter === $series_id ? ' is-active' : ''; ?>"
				href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-waitlists&series=' . rawurlencode( $series_id ) ) ); ?>"
			>
				<?php
				printf(
					/* translators: 1: event title, 2: signup count */
					esc_html__( '%1$s (%2$d)', 'xciv-social-core' ),
					esc_html( $label ),
					(int) ( $count_map[ $series_id ] ?? 0 )
				);
				?>
			</a>
		<?php endforeach; ?>
	</nav>

	<section class="xciv-admin__card">
		<header class="xciv-admin__card-head">
			<div>
				<h2>
					<?php
					echo '' === $filter
						? esc_html__( 'All signups', 'xciv-social-core' )
						: esc_html( $series_labels[ $filter ] ?? $filter );
					?>
				</h2>
				<p>
					<?php
					printf(
						/* translators: %d: number of rows shown */
						esc_html( _n( '%d person in this view', '%d people in this view', $filter_total, 'xciv-social-core' ) ),
						(int) $filter_total
					);
					?>
				</p>
			</div>
		</header>

		<?php if ( empty( $rows ) ) : ?>
			<div class="xciv-admin__empty xciv-admin__empty--inset">
				<p class="xciv-admin__empty-title"><?php esc_html_e( 'No signups yet', 'xciv-social-core' ); ?></p>
				<p class="xciv-admin__muted">
					<?php esc_html_e( 'When guests join a pre-sale waitlist from the events pages, they will show up here.', 'xciv-social-core' ); ?>
				</p>
			</div>
		<?php else : ?>
			<div class="xciv-admin__table-wrap">
				<table class="xciv-admin__table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Name', 'xciv-social-core' ); ?></th>
							<th><?php esc_html_e( 'Email', 'xciv-social-core' ); ?></th>
							<th><?php esc_html_e( 'Event', 'xciv-social-core' ); ?></th>
							<th><?php esc_html_e( 'Source', 'xciv-social-core' ); ?></th>
							<th><?php esc_html_e( 'Joined', 'xciv-social-core' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $rows as $row ) : ?>
							<?php
							$series_id = (string) $row['series_id'];
							$label     = $series_labels[ $series_id ] ?? $series_id;
							$source    = (string) ( $row['source'] ?? 'events' );
							?>
							<tr>
								<td>
									<strong><?php echo esc_html( (string) $row['full_name'] ); ?></strong>
								</td>
								<td>
									<a href="mailto:<?php echo esc_attr( (string) $row['email'] ); ?>">
										<?php echo esc_html( (string) $row['email'] ); ?>
									</a>
								</td>
								<td>
									<span class="xciv-admin__pill xciv-admin__pill--soft"><?php echo esc_html( $label ); ?></span>
								</td>
								<td>
									<span class="xciv-admin__muted"><?php echo esc_html( $source ); ?></span>
								</td>
								<td>
									<time datetime="<?php echo esc_attr( (string) $row['created_at'] ); ?>">
										<?php echo esc_html( (string) $row['created_at'] ); ?>
									</time>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</section>
</div>
