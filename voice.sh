#!/bin/sh

path_server="/var/www/html"
path_home="/home/pi/uploads"

export GOOGLE_APPLICATION_CREDENTIALS=$path_server/SubwayVoice-dd34529fa4c6.json

echo $1 | festival --tts 
rec --encoding signed-integer --bits 16 --channels 1 --rate 16000 $path_home/answer.wav silence 1 0.1 1% 1 3.0 5% 2>&1 /dev/null
python $path_server/transcribe.py  $path_home/answer.wav > $path_home/transcribe.out
cat $path_home/transcribe.out

# Edinorozhka 2017