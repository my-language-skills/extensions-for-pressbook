# Extensions for PressBooks

* Contributors:  @danzhik, @huguespages, @lukastonhajzer, @CharalamposTheodorou
* Donate link: https://opencollective.com/mylanguageskills
* Tags: wordpress, multisite, pressbooks
* Tested up to: WP 5.2.4
* Tested UP:  Pressbooks 5.9.5
* Stable tag: 1.2.8
* License:  GPL 3.0
* License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Extended core functionalities for Pressbooks

## Description

This plugin provides tiny extensions for main functionality of pressbooks.

The plugin offer the following functionalities

## Original Mark

Original Mark package provides network administrators with ability to mark books of original publisher. It is done with a checkbox in `/wp-admin/network/sites.php` page, after activation of a plugin you will have new column there with name 'Featured Books'.

## EFP settings page

Extensions for PressBooks provides a blank settings page on network and on book level that can be filled with settings of other plugins.

## pb_is_based_on metadata update option

pb_is_based_on metadata save the URL of the source of the content if the book is cloned. With pb_is_based_on metabox, we can see the URL of the source of the content or to update to a new URL if the source change the URL for some reason or is a page created without being cloned.

>Current URL:
>[/english-a1-grammar/chapter/cardinal-numbers/]
>
>Insert new URL:
>[ ]

## Canonical

Canonical package provides network administrators with ability to choose canonical URL of cloned books.
This functionality works only with "The SEO Framework" plugin active.
If book is original -> The SEO framework canonical url of pages
If book is a clone -> checkbox available in Appearance -> EFP Customization, the canonical is the parent page.
If clone is also featured -> checkbox focusable (canonical to the page or the parent page).

## default theme

As plugin is supposed to be used with our [child theme](https://github.com/my-language-skills/books4languages-book-child-theme-for-pressbooks), the plugin also will set up this theme for all newly created books if theme is installed and network active.

## Installation

1. Clone (or copy) this repository folder `extensions-for-pressbooks` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' screen in WordPress

## Upgrades

For upgrades, download the las stable version from github, delete from FTP the old plugin and install the new one.

## Requirements

Extensions for pressbooks requires:

* [Pressbooks](https://github.com/pressbooks/pressbooks)

Extensions For Pressbooks plugin works with:

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
* **ADDITIONS**
  * UPDATE network-admin.php
  * ADDED Canonical functionality that creates a checkbox to set the canonical URL of the book

* **MODIFICATIONS**
  * efpb-admin-settings create new canonical section in EFP -> Customization

* **REMOVED**
  * Unistall translation section is mooved to Translations for Pressbooks

### Soon

### Later

### Future

### Changelog
### 1.2.9
* **ADDITIONS**
  * Translation functions added to all Titles and Input values of the plugin.
  * Sanitized all input from user input and database updates
  * Escape all html attributes before updating contents on front-end
  * All function names and actions contain the plugin prefix to prevent conflictions with other plugins

### 1.2.8
* **ADDITIONS**
  * New blogs use default permalink (blogname)

### 1.2.7
* **REMOVED**
  * Deregister dashicons REMOVED
  * Unistall translation section is now in Translation for Pressbooks plugin

#### 1.2.6
* **ADDITIONS**
   * Added drop down menu to choose books written in a specific language.
   * Now all languages are available to be choosen
   * Added new functionality: now in the dropdown menu are shown only available languages and not all.

#### 1.2.5
* **ADDITIONS**
   * EFP Customization settings section and setting field added to site level for this plugin added. (to the "platform" created in previous version).
   * Metabox in post edit which contains input field where we can add new pb_is_based_on URL for currently opened post.
   * 'Settings saved' information bar have been added to inform user settings have been updated sucessfully.
   * post-edit pb_is_based_on metabox is now shown even when pb_is_based_on value is not set for the current post.

 * **MODIFICATIONS**
    * Possibility to display 'pb_is_based_on' metabox on post-edit page enabled also for books with no 'pb_is_based_on' value (source books)

* **LIST OF FILE REVISED**
   * ADDED efpb-post-metabox-pb_is_based_on.php
   * ADDED efpb-admin-settings
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
