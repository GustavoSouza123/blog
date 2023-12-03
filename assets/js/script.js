$(function() {
    // include path
    const include_path = $('input[name="include_path"]').val();
    const include_path_portfolio = $('input[name="include_path_portfolio"]').val();

    // showing posts when clicking on post cards
    $('.posts-content .post').on('click', function() {
        $(this).find('a')[0].click();
    })

    // languages
    let activeLanguage = 'en';
    $('header nav .languages > div').click(function() {
        activeLanguage = $(this).attr('language'); 
        $('header nav .languages > div').removeClass('active');
        $(`div[language="${activeLanguage}"]`).addClass('active');
        document.cookie = `activeLanguage=${activeLanguage}; expires=60*60*24; path=/`;

        $.ajax({
            url: include_path_portfolio+`json/${activeLanguage}.json`,
            method: 'post',
            dataType: 'json'
        }).done(function(data) {
            document.cookie = `portfolioContent=${JSON.stringify(data)}; expires=60*60*24; path=/`;
            location.reload();
        });
    })

    // toggle social media logos
    let themeToggle = $('.theme-toggle')
    let theme = $('input[name="theme"]').val();
    themeToggle.click(function() {
        theme = (theme == 'light') ? 'dark' : 'light';
        $('header .social a img').eq(0).attr('src', `${include_path_portfolio}assets/images/github-${theme}.svg`);
        $('header .social a img').eq(1).attr('src', `${include_path_portfolio}assets/images/linkedin-${theme}.svg`);
        $('header .social a img').eq(2).attr('src', `${include_path_portfolio}assets/images/twitter-${theme}.svg`);
    })
})
