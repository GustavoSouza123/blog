$(function() {
    // include path
    const include_path = $('input[name="include_path"]').val();

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

    $('header ul li.action a').click(function(e) {
        e.preventDefault();
    })

    // show action windows
    $('li.action ul li a').click(function(e) {
        e.preventDefault();
        $('header ul.dropdown').stop().slideUp(200);

        $('.action-window .title').text($(this).text());
        $('.action-window form').addClass('add');
        $('.action-window form').css('display', 'flex')
        $('.action-window form').html('');

        let index = parseInt($(this).attr('index'));
        let formName;
        let inputNum = 0;
        let inputNames = [];
        let inputLabels = [];
        switch(index) {
            case 0:
                formName = "category";
                inputNames = ['name', 'image'];
                inputLabels = ['Nome', 'Imagem'];
                break;
            case 2:
                formName = "post";
                inputNames = ['category_id', 'thumbnail', 'title', 'subtitle'];
                inputLabels = ['Categoria', 'Imagem principal', 'Título', 'Subtítulo'];
                break;
            case 4:
                formName = "user";
                inputNames = ['user', 'password', 'name'];
                inputLabels = ['Usuário', 'Senha', 'Nome'];
                break;
            default:
                // console.log(index);
        }

        if(inputNames.length > 0) {
            for(let i = 0; i < inputNames.length; i++) {
                if(inputNames[i] == 'thumbnail') {
                    $('.action-window form').append(`<label for="${inputNames[i]}">${inputLabels[i]}</label><input type="file" name="${inputNames[i]}" id="${inputNames[i]}" accept="image/*" />`);
                    continue;
                }
                $('.action-window form').append(`<label for="${inputNames[i]}">${inputLabels[i]}</label><input type="text" name="${inputNames[i]}" id="${inputNames[i]}" />`);
            }
            if(inputNames[0] == 'category_id') {
                $('.action-window form').append('<label>Post</label><textarea name="post"></textarea>'); 
            }
            $('.action-window form').append(`<input type="submit" name="${formName}" value="Adicionar" />`);
        } else {
            // ação editar
        }
    })

    // ajax add forms
    $('body').on('submit', 'form.add', function() {
        let form = $(this);
        $.ajax({
            url: include_path+'ajax/addForms.php',
            method: 'post',
            dataType: 'json',
            data: form.serialize()
        }).done(function(data) {
            console.log(data);
        });

        return false;
    })
})