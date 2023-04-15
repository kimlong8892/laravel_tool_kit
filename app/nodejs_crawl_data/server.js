const express = require("express");
const app = express();
const server = require("http").Server(app);
server.listen(3000);

const CrawlTikiController = require('./controller/CrawlTikiController');
const CrawlLazadaController = require('./controller/CrawlLazadaController');

app.get('/tiki/list-product', CrawlTikiController.getListProductTiki);
app.get('/lazada/list-product', CrawlLazadaController.getListProductLazada);