<?php

/**
 * Set Timezone
 */
 date_default_timezone_set('Asia/Tehran');

/**
 * Project
 */
$config['Project']['name'] = 'AliPI';
$config['Project']['version'] = '0.2.1';

/**
 * Base Url
 */
$config['url'] = 'http://127.0.0.1/aftabrasan-app/';
$config['url_api'] = 'http://192.168.203.182/aftabrasan/';

/**
 * SLIM
 */
// Turn this on in development mode to get information about errors
$config['displayErrorDetails'] = true;
// Allows the web server to set the Content-Length header
// which makes Slim behave more predictably.
$config['addContentLengthHeader'] = false;

/**
 * Neo4j
 */
// username
$config['neo4j']['user'] = '';
// password
$config['neo4j']['pass'] = '';
// timeout: number : seconds
$config['neo4j']['timeout'] = 4;
// server-addr:port
$config['neo4j']['http-addr'] = '';
// server-addr:port
$config['neo4j']['https-addr'] = '';
// server-addr:port
$config['neo4j']['bolt-addr'] = '';
// true : false
$config['neo4j']['check-tls'] = true;

/**
 * SQL DB
 */
 $config['db']['driver'] = 'mysql';
 $config['db']['host'] = 'localhost';
 $config['db']['database'] = 'aftabrasan_app';
 $config['db']['username'] = 'root';
 $config['db']['password'] = '';
 $config['db']['charset'] = 'utf8';
 $config['db']['collation'] = 'utf8_unicode_ci';
 $config['db']['prefix'] = '';

/**
 * Logger
 * do not fill the values to use the default vals
 */
// name
$config['logger']['name'] = '';
// log address:  folder/file.ext
$config['logger']['addr'] = '';

/**
 * Session
 * to deisable: empty session name
 */
// name
$config['session']['name'] = 'aftabrasan_app';
// (boolean)
// true if you want session to be refresh when user activity is made
// (interaction with server)
$config['session']['autorefresh'] = false;
// How much should the session last? Default 20 minutes.
// Any argument that strtotime can parse is valid.
$config['session']['lifetime'] = '1 day';
$config['session']['httponly'] = true;

/**
 * Upload Config
 */
// set folder name
$config['upload']['folder']['main'] = 'uploads';
$config['upload']['folder']['avatar'] = 'avatar';
$config['upload']['folder']['tmp'] = 'tmp';
// do not change these values
$config['upload']['dir'] = PATH . DIRECTORY_SEPARATOR . $config['upload']['folder']['main'];
$config['upload']['url'] = $config['url'] . $config['upload']['folder']['main'] . '/';


?>
