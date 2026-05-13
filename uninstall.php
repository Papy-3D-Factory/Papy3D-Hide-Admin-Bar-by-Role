<?php
/**
 * Plugin uninstall routine.
 *
 * @package RoleBound_Admin_Toolbar
 */

declare(strict_types=1);

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'rolebound_admin_toolbar_hidden_roles' );
delete_option( 'papy3d_admin_bar_hidden_roles' );
