var express = require('express'); 
var child_process = require('child_process');
const ip = require("ip");
const puppeteer = require("puppeteer");
var app = express(); 
var PORT = process.env.PORT| 13002; 
var HOST = process.env.HOST| "127.0.0.1"
const ipsList = new Map();
const now = ()=>Math.floor(Date.now() / 1000);
app.set('view engine', 'ejs'); 
app.use(express.static('public'))

app.get("/",function(req,res,next){
    var {color,name}= req.query
    res.render("index",{color:color,name:name})
})


app.get("/status",function(req,res,next){
    var  cmd= req.query.cmd? req.query.cmd:"ps"
	var rip = req.header('X-Real-IP')?req.header('X-Real-IP'):req.ip
	console.log(rip)
    if (cmd.length > 4 || !ip.isPrivate(rip)) return res.send("hacker!!!")
    const result = child_process.spawnSync(cmd,{shell:true});
	out = result.stdout.toString();
	res.send(out)
})

app.get('/report', async function(req, res){
	const url = req.query.url;
	var rip = req.header('X-Real-IP')?req.header('X-Real-IP'):req.ip
	if(ipsList.has(rip) && ipsList.get(rip)+30 > now()){
		return res.send(`Please comeback ${ipsList.get(rip)+30-now()}s later!`);
	}
	ipsList.set(rip,now());
	const browser = await puppeteer.launch({headless: true,executablePath: '/usr/bin/google-chrome',args: ['--no-sandbox', '--disable-gpu','--ignore-certificate-errors','--ignore-certificate-errors-spki-list']});
	const page = await browser.newPage();
	try{
		await page.goto(url,{
	  		timeout: 10000
		});
		await new Promise(resolve => setTimeout(resolve, 10e3));
	} catch(e){}
	await page.close();
	await browser.close();
	res.send("OK");
});

app.get("/ping",function(req,res,next){
    res.send("pong")
})


app.listen(PORT,HOST, function(err){ 
    if (err) console.log(err); 
    console.log(`Server listening on ${HOST}:${PORT}`); 
});