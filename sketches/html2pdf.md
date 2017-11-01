# PDF to HTML

## communication between PHP and other languages

### python - xampp

* https://stackoverflow.com/questions/8363247/python-xampp-on-windows-how-to#8365990

### python - php

* https://stackoverflow.com/questions/19735250/running-a-python-script-from-php#19736494
* https://stackoverflow.com/questions/8984287/execute-php-code-in-python


## Converter

### weasyprint

* https://weasyprint.readthedocs.io/en/stable/install.html
* has dependencies with sudo apt-get --> may not work on Uberspace
* really doesn't like Windows
* installation help on Windows:
  * https://gist.github.com/doobeh/3188318
  * https://github.com/Kozea/WeasyPrint/issues/330
  * https://stackoverflow.com/questions/38556368/getting-oserror-dlopen-failed-to-load-a-library-cairo-cairo-2-on-windows#38556369
  * https://github.com/Kozea/CairoSVG/issues/84

### wkhtmltopdf

* https://wkhtmltopdf.org/downloads.html
* PHP Wrapper: https://github.com/mikehaertl/phpwkhtmltopdf
* bad CSS3 support
  * `calc()` doesn't work
* no CSS @page rule


installation on Uberspace: https://wiki.uberspace.de/faq#wkhtmltopdf (wrong download link)

```bash
$ mkdir ~/tmp ; cd ~/tmp
$ wget https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.4/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz
$ tar xf wkhtmltox-0.12.4_linux-generic-amd64.tar.xz
$ cp ~/tmp/wkhtmltox/bin/* ~/bin/
```

install alpha version:

```bash
$ mkdir ~/tmp ; cd ~/tmp
$ wget https://bitbucket.org/wkhtmltopdf/wkhtmltopdf/downloads/wkhtmltox-0.13.0-alpha-7b36694_linux-centos6-amd64.rpm
$ rpm2cpio https://bitbucket.org/wkhtmltopdf/wkhtmltopdf/downloads/wkhtmltox-0.13.0-alpha-7b36694_linux-centos6-amd64.rpm | cpio -idmv
$ cp ~/tmp/usr/local/bin/* ~/bin/
```

