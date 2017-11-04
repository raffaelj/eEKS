# eEKS

Simple accounting software with automation for "[Anlage EKS][1]" (a document needed in Germany for freelancers with unemployment benefits)

Alternative pronounciation ([IPA][2]): [iːks] ;-)

__EKS__ = income from self-employment (German: Einkommen aus selbständiger Tätigkeit)  
__e__ = easy, electronic... or in German: einfach, erledigt, elektronisch...

Kindly excuse my clause grammar mistakes and some wrong vocabularies. I try my best. Feel free to file an issue or to send a pull request with corrections.

This will be a complete rewrite of a "works for me" solution with some bugs in a private repo of mine.

The original one grew over a few years after experimenting with Open Office Base, porting the database to SQLite and later to MySQL. Open Office Base doesn't work well, is complicated and I really don't like the visual experience. With [lazymofo/datagrid][3] I found an easy solution to insert and change my data and every time I needed a new feature I hacked a view new lines in the code, mixed up German and English variable names...

This time I try to have a cleaner coding style, avoid any German language in the source code and translate it later with a language file.

The code is based on lazy_mofo/datagrid with a lot of additions.

## Warning

Don't use this software if you dont't know what's going on. Don't use it on a public available web server. It's in a very early state with no security features. I use it in a local environment with [XAMPP][4].

## Demo database scheme with sample data

You can import `sample_data.sql` with English column headers and German sample data.

## installation/demo

It's work in progress! There are no security features!

instructions for installing on an [Uberspace](https://uberspace.de/):

* only MYSQL 5.1 possible until they update to CentOS 7
  * --> no `utf8mb4`
  * --> no two auto timestamp columns for `date_created` and `date_last_changed`

more info coming soon...

* create a new database
* import `sample_data.sql`
* via console:

```bash
# go to web root
cd /var/www/virtual/$USER/html;

# clone repo
git clone https://github.com/raffaelj/eEKS.git;

# open folder
cd eEKS;

# copy config dist files
cp eEKS.db.ini.php.dist eEKS.db.ini.php
cp eEKS.config.ini.php.dist eEKS.config.ini.php

# add your database credentials
nano eEKS.db.ini.php
```

Now eEKS should be available under `http://username.servername.uberspace.de/eEKS`

### Updating to newest development version with sample data

* navigate to your eEKS directory for example: `cd /var/www/virtual/$USER/html/eEKS`
* make `update.sh` executable `chmod 744 update.sh`
* run `./update.sh`

Now eEKS should be available under `http://username.servername.uberspace.de/eEKS`

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

* y10k bug ;-)

## To do

### revise lm code and features

* delete dataset without javascript
  * [x] single from grid
  * [x] multi from grid (without confirmation)
  * [x] from form
* grid - set class names (or data attributes) for data types
  * [x] get rid of javascript inside code
  * [x] get rid of inline styles (nowrap, align...)
  * [x] position of edit link, export link and searchbox should be defined in template file; div instead of table
  * extra classes like
      * [ ] with_rollup (last row bold)
      * [x] positive/negative numbers (colors/backgrounds)
      * [x] number (text-align:right)
      * [x] number, date, datetime
  * [ ] possibly HTML5 data attributes for easier evaluation with javascript
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
* [ ] no javascript for basic usage
  * [x] delete
  * [x] back
  * [ ] multi delete
  * [ ] go button on giant datasets
* [x] output via template file
* [ ] CSV export needs i18n number_format
* experimental multi-value column
  * [x] grid
  * [ ] with grid_input_control
  * [x] with column sums
* [ ] Export to CSV doesn't work with multiple grids
* [x] PDF export
  * [ ] mixed landscape/portrait (EKS)
  * [ ] user should choose if landscape or portrait
  * [ ] use different margins for EKS and all other pages

### pages

* [ ] dashboard (with views)
* [x] accounting (default page)
  * [ ] extra: records without value_date
* [ ] options
  * [x] change content of tables
  * [ ] change (some) content of ini files

### searchbox

* [x] not in grid
* [x] add filters

### filters

monthly view needs filters, too 

* [ ] income/costs
  * [x] default + no_date
  * [ ] monthly view
* [x] value_date (from - to)
* [x] vaoucher_date (from - to)
* [x] without value_date
* [x] type_of_costs
* [x] mode_of_employment
* [ ] account
* [ ] filter by custom category
* [x] full text search
* [ ] GROUP BY something (except notes, files) --> see views->monthly sums

### views

* [ ] monthly sums
  * [ ] only income
  * [ ] only costs
  * [ ] join chart_of_accounts (EKS)
  * [ ] cash basis accounting (German: EÜR)
* [ ] EKS preview
* [ ] charts --> maybe with javascript

### EKS preview

* [ ] configuration file for not changing/ personal data
* [ ] concluded
* [ ] estimated
  * [ ] automated sums on every page
  * [ ] save estimated data for comparing in the future
* because browsers dont't understand mixed page sizes (landscape and portrait) in print CSS
  * [ ] page 1-2
  * [ ] page 3-6










 [1]: https://www3.arbeitsagentur.de/web/content/DE/Formulare/Detail/index.htm?dfContentId=L6019022DSTBAI516946
 [2]: https://en.wiktionary.org/wiki/Wiktionary:International_Phonetic_Alphabet
 [3]: https://github.com/lazymofo/datagrid
 [4]: https://www.apachefriends.org/index.html