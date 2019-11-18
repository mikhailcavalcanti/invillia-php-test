FROM httpd:2.4.41-alpine
RUN apk update; \
    apk upgrade;
# Copy apache vhost file to proxy php requests to php-fpm container
COPY web.conf /usr/local/apache2/conf/web.conf
RUN echo "Include /usr/local/apache2/conf/web.conf" \
    >> /usr/local/apache2/conf/httpd.conf

# Enable mod-rewrite
RUN sed -i '/LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf
