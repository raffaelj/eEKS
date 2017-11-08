# eEKS

Simple accounting software with automation for "[Anlage EKS][1]" (a document needed in Germany for freelancers with unemployment benefits)

Alternative pronounciation ([IPA][2]): [iːks] ;-)

__EKS__ = income from self-employment (German: Einkommen aus selbständiger Tätigkeit)  
__e__ = easy, electronic... or in German: einfach, erledigt, elektronisch...

Kindly excuse my clause grammar mistakes and some wrong vocabularies. I try my best. Feel free to file an issue or to send a pull request with corrections.

This will be a complete rewrite of a "works for me" solution with some bugs in a private repo of mine.

The original one grew over a few years after experimenting with Open Office Base, porting the database to SQLite and later to MySQL. Open Office Base doesn't work well, is complicated and I really don't like the visual experience. With [lazymofo/datagrid][3] I found an easy solution to insert and change my data and every time I needed a new feature I hacked a few new lines in the code, mixed up German and English variable names...

This time I try to have a cleaner coding style, avoid any German language in the source code and translate it later with a language file.

The code is based on lazy_mofo/datagrid with a lot of additions.

## Warning

Don't use this software if you dont't know what's going on. Don't use it on a public available web server. It's in a very early state with no security features. I use it in a local environment with [XAMPP][4].

## Demo database scheme with sample data

You can import `sample_data.sql` with English column headers and German sample data.

## installation demo and update

It's work in progress! There are no security features!

demo: coming soon

If you want to try the dev version have a look at [docs/install.md](docs/install.md).

updating to newest dev version: run `update.sh ini sql` (renews data, config files and database)


## Version and license

coming soon

## Features of eEKS

* all accounting data in one table with customizable categorization
* basic overviews with filter functions (coming soon)
* automation of "Anlage EKS" (coming soon)
* ...

## Code features compared to lazy_mofo/datagrid (all work in progress)

* no javascript for basic functionality like delete or back link
* no inline styles
* duplicate existing dataset
* multi-value column
* i18n of number_format (dot or comma as decimal points etc.)
* class names for some content types like numbers and dates to allow styling by content
* template files
* automatic generation of grid_sql (with config in ini file)
* filters in search box

## Notes

* grid_multi_delete works, but has no confirmation message

## Requirements and restrictions

* based on [lazy_mofo/datagrid][3], which requires
  * PHP 5+ and MySQL 5
  * Magic Quotes should be turned off
  * PDO MySQL module installed for PHP
  * Database table must have a primary key identity
  * Multibyte Support / mbstring must be enabled
* PDF export requires [wkhtmltopdf](https://wkhtmltopdf.org/downloads.html)
* y10k bug ;-)

## To do

### top priority

* invoices (needs customer database)
* concluded EKS
* custom filters in search bar for EKS
* estimated EKS
* discuss porting features to lm

### lower priority

* customer database
* product database
* dashboard
* better GUI (navigation, search bar, settings)
* icons
* save user authentication
* translate GUI
* translate everything
* driver's log
* print CSS for (large) tables

### revise lm code, structural changes and features

* grid - set class names (or data attributes) for data types
  * [x] get rid of javascript inside code
  * [x] get rid of inline styles (nowrap, align...)
  * [x] position of edit link, export link and searchbox should be defined in template file; div instead of table
  * extra classes like
      * [x] <del>with_rollup</del> optional column with sums (last row bold)
      * [x] positive/negative numbers (colors/backgrounds)
      * [x] number (text-align:right)
      * [x] number, date, datetime
  * [x] HTML5 data attributes for easier evaluation with javascript or styling for small screens
  * nice to have:
    * [ ] info about column on th:hover (or click?)
* i18n number format (dot, comma)
  * [x] number_in()
  * [x] number_out()
  * [x] Bug: int output as float, should be int
* [x] custom search box
* [x] filter functions (for search box)
* [x] custom function cast_value (i18n number format)
* custom function get_input_control
  * [x] i18n number format
  * [x] no inline styles
* [x] no inline styles
* no javascript for basic usage
  * delete dataset without javascript
    * [x] single from grid
    * [x] multi from grid (without confirmation)
    * [ ] multi from grid (with confirmation)
    * [x] single from form
  * [x] back
  * [ ] multi delete
  * [ ] go button on giant datasets
* [x] output via template file
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
  * [ ] trigger for export must be outside of grid
  * [x] mixed landscape/portrait (EKS)
  * [ ] user should choose if landscape or portrait
  * [ ] use different margins for EKS and all other pages
  * [ ] doesn't recognize changed input fields, expected: output same as screen, should submit form data to querystring
* [x] I really have to figure out how `$this->query_string_list` works for _view, _lang, _action
* [x] escape ampersands in links
* [ ] optional: disable links in column headers

### searchbox

* [x] not in grid
* [x] add filters
* [ ] custom searchbox per view

### filters

monthly view needs filters, too 

* [ ] income/costs
  * [x] default + no_date
  * [ ] monthly view
* [x] value_date (from - to)
* [x] voucher_date (from - to)
* [x] without value_date
* [x] type_of_costs
* [x] mode_of_employment
* [ ] account
* [ ] filter by custom category
* [x] full text search
* [ ] GROUP BY something (except notes, files) --> see views->monthly sums

### views/pages

* [ ] views need their own config file or section in config.ini
* [ ] dashboard (with views)
  * [ ] move to action or somewhere else, it contains views and shouldn't be a view itself
* [ ] monthly sums
  * [ ] only income
  * [ ] only costs
  * [ ] join chart_of_accounts (EKS)
  * [ ] cash basis accounting (German: EÜR)
* [ ] EKS preview
* [ ] charts --> maybe with javascript
* [x] accounting (default page)
  * [ ] extra: records without value_date
* [ ] settings
  * [x] change content of tables (as view with table name via $_GET and some input controls)
  * [ ] change (some) content of ini files

### EKS preview

* [x] configuration file for not changing/ personal data
* [ ] choose profiles
* [ ] edit profiles in form
* [ ] concluded
* [ ] estimated
  * [ ] automated sums on every page
  * [ ] save estimated data for comparing in the future
* [x] rotate landscape pages for printing and PDF export
* [x] show only one/some pages
  * [ ] table pages require variables from page before (sum, carryover)


### GUI and styling

* [ ] CSS for small(er) screens
* [ ] all select boxes need titles
* [ ] cross browser print CSS - Oh my god!
  * `white-space:nowrap` seems to break layout in FF and wkhtmltopdf






 [1]: https://www3.arbeitsagentur.de/web/content/DE/Formulare/Detail/index.htm?dfContentId=L6019022DSTBAI516946
 [2]: https://en.wiktionary.org/wiki/Wiktionary:International_Phonetic_Alphabet
 [3]: https://github.com/lazymofo/datagrid
 [4]: https://www.apachefriends.org/index.html