#!/bin/bash
# Cuts a Github release; this is necessary because the Git submodule wouldn't get included in the Git released .zip
# Arg: the release name

if [[ $# -eq 0 ]] ; then
    echo 'Supply a name for the release as a CLI arg'
    exit 0
fi

cd ..
cp -r eileen-southern-theme/ ~/Documents/southern_releases/eileen-southern-theme-$1
cd ~/Documents/southern_releases/eileen-southern-theme-$1
rm -rf .git
cd ..
zip -r eileen-southern-theme-$1.zip eileen-southern-theme-$1