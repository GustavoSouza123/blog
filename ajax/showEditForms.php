<?php
    require '../config/config.php';
    $data = [];
    $form_name = (isset($_POST['formName'])) ? $_POST['formName'] : '';

    $tableName = '';
    if($form_name == 'category') {
        $tableName = 'tb_categories';
    } else if($form_name == 'post') {
        $tableName = 'tb_posts';
    } else if($form_name == 'user') {
        $tableName = 'tb_admin_users';
    }

    if($tableName == '') {
        $data['success'] = false;
        $data['error'] = 'Erro no nome da tabela';
    } else {
        // only get the posts that were made by the current user
        if($form_name == 'post') {
            $sql = $pdo->prepare("SELECT * FROM `".$tableName."` WHERE author_id = ?");
            $sql->execute(array($_POST['user_id']));
        } else {
            $sql = $pdo->prepare("SELECT * FROM `".$tableName."`");
            $sql->execute();
        }
        
        // $numColumns = $sql->columnCount();
        if($sql->rowCount() == 0) {
            $data['table'] = 'Tabela vazia';
        } else {            
            $rowsData = $sql->fetchAll(PDO::FETCH_ASSOC);
            $count = 0;
            $columnNames = [];
            $tableHeaderNames = [];
            foreach($rowsData as $key => $value) {
                // actions and table headers
                if($count == 0) {
                    // actions
                    $data['actions'] = '<td class="action-btn edit"><a href="" name="edit">Editar</a></td>';
                    if($form_name == 'user') {
                        $data['actions'] .= '<td class="action-btn edit-password"><a href="" name="edit-password">Alterar senha</a></td>';
                    }
                    $data['actions'] .= '<td class="action-btn delete"><a href="" name="delete">Excluir</a></td>';

                    // table headers
                    $data['table'] = '<tr>';
                    $data['table'] .= '<th></th>';
                    /* ** adding column names dinamically **
                    for($i = 0; $i < $numColumns; $i++) {
                        $meta = $sql->getColumnMeta($i);
                        if($form_name == 'post') {
                            if($meta['name'] != 'id' && $meta['name'] != 'author_id' && $meta['name'] != 'thumbnail' && $meta['name'] != 'post') {
                                $columnNames[] = $meta['name'];
                                $data['table'] .= '<th>'.ucfirst($meta['name']).'</th>';
                            }
                        } else if($form_name == 'user') {
                            if($meta['name'] != 'password' && $meta['name'] != 'profile_photo') {
                                $columnNames[] = $meta['name'];
                                $data['table'] .= '<th>'.ucfirst($meta['name']).'</th>';
                            }
                        } else {
                            $columnNames[] = $meta['name'];
                            $data['table'] .= '<th>'.ucfirst($meta['name']).'</th>';
                        }
                    }
                    if($form_name == 'post') {
                        $numColumns -= 4;
                    } else if($form_name == 'user') {
                        $numColumns -= 2;
                    }*/

                    // ** adding column names manually **
                    if($form_name == 'category') {
                        $columnNames = ['id', 'name', 'image', 'creation_date'];
                        $tableHeaderNames = ['id', 'nome', 'imagem', 'data de criação'];
                    } else if($form_name == 'post') {
                        $columnNames = ['category_id', 'title', 'subtitle', 'read_time', 'published', 'creation_date', 'last_update'];
                        $tableHeaderNames = ['categoria', 'título', 'subtítulo', 'tempo de leitura', 'publicado', 'data de criação', 'última modificação'];
                    } else if($form_name == 'user') {
                        $columnNames = ['id', 'user', 'email', 'name', 'role', 'joined_in'];
                        $tableHeaderNames = ['id', 'usuário', 'email', 'nome', 'função', 'data de cadastro'];

                    }
                    for($i = 0; $i < count($columnNames); $i++) {
                        $data['table'] .= '<th>'.ucfirst($tableHeaderNames[$i]).'</th>';
                    }
                    $data['table'] .= '</tr>';
                }

                // table data
                $data['table'] .= '<tr>';
                $data['table'] .= '<td><input type="checkbox" name="selected" value="'.$value['id'].'" /></td>';
                for($i = 0; $i < count($columnNames); $i++) {
                    $data['table'] .= '<td>'.$value[$columnNames[$i]].'</td>';
                }
                $data['table'] .= '</tr>';
                
                $count++;
            }
        }
    }
    
    die(json_encode($data));
?>
