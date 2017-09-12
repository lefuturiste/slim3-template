<?php

namespace App;

use Slim\Route;

class TwigExtension extends \Twig_Extension
{

	/**
	 * @var
	 */
	private $container;

	public function __construct($container)
	{

		$this->container = $container;
	}

	public function getFilters()
	{
		return [
			new \Twig_SimpleFilter('markdown', [$this, 'markdown'], ['is_safe' => ['html']]),
			new \Twig_SimpleFilter('short', [$this, 'short']),
		];
	}

	public function getFunctions()
	{
		return [
			new \Twig_Function('short_str', [$this, 'short_str']),
			new \Twig_Function('getHoursFromDateTime', [$this, 'getHoursFromDateTime']),
			new \Twig_Function('dump', [$this, 'dump']),
			new \Twig_Function('timeago', [$this, 'timeago']),
			new \Twig_Function('getLocale', [$this, 'getLocale']),
			new \Twig_Function('ucfirst', [$this, 'ucfirst']),
			new \Twig_Function('timestampToTime', [$this, 'timestampToTime']),
			new \Twig_Function('flash', [$this, 'flash']),
			new \Twig_Function('routeNameFor', [$this, 'routeNameFor']),
		];
	}

	public function short_str($string, $long = 20)
	{
		if (strlen($string) > $long) {
			return substr($string, 0, $long) . '...';
		} else {
			return $string;
		}
	}

	public function ucfirst($string)
	{
		return ucfirst($string);
	}


	public function markdown($value)
	{
		$Parsedown = new \Parsedown();

		return $Parsedown->text($value);
	}

	public function short($string)
	{
		return substr($string, 0, 20);
	}

	public function getHoursFromDateTime($date)
	{
		$dt = \DateTime::createFromFormat("Y-m-d H:i:s", $date);
		$hours = $dt->format('H:i');

		return $hours;
	}

	public function timeago($date)
	{
		$timeAgo = new \Westsworld\TimeAgo(NULL, 'fr');

		return ucfirst(
			$timeAgo->inWords(
				$date
			)
		);
	}

	public function timestampToTime($date)
	{
		return date('Y-m-d H:i:s', $date);
	}

	public function getLocale($locale)
	{
		switch ($locale) {
			case 'FRENCH_FRANCE':
				return 'Français';
				break;
			default:
				return 'Inconnu';
				break;
		}
	}

	public function dump($value)
	{
		var_dump($value);
		dd('end of debug');
	}

	public function flash($key)
	{
		if ($this->container->flash->hasMessage($key)) {
			return $this->container->flash->getMessage($key);
		} else {
			return false;
		}
	}

	public function routeNameFor($url, $names)
	{
		$i = 0;
		while ($i < count($names)){
			$route = $this->container->router->getNamedRoute($names[$i]);
			$pattern = $route->getPattern();
			if ($pattern == $url OR $pattern){
				return true;
			}
			$i++;
		}
	}


}