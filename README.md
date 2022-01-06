# HTTP 协议详解 PHP 环境配置

_课程地址：https://www.bilibili.com/video/BV1js411g7Fw?p=4_

**我没有看老师之前关于 php 的教程，所以用的自己熟悉的 XAMPP 来配置环境**

## 下载 XAMPP

根据个人操作系统选择下载文件：[下载连接](https://www.apachefriends.org/index.html)

## 安装 XAMPP

**如果只为这门课程配置环境，可以仅选择 Server->Apache 和 Program Languages->PHP 即可**

如果想学习 PHP，可以全选。

![第一步](./install-01.png)

**为了避免某些奇葩的权限问题，建议不要装在系统盘下面。我的系统盘是 C 盘，所以我装在 D 盘下面了**

![第二步](./install-02.png)

**然后就一直 next 下去，直到安装结束**

## 开启 XAMPP

一般安装完成后会自动打开 XAMPP Control Panel。如果没有的话可以在系统里面搜一下 XAMPP Control Panel

![搜索XAMPP](./run-01.png)

打开后进入如下界面，如果 Apache 左侧出现红叉，点击一下安装 Apache Service 即可。

![XAMPP控制面板](./run-02.png)

然后点击 Start 开启 Apache 服务。此时可以看到 Apache 变成绿色，证明 Apache 服务正常运行

![开启Apache](./run-03.png)

此时，我们可以打开浏览器访问：http://localhost/dashboard/

![首页](./run-04.png)

这个页面的文件来源于 D:\xampp\htdocs\dashboard

## 写代码

我们所有的项目文件均在 D:\xampp\htdocs\ 下。

我习惯每个项目新建一个目录，比如说新建一个名为 learn-http 的目录

![写代码](./coding-01.png)

此时可以用我们的 IDE 打开该目录（我用的是 VS Code）

在该目录下创建新目录 lesson1，并在 lesson1 下创建新 php 文件 01.php

**具体目录结构没有特定要求，大家可以根据自己喜好来安排**

![01.php](./coding-02.png)

在 01.php 中写入如下代码

```php
<?php
    echo "hello";
?>
```

此时我们在浏览器中访问 http://localhost/learn-http/lesson1/01.php

一般运行哪个文件，就是 http://localhost/ 加上 xampp/htdocs 下的路径

可以看到 echo 的 hello 字符串

![run 01.php](./coding-03.png)

## 关闭服务

学习结束后，返回 XAMPP Control Panel 点击 Stop 停止 Apache 服务

![stop apache](./run-03.png)
