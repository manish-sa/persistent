#!/bin/sh
check=`cat /proc/loadavg | sed 's/./ /' | awk '{print $1}'`
max_load='25'
# log file
high_load_log='/var/log/apache_high_load_restart.log';
# location of inidex.php to overwrite with temporary message
index_php_loc='/var/www/index.php';
apache_init='/etc/init.d/apache2';
site_maintenance_msg="Site Maintenance in progress";
if [ $check -gt "$max_load" ]; then>
    cp -rpf $index_php_loc $index_php_loc.bak_ap
    echo "$site_maintenance_msg" > $index_php_loc
    sleep 15;
    if [ $check -gt "$max_load" ]; then
        $apache_init stop
        sleep 5;
        $apache_init restart
        echo "$(date) : Apache Restart due to excessive load | $check |" >> $high_load_log;
        cp -rpf $index_php_loc.bak_ap $index_php_loc
    fi
fi

# restart Apache if load is higher than 25 set cron using below command
# */5 * * * * FILE_PATH/load_average.sh >/dev/null 2>&1