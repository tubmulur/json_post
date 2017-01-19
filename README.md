# Simple realtime ticket order system with simple debug interface.

JSON MYSQL PHP
Allows to order tickets from table SPOT.
Ticket has statuses: blocked, ready to pay, payed

# Usage
Insert your tickets into table spot.
To order it run /api/SessionSubscribe


# Installation
1) Setup class is in folder /config/
2) MySql Database structure  api_sql.tar.gz

Как установить:
1) Copy project files into your web directory document_root, like this: /home/project_root/api/index.php
2) Configure database connection /config/
3) Load all MySql database structure scripts from  api_sql.tar.gz
6) Attention! Scripts MUST be load step by step first is _0_....sql   second is 1_....sql  etc.
7) Debug form class /object/Form.php
# DEMO
http://lastdayradio.com/api/Table
http://lastdayradio.com/api/SessionSubscribe
Order tickets method
http://lastdayradio.com/api/PostNews
News poster, that posts without duplicates. 
