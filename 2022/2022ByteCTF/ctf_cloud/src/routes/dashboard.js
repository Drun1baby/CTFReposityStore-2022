var express = require('express');
var router = express.Router();
var multer  = require('multer');
var path = require('path');
var fs = require('fs');
var cp = require('child_process');
var dependenciesCheck = require('../utils/dashboard');
var upload = multer({dest: '/tmp/'});

var appPath = path.join(__dirname, '../public/app');
var appBackupPath = path.join(__dirname, '../public/app_backup');

/* authentication middleware */
router.use(function(req, res, next) {
    if (!req.session.is_login)
      return res.json({"code" : -1 , "message" : "Please login first."});
   next();
});

/* upload api */
router.post('/upload', upload.any(),function(req, res, next) {
    if (!req.files) {
        return res.json({"code" : -1 , "message" : "Please upload a file."});
    }
    var file = req.files[0];

    // check file name
    if (file.originalname.indexOf('..') !== -1 || file.originalname.indexOf('/') !== -1) {
        return res.json({"code" : -1 , "message" : "File name is not valid."});
    }

    // do upload
    var filePath = path.join(appPath, '/public/uploads/', file.originalname);
    var fileContent = fs.readFileSync(file.path);
    fs.writeFile(filePath, fileContent, function(err) {
        if (err) {
            return res.json({"code" : -1 , "message" : "Error writing file."});
        } else {
            res.json({"code" : 0 , "message" : "Upload successful at " + filePath});
        }
    })
});

/* list upload dir */
router.get('/list', function(req, res, next) {
    var files = fs.readdirSync(path.join(appPath, '/public/uploads/'));
    res.json({"code" : 0 , "message" : files});
})

/* reset user app */
router.post('/reset', function(req, res, next) {
    // reset app folder
    cp.exec('rm -rf ' + appPath + '/*', function(err, stdout, stderr) {
       if (err) {
           console.log(err);
           return res.json({"code" : -1 , "message" : "Error resetting app."});
       } else {
           cp.exec('cp -r ' + appBackupPath + '/* ' + appPath + '/', function(err, stdout, stderr) {
               if (err) {
                   console.log(err);
                   return res.json({"code" : -1 , "message" : "Error resetting app."});
               } else {
                   return res.json({"code" : 0 , "message" : "Reset successful"});
               }
           });
       }
    });
})

/* dependencies get router */
router.get('/dependencies', function(req, res, next) {
   res.json({"code" : 0 , "message" : "Please post me your dependencies."});
});

/* set node.js dependencies */
router.post('/dependencies', function(req, res, next) {
    var dependencies = req.body.dependencies;

    // check dependencies
    if (typeof dependencies != 'object' || dependencies === {})
        return res.json({"code" : -1 , "message" : "Please input dependencies."});
    if (!dependenciesCheck(dependencies))
        return res.json({"code" : -1 , "message" : "Dependencies are not valid."});

    // write dependencies to package.json
    var filePath = path.join(appPath, '/package.json');
    var packageJson = {
        "name": "userapp",
        "version": "0.0.1",
        "dependencies": {
        }
    };
    packageJson.dependencies = dependencies;
    var fileContent = JSON.stringify(packageJson);
    fs.writeFile(filePath, fileContent, function(err) {
        if (err) {
            return res.json({"code" : -1 , "message" : "Error writing file."});
        } else {
            return res.json({"code" : 0 , "message" : "Set successful"});
        }
    });
});


/* run npm install */
router.post('/run', function(req, res, next) {
    if (!req.session.is_admin)
        return res.json({"code" : -1 , "message" : "Please login as admin."});
    cp.exec('cd ' + appPath + ' && npm i --registry=https://registry.npm.taobao.org', function(err, stdout, stderr) {
        if (err) {
            return res.json({"code" : -1 , "message" : "Error running npm install."});
        }
        return res.json({"code" : 0 , "message" : "Run npm install successful"});
    });
});

/* force kill npm install */
router.post('/kill', function(req, res, next) {
    if (!req.session.is_admin)
        return res.json({"code" : -1 , "message" : "Please login as admin."});
    // kill npm process
    cp.exec("ps -ef | grep npm | grep -v grep | awk '{print $2}' | xargs kll -9", function(err, stdout, stderr) {
        if (err) {
            return res.json({"code" : -1 , "message" : "Error killing npm install."});
        }
        return res.json({"code" : 0 , "message" : "Kill npm install successful"});
    });
}
);


module.exports = router;
