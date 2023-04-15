const CrawlLazadaController = require('express');

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

CrawlLazadaController.getListProductLazada = async function (req, res) {
    const puppeteer = require('puppeteer');
    const browser = await puppeteer.launch({
        headless: true, args: ['--no-sandbox']
    });
    const page = await browser.newPage();
    const search = req.query.search ?? '';

    await page.goto('https://www.lazada.vn/catalog/?q=' + search, {waitUntil: 'networkidle2', timeout: 0});
    await autoScroll(page);
    await page.screenshot({ path: 'fullpage.png', fullPage: true });

    await page.waitForSelector('.Bm3ON');
    const listProduct = await page.evaluate(() => {
        let productTags = document.querySelectorAll('.Bm3ON');
        let productArray = [];
    
        productTags.forEach(item => {
            const name = item.querySelector('.RfADt a').textContent;
            let price = item.querySelector('.aBrP0 .ooOxS').textContent;
            price = price.replace('₫', '');
            price = price.trim();
            const image = item.querySelector('.picture-wrapper img').getAttribute('src');

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

module.exports = CrawlLazadaController;