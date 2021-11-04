$(document).ready(function(e) {
    var filterForm = $('form#a_filter');
    customInput();
    filterForm.find('input[type=checkbox]').change(function(e) {
        filterForm.submit();
    });
    filterForm.find('span.customCheckbox').click(function(e) {
        e.preventDefault();
        filterForm.submit();
    });
});