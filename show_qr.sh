#!/bin/sh

export DISPLAY=:0
export HOME=/home/pi/

path="/home/pi/uploads"

xset dpms force on

rm -f $path/qr_code.png
rm -f $path/qr_output
/usr/local/bin/qrencode -s 20 -l H -v 1 -o $path/qr_code.png $1
echo "{\"response\":\"" > $path/qr_output
zbarimg  $path/qr_code.png >> $path/qr_output
echo "\"}" >> $path/qr_output
feh -F $path/qr_code.png > /dev/null 2>&1 &  
cat $path/qr_output

