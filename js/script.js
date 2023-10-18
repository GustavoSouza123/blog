$(function() {
    $('.actions .action').click(function() {
        $('.action-window form').css('display', 'flex')
        $('.action-window .title').text($(this).text());
        index = $(this).index(); // 2, 3, 5, 6, 8, 9
        switch(index) {
            case 2:
                $('.action-window form').innerHTML += `
                    
                `;
            case 3:

            case 5:

            case 6:

            case 8:

            case 9:

            default:
                // console.log(index);
        }        
    })
})