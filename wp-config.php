<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'PandaPhat2003@' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '1+;7ZPK$ @J3CfGuC4ej$/{^:[fMGKC!d~ m#=u[$_r3cE41{_.]p<eBqr hf/~=' );
define( 'SECURE_AUTH_KEY',  'AwsC->#J[)5ns1Ae R$%iE|6OolR$w3 vMW-ThwS*LP9yjvL*2f7 D?600uG/ag>' );
define( 'LOGGED_IN_KEY',    'W_c(e<X:p{f;*tLqiGq0Qb!r57tnUzu,QtGh:>Ail@poZE}AlA;_Q68J)W<Q_)=R' );
define( 'NONCE_KEY',        '|GO*ffT6jwJM4y9397wy#PMB%@JTUeCKZqbo uXgDVBAA~EJvXh{d:])lifDn+K$' );
define( 'AUTH_SALT',        'Qo.|wT>:gFspgNL8OQ@(Xz9(^~gY7+*d8b&QbZ|FNWa#]cZ~~z21!>T@LSJ{6iTj' );
define( 'SECURE_AUTH_SALT', '8}r2<L1~idwl?!_%E5<~)v(7#{[`Hgf6&Xs_Pw5_=8N1J9O {={A/B^q;Tt[)dPj' );
define( 'LOGGED_IN_SALT',   'X)[s,^h_xD[6F4Q|^|Z8% 2MTjHYD-<g5!:z>?eLCu|P#rj,*mx& nJZ964QN7fz' );
define( 'NONCE_SALT',       'l5 O&ji151$Vp>ou5^]4)35wd,}[3]qA4~RkJ8Vdrp)mAebdphG>Ht1#>M;FL6Gc' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
