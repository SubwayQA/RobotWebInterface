#!/bin/sh

export DISPLAY=:0
export HOME=/home/pi/

xset dpms force on

feh -F /bender_kill_all_humans3.jpg > /dev/null 2>&1 &  
echo "Oh, YES, baby!"

