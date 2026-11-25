<?php
/**
 * Event waitlist audience view.
 *
 * @package XCIV_Social_Core
 * @var array<int,array<string,mixed>>|null $rows
 * @var array<string,int>                   $count_map
 * @var string                              $filter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$series_labels = array(
	'harrisburg-to-lynn'      => __( 'Harrisburg to Lynn', 'xciv-social-core' ),
	'township-backways-route' => __( 'The Township Backways Route', 'xciv-social-core' ),
);
?>
<div class="wrap">
	<h1><?php esc_html_e( 'Event pre-sale waitlists', 'xciv-social-core' ); ?></h1>
	<p><?php esc_html_e( 'Audience building lists for upcoming Super Ninety Four Experiences.', 'xciv-social-core' ); ?></p>

	<ul style="display:flex;gap:1rem;flex-wrap:wrap;list-style:none;padding:0;">
		<li>
			<a class="button<?php echo '' === $filter ? ' button-primary' : ''; ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social-waitlists' ) ); ?>">
				<?php esc_html_e( 'All', 'xciv-social-core' ); ?>
			</a>
		</li>
		<?php foreach ( $series_labels as $series_id => $label ) : ?>
			<li>
				<a
					class="button<?php echo $filter === $series_id ? ' button-primary' : ''; ?>"
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
			</li>
		<?php endforeach; ?>
	</ul>

	<?php if ( empty( $rows ) ) : ?>
		<p><?php esc_html_e( 'No waitlist signups yet.', 'xciv-social-core' ); ?></p>
	<?php else : ?>
		<table class="widefat striped" style="max-width:960px;margin-top:1rem;">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Name', 'xciv-social-core' ); ?></th>
					<th><?php esc_html_e( 'Email', 'xciv-social-core' ); ?></th>
					<th><?php esc_html_e( 'Event', 'xciv-social-core' ); ?></th>
					<th><?php esc_html_e( 'Joined', 'xciv-social-core' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $rows as $row ) : ?>
					<?php
					$series_id = (string) $row['series_id'];
					$label     = $series_labels[ $series_id ] ?? $series_id;
					?>
					<tr>
						<td><?php echo esc_html( (string) $row['full_name'] ); ?></td>
						<td><a href="mailto:<?php echo esc_attr( (string) $row['email'] ); ?>"><?php echo esc_html( (string) $row['email'] ); ?></a></td>
						<td><?php echo esc_html( $label ); ?></td>
						<td><?php echo esc_html( (string) $row['created_at'] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>
