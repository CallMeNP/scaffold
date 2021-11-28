整合一些比较熟悉的工具，作为日常工具开发的脚手架。技术栈不限于php，还包含前端和shell。旨在用胶水代码快速实现功能。

## 文件说明
* 入口文件
    * web/index.php
    * bin/console
* 控制器
    * src-php/App/Command
    * src-php/App/Controller
* src-php/bootstrap.php 启动文件
* src-php/App/Core 基础设施
* src-php/App/Service 业务逻辑
* 自动加载（参见ObjBox）
    * Core 加载 src-php/App/Core 下的对象
    * Service 加载 src-php/App/Service 下的对象

## 主要依赖包
* slim
* twig
* fluentPdo
* Monolog
* Noodlehaus
* symphony/console
