<?php
/**
 * Grundeinstellungen für WordPress
 *
 * Zu diesen Einstellungen gehören:
 *
 * * MySQL-Zugangsdaten,
 * * Tabellenpräfix,
 * * Sicherheitsschlüssel
 * * und ABSPATH.
 *
 * Mehr Informationen zur wp-config.php gibt es auf der
 * {@link https://codex.wordpress.org/Editing_wp-config.php wp-config.php editieren}
 * Seite im Codex. Die Zugangsdaten für die MySQL-Datenbank
 * bekommst du von deinem Webhoster.
 *
 * Diese Datei wird zur Erstellung der wp-config.php verwendet.
 * Du musst aber dafür nicht das Installationsskript verwenden.
 * Stattdessen kannst du auch diese Datei als wp-config.php mit
 * deinen Zugangsdaten für die Datenbank abspeichern.
 *
 * @package WordPress
 */

// Our loadbalancer provides HTTP_X_FORWARDED_PROTO, so that wordpress know, which protocol was requested initially.
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
    $_SERVER['HTTPS'] = 'on';


// ** MySQL-Einstellungen ** //
/**   Diese Zugangsdaten bekommst du von deinem Webhoster. **/

/**
 * Ersetze datenbankname_hier_einfuegen
 * mit dem Namen der Datenbank, die du verwenden möchtest.
 */
define( 'DB_NAME', 'ebdb' );

/**
 * Ersetze benutzername_hier_einfuegen
 * mit deinem MySQL-Datenbank-Benutzernamen.
 */
define( 'DB_USER', 'admin' );

/**
 * Ersetze passwort_hier_einfuegen mit deinem MySQL-Passwort.
 */
define( 'DB_PASSWORD', 'm7ioPwBoU+Uxt' );

/**
 * Ersetze localhost mit der MySQL-Serveradresse.
 */
define( 'DB_HOST', 'aaqzbowe6r1md5.cf7v6pauijwp.eu-central-1.rds.amazonaws.com' );

/**
 * Der Datenbankzeichensatz, der beim Erstellen der
 * Datenbanktabellen verwendet werden soll
 */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Der Collate-Type sollte nicht geändert werden.
 */
define('DB_COLLATE', '');

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden untenstehenden Platzhaltertext in eine beliebige,
 * möglichst einmalig genutzte Zeichenkette.
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * kannst du dir alle Schlüssel generieren lassen.
 * Du kannst die Schlüssel jederzeit wieder ändern, alle angemeldeten
 * Benutzer müssen sich danach erneut anmelden.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '<#()hu]89wYJt9,a eFY0mTR}X,v:8`o2pg|Kno!oyxJq&$c6d#q0RwW@>T#KR-T' );
define( 'SECURE_AUTH_KEY',  '2[+$RtL/ :MP=aTDsHuX8/ciWV_b.7mtN@lTAqnH+S#ox]<Q;:G9<y@kg/A_I2?]' );
define( 'LOGGED_IN_KEY',    'R(%]kYI4HRIaolt.{+SK)Hn=0$tYOviS <;zN8s-E;C.@jt=6Vu_H}wGC1HiFsn2' );
define( 'NONCE_KEY',        't4@GvOy7n1nK]|`TI6<kxz XrvB0+I3Ya=R^*]r?JHUu3<=}FQkQ1ys.ipBQA5&/' );
define( 'AUTH_SALT',        'pC]i/C1^XL:=:G{tc5BJ2j,9YI5=o13D2TtBt=K?xB,5#xN7Jl /]I)~q)2UNB>F' );
define( 'SECURE_AUTH_SALT', '3j6d_SG8>j[u_BXaS0l8iK>$O>4l2~)cD32NT8TSkkn&v<)]GPY=$/AEpXRjiki~' );
define( 'LOGGED_IN_SALT',   'ZP~!v,[|cesteEE(y [`[XTVT:]LpY%NISIz-Ru^:TBAmW>8x2Qrbcew5a<vq0ZT' );
define( 'NONCE_SALT',       '8t qjT.`~Z[#8?>GR*4YgetzpLGa5u[7vH#I}OYQXzV6uSv>*cvOxkj@j7U}G~w%' );

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 * Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 * verschiedene WordPress-Installationen betreiben.
 * Bitte verwende nur Zahlen, Buchstaben und Unterstriche!
 */
$table_prefix = 'wp_';

/**
 * Für Entwickler: Der WordPress-Debug-Modus.
 *
 * Setze den Wert auf „true“, um bei der Entwicklung Warnungen und Fehler-Meldungen angezeigt zu bekommen.
 * Plugin- und Theme-Entwicklern wird nachdrücklich empfohlen, WP_DEBUG
 * in ihrer Entwicklungsumgebung zu verwenden.
 *
 * Besuche den Codex, um mehr Informationen über andere Konstanten zu finden,
 * die zum Debuggen genutzt werden können.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Das war’s, Schluss mit dem Bearbeiten! Viel Spaß. */
/* That's all, stop editing! Happy publishing. */

/** Der absolute Pfad zum WordPress-Verzeichnis. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}


//define( 'JETPACK_DEV_DEBUG', false );
/** Definiert WordPress-Variablen und fügt Dateien ein.  */
require_once( ABSPATH . 'wp-settings.php' );
