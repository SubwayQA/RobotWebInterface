#!/bin/sh

export DISPLAY=:0
export HOME=/home/pi/

path="/home/pi/uploads"
old_string="EndProlog"
#new_string="EndProlog\n\n%%BeginSetup\n << /PageSize [842 595] /Orientation 3 >> setpagedevice\n%%EndSetup\n"
new_string="EndProlog\n\n%%BeginSetup\n << /PageSize [842 595] /Orientation 3 >> setpagedevice\n%%EndSetup\n"

rm -f $path/bar_code.ps
rm -f $path/bar_code.pdf
rm -f $path/bar_code-1.png

xset dpms force on

barcode -b $1 -g 800x400 -o $path/bar_code.ps
sed -i "s;$old_string;$new_string;g" $path/bar_code.ps
#barcode -b $1 -o $path/bar_code.ps
ps2pdf $path/bar_code.ps $path/bar_code.pdf
pdftoppm -png $path/bar_code.pdf $path/bar_code
feh -F $path/bar_code-1.png > /dev/null 2>&1 &
echo "{\"response\" : \" OK \"}"

