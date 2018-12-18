##Small task system PHP + Kohana

As admin you have rights to add/modify users, add/modify tasks, add/modify devices,
As simple user you able to add/modify tasks, add/modify devices

After adding device and it's location, you able to add task.
There are 2 types of task: Permanent and Temporary.

Temporary could be edited and modified
Permanent is a static task.

Next step is preview mode, where you adding emails to notify your users.
After saving, you can view your task by clicking eye icon on tasks list.

Make directories *application/cache* and *application/logs* writable

Configure database access in *application/config/database.php*, use **alternate** version, it's already using PDO driver and integrated with migrations, if you prefer different driver, don't forget to edit *application/config/migration.php*

After setting up database setting and hosting connection, run migrations in console

```PHP
php index.php db:migrate
 ```
OR (if not working)

```PHP
/.minion db:migrate
 ```
 
By default your admin panel access http://yourdomain/admin

login: admin
pass: 123456

You can change it by editing it in user section of admin panel

Modify default languages in *application/config/lang.php*, first for website's front, second - for admin panel. Don't forget put your language files directly into application/i18n 

In *application/config/security.php* file you can give privileges to users, I've presetted read/add/write/remove (CRUD correctly) rights to admin user with role = 2, and read/save to other users
 
 

