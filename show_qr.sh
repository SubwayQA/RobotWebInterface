#!/bin/bash

export DISPLAY=:0
export HOME=/home/pi/

path="/home/pi/uploads"

xset dpms force on

rm -f $path/qr_code.png
rm -f $path/qr_output

info1=$1
info2=${info1//Tartakovsky/+}
info2=${info2//Bachchan/#}
info2=${info2//Federer/$}
info2=${info2//Sharapova/&}

/usr/local/bin/qrencode -s 20 -l H -v 1 -o $path/qr_code.png $info2
echo "{\"response\":\"" > $path/qr_output
zbarimg  $path/qr_code.png >> $path/qr_output
echo "\"}" >> $path/qr_output
feh -F $path/qr_code.png > /dev/null 2>&1 &  
cat $path/qr_output

