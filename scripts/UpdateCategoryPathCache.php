<?php
/**
 * This is a script which updates all category path caches to the configured path separator.
 * 
 * This script needs to be called after changing the partkeepr.category.path_separator.
 */
namespace de\RaumZeitLabor\PartKeepr\Scripts;

use de\RaumZeitLabor\PartKeepr\PartKeepr,
	de\RaumZeitLabor\PartKeepr\PartCategory\PartCategoryManager,
	de\RaumZeitLabor\PartKeepr\Util\Configuration,
	de\RaumZeitLabor\PartKeepr\FootprintCategory\FootprintCategoryManager;

include("../src/backend/de/RaumZeitLabor/PartKeepr/PartKeepr.php");


PartKeepr::initialize();

PartCategoryManager::getInstance()->updateCategoryPaths(PartCategoryManager::getInstance()->getRootNode());
FootprintCategoryManager::getInstance()->updateCategoryPaths(FootprintCategoryManager::getInstance()->getRootNode());

PartKeepr::getEM()->flush();

echo "All categories are updated for the configured category seperator of ";
echo Configuration::getOption("partkeepr.category.path_separator") ."\n";