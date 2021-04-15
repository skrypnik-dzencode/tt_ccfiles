FROM nginx

ADD dockerfiles/conf/nginx.conf /etc/nginx/conf.d/default.conf

#WORKDIR /var/www/example