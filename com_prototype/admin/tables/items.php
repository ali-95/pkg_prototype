<?php
/**
 * @package    Prototype Component
 * @version    1.3.5
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2018 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;
use Joomla\CMS\Table\Observer\Tags;

class PrototypeTableItems extends Table
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver &$db Database connector object
	 *
	 * @since  1.0.0
	 */
	function __construct(&$db)
	{
		parent::__construct('#__prototype_items', 'id', $db);

		// Set the alias since the column is called state
		$this->setColumnAlias('published', 'state');

		Tags::createObserver($this, array('typeAlias' => 'com_prototype.item'));
	}
}