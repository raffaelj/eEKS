# eEKS

Simple accounting software with automation for "[Anlage EKS][1]" (a document needed in Germany for freelancers with unemployment benefits)

Pronounciation ([IPA][2]): [iːks] ;-)

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
* basic overviews with filter functions
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

## Requirements and restrictions

* based on [lazy_mofo/datagrid][3], which requires
  * PHP 5+ and MySQL 5
  * Magic Quotes should be turned off
  * PDO MySQL module installed for PHP
  * Database table must have a primary key identity
  * Multibyte Support / mbstring must be enabled
* PDF export requires [wkhtmltopdf](https://wkhtmltopdf.org/downloads.html)
* y10k bug ;-)

## Notes, known bugs

* grid_multi_delete works, but has no confirmation message
* changing language works, but doesn't change posted dates in date filter

## To do

See [TO_DO.md](TO_DO.md) and [DONE.md](DONE.md).


 [1]: https://www3.arbeitsagentur.de/web/content/DE/Formulare/Detail/index.htm?dfContentId=L6019022DSTBAI516946
 [2]: https://en.wiktionary.org/wiki/Wiktionary:International_Phonetic_Alphabet
 [3]: https://github.com/lazymofo/datagrid
 [4]: https://www.apachefriends.org/index.html