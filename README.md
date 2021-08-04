## Menu Manager for Magento 2
This integration for Magento 2 allows store administrators and site builders to manage menus from the user interface.

Menu Manager offers many features that increase productivity and maintenability when working on navigation systems for Magento 2 stores.

Menu Manager does the heavy work in the background and removes the need for technical skills, making it easier and faster to build navigation systems for Magento 2 stores.

## Features
* Create custom menus and menu links
* Override core menus
* Manage menu access permissions
* Generate product and category links
* Tree structures display
* Unlimited menu depth
* Drag and drop interface
* Upload and display link images
* Generate XML sitemaps
* Vertical and horizontal menus
* Multi store mode support
* Multi languages support

## Composer installation
The easiest and recommended way to install Menu Manager for Magento 2 is to run the following commands in a terminal, from your Magento 2 root directory:

```bash
composer require naxero/menu-manager:*
```

## Manual installation
You can also install Menu Manager for Magento manually.

From the root of your Magento 2 installation, create a directory named <strong>app/code/Naxero/MenuManager</strong>

Upload the repository files into the folder created, and make sure the file and folder permissions match your server configuration and requirements.

Usually, you will need folders with <strong>chmod 755</strong>, files with <strong>chmod 644</strong>, and the web server user:group as owner of the Magento 2 installation's file system.

## Enable the integration
Once the extension installed, run the following command in the terminal, from the Magento 2 root directory:

```bash
bin/magento module:enable Naxero_MenuManager
```

For more information Magento 2 exetnsions installation and update process, please have a look at the offcicial Magento 2 technical documentation.

## License
This sofware is released under the GNU GPL3 license. See <http://www.gnu.org/licenses>.

## Copyright
Copyright (C) 2021 David Fiaty | 
[www.davidfiaty.com](https://www.davidfiaty.com "David Fiaty")
