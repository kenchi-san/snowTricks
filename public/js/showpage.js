// media
const allMediasContainers = document.querySelectorAll('.js-trick-media');
const modal = new bootstrap.Modal(document.getElementById('modal'));
const showMoreMediaBtn = document.querySelector(".js-add-more-medias")
const INITMEDIA = 6;
// action click sur les images
allMediasContainers.forEach((container) => {
    container.addEventListener('click', () => {
        modal._element.querySelector('.modal-body').innerHTML = container.innerHTML;
        modal.show()
    })
})

// affichage ou non du bouton si tous les medias sont affiché et affiche les éléments non visibles
function btnShowMoreMedia() {
    if (document.querySelectorAll('.js-trick-media.d-none').length === 0) {
        showMoreMediaBtn.classList.add('d-none');
    } else {
        showMoreMediaBtn.addEventListener('click', () => {
            if (document.querySelectorAll('.js-trick-media.d-none').length === 0) {
                showMoreMediaBtn.classList.add('d-none');
            }
            showMoreMedia();
        })
    }
}

// affiche les médias
function showMoreMedia() {
    for (let i = 0; i < INITMEDIA; i++) {
        mediaElt = document.querySelector('.js-trick-media.d-none');
        if (!mediaElt) {
            break;
        }
        mediaElt.classList.remove('d-none');
    }
}

btnShowMoreMedia();
if (screen.width > 750) {
    showMoreMedia();
} else {
    btnShowMoreMedia();
}
// comments
const comments = document.querySelectorAll('.js-show-comments');
const initComments = 5;
const butonMoreComment = document.querySelector('#js-add-more-comments');

function startToShowXComments() {
    const commentsHidden = document.querySelectorAll('.js-show-comments.d-none');
    for (let i = 0; i < commentsHidden.length; i++) {
        if (i >= initComments) {
            break;
        }
        commentsHidden[i].classList.remove('d-none');
    }

    const nbCommentsHidden = document.querySelectorAll('.js-show-comments.d-none');
    if (nbCommentsHidden.length === 0) {
        butonMoreComment.classList.add('d-none');
    }
}

function showMoreCommentsButon() {
    if (butonMoreComment.className !== 'd-none') {
        butonMoreComment.addEventListener('click', () => {
            startToShowXComments()
        });
    }
}

startToShowXComments();
showMoreCommentsButon();
