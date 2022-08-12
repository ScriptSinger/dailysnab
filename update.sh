#!/bin/bash
cd ~/questrequest.ru/public_html/; 
if [ "$git_status" != "" ]
   then
       git_modified_color="\[${RED}\]"
   fi
git add .
git commit -m 'Изменения Димы и с сервера'
git push

git pull