# Build command:
# docker build -t moriorgames/socket-server .
# Run command:
# docker run -td --name bfai_socket -p 5100:5100 moriorgames/socket-server
FROM        moriorgames/php72-base
MAINTAINER  MoriorGames "moriorgames@gmail.com"

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
