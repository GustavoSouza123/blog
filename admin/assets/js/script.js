$(function() {
    // include path
    const include_path = $('input[name="include_path"]').val();

    // show dropdown menu
    $('header ul li.action').hover(function(e) {
        $('header ul.dropdown').hide();
        $('header ul.dropdown').eq($(this).attr('dropdown')).stop().slideDown(200);
        e.stopPropagation();
    }, function() {
        $('header ul.dropdown').eq($(this).attr('dropdown')).stop().slideUp(200);
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
    let table = $('.action-window table');
    $('li.action ul li a').click(async function(e) {
        e.preventDefault();
        $('header ul.dropdown').stop().slideUp(200);
        $('.action-window .title').text($(this).text());

        let index = parseInt($(this).attr('index'));
        let formName;
        let inputNames = [];
        let inputLabels = [];
        switch(index) {
            // add forms
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
                inputNames = ['user', 'email', 'password', 'name', 'profile_photo', 'role'];
                inputLabels = ['Usuário', 'Email', 'Senha', 'Nome', 'Foto', 'Permissão'];
                break;
            // edit forms
            case 1:
                formName = 'category';
                break;
            case 3:
                formName = 'post';
                break;
            case 5:
                formName = 'user';
                break;
        }

        if(inputNames.length > 0) {
            // add forms
            form.addClass('add'); 
            form.css('display', 'flex');
            form.html('');
            form.append('<p class="form-message"></p>');
            table.css('display', 'none');
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
                if(inputNames[i] == 'image' || inputNames[i] == 'thumbnail' || inputNames[i] == 'profile_photo') {
                    // file inputs for uploading photos
                    form.append(`<input type="file" name="${inputNames[i]}" id="${inputNames[i]}" accept="image/*" />`);    
                    continue;
                } else if(inputNames[i] == 'email') {
                    // email inputs
                    form.append(`<input type="email" name="${inputNames[i]}" id="${inputNames[i]}" />`);
                    continue;
                } else if(inputNames[i] == 'role') {
                    // user role permission
                    form.append('<input type="text" name="role" id="role" value="Usuário" readonly />');
                } else {
                    // normal text inputs
                    form.append(`<input type="text" name="${inputNames[i]}" id="${inputNames[i]}" />`);
                }
            }
            // post textarea
            if(inputNames[0] == 'category_id') {
                form.append('<label>Postagem</label><textarea name="post"></textarea>'); 
            } 
            form.append(`<input type="hidden" name="form_name" value="${formName}" />`);
            form.append(`<input type="submit" value="Adicionar" />`);
        } else {
            // edit forms
            // show database tables using an ajax request
            form.css('display', 'none');
            table.css('display', 'block');
            table.html('');
            let postData = {formName: formName};
            $.ajax({
                url: include_path+'ajax/showEditForms.php',
                method: 'post',
                dataType: 'json',
                data: postData
            }).done(function(data) {
                table.append(data.table);
            });

            // edit data
            $('body').on('click', '.edit a', function() {
                let actionData = {actionName: 'edit', index: $(this).attr('index')};
                // console.log($(this).className);
                $.ajax({
                    url: include_path+'ajax/editForms.php',
                    method: 'post',
                    dataType: 'json',
                    data: actionData
                });
                return false;
            })
            
            // delete data
            $('body').on('click', '.delete a', function() {
                let actionData = {actionName: 'delete', index: $(this).attr('index')};
                $.ajax({
                    url: include_path+'ajax/editForms.php',
                    method: 'post',
                    dataType: 'json',
                    data: actionData
                });
                return false;
            })
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
            // TEMPORÁRIO!
            alert('Formulário enviado com sucesso!');
            $('form.add')[0].reset();
           
            /*if(!data.success) {
                $('p.form-message').text(data.error);
            } else {
                $('p.form-message').text('Formulário enviado com sucesso!');
                $('form.add')[0].reset();
            }*/
        });
    })
})
