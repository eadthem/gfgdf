#!/bin/bash


export CFLAGS=-m32


g++ -m32 -std=c++0x -O3 -g3 -Wall -c -fmessage-length=0 -MMD -MP -MF"main.d" -MT"main.o" -o "main.o" "main.cpp"
g++ -m32 -o "gfgDiskWipe"  ./main.o 
