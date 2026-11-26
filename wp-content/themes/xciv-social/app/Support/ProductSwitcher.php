<?php
/**
 * Sister-product switcher (Social / Courier / Super Ninety Four).
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

namespace XCIV\Theme\Support;

final class ProductSwitcher {

	/**
	 * Sister products for the Uber-style product switcher.
	 *
	 * @return array<int, array{id:string,label:string,short:string,glyph:string,blurb:string,url:string,current:bool,external:bool}>
	 */
	public static function items(): array {
		$items = array(
			array(
				'id'       => 'xcivsocial',
				'label'    => __( 'XCIV Social', 'xciv-social' ),
				'short'    => __( 'Social', 'xciv-social' ),
				'glyph'    => 'S',
				'blurb'    => __( 'Connect with the community', 'xciv-social' ),
				'url'      => home_url( '/' ),
				'current'  => true,
				'external' => false,
			),
			array(
				'id'       => 'courier',
				'label'    => __( 'XCIV Courier', 'xciv-social' ),
				'short'    => __( 'Courier', 'xciv-social' ),
				'glyph'    => 'C',
				'blurb'    => __( 'On-demand delivery & pickup', 'xciv-social' ),
				'url'      => 'https://xcivcourier.com/',
				'current'  => false,
				'external' => true,
			),
			array(
				'id'       => 'superninetyfour',
				'label'    => __( 'Super Ninety Four', 'xciv-social' ),
				'short'    => __( 'SN4', 'xciv-social' ),
				'glyph'    => '94',
				'blurb'    => __( 'Culture, drops & merch', 'xciv-social' ),
				'url'      => 'https://superninetyfour.com/',
				'current'  => false,
				'external' => true,
			),
		);

		/**
		 * Filter product switcher destinations.
		 *
		 * @param array<int, array{id:string,label:string,short:string,glyph:string,blurb:string,url:string,current:bool,external:bool}> $items Products.
		 */
		return apply_filters( 'xciv_product_switcher_items', $items );
	}

	/**
	 * Render the product switcher markup.
	 */
	public static function render(): void {
		$items   = self::items();
		$current = array(
			'id'    => 'xcivsocial',
			'short' => __( 'Social', 'xciv-social' ),
			'glyph' => 'S',
			'label' => __( 'XCIV Social', 'xciv-social' ),
		);

		foreach ( $items as $item ) {
			if ( ! empty( $item['current'] ) ) {
				$current['id']    = (string) $item['id'];
				$current['short'] = (string) ( $item['short'] ?? $item['label'] );
				$current['glyph'] = (string) ( $item['glyph'] ?? ( function_exists( 'mb_substr' ) ? mb_substr( $current['short'], 0, 1 ) : substr( $current['short'], 0, 1 ) ) );
				$current['label'] = (string) $item['label'];
				break;
			}
		}

		$switch_label = sprintf(
			/* translators: %s: current product short name */
			__( 'Switch product, current: %s', 'xciv-social' ),
			$current['short']
		);
		?>
		<div class="xciv-product-switcher" data-xciv-product-switcher>
			<button
				type="button"
				class="xciv-product-switcher__trigger"
				data-xciv-product-switcher-trigger
				aria-expanded="false"
				aria-haspopup="menu"
				aria-controls="xciv-product-switcher-menu"
				aria-label="<?php echo esc_attr( $switch_label ); ?>"
			>
				<span class="xciv-product-switcher__glyph" aria-hidden="true"><?php echo esc_html( $current['glyph'] ); ?></span>
				<span class="xciv-product-switcher__current"><?php echo esc_html( $current['short'] ); ?></span>
				<svg class="xciv-product-switcher__chevron" width="12" height="12" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
					<path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>

			<div
				id="xciv-product-switcher-menu"
				class="xciv-product-switcher__menu"
				data-xciv-product-switcher-menu
				role="menu"
				aria-label="<?php esc_attr_e( 'Switch product', 'xciv-social' ); ?>"
				hidden
			>
				<?php foreach ( $items as $item ) : ?>
					<?php
					$is_current = ! empty( $item['current'] );
					$classes    = 'xciv-product-switcher__item';
					if ( $is_current ) {
						$classes .= ' is-current';
					}
					$glyph = (string) ( $item['glyph'] ?? '' );
					$blurb = (string) ( $item['blurb'] ?? '' );
					?>
					<a
						class="<?php echo esc_attr( $classes ); ?>"
						role="menuitem"
						href="<?php echo esc_url( (string) $item['url'] ); ?>"
						<?php echo $is_current ? 'aria-current="page"' : ''; ?>
						<?php echo ! empty( $item['external'] ) ? 'rel="noopener noreferrer"' : ''; ?>
						data-xciv-product="<?php echo esc_attr( (string) $item['id'] ); ?>"
					>
						<span class="xciv-product-switcher__item-glyph" aria-hidden="true"><?php echo esc_html( $glyph ); ?></span>
						<span class="xciv-product-switcher__item-text">
							<span class="xciv-product-switcher__item-label"><?php echo esc_html( (string) $item['label'] ); ?></span>
							<?php if ( $blurb !== '' ) : ?>
								<span class="xciv-product-switcher__item-blurb"><?php echo esc_html( $blurb ); ?></span>
							<?php endif; ?>
						</span>
						<?php if ( $is_current ) : ?>
							<svg class="xciv-product-switcher__check" width="14" height="14" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
								<path d="M5 12.5l4.5 4.5L19 7.5" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						<?php else : ?>
							<span class="xciv-product-switcher__check-spacer" aria-hidden="true"></span>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
