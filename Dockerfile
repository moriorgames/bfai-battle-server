# Build command:
# docker build -t moriorgames/socket-server .
# Run command:
# docker run -td --name socket_server -p 5100:5100 moriorgames/socket-server
FROM        ubuntu:17.10
MAINTAINER  MoriorGames "moriorgames@gmail.com"

# Install packages
RUN         apt-get update -y
RUN         apt-get upgrade -y
RUN         apt-get install -y software-properties-common
RUN         apt-get install -y language-pack-en-base
RUN         LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php

# Once the PPA is installed, update the local package cache to include its contents:
RUN         apt-get update
RUN         apt-get install -y php7.1 php7.1-mysql zip php7.1-xml
RUN         apt-get install -y vim

# Create Application directory
RUN         mkdir -p /app && rm -fr /var/www/html && ln -s /app /var/www/html
COPY        . /app
WORKDIR     /app

# Composer variables
ENV         COMPOSER_HOME /app

# Build project
RUN     php /app/phars/composer.phar install --optimize-autoloader
RUN     chown www-data:www-data /app -R

# Expose ports
EXPOSE  5100

CMD ["php", "socket"]
