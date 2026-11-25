<?php
/**
 * Template Name: Member Feed
 *
 * @package XCIV_Social
 */

get_template_part( 'template-parts/member/require', 'member' );
get_header();

$current_user = wp_get_current_user();
$display_name = $current_user->display_name ? $current_user->display_name : __( 'Member', 'xciv-social' );
$initial     = strtoupper( substr( $display_name, 0, 1 ) );
?>
<main id="main" class="xciv-shell xciv-feed" data-xciv-feed-page>
	<header class="xciv-section-head xciv-section-head--split">
		<div>
			<h1><?php esc_html_e( 'Feed', 'xciv-social' ); ?></h1>
			<p><?php esc_html_e( 'Ideas, introductions, and business contributions from approved members.', 'xciv-social' ); ?></p>
		</div>
		<div class="xciv-section-head__actions">
			<button type="button" class="xciv-btn xciv-btn--ghost" data-feed-refresh><?php esc_html_e( 'Refresh', 'xciv-social' ); ?></button>
		</div>
	</header>

	<div class="xciv-feed__layout">
		<div class="xciv-feed__main">
			<section class="xciv-panel xciv-composer" data-xciv-composer>
				<div class="xciv-composer__top">
					<div class="xciv-avatar" aria-hidden="true">
						<span><?php echo esc_html( $initial ); ?></span>
					</div>
					<div class="xciv-composer__fields">
						<p class="xciv-composer__who">
							<?php
							printf(
								/* translators: %s: member display name */
								esc_html__( 'Posting as %s', 'xciv-social' ),
								esc_html( $display_name )
							);
							?>
						</p>
						<label for="xciv-post-body" class="screen-reader-text"><?php esc_html_e( 'New post', 'xciv-social' ); ?></label>
						<textarea
							id="xciv-post-body"
							rows="3"
							maxlength="1200"
							placeholder="<?php esc_attr_e( 'Share an idea, introduction, or opportunity…', 'xciv-social' ); ?>"
							data-composer-body
						></textarea>
					</div>
				</div>

				<div class="xciv-composer__types" role="group" aria-label="<?php esc_attr_e( 'Post type', 'xciv-social' ); ?>">
					<button type="button" class="xciv-chip is-active" data-post-type="idea" aria-pressed="true"><?php esc_html_e( 'Idea', 'xciv-social' ); ?></button>
					<button type="button" class="xciv-chip" data-post-type="introduction" aria-pressed="false"><?php esc_html_e( 'Introduction', 'xciv-social' ); ?></button>
					<button type="button" class="xciv-chip" data-post-type="opportunity" aria-pressed="false"><?php esc_html_e( 'Opportunity', 'xciv-social' ); ?></button>
				</div>

				<footer class="xciv-composer__foot">
					<span class="xciv-muted xciv-composer__count" data-char-count>0 / 1200</span>
					<button type="button" class="xciv-btn xciv-btn--primary" data-publish><?php esc_html_e( 'Post', 'xciv-social' ); ?></button>
				</footer>
			</section>

			<nav class="xciv-feed-filters" data-feed-filters aria-label="<?php esc_attr_e( 'Filter feed', 'xciv-social' ); ?>">
				<button type="button" class="xciv-feed-filters__btn is-active" data-filter="all" aria-pressed="true"><?php esc_html_e( 'All', 'xciv-social' ); ?></button>
				<button type="button" class="xciv-feed-filters__btn" data-filter="idea" aria-pressed="false"><?php esc_html_e( 'Ideas', 'xciv-social' ); ?></button>
				<button type="button" class="xciv-feed-filters__btn" data-filter="introduction" aria-pressed="false"><?php esc_html_e( 'Introductions', 'xciv-social' ); ?></button>
				<button type="button" class="xciv-feed-filters__btn" data-filter="opportunity" aria-pressed="false"><?php esc_html_e( 'Opportunities', 'xciv-social' ); ?></button>
			</nav>

			<section class="xciv-feed-list" data-xciv-feed aria-live="polite">
				<article class="xciv-feed-item" data-type="opportunity" data-post-id="demo-1">
					<header class="xciv-feed-item__head">
						<a class="xciv-avatar" href="<?php echo esc_url( home_url( '/profile/' ) ); ?>" aria-hidden="true"><span>M</span></a>
						<div class="xciv-feed-item__meta">
							<div class="xciv-feed-item__byline">
								<a class="xciv-feed-item__name" href="<?php echo esc_url( home_url( '/profile/' ) ); ?>"><?php esc_html_e( 'Maya Okonkwo', 'xciv-social' ); ?></a>
								<span class="xciv-feed-item__badge" data-type-label><?php esc_html_e( 'Opportunity', 'xciv-social' ); ?></span>
							</div>
							<p class="xciv-muted xciv-feed-item__sub">
								<?php esc_html_e( 'Fintech · Lagos', 'xciv-social' ); ?>
								<span aria-hidden="true"> · </span>
								<time datetime="2026-11-24T14:10:00"><?php esc_html_e( '2h ago', 'xciv-social' ); ?></time>
							</p>
						</div>
					</header>
					<div class="xciv-feed-item__body">
						<p><?php esc_html_e( 'Looking for a warm intro to operators running cross-border remittance corridors in West Africa. We have distribution; need compliance-aware partners who already clear volume.', 'xciv-social' ); ?></p>
						<aside class="xciv-feed-item__card">
							<span class="xciv-feed-item__card-label"><?php esc_html_e( 'Ask', 'xciv-social' ); ?></span>
							<strong><?php esc_html_e( 'Warm intros · Compliance-ready remittance operators', 'xciv-social' ); ?></strong>
						</aside>
					</div>
					<footer class="xciv-feed-item__actions">
						<button type="button" class="xciv-feed-action" data-appreciate>
							<span data-appreciate-label><?php esc_html_e( 'Appreciate', 'xciv-social' ); ?></span>
							<span class="xciv-feed-action__count" data-appreciate-count>12</span>
						</button>
						<button type="button" class="xciv-feed-action" data-comment><?php esc_html_e( 'Comment', 'xciv-social' ); ?> <span class="xciv-feed-action__count">4</span></button>
						<button type="button" class="xciv-feed-action" data-introduce><?php esc_html_e( 'Offer intro', 'xciv-social' ); ?></button>
					</footer>
				</article>

				<article class="xciv-feed-item" data-type="idea" data-post-id="demo-2">
					<header class="xciv-feed-item__head">
						<a class="xciv-avatar" href="<?php echo esc_url( home_url( '/profile/' ) ); ?>" aria-hidden="true"><span>J</span></a>
						<div class="xciv-feed-item__meta">
							<div class="xciv-feed-item__byline">
								<a class="xciv-feed-item__name" href="<?php echo esc_url( home_url( '/profile/' ) ); ?>"><?php esc_html_e( 'Jonah Reyes', 'xciv-social' ); ?></a>
								<span class="xciv-feed-item__badge" data-type-label><?php esc_html_e( 'Idea', 'xciv-social' ); ?></span>
							</div>
							<p class="xciv-muted xciv-feed-item__sub">
								<?php esc_html_e( 'Hospitality · Miami', 'xciv-social' ); ?>
								<span aria-hidden="true"> · </span>
								<time datetime="2026-11-24T11:40:00"><?php esc_html_e( '5h ago', 'xciv-social' ); ?></time>
							</p>
						</div>
					</header>
					<div class="xciv-feed-item__body">
						<p><?php esc_html_e( 'What if members hosted quarterly “table dinners” with a hard rule: one introduction offered before dessert? Small rooms beat large mixers for trust. Interested in piloting this in three cities.', 'xciv-social' ); ?></p>
					</div>
					<footer class="xciv-feed-item__actions">
						<button type="button" class="xciv-feed-action is-active" data-appreciate aria-pressed="true">
							<span data-appreciate-label><?php esc_html_e( 'Appreciated', 'xciv-social' ); ?></span>
							<span class="xciv-feed-action__count" data-appreciate-count>28</span>
						</button>
						<button type="button" class="xciv-feed-action" data-comment><?php esc_html_e( 'Comment', 'xciv-social' ); ?> <span class="xciv-feed-action__count">9</span></button>
						<button type="button" class="xciv-feed-action" data-introduce><?php esc_html_e( 'Offer intro', 'xciv-social' ); ?></button>
					</footer>
				</article>

				<article class="xciv-feed-item" data-type="introduction" data-post-id="demo-3">
					<header class="xciv-feed-item__head">
						<a class="xciv-avatar" href="<?php echo esc_url( home_url( '/profile/' ) ); ?>" aria-hidden="true"><span>A</span></a>
						<div class="xciv-feed-item__meta">
							<div class="xciv-feed-item__byline">
								<a class="xciv-feed-item__name" href="<?php echo esc_url( home_url( '/profile/' ) ); ?>"><?php esc_html_e( 'Amira Haddad', 'xciv-social' ); ?></a>
								<span class="xciv-feed-item__badge" data-type-label><?php esc_html_e( 'Introduction', 'xciv-social' ); ?></span>
							</div>
							<p class="xciv-muted xciv-feed-item__sub">
								<?php esc_html_e( 'Media · Dubai', 'xciv-social' ); ?>
								<span aria-hidden="true"> · </span>
								<time datetime="2026-11-23T18:00:00"><?php esc_html_e( 'Yesterday', 'xciv-social' ); ?></time>
							</p>
						</div>
					</header>
					<div class="xciv-feed-item__body">
						<p><?php esc_html_e( 'Introducing Elise Cho (supply-chain software, Seoul) to anyone building last-mile logistics in GCC markets. Elise is selective, sharp, and looking for operators—not pitch decks.', 'xciv-social' ); ?></p>
						<aside class="xciv-feed-item__card xciv-feed-item__card--people">
							<div class="xciv-feed-item__people">
								<span class="xciv-avatar" aria-hidden="true"><span>E</span></span>
								<span>
									<strong><?php esc_html_e( 'Elise Cho', 'xciv-social' ); ?></strong>
									<small class="xciv-muted"><?php esc_html_e( 'Supply chain · Seoul', 'xciv-social' ); ?></small>
								</span>
							</div>
						</aside>
					</div>
					<footer class="xciv-feed-item__actions">
						<button type="button" class="xciv-feed-action" data-appreciate>
							<span data-appreciate-label><?php esc_html_e( 'Appreciate', 'xciv-social' ); ?></span>
							<span class="xciv-feed-action__count" data-appreciate-count>17</span>
						</button>
						<button type="button" class="xciv-feed-action" data-comment><?php esc_html_e( 'Comment', 'xciv-social' ); ?> <span class="xciv-feed-action__count">6</span></button>
						<button type="button" class="xciv-feed-action" data-introduce><?php esc_html_e( 'Request intro', 'xciv-social' ); ?></button>
					</footer>
				</article>

				<article class="xciv-feed-item" data-type="idea" data-post-id="demo-4">
					<header class="xciv-feed-item__head">
						<a class="xciv-avatar" href="<?php echo esc_url( home_url( '/profile/' ) ); ?>" aria-hidden="true"><span>T</span></a>
						<div class="xciv-feed-item__meta">
							<div class="xciv-feed-item__byline">
								<a class="xciv-feed-item__name" href="<?php echo esc_url( home_url( '/profile/' ) ); ?>"><?php esc_html_e( 'Theo Marchand', 'xciv-social' ); ?></a>
								<span class="xciv-feed-item__badge" data-type-label><?php esc_html_e( 'Idea', 'xciv-social' ); ?></span>
							</div>
							<p class="xciv-muted xciv-feed-item__sub">
								<?php esc_html_e( 'Climate tech · Montréal', 'xciv-social' ); ?>
								<span aria-hidden="true"> · </span>
								<time datetime="2026-11-23T09:20:00"><?php esc_html_e( 'Yesterday', 'xciv-social' ); ?></time>
							</p>
						</div>
					</header>
					<div class="xciv-feed-item__body">
						<p><?php esc_html_e( 'Sharing a working thesis: member capital + operator sweat + closed feedback loops beats open venture theater. Drafting a lightweight deal memo template for first conversations inside XCIV.', 'xciv-social' ); ?></p>
					</div>
					<footer class="xciv-feed-item__actions">
						<button type="button" class="xciv-feed-action" data-appreciate>
							<span data-appreciate-label><?php esc_html_e( 'Appreciate', 'xciv-social' ); ?></span>
							<span class="xciv-feed-action__count" data-appreciate-count>21</span>
						</button>
						<button type="button" class="xciv-feed-action" data-comment><?php esc_html_e( 'Comment', 'xciv-social' ); ?> <span class="xciv-feed-action__count">3</span></button>
						<button type="button" class="xciv-feed-action" data-introduce><?php esc_html_e( 'Offer intro', 'xciv-social' ); ?></button>
					</footer>
				</article>

				<p class="xciv-feed-empty xciv-muted" data-feed-empty hidden><?php esc_html_e( 'Nothing in this lane yet. Switch filters or post the first note.', 'xciv-social' ); ?></p>
			</section>
		</div>

		<aside class="xciv-feed__aside">
			<section class="xciv-panel" data-feed-pulse>
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'This week', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Signals moving through the room.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<ul class="xciv-feed-stats">
						<li>
							<strong>38</strong>
							<span class="xciv-muted"><?php esc_html_e( 'New posts', 'xciv-social' ); ?></span>
						</li>
						<li>
							<strong>14</strong>
							<span class="xciv-muted"><?php esc_html_e( 'Open intros', 'xciv-social' ); ?></span>
						</li>
						<li>
							<strong>9</strong>
							<span class="xciv-muted"><?php esc_html_e( 'Opportunities', 'xciv-social' ); ?></span>
						</li>
					</ul>
				</div>
			</section>

			<section class="xciv-panel" data-feed-spotlight>
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Worth a look', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Members circulating this week.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<ul class="xciv-feed-spotlight">
						<li>
							<span class="xciv-avatar" aria-hidden="true"><span>R</span></span>
							<span class="xciv-feed-spotlight__copy">
								<strong><?php esc_html_e( 'Rina Patel', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Health systems · Toronto', 'xciv-social' ); ?></small>
							</span>
						</li>
						<li>
							<span class="xciv-avatar" aria-hidden="true"><span>L</span></span>
							<span class="xciv-feed-spotlight__copy">
								<strong><?php esc_html_e( 'Luis Navarro', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Private credit · CDMX', 'xciv-social' ); ?></small>
							</span>
						</li>
						<li>
							<span class="xciv-avatar" aria-hidden="true"><span>S</span></span>
							<span class="xciv-feed-spotlight__copy">
								<strong><?php esc_html_e( 'Sofia Berg', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Design ops · Stockholm', 'xciv-social' ); ?></small>
							</span>
						</li>
					</ul>
					<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/people/' ) ); ?>"><?php esc_html_e( 'Browse people', 'xciv-social' ); ?></a>
				</div>
			</section>
		</aside>
	</div>
</main>
<?php
get_footer();
