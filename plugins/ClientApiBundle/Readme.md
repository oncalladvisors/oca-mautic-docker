1) Copy directory ClientApiBundle INTO  {mautic-source}/addons/ 
2) Delete every directory and file inside {mautic-source}/app/cache/ 
3) From command line navigate into {mautic-source} direcotry and run 
    php app/console doctrine:schema:update --dump-sql

    This command should only print out  two queries 
    a) Query which creates a table called client_apis 
    b) Query which creates a table called request_action_log

4) If the step 3 goes as expected run 
     
    php app/console doctrine:schema:update --force

6) Open Addons page on Mautic and click install/Upgrade addons/

    After a few sec you will be able to see a new addon in the left menu in the table called Client Api, 
    switch it into active and you are done! 
     
    If you are not able to see the addon in the table repeat step 2 and step 6