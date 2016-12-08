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
define('DB_NAME', 'marinet');

/** MySQL database username */
define('DB_USER', 'georgetour');

/** MySQL database password */
define('DB_PASSWORD', 'f62WdSaTvj9Wnp8y');

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
define('AUTH_KEY',         'D|8+m:A?4~(iB!+$9k2YUwT3E|p^`U{rfP[D22.oM=(Qx]Nj?R#Ob8WjaSE6<BVx');
define('SECURE_AUTH_KEY',  'KGK=)p!cpe<]a)n=3@`FxWbz=o;!NI>U1;y6y[MiG9>4zTwl0al7@9`sP%$ ?w&i');
define('LOGGED_IN_KEY',    '`VS>,e/om=F>p?O*w%hRWKFK_;3=l}HxeI0_Whc+?5BM{2`9%32KSz-qmQ.ckm=r');
define('NONCE_KEY',        'Dai@z:BuX(ZhCNo|G>+tg^{(r;J{u~*D NA_Qk%l]|C}2ewCXSt[=b.a@9phqhk;');
define('AUTH_SALT',        ',(l+bu6TB@&O|^0{R{>PbtC~g``a#j9].oJ<:SKy]Nw23Yr*=Z[NKPQZK.ADINYm');
define('SECURE_AUTH_SALT', 'Au,}8=SWh`xba$D!^c8WrsmZqBxMN}v4>A0(YcNH@;DfMGx;*TLY@C})G3)cp}@u');
define('LOGGED_IN_SALT',   'b[:jIZRa.nYr8Il%z(GB]W/>y71M~g)F.Vy[=)$!>!~(`1 z^O<ikI$W9Rx .:uT');
define('NONCE_SALT',       ')JpRW$KPi_!+0p1MYH3E#$@ >aY8X`IP|4Gu4jn4o^H:;(%a3vK+ ct<^?}*?|IZ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'dbmarinet_';

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
