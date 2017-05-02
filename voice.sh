#!/bin/sh

path="/var/www/html/"

export GOOGLE_APPLICATION_CREDENTIALS=$path/SubwayVoice-dd34529fa4c6.json
echo $1 | festival --tts
rec --encoding signed-integer --bits 16 --channels 1 --rate 16000 $path/answer.wav silence 1 0.1 1% 1 3.0 5%
python $path/transcribe.py $path/answer.wav > $path/transcribe.out
echo file_get_contents( "./transcribe.out" );

# Edinorozhka 2017