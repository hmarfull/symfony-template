FROM phpdockerio/php:8.3-fpm
WORKDIR "/application"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php8.3-amqp \ 
        php8.3-intl \ 
        php8.3-mysql \ 
        php8.3-redis \ 
        php8.3-xdebug \ 
        php8.3-xmlrpc \ 
        php8.3-xsl \ 
        php8.3-yaml \
        php8.3-pdo \
        php8.3-pdo-mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
