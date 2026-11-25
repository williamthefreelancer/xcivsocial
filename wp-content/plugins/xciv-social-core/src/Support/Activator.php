<?php
/**
 * Activation: roles + DB tables.
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Support;

use XCIV\Core\Services\RolesService;
use XCIV\Core\Models\ApplicationTable;
use XCIV\Core\Models\WaitlistTable;

final class Activator {

	public static function activate(): void {
		RolesService::register_roles();
		ApplicationTable::create();
		WaitlistTable::create();
		flush_rewrite_rules();
	}

	public static function deactivate(): void {
		flush_rewrite_rules();
	}
}
