# Done

see also [TO_DO.md](TO_DO.md)

## Essential features

* [x] concluded EKS (part A and B, without driver's log)

## structural

### revise lm code, structural changes and features

* grid - set class names (or data attributes) for data types
  * [x] get rid of javascript inside code
  * [x] get rid of inline styles (nowrap, align...)
  * [x] position of edit link, export link and searchbox should be defined in template file; div instead of table
  * extra classes like
      * [x] optional column with sums (last row bold)
      * [x] positive/negative numbers (colors/backgrounds)
      * [x] number (text-align:right)
      * [x] number, date, datetime
  * [x] HTML5 data attributes for easier evaluation with javascript or styling for small screens
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
* [x] output via template file
* [x] escape ampersands in links

### searchbox

* [x] not in grid
* [x] add filters
* [x] custom searchbox per view

### filters

* [x] income/costs
  * [x] default + no_date
  * [x] monthly view
* [x] value_date (from - to)
* [x] voucher_date (from - to)
* [x] without value_date
* [x] type_of_costs
* [x] mode_of_employment
* [x] full text search