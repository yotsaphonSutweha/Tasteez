// (function() {
//   var comments = document.querySelector('.comments');
//
//   function onSubmit() {
//     window.alert("deleted comment");
//   }
//
//   comments.addEventListener('click', function(e) {
//     var element = e.target.parentElement;
//
//     if(element.classList.contains('comment__button')) {
//       var mealID = element.getAttribute('data-meal-id');
//       var commentID = element.getAttribute('data-comment-id');
//
//       while (!element.classList.contains('comment')) {
//         element = element.parentElement
//       }
//
//       element.parentElement.removeChild(element)
//
//       axios.post(`/api/meals/${mealID}/delete-comment`, {
//         comment_id: commentID
//       })
//       .catch(console.log)
//     }
//
//   })
//
// }())
