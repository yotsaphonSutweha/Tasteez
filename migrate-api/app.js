var axios = require('axios');
var json = require('./mealsdb.json');
var ingredientsJson = require('../indgrediants.json');
var data = json.filter(item => item !== null).map(arr => arr[0])
var fs = require('fs');

var meals = data.map(meal => {
   return {
     id: meal.idMeal,
     name: meal.strMeal,
     cat: meal.strCategory,
     instructions: meal.strInstructions,
     area: meal.strArea,
     thumbnail: meal.strMealThumb,
     video: meal.strYoutube,
     source: meal.strSource,
     dateModified: meal.dateModified,
     ingredients: (function() {
       var arr = []
       for (var i = 1; i <= 20 ; i++) {
         arr.push(meal["strIngredient" + i])
       }
       return arr.filter(ing => ing !== "")
     })()
   }
})

var meal_ingredients = [];

meals.forEach(meal => {
  var meal_id = meal.id;
  var ingredients = meal.ingredients;
  var ingredients_ids = [];
  ingredients.forEach(a => {
    var found = ingredientsJson.find(b => b.name === a)
    if (!!found) {
      ingredients_ids.push(found.id)
    }
    meal_ingredients.push({meal_id: meal_id, ingredient_ids: ingredients_ids});
  })
})
//
// axios.get('https://www.themealdb.com/api/json/v1/1/list.php?i=list')
//   .then(res => {
//     let ingredients = res.data.meals.map(meal => {
//       return {id: meal.idIngredient, name: meal.strIngredient, description: meal.strDescription, type: meal.strType}
//     });
//
//
//     fs.writeFile("indgrediants.json", JSON.stringify(ingredients), function(err) {
//       if(err) {
//         return console.log(err);
//       }
//       console.log("The file was saved!");
//     });
//
//   })

fs.writeFile("meal_ingredients.json", JSON.stringify(meal_ingredients), function(err) {
    if(err) {
      return console.log(err);
    }
    console.log("The file was saved!");
  });
