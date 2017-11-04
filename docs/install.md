# installation

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


The PDF export requires [wkhtmltopdf](https://wkhtmltopdf.org/downloads.html).

* on Windows install the executable and take care of setting the path variable
* Uberspace with CentOs 6 has [these instructions](https://wiki.uberspace.de/faq#wkhtmltopdf)
* path example on Uberspace: `'/home/$USER/bin/wkhtmltopdf'`
* set the full path to wkhtmltopdf
  * in `index.php` with `$eeks-->wkhtmltopdf_path = '/home/$USER/bin/wkhtmltopdf'`
  * or in `config/eEKS.config.ini.php` with `wkhtmltopdf_path = "/home/$USER/bin/wkhtmltopdf"`
  


### Updating to newest development version with sample data

* navigate to your eEKS directory for example: `cd /var/www/virtual/$USER/html/eEKS`
* make `update.sh` executable `chmod 744 update.sh`
* run `./update.sh`

Now eEKS should be available under `http://username.servername.uberspace.de/eEKS`