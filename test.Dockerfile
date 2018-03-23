#
# http://php.net/eol.php
#

#
# TEST PHP PROJECT BY Docker
#

#
# 7.2.0+
#

ARG PHP_VERSION_7_2_X=7.2.0

#
# 7.1.0+
#

ARG PHP_VERSION_7_1_X=7.1.0

#
# 7.0.0+
#

ARG PHP_VERSION_7_0_X=7.0.0

#
# 5.6.0+
#

ARG PHP_VERSION_5_6_X=5.6.0

#
# TEST PHP VERSION 7.2.x
#

FROM khs1994/php-fpm:${PHP_VERSION_7_2_X}-alpine3.7

RUN git clone --recursive --depth=1 https://github.com/khs1994-php/EXAMPLE.git /root/khs1994-php/EXAMPLE \
    && cd /root/khs1994-php/EXAMPLE \
    && composer install -q \
    && composer update -q \
    && vendor/bin/phpunit

#
# TEST PHP VERSION 7.1.x
#

FROM khs1994/php-fpm:${PHP_VERSION_7_1_X}-alpine3.4

COPY --from=0 /root/khs1994-php/EXAMPLE /root/khs1994-php/EXAMPLE

RUN cd /root/khs1994-php/EXAMPLE \
    && rm -rf vendor composer.lock \
    && composer install -q \
    && composer update -q \
    && vendor/bin/phpunit

#
# TEST PHP VERSION 7.0.x
#

# FROM khs1994/php-fpm:${PHP_VERSION_7_0_X}-alpine3.4
#
# COPY --from=0 /root/khs1994-php/EXAMPLE /root/khs1994-php/EXAMPLE
#
# RUN cd /root/khs1994-php/EXAMPLE \
#       && rm -rf vendor composer.lock \
#       && composer install -q \
#       && composer update -q \
#       && vendor/bin/phpunit

#
# TEST PHP VERSION 5.6.x
#

# FROM khs1994/php-fpm:${PHP_VERSION_5_6_X}-alpine3.4
#
# COPY --from=0 /root/khs1994-php/EXAMPLE /root/khs1994-php/EXAMPLE
#
# RUN cd /root/khs1994-php/EXAMPLE \
#       && rm -rf vendor composer.lock \
#       && composer install -q \
#       && composer update -q \
#       && vendor/bin/phpunit
