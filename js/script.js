$(function() {
    // show dropdown menu
    $('header ul li.action').hover(function(e) {
        $('header ul.dropdown').hide
        $('header ul.dropdown').eq($(this).index()).stop().slideDown(200);
        e.stopPropagation();
    }, function() {
        $('header ul.dropdown').eq($(this).index()).stop().slideUp(200);
    })

    $('header ul.dropdown').hover(function(e) {
        e.stopPropagation();
    }, function() {
        $(this).stop().slideUp(200);
    })

    // show action windows
    $('li.action ul li a').click(function(e) {
        e.preventDefault();
        $('header ul.dropdown').stop().slideUp(200);

        $('.action-window .title').text($(this).text());
        $('.action-window form').css('display', 'flex')
        $('.action-window form').html('');

        let index = parseInt($(this).attr('index'));
        console.log(index)
        let inputNum = 0;
        let inputNames = [];
        let inputLabels = [];
        switch(index) {
            case 0:
                inputNum = 2;
                inputNames = ['name', 'image'];
                inputLabels = ['Nome', 'Imagem'];
                break;
            case 2:
                inputNum = 3;
                inputNames = ['category_id', 'title', 'subtitle'];
                inputLabels = ['Categoria', 'Título', 'Subtítulo'];
                break;
            case 4:
                inputNum = 3;
                inputNames = ['user', 'password', 'name'];
                inputLabels = ['Usuário', 'Senha', 'Nome'];
                break;
            default:
                // console.log(index);
        }

        if(inputNames.length > 0) {
            for(let i = 0; i < inputNames.length; i++) {
                $('.action-window form').append(`<label>${inputLabels[i]}</label><input type="text" name="${inputNames[i]}" />`);
            }
            if(inputNames[0] == 'category_id') {
                $('.action-window form').append('<label>Post</label><textarea name="post"></textarea>'); 
            }
            $('.action-window form').append(`<input type="submit" value="Adicionar" />`);
        } else {
            // ação editar
        }
    })
})
