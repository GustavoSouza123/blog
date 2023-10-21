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
    let form = $('.action-window form');
    $('li.action ul li a').click(function(e) {
        e.preventDefault();
        $('header ul.dropdown').stop().slideUp(200);

        $('.action-window .title').text($(this).text());
        form.addClass('add');
        form.css('display', 'flex')
        form.html('');

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
                    form.append(`<label for="${inputNames[i]}">${inputLabels[i]}</label><input type="file" name="${inputNames[i]}" id="${inputNames[i]}" accept="image/*" />`);
                    continue;
                }
                form.append(`<label for="${inputNames[i]}">${inputLabels[i]}</label><input type="text" name="${inputNames[i]}" id="${inputNames[i]}" />`);
            }
            if(inputNames[0] == 'category_id') {
                form.append('<label>Post</label><textarea name="post"></textarea>'); 
            }
            form.append(`<input type="hidden" name="form_name" value="${formName}" />`);
            form.append(`<input type="submit" value="Adicionar" />`);
        } else {
            // ação editar
        }
    })

    // ajax add forms
    $('body').on('submit', 'form.add', function(e) {
        e.preventDefault();
        let formDataObj = new FormData(form[0]);
        let formDataStr = Object.fromEntries(formDataObj);
        // formDataStr = JSON.stringify(formDataStr);

        let fileObj = formDataStr.thumbnail;
        let file = {
            lastModified: fileObj.lastModified,
            lastModifiedDate: fileObj.lastModifiedDate,
            name: fileObj.name,
            size: fileObj.size,
            type: fileObj.type,
        }
        // PAREI AQUI //
        console.log(formDataStr.thumbnail)
        console.log(JSON.stringify(file))
        // formDataObj.forEach(function(value, key) {
        //     if(key == 'thumbnail') {
        //         // formDataStr[key] =  form[0].files[0];
        //         console.log(value)
        //     } else {
        //         formDataStr[key] = value
        //     }
        // });
        $.ajax({
            url: include_path+'ajax/addForms.php',
            method: 'post',
            dataType: 'json',
            // data: formDataObj
        }).done(function(data) {
            console.log(data);
        });
    })
})
