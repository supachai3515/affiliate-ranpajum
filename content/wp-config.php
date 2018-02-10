<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'admin_cyberbatt');


/** MySQL database username */
define('DB_USER', 'admin_cyberbatt');


/** MySQL database password */
define('DB_PASSWORD', 'sA1orzSpWR');


/** MySQL hostname */
define('DB_HOST', 'localhost');


/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');


/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'F.cO=Y`lQ@<I/9u?u;nO4pIRo)Ie)W_u`Vy(aJ%H}PsT-%Tgio^X%/I>+I@y*I/u');

define('SECURE_AUTH_KEY',  '}[1&=j8:.4PKq@!X6s@.~(G3*}5GT.@dUD>B&GCoX6mc_J&[#S7]0#4>xgy*hCg2');

define('LOGGED_IN_KEY',    'Z:I#~,)ivoqL=3%zCx5$%CLqX_m+PFPhrfNS!B5uQzhqPb0`LG#odBotjWT{>(X4');

define('NONCE_KEY',        'd471=2+sT<g<H$EY=01v~vgGV3$/}PNLoA/)%Iz$KIEXfBO].U=W^-&@m2wUM^pY');

define('AUTH_SALT',        'Z_7m@?(s8r24]8rXp:AQ!n]T~rVIW&+7aN,Oq|sT1Ni-X%%EA=;eP16 9HunoSti');

define('SECURE_AUTH_SALT', '+]{!z9EN|HuWei5*E,&DOS,<K)z%)F);Q74liW5aH=<A9hU0KkfbbJ5(;F#TyG~j');

define('LOGGED_IN_SALT',   '^bBY~W53^E7G>wN-P<.X7NKksDBdkY+|n0ejVkm$WIFqOE+_=bdaXqVECd/g= C<');

define('NONCE_SALT',       '2$>aLS>EF|7dr8ogZ+_s,l#mMq]shbUW(l2& j#Jm}hNgZ{Hxp8R :|<n7r*GWT4');


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
