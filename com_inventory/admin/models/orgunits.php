<?php // no direct access

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

defined( '_JEXEC' ) or die( 'Restricted access' ); 

class InventoryModelOrgunits extends JModelList{

	public function __construct($config = array()){
		if (empty($config['filter_fields'])){
			$config['filter_fields'] = array(
				'id', 'a.orgunit_id',
				'catid', 'a.catid',
				'name', 'a.name',
				'shortdescription', 'a.shortdescription'
			);
		}
		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null){
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_inventory');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.name', 'asc');
	}

	protected function getStoreId($id = ''){
		$id .= ':' . $this->getState('filter.search');
		return parent::getStoreId($id);
	}

	protected function getListQuery(){
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$user = JFactory::getUser();
		$app = JFactory::getApplication();

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.orgunit_id, a.catid, a.name, a.shortdescription'
			)
		);
		$query->from($db->quoteName('#__inventory_orgunits') . ' AS a');

		// Filter by search in module
		$search = $this->getState('filter.search');
		if (!empty($search)){
			if (stripos($search, 'id:') === 0){
				$query->where('a.orgunit_id = ' . (int) substr($search, 3));
			}else{
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('(a.name LIKE ' . $search . ')');
			}
		}

		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');
		if(isset($orderCol)&&isset($orderDirn))
			$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}
}
