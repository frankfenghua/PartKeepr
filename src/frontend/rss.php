<?php
namespace de\RaumZeitLabor\PartKeepr\Frontend;

use de\RaumZeitLabor\PartKeepr\PartKeepr,
	de\RaumZeitLabor\PartKeepr\Util\Configuration;

include("../src/backend/de/RaumZeitLabor/PartKeepr/PartKeepr.php");

header("Content-Type: text/xml; charset=UTF-8");

PartKeepr::initialize("");

echo file_get_contents(Configuration::getOption("partkeepr.files.path")."/feed.rss");