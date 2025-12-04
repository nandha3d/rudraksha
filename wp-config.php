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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'G: )r^*=NP`&,qf>)74?PO~O9!Uccz:q~Xucs}CwOg$naD3h+|S4vgU4kK2oC.sJ' );
define( 'SECURE_AUTH_KEY',   ' =TZ)-.51vQ(ZZ9JzFeuc*ZFu]53=-*=$q4ExD{yo*e=@b{>pM ll~aEMah6kOnO' );
define( 'LOGGED_IN_KEY',     'obP$_A=Huy*Zu>brGoQQdMIGz3HH9Kzr`[<Mu.0E:F>BY5D&{Bt:`[8x,jT{ek)2' );
define( 'NONCE_KEY',         'oFSv+~3Yq}6f)`GT.}&aK?A_aTkkAJW{3K[UETQRg;gZ=r#{&%;pzQW$H^HytNj3' );
define( 'AUTH_SALT',         '[3`h]a7`#o[/ty.7aKOOr*<$Tq,,k*3c|PrZpXs]>unr&1)$d^i5VU=2sC#]QOLp' );
define( 'SECURE_AUTH_SALT',  'bA./)C6RH^r0(LY-dNs?E8?F9,W>bz(lH32k^G%1ra[PuhI/^u<F+T*@<kr5|C/6' );
define( 'LOGGED_IN_SALT',    'O=5%HvfG3xZ3&XsCCIl<&`7m8=PY|ZM-TIQXBR3rTmAb6Da}!X&PE1i`;!y2btf>' );
define( 'NONCE_SALT',        'nAHL+^*s2dUzlQ;ZOWVT2|.%khq?l:[f!qP^x7&M,M4J<M=rZJ2NU>/lno88PgmI' );
define( 'WP_CACHE_KEY_SALT', '/Qp0xi1<iZ6[;z)SGP3_L-Z@boHPQpbuE%tL[lK,Q]3YfWt]R_=ODa9(Lt.zg%zf' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
