// (function() {
//
//   var addCommentForm;
//   var addCommentInput;
//   var commentsDiv;
//   var mealInput;
//   var submitButton;
//
//   function onAddCommentError(err) {
//     if (err.response.status === 403) {
//       window.location.replace("/auth/login");
//     }
//     submitButton.value = "Leave Comment";
//     submitButton.disabled = false;
//   }
//
//
//   function onAddComment(response) {
//     var comment = response.data.comment;
//
//     var commentDiv = document.createElement("div");
//     addCommentForm.classList.remove('loading');
//     commentDiv.innerHTML =
//       `<div class="comment">
//         <div class="comment__header">
//           <i class="fas fa-user"></i>
//           <span class="comment__user">${ comment.username }</span>
//           <span class="commnet_date">${ comment.shortDate }</span>
//         </div>
//         <div class="comment__body">
//           ${ comment.comment }
//         </div>
//         ${comment.usersComment ? `
//           <form class="" action="index.html" method="post">
//             <input class="button add-comment__submit" type="submit" name="" value="Delete Comment">
//           </form>`: null}
//       </div>`;
//     commentsDiv.appendChild(commentDiv);
//     submitButton.disabled = false;
//     submitButton.value = "Leave Comment";
//   }
//
//   function onSubmit(event) {
//     event.preventDefault();
//
//     var comment = addCommentInput.value;
//     var mealID = mealInput.value;
//
//     submitButton.disabled = true;
//     submitButton.value = "Submiting Comment...";
//
//     this.reset();
//     axios.post('/api/meals/' + mealID + '/add-comment', {
//       comment: comment,
//       meal_id: mealID
//     })
//     .then(onAddComment)
//     .catch(onAddCommentError);
//   }
//
//   window.addEventListener('load', function() {
//
//     addCommentForm = document.querySelector('.add-comment__form');
//     addCommentInput = document.querySelector('.add-comment__input');
//     submitButton = document.querySelector('.add-comment__submit');
//     commentsDiv = document.querySelector('.comments');
//     mealInput = document.querySelector('.meal-id');
//
//     addCommentForm.addEventListener('submit', onSubmit);
//
//   });
//
//
// }())