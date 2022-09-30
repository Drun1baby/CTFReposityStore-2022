var dependenciesCheck = function (dependencies) {
    var blacklist = ['__proto__', 'prototype', 'constructor'];
    for ( let denpendency in dependencies) {
        for (var i = 0; i < blacklist.length; i++) {
            if (denpendency.indexOf(blacklist[i]) !== -1 || dependencies[denpendency].indexOf(blacklist[i]) !== -1) {
                return false;
            }
        }
    }
    return true;
}

module.exports = dependenciesCheck;