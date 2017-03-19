#!/bin/sh

kill -9 $(pgrep gs)
kill -9 $(pgrep gv)

echo "{\"response\" : \" OK \"}"; 