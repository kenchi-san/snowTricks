$(document).ready(function() {
    // Get the ul that holds the collection of tags
    const $collectionHolder = $('ul.videos');

    $collectionHolder.find('li').each(function() {
        addEntryDeleteLink($(this));
    });
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('li').length);
    $('body').on('click', '.add_item_link', function(e) {
        addFormToCollection($collectionHolder);
    })

});

function addFormToCollection($collectionHolder) {

    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');
    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index + 1);
    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    // Add the new form at the end of the list
    $collectionHolder.append($newFormLi)
    addEntryDeleteLink($newFormLi);


}

function addEntryDeleteLink($entry) {
    const $removeFormButton = $('<button type="button">supprimer </button>');
    $entry.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $entry.remove();
    });
}
