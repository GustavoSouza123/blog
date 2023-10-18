$(function() {
    $('.actions .action').click(function() {
        $('.action-window .title').text($(this).text());
        $('.action-window form').css('display', 'flex')
        $('.action-window form').html('');

        let index = $(this).index(); // 2, 3, 5, 6, 8, 9
        let inputNum = 0;
        let inputNames = [];
        let inputLabels = [];
        switch(index) {
            case 2:
                inputNum = 2;
                inputNames = ['name', 'image'];
                inputLabels = ['Nome', 'Imagem'];
                break;
            case 5:
                inputNum = 3;
                inputNames = ['category_id', 'title', 'subtitle'];
                inputLabels = ['Categoria', 'Título', 'Subtítulo'];
                break;
            case 8:
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
                $('.action-window form').append('<label>Artigo</label><textarea name="article"></textarea>'); 
            }
            $('.action-window form').append(`<input type="submit" value="Adicionar" />`);
        } else {
            // ação editar
        }
    })
})
