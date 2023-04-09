const express = require("express");
const app = express();
const server = require("http").Server(app);
server.listen(3000);
const fetch = require("node-fetch");

async function autoScroll(page) {
    await page.evaluate(async () => {
        await new Promise((resolve) => {
            let totalHeight = 0;
            const distance = 100;
            const scrollHeight = document.body.scrollHeight;
            window.scrollBy(0, distance);
            totalHeight += distance;

            if (totalHeight >= scrollHeight - window.innerHeight) {
                clearInterval(timer);
                resolve();
            }
        });
    });
}

app.get('/test-facebook', async function (req, res) {
    fetch("https://www.facebook.com/api/graphql/", {
        "headers": {
          "accept": "*/*",
          "accept-language": "vi",
          "content-type": "application/x-www-form-urlencoded",
          "sec-ch-prefers-color-scheme": "dark",
          "sec-ch-ua": "\"Chromium\";v=\"112\", \"Google Chrome\";v=\"112\", \"Not:A-Brand\";v=\"99\"",
          "sec-ch-ua-mobile": "?0",
          "sec-ch-ua-platform": "\"Windows\"",
          "sec-fetch-dest": "empty",
          "sec-fetch-mode": "cors",
          "sec-fetch-site": "same-origin",
          "viewport-width": "977",
          "x-asbd-id": "198387",
          "x-fb-friendly-name": "CometUFICreateCommentMutation",
          "x-fb-lsd": "2harFaHNvcJ25ufaF4M0En"
        },
        "referrer": "https://www.facebook.com/groups/897459204677592/posts/897459694677543/",
        "referrerPolicy": "origin-when-cross-origin",
        "body": "av=100091877191459&__user=100091877191459&__a=1&__req=r&__hs=19455.HYP%3Acomet_pkg.2.1..2.1&dpr=1&__ccg=EXCELLENT&__rev=1007275190&__s=wt9bai%3A5q3t0s%3A59gu6x&__hsi=7219679269364380127&__dyn=7AzHJ16U9ob8ng5K8G6EjBWo2nDwAxu13wFwhUngS3q2ibwNw9G2Saxa1NwJwpUe8hwaG0Z82_CxS320om78c87m2210wEwgolzUO0-E4a3a4oaEnxO0Bo7O2l2Utwwwi831wiEjwZx-3m1mzXw8W58jwGzEaE5e7oqBwJK2W5olwUwgojUlDw-wUwxwjFovUy2a0-pobpEbUGdwb6223908O3216AzUjwTwNxe6Uak1xwJwxyo566E&__csr=g9IkzMB6ZNAz5PaRdnSykINfj9my9QhrT4ZZbjh6GOuJ_9laGJrmt8NBAirbIDmKEy8iyaQ-GDCDAC8AAAFaGFAUS2bGauh2qBgCcAAKAVk8y8Kqpyqy8OqF-qmi8KWgiACGbxKi69ooxa7aG68e9o889EeWGcCwkFUqyoO4oeo9oO78bu2y6USi8wyxm8xedwfi2KexO3-68622S3a0JUlyEaVEKA7U2Awd-2u36fxC02Gq05-o1UE03r1w0zLw7vzo3kw3Jo0vMK07XU2oa04Q83ow0P_w18O9w7iw2e88U2tw2b81eE5K0cbw4Cg1UE&__comet_req=15&fb_dtsg=NAcOe0W8Vc3nUsYOKwoLuf3SsDvjX8fXWFUYIm7zLwS8JjlWZlLrSGA%3A5%3A1680954005&jazoest=25495&lsd=2harFaHNvcJ25ufaF4M0En&__spin_r=1007275190&__spin_b=trunk&__spin_t=1680962571&fb_api_caller_class=RelayModern&fb_api_req_friendly_name=CometUFICreateCommentMutation&variables=%7B%22displayCommentsFeedbackContext%22%3Anull%2C%22displayCommentsContextEnableComment%22%3Anull%2C%22displayCommentsContextIsAdPreview%22%3Anull%2C%22displayCommentsContextIsAggregatedShare%22%3Anull%2C%22displayCommentsContextIsStorySet%22%3Anull%2C%22feedLocation%22%3A%22GROUP_PERMALINK%22%2C%22feedbackSource%22%3A2%2C%22focusCommentID%22%3Anull%2C%22groupID%22%3Anull%2C%22includeNestedComments%22%3Afalse%2C%22input%22%3A%7B%22attachments%22%3Anull%2C%22feedback_id%22%3A%22ZmVlZGJhY2s6ODk3NDU5Njk0Njc3NTQz%22%2C%22formatting_style%22%3Anull%2C%22message%22%3A%7B%22ranges%22%3A%5B%5D%2C%22text%22%3A%22alotest123%22%7D%2C%22attribution_id_v2%22%3A%22CometGroupPermalinkRoot.react%2Ccomet.group.permalink%2Cvia_cold_start%2C1680962572354%2C298425%2C2361831622%2C%22%2C%22is_tracking_encrypted%22%3Atrue%2C%22tracking%22%3A%5B%22AZWZN4NDBjCB-woHMESl4UNan3gmVLbbn8xoR68RmI4-2NxD81LAJRDSRNj0UZrA6WPPe5ingqol9uChVEr9x3XzIZ4keaszDe5iJ-05TIFtjzcLfSKrqnMTkmsmRDQ85O6GaWBhM0Kqq4K1-ua76vLkM-Vh54Iw8LkNehRzNvlBp7_A9PX0dgpE4fNl38877a8XBRjiu1_ABpVILOVy3BJ7lLe8dEUmQrza7tB-l5ryOTDS8xs-ifF1gEzbZE28HT79jn7XyZ8VXlQgtJjWQ9ze1ANZNbdVIkgQ3waoUQon3aN-c_E_q6JwdO-7rQhqxgx1HJQxi8bu4ON2NmgwSu2pw2RRVdNJi3cMpeaOATlAtpS28lX43Fskm9dvsKIhgHPO7rm3ur8lkQqIS8B0omnXSSI2qvpJ4mSorYnpEia7B93JzMzco57gXpJolChb5_7NMwu6oK8zc44sdERUmukoeNO6eBPClFxxDLbooOmEIAxEwr_ds0de54tUCE8yQ-nm4Ra4cWna9tx8omah8J_Cnew6cN4ETCWGNA8M3meWPMqli0slGFJ-OK8A0UK5K62TYUfy66MXtqhYAZYfBkpWGWL_ymT_Ek6OgPZvheBeCp9xoewnxAxfSELb3Qmd0-wdfUHR0m7-JQedl9TPSkr7HuFjCswD9myuDau4fW1j8oVzWeFWJ-TFCbml5V_MmkxlhvzkkfmzK7mMXp83aRvYYdhKJv57FpyOuakRM3AYo_xSfn-6UvaFaIcmrr2e712EGtrL6-QKBA_TXYl6aUen%22%2C%22%7B%5C%22assistant_caller%5C%22%3A%5C%22comet_above_composer%5C%22%2C%5C%22conversation_guide_session_id%5C%22%3A%5C%229620d216-1809-43a4-af79-19d5f64a0cfd%5C%22%2C%5C%22conversation_guide_shown%5C%22%3Anull%7D%22%5D%2C%22feedback_source%22%3A%22OBJECT%22%2C%22idempotence_token%22%3A%22client%3Ac700e680-4132-48ff-bba8-9f76d5dde442%22%2C%22session_id%22%3A%22185cb909-5d6a-4617-9a66-5a09469d771c%22%2C%22actor_id%22%3A%22100091877191459%22%2C%22client_mutation_id%22%3A%224%22%7D%2C%22inviteShortLinkKey%22%3Anull%2C%22renderLocation%22%3Anull%2C%22scale%22%3A1%2C%22useDefaultActor%22%3Afalse%2C%22UFI2CommentsProvider_commentsKey%22%3A%22CometGroupPermalinkRootFeedQuery%22%7D&server_timestamps=true&doc_id=6041323439282313",
        "method": "POST",
        "mode": "cors",
        "credentials": "include"
      });      



    res.send("123");
    const puppeteer = require('puppeteer');
    const browser = await puppeteer.launch({
        headless: true, args: ['--no-sandbox']
    });
    const page = await browser.newPage();
    await page.goto("https://www.facebook.com/groups/507295559626595", {waitUntil: 'networkidle2', timeout: 0});
    //await page.setCookie(...cookies);
    await page.screenshot({ path: 'fullpage.png', fullPage: true });

    // x1yztbdb x1n2onr6 xh8yej3 x1ja2u2z
    await page.waitForSelector('.x1yztbdb.x1n2onr6.xh8yej3.x1ja2u2z');
    const listPostInGroup = await page.evaluate(() => {
        let divTags = document.querySelectorAll('.x1yztbdb.x1n2onr6.xh8yej3.x1ja2u2z');
        let divTagArray = [];
    
        divTags.forEach(item => {
            const aLinkClass = '.x1i10hfl.xjbqb8w.x6umtig.x1b1mbwd.xaqea5y.xav7gou.x9f619.x1ypdohk.xt0psk2.xe8uvvx.xdj266r.x11i5rnm.xat24cr.x1mh8g0r.xexx8yu.x4uap5.x18d9i69.xkhd6sd.x16tdsg8.x1hl2dhg.xggy1nq.x1a2a7pz.x1heor9g.xt0b8zv.xo1l8bm';
            const linkPost = item.querySelector(aLinkClass);

            // x11i5rnm xat24cr x1mh8g0r x1vvkbs xdj266r x126k92a
            // x11i5rnm xat24cr x1mh8g0r x1vvkbs xdj266r
            //const titleClass = '.x11i5rnm.xat24cr.x1mh8g0r.x1vvkbs.xdj266r.x126k92a';
            // x11i5rnm xat24cr x1mh8g0r x1vvkbs xdj266r
            const titleClass = '.x11i5rnm.xat24cr.x1mh8g0r.x1vvkbs.xdj266r';

            divTagArray.push({
                href: linkPost.getAttribute('href')
            });
        });
    
        return divTagArray;
    });


    await browser.close();



    res.send({
        success: true,
        data: {
            listPostInGroup
        }
    });
});

const CrawlShopeeController = require('./controller/CrawlShopeeController');

if (CrawlShopeeController.hasOwnProperty('getListCoupon')) {
    app.get('/crawl-shopee', CrawlShopeeController.getListCoupon);
}
