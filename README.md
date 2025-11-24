Extended Event Management — vE&K Event Extensions (vek_event_extensions)
======================================================================

Overview
--------
This extension builds upon the TYPO3 extension *sf_event_mgt* and adds
powerful enhancements for managing both standard and training events.

- Support for event types: Standard and Training
- Certificate generation with customizable PDFs
- Additional training-related registration fields
- Verification workflows for certificate eligibility
- Training points handling
- Email tools for certificates and online meeting information
- Automated reminder emails
- Backend modules for participant management

Requirements
------------
- TYPO3 v12
- `sf_event_mgt` extension installed and activated
- Composer-based project recommended

Installation
------------
1. Install the extension via Composer:

   ``vek/vek-event-extensions``

2. Execute the database compare to add the new fields.

3. Include the static TypoScript configuration `vE&K Event Extensions (vek_event_extensions)` in your TypoScript template.

4. Clear all caches.

License
-------
This project is distributed under the GNU General Public License (GPL) Version 2.
The full license text is included in `LICENSE.txt`.

Further documentation
---------------------
See the `Documentation/` folder for more detailed information.

Changelog
---------
See `Documentation/Changelog/Index.rst` for release notes and changes.
