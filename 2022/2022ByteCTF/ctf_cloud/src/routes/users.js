var express = require('express');
var router = express.Router();
var sqlite3 = require('sqlite3').verbose();
var stringRandom = require('string-random');
var db = new sqlite3.Database('db/users.db');
var passwordCheck = require('../utils/user');

/* login */
router.post('/signin', function(req, res, next) {
    var username = req.body.username;
    var password = req.body.password;

    if (username == '' || password == '')
        return res.json({"code" : -1 , "message" : "Please input username and password."});

    if (!passwordCheck(password))
        return res.json({"code" : -1 , "message" : "Password is not valid."});

    db.get("SELECT * FROM users WHERE NAME = ? AND PASSWORD = ?", [username, password], function(err, row) {
        if (err) {
            console.log(err);
            return res.json({"code" : -1, "message" : "Error executing SQL query"});
        }
        if (!row) {
            return res.json({"code" : -1 , "msg" : "Username or password is incorrect"});
        }
        req.session.is_login = 1;
        if (row.NAME === "admin" && row.PASSWORD == password && row.ACTIVE == 1) {
            req.session.is_admin = 1;
        }
        return res.json({"code" : 0, "message" : "Login successful"});
    });

});

/* register */
router.post('/signup', function(req, res, next) {
    var username = req.body.username;
    var password = req.body.password;

    if (username == '' || password == '')
        return res.json({"code" : -1 , "message" : "Please input username and password."});

    // check if username exists
    db.get("SELECT * FROM users WHERE NAME = ?", [username], function(err, row) {
        if (err) {
            console.log(err);
            return res.json({"code" : -1, "message" : "Error executing SQL query"});
        }
        if (row) {
            console.log(row)
            return res.json({"code" : -1 , "message" : "Username already exists"});
        } else {
            // in case of sql injection , I'll reset admin's password to a new random string every time.
            var randomPassword = stringRandom(100);
            db.run(`UPDATE users SET PASSWORD = '${randomPassword}' WHERE NAME = 'admin'`, ()=>{});

            // insert new user
            var sql = `INSERT INTO users (NAME, PASSWORD, ACTIVE) VALUES (?, '${password}', 0)`;
            db.run(sql, [username], function(err) {
                if (err) {
                    console.log(err);
                    return res.json({"code" : -1, "message" : "Error executing SQL query " + sql});
                }
                return res.json({"code" : 0, "message" : "Sign up successful"});
            });
        }
    });
});

/* logout */
router.get('/logout', function(req, res) {
    req.session.is_login = 0;
    req.session.is_admin = 0;
    res.redirect('/');
});

module.exports = router;