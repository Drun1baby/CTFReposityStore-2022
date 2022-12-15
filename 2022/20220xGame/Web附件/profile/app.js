const express = require("express");
const path = require("path");
const fs = require("fs");
const jwt = require("jsonwebtoken");
const cookieParser = require("cookie-parser");

const app = express();
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());

const port = 3000;
const flag = process.env.FLAG || "flag{fake_flag}";
const jwtKey = Math.random().toString();

class UserStore {
    constructor() {
        this.users = {};
        this.usernames = {};
    }

    insert(username, password) {
        const uid = Math.random().toString();
        this.users[uid] = {
            username,
            uid,
            password,
            profile: "个人简介",
            restricted: true,
        };
        this.usernames[username] = uid;
        return uid;
    }

    get(uid) {
        return this.users[uid] ?? {};
    }

    lookup(username) {
        return this.usernames[username];
    }

    remove(uid) {
        const user = this.get(uid);
        delete this.usernames[user.username];
        delete this.users[uid];
    }
}

const users = new UserStore();

app.use((req, res, next) => {
    try {
        res.locals.user = jwt.verify(req.cookies.token, jwtKey, {
            algorithms: ["HS256"],
        });
    } catch (err) {
        if (req.cookies.token) {
            res.clearCookie("token");
        }
    }
    next();
});

app.get("/", (req, res) => {
    res.send(`<html>
<body>欢迎使用</body>
<!--/source-->
</html>`);
});

app.post("/register", (req, res) => {
    if (
        !req.body.username ||
        !req.body.password ||
        req.body.username.length > 32 ||
        req.body.password.length > 32
    ) {
        res.send("非法用户名/密码");
        return;
    }
    if (users.lookup(req.body.username)) {
        res.send("该用户名已被占用");
        return;
    }
    const uid = users.insert(req.body.username, req.body.password);
    res.cookie("token", jwt.sign({ uid }, jwtKey, { algorithm: "HS256" }));
    res.send("注册成功");
});

app.post("/login", (req, res) => {
    const user = users.get(users.lookup(req.body.username));
    if (user && user.password === req.body.password) {
        res.cookie("token", jwt.sign({ uid: user.uid }, jwtKey, { algorithm: "HS256" }));
    } else {
        res.send("用户名/密码错误");
    }
});

app.post("/delete", (req, res) => {
    if (res.locals.user) {
        users.remove(res.locals.user.uid);
    }
    res.clearCookie("token");
    res.send("已成功删除该用户");
});

app.get("/profile", (req, res) => {
    if (!res.locals.user) {
        res.status(401).send("请先登录");
        return;
    }
    const user = users.get(res.locals.user.uid);
    res.send(user.restricted ? user.profile : flag);
});

app.post("/profile", (req, res) => {
    if (!res.locals.user) {
        res.status(401).send("请先登录");
        return;
    }
    if (!req.body.profile || req.body.profile.length > 2000) {
        res.send("简介必须为1-2000个字内");
        return;
    }
    users.get(res.locals.user.uid).profile = req.body.profile;
    res.send("简介修改成功");
});

app.get("/source", (req, res) => {
   res.sendFile("/app/app.js");
});

app.listen(port, () => {
    console.log(`服务已启动`);
});