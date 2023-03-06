const express = require("express");
const app = express();
const server = require("http").Server(app);
server.listen(4000);

const CrawlShopeeController = require('./controller/CrawlShopeeController');

if (CrawlShopeeController.hasOwnProperty('getListCoupon')) {
    app.get('/crawl-shopee', CrawlShopeeController.getListCoupon);
}
