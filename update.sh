#!/bin/bash
cd ~/questrequest.ru/public_html/; 
local git_status=$(git status --porcelain 2>/dev/null)
if [ "$git_status" == "" ]
   then
       git_modified_color="\[${RED}\]"
   fi
git add .
git commit -m 'Изменения Димы и с сервера'
git push

git pull