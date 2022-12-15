const express = require('express');
const app = express();
const bodyParser = require("body-parser")
const fs = require("fs")
app.use(bodyParser.text({type: '*/*'}));
const {  execFileSync } = require('child_process');

app.post('/readfile', function (req, res) {
    let body = req.body.toString();
    let file_to_read = "app.js";
    const file = execFileSync('/app/rust-waf', [body], {
        encoding: 'utf-8'
    }).trim();
    try {
        file_to_read = JSON.parse(file)
    } catch (e){
        file_to_read = file
    }
    let data = fs.readFileSync(file_to_read);
    res.send(data.toString());
});

app.get('/', function (req, res) {
    res.send('see `/src`');
});



app.get('/src', function (req, res) {
    var data = fs.readFileSync('app.js');
    res.send(data.toString());
});

app.listen(3000, function () {
    console.log('start listening on port 3000');
});