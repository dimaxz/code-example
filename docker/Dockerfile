#FROM php:7.2-fpm
FROM debian:stretch-slim as extension_builder

RUN apt-get update && \
    apt-get -y install apt-transport-https curl gnupg2 lsb-release ca-certificates sudo && \
    curl https://packages.sury.org/php/apt.gpg | apt-key add - && \
    sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' && \
    sh -c 'echo "deb http://deb.debian.org/debian $(lsb_release -sc)-backports main contrib non-free" > /etc/apt/sources.list.d/backports.list' && \
    apt-get update

RUN apt-get install unzip && \
    apt-get install -y openssh-client \
            nginx \
            nano \
            htop \
            git \
            curl \
    && apt-get install -y php-pear \
        php7.2-common \
        php7.2-cli \
        php7.2-fpm \
        php7.2-xml \
        php7.2-zip \
        php7.2-gd \
        php7.2-mbstring \
        php7.2-curl \
        php7.2-bcmath \
        php7.2-json \
        php7.2-imap \
        php7.2-mysql \
        php7.2-tokenizer \
        php7.2-dev && \
        pecl channel-update pecl.php.net && \
        pecl install xdebug-3.1.3

RUN ln -s /usr/sbin/php-fpm7.2 /usr/sbin/php-fpm && \
    sh -c 'mkdir /run/php /run/sshd'

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.1.3

ARG APP_USER_ID=1000
ARG APP_USERGROUP_ID=1000

RUN if [ $(grep ${APP_USERGROUP_ID} /etc/group) ]; then \
        OLD_NAME=$(grep ${APP_USERGROUP_ID} /etc/group | cut -d ':' -f1); \
        groupmod -n apps $(grep ${APP_USERGROUP_ID} /etc/group | cut -d ':' -f1); \
        echo "group $OLD_NAME renamed"; \
    else \
        groupadd -g ${APP_USERGROUP_ID} apps; \
    fi

RUN useradd -m -g ${APP_USERGROUP_ID} -s /bin/bash -u ${APP_USER_ID} apps && \
    usermod -aG apps www-data && \
    usermod -aG www-data apps && \
    echo "apps:123" | chpasswd

RUN echo "AllowUsers apps" >> /etc/ssh/sshd_config \
    && echo "export VISIBLE=now" >> /etc/profile \
    && /usr/bin/ssh-keygen -A \
    && mkdir /home/apps/.ssh \
    && chown -R apps: /home/apps/.ssh \
    && mkdir /home/apps/site \
    && chown -R apps: /home/apps/site

EXPOSE 80 443

WORKDIR /home/apps/site

RUN sed -i -e "s/listen\s*=\s*\/run\/php\/php7.2-fpm.sock/listen = 127.0.0.1:9000/g" /etc/php/7.2/fpm/pool.d/www.conf

ENTRYPOINT /usr/sbin/php-fpm -D && /usr/sbin/nginx -g 'daemon off;'