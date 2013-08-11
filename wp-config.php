<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Heroku Postgres settings - from Heroku Environment ** //
$db = parse_url($_ENV["DATABASE_URL"]);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', trim($db["path"],"/"));

/** MySQL database username */
define('DB_USER', $db["user"]);

/** MySQL database password */
define('DB_PASSWORD', $db["pass"]);

/** MySQL hostname */
define('DB_HOST', $db["host"]);

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
define('AUTH_KEY',         'sm]dehL$a5Oh>U{_(K]4udPBb!3{%WUHjJP+cC-jJQxUxzq]UV@+4/z..;`}*B5{');
define('SECURE_AUTH_KEY',  'NuOeZ!9FF{.Df2fqvjVgvSmIO+ms9?w<#;(Een[tn{z?xD%Bj`RbsQQ-X1<Qv)oS');
define('LOGGED_IN_KEY',    'Z3Jq59N.y9TY|mT6f.[c?]-8n+@.~lf_ZXVSn(k:=?$OYFNOa&!q(>=#w88GY5?D');
define('NONCE_KEY',        ')|+.F+6Y-F9=Pn!!67@ZKH%_c~So?YnD++Z{XtG/(Z06K,PER]Qv||&$+N|0@+L ');
define('AUTH_SALT',        'IRUE8}b>GH0/p6K3BuQQiP|cQ9oSsnYo7f}M]TW-WXXppQx.%-MIoKg,}kSw:TGa');
define('SECURE_AUTH_SALT', '9$S{Q[prxv/|Y`OeiMx+(I*,^X)y1w 4e?f9?Y, H)=`L,+dBh,C$v2W8lE-{L#q');
define('LOGGED_IN_SALT',   'K~&=sFcy&m8|,um5|Q?`Hxa=9)-<A{2j0T:>TW+QqlDXMNymY*23H>b<.pp.eBy{');
define('NONCE_SALT',       '/)):M|lkD+Srht]htx/W-oNH$SuD|P~&1`Xr}yNBo7mN]B?S~=+Qw++TDk+$7eAh');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
