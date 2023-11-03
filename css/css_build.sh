#!/usr/bin/env bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
NODE_MODULES=$SCRIPT_DIR/node_modules
MINTYLEIO=$NODE_MODULES/minstyle.io/dist/css
DARK_MODE_SWITCH=$NODE_MODULES/dark-mode-switcher
mkdir $SCRIPT_DIR/../templates/css
mkdir $SCRIPT_DIR/../templates/js
mkdir $SCRIPT_DIR/../public/css
mkdir $SCRIPT_DIR/../public/js
cp $MINTYLEIO/minstyle.io.min.* $SCRIPT_DIR/../templates/css
cp $DARK_MODE_SWITCH/dist/dark.min.js $SCRIPT_DIR/../templates/js
cp $MINTYLEIO/minstyle.io.min.* $SCRIPT_DIR/../public/css
cp $DARK_MODE_SWITCH/dist/dark.min.js $SCRIPT_DIR/../public/js

