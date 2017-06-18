# MetaSEO - Search Engine Optimization for TYPO3

![stable v2.1.0](https://img.shields.io/badge/stable-v2.1.0-green.svg?style=flat)
![development v3.0.0](https://img.shields.io/badge/development-v3.0.0-red.svg?style=flat)
![License GPL3](https://img.shields.io/badge/license-GPL3-blue.svg?style=flat)


[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/mblaschke/TYPO3-metaseo.svg)](http://isitmaintained.com/project/mblaschke/TYPO3-metaseo "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/mblaschke/TYPO3-metaseo.svg)](http://isitmaintained.com/project/mblaschke/TYPO3-metaseo "Percentage of issues still open")

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/19914ab4-1f0f-4be0-9215-410fba880af2/big.png)](https://insight.sensiolabs.com/projects/19914ab4-1f0f-4be0-9215-410fba880af2)


MetaSEO is an extension for TYPO3 CMS and provides an indexed google/xml-sitemap, enhanced metatag support
and pagetitle manipulation.
It's a replacement for the "metatag" extension and the successor of the discontinued extension "tq_seo".

* Manual:      https://docs.typo3.org/typo3cms/extensions/metaseo/
* Support:     https://github.com/mblaschke/TYPO3-metaseo/issues
* Source code: https://github.com/mblaschke/TYPO3-metaseo

## Version status

MetaSEO is available via TYPO3's Extension Manager ([TER](https://typo3.org/extensions/repository/view/metaseo))
and via composer ([TER](https://typo3.org/extensions/repository/view/metaseo),
[Packagist](https://packagist.org/packages/mblaschke/metaseo)).

* Development version **3.0.1-dev**:

  + Branch **master**
  + TYPO3 Version: 8.7.x
  + composer via Packagist: `composer require mblaschke/metaseo:dev-master -o`
  + Please be aware that the development version can break at any time

* Stable version **3.0.0**:

  + Branch **v3.0**
  + TYPO3 Version: 8.7.x
  + composer via TER: `composer require typo3-ter/metaseo -o` (recommended)
  + composer via Packagist: `composer require mblaschke/metaseo -o`

* Old-Stable version **2.1.0**:

  + Branch **v2.1**
  + TYPO3 Version: 6.2.x - 7.6.x
  + composer via TER: `composer require typo3-ter/metaseo -o` (recommended)
  + composer via Packagist: `composer require mblaschke/metaseo -o`

For version specific information see [changelog for MetaSEO](CHANGELOG.md)

## Found a bug? Have questions?

Please feel free to file an issue in our [Bugtracker](https://github.com/mblaschke/TYPO3-metaseo/issues). To avoid feedback loops we suggest to provide

* MetaSEO version
* TYPO3 version
* RealUrl version (if used)
* PHP version
* Web server and version (optional)
* Operating system and version (optional)
* Hoster name (in rare cases)

In case of issues, please update to the latest version of MetaSEO first. We also strongly recommend to use recent
versions of TYPO3 CMS (6.2.28+, 7.6.12+) and RealUrl (2.1.5+)

MetaSEO users also meet on slack at [#ext-metaseo](https://typo3.slack.com/messages/ext-metaseo/).

## Contribute

MetaSEO is driven by the community and we're pleased to add new contributions.
If you want to provide improvements, please

- make sure that an [issue](https://github.com/mblaschke/TYPO3-metaseo/issues) exists so that it is clear what
  your contribution is supposed to do. Eventually, open a new issue.
- add a `Fixes #123` to the message of your first commit, whereas `#123` should be the issue number.
- add yourself to the [list of contributors](https://github.com/mblaschke/TYPO3-metaseo/blob/develop/Documentation/Introduction/Index.rst)
  when you send us your first pull request (PR).
- provide as many commits in your PR as necessary. There's no single-commit policy, but one PR should not affect more
  than one issue (if possible).

The coding style of MetaSEO's source code follows the
[PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
standard. Please enable PSR-2 support in your IDE or enable the editorconfig plugin.
See [.editorconfig](.editorconfig) for indentation.

