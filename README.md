# SSH-Putty2Remmina
A small PHP 8 script that can read a Putty backup taken from registry and creates remmina ssh profiles.

Maybe usefull for others...  Not planning to do more with the code, and you need PHP, so I guess you are a programmer. :-D

I had loads of putty based ssh server connections, which I wanted to use in remmina without spending hours adding them one by one.
It does not do anything more than : Name of connection, hostname and username
Although it is easy to add more if the data is available. I am using ssh keys, so login for me does not require password.

Putty registry files where in a weird format for Linux, so I did some conversion on it to remove redundant data.

To use : 

Edit the script to point to a backup of the windows registry containing Putty Server profiles.  (around line 20)

$data = explode(PHP_EOL,file_get_contents('/home/sinnige/Downloads/Putty backup Desktop.reg'));

run php -f convert.php

move the profiles to the remmina folder containing the remmina profiles.

/home/**username**/.var/app/org.remmina.Remmina/data/remmina/group_ssh_name_host.remmina
