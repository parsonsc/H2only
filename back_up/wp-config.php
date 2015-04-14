<?php
define('DEV', false);
define('WP_DEBUG', true);
define('SAVEQUERIES', true);
define('DISALLOW_FILE_EDIT', true);
define('ENABLE_CACHE', False);
define('WP_CACHE', False); 

$httpHost = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '' ;	
switch ($httpHost) {	
    case 'w7dev1' : 
    case 'w7dev1.thegoodagency.co.uk' : 
    case 'localhost:8080' : 
        define('WP_HOME','http://localhost:8080/h2only');
        define('WP_SITEURL','http://localhost:8080/h2only');	
        define('DB_NAME', 'h2only_rnli');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '');
        define('DB_HOST', 'localhost');
    break;

    case 'test6.thegoodagencydigital.co.uk' : 
        define('WP_HOME','http://test6.thegoodagencydigital.co.uk');
        define('WP_SITEURL','http://test6.thegoodagencydigital.co.uk');	
        define('DB_NAME', 'rnl1h2only_2014');
        define('DB_USER', 'rnl1h2only_2014');
        define('DB_PASSWORD', 'DGcp!091');
        define('DB_HOST', 'localhost');
    break;	
    
    default:
        define('WP_HOME','http://www.h2only.org.uk');
        define('WP_SITEURL','http://www.h2only.org.uk');	
        define('DB_NAME', 'h2only_rnli');
        define('DB_USER', 'rnl1h2only');
        define('DB_PASSWORD', 'H2cp!091');
        define('DB_HOST', 'localhost');
    break;
}


define('DB_CHARSET', 'utf8');
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
define('AUTH_KEY',         '7V/P^}X$Dy{Yp3!2hGE.Q+sWgQ&qvjo ~JY <=xrBI)xve(H:OUF:)0*u|b;PJxn');
define('SECURE_AUTH_KEY',  'JP 9:AcO%SQX@,*1W|]jvSqM|f@1R+z=PYFHuYTs?X_#^mbp&:orPw-Sbn3cE r&');
define('LOGGED_IN_KEY',    'm9w2i1DR[eC6osNtUphUW>I,S(tCO/CM%eT4O&^ytL2,=:sFo(8&Z&++,6#|A&Nc');
define('NONCE_KEY',        'd7k/;wd@$kN*|.y|_&W]c+ezB{J+1<@CPR@-kl:zy07syN+G[f_i%wz(e>6@|cNb');
define('AUTH_SALT',        ';~ae!tw(=_=+pP<K.eNN!-My_m)AQ5+$GIO64Wa[IdNz/?gxf`Tvg}h|D)Xq~(iR');
define('SECURE_AUTH_SALT', 'vB}Bc2az8+~# zAYeOz!]+H)|dh6>w`3jOqE*10yim[EnM-DlgcI7f!VYw7it{&s');
define('LOGGED_IN_SALT',   'P-knsXATcKU8:v(z(Wb#|HL#[en^8 l]XkGeL$gOPzM0iLpd`DbcMK|S}Gxs$<6K');
define('NONCE_SALT',       'i@ur1d(X%Bx9v>zMvSE*7EdV9]+m|;@%~:Y9KI#$nA(DC|`P?m6L^&$u|H9h:~R;');

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
