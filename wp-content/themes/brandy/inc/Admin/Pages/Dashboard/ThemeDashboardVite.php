<?php
/**
 * Handle DashboardVite admin app.
 *
 * @package Brandy\Class
 */

namespace Brandy\Admin\Pages\Dashboard;

/**
 * Declare class
 */
class ThemeDashboardVite {

	private static $root = 'src';

	private static $path_to_dist = '/assets/dist/dashboard/';

	/**
	 * Get path of build files.
	 */
	public static function base_path() {
		return BRANDY_TEMPLATE_URL . self::$path_to_dist;
	}

	/**
	 * Enqueue build scripts.
	 *
	 * @param string $script Name of script file.
	 * @param string $port Current when run dev.
	 */
	public static function enqueue_vite( $script = 'main.tsx', $port = '3005' ) {
		self::enqueue_preload( $script, $port );
		self::css_tag( $script );
		self::register( $script, $port );
		add_filter(
			'script_loader_tag',
			function ( $tag, $handle, $src ) {
				if ( str_contains( $handle, 'module/brandy-theme-dashboard/' ) ) {
					$str  = "type='module'";
					$str .= true ? ' crossorigin' : '';
					$tag  = '<script ' . $str . ' src="' . esc_url( $src ) . '" id="' . esc_attr( $handle ) . '-js"></script>';
				}
				return $tag;
			},
			10,
			3
		);

		add_filter(
			'script_loader_src',
			function( $src, $handle ) {
				if ( str_contains( $handle, 'module/brandy-theme-dashboard/vite' ) && strpos( $src, '?ver=' ) ) {
					return remove_query_arg( 'ver', $src );
				}
				return $src;
			},
			10,
			2
		);
	}

	/**
	 * Enqueue script
	 *
	 * @param string $script Name of script file.
	 * @param string $port Current when run dev.
	 */
	public static function enqueue_preload( $script, $port ) {
		add_action(
			'admin_head',
			function() use ( $script, $port ) {
				self::js_preload_imports( $script, $port );
			}
		);
	}

	/**
	 * Register script
	 *
	 * @param string $entry Name of script file.
	 * @param string $port Current when run dev.
	 */
	public static function register( $entry, $port ) {
		$url = constant( 'BRANDY_IS_DEVELOPMENT' )
		? "http://localhost:$port/src/$entry"
		: self::asset_url( $entry );

		if ( ! $url ) {
			return '';
		}
		if ( constant( 'BRANDY_IS_DEVELOPMENT' ) ) {
			wp_enqueue_script( 'module/brandy-theme-dashboard/vite', "http://localhost:$port/@vite/client", array( 'react', 'react-dom' ), 1.0, false );
		}
		wp_register_script( "module/brandy-theme-dashboard/$entry", $url, array( 'react', 'react-dom' ), true, true );
		wp_enqueue_script( "module/brandy-theme-dashboard/$entry" );
	}

	/**
	 * Register script
	 *
	 * @param string $entry Name of script file.
	 * @param string $port Current when run dev.
	 */
	private static function js_preload_imports( $entry, $port ) {
		if ( constant( 'BRANDY_IS_DEVELOPMENT' ) ) {
			echo '<script type="module">
			import RefreshRuntime from "http://localhost:' . esc_attr( $port ) . '/@react-refresh"
			RefreshRuntime.injectIntoGlobalHook(window)
			window.$RefreshReg$ = () => {}
			window.$RefreshSig$ = () => (type) => type
			window.__vite_plugin_react_preamble_installed__ = true
			</script>';
		} else {
			foreach ( self::imports_urls( $entry ) as $url ) {
				echo ( '<link rel="modulepreload" href="' . esc_url( $url ) . '">' );
			}
		}

	}

	/**
	 * Register script
	 *
	 * @param string $entry Name of css file.
	 */
	private static function css_tag( $entry ) {
		// not needed on dev, it's inject by Vite.
		if ( constant( 'BRANDY_IS_DEVELOPMENT' ) ) {
			return '';
		}

		$tags = '';
		foreach ( self::css_urls( $entry ) as $key => $url ) {
			wp_register_style( "brandy-theme-dashboard/$key", $url, array(), BRANDY_SCRIPT_VERSION );
			wp_enqueue_style( "brandy-theme-dashboard/$key", $url, array(), BRANDY_SCRIPT_VERSION );
		}
		return $tags;
	}


	/**
	 * Get manifest file
	 */
	private static function get_manifest() {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$content = file_get_contents( BRANDY_TEMPLATE_DIR . self::$path_to_dist . 'manifest.json' );

		return json_decode( $content, true );
	}

	/**
	 * Get asset url
	 *
	 * @param string $entry name of asset file.
	 */
	private static function asset_url( $entry ) {
		$manifest = self::get_manifest();
		$root     = self::$root;
		$key      = "$root/$entry";
		return isset( $manifest[ $key ] )
		? self::base_path() . $manifest[ $key ]['file']
		: self::base_path() . $entry;
	}

	/**
	 * Get asset file url
	 */
	private static function get_public_url_base() {
		return constant( 'BRANDY_IS_DEVELOPMENT' ) ? '/dist/' : self::base_path();
	}

	/**
	 * Import asset files from url
	 *
	 * @param string $entry Entry file.
	 */
	private static function imports_urls( $entry ) {
		$urls     = array();
		$manifest = self::get_manifest();
		$root     = self::$root;
		$key      = "$root/$entry";
		if ( ! empty( $manifest[ $key ]['imports'] ) ) {
			foreach ( $manifest[ $key ]['imports'] as $imports ) {
				$urls[] = self::get_public_url_base() . $manifest[ $imports ]['file'];
			}
		}
		return $urls;
	}

	/**
	 * Get urls of css files
	 *
	 * @param string $entry Entry file.
	 */
	private static function css_urls( $entry ) {
		$urls     = array();
		$manifest = self::get_manifest();
		$root     = self::$root;
		$key      = "$root/$entry";
		if ( ! empty( $manifest[ $key ]['css'] ) ) {
			foreach ( $manifest[ $key ]['css'] as $file ) {
				$urls[ "brandy_entry_$file" ] = self::get_public_url_base() . $file;
			}
		}

		if ( ! empty( $manifest[ $key ]['imports'] ) ) {
			foreach ( $manifest[ $key ]['imports'] as $imports ) {
				if ( ! empty( $manifest[ $imports ]['css'] ) ) {
					foreach ( $manifest[ $imports ]['css'] as $css ) {
						$urls[ "brandy_imports_$css" ] = self::get_public_url_base() . $css;
					}
				}
			}
		}
		return $urls;
	}
}
