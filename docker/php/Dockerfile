FROM php:8.2.14-cli

RUN apt-get update \
    &&  apt-get install -y --no-install-recommends \
        locales apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev unzip libpq-dev nodejs npm wget \
        apt-transport-https lsb-release ca-certificates libldap2-dev

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen  \
    &&  echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen \
    &&  locale-gen

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt install -y nodejs \
    && mkdir ~/.npm-global \
    && npm config set prefix '~/.npm-global' \
    && export PATH=~/.npm-global/bin:$PATH \
    && curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | tee /usr/share/keyrings/yarnkey.gpg >/dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/yarnkey.gpg] https://dl.yarnpkg.com/debian stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt update \
    && apt install -y yarn

RUN curl -sS https://getcomposer.org/installer | php -- \
    &&  mv composer.phar /usr/local/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony5/bin/symfony /usr/local/bin

RUN mkdir /opt/oracle
# Install Oracle Instantclient
RUN wget https://download.oracle.com/otn_software/linux/instantclient/216000/instantclient-basic-linux.x64-21.6.0.0.0dbru.zip \
&& wget https://download.oracle.com/otn_software/linux/instantclient/216000/instantclient-sdk-linux.x64-21.6.0.0.0dbru.zip \
&& wget https://download.oracle.com/otn_software/linux/instantclient/216000/instantclient-sqlplus-linux.x64-21.6.0.0.0dbru.zip \
&& unzip instantclient-basic-linux.x64-21.6.0.0.0dbru.zip -d /opt/oracle \
&& unzip instantclient-sdk-linux.x64-21.6.0.0.0dbru.zip -d /opt/oracle \
&& unzip instantclient-sqlplus-linux.x64-21.6.0.0.0dbru.zip -d /opt/oracle \
&& rm -rf *.zip \
&& mv /opt/oracle/instantclient_21_6 /opt/oracle/instantclient

#add oracle instantclient path to environment
ENV ORACLE_HOME instantclient,/opt/oracle/instantclient/
ENV LD_LIBRARY_PATH /opt/oracle/instantclient/
RUN ldconfig

RUN docker-php-ext-configure \
            intl
RUN docker-php-ext-configure \
            pdo_oci --with-pdo-oci=instantclient,/opt/oracle/instantclient,21.1

RUN echo 'instantclient,/opt/oracle/instantclient/' | pecl install oci8-3.3.0
RUN apt-get install libaio1 libaio-dev
RUN ldd /usr/local/lib/php/extensions/no-debug-non-zts-20220829/oci8.so

RUN docker-php-ext-install \
            pdo pdo_mysql pdo_pgsql pdo_oci opcache intl zip calendar dom mbstring gd xsl ldap

RUN docker-php-ext-enable \
            oci8

RUN pecl install apcu && docker-php-ext-enable apcu

RUN git config --global user.email "you@example.com" \
    &&  git config --global user.name "Your Name"

RUN echo memory_limit = -1 >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

CMD tail -f /dev/null

WORKDIR /web/app