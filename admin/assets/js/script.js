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
        let currentForm = $('.action-window form');
        currentForm.addClass('add');
        currentForm.css('display', 'flex')
        currentForm.html('');

        let index = parseInt($(this).attr('index'));
        let formName;
        let inputNum = 0;
        let inputNames = [];
        let inputLabels = [];
        switch(index) {
            case 0:
                formName = 'category';
                inputNames = ['name', 'image'];
                inputLabels = ['Nome', 'Imagem'];
                break;
            case 2:
                formName = 'post';
                inputNames = ['category_id', 'thumbnail', 'title', 'subtitle'];
                inputLabels = ['Categoria', 'Imagem principal', 'Título', 'Subtítulo'];
                break;
            case 4:
                formName = 'user';
                inputNames = ['user', 'password', 'name'];
                inputLabels = ['Usuário', 'Senha', 'Nome'];
                break;
            default:
                // console.log(index);
        }

        if(inputNames.length > 0) {
            for(let i = 0; i < inputNames.length; i++) {
                if(inputNames[i] == 'thumbnail') {
                    currentForm.append(`<label for="${inputNames[i]}">${inputLabels[i]}</label><input type="file" name="${inputNames[i]}" id="${inputNames[i]}" accept="image/*" />`);
                    continue;
                }
                currentForm.append(`<label for="${inputNames[i]}">${inputLabels[i]}</label><input type="text" name="${inputNames[i]}" id="${inputNames[i]}" />`);
            }
            if(inputNames[0] == 'category_id') {
                currentForm.append('<label>Post</label><textarea name="post"></textarea>'); 
            }
            currentForm.append(`<input type="hidden" name="form_name" value="${formName}" />`);
            currentForm.append(`<input type="submit" value="Adicionar" />`);
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
            data: form.serialize() // adicionar file com .files[0]
        }).done(function(data) {
            console.log(data);
        });

        return false;
    })
})
