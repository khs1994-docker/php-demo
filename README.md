# Create PHP Application by Composer

[![GitHub stars](https://img.shields.io/github/stars/khs1994-php/example.svg?style=social&label=Stars)](https://github.com/khs1994-php/example) [![PHP from Packagist](https://img.shields.io/packagist/php-v/khs1994/example.svg)](https://packagist.org/packages/khs1994/example) [![GitHub (pre-)release](https://img.shields.io/github/release/khs1994-php/example/all.svg)](https://github.com/khs1994-php/example/releases) [![Build Status](https://travis-ci.org/khs1994-php/example.svg?branch=master)](https://travis-ci.org/khs1994-php/example) [![StyleCI](https://styleci.io/repos/115306597/shield?branch=master)](https://styleci.io/repos/115306597)

```bash
$ composer create-project --prefer-dist khs1994/example example @dev

$ cd example

# init

$ composer z-example
```

# Docker 化 PHP 项目最佳实践

完全使用 Docker 开发、部署 PHP 项目

* [问题反馈](https://github.com/khs1994-docker/lnmp/issues/187)

## 准备

建立一个自己的 PHP 项目模板（即 `composer` 包类型为 `project`),里面包含了常用的文件的模板。

示例：https://github.com/khs1994-php/example

将 Docker 化的常用命令所在文件夹加入 `PATH`

**务必执行此项操作** 具体请查看 [这里](https://github.com/khs1994-docker/lnmp/tree/master/bin)。

## 一、开发

### 环境

* LNMP [khs1994-docker/lnmp](https://github.com/khs1994-docker/lnmp)

* IDE `PHPStorm`

* git 分支 `dev`

### 1. 新建 PHP 项目

使用自己的模板项目初始化 `PHP` 项目并初始化 git 仓库。

```bash
$ cd lnmp/app

$ lnmp-composer create-project --prefer-dist khs1994/example example @dev

$ cd example

$ git init

$ git remote add origin git@github.com:username/repo.git

$ git checkout -b dev

$ echo -e "<?php\nphpinfo();" >> index.php
```

### 2. 新增 NGINX 配置

参考示例配置文件在 `config/nginx` 新建 `*.conf` NGINX 配置文件

### 3. 启动 khs1994-docker/lnmp

```bash
$ ./lnmp-docker.sh development
```

### 4. 浏览器验证

浏览器打开页面，出现 php 信息

### 5. PHPStorm 打开已有项目

### 6. 设置 CLI

`PHPStorm 设置`-> `Languages & ...` -> `PHP` -> `CLI Interpreter` -> `点击后边三个点`
     -> `左上角添加` -> `From Docker ...` -> `Remote` -> `选择 Docker`
     -> `Image name` -> `选择 khs1994/php-fpm:7.2.3-alpine3.7`
     -> `点击 OK 确认`

### 7. 设置 Xdebug

请查看 https://github.com/khs1994-docker/lnmp/blob/master/docs/xdebug.md

### 8. 引入 Composer 依赖

容器化 PHPer 常用命令请查看 https://github.com/khs1994-docker/lnmp/blob/master/docs/command.md

```bash
$ lnmp-composer require phpunit/phpunit
```

### 9. 编写 PHP 代码

### 10. 编写 PHPUnit 测试代码

### 11. 使用 PHPUnit 测试

#### 使用 PHPStorm

`PHPStorm 设置`-> `Languages & ...` -> `PHP` ->`Test Frameworks` -> `左上角添加`
              -> `PHPUnit by Remote Interpreter` -> `选择第五步添加的 Docker 镜像`
              -> `点击 OK` -> `PHPUnit Library` -> `选择 Use Composer autoloader`
              -> `Path to script` -> `填写 /opt/project/vendor/autoload.php`
              -> `点击右边刷新` -> `点击 OK 确认`


在测试函数名单击右键 `run FunName` 开始测试。

#### 使用命令行

```bash
$ lnmp-phpunit
```

在笔记本需要与数据库交互的测试流程暂未发布。

### 12. 测试构建 PHP 及 NGINX 镜像

> 将 PHP 项目打入镜像，镜像中严禁包含配置文件

自行修改 `.env` `docker-compose.yml` 文件，保留所需的 PHP 版本，其他的注释

```bash
$ docker-compose build
```

### 13. 将项目提交到 Git

```bash
$ git add .

$ git commit -m "First"

$ git push origin dev:dev
```

## CI/CD 服务搭建

`khs1994.com` CI/CD 由 [khs1994-docker/ci](https://github.com/khs1994-docker/ci) 提供。

`Drone + Gogs` 暂不支持挂载本地 `Volume`

本例 CI/CD 由 `Travis` 提供。

## 二、测试（全自动）

### 1. Git 通知到 CI/CD 服务器

* Travis CI (公共的、仅支持 GitHub CI/CD)

* Drone (私有化 CI/CD)

### 2. CI/CD 服务器测试

## 三、开发、测试循环

## git 添加 tag

* 只有添加了 `tag` 的代码才能部署到生产环境

* Docker 镜像名必须包含 git `tag`

* CI/CD 服务器构建并推送镜像到 Docker 仓库。

## 四、部署 (全自动)

生产环境部署 [khs1994-docker/lnmp](https://github.com/khs1994-docker/lnmp) 请查看 https://github.com/khs1994-docker/lnmp/tree/master/docs/production

### 1. Docker 私有仓库通知到指定地址

### 2. Swarm mode 或 k8s 集群调用相应的 API 自动更新服务

#### Swarm mode

```bash
#
# 管理员通过 API 新增配置文件、密钥, 并更新
#
# @link https://docs.docker.com/engine/swarm/configs/
#
# @link https://docs.docker.com/engine/swarm/secrets/
#
# @link https://docs.docker.com/edge/engine/reference/commandline/service_update/
#

$ docker config create nginx_khs1994_com_conf_v2 config/nginx/khs1994.com.conf

# 从 git 源文件创建 configs

$ curl https://raw.githubusercontent.com/khs1994-docker/php-demo/d77eee54be1c023bc3e9dc1a025bde02471f1b5e/nginx/khs1994.com.conf | docker config create nginx_khs1994_com_conf_v2 -

#
# 更新配置的时候也可以同时更新镜像
#

$ docker service update \
    --config-rm nginx_khs1994_com_conf \
    --config-add source=nginx_khs1994_com_conf_v2,target=/etc/nginx/conf.d/khs1994.com.conf \
    --image khs1994/nginx:swarm-alpine-NEW_GIT_TAG lnmp_nginx \
    lnmp_nginx

$ docker secret create khs1994_com_ssl_crt_v2 config/nginx/ssl/khs1994.com.crt

# 从 git 源文件创建 secrets，省略

$ docker service update \
    --secret-rm khs1994_com_ssl_crt \
    --secret-add source=khs1994_com_ssl_crt_v2,target=/etc/nginx/conf.d/ssl/khs1994.com.crt \
    lnmp_nginx

#
# 更新镜像
#

$ docker service update --image khs1994/nginx:swarm-alpine-NEW_GIT_TAG lnmp_nginx

#
# 其他项也可以更新，请查看帮助信息
#

$ docker service update --help
```

#### k8s

### 3. 完成部署
