<?php
defined('TYPO3_MODE') or exit;

// ############################################################################
// TABLES
// ############################################################################

// ################
// Settings Root
// ################

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tx_metaseo_setting_root',
    'EXT:metaseo/Resources/Private/Language/locallang.tca.xml'
);

// allow pages which contain such a record to be copied by users without throwing errors
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_metaseo_setting_root');


// ############################################################################
// Backend
// ############################################################################

if (TYPO3_MODE == 'BE') {

    // ####################################################
    // Module category "WEB"
    // ####################################################

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Metaseo.' . $_EXTKEY,
        'web',
        'pageseo',
        '', # Position
        ['BackendPageSeo' => 'main,metadata,geo,searchengines,url,pagetitle,pagetitlesim'], # Controller array
        [
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Backend/Icons/ModuleSeo.png',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/ModuleSeo/locallang.xlf',
        ]
    );

    // ####################################################
    // Module category "SEO"
    // ####################################################

	/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
	$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
		\TYPO3\CMS\Core\Imaging\IconRegistry::class
	);
	$iconRegistry->registerIcon(
		'module-seo',
		\TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
		[
			'name' => 'bullseye'
		]
	);

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        $_EXTKEY,
        'metaseo',
        '',
        '',
        [],
        [
            'access' => 'user,group',
            'iconIdentifier' => 'module-seo',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/ModuleMain/locallang.xlf',
        ]
    );


    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Metaseo.' . $_EXTKEY,
        'metaseo',
        'controlcenter',
        '',
        ['BackendControlCenter' => 'main'],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Backend/Icons/ModuleControlCenter.png',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/ModuleControlCenter/locallang.xlf',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Metaseo.' . $_EXTKEY,
        'metaseo',
        'sitemap',
        'after:controlcenter',
        ['BackendSitemap' => 'main,sitemap'],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Backend/Icons/ModuleSitemap.png',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/ModuleSitemap/locallang.xlf',
        ]
    );

    // ############################################################################
    // REGISTER AJAX CONTROLLERS
    // ############################################################################
    // AJAX
    \Metaseo\Metaseo\Utility\ExtensionManagementUtility::registerAjaxClasses(
        \Metaseo\Metaseo\Controller\Ajax\AbstractPageSeoController::getBackendAjaxClassNames()
    );
    \Metaseo\Metaseo\Utility\ExtensionManagementUtility::registerAjaxClasses(
        \Metaseo\Metaseo\Controller\Ajax\SitemapController::getBackendAjaxClassNames()
    );
}

// ############################################################################
// CONFIGURATION
// ############################################################################

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'MetaSEO');
