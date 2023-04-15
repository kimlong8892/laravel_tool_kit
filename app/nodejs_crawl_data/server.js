const express = require("express");
const app = express();
const server = require("http").Server(app);
server.listen(3000);



const CrawlController = require('./controller/CrawlController');
app.get('/tiki/list-product', CrawlController.getListProductTiki);
app.get('/lazada/list-product', CrawlController.getListProductLazada);