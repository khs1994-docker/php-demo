#
# 此 Dockerfile 使用了多阶段构建，同时构建了 PHP 及 NGINX 两个镜像
#
# @link https://docs.docker.com/develop/develop-images/multistage-build/
#

#
# 约定，只有 git 打了 tag 才能将对应的镜像部署到生产环境
#

ARG PHP_VERSION=7.2.3-alpine3.7

ARG  NGINX_VERSION=1.13.9

#
# 安装 composer 依赖
#

FROM khs1994/php-fpm:${PHP_VERSION} as composer

COPY . /app/EXAMPLE/

RUN cd /app/EXAMPLE \
      #
      # 安装 composer 依赖
      #
      && if [ -f composer.json ];then \
           echo "Composer packages installing..."; \
           composer install --no-dev; \
           echo "Composer packages install success"; \
         else \
           echo "composer.json NOT exists"; \
         fi

#
# 将 PHP 项目打入 PHP 镜像
#

FROM khs1994/php-fpm:${PHP_VERSION} as php

COPY --from=composer /app /app

CMD ["php-fpm", "-R", "-d", "variables_order='EGPCS'"]

#
# $ docker build -t khs1994/php-fpm:swarm-7.2.3-alpine3.7-GIT_TAG --target=php .
#
# @link https://docs.docker.com/develop/develop-images/multistage-build/#stop-at-a-specific-build-stage
#

#
# 将 PHP 项目打入 NGINX 镜像
#

#
# Debian 镜像缺少网络相关工具，这里为了方便测试 LinuxKit 继续使用 Alpine 镜像
#

#
# Nginx 配置文件统一通过 configs 管理，严禁将配置文件打入镜像
#

# FROM khs1994/nginx:1.13.9-tls1.3-stretch

FROM nginx:${NGINX_VERSION}-alpine as nginx

COPY --from=php /app /app

ADD https://raw.githubusercontent.com/khs1994-docker/lnmp-nginx-conf-demo/master/wait-for-php.sh /wait-for-php.sh

RUN rm -rf /etc/nginx/conf.d \
    && chmod +x /wait-for-php.sh

CMD ["/wait-for-php.sh"]

#
# $ docker build -t khs1994/nginx:swarm-1.13.9-alpine-GIT_TAG .
#
# @link
#
