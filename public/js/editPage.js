// media
const allMediasContainers = document.querySelectorAll(".js-trick-media>img");
const modal = new bootstrap.Modal(document.getElementById("modal"));
const showMoreMediaBtn = document.querySelector(".js-add-more-medias");
const INITMEDIA = 6;


allMediasContainers.forEach((container) => {
    container.addEventListener("click", () => {

            modal._element.querySelector(".modal-body").innerHTML = container.outerHTML;
            if (IS_CONNECTED) {
                modal._element.querySelector(".modal-footer").innerHTML =
                    `<a href="${container.parentElement.dataset.editImage}">edit</a>
                  <a href="${container.parentElement.dataset.deleteImage}">supprimer</a>`;
            }
            modal.show();
    })
})

function btnShowMoreMedia() {
    if (document.querySelectorAll(".js-trick-media.d-none").length === 0) {
        showMoreMediaBtn.classList.add("d-none");
    } else {
        showMoreMediaBtn.addEventListener("click", () => {
            if (document.querySelectorAll(".js-trick-media.d-none").length === 0) {
                showMoreMediaBtn.classList.add("d-none");
            }
            showMoreMedia();
        })
    }
}
function showMoreMedia() {
    for (let i = 0; i < INITMEDIA; i++) {
        mediaElt = document.querySelector(".js-trick-media.d-none");
        if (!mediaElt) {
            break;
        }
        mediaElt.classList.remove("d-none");
    }
}

btnShowMoreMedia();
if (screen.width > 750) {
    showMoreMedia();
} else {
    btnShowMoreMedia();
}



