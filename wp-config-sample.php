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
define('AUTH_KEY',         '+/jW}AbC%c!VkE9Mdj|0[I(Yn+Rcl4C(:RGtgY3[S&OOFG)XP|TJ~g9|DZ*0gg+n');
define('SECURE_AUTH_KEY',  'RkG#DNtZA+:*V#9U}Ce>{/~u2o2i/G?:4|ho1o8oqFSc`Zd!Thm4E.X0Zd3/ O^a');
define('LOGGED_IN_KEY',    'l6T]e#`)GBD2lEV^6{UQ2Eoy@~5ktgO`%Umg]|5U^{,`vE9X9v<#xqJ~m1gDLsGl');
define('NONCE_KEY',        'W-scAyJFh%pD/|Tm|nwN$]x4`qWI|t)yP1v{F/b#*!WAaGqMBNZ0=ivRGYsh@{nD');
define('AUTH_SALT',        '$F48&eMdW`m+:^9rr367Lj:}R5 :5c#du0b`!m{nGCp6%+M]~:G2y|Zy@#J]vpc*');
define('SECURE_AUTH_SALT', '*~z-YY;CgK`R2%Hs}b! _+YN |E9K+-VX|N6}1V:N+_Q6uQqj.!]#1bK}cQ^%Xv2');
define('LOGGED_IN_SALT',   '[n:cUvdQ%wTFS=o<aZ?WI-E7u!,9Sj=)T 0PE}1#f404/--98`BEW{1:YE(Ntqoo');
define('NONCE_SALT',       'd>?n>IcV/FD+ hVr$rF8|<m/.ruEI8d1ec_z>GW3]rZJ$-Gj66!)YA]M/N/x+/CX');

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
