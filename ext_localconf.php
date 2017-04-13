<?php
defined('TYPO3_MODE') or exit;

$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['metaseo']);

// ##############################################
// BACKEND
// ##############################################
if (TYPO3_MODE == 'BE') {
	if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 7005000) {
		// IconRegistry is available since TYPO3 7.5.0
		/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		$iconRegistry->registerIcon(
			'module-seo',
			\TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
			['name' => 'bullseye']
		);
		unset($iconRegistry);
	}
	
    // Field validations
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals']['tx_metaseo_backend_validation_float']
        = 'EXT:metaseo/Classes/Backend/Validator/ValidatorImport.php';

    /*
     * BackendCompliantTsfeController suppresses redirect http headers sent by TypoScriptFrontendController
     * by faking default scheme for pages processed by TypoScriptFrontendController (use for Ajax requests only)
     */
    if (isset($_SERVER['HTTP_X_TX_METASEO_AJAX'])) { //original header is 'X-Tx-Metaseo-Ajax' (prefixed by webserver)
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']
            ['TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController'] = array(
                'className' => 'Metaseo\\Metaseo\\Frontend\\Controller\\BackendCompliantTsfeController'
            );
    }
}

// ##############################################
// SEO
// ##############################################

$GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields']
    .= ',tx_metaseo_pagetitle,tx_metaseo_pagetitle_rel,tx_metaseo_pagetitle_prefix,'
    . 'tx_metaseo_pagetitle_suffix,tx_metaseo_canonicalurl';
$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields']
    .= ',tx_metaseo_pagetitle_prefix,tx_metaseo_pagetitle_suffix,tx_metaseo_inheritance';

// Typolink post proc hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['typoLink_PostProc'][]
    = 'Metaseo\\Metaseo\\Hook\\SitemapIndexLinkHook->hook_linkParse';

// HTTP Header extension
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['isOutputting']['metaseo']
    = 'Metaseo\\Metaseo\\Hook\\HttpHook->main';


// ##############################################
// SITEMAP
// ##############################################
// Frontend indexed
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['pageIndexing'][]
    = 'Metaseo\\Metaseo\\Hook\\SitemapIndexPageHook';

// ##############################################
// HOOKS
// ##############################################


// EXT:tt_news
if (!empty($confArr['enableIntegrationTTNews'])) {
    // Metatag fetch hook
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_news']['extraItemMarkerHook']['metaseo']
        = 'Metaseo\\Metaseo\\Hook\\Extension\\TtnewsExtension';
}

// EXT:news
if (!empty($confArr['enableIntegrationNews'])) {
    // Metatag fetch hook
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['news']['hooks']['listAction']['metaseo']
        = 'Metaseo\\Metaseo\\Hook\\Extension\\NewsExtension->listActionHook';
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['news']['hooks']['detailAction']['metaseo']
        = 'Metaseo\\Metaseo\\Hook\\Extension\\NewsExtension->detailActionHook';
}

// ############################################################################
// CLI
// ############################################################################

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][]
    = 'Metaseo\\Metaseo\\Command\\MetaseoCommandController';

// ##############################################
// SCHEDULER
// ##############################################

// Cleanup task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']
['Metaseo\\Metaseo\\Scheduler\\Task\\GarbageCollectionTask'] = array(
    'extension'   => $_EXTKEY,
    'title'       => 'Sitemap garbage collection',
    'description' => 'Cleanup old sitemap entries'
);

// Sitemap XML task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Metaseo\\Metaseo\\Scheduler\\Task\\SitemapXmlTask']
    = array(
        'extension'   => $_EXTKEY,
        'title'       => 'Sitemap.xml builder',
        'description' => 'Build sitemap xml as static file (in uploads/tx_metaseo/sitemap-xml/)'
    );

// Sitemap TXT task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Metaseo\\Metaseo\\Scheduler\\Task\\SitemapTxtTask']
    = array(
        'extension'   => $_EXTKEY,
        'title'       => 'Sitemap.txt builder',
        'description' => 'Build sitemap txt as static file (in uploads/tx_metaseo/sitemap-txt/)'
    );
