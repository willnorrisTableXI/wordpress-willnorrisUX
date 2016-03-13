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
define('DB_NAME', 'willnorrisux-wordpress');

/** MySQL database username */
define('DB_USER', 'willnorris');

/** MySQL database password */
define('DB_PASSWORD', 'eBVHqCB7tdni2AbT');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'nv)rT~6mXgc2fADM.#9Uy;s,@~fdnqqL:NV>litL&92&vte!XXPdv7;T yOC|8LF');
define('SECURE_AUTH_KEY',  'Ud;tz#u[6BuR-n]!qkH>)7Nl?Z~Cay-pWAQ(XJA}<5B>V[3Jrc$b&ck8i/n.|]@8');
define('LOGGED_IN_KEY',    'U[rH@MaJ4V-QwlcpWgu,0-}tr2D{K| Q]!8r93@_oYpT9U-C0h-%W&g4<.rvCIeD');
define('NONCE_KEY',        'k11ok<UKSB~TQ=K 8i7!1$A%-AaUlxIPziRw?k.$`V6|7tm7n/85ME|9jpCJv8#l');
define('AUTH_SALT',        '&RAhr>#`nJJj8P4@ZvHG4G^5Ay1B^T%&,c3ZjpCGd0-k2pM*uCu>Lt(e=ga1|EAS');
define('SECURE_AUTH_SALT', 'W&d~f&!#V{+:AP981SsGqv-L%J|o*+NC6aDK?MZM6x4&LEWxOqqJ+& 9/<WP9kwx');
define('LOGGED_IN_SALT',   '=;!E);[EaV4<N|c+u-^NPoM>|SEPDT>?ldxFdj3-./P:-/(-NyKA@s<~IQlW|@T ');
define('NONCE_SALT',       '`AS2LMH3r6<y-3+magzDORAlmq4D+Nq+cC[8t|=`!a07|O3_c`0lb8w}E6|YO9RY');

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
