.. include:: /Includes.rst.txt

Configuration
=============

Changing paths of the templates
===============================

Please do never change templates directly in the Ressources folder of the extensions,
since your changes will get overwritten by extension updates.

The easiest way to override templates is to set the following constants:

* :typoscript:`plugin.vek_event_extensions.view.templateRootPath`
* :typoscript:`plugin.vek_event_extensions.view.partialRootPath`
* :typoscript:`plugin.vek_event_extensions.view.layoutRootPath`

Those values will automatically be added after the default paths configuration of the extension. If you prefer
to configure the path-values using TypoScript setup, please refer to the example below
(note the **plural** of the path-name)::

  plugin.vek_event_extensions {
    view {
      templateRootPaths {
        3 = EXT:sitepackage/Resources/Private/Extensions/EventExtensions/Templates/
      }
      partialRootPaths {
        3 = EXT:sitepackage/Resources/Private/Extensions/EventExtensions/Partials/
      }
      layoutRootPaths {
        3 = EXT:sitepackage/Resources/Private/Extensions/EventExtensions/Layouts/
      }
    }
  }

Doing so, you can just **override single files** from the original templates.

Adjust registration template only via TS constants
==================================================
In case you just want to override the registration template, you can also use the following constants:

* :typoscript:`module.vek_event_extensions.settings.certificate.templatePath`
* :typoscript:`module.vek_event_extensions.settings.certificate.stampImagePath`

Those constants allow you to set a custom template file and a custom stamp image.
Example::

EXT:sitepackage/Resources/Private/Extensions/EventExtensions/Templates/Certificate/CustomTemplate.html
EXT:sitepackage/Resources/Public/Images/CustomStamp.png

Using the remaining constants you can adjust the sender names, email addresses and subject lines for the respective emails.
They should be self-explanatory.

If no sender name or email address is provided, the notification mail settings from `sf_event_mgt` will be used.
If no subject line is set, emails will not be sent.
