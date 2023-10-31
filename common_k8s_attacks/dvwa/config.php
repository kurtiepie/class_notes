<?php

# If you are having problems connecting to the MySQL database and all of the variables below are correct
# try changing the 'db_server' variable from localhost to 127.0.0.1. Fixes a problem due to sockets.
#   Thanks to @digininja for the fix.

# Database management system to use
$DBMS = 'MySQL';
#$DBMS = 'PGSQL'; // Currently disabled

# Database variables
#   WARNING: The database specified under db_database WILL BE ENTIRELY DELETED during setup.
#   Please use a database dedicated to DVWA.
#
# If you are using MariaDB then you cannot use root, you must use create a dedicated DVWA user.
#   See README.md for more information on this.
$_DVWA = array();
$_DVWA[ 'db_port'] = '3306';
?>
<?php
$_DVWA[ 'db_server' ]   = 'dvwa-mysql-service';
$_DVWA[ 'db_database' ] = 'dvwa';
$_DVWA[ 'db_user' ]     = 'dvwa';
$_DVWA[ 'db_password' ] = 'p@ssword';
$_DVWA[ 'recaptcha_public_key' ]  = '';
$_DVWA[ 'recaptcha_private_key' ] = '';
$_DVWA[ 'default_security_level' ] = 'low';
$_DVWA[ 'default_phpids_level' ] = 'disabled';
$_DVWA[ 'default_phpids_verbose' ] = 'true';
define ("MYSQL", "mysql");
define ("SQLITE", "sqlite");
$_DVWA["SQLI_DB"]    = MYSQL;
$_DVWA[ 'disable_authentication' ] = true
#$_DVWA["SQLI_DB"]   = SQLITE;
#$_DVWA["SQLITE_DB"] = "sqli.db";
?>
