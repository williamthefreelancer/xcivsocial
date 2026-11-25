<?php
/**
 * Normalize YouTube / Vimeo / Bunny Stream URLs into iframe embeds.
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

namespace XCIV\Theme\Support;

final class VideoEmbed {

	/**
	 * Resolve a watch / share / embed URL into player data.
	 *
	 * @return array{provider: string, embed: string, autoplay: string}|null
	 */
	public static function resolve( string $url ): ?array {
		$url = trim( $url );
		if ( '' === $url ) {
			return null;
		}

		$youtube = self::youtube( $url );
		if ( $youtube ) {
			return $youtube;
		}

		$vimeo = self::vimeo( $url );
		if ( $vimeo ) {
			return $vimeo;
		}

		$bunny = self::bunny( $url );
		if ( $bunny ) {
			return $bunny;
		}

		return null;
	}

	/**
	 * @return array{provider: string, embed: string, autoplay: string}|null
	 */
	private static function youtube( string $url ): ?array {
		$host = (string) wp_parse_url( $url, PHP_URL_HOST );
		$host = strtolower( preg_replace( '/^www\./', '', $host ) ?? '' );
		$id   = '';

		if ( in_array( $host, array( 'youtu.be' ), true ) ) {
			$path = trim( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' );
			$id   = $path;
		} elseif ( in_array( $host, array( 'youtube.com', 'm.youtube.com', 'youtube-nocookie.com' ), true ) ) {
			$path = (string) wp_parse_url( $url, PHP_URL_PATH );
			if ( preg_match( '#/(?:embed|shorts|live)/([A-Za-z0-9_-]{6,})#', $path, $m ) ) {
				$id = $m[1];
			} else {
				$query = array();
				parse_str( (string) wp_parse_url( $url, PHP_URL_QUERY ), $query );
				$id = isset( $query['v'] ) ? (string) $query['v'] : '';
			}
		}

		if ( ! preg_match( '/^[A-Za-z0-9_-]{6,}$/', $id ) ) {
			return null;
		}

		$embed = 'https://www.youtube-nocookie.com/embed/' . rawurlencode( $id );
		return array(
			'provider' => 'youtube',
			'embed'    => $embed,
			'autoplay' => add_query_arg(
				array(
					'autoplay' => '1',
					'rel'      => '0',
					'modestbranding' => '1',
				),
				$embed
			),
		);
	}

	/**
	 * @return array{provider: string, embed: string, autoplay: string}|null
	 */
	private static function vimeo( string $url ): ?array {
		$host = (string) wp_parse_url( $url, PHP_URL_HOST );
		$host = strtolower( preg_replace( '/^www\./', '', $host ) ?? '' );

		if ( ! in_array( $host, array( 'vimeo.com', 'player.vimeo.com' ), true ) ) {
			return null;
		}

		$path = trim( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' );
		if ( ! preg_match( '#(?:video/)?(\d+)#', $path, $m ) ) {
			return null;
		}

		$embed = 'https://player.vimeo.com/video/' . rawurlencode( $m[1] );
		return array(
			'provider' => 'vimeo',
			'embed'    => $embed,
			'autoplay' => add_query_arg( array( 'autoplay' => '1' ), $embed ),
		);
	}

	/**
	 * Bunny.net Stream — iframe.mediadelivery.net embed/play URLs,
	 * plus pull-zone style hosts that already point at an embed path.
	 *
	 * @return array{provider: string, embed: string, autoplay: string}|null
	 */
	private static function bunny( string $url ): ?array {
		$host = (string) wp_parse_url( $url, PHP_URL_HOST );
		$host = strtolower( preg_replace( '/^www\./', '', $host ) ?? '' );
		$path = trim( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' );

		$library = '';
		$video   = '';

		// Canonical Stream player: /embed/{libraryId}/{videoId} or /play/...
		if (
			in_array( $host, array( 'iframe.mediadelivery.net', 'video.bunnycdn.com' ), true )
			&& preg_match( '#^(?:embed|play)/([^/]+)/([^/]+)/?#', $path, $m )
		) {
			$library = $m[1];
			$video   = $m[2];
		}

		// Custom Bunny player hostname with the same /embed|play path shape.
		if (
			'' === $library
			&& $host
			&& preg_match( '#^(?:embed|play)/([^/]+)/([^/]+)/?#', $path, $m )
			&& ( false !== stripos( $host, 'b-cdn.net' ) || false !== stripos( $host, 'mediadelivery' ) || false !== stripos( $host, 'bunny' ) )
		) {
			$library = $m[1];
			$video   = $m[2];
		}

		if ( '' === $library || '' === $video ) {
			return null;
		}

		$embed = sprintf(
			'https://iframe.mediadelivery.net/embed/%s/%s',
			rawurlencode( $library ),
			rawurlencode( $video )
		);

		return array(
			'provider' => 'bunny',
			'embed'    => $embed,
			'autoplay' => add_query_arg(
				array(
					'autoplay'   => 'true',
					'preload'    => 'true',
					'responsive' => 'true',
				),
				$embed
			),
		);
	}
}
