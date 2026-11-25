<?php
/**
 * Member app sidebar navigation.
 *
 * @package XCIV_Social
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = array(
	array(
		'slug'  => 'dashboard',
		'url'   => home_url( '/dashboard/' ),
		'label' => __( 'Dashboard', 'xciv-social' ),
		'icon'  => 'dashboard',
	),
	array(
		'slug'  => 'member-feed',
		'url'   => home_url( '/member-feed/' ),
		'label' => __( 'Feed', 'xciv-social' ),
		'icon'  => 'feed',
	),
	array(
		'slug'  => 'events',
		'url'   => home_url( '/events/' ),
		'label' => __( 'Events', 'xciv-social' ),
		'icon'  => 'events',
		'also'  => array( 'event-calendar' ),
	),
	array(
		'slug'  => 'people',
		'url'   => home_url( '/people/' ),
		'label' => __( 'People', 'xciv-social' ),
		'icon'  => 'people',
		'also'  => array( 'directory' ),
	),
	array(
		'slug'  => 'messages',
		'url'   => home_url( '/messages/' ),
		'label' => __( 'Messages', 'xciv-social' ),
		'icon'  => 'messages',
	),
	array(
		'slug'  => 'profile',
		'url'   => home_url( '/profile/' ),
		'label' => __( 'Profile', 'xciv-social' ),
		'icon'  => 'profile',
	),
);

$current = '';
if ( is_page() ) {
	$current = get_post_field( 'post_name', get_queried_object_id() );
}

/**
 * Render a simple line icon.
 *
 * @param string $name Icon key.
 */
$render_icon = static function ( string $name ): void {
	$icons = array(
		'dashboard'   => '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>',
		'feed'        => '<path d="M4 6h16M4 12h16M4 18h10"/>',
		'events'      => '<rect x="3" y="5" width="18" height="16" rx="1"/><path d="M3 10h18M8 3v4M16 3v4"/>',
		'people'      => '<circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.5"/><path d="M3 19c0-3 2.5-5 6-5s6 2 6 5"/><path d="M15 19c.3-1.8 1.6-3 3.5-3 1.4 0 2.5.7 3 1.8"/>',
		'messages'    => '<path d="M4 5h16v11H8l-4 3V5z"/>',
		'profile'     => '<circle cx="12" cy="8" r="4"/><path d="M4 20c0-3.5 3.6-6 8-6s8 2.5 8 6"/>',
	);
	$path = $icons[ $name ] ?? $icons['dashboard'];
	echo '<svg class="xciv-sidebar__svg" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG markup.
};
?>
<aside class="xciv-sidebar" id="xciv-sidebar-drawer" data-xciv-sidebar aria-label="<?php esc_attr_e( 'Primary', 'xciv-social' ); ?>">
	<nav class="xciv-sidebar__nav">
		<?php foreach ( $items as $item ) : ?>
			<?php
			$active_slugs = array_merge( array( $item['slug'] ), $item['also'] ?? array() );
			$is_active    = in_array( $current, $active_slugs, true );
			?>
			<a
				class="xciv-sidebar__link<?php echo $is_active ? ' is-active' : ''; ?>"
				href="<?php echo esc_url( $item['url'] ); ?>"
				aria-label="<?php echo esc_attr( $item['label'] ); ?>"
				<?php echo $is_active ? ' aria-current="page"' : ''; ?>
				title="<?php echo esc_attr( $item['label'] ); ?>"
			>
				<span class="xciv-sidebar__icon"><?php $render_icon( $item['icon'] ); ?></span>
				<span class="xciv-sidebar__label"><?php echo esc_html( $item['label'] ); ?></span>
			</a>
		<?php endforeach; ?>
	</nav>
</aside>
