$(function() {
    // include path
    const include_path = $('input[name="include_path"]').val();

    // show dropdown menu
    $('header ul li.action').hover(function(e) {
        $('header ul.dropdown').hide();
        $('header ul.dropdown').eq($(this).attr('dropdown')).stop().slideDown(200);
        e.stopPropagation();
    }, function() {
        $('header ul.dropdown').eq($(this).attr('dropdown')).stop().slideUp(100);
    })

    $('header ul.dropdown').hover(function(e) {
        e.stopPropagation();
    }, function() {
        $(this).stop().slideUp(100);
    })

    $('header ul li.action a').click(function(e) {
        e.preventDefault();
    })

    // show action windows

    // function to get data through an ajax request
    function getData(url) {
        return $.ajax({
            url: include_path+url,
            method: 'post',
            dataType: 'json'
        });
    }

    let form = $('.action-window form');
    let table = $('.action-window table');
    let index;
    $('li.action ul li a').click(async function(e) {
        let dropdown = $(this);

        e.preventDefault();
        $('header ul.dropdown').stop().slideUp(200); 
        $('.dashboard').css('display', 'none');
        $('.action-window').css('display', 'flex');
        $('.action-window .title').text($(this).text());

        index = parseInt($(this).attr('index'));
        let formName = '';
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

        dropdown.attr('name', formName);

        if(inputNames.length > 0) {
            // add forms
            form.removeClass('edit');
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
                            const data = await getData('ajax/getCategories.php');
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
                } else if(inputNames[i] == 'password') {
                    // password input
                    form.append(`<input type="password" name="${inputNames[i]}" id="${inputNames[i]}" />`);
                    continue;
                } else if(inputNames[i] == 'role') {
                    // user role permission
                    async function showRoles() {
                        try {
                            const data = await getData('ajax/getRoles.php');
                            form.append(`<select name="${inputNames[i]}" id="${inputNames[i]}"></select>`);
                            let roleSelect = form.find(`select[name="${inputNames[i]}"]`);
                            for(let j = 0; j < data.roles.length; j++) {
                                roleSelect.append(`<option value="${j}">${data.roles[j]}</option>`);
                            }
                        } catch(error) {
                            console.error('Error loading roles: ', error)
                        }
                    }
                    await showRoles();
                    continue;
                } else {
                    // normal text inputs
                    form.append(`<input type="text" name="${inputNames[i]}" id="${inputNames[i]}" />`);
                    continue;
                }
            }
            // post textarea
            if(inputNames[0] == 'category_id') {
                form.append('<label for="post">Postagem</label><textarea name="post" id="post"></textarea>');
            }
            // name of the author of the post
            form.append(`<input type="hidden" name="author" value="${$('header h3 span').text()}" />`);
            // name of the form
            form.append(`<input type="hidden" name="form_name" value="${formName}" />`);
            // submit input (save draft for add post form)
            if(formName == 'post') {
                form.append(`<input type="hidden" name="draft" />`);
                form.append(`<div class="submit-btns"><input type="submit" value="Publicar" /><input type="submit" name="save_draft" value="Salvar rascunho" /></div>`);
            } else {
                form.append(`<input type="submit" name="submit" value="Adicionar" />`);
            }
            // save post as a draft
            $('input[name="save_draft"]').click(function() {
                $('input[name="draft"]').val('true');
            })
        } else {
            // edit forms

            // show database tables using an ajax request
            form.css('display', 'none');
            table.css('display', 'block');
            table.html('');
            let postData = {formName: formName, user_id: $('input[name="user_id"]').val()};
            $.ajax({
                url: include_path+'ajax/showEditForms.php',
                method: 'post',
                dataType: 'json',
                data: postData
            }).done(function(data) {
                table.append(data.table);
            });

            // edit and delete data
            $('body').off('click');

            $('body').on('click', '.action-btn a', function() {
                let actionData = {formName: formName, actionName: $(this).attr('name'), index: $(this).attr('index')};

                if(actionData.actionName == 'edit') {
                    let addIndex = index-1;
                    $(`.menu ul.dropdown li a[index=${addIndex}]`).trigger('click');
                    form.removeClass('add'); 
                    form.addClass('edit');
                    $('.action-window .title').text('Editar '+$(`ul.dropdown li a[index=${addIndex}]`).text().split(' ')[1]);
                    $('.action-window form.edit input[type="submit"]').val('Atualizar');
                    $.ajax({
                        url: include_path+'ajax/editForms.php',
                        method: 'post',
                        dataType: 'json',
                        data: actionData
                    }).done(function(data) {
                        $('form.edit').append('<input type="hidden" name="edit_form" value="true" />');
                        $('form.edit').append(`<input type="hidden" name="index" value="${data.index}" />`);
                        $('form.edit').append(`<input type="hidden" name="table" value="${data.table}" />`);
                        $('form.edit input[name="form_name"]').remove();

                        // save post as a draft
                        $('input[name="save_draft"]').click(function() {
                            $('input[name="draft"]').val('true');
                        })
                        
                        // put data on the inputs
                        $('input[name="user"]').val(data.row.user);
                        $('input[name="email"]').val(data.row.email);
                        $('input[name="password"]').val(data.row.password);
                        $('input[name="name"]').val(data.row.name);
                        $('form.edit select[name="role"] option[value="'+data.row.role+'"]').attr('selected', 'selected');
                        $('form.edit select[name="category_id"] option[value="'+data.row.category_id+'"]').attr('selected', 'selected');
                        $('input[name="title"]').val(data.row.title);
                        $('input[name="subtitle"]').val(data.row.subtitle);
                        $('textarea[name="post"]').text(data.row.post);
                    });
                } else if(actionData.actionName == 'delete') {
                    if(confirm("Tem certeza que deseja excluir este campo?") == true) {
                        $.ajax({
                            url: include_path+'ajax/editForms.php',
                            method: 'post',
                            dataType: 'json',
                            data: actionData
                        }).done(function(data) {
                            if(data.success) {
                                alert('Campo excluido com sucesso!');
                                dropdown.trigger('click');
                            } else {
                                alert(data.error);
                            }
                        });
                    }
                }

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
            if(data.success) {
                alert('Formulário enviado com sucesso!');
                $('form.add')[0].reset();
                $(`.menu ul.dropdown li a[index=${index+1}]`).trigger('click');
            } else {
                alert(data.error);
            }
        });
    })

    // ajax edit (update) forms
    $('body').on('submit', 'form.edit', function(e) {
        e.preventDefault();
        let formData = new FormData($('form.edit')[0]);
            
        $.ajax({
            url: include_path+'ajax/addForms.php',
            method: 'post',
            datatype: 'json',
            processData: false,
            contentType: false,
            data: formData
        }).done(function(data) {
            alert('Campo modificado com sucesso!');
            $('form.edit')[0].reset();
            $(`.menu ul.dropdown li a[index=${index+1}]`).trigger('click');
        });
    })
})
