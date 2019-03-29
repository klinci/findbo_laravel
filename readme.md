30 	* 	* 	* 	* 	/usr/bin/php http://findbo.dk/cronjobs/inactivate_expired_properties.php > /dev/null 2>&1 & 	
   
0 	* 	* 	* 	* 	/usr/bin/php http://findbo.dk/cronjobs/inactivate_expired_seek_ads.php > /dev/null 2>&1 & 	
   
*/30 	* 	* 	* 	* 	/usr/bin/php http://findbo.dk/cronjobs/renew_seeker_packages.php > /dev/null 2>&1 & 	
   
0 	10 	* 	* 	* 	/usr/bin/php http://findbo.dk/cronjobs/renew_seeker_package_reminder.php > /dev/null 2>&1 & 	
   
0 	0,12 	* 	* 	* 	/usr/bin/php http://findbo.dk/cronjobs/update_sitemap.php > /dev/null 2>&1 & 	
   
30 	0 	* 	* 	* 	/usr/bin/php http://findbo.dk/cronjobs/property_hunting.php > /dev/null 2>&1 & 	
   
0 	* 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/cronjobs/delete_cron_response_files.php > /dev/null 2>&1 & 	
   
0 	2 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/cronjobs/delete_properties.php > /dev/null 2>&1 & 	
   
00 	05 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/api_housing_denmark.php > /dev/null 2>&1 & 	
   
00 	17 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/api_housing_denmark.php > /dev/null 2>&1 & 	
   
00 	06 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/dba_url.php > /dev/null 2>&1 	
   
15 	06 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/dba_detail.php > /dev/null 2>&1 	
   
00 	18 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/dba_url.php > /dev/null 2>&1 	
   
00 	18 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/dba_detail.php > /dev/null 2>&1 	
   
0 	0 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/cronjobs/delete_properties.php > /dev/null 2>&1 	
   
0 	0 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/cronjobs/import_properties.php > /dev/null 2>&1 	
   
30 	06 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/prodomus_url.php > /dev/null 2>&1 	
   
30 	18 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/prodomus_url.php > /dev/null 2>&1 	
   
45 	06 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/prodomus_detail.php > /dev/null 2>&1 	
   
45 	18 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/prodomus_detail.php > /dev/null 2>&1 	
   
00 	07 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/taurus_url.php > /dev/null 2>&1 	
   
00 	19 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/taurus_url.php > /dev/null 2>&1 	
   
15 	07 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/taurus_detail.php > /dev/null2>&1 	
   
15 	19 	* 	* 	* 	/usr/bin/php /home/majfztgo/public_html/taurus_detail.php > /dev/null2>&1 	
    