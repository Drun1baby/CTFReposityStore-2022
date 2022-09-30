var passwordCheck = function (password) {
    var blacklist = ['>', '<', '=', '"', ";", '^', '|', '&', ' ', 'and', 'or', 'case', 'if', 'substr', 'like', 'glob', 'regexp', 'mid', 'trim', 'right', 'left', 'between', 'in', 'print', 'format', 'password', 'users', 'from', 'random' ];
    for (var i = 0; i < blacklist.length; i++) {
        if (password.indexOf(blacklist[i]) !== -1) {
            return false;
        }
    }
    return true;
}

module.exports = passwordCheck;