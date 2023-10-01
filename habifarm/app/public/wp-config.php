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


define('AUTH_KEY',         'fLw5vo8yuzUmeYc+WH1nN5vUjWYmc+IX+l2CmdnbH42ccFARDfeqVp5RT/jcE/yt/eRtql+kVKn2jPxxBgW0XA==');
define('SECURE_AUTH_KEY',  'cmMQQY9gHnCs8sDbfTZ9tMNMwcjRI1TyKj1l7/qeH3zdvnaGc3IBSTxtgOd6DqPi6yQtBIH5ulkWYcu0+YleIg==');
define('LOGGED_IN_KEY',    'MGcB7SmbIiwNir8WG0+eoHMmP2qbaOMgI63pIUaGtaoyhlPxRvsyEfPB1iuT4zU15QdPRXyjtc/9SJ3HWWBMSA==');
define('NONCE_KEY',        'rYv9ogTdEyfgqn9RZSJqkHhHWSwe1joqxBFMPVY339FmEib4Ba7Krpx0BIoYkXTANL6sEnSRbGI0eoJ5KeLS7g==');
define('AUTH_SALT',        'iPRMm4QmMadzXh9N73AoA1BoLTBPlulHpVA4MtpcGC3F9DE9xqGcW5k4gAt3kQsJ1bIawWuhcKSU/TS4b56XtA==');
define('SECURE_AUTH_SALT', '847Cb1QZNjIZ62H2ZkM9VJA0L5RASBf4tsrqVnwEitZ74fhyXXCQQQcMrVtwtBxY/JZO4wKOnDCNROJJS+5hmw==');
define('LOGGED_IN_SALT',   'dPv7arBkACl7nRsy5qBAfySWIEn9bWpA6qOC1vwITPDVs12lj8OG01Ox77LriAyYIUvqdON4tRZR3z5lK7WR8w==');
define('NONCE_SALT',       'GrLoS+9sOPjHI5vJFTCPYSaPnPr8/5BJ2UuzPV4Xl+nBk0S7pVxg+dbSq2AHTFxDzWKle2UBmqNJYYIxNwMOJA==');
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
