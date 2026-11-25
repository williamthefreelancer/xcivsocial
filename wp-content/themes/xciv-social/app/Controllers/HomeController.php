<?php
/**
 * Front page data.
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

namespace XCIV\Theme\Controllers;

final class HomeController {

	/**
	 * @return array{brand:string,headline:string,subhead:string,cta_label:string,cta_url:string}
	 */
	public static function landing(): array {
		$admission = get_page_by_path( 'request-admission' );

		return array(
			'brand'     => 'XCIV Social',
			'headline'  => 'A private network for sovereign operators.',
			'subhead'   => 'Multi-family offices, hospitality, clubs, nightlife, and the people who move capital and experience.',
			'cta_label' => 'Request Admission',
			'cta_url'   => $admission ? get_permalink( $admission ) : home_url( '/request-admission/' ),
		);
	}
}
