const crypto = require('crypto');
const express = require('express');
const session = require("express-session");
const app = express();
const jwt = require("jsonwebtoken");
const fs = require("fs")
const bodyParser = require('body-parser')
session_secret = Math.random().toString(36).substr(2);
const cookieParser = require('cookie-parser');
app.use(cookieParser(session_secret));
app.use(bodyParser.json())
app.use(session({ secret: session_secret, resave: true, saveUninitialized: true }))
// const secret = crypto.randomBytes(18).toString('hex');
const secret = '';

app.post('/register', function (req, res) {
    const username = req.body.name;
    if ( username == 'admin'){
        res.send("admin not allowed");
        return
    }
    const token = jwt.sign({username}, secret, {algorithm: 'HS256'});
    res.send({token: token});
});

app.post('/login', function (req, res) {
    const token = req.body.auth
    try {
        jwt.verify(token, secret, {algorithm: 'HS256'},function (_,user){
            console.log(user)
            req.session.user = {"username":user.username}
        });
    }catch (e) {
        res.send("login error")
        return
    }
    res.send(req.session.user.username + " login successfully")
});



function copyArray(arr1){
    var arr2 = new Array(arr1.length);
    for (var i=0;i<arr1.length;i++){
        if(arr1[i] instanceof Object){
            arr2[i] = copyArray(arr1[i])
        }else{
            arr2[i] = arr1[i]
        }
    }
    return arr2
}

app.get('/', function (req, res) {
    res.send('see `/src`');
});

app.post('/properties',function(req,res){
    if(req.session.user.username !== "admin"){
        res.send('only admin can set properties')
        return
    }
    const properties = req.body.properties
    for(let i=0; i<properties.length; i++){
        if(properties[i] == 'flag'){
            res.send('flag properties not allowed')
            return
        }
    }
    req.session.user.properties = copyArray(properties)
    res.send('Success')
})

app.get('/getflag',function(req,res){
    if(req.session.user.properties ){
        for(var i=0;i<req.session.user.properties.length;i++)
            if(req.session.user.properties[i] == 'flag'){
                var data = fs.readFileSync('/flag')
                res.send(data.toString())
                return
            }
    }else{
        res.send("not flag properties")
        return
    }
    res.send("get flag")
})

app.get('/src', function (req, res) {
    var data = fs.readFileSync('app.js');
    res.send(data.toString());
});

app.listen(80, function () {
    console.log('start listening on port 80');
});
