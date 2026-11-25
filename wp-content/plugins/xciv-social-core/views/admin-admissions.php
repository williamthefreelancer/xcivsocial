<?php
/**
 * Admissions queue view.
 *
 * @package XCIV_Social_Core
 * @var array<int,array<string,mixed>>|null $rows
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap">
	<h1><?php esc_html_e( 'Admission Intelligence', 'xciv-social-core' ); ?></h1>
	<p><?php esc_html_e( 'Review pending applicants. Approve only those who align with XCIV standards.', 'xciv-social-core' ); ?></p>

	<?php if ( empty( $rows ) ) : ?>
		<p><?php esc_html_e( 'No pending applications yet. The queue fills when applicants complete the Admission Intelligence form.', 'xciv-social-core' ); ?></p>
	<?php else : ?>
		<?php foreach ( $rows as $row ) : ?>
			<?php
			$answers = json_decode( (string) $row['answers'], true );
			if ( ! is_array( $answers ) ) {
				$answers = array();
			}
			?>
			<div class="card" style="max-width:720px;padding:1rem;margin:1rem 0;">
				<h2><?php echo esc_html( $row['full_name'] ); ?> <small>(<?php echo esc_html( $row['vertical'] ); ?>)</small></h2>
				<p><strong><?php esc_html_e( 'Email:', 'xciv-social-core' ); ?></strong> <?php echo esc_html( $row['email'] ); ?></p>
				<ul>
					<?php foreach ( $answers as $key => $value ) : ?>
						<li><strong><?php echo esc_html( (string) $key ); ?>:</strong> <?php echo esc_html( (string) $value ); ?></li>
					<?php endforeach; ?>
				</ul>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'xciv_review_admission' ); ?>
					<input type="hidden" name="action" value="xciv_review_admission">
					<input type="hidden" name="application_id" value="<?php echo esc_attr( (string) $row['id'] ); ?>">
					<p>
						<label>
							<?php esc_html_e( 'Owner notes', 'xciv-social-core' ); ?><br>
							<textarea name="owner_notes" rows="3" class="large-text"><?php echo esc_textarea( (string) $row['owner_notes'] ); ?></textarea>
						</label>
					</p>
					<p>
						<button type="submit" name="review_action" value="approve" class="button button-primary"><?php esc_html_e( 'Approve', 'xciv-social-core' ); ?></button>
						<button type="submit" name="review_action" value="reject" class="button"><?php esc_html_e( 'Reject', 'xciv-social-core' ); ?></button>
					</p>
				</form>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
