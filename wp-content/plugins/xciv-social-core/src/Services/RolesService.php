<?php
/**
 * Membership roles.
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Services;

final class RolesService {

	public const ROLE_APPLICANT = 'xciv_applicant';
	public const ROLE_PENDING   = 'xciv_pending';
	public const ROLE_MEMBER    = 'xciv_member';

	public static function register_roles(): void {
		add_role(
			self::ROLE_APPLICANT,
			'XCIV Applicant',
			array(
				'read' => true,
			)
		);

		add_role(
			self::ROLE_PENDING,
			'XCIV Pending',
			array(
				'read' => true,
			)
		);

		add_role(
			self::ROLE_MEMBER,
			'XCIV Member',
			array(
				'read'         => true,
				'upload_files' => true,
			)
		);
	}
}
