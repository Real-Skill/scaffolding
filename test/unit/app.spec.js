'use strict';

var Promise = require('bluebird');
var chai = require('chai');
var expect = chai.expect;
var MongoClient = require('mongodb').MongoClient;
var sinon = require('sinon');
chai.use(require('sinon-chai'));
var app = require('../../app/app');
Promise.longStackTraces();


describe('app', function ()
{
    it('should...', function ()
    {
        return new Promise(function (resolve, reject)
        {
            var mongohost = process.env.MONGO_HOST || 'localhost';
            var url = 'mongodb://' + mongohost + '/test';
            MongoClient.connect(url, function (err, db)
            {
                if (err) {
                    reject(err);
                    return;
                }
                db.collection('car').find().toArray(function (err, result)
                {
                    if (err) {
                        reject(err);
                    } else {
                        resolve(result);
                    }
                    db.close();
                });
            });
        })
                .then(function (result)
                {
                    expect(result).to.eql([]);
                });
    });
});
