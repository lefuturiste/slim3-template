<?php
/*
|--------------------------------------------------------------------------
| Debug mode
|--------------------------------------------------------------------------
|
| If debug mode is enabled, we can enable tracy debugger
|
*/
if ($config['app_debug']) {
	Tracy\Debugger::enable();
}

/*
|--------------------------------------------------------------------------
| Debug and die function
|--------------------------------------------------------------------------
|
| Many time you need a simple function for debugging your application.
| This function will show to you the value parsed in html with Tracy Debugger library.
| This function is ignored is debug mode is not enabled
|
*/
function dd($value = 'Die and Debug ! ;)')
{
	global $config;
	if ($config['app_debug']){
		Tracy\Debugger::dump($value);
		die();
	}
};

function debug($value)
{
	return dd($value);
}

function d($value)
{
	return dd($value);
}
