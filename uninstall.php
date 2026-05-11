<?php
/**
 * Uninstall Papy3D Hide Admin Bar by Role.
 *
 * @package Papy3DHideAdminBarByRole
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'papy3d_admin_bar_hidden_roles' );

if ( is_multisite() ) {

	$papy3d_sites_ids = get_sites(
		array(
			'fields' => 'ids',
		)
	);

	foreach ( $papy3d_sites_ids as $papy3d_site_id ) {

		switch_to_blog( $papy3d_site_id );

		delete_option( 'papy3d_admin_bar_hidden_roles' );

		restore_current_blog();
	}
}