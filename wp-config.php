<?php

/**a
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
define('COMPRESS_CSS', true );
//define('COMPRESS_SCRIPTS', true );
//define('ENFORCE_GZIP', true );
//define('CONCATENATE_SCRIPTS', true);
define('WP_MEMORY_LIMIT', '128M');

define('WP_CACHE', false);
define( 'WPCACHEHOME', '/srv/www/vaycaptoc.com/wp-content/plugins/wp-super-cache/' );
define('DB_NAME', 'vct');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
/**
 *
 */
define('WP_SITEURL', 'https://vaycaptoc.com');
define('WP_HOME', 'https://vaycaptoc.com');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'qemc<u{noiJH2{,,Ml(%+1NrC*a-j&KszulO]1ax3}E$tw_-0lF`pfIyk#zQf1ki');
define('SECURE_AUTH_KEY',  '|W:G>[z%0Aw88>z<8PHy(rf2}[HV%@L`:!M>#3qT;E287Xg{|^xJmSMO.:YDu VT');
define('LOGGED_IN_KEY',    'mZjlYc3<]bHR=eQLRr_< Wsg9ODcWTL#@v3&;xy/NG#W!}-&`n4)[a}=f~y&v_8Y');
define('NONCE_KEY',        '[G{,>fuyAz})c}F:VuMUoGq+0Vt~b&+Y7,%GU]`9<BvjNHXZ>.5cz!&}#%jKiJFa');
define('AUTH_SALT',        'qr*8UFWdjc.N5l2/3aNQ$,d2,UJv8E{CD|]p6Lc{@-7bu#cc;Vok_47$fA`N!1 G');
define('SECURE_AUTH_SALT', 'by4|-sua7*IiI+5ym&6#{Mc-L?<G`y9wC4E0S4vakuOK4Vc207PCJwb@R1F gEJO');
define('LOGGED_IN_SALT',   '5CBs-S6=nzlU)b^XN+pBE==r[4c9bb3h?^wb5ZR/F]GZwh=LNqdsF^A17e3|0P={');
define('NONCE_SALT',       'X&@(XobxX=d1YWL= +t@l9W0g<O}B.B+]E]e-{4kw o.R[n4Tc``/X]T1SOQ(0B:');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'v_';


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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
define('FS_METHOD','direct');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
