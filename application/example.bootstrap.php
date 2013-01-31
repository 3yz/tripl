<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

// set $base_url. Development as default.
switch (Kohana::$environment) {
	case Kohana::TESTING:
		$base_url = '/';
		break;

	case Kohana::PRODUCTION:
		$base_url = '/';
		break;
	
	default:
		$base_url = '/projetos/3yz/tripl/';
		break;
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'index_file' => FALSE,
	'base_url'   => $base_url,
	'errors' 		 => (Kohana::$environment != Kohana::PRODUCTION),
	'caching'    => Kohana::$environment == Kohana::PRODUCTION
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));
Log::$write_on_add = TRUE;

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'tripl-manager'  => MODPATH.'tripl-manager',  // User guide and API documentation
	'auth'           => MODPATH.'auth',       // Basic authentication
	'assets'         => MODPATH.'assets',       
	// 'cache'         => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'     => MODPATH.'codebench',  // Benchmarking tool
	'database'       => MODPATH.'database',   // Database access
	// 'image'         => MODPATH.'image',      // Image manipulation
	'minion'         => MODPATH.'minion',     // CLI Tasks
	'orm'            => MODPATH.'orm',        // Object Relationship Mapping
	'kohana-notices' => MODPATH.'kohana-notices',  
	'pagination'     => MODPATH.'pagination',   
	// 'unittest'      => MODPATH.'unittest',   // Unit testing
	// 'userguide'     => MODPATH.'userguide',  // User guide and API documentation
	
	));

// Define global paths
define('PUBLIC_PATH', DOCROOT.'public/');
define('UPLOAD_PATH', PUBLIC_PATH.'upload/');

Cookie::$salt = md5($base_url);

// Load Routes
require APPPATH.'routes'.EXT;
