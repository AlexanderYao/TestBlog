#!/bin/sh
host='alexande.hkhost55.cachechina.org'
user='alexande'
password='dwy314926'

ftp -in $host << END
quote USER $user
quote PASS $password
cd domains/alexanderyao.com/public_html
put $1
bye
END
exit 0
