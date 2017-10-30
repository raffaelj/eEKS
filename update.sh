#!/bin/bash

# updating eEKS development version on an Uberspace

FILE=eEKS.db.ini.php

if [ -f $FILE ]
then

  # grep dbname from `db.eEKS.ini.php`
  source <(grep ^dbname $FILE | sed 's/ *= */=/g')
  source <(grep ^username $FILE | sed 's/ *= */=/g')

  ## grab all new fancy files
  git pull

  ## optional: copy config file
  cp config/eEKS.config.ini.php.dist config/eEKS.config.ini.php

  ## optional: copy EKS profile
  cp profiles/default.ini.php.dist profiles/default.ini.php

  ## optional: insert new sample data in mysql database
  mysql $dbname < sample_data.sql
  
  echo Update successful

else
  echo $FILE does not exist. Please copy {$FILE}.dist to {$FILE}, enter your database login credentials and try to update again.
fi

# unset variables
unset FILE
unset dbname
unset username