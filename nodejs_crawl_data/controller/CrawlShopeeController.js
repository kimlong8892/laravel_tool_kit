const CrawlShopeeController = require('express');

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


CrawlShopeeController.getListCoupon = async function (req, res) {
    const url = 'https://shopee.vn/m/ma-giam-gia#anchorId-1675880136350';
    const puppeteer = require('puppeteer');
    const browser = await puppeteer.launch({
        headless: true, args: ['--no-sandbox']
    });
    const page = await browser.newPage();
    await page.goto(url, {waitUntil: 'networkidle2', timeout: 0});
    await autoScroll(page);

    try {
        await page.waitForSelector('article.SmvA9S.etHrGu.mMX4Zv.EBe5rs');

        const listCoupon = await page.evaluate(() => {
            let listCouponDivTag = document.querySelectorAll('article.SmvA9S.etHrGu.mMX4Zv.EBe5rs');
            let listCouponData = [];

            // .O1TYNn
            listCouponDivTag.forEach(async function (item) {
                const title = item.querySelector('.AuutUU').innerText ?? '';
                const description = item.querySelector('.roewY8, .O1TYNn').innerText ?? '';
                const titleImage = item.querySelector('.co8mRf').innerText ?? '';
                const link = item.querySelector('._2dTcRw.e6NNk6').getAttribute('href') ?? '';

                listCouponData.push({
                    title: title,
                    description: description,
                    title_image: titleImage,
                    link: 'https://shopee.vn' + link
                });
            });

            return listCouponData;
        });


        res.send({
            success: true,
            data: listCoupon
        });
    } catch (e) {
        console.log(e);
        res.send({
            success: false,
            mgs: e
        })
    }
}


module.exports = CrawlShopeeController;
