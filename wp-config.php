<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'h2only');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_HOME','http://localhost/h2only');
define('WP_SITEURL','http://localhost/h2only');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '$bL@ahO[.S]52^qES?l?E0]{L/+/cz0},&eswS%:Oa]ZxG]L&=q)$3[!=?CK :6O');
define('SECURE_AUTH_KEY',  'Y4hn>T<%M` HZ>BTA$)B%P90`}>Qi2FjkGK(S{/r|,/n;tY$|)5E9]|.[7E9T<Ud');
define('LOGGED_IN_KEY',    'O`=o#oGYXQr?mh(YnOjs-ZL|MR<uhqa&|g,{sg++&+PIG2d~QvsN|}H=$Pwn;~hI');
define('NONCE_KEY',        '*a771R+BsV[{kn*eE!v,M@9C,QM%,o}PyeIv~d*q%wN3MP,2cad_Lp:M9c8m;CKT');
define('AUTH_SALT',        'N|r{Mx8w]pzb*/yp=p&D0ihr@i3Ug;yfbxfH}D{q#1bg,/]RUs(ol.]e6c--6/2A');
define('SECURE_AUTH_SALT', 'R*7M@`]HQGP+73Zi#W~Pi%3%neLJEa0u!um I=_:_>|A$`Y*@}X^;!qu+^y(=RL5');
define('LOGGED_IN_SALT',   'B4(:YkO7+O@|uul2#na{c#iLq1P;=}j;0lSD1N=i#34]qD(pCkJ%$T}*+.L-{j+#');
define('NONCE_SALT',       '%`FF+BgQ;X}@XM?]N|p(8#Y-fjw$PT6^WHNx+#0nfFs++)c]&9F y0gx[JmN8g=q');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
