<?php
/**
 * @package    Prototype Component
 * @version    1.4.3
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2018 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\StandardRules;

class PrototypeRouter extends RouterView
{
	/**
	 * Router constructor
	 *
	 * @param   JApplicationCms $app  The application object
	 * @param   JMenu           $menu The menu object to work with
	 *
	 * @since  1.0.0
	 */
	public function __construct($app = null, $menu = null)
	{
		// List route
		$list = new RouterViewConfiguration('list');
		$list->setKey('id')->setNestable();
		$this->registerView($list);

		// Form route
		$form = new RouterViewConfiguration('form');
		$form->setKey('key')->setParent($list, 'catid');
		$this->registerView($form);

		// Map route
		$map = new RouterViewConfiguration('map');
		$map->setKey('id')->setNestable();
		$this->registerView($map);

		// Map Item route (fake for nesestable)
		$mapitem = new RouterViewConfiguration('mapitem');
		$mapitem->setKey('id')->setParent($map, 'catid');
		$this->registerView($mapitem);

		parent::__construct($app, $menu);

		$this->attachRule(new MenuRules($this));
		$this->attachRule(new StandardRules($this));
		$this->attachRule(new NomenuRules($this));
	}

	/**
	 * Method to get the segment(s) for a items
	 *
	 * @param   string $id    ID of the category to retrieve the segments for
	 * @param   array  $query The request that is built right now
	 *
	 * @return  array|string  The segments of this item
	 *
	 * @since  1.0.0
	 */
	public function getItemsSegment($id, $query)
	{
		$path = array();

		while ($id > 1)
		{
			$db      = Factory::getDbo();
			$dbquery = $db->getQuery(true)
				->select(array('id', 'alias', 'parent_id'))
				->from('#__prototype_categories')
				->where('id =' . $id);
			$db->setQuery($dbquery);
			$category = $db->loadObject();

			if ($category)
			{
				$path[$category->id] = $category->alias;
			}
			$id = ($category) ? $category->parent_id : 1;
		}
		$path[1] = 'root';

		return $path;
	}

	/**
	 * Method to get the segment(s) for a list view
	 *
	 * @param   string $id    ID of the category to retrieve the segments for
	 * @param   array  $query The request that is built right now
	 *
	 * @return  array|string  The segments of this item
	 *
	 * @since  1.0.0
	 */
	public function getListSegment($id, $query)
	{
		return $this->getItemsSegment($id, $query);
	}

	/**
	 * Method to get the segment(s) for a map view
	 *
	 * @param   string $id    ID of the category to retrieve the segments for
	 * @param   array  $query The request that is built right now
	 *
	 * @return  array|string  The segments of this item
	 *
	 * @since  1.0.0
	 */
	public function getMapSegment($id, $query)
	{
		return $this->getItemsSegment($id, $query);
	}

	/**
	 * Method to get the segment(s) for form view
	 *
	 * @param   string $id    ID of the form to retrieve the segments for
	 * @param   array  $query The request that is built right now
	 *
	 * @return  array|string  The segments of this item
	 *
	 * @since  1.0.0
	 */
	public function getFormSegment($id, $query)
	{
		$catid = (!empty($query['catid'])) ? $query['catid'] : 1;
		$name  = (!empty($query['id'])) ? 'edit' : 'add';

		return array($catid => $name);
	}

	/**
	 * Method to get the id for a items
	 *
	 * @param   string $segment Segment to retrieve the ID for
	 * @param   array  $query   The request that is parsed right now
	 *
	 * @return  mixed   The id of this item or false
	 *
	 * @since  1.0.0
	 */
	public function getItemsId($segment, $query)
	{
		if (isset($query['id']))
		{
			$parent = $query['id'];

			$db      = Factory::getDbo();
			$dbquery = $db->getQuery(true)
				->select(array('alias', 'id'))
				->from('#__prototype_categories')
				->where($db->quoteName('parent_id') . ' =' . $db->quote($parent));
			$db->setQuery($dbquery);
			$categories = $db->loadObjectList();

			foreach ($categories as $category)
			{
				if ($category->alias == $segment)
				{
					return $category->id;
				}
			}
		}

		return false;
	}

	/**
	 * Method to get the id for a List view
	 *
	 * @param   string $segment Segment to retrieve the ID for
	 * @param   array  $query   The request that is parsed right now
	 *
	 * @return  mixed   The id of this item or false
	 *
	 * @since  1.0.0
	 */
	public function getListId($segment, $query)
	{
		return $this->getItemsId($segment, $query);
	}

	/**
	 * Method to get the id for a Map view
	 *
	 * @param   string $segment Segment to retrieve the ID for
	 * @param   array  $query   The request that is parsed right now
	 *
	 * @return  mixed   The id of this item or false
	 *
	 * @since  1.0.0
	 */
	public function getMapId($segment, $query)
	{
		return $this->getItemsId($segment, $query);
	}

	/**
	 * Method to get the id for form view
	 *
	 * @param   string $segment Segment to retrieve the ID for
	 * @param   array  $query   The request that is parsed right now
	 *
	 * @return  mixed   The id of this item or false
	 *
	 * @since  1.0.0
	 */
	public function getFormId($segment, $query)
	{
		if (in_array($segment, array('form', 'add', 'edit')))
		{
			$cid = (!empty($query['id'])) ? $query['id'] : 0;

			return $cid;
		}

		return false;
	}
}

function prototypeBuildRoute(&$query)
{
	$app    = Factory::getApplication();
	$router = new PrototypeRouter($app, $app->getMenu());

	return $router->build($query);
}

function prototypeParseRoute($segments)
{
	$app    = Factory::getApplication();
	$router = new PrototypeRouter($app, $app->getMenu());

	return $router->parse($segments);
}