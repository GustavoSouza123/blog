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

    // async function to get the categories of the blog through an ajax request
    async function getCategories() {
        const result = await $.ajax({
            url: include_path+'ajax/categories.php',
            method: 'post',
            dataType: 'json'
        });
        return result;
    }

    let form = $('.action-window form');
    $('li.action ul li a').click(async function(e) {
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
                inputNames = ['user', 'email', 'password', 'name', 'profile_photo'];
                inputLabels = ['Usuário', 'Email', 'Senha', 'Nome', 'Foto'];
                break;
            default:
                // console.log(index);
        }

        if(inputNames.length > 0) {
            for(let i = 0; i < inputNames.length; i++) {
                form.append(`<label for="${inputNames[i]}">${inputLabels[i]}</label>`);
                if(inputNames[i] == 'category_id') {
                    // show the categories of the blog in the form through a select field
                    async function showCategories() {
                        try {
                            const data = await getCategories();
                            // console.log(data);

                            if(data.error != undefined) {
                                form.append(data.error);
                            } else {
                                form.append(`<select name="${inputNames[i]}" id="${inputNames[i]}"></select>`);
                                let formSelect = form.find(`select[name="${inputNames[i]}"]`);
                                for(let i = 0; i < data.categories.length; i++) {
                                    formSelect.append(`<option value="${data.categories[i].id}">${data.categories[i].name}</option>`);
                                }
                            }
                        } catch(error) {
                            console.error('Error loading categories: ', error)
                        }
                    }
                    await showCategories();
                    continue;
                }
                // file inputs for uploading photos
                if(inputNames[i] == 'image' || inputNames[i] == 'thumbnail' || inputNames[i] == 'profile_photo') {
                    form.append(`<input type="file" name="${inputNames[i]}" id="${inputNames[i]}" accept="image/*" />`);    
                    continue;
                }
                // email inputs
                if(inputNames[i] == 'email') {
                    form.append(`<input type="email" name="${inputNames[i]}" id="${inputNames[i]}" />`);
                    continue;
                }
                form.append(`<input type="text" name="${inputNames[i]}" id="${inputNames[i]}" />`);
            }
            // post textarea
            if(inputNames[0] == 'category_id') {
                form.append('<label>Postagem</label><textarea name="post"></textarea>'); 
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
        let formData = new FormData($('form.add')[0]);

        $.ajax({
            url: include_path+'ajax/addForms.php',
            method: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData
        }).done(function(data) {
            console.log(data.sucess)
            if(!data.success) {
                $('p.form-message').text(data.error);
            } else {
                $('p.form-message').text('Formulário enviado com sucesso!');
            }
        }).fail(function() {
            alert('erro');
        });
    })
})
