# Extensions for PressBooks

* Contributors:  @danzhik, @huguespages, @!ndeed
* Donate link: https://opencollective.com/mylanguageskills
* Tags: wordpress, multisite, pressbooks
* Tested up to: WP 5.2.4
* Tested UP:  Pressbooks 5.9.5
* Stable tag: 1.2.5
* License:  GPL 3.0
* License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Extended core functionalities for Pressbooks

## Description

This plugin provides tiny extensions for main functionality of pressbooks.

With use of it you can now define Edition of your book in Book Info, also it is possible to mark books of original publisher (for example in case your platform is open for publishing from authors or distributors).

The last, but not the least feature, of this plugin is creation connections between original books and their translations (this feature will only work if tranaslations of books are created with cloning tool of Pressbooks).

Plugin is also responsible for creation of back-end (platform) blank setting pages on network and on book level. These blank pages are to be filled with settings of other plugins.

As plugin is supposed to be used with our [child theme](https://github.com/my-language-skills/books4languages-book-child-theme-for-pressbooks), the plugin also will set up this theme for all newly created books if theme is installed and network active.

## Installation

1. Clone (or copy) this repository folder `extensions-for-pressbooks` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' screen in WordPress

## Upgrades

For upgrades, download the las stable version from github, delete from FTP the old plugin and install the new one.

## Requirements

Extensions For Pressbooks plugin works with:

* [Pressbooks](https://github.com/pressbooks/pressbooks)
* [Feature Image for PressBooks](https://github.com/my-language-skills/featured-image-for-pressbooks)
* [Translations for Pressbooks](https://github.com/my-language-skills/translations-for-pressbooks)
* [books4languages Book Child theme for PressBooks](https://github.com/my-language-skills/books4languages-book-child-theme-for-pressbooks)
* [books4languages Root Child theme for PressBooks](https://github.com/my-language-skills/books4languages-root-child-theme-for-pressbooks)

## Disclaimers

The Extensions For Pressbooks plugin is supplied "as is" and all use is at your own risk.

## Instructions

If you need some help with understanding on how plugin was structured, take a look at [folder structure](/doc/folder-structure.md).


### Now
## 0.xx

### Soon

### Later

### Future

### Changelog
#### 1.2.5
* **ADDITIONS**
   * EFP Customization settings section and setting field added to site level for this plugin added. (to the "platform" created in previous version).
   * Metabox in post edit which contains input field where we can add new pb_is_based_on URL for currently opened post.
   * 'Settings saved' information bar have been added to inform user settings have been updated sucessfully.
   * post-edit pb_is_based_on metabox is now shown even when pb_is_based_on value is not set for the current post.

* **LIST OF FILE REVISED**
   * ADDED post-metabox-pb_is_based_on.php
   * ADDED efp-admin-settings
   * extensions-for-pressbooks.php

#### 1.2.4
* **ADDITIONS**
   *  Functionality (platform) of a blank settings pages (network and also book level) where other plugins are able to place their own settings.

#### 1.2.3
* **REMOVED**
   *  Auto updated

#### 1.2.2
* **REMOVED**
   * Automatically set the wordpress image title alt text other meta transfered to **feature images for Pressbooks**.

#### 1.2.1
* **ADDITIONS**
   * Add new functions in media to automatically set the wordpress image title alt text other meta
   * Add new functions in to original mark, for see checkbox

#### 1.2
* **REMOVED**
   * Edition extension translations removed


#### 1.1
 * Edition extension removed

#### 1.0 Initial release


## Upgrade Notice

---
[Up](/README.md)
