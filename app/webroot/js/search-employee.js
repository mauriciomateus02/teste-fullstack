$(document).ready(function() {
    var searchTimeout;
    
    var searchInput = $('#searchInput');
    var searchForm = $('#searchForm');
    
    searchInput.on('keyup', function() {
        var searchTerm = $(this).val().trim();
        
        clearTimeout(searchTimeout);
        
        if (searchTerm === '') {
            submitSearch();
            return;
        }
        
        searchTimeout = setTimeout(function() {
            submitSearch();
        }, 500);
    });

    function submitSearch() {
        var url = new URL(window.location.href);
        url.searchParams.delete('page');
        
        var formAction = searchForm.attr('action');
        if (url.searchParams.has('q') && searchInput.val() === '') {
            url.searchParams.delete('q');
        }
        
        searchForm.attr('action', url.pathname + url.search);
        searchForm.submit();
    }
    $('.clear-search').on('click', function() {
        searchInput.val('');
        submitSearch();
    });
});
