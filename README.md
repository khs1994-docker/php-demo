# Docker 化 PHP 项目最佳实践

完全使用 Docker 开发、部署 PHP 项目

* [问题反馈](https://github.com/khs1994-docker/lnmp/issues/187)

## 开发

### 环境

* LNMP [khs1994-docker/lnmp](https://github.com/khs1994-docker/lnmp)

* IDE `PHPStorm`

### 1. 新建 PHP 项目

```bash
$ cd lnmp

$ mkdir -p app/demo

$ echo -e "<?php\nphpinfo();" >> app/demo/index.php
```

### 2. 新增 NGINX 配置

参考示例配置文件在 `config/nginx` 新建 `php.conf` NGINX 配置文件

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

### 12. NGINX 配置文件说明

> 测试环境用不到 NGINX？

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
$ git init

$ git add .

$ git commit -m "First"

$ git remote add origin GIT_URL

$ git push origin master
```

## CI/CD 服务搭建

`khs1994.com` CI/CD 由 [khs1994-docker/ci](https://github.com/khs1994-docker/ci) 提供。

## 测试（全自动）

### 1. Git 通知到 CI/CD 服务器

* Travis CI (公共的、仅支持 GitHub CI/CD)

* Drone (私有化 CI/CD)

### 2. CI/CD 服务器测试

## 开发、测试循环

## git 添加 tag

只有添加了 `tag` 的代码才能部署

Docker 镜像名包含 git `tag`

## 部署 (全自动)

生产环境部署 [khs1994-docker/lnmp](https://github.com/khs1994-docker/lnmp) 请查看 https://github.com/khs1994-docker/lnmp/tree/master/docs/production

### 1. CI/CD 服务器构建 Docker 镜像

### 2. CI/CD 服务器推送 Docker 镜像到私有 Docker 仓库

### 3. Docker 私有仓库通知到指定地址

### 4. Swarm mode 或 k8s 集群自动更新服务

调用响应的 API

#### Swarm mode

```bash
#
# 管理员通过 API 新增配置文件、密钥, 并更新
#

$ docker config create nginx_khs1994_com_conf_vN config/nginx/khs1994.com.conf

#
# 更新配置的时候也可以同时更新镜像
#

$ docker service update \
    --config-rm nginx_khs1994_com_conf \
    --config-add source=nginx_khs1994_com_conf_vN,target=/etc/nginx/conf.d/khs1994.com.conf \
    --image khs1994/nginx:swarm-alpine-NEW_GIT_TAG lnmp_nginx \
    lnmp_nginx

$ docker secret create khs1994_com_ssl_crt_vN config/nginx/ssl/khs1994.com.crt

$ docker service update \
    --secret-rm khs1994_com_ssl_crt \
    --secret-add source=khs1994_com_ssl_crt_vN,target=/etc/nginx/conf.d/ssl/khs1994.com.crt \
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

### 5. 完成部署
