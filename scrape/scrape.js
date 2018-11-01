// Get meals and meal ingredients from api, format the field names and
// write data to a json file
//==============================================================================
const scrapeMeals = require('./scrape_meals.js')
const scrapeIngredients = require('./scrape_ingredients.js')
const scrapeMealIngredients = require('./scrape_meal_ingredients.js')

console.log("Scraping data...");

// scrapeIngredients(err => {
//   if (err) console.log(err)
//   console.log("ingredients scraped...")
//
//   scrapeMeals(err => {
//     if (err) console.log(err)
//     console.log("meals scraped...")
//
//     scrapeIngredients((err) => {
//       if (err) console.log(err)
//       console.log("Scrape complete :)");
//     })
//
//   })
// })

scrapeMeals((err, meals) => {
  if (err) return console.log(err);
  console.log(meals.length);
})
