# Lara CMS - Pages module

This is a <a href="https://github.com/Grundmanis/laracms">Laracms module</a>. 
This module allows to create a new pages with urls for your website.

![laracms dashboard](https://user-images.githubusercontent.com/6103997/35482156-c64ad344-0439-11e8-9972-db1f9c9c89b4.png)

## How to use

Publish page layouts to make available to modify them
```
php artisan vendor:publish --tag=laracms_pages
```
Then `resources/views/laracms/pages/layouts` will appear with 2 already created layouts, 
You can create your own layouts in this folder and they will be automatically grabbed by laracms.

Click on "pages" menu point or go to `yourhost.com/laracms/pages/`, create a new page by using unique URL, choose layout and
type some text. Now, You can see your page: `yourhost.com/whatever_created_page_slug_here`

## Installation
Run 
```
composer require grundmanis/laracms-pages
```
then run migration:
```
php artisan laracms:configure
```