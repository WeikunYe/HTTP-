const Koa = require("koa");
const Router = require("@koa/router");
const bodyParser = require("koa-bodyparser");

const app = new Koa();

app.use(bodyParser());

const router = new Router();

router.get("/", (ctx) => {
	ctx.state = 200;
	ctx.body = JSON.stringify({ message: "Hello" });
});

router.post("/api/http-post", (ctx) => {
	console.log(ctx.request.body);

	ctx.state = 200;
	ctx.body = JSON.stringify({ message: "I GOT YOUR REQUEST" });
});

app.use(router.routes()).use(router.allowedMethods());

app.listen(5000);
