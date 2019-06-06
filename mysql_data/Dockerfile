FROM mysql

ENV MYSQL_ROOT_PASSWORD='mysql.1'
ENV MYSQL_USER='paddle_center_admin'
ENV MYSQL_PASSWORD='mysql.1'

EXPOSE 3306
EXPOSE 33060

COPY backup.sql .

#RUN /etc/init.d/mysql start && tail -F /var/log/mysql.log
#CMD mysql --user=root --password=mysql.1 -s < backup.sql
