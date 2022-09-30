#!/bin/bash

randstr() {
  index=0
  str=""
  for i in {a..z}; do arr[index]=$i; index=`expr ${index} + 1`; done
  for i in {A..Z}; do arr[index]=$i; index=`expr ${index} + 1`; done
  for i in {0..9}; do arr[index]=$i; index=`expr ${index} + 1`; done
  for i in {1..20}; do str="$str${arr[$RANDOM%$index]}"; done
  echo $str
}

echo "INSERT INTO users VALUES('admin', '"`randstr`"', 1);"  >> /db.sql 
sqlite3 /usr/local/app/db/users.db ".read /db.sql"
rm /db.sql

node /usr/local/app/bin/www
