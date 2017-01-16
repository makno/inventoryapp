<?php

	/**
	 * @package     it+kapfenberg
	 * @subpackage  plg_finder_inventory
	 *
	 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
	 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
	 */
	 
	defined( '_JEXEC' ) or die( 'Restricted access' );

	require_once JPATH_ADMINISTRATOR . '/components/com_finder/helpers/indexer/adapter.php';


class PlgFinderInventory extends FinderIndexerAdapter{

	protected $context = 'Inventory';
	protected $extension = 'com_inventory';
	protected $layout = 'device';
	protected $type_title = 'Device';
	protected $table = '#__inventory_devices';
	protected $state_field = 'published';
	protected $autoloadLanguage = true;

	public function onFinderCategoryChangeState($extension, $pks, $value){
		if ($extension == 'com_inventory'){
			$this->categoryStateChange($pks, $value);
		}
	}

	public function onFinderAfterDelete($context, $table){
		if ($context == 'com_inventory.device'){
			$id = $table->id;
		}elseif ($context == 'com_finder.index'){
			$id = $table->link_id;
		}else{
			return true;
		}
		return $this->remove($id);
	}

	public function onFinderAfterSave($context, $row, $isNew){
		if ($context == 'com_inventory.device'){
			if (!$isNew && $this->old_access != $row->access){
				$this->itemAccessChange($row);
			}
			$this->reindex($row->id);
		}
		if ($context == 'com_categories.category'){
			if (!$isNew && $this->old_cataccess != $row->access)
			{
				$this->categoryAccessChange($row);
			}
		}
		return true;
	}

	public function onFinderBeforeSave($context, $row, $isNew){
		if ($context == 'com_inventory.device'){
			if (!$isNew){
				$this->checkItemAccess($row);
			}
		}
		if ($context == 'com_categories.category'){
			if (!$isNew){
				$this->checkCategoryAccess($row);
			}
		}
		return true;
	}

	public function onFinderChangeState($context, $pks, $value){
		if ($context == 'com_inventory.device'){
			$this->itemStateChange($pks, $value);
		}
		if ($context == 'com_plugins.plugin' && $value === 0){
			$this->pluginDisable($pks);
		}
	}

	protected function index(FinderIndexerResult $item, $format = 'html'){
		if (JComponentHelper::isEnabled($this->extension) == false){
			return;
		}
		$item->setLanguage();
		// Initialize the item parameters.
		$registry = new JRegistry;
		$registry->loadString($item->params);
		$item->params = $registry;
		$registry = new JRegistry;
		$registry->loadString($item->metadata);
		$item->metadata = $registry;
		// Build the necessary route and path information.
		$item->url = $this->getURL($item->id, $this->extension, $this->layout);
		$item->route = NewsfeedsHelperRoute::getNewsfeedRoute($item->slug, $item->catslug, $item->language);
		$item->path = FinderIndexerHelper::getContentPath($item->route);
		// Add the meta-author.
		$item->metaauthor = $item->metadata->get('author');
		// Handle the link to the meta-data.
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'link');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'metakey');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'metadesc');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'metaauthor');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'author');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'created_by_alias');
		// Add the type taxonomy data.
		$item->addTaxonomy('Type', 'Device');
		// Add the category taxonomy data.
		$item->addTaxonomy('Category', $item->category, $item->cat_state, $item->cat_access);
		// Add the language taxonomy data.
		$item->addTaxonomy('Language', $item->language);
		// Get content extras.
		FinderIndexerHelper::getContentExtras($item);
		// Index the item.
		$this->indexer->index($item);
	}

	protected function setup(){
		require_once JPATH_SITE . '/components/com_inventory/helpers/route.php';
		return true;
	}

	protected function getListQuery($query = null){
		$db = JFactory::getDbo();
		$query = $query instanceof JDatabaseQuery ? $query : $db->getQuery(true)
			->select('d.device_id, d.devicename AS title, d.snumber, d.shortdescription, d.location, d.qrcode')
			->select('c.title AS category, c.published AS cat_state, c.access AS cat_access');
			->from('#__inventory_devices AS d')
		return $query;
	}
}
