<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Semyon Vyskubov <sv@rv7.ru>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

if (!class_exists('tslib_pibase')) require_once(PATH_tslib . 'class.tslib_pibase.php');

/**
 * Plugin 'Simple Slider' for the 'simple_slider' extension.
 *
 * @author	Semyon Vyskubov <sv@rv7.ru>
 * @package	TYPO3
 * @subpackage	tx_simpleslider
 */
class tx_simpleslider_pi1 extends tslib_pibase {

	var $prefixId      = 'tx_simpleslider_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_simpleslider_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'simple_slider';	// The extension key.
	var $pi_checkCHash = true;

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {

		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_initPIflexForm();

		$storePid = (int)$this->conf['storePid'];
		if ((int)$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'storePid', 'sDEF') > 0)
			$storePid = (int)$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'storePid', 'sDEF');

		$imageWidth = (int)$this->conf['imageWidth'];
		if ((int)$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'imageWidth', 'sDEF') > 0)
			$imageWidth = (int)$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'imageWidth', 'sDEF');

		$imageHeight = (int)$this->conf['imageHeight'];
		if ((int)$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'imageHeight', 'sDEF') > 0)
			$imageHeight = (int)$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'imageHeight', 'sDEF');

		$animation = 'slide';
		$animationSpeed = 700;
		$slidePause = 5000;

		if (strlen($this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'animation', 'sDEF')) > 0)
			$animation = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'animation', 'sDEF');
		if ((int)$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'animationSpeed', 'sDEF') > 0)
			$animationSpeed = (int)$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'animationSpeed', 'sDEF');
		if ((int)$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'slidePause', 'sDEF') > 0)
			$slidePause = (int)$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'slidePause', 'sDEF');

		if (strlen($this->conf['animation']) > 0)
			$animation = $this->conf['animation'];
		if ((int)($this->conf['animationSpeed']) > 0)
			$animationSpeed = $this->conf['animationSpeed'];
		if ((int)($this->conf['slidePause']) > 0)
			$slidePause = $this->conf['slidePause'];

		$GLOBALS['TSFE']->setCSS($this->extKey, '' .
			'.tx-simpleslider-pi1-switcher { clear: both; }' .
			'.tx-simpleslider-pi1-switcher UL { list-style: none; margin: 0; padding: 0; }' .
			'.tx-simpleslider-pi1-switcher UL LI { float: left; }'.
			'.tx-simpleslider-pi1-switcher UL LI A { display: block; width: 15px; height: 15px; margin-right: 3px; background: grey; border: 1px solid #fff; }'.
			'.tx-simpleslider-pi1-switcher UL LI.active A { background: red; }'
		);

		$GLOBALS["TSFE"]->setJS($this->extKey, '' .
			'tx_simpleslider_pi1_conf = new Array();' .
			'tx_simpleslider_pi1_conf[\'animation\'] = \'' . $animation . '\';'.
			'tx_simpleslider_pi1_conf[\'animationSpeed\'] = ' . $animationSpeed . ';'.
			'tx_simpleslider_pi1_conf[\'slidePause\'] = ' . $slidePause . ';'
		);
		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey] = '<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->extKey) . 'js/main.js"></script>';

		$templateFile = 'EXT:simple_slider/templates/default.html';
		if (strlen($this->conf['templateFile']) > 0)
			$templateFile = $this->conf['templateFile'];
		if (strlen(trim($this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'templateFile', 'sDEF'))) > 0)
			$templateFile = trim($this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'templateFile', 'sDEF'));
		$template = $this->cObj->fileResource($templateFile);

		$tmplSlider = $this->cObj->getSubpart($template, '###TEMPLATE_SLIDER###');
		$tmplItem = $this->cObj->getSubpart($template, '###TEMPLATE_SLIDER_ITEM###');

		$collect = '';
		
		$whereApx = '1 = 1';
		if ($storePid > 0)
			$whereApx = 'pid = ' . $storePid;
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'*',
			'tx_simpleslider_items',
			$whereApx . $this->cObj->enableFields('tx_simpleslider_items'),
			'',
			'sorting'
		);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {

			$imageConf['file'] = 'uploads/tx_simpleslider/' . $row['image'];
			if ($imageWidth > 0)
				$imageConf['file.']['width'] = $imageWidth;
			if ($imageHeight > 0)
				$imageConf['file.']['height'] = $imageHeight;

			$image = $this->cObj->IMAGE($imageConf);
			$imgResource = $this->cObj->IMG_RESOURCE($imageConf);

			$typolinkConf = $this->conf['typolink.'];
			$typolinkConf['parameter'] = $row['link'];
			$typolink = $this->cObj->typolinkWrap($typolinkConf);

			$itemMarkers = array(
				'###LINK_OPEN###' => $typolink[0],
				'###LINK_CLOSE###' => $typolink[1],
				'###IMAGE###' => $image,
				'###IMG_RESOURCE###' => $imgResource,
				'###HEADER###' => $row['header'],
				'###SUBHEADER###' => $row['subheader']
			);

			$collect .= $this->cObj->substituteMarkerArray($tmplItem, $itemMarkers);

		}

		$itemMarkers = array(
			'###SLIDER###' => $collect,
			'###SWITCHER###' => '<div class="tx-simpleslider-pi1-switcher"></div>'
		);
		$content = $this->cObj->substituteMarkerArray($tmplSlider, $itemMarkers);

		return $this->pi_wrapInBaseClass($content);

	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/simple_slider/pi1/class.tx_simpleslider_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/simple_slider/pi1/class.tx_simpleslider_pi1.php']);
}

?>