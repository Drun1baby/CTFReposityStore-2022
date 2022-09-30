var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
    if (!req.session.is_login)
        return res.render('login');
    return res.render('dashboard' );
});

module.exports = router;
