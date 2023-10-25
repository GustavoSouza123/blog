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
        $sql = $pdo->prepare("SELECT * FROM `".$tableName."`");
        $sql->execute();
        
        $numColumns = $sql->columnCount();
        $columnNames = [];
        if($sql->rowCount() == 0) {
            $data['table'] = 'Nenhum resultado encontrado';
        } else {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            $count = 0;
            foreach($data as $key => $value) {
                if($count == 0) {
                    $data['table'] = '<tr>';
                    for($i = 0; $i < $numColumns; $i++) {
                        $meta = $sql->getColumnMeta($i);
                        $columnNames[] = $meta['name'];
                        $data['table'] .= '<th>'.$meta['name'].'</th>';
                    }
                    $data['table'] .= '</tr>';
                }
                $data['table'] .= '<tr>';
                for($i = 0; $i < $numColumns; $i++) {
                    $data['table'] .= '<td>'.$value[$columnNames[$i]].'</td>';
                }
                $data['table'] .= '</tr>';
                
                $count++;
            }
        }
    }
    
    die(json_encode($data));
?>