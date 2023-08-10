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
define( 'DB_NAME', 'itf' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'faker00tX' );

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
define( 'AUTH_KEY',         '_M0$4@~GkP_A&yoy/oOQSd}rewDT4/00$FuUj%WmkVOnK7Et8D}-,kx,$vdb!5OJ' );
define( 'SECURE_AUTH_KEY',  'bK|wjTS1j9-R`.@Fg%7aqB_:4!e3DCz0Cj[F*&kz<DE=8E0:9)AtXd9LN5o7rhRE' );
define( 'LOGGED_IN_KEY',    'M/hxYr,djY-[V8<a7Y`u9Sd3v,Z6~7(GDac[>N4M.8ODuq`Ax8Q0>xYeZ%P=0x*=' );
define( 'NONCE_KEY',        '-y/nHV?8?LZs21Q]_L+=#7_@WR6dj&h8q(^9S@h88Z|rAi9:sTJK[n>6,GVN;v={' );
define( 'AUTH_SALT',        'Vt1/pg|&&&*tc1=21Qk{_(qhc9)98<f:G+pZOn8)2x+ERY(,Ju!*3.d_?mj>Eh]U' );
define( 'SECURE_AUTH_SALT', 'oMNm!|^:3;$PB]YdZ%04xKK-Yc+iRw>Z.Ax#8C^{UZWlpzTeoqb8kY.yY]9L2vso' );
define( 'LOGGED_IN_SALT',   ')62Le^YR+fNUI<un701B;mkHU^E! L=Dck(yEq;V2F/g]WcBNUpQ|mb9kiy}c,sh' );
define( 'NONCE_SALT',       'bvy,olw13d$(%bbOo-[Gv**.&r}V*2DeVk0`P5x%jbD)GPf/3WY+P-Gzo#~6Qm*j' );

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
