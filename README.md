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


3) Copy project files into your web directory document_root, like this: /home/project_root/api/index.php
4) Configure database connection /config/
5) Load all MySql database structure scripts from  api_sql.tar.gz
6) Attention! Scripts MUST be load step by step first is _0_....sql   second is 1_....sql  etc.
7) Debug form class /object/Form.php
# DEMO
+ Demo user email is: demo@lastdayradio.com
+ http://lastdayradio.com/api/Table
+ http://lastdayradio.com/api/SessionSubscribe
# Order tickets method
+ http://lastdayradio.com/api/PostNews
+ News poster, that posts without duplicates. 
<!--
Copyright (c) 2017 lubimki.ru HQ audio software, RCeFramework

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

Redestribution of source code must retain the above copyright notice:

Created by lubimki.ru HQ audio software 2001-2017 with association with RCeFramework

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-->
