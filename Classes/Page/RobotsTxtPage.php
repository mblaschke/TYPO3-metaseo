<?php

/*
 *  Copyright notice
 *
 *  (c) 2015 Markus Blaschke <typo3@markus-blaschke.de> (metaseo)
 *  (c) 2013 Markus Blaschke (TEQneers GmbH & Co. KG) <blaschke@teqneers.de> (tq_seo)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 */

namespace Metaseo\Metaseo\Page;

use Metaseo\Metaseo\Utility\GeneralUtility;

/**
 * Robots txt Page
 */
class RobotsTxtPage extends \Metaseo\Metaseo\Page\AbstractPage {

    // ########################################################################
    // Attributes
    // ########################################################################


    // ########################################################################
    // Methods
    // ########################################################################

    /**
     * Fetch and build robots.txt
     */
    public function main() {
        $settings = GeneralUtility::getRootSetting();

        // INIT
        $tsSetup  = $GLOBALS['TSFE']->tmpl->setup;
        $cObj     = $GLOBALS['TSFE']->cObj;
        $rootPid  = GeneralUtility::getRootPid();
        $ret      = '';

        $tsSetupSeo = null;
        if (!empty($tsSetup['plugin.']['metaseo.']['robotsTxt.'])) {
            $tsSetupSeo = $tsSetup['plugin.']['metaseo.']['robotsTxt.'];
        }

        // check if sitemap is enabled in root
        if (!GeneralUtility::getRootSettingValue('is_robotstxt', true)) {
            return true;
        }

        $linkToStaticSitemap = GeneralUtility::getRootSettingValue('is_robotstxt_sitemap_static',
            false);

        // Language lock
        $sitemapLanguageLock = GeneralUtility::getRootSettingValue('is_sitemap_language_lock',
            false);
        $languageId          = GeneralUtility::getLanguageId();

        // ###############################
        // Fetch robots.txt content
        // ###############################
        $settings['robotstxt'] = trim($settings['robotstxt']);

        if (!empty($settings['robotstxt'])) {
            // Custom Robots.txt
            $ret .= $settings['robotstxt'];
        } elseif ($tsSetupSeo) {
            // Default robots.txt
            $ret .= $cObj->cObjGetSingle($tsSetupSeo['default'], $tsSetupSeo['default.']);
        }

        // ###############################
        // Fetch extra robots.txt content
        // ###############################
        // User additional
        if (!empty($settings['robotstxt_additional'])) {
            $ret .= "\n\n" . $settings['robotstxt_additional'];
        }

        // Setup additional
        if ($tsSetupSeo) {
            // Default robots.txt
            $tmp = $cObj->cObjGetSingle($tsSetupSeo['extra'], $tsSetupSeo['extra.']);

            if (!empty($tmp)) {
                $ret .= "\n\n" . $tmp;
            }
        }

        // ###############################
        // Marker
        // ###############################
        if (!empty($tsSetupSeo['marker.'])) {
            // Init marker list
            $markerList     = array();
            $markerConfList = array();

            foreach ($tsSetupSeo['marker.'] as $name => $data) {
                if (strpos($name, '.') === false) {
                    $markerConfList[$name] = null;
                }
            }

            if ($linkToStaticSitemap) {
                // remove sitemap-marker because we link to static url
                unset($markerConfList['sitemap']);
            }

            // Fetch marker content
            foreach ($markerConfList as $name => $conf) {
                $markerList['%' . $name . '%'] = $cObj->cObjGetSingle($tsSetupSeo['marker.'][$name],
                    $tsSetupSeo['marker.'][$name . '.']);
            }

            // generate sitemap-static marker
            if ($linkToStaticSitemap) {
                if ($sitemapLanguageLock) {
                    $path = 'uploads/tx_metaseo/sitemap_xml/index-r' . (int)$rootPid . '-l' . (int)$languageId . '.xml.gz';
                } else {
                    $path = 'uploads/tx_metaseo/sitemap_xml/index-r' . (int)$rootPid . '.xml.gz';
                }

                $conf = array(
                    'parameter' => $path
                );

                $markerList['%sitemap%'] = $cObj->typolink_URL($conf);
            }

            // Fix sitemap-marker url (add prefix if needed)
            $markerList['%sitemap%'] = GeneralUtility::fullUrl($markerList['%sitemap%']);

            // Call hook
            GeneralUtility::callHookAndSignal(__CLASS__, 'robotsTxtMarker', $this, $markerList);

            // Apply marker list
            if (!empty($markerList)) {
                $ret = strtr($ret, $markerList);
            }
        }

        // Call hook
        GeneralUtility::callHookAndSignal(__CLASS__, 'robotsTxtOutput', $this, $ret);

        return $ret;
    }
}
