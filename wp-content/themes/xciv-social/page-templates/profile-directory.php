<?php
/**
 * Template Name: Profile Directory
 *
 * @package XCIV_Social
 */

get_template_part( 'template-parts/member/require', 'member' );
get_header();

$members = array(
	array(
		'initial' => 'M',
		'name'    => 'Maya Okonkwo',
		'meta'    => 'Fintech · Lagos',
		'vertical'=> 'fintech',
		'city'    => 'Lagos',
		'summary' => 'Building remittance corridors; looking for compliance-aware operators who already clear volume.',
		'tags'    => array( 'Payments', 'Intros open' ),
	),
	array(
		'initial' => 'J',
		'name'    => 'Jonah Reyes',
		'meta'    => 'Hospitality · Miami',
		'vertical'=> 'hospitality',
		'city'    => 'Miami',
		'summary' => 'Runs intimate member dinners. Believes small rooms beat large mixers for trust.',
		'tags'    => array( 'Hosting', 'Tables' ),
	),
	array(
		'initial' => 'A',
		'name'    => 'Amira Haddad',
		'meta'    => 'Media · Dubai',
		'vertical'=> 'nightlife',
		'city'    => 'Dubai',
		'summary' => 'Connects media, nightlife, and hospitality operators across GCC markets.',
		'tags'    => array( 'Introducer', 'GCC' ),
	),
	array(
		'initial' => 'T',
		'name'    => 'Theo Marchand',
		'meta'    => 'Climate tech · Montréal',
		'vertical'=> 'consulting',
		'city'    => 'Montréal',
		'summary' => 'Operator capital + closed feedback loops. Drafting deal memos for first conversations.',
		'tags'    => array( 'Capital', 'Climate' ),
	),
	array(
		'initial' => 'R',
		'name'    => 'Rina Patel',
		'meta'    => 'Health systems · Toronto',
		'vertical'=> 'consulting',
		'city'    => 'Toronto',
		'summary' => 'Hospital operations and private clinic networks. Seeking partners on staffing models.',
		'tags'    => array( 'Health', 'Ops' ),
	),
	array(
		'initial' => 'L',
		'name'    => 'Luis Navarro',
		'meta'    => 'Private credit · CDMX',
		'vertical'=> 'mfo',
		'city'    => 'CDMX',
		'summary' => 'Structures private credit for hospitality and property groups across LatAm.',
		'tags'    => array( 'Credit', 'LatAm' ),
	),
	array(
		'initial' => 'S',
		'name'    => 'Sofia Berg',
		'meta'    => 'Design ops · Stockholm',
		'vertical'=> 'club_event',
		'city'    => 'Stockholm',
		'summary' => 'Design and production systems for clubs and festivals. Open to EU collaborations.',
		'tags'    => array( 'Events', 'EU' ),
	),
	array(
		'initial' => 'E',
		'name'    => 'Elise Cho',
		'meta'    => 'Supply chain · Seoul',
		'vertical'=> 'marketplace',
		'city'    => 'Seoul',
		'summary' => 'Last-mile logistics software. Looking for operators — not pitch decks.',
		'tags'    => array( 'Logistics', 'Selective' ),
	),
);
?>
<main id="main" class="xciv-shell xciv-directory" data-xciv-directory>
	<header class="xciv-section-head xciv-section-head--split">
		<div>
			<h1><?php esc_html_e( 'People', 'xciv-social' ); ?></h1>
			<p><?php esc_html_e( 'Find operators by vertical, city, and contribution focus.', 'xciv-social' ); ?></p>
		</div>
		<div class="xciv-section-head__actions">
			<span class="xciv-muted" data-directory-count><?php echo esc_html( sprintf( /* translators: %d: member count */ _n( '%d member', '%d members', count( $members ), 'xciv-social' ), count( $members ) ) ); ?></span>
		</div>
	</header>

	<section class="xciv-panel xciv-filters" data-directory-filters>
		<div class="xciv-panel__body">
			<form class="xciv-filter-row" action="#" method="get">
				<label>
					<span class="screen-reader-text"><?php esc_html_e( 'Search members', 'xciv-social' ); ?></span>
					<input type="search" name="q" placeholder="<?php esc_attr_e( 'Name, firm, or keyword…', 'xciv-social' ); ?>" data-directory-search>
				</label>
				<label>
					<span class="screen-reader-text"><?php esc_html_e( 'Vertical', 'xciv-social' ); ?></span>
					<select name="vertical" data-directory-vertical>
						<option value=""><?php esc_html_e( 'All verticals', 'xciv-social' ); ?></option>
						<option value="mfo"><?php esc_html_e( 'MFO', 'xciv-social' ); ?></option>
						<option value="hospitality"><?php esc_html_e( 'Hospitality', 'xciv-social' ); ?></option>
						<option value="nightlife"><?php esc_html_e( 'Nightlife', 'xciv-social' ); ?></option>
						<option value="club_event"><?php esc_html_e( 'Club & event', 'xciv-social' ); ?></option>
						<option value="property"><?php esc_html_e( 'Property', 'xciv-social' ); ?></option>
						<option value="consulting"><?php esc_html_e( 'Consulting', 'xciv-social' ); ?></option>
						<option value="fintech"><?php esc_html_e( 'Fintech', 'xciv-social' ); ?></option>
						<option value="marketplace"><?php esc_html_e( 'Marketplace', 'xciv-social' ); ?></option>
					</select>
				</label>
				<label>
					<span class="screen-reader-text"><?php esc_html_e( 'City', 'xciv-social' ); ?></span>
					<input type="text" name="city" placeholder="<?php esc_attr_e( 'City', 'xciv-social' ); ?>" data-directory-city>
				</label>
				<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Search', 'xciv-social' ); ?></button>
			</form>
		</div>
	</section>

	<section class="xciv-directory__grid" data-directory-grid>
		<?php foreach ( $members as $member ) : ?>
			<article
				class="xciv-member-card"
				data-name="<?php echo esc_attr( strtolower( $member['name'] ) ); ?>"
				data-vertical="<?php echo esc_attr( $member['vertical'] ); ?>"
				data-city="<?php echo esc_attr( strtolower( $member['city'] ) ); ?>"
				data-summary="<?php echo esc_attr( strtolower( $member['summary'] ) ); ?>"
			>
				<div class="xciv-member-card__top">
					<div class="xciv-avatar xciv-avatar--lg" aria-hidden="true"><span><?php echo esc_html( $member['initial'] ); ?></span></div>
					<div class="xciv-member-card__identity">
						<h2 class="xciv-member-card__name"><?php echo esc_html( $member['name'] ); ?></h2>
						<p class="xciv-muted"><?php echo esc_html( $member['meta'] ); ?></p>
					</div>
				</div>
				<p class="xciv-member-card__summary"><?php echo esc_html( $member['summary'] ); ?></p>
				<ul class="xciv-tag-row">
					<?php foreach ( $member['tags'] as $tag ) : ?>
						<li><?php echo esc_html( $tag ); ?></li>
					<?php endforeach; ?>
				</ul>
				<div class="xciv-action-row">
					<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/profile/' ) ); ?>"><?php esc_html_e( 'View', 'xciv-social' ); ?></a>
					<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/messages/' ) ); ?>"><?php esc_html_e( 'Message', 'xciv-social' ); ?></a>
					<button type="button" class="xciv-btn xciv-btn--primary" data-connect><?php esc_html_e( 'Connect', 'xciv-social' ); ?></button>
				</div>
			</article>
		<?php endforeach; ?>
	</section>

	<p class="xciv-feed-empty xciv-muted" data-directory-empty hidden><?php esc_html_e( 'No members match these filters.', 'xciv-social' ); ?></p>
</main>
<?php
get_footer();
