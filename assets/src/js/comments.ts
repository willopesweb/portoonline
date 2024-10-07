const commentForm = document.querySelector(".js-comment-form");
const replyButtons: NodeListOf<HTMLElement> | null =
  document.querySelectorAll(".js-reply-comment");

if (commentForm && replyButtons && replyButtons.length > 0) {
  const idInput: HTMLInputElement | null = commentForm.querySelector(
    "input[name='ParentId']"
  );
  const cancelReply: HTMLElement | null =
    commentForm.querySelector(".js-cancel-reply");

  if (idInput && cancelReply) {
    replyButtons.forEach((replyButton) => {
      replyButton.addEventListener("click", () => {
        idInput.value = replyButton.dataset.id ? replyButton.dataset.id : "0";
        cancelReply.classList.add("is-visible");
      });
    });

    cancelReply?.addEventListener("click", () => {
      idInput.value = "0";
      cancelReply.classList.remove("is-visible");
    });
  }
}
