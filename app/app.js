'use strict';

var Promise = require('bluebird');
var express = require('express');
var uuid = require('node-uuid');

module.exports = function (port)
{
    var app = express();

    app.get('/', function (req, res)
    {
        res.send(uuid.v4());
    });

    return new Promise(function (resolve)
    {
        var server = app.listen(port, function ()
        {
            resolve(server);
        });
    });
};
