#!/bin/bash

# updating eEKS development version on an Uberspace

FILE=eEKS.db.ini.php

if [ -f $FILE ]
then

  # grep dbname from `db.eEKS.ini.php`
  source <(grep ^dbname $FILE | sed 's/ *= */=/g')
  source <(grep ^username $FILE | sed 's/ *= */=/g')
  
  echo run update...

  ## grab all new fancy files
  git pull
  
  ## set `last_commit.txt` for temporary versioning
  git log -1 --date=format:"%Y-%m-%d %H:%M:%S" --pretty=format:%cd,%H>last_commit.txt
  
  ## optional: copy config file and EKS profile
  if [[ $1 = ini  ]] || [[ $2 = ini ]]
  then
    cp config/eEKS.config.ini.php.dist config/eEKS.config.ini.php
    cp profiles/default.ini.php.dist profiles/default.ini.php
    cp profiles/demo_gewerbe.ini.php.dist profiles/demo_gewerbe.ini.php
    echo config files updated
  fi

  ## optional: insert new sample data in mysql database
  if [[ $1 = sql  ]] || [[ $2 = sql ]]
  then
    mysql $dbname < sample_data.sql
    echo database reset with sample data
  fi
  
  echo Update successful

else
  echo $FILE does not exist. Please copy {$FILE}.dist to {$FILE}, enter your database login credentials and try to update again.
fi

# unset variables
unset FILE
unset dbname
unset username