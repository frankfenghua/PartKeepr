<?php
namespace de\RaumZeitLabor\PartKeepr\Frontend;
use de\RaumZeitLabor\PartKeepr\Footprint\FootprintAttachment,
	de\RaumZeitLabor\PartKeepr\Project\ProjectAttachment,
	de\RaumZeitLabor\PartKeepr\Part\PartAttachment,
	de\RaumZeitLabor\PartKeepr\UploadedFile\TempUploadedFile,
	de\RaumZeitLabor\PartKeepr\PartKeepr,
	de\RaumZeitLabor\PartKeepr\Image\Image,
	de\RaumZeitLabor\PartKeepr\Manufacturer\ManufacturerICLogo;

include("../src/backend/de/RaumZeitLabor/PartKeepr/PartKeepr.php");

PartKeepr::initialize("");

$type = $_REQUEST["type"];
$id = $_REQUEST["id"];

if (substr($id, 0, 4) === "TMP:") {
		$tmpFileId = str_replace("TMP:", "", $id);
		$file = TempUploadedFile::loadById($tmpFileId);
} else {
	try {
		switch ($type) {
			case "PartKeepr.PartAttachment":
			case "PartAttachment":
				$file = PartAttachment::loadById($id);
				break;
			case "FootprintAttachment":
			case "PartKeepr.FootprintAttachment":
					$file = FootprintAttachment::loadById($id);
					break;
			case "ProjectAttachment":
			case "PartKeepr.ProjectAttachment":
				$file = ProjectAttachment::loadById($id);
				break;
			default:
				$file = null;
				// Add default image?
		}
		
	} catch (\Exception $e) {
		$file = null;
		// Something bad happened
	}
}

if ($file == null) {
	
	// Could not find the image, but maybe we want a temporary image?
	if (array_key_exists("tmpId", $_REQUEST)) {
		$file = TempUploadedFile::loadById($_REQUEST["tmpId"]);
	}
}

if (is_object($file)) {
	header("Content-Type: ".$file->getMimeType());
	
	if ($_REQUEST["download"] && $_REQUEST["download"] == "true") {
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="'.basename($file->getOriginalFilename()).'"');
	} else {
		header('Content-Disposition: inline; filename="'.basename($file->getOriginalFilename()).'"');
	}
	
	
	$fp = fopen($file->getFilename(), "rb");
	fpassthru($fp);
	fclose($fp);
} else {
	echo "404 not found";
}

PartKeepr::getEM()->flush();
exit();