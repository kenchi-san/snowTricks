const deleteTrickModal = new bootstrap.Modal(document.getElementById('delete_figure'));
const deleteTricksButtons = document.querySelectorAll('.js-button-delete-trick');
deleteTricksButtons.forEach(button => {
    button.addEventListener('click', () => {
        deleteTrickModal._element.querySelector(".js-delete_figure_modal_link").href = button.dataset.href;
        deleteTrickModal.toggle();
    })
})
const figureTrickButton = document.querySelector('.js-add-more-figure');
const FIGURES_PER_PAGE = 8;

function showMoreFigure() {
    const figures = document.querySelectorAll('.portfolio-item.d-none');
    for (let i = 0; i < figures.length; i++) {
        if (i >= FIGURES_PER_PAGE) {
            break;
        }
        figures[i].classList.remove('d-none');
    }

    let nbFiguresHidden = document.querySelectorAll('.portfolio-item.d-none').length;
    if (nbFiguresHidden === 0){
        figureTrickButton.classList.add('d-none');
    }

}

showMoreFigure();

figureTrickButton.addEventListener('click', () => {
    showMoreFigure()
});