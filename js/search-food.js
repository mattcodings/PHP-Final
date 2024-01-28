$(document).ready(function(){
    $('#search').on('keyup', function(e){
        let searchTerm = $('#search').val();

        $.get(
            'food-search-results.php',
            {
                search: searchTerm
            },
            function(data){
                $('#food-items-table').html(data);
            },
            'html'
        )
    })
})