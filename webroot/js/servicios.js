$(document).ready(function(){
    $('input.quicksearch').quicksearch('.service-item', {
        'noResults': 'div.quicksearch-no-results',
    });
});