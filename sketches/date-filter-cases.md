

* days in given dates are ignored
* change _from to first day of month
* change _to to last day of month

* column names as month short names
* if year(_from) != year(_to) --> column name = month name + year



case: _from = "", _to = ""
--> expect: _from = january of current year, _to = current month

case: _from = date, _to = ""
--> expect: _to = december, same year as _to

case: _from = date, _to = date
--> no problem if _to is later than _from

case: _from = "", _to = date
--> expect: _to = january, same year as _from

case: _from = YYYY --> year (int, 4 digits)
--> expect: _from = jan, 1st of year

case: _to = YYYY --> year (int, 4 digits)
--> expect: _to = dec, 31th of year

case: _from/_to = MM.YYYY (1/2 digits, delimiter, 4 digits)
case: _from/_to = YYYY.MM (4 digits, delimiter, 1/2 digits)
--> explode by delimiter, expect: 4digit = year, 1/2digit = month