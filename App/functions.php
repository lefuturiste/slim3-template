<?php
/*
|--------------------------------------------------------------------------
| Debug and die function
|--------------------------------------------------------------------------
|
| Many time you need a simple function for debugging your application.
| This function will show to you the value parsed in html with var_dump() function.
|
*/
function dd($value = 'Die and Debug ! ;)'){
	var_dump($value);
	die('');
}