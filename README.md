Magento 2 Module providing connection to Beny Repricing API.(We advise you to test the module thoroughly on a dev system 
before you move it to production)

Requirements
============
1. Magento >=2.4
2. PHP >=7.2

Installation
============
Composer
--------
    composer require mediarox/module-beny-reprice
    bin/magento setup:upgrade
    
Features
========
Configuration
-------------
Fine tune settings provided by the Beny Repricing API directly in your Magento 2 backend.

Export Your Products
--------------------
... directly to Beny Repricing via .csv file.

Import Price Suggestions
------------------------
... from Beny Repricing directly into your catalog. (Default store view only - feature might be extended in the future)

Export Of Erroneous Products
----------------------------
... directly from your store backend into a .csv file.

Delete Products From Beny
-------------------------
... while deleting them from your catalog to keep your Beny database clean. (must be configured)