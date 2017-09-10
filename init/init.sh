mysql -uroot -p -e "drop database if exists event_registration"
mysqladmin -uroot -p create event_registration
mysql -uroot -p event_registration < init/dump.sql
