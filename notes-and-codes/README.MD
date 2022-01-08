# HTTP 协议详解

_视频地址：https://www.bilibili.com/video/BV1js411g7Fw?p=1_

## P1 HTTP 协议概念及工作流程

### HTTP 信息格式

-   请求/响应 **行** (start-line)
-   请求/响应 **头信息** (HTTP headers)
-   **空行** (Empty line)
-   请求/响应 **主体信息** (body)

_请求和响应的基本格式相同_

![http-req-res](./images/p1-http-req-res.png)

#### 补充：

![http-steps](./images/p1-http-steps.png)

### HTTP 请求格式

-   请求行：`<METHOD> <PATH> <Protocal>/<Version>`
-   请求头：`<key>: <value>`
-   空行
-   请求主体 `<key1>=<value1>&<key2>=<value2>`

举例

1. GET 请求

```bash
    GET /articles/01 HTTP/1.1 #请求行
    Host: mydomain.com        #请求头
    Connection: keep-alive    #请求头
                              #空行
```

2. POST 请求

```bash
    GET /auth/login HTTP/1.1                         #请求行
    Host: mydomain.com                               #请求头
    Content-type: application/x-www-form-urlencoded  #请求头
    Content-length: 28                               #请求头
                                                     #空行
    username=weikun&password=123                     #请求主题

```

## P2 HTTP 协议之方法与状态码

常见方法：GET POST PUT DELETE HEAD OPTIONS TRACE

常见状态码：

-   200：成功
-   301、302：永久、临时重定向
-   304：NOT MODIFIED 未修改（取的缓存，服务器返回 304，浏览器从缓存拿文件）
-   307：重新定向中保存原有请求数据
-   404：不存在

## P6 Referer 头与防盗链

### XAMPP Apache config

XAMPP Apache 的 config 文件在这里：

![apache-config](./images/p5-apache-config.png)

然后选择第一个 `Apache (httpd.conf)`

此外，还需要修改第三个 `Apache (httpd-xampp.conf)`

将 `Allowoverride AuthConfig` 改成 `Allowoverride All`

两个文件改完后，记得重启 Apache 服务

### HTML 文件

随便在项目目录(我的是：D:/xampp/htdocs/learn-http)下新建一个 HTML 文件，下载一个图片在 HTML 中引用。例如：

```html
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>P6 Referer头与防盗链</title>
	</head>
	<body>
		<p>
			<img src="./assets/apple.jpg" alt="" />
		</p>
	</body>
</html>
```

然后在项目根目录下新建文件 `.htaccess`，添加如下内容

```
RewriteEngine On
RewriteCond %{HTTP_REFERER} !http://localhost/.* [NC]
RewriteRule \.(jpg|png)$ https://picsum.photos/200/300
```

-   `RewriteEngine On`：开启重写
-   `RewriteCond`: 重写条件
-   `%{HTTP_REFERER}`：referer 头
-   `!`：逻辑否
-   `http://localhost/.*`: 正则表达，匹配以 `http://localhost/` 开头的任何字符串
-   `[NC]`: 大小写不敏感
-   `RewriteRule`：重写规则
-   `\.(jpg|png)$`：任何以 `jpg` 或者 `png` 结尾的请求

如果任何以 `jpg` `png` 结尾的请求中 referer 头不包含 `http://localhost/` 则重写为 `https://picsum.photos/200/300`。

当然这么写完打开 HTML 页面是没有变化的，因为我们的 referer 头包括 `http://localhost`。

可以将 `!` 感叹号去掉，此时任何 referer 头包括 `http://localhost` 都会被重写。

(如果没有重写，看看是不是 cache 住了)

## P7 HTTP 缓存详解

-   本地没有缓存，直接请求资源
-   响应头包括 `Etag` 资源标识符 `Last-Modified` 最后修改时间
-   本地有缓存 请求头 `If-Modified-Since` 和 `If-Modified-Match`。
-   服务器比对请求头资源的 `Etag` 和 modified 时间，如果匹配，则证明该资源在上次请求后没有变化，则返回 304。
-   此时，浏览器就知道应该使用缓存的资源

**具体 Apache .htaccess 省略**

## P8 HTTP 内容压缩

打开一个网页，`Content-length` 如果小于保存下来的源码，说明服务器用了压缩协议

可查看响应头的 `Content-Encoding`

**服务器配置时，需要指定压缩的文件类型，因为有时候压缩 视频、图片等文件的效果并不好，且耗费 CPU**

```
Content-Encoding: gzip
Content-Encoding: compress
Content-Encoding: deflate
Content-Encoding: br

// Multiple, in the order in which they were applied
Content-Encoding: deflate, gzip
```

请求头是 `Accept-Encoding` 告诉服务器：客户端可以接受哪些压缩方式

```
Accept-Encoding: gzip
Accept-Encoding: compress
Accept-Encoding: deflate
Accept-Encoding: br
Accept-Encoding: identity
Accept-Encoding: *

// Multiple algorithms, weighted with the quality value syntax:
//优先级，无后缀默认为1
Accept-Encoding: deflate, gzip;q=1.0, *;q=0.5
```

做采集（爬虫？）时，可以采集 gzip 提高速度，然后再解压。

## P9 Comet 反向 Ajax

`Transfer-Encoding: chunked`

数据以一系列分块的形式进行发送。 Content-Length 首部在这种情况下不被发送。。在每一个分块的开头需要添加当前分块的长度，以十六进制的形式表示，后面紧跟着 '\r\n' ，之后是分块本身，后面也是'\r\n' 。终止块是一个常规的分块，不同之处在于其长度为 0。终止块后面是一个挂载（trailer），由一系列（或者为空）的实体消息首部构成。
