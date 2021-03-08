FROM php:apache
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN docker-php-ext-enable mysqli
RUN a2enmod rewrite.load
RUN service apache2 restart
RUN apt-get update
RUN apt-get upgrade

RUN sudo php composer.phar require symfony/apache-pack
#RUN sudo apt-get install php7.4-intl

#Este comando sirve para crear una base de datos de symfony desde el terminal
#php bin/console doctrine:database:create --if-not-exists

#COPY php.ini /usr/local/etc/php/php.ini-development

#COPY virtual-host.conf /etc/apache2/sites-avalible/000-default.conf

COPY my.cnf /etc/mysql/my.cnf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer