## Menu Manager for Magento 2
The Menu Manager extension for Magento 2 allows administrators and site builders to manage menus from the user interface.

Menu Manager offers many features that increase productivity and maintenability when working on navigation systems for Magento 2 stores.

As most menu management tasks can be performed from the user interface, this integration removes the need for technical skills, making it easier and faster to build navigation systems.

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

## Installation with Composer 
The easiest and recommended way to install Menu Manager for Magento 2 is to run the following commands in a terminal, from your Magento 2 root directory:

```bash
composer require naxero/menu-manager:*
```

## Manual installation
You can also install Menu Manager for Magento manually:

* Step 1
From the root of your Magento 2 installation, create a directory named <strong>app/code/Naxero/MenuManager</strong>

* Step 2
Upload the repository files into the folder created, and make sure the file and folder permissions are configured properly.

## Enable the integration
Once the extension installed, run the following command in the terminal, from the Magento 2 root directory:

```bash
bin/magento module:enable Naxero_MenuManager
```

For more information on the Magento 2 module installation process, please have a look at the [Magento 2 official documentation](http://devdocs.magento.com/guides/v2.0/install-gde/install/cli/install-cli-subcommands-enable.html "Magento 2 official documentation")
