const CrawlTikiController = require('express');

async function autoScroll(page) {
    await page.evaluate(async () => {
        await new Promise((resolve) => {
            let totalHeight = 0;
            const distance = 100;
            const timer = setInterval(() => {
                const scrollHeight = document.body.scrollHeight;
                window.scrollBy(0, distance);
                totalHeight += distance;

                if (totalHeight >= scrollHeight - window.innerHeight) {
                    clearInterval(timer);
                    resolve();
                }
            }, 100);
        });
    });
}

CrawlTikiController.getListProductTiki = async function (req, res) {
    const puppeteer = require('puppeteer');
    const browser = await puppeteer.launch({
        headless: true, args: ['--no-sandbox']
    });
    const page = await browser.newPage();
    const search = req.query.search ?? '';

    await page.goto('https://tiki.vn/search?q=' + search, {waitUntil: 'networkidle2', timeout: 0});
    await autoScroll(page);

    await page.waitForSelector('.product-item .image-wrapper');
    const listProduct = await page.evaluate(() => {
        let productTags = document.querySelectorAll('.product-item');
        let productArray = [];
    
        productTags.forEach(item => {
            const name = item.querySelector('.info .name h3').textContent;
            let price = item.querySelector('.price-discount__price').innerHTML;
            price = price.replace('<sup> ₫</sup>', '');
            price = price.replace('.', '');
            price = parseInt(price);
            let image = item.querySelector('.image-wrapper').innerHTML;
            let myRegex = /<img[^>]+src="https:\/\/([^">]+)/g;
            image = myRegex.exec(image);

            if (image !== null) {
                image = Object.values(image);
                image = image[0] ?? '';
                image = image.replace('<img src=\"', '');
            }

            productArray.push({
                name: name,
                price: price,
                image: image
            });
        });
    
        return productArray;
    });


    res.send({
        listProduct: listProduct
    });
}

module.exports = CrawlTikiController;