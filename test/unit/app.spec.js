'use strict';

var Promise = require('bluebird');
var supertestFactory = require('supertest-as-promised');
var appFactory = require('../../app/app');
Promise.longStackTraces();

describe('app', function ()
{
    var app;
    var port = process.env.PORT || 8000;
    before(function ()
    {
        return appFactory(port).then(function (result)
        {
            app = result;
        });
    });
    after(function ()
    {
        return app && app.close();
    });
    it('should ...', function ()
    {
        return supertestFactory('http://localhost:' + port).get('/').expect(200);
    });
});
