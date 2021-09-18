<?php
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    
    $ticket = new Ticket();
    

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    require_once("../models/Documento.php");
    $documento = new Documento();

    switch($_GET["op"]){


        case "tipoSolicitud":
            
            $datos=[
                ['id'=>'Solicitud de informacion','solicitud'=>'Solicitud de informacion' ],  
                ['id'=>'Soporte','solicitud'=>'Soporte' ],      
                ['id'=>'Servicio','solicitud'=>'Servicio' ]
            ];          
                $html.="<option>Selecciona</option>";
                foreach($datos as $row)
                {                    
                    $html.= "<option value='".$row['id']."' >".$row['solicitud']."</option>";
                }
                echo $html;            
        break; 
        
        case "sucursal":
           
            $datos=[
                ['id'=>'Monterrey','sucursal'=>'Monterrey' ],  
                ['id'=>'Monterrey la Fe','sucursal'=>'Monterrey la Fe' ],      
                ['id'=>'Monterrey Lincoln','sucursal'=>'Monterrey Lincoln' ],
                ['id'=>'San Nicolas','sucursal'=>'San Nicolas' ],
                ['id'=>'San Nicolas Plaza Opcion','sucursal'=>'San Nicolas Plaza Opcion' ],
                ['id'=>'Santa Catarina','sucursal'=>'Santa Catarina' ]
            ];          
                $html.="<option>Selecciona</option>";
                foreach($datos as $row)
                {                    
                    $html.= "<option value='".$row['id']."' >".$row['sucursal']."</option>";
                }
                echo $html;            
        break; 
        
        case "areas":      
            $datos=[
                ['id'=>'Electrocardiograma','area'=>'Electrocardiograma' ],  
                ['id'=>'Densitometria','area'=>'Densitometria' ],      
                ['id'=>'Vitrina','area'=>'Vitrina' ],
                ['id'=>'Imagen','area'=>'Imagen' ],
                ['id'=>'Ultrasonido','area'=>'Ultrasonido' ],
                ['id'=>'Optometria','area'=>'Optometria' ],
                ['id'=>'Laboratorio','area'=>'Laboratorio' ]
            ];          
                $html.="<option>Selecciona</option>";
                foreach($datos as $row)
                {                    
                    $html.= "<option value='".$row['id']."' >".$row['area']."</option>";
                }
                echo $html;            
        break;  

        case "prioridad":
            
            $datos=[
                ['id'=>'Baja','prioridad'=>'Baja'],  
                ['id'=>'Normal','prioridad'=>'Normal'],      
                ['id'=>'Media','prioridad'=>'Media'],
                ['id'=>'Alta','prioridad'=>'Alta']
            ];          
                $html.="<option>Selecciona</option>";
                foreach($datos as $row)
                {                    
                    $html.= "<option value='".$row['id']."' >".$row['prioridad']."</option>";
                }
                echo $html;            
        break;         

        case "categoria":
            $datos = $ticket->get_categoria();
            if(is_array($datos)==true and count($datos)>0){
                $html.="<option>Selecciona</option>";
                foreach($datos as $row)
                {                    
                    $html.= "<option value='".$row['cat_id']."' >".$row['cat_nom']."</option>";
                }
                echo $html;
            }
        break;

        case "subcategoria": 
            $datos=$ticket->listarSubCategoria($_POST["idCategoria"]);
            if(is_array($datos)==true and count($datos)>0){
                $html.="<option>Selecciona</option>";
                foreach($datos as $row)
                {
                    
                    $html.= "<option value='".$row['idSubCategoria']."' >".$row['subCategoria']."</option>";
                }
                echo $html;
            }                                      
        break;
        
        case "articuloSubcategoria": 
            $datos=$ticket->listarArticuloSubCategoria($_POST["idSubCategoria"]);
            if(is_array($datos)==true and count($datos)>0){
                $html.="<option>Selecciona</option>";
                foreach($datos as $row)
                {
                    
                    $html.= "<option value='".$row['id_articulo_sub']."' >".$row['articulo_subcat']."</option>";
                }
                echo $html;
            }
        break;  
        
        case "rolSoporte":
            $datos = $usuario->get_usuario_x_rol();
            if(is_array($datos)==true and count($datos)>0){
                $html.="<option>Selecciona</option>";
                foreach($datos as $row)
                {                   
                    $html.= "<option value='".$row['usu_id']."' >".$row['usu_nom']."</option>";
                }
                echo $html;
            }
        break;

        case "rolSupervisor":
            $datos = $usuario->get_usuario_x_rol_sup();
            if(is_array($datos)==true and count($datos)>0){
                $html.="<option>Selecciona</option>";
                foreach($datos as $row)
                {                   
                    $html.= "<option value='".$row['usu_id']."' >".$row['usu_nom']."</option>";
                }
                echo $html;
            }
        break;

        case "insert":
            $datos=$ticket->insert_ticket($_POST["usu_id"], $_POST["tipoSolicitud"], $_POST["sucursal"], $_POST["areas"],
                $_POST["prioridad"], $_POST["cat_id"], $_POST["subcat_id"], $_POST["articulo_id"],
                $_POST["tick_titulo"],$_POST["tick_descrip"], $_POST["soporte"], $_POST["supervisor"]);
            if (is_array($datos)==true and count($datos)>0){
                foreach ($datos as $row){
                    $output["tick_id"] = $row["tick_id"];
                    

                    if ($_FILES['files']['name']==0){

                    }else{
                        $countfiles = count($_FILES['files']['name']);
                        $ruta = "../public/document/".$output["tick_id"]."/";
                        $files_arr = array();

                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES['files']['tmp_name'][$index];
                            $destino = $ruta.$_FILES['files']['name'][$index];

                            $documento->insert_documento( $output["tick_id"],$_FILES['files']['name'][$index]);

                            move_uploaded_file($doc1,$destino);
                        }
                    }
                }
            }
            echo json_encode($datos);
        break;

        case "update":
            $ticket->update_ticket($_POST["tick_id"]);
            $ticket->insert_ticketdetalle_cerrar($_POST["tick_id"],$_POST["usu_id"]);
        break;

        case "asignar":
            $ticket->update_ticket_asignacion($_POST["tick_id"],$_POST["usu_asig"]);
        break;

        case "listar_x_usu":
            $datos=$ticket->listar_ticket_x_usu($_POST["usu_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                if ($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

                if($row["fech_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-warning">Sin Asignar</span>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"].'</span>';
                    }
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listar":
            $datos=$ticket->listar_ticket();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                if ($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

                if($row["fech_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"].'</span>';
                    }
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listardetalle":
            $datos=$ticket->listar_ticketdetalle_x_ticket($_POST["tick_id"]);
            ?>
                <?php
                    foreach($datos as $row){
                        ?>
                            <article class="activity-line-item box-typical">
                                <div class="activity-line-date">
                                    <?php echo date("d/m/Y", strtotime($row["fech_crea"]));?>
                                </div>
                                <header class="activity-line-item-header">
                                    <div class="activity-line-item-user">
                                        <div class="activity-line-item-user-photo">
                                            <a href="#">
                                                <img src="../../public/<?php echo $row['rol_id'] ?>.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="activity-line-item-user-name"><?php echo $row['usu_nom'].' '.$row['usu_ape'];?></div>
                                        <div class="activity-line-item-user-status">
                                            <?php 
                                                if ($row['rol_id']==1){
                                                    echo 'Usuario';
                                                }else{
                                                    echo 'Soporte';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </header>
                                <div class="activity-line-action-list">
                                    <section class="activity-line-action">
                                        <div class="time"><?php echo date("H:i:s", strtotime($row["fech_crea"]));?></div>
                                        <div class="cont">
                                            <div class="cont-in">
                                                <p>
                                                    <?php echo $row["tickd_descrip"];?>
                                                </p>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </article>
                        <?php
                    }
                ?>
            <?php
        break;

        case "mostrar";
            $datos=$ticket->listar_ticket_x_id($_POST["tick_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tick_id"] = $row["tick_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["cat_id"] = $row["cat_id"];

                    $output["tick_titulo"] = $row["tick_titulo"];
                    $output["tick_descrip"] = $row["tick_descrip"];

                    $output["tipo_solicitud_id"]=$row["tipo_solicitud_id"];
                    $output["sucursal_id"]=$row["sucursal_id"];
                    $output["prioridad_id"]=$row["prioridad_id"];
                    $output["area_id"]=$row["area_id"];
                    $output["subCategoria"]=$row["subCategoria"];
                    $output["articulo_subcat"]=$row["articulo_subcat"];

                    if ($row["tick_estado"]=="Abierto"){
                        $output["tick_estado"] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $output["tick_estado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $output["tick_estado_texto"] = $row["tick_estado"];

                    $output["fech_crea"] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["cat_nom"] = $row["cat_nom"];
                }
                echo json_encode($output);
            }   
        break;

        case "insertdetalle":
            $ticket->insert_ticketdetalle($_POST["tick_id"],$_POST["usu_id"],$_POST["tickd_descrip"]);
        break;

        case "total";
            $datos=$ticket->get_ticket_total();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalabierto";
            $datos=$ticket->get_ticket_totalabierto();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalcerrado";
            $datos=$ticket->get_ticket_totalcerrado();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "grafico";
            $datos=$ticket->get_ticket_grafico();  
            echo json_encode($datos);
        break;

    }
?>