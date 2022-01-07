# Koa Server

这个课程非常老，其中老师用来发帖的网站都不存在了。

所以我写了一个非常简单 Koa 后端，用来接受 php 的请求。

## 安装

`cd` 到 `server` 目录下运行 `yarn install` 安装依赖

然后运行 `yarn dev` 启动

此时应该可以访问 http://localhost:5000 得到：

```json
{
	"message": "hello"
}
```

## API

1. 发帖 (POST)

    `/api/http-post` 主体信息随意，接受到主体信息会 `console.log` 出来，同时返回 `{ message: "I GOT YOUR REQUEST" }`。
