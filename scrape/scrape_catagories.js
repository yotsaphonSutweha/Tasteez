const fs = require('fs')
const rp = require('request-promise')

function scrapeCatogories(callback) {
  rp('https://www.themealdb.com/api/json/v1/1/list.php?c=list')
    .then(res => {
      const categories = JSON.parse(res).meals.map(cat => {
        return {name: cat.strCategory}
      })
      fs.writeFile('./scrape/data/categories.json', JSON.stringify(categories), err => {
        if (err) callback(err)
        callback(null)
      })
    })
    .catch(callback)
}

module.exports = scrapeCatogories
