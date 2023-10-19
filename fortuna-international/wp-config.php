<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'fortuna-international' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'YU[6!@e0#:W{NIw:ho+gsT#Q_^D:>5Rnmdzsb8nkEU@&)@BjE8V9[F9:cb<<L|Ph' );
define( 'SECURE_AUTH_KEY',  ',,E*JLXPh>V#Gxha9u!q[E` UC0)@d62(9V7eTqte`*z#0ap$qGKgmo:K?C[`~Wu' );
define( 'LOGGED_IN_KEY',    ';qTQs&us[j&z6hn]I`Zi!~Je1qE`Lwzdb%uiwtx *nT$,@TNP +k[R+TUq+0a!en' );
define( 'NONCE_KEY',        'K7|1*Ka6Nt.Se^L2/TgxwR~92-E^}@4#W$5r`1ev%4$0>nJKnsf!mk:Zv_zuv4<T' );
define( 'AUTH_SALT',        '51m0Nc;TilD0T9Pnp@/i~9SP>`V@xA%z^?o[-?{0PQ2f`U_^4<&ORMd%A3%KXxYM' );
define( 'SECURE_AUTH_SALT', '-R;Lu*T)Dz>Y)oIEZjZti_QT(=l;wn/!y` $0,tTgXyh$0>^pu}O1^SP()kcom3v' );
define( 'LOGGED_IN_SALT',   '.T7}&6CQ8wGNWy3*7HiY7tzl}j2FNqLbEkD>M2Vgb`$s=iM{ZyoLk(pVFZ:x7Ukr' );
define( 'NONCE_SALT',       '3f=Mbhg{GWIdSzWw)1ww4E%aI*3>!]r :p]/yiv^gT3UjCigxrYbeoV8N2xE/>E7' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
