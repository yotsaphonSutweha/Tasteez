const fs = require('fs')
const rp = require('request-promise')
const mealdbIngredients = require('./data/mealdb/ingredients.json')

const meals = []
const firstMealID = 52802
const lastMealID = 52956
let failedRequests = 0

// Get ingredients
function scrapeIngredients(callback) {

  return rp('https://www.themealdb.com/api/json/v1/1/list.php?i=list')
    .then(res => {

      const ingredients = JSON.parse(res).meals.map(ingredient => {
        return {id: ingredient.idIngredient, name: ingredient.strIngredient}
      })

      fs.writeFile("./scrape/data/ingredients.json", JSON.stringify(ingredients), function(err) {
        if(err) return callback(err)
        console.log("ingredients.json file saved");
        callback(null)
      });

    })
}

module.exports = scrapeIngredients
