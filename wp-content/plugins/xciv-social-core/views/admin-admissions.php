<?php
/**
 * Admissions queue view.
 *
 * @package XCIV_Social_Core
 * @var array<int,array<string,mixed>>|null $rows
 * @var array{pending:int,approved:int,rejected:int,total:int} $counts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$answer_labels = array(
	'sovereignty' => __( 'Sovereignty', 'xciv-social-core' ),
	'lifestyle'   => __( 'Lifestyle', 'xciv-social-core' ),
	'bring'       => __( 'Contribution', 'xciv-social-core' ),
	'seek'        => __( 'Seeking', 'xciv-social-core' ),
	'proof_url'   => __( 'Proof link', 'xciv-social-core' ),
);

$vertical_labels = array(
	'mfo'         => __( 'Multi-family office', 'xciv-social-core' ),
	'hospitality' => __( 'Hospitality', 'xciv-social-core' ),
	'club_event'  => __( 'Club & event', 'xciv-social-core' ),
	'nightlife'   => __( 'Nightlife', 'xciv-social-core' ),
	'marketplace' => __( 'Marketplace', 'xciv-social-core' ),
	'property'    => __( 'Property', 'xciv-social-core' ),
	'consulting'  => __( 'Consulting', 'xciv-social-core' ),
	'organizer'   => __( 'Event organizer', 'xciv-social-core' ),
	'partygoer'   => __( 'Partygoer', 'xciv-social-core' ),
	'holding'     => __( 'Holding company', 'xciv-social-core' ),
	'other'       => __( 'Other', 'xciv-social-core' ),
);

$updated = isset( $_GET['updated'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$error   = isset( $_GET['error'] ) ? sanitize_key( wp_unslash( (string) $_GET['error'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>
<div class="wrap xciv-admin xciv-admin--admissions">
	<header class="xciv-admin__hero">
		<div>
			<p class="xciv-admin__eyebrow"><?php esc_html_e( 'Membership', 'xciv-social-core' ); ?></p>
			<h1><?php esc_html_e( 'Admissions', 'xciv-social-core' ); ?></h1>
			<p class="xciv-admin__lede">
				<?php esc_html_e( 'Review pending applicants. Approve only those who align with XCIV standards.', 'xciv-social-core' ); ?>
			</p>
		</div>
		<div class="xciv-admin__hero-actions">
			<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=xciv-social' ) ); ?>">
				<?php esc_html_e( '← Dashboard', 'xciv-social-core' ); ?>
			</a>
			<a class="button button-primary" href="<?php echo esc_url( home_url( '/request-admission/' ) ); ?>" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'View form', 'xciv-social-core' ); ?>
			</a>
		</div>
	</header>

	<?php if ( $updated ) : ?>
		<div class="xciv-admin__notice xciv-admin__notice--ok" role="status">
			<?php esc_html_e( 'Application updated.', 'xciv-social-core' ); ?>
		</div>
	<?php elseif ( 'missing' === $error ) : ?>
		<div class="xciv-admin__notice xciv-admin__notice--err" role="alert">
			<?php esc_html_e( 'That application could not be found.', 'xciv-social-core' ); ?>
		</div>
	<?php endif; ?>

	<section class="xciv-admin__stats xciv-admin__stats--3" aria-label="<?php esc_attr_e( 'Admission snapshot', 'xciv-social-core' ); ?>">
		<article class="xciv-admin__stat">
			<p class="xciv-admin__stat-label"><?php esc_html_e( 'Pending review', 'xciv-social-core' ); ?></p>
			<p class="xciv-admin__stat-value"><?php echo esc_html( (string) $counts['pending'] ); ?></p>
			<span class="xciv-admin__stat-hint"><?php esc_html_e( 'In the queue below', 'xciv-social-core' ); ?></span>
		</article>
		<article class="xciv-admin__stat">
			<p class="xciv-admin__stat-label"><?php esc_html_e( 'Approved', 'xciv-social-core' ); ?></p>
			<p class="xciv-admin__stat-value"><?php echo esc_html( (string) $counts['approved'] ); ?></p>
			<span class="xciv-admin__stat-hint"><?php esc_html_e( 'Granted membership', 'xciv-social-core' ); ?></span>
		</article>
		<article class="xciv-admin__stat">
			<p class="xciv-admin__stat-label"><?php esc_html_e( 'Rejected', 'xciv-social-core' ); ?></p>
			<p class="xciv-admin__stat-value"><?php echo esc_html( (string) $counts['rejected'] ); ?></p>
			<span class="xciv-admin__stat-hint"><?php esc_html_e( 'Did not meet standards', 'xciv-social-core' ); ?></span>
		</article>
	</section>

	<?php if ( empty( $rows ) ) : ?>
		<section class="xciv-admin__empty">
			<p class="xciv-admin__empty-title"><?php esc_html_e( 'Queue is clear', 'xciv-social-core' ); ?></p>
			<p class="xciv-admin__muted">
				<?php esc_html_e( 'No pending applications. New submissions from the Admission Intelligence form will appear here.', 'xciv-social-core' ); ?>
			</p>
			<p class="xciv-admin__card-actions">
				<a class="button" href="<?php echo esc_url( home_url( '/request-admission/' ) ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Open admission form', 'xciv-social-core' ); ?>
				</a>
			</p>
		</section>
	<?php else : ?>
		<div class="xciv-admin__queue">
			<?php foreach ( $rows as $row ) : ?>
				<?php
				$answers = json_decode( (string) $row['answers'], true );
				if ( ! is_array( $answers ) ) {
					$answers = array();
				}
				$vertical_key = (string) $row['vertical'];
				$vertical     = $vertical_labels[ $vertical_key ] ?? $vertical_key;
				$created      = (string) $row['created_at'];
				?>
				<section class="xciv-admin__card xciv-admin__applicant">
					<header class="xciv-admin__applicant-head">
						<div>
							<p class="xciv-admin__applicant-meta">
								<span class="xciv-admin__pill"><?php echo esc_html( $vertical ); ?></span>
								<?php if ( $created ) : ?>
									<span class="xciv-admin__muted">
										<?php
										printf(
											/* translators: %s: datetime */
											esc_html__( 'Submitted %s', 'xciv-social-core' ),
											esc_html( $created )
										);
										?>
									</span>
								<?php endif; ?>
							</p>
							<h2><?php echo esc_html( (string) $row['full_name'] ); ?></h2>
							<p class="xciv-admin__applicant-email">
								<a href="mailto:<?php echo esc_attr( (string) $row['email'] ); ?>">
									<?php echo esc_html( (string) $row['email'] ); ?>
								</a>
							</p>
						</div>
						<span class="xciv-admin__status xciv-admin__status--pending">
							<?php esc_html_e( 'Pending', 'xciv-social-core' ); ?>
						</span>
					</header>

					<?php if ( ! empty( $answers ) ) : ?>
						<dl class="xciv-admin__answers">
							<?php foreach ( $answers as $key => $value ) : ?>
								<?php
								$key_str = (string) $key;
								$label   = $answer_labels[ $key_str ] ?? ucwords( str_replace( '_', ' ', $key_str ) );
								$value_str = (string) $value;
								if ( '' === trim( $value_str ) ) {
									continue;
								}
								?>
								<div>
									<dt><?php echo esc_html( $label ); ?></dt>
									<dd>
										<?php if ( 'proof_url' === $key_str ) : ?>
											<a href="<?php echo esc_url( $value_str ); ?>" target="_blank" rel="noopener noreferrer">
												<?php echo esc_html( $value_str ); ?>
											</a>
										<?php else : ?>
											<?php echo esc_html( $value_str ); ?>
										<?php endif; ?>
									</dd>
								</div>
							<?php endforeach; ?>
						</dl>
					<?php endif; ?>

					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="xciv-admin__review">
						<?php wp_nonce_field( 'xciv_review_admission' ); ?>
						<input type="hidden" name="action" value="xciv_review_admission">
						<input type="hidden" name="application_id" value="<?php echo esc_attr( (string) $row['id'] ); ?>">
						<label class="xciv-admin__notes-label">
							<span><?php esc_html_e( 'Owner notes', 'xciv-social-core' ); ?></span>
							<textarea name="owner_notes" rows="3" class="large-text"><?php echo esc_textarea( (string) $row['owner_notes'] ); ?></textarea>
						</label>
						<div class="xciv-admin__review-actions">
							<button type="submit" name="review_action" value="approve" class="button button-primary">
								<?php esc_html_e( 'Approve', 'xciv-social-core' ); ?>
							</button>
							<button type="submit" name="review_action" value="reject" class="button">
								<?php esc_html_e( 'Reject', 'xciv-social-core' ); ?>
							</button>
						</div>
					</form>
				</section>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
