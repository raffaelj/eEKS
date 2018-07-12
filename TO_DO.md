# To do

This list contains things to do, ideas and internal bug tracking until other people use the Github issue tracker.

see also [DONE.md](DONE.md)

## Besides coding

* [ ] language review (my English is rusty)
* [ ] documentation for developers
* [ ] documentation for users
* [ ] review from financer --> Is everything correct?
* [ ] user feedback --> Use cases I didn't expect
* [ ] versioning and changelog

## strategic

* [ ] port a lot of new features to lm or fork lm

## Essential features

* [x] a way to handle reimbursements
* [ ] invoices
  * needs customer database
* [ ] estimated EKS
* [ ] concluded EKS (part C)
* [ ] user authentication system
* [ ] input validation
* [ ] responsive navigation and search bar
* [ ] anonymise data (columns) for export

## important, but not essential

* [ ] customer database
* [ ] product database
* [ ] periodic entries
* [ ] nice looking dashboard
* [ ] notices and warnings on user defined events
* [ ] deamon with mail notifications (daily, monthly overview etc.)
* [ ] more icons
* [ ] driver's log
* [ ] print CSS for (large) tables


## structural

* [ ] split eEKS into eEKS and data-multi-grid/lm fork/whatever

### revise lm code, structural changes and features

* nice to have:
  * [ ] info about column on th:hover (or click?)
* no javascript for basic usage
  * delete dataset without javascript
    * [x] single from grid
    * [x] multi from grid (without confirmation)
    * [ ] multi from grid (with confirmation)
    * [x] single from form
  * [x] back
  * [ ] multi delete
  * [ ] go button on giant datasets
  * [x] trigger page redirect on pagination
* CSV export
  * [x] optional renaming of column headers
  * [ ] needs i18n number_format
  * [ ] doesn't work with multiple grids (chooses first grid)
  * [ ] trigger for export should be outside of grid
* experimental multi-value column
  * [x] grid
  * [ ] with grid_input_control
  * [x] with column sums
* [x] PDF export
  * [x] trigger for export must be outside of grid ! --> also for pdf background fix
  * [x] mixed landscape/portrait (EKS)
  * [ ] user should choose if landscape or portrait
  * [ ] use different margins for EKS and all other pages
  * [ ] doesn't recognize changed input fields, expected: output same as screen, should submit form data to querystring
  * [x] background-image not loading inside @media print, [wkhtmltopdf issue](https://github.com/wkhtmltopdf/wkhtmltopdf/issues/3126)
  * [x] export of CBA/EÜR doesn't work (unescaped ampersands in qs)
  * [ ] export of Dashboard doesn't work (missing qs:action in link)
  * [x] export of EKS doesn't work  (unescaped ampersands in qs)
* [x] optional: disable links in column headers (for EKS to prevent unwanted sorting)
* [x] print CSS - deactivate optional background image

### filters

* [ ] account
* [ ] filter by custom categories (without tables, via ini file)
* [ ] reset all filters (or reset for each filter)

### views/pages

* [ ] think about restructuring views and actions
* [ ] views need their own config file or section in config.ini
* [ ] dashboard (with views)
  * [x] move to action or somewhere else, it contains views and shouldn't be a view itself
* [ ] monthly sums
  * [ ] only income
  * [ ] only costs
  * [ ] join chart_of_accounts (EKS)
  * [ ] cash basis accounting (German: EÜR)
* [ ] EKS preview
* [ ] charts --> maybe with javascript
* [x] accounting (default page)
  * [x] extra: records without value_date
* [ ] settings
  * [x] change content of tables (as view with table name via $_GET and some input controls)
  * [ ] change (some) content of ini files
* [x] yearly sums - average is wrong

### EKS preview

* [x] configuration file for not changing/ personal data
* [x] choose profiles
  * [x] better check $_GET parameters to avoid notices
* [ ] edit profiles in form
* [x] concluded
* [ ] estimated
  * [x] solve rounding issues in sums
  * better algorithm
    * [x] exclude some types of cost from growing
    * [ ] intended growth = 0 not possible
  * [ ] automated sums on every page
  * [ ] save estimated data for comparing in the future
* [x] rotate landscape pages for printing and PDF export
* [x] show only one/some pages
  * [x] table pages require variables from page before (sum, carryover)
* [x] EKS page 1, 4.1 image - missing text "handelt."
* [x] EKS page 4, remove "e)" to "i)" from image to avoid overlapping of text

### GUI and styling

* [ ] CSS for small(er) screens
* [ ] all select boxes need titles
* [ ] cross browser print CSS - Oh my god!
  * `white-space:nowrap` seems to break layout in FF and wkhtmltopdf
  * rotate hack - page-break with margin-top breaks in Opera
  * print preview EKS seems to work in (System: Win7Pro, 64bit)
    * [x] wkhtmltopdf
    * [x] Firefox 56.0.2 (64-Bit)
    * [x] Google Chrome 62.0.3202.89 (64-Bit)
    * [x] Opera 49.0
    * [ ] Internet Explorer 11 --> Don't use this damn browser!
      * margin:0 not possible - Why?
      * --> page sizes and input fields break
      * svg background icon not correct
    * ... Safari, Edge etc. not tested yet

### validation

* [x] gross_aout must be negative if type_of_costs != is_income
* [ ] date formats
* [ ] number formats
* [ ] no text in numerical or date fields

### nice to have

* [ ] split record into multiple records (multiple products, same invoice, different categories)