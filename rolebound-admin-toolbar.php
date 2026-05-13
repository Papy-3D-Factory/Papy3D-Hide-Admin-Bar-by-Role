<?php
/**	
 * Plugin Name: RoleBound Admin Toolbar
 * Plugin URI: https://github.com/Papy-3D-Factory/RoleBound-Admin-Toolbar
 * Description: Control WordPress admin toolbar visibility on the front end for selected user roles.
 * Version: 1.0.0
 * Requires at least: 6.4
 * Tested up to: 6.9
 * Requires PHP: 8.1
 * Author: papy3d
 * Author URI: https://papy-3d-factory.xyz
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: rolebound-admin-toolbar
 */
 
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class RoleBound_Admin_Toolbar_Controller {

	const OPTION_NAME        = 'rolebound_admin_toolbar_hidden_roles';
	const LEGACY_OPTION_NAME = 'papy3d_admin_bar_hidden_roles';
	const PAGE_SLUG          = 'rolebound-admin-toolbar';

	public function boot() {
		add_action( 'admin_menu', array( $this, 'register_options_screen' ) );
		add_action( 'admin_init', array( $this, 'register_option_storage' ) );
		add_filter( 'show_admin_bar', array( $this, 'control_toolbar_display' ), 1000 );
	}

	public function register_options_screen() {
		add_options_page(
			esc_html__( 'RoleBound Toolbar', 'rolebound-admin-toolbar' ),
			esc_html__( 'RoleBound Toolbar', 'rolebound-admin-toolbar' ),
			'manage_options',
			self::PAGE_SLUG,
			array( $this, 'display_options_screen' )
		);
	}

	public function register_option_storage() {
		register_setting(
			'rolebound_admin_toolbar_roles_group',
			self::OPTION_NAME,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'clean_submitted_roles' ),
				'default'           => array(),
			)
		);
	}

	public function control_toolbar_display( $is_visible ) {
		if ( is_admin() || ! is_user_logged_in() ) {
			return $is_visible;
		}

		$user = wp_get_current_user();

		if ( empty( $user->roles ) ) {
			return $is_visible;
		}

		$hidden_roles = $this->get_hidden_roles();

		if ( empty( $hidden_roles ) ) {
			return $is_visible;
		}

		$matching_roles = array_intersect( $user->roles, $hidden_roles );

		return empty( $matching_roles ) ? $is_visible : false;
	}

	public function clean_submitted_roles( $submitted_value ) {
		if ( ! is_array( $submitted_value ) ) {
			return array();
		}

		$available_roles = array_keys( $this->get_available_roles() );
		$selected_roles  = array_map( 'sanitize_key', $submitted_value );

		return array_values(
			array_intersect( $selected_roles, $available_roles )
		);
	}

	private function get_hidden_roles() {
		$roles = get_option( self::OPTION_NAME, null );

		if ( null === $roles ) {
			$roles = get_option( self::LEGACY_OPTION_NAME, array() );
		}

		if ( ! is_array( $roles ) ) {
			return array();
		}

		return array_map( 'sanitize_key', $roles );
	}

	private function get_available_roles() {
		global $wp_roles;

		if ( ! $wp_roles instanceof WP_Roles ) {
			$wp_roles = new WP_Roles();
		}

		return $wp_roles->get_names();
	}

	public function display_options_screen() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$roles        = $this->get_available_roles();
		$hidden_roles = $this->get_hidden_roles();
		?>

		<div class="wrap">
			<h1><?php esc_html_e( 'RoleBound Admin Toolbar', 'rolebound-admin-toolbar' ); ?></h1>

			<p>
				<?php esc_html_e( 'Choose which user roles should not see the WordPress admin bar on the front end.', 'rolebound-admin-toolbar' ); ?>
			</p>

			<form method="post" action="options.php">
				<?php settings_fields( 'rolebound_admin_toolbar_roles_group' ); ?>

				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row">
								<?php esc_html_e( 'Hidden for roles', 'rolebound-admin-toolbar' ); ?>
							</th>

							<td>
								<?php foreach ( $roles as $role_key => $role_name ) : ?>
									<label style="display:block;margin-bottom:10px;">
										<input
											type="checkbox"
											name="<?php echo esc_attr( self::OPTION_NAME ); ?>[]"
											value="<?php echo esc_attr( $role_key ); ?>"
											<?php checked( in_array( $role_key, $hidden_roles, true ) ); ?>
										>

										<?php echo esc_html( translate_user_role( $role_name ) ); ?>

										<code><?php echo esc_html( $role_key ); ?></code>
									</label>
								<?php endforeach; ?>

								<p class="description">
									<?php esc_html_e( 'The admin bar remains available inside the WordPress dashboard.', 'rolebound-admin-toolbar' ); ?>
								</p>
							</td>
						</tr>
					</tbody>
				</table>

				<?php submit_button(); ?>
			</form>
		</div>

		<?php
	}
}

add_action(
	'plugins_loaded',
	static function() {
		$plugin = new RoleBound_Admin_Toolbar_Controller();
		$plugin->boot();
	}
);