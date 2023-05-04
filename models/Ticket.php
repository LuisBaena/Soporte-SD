<?php
    class Ticket extends Conectar{

        //OBTIENE EL TIPO DE SOLICITUD EN LISTADO COMO PARAMETRO ACTIVA
        public function get_tiposolicitud(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_tiposolicitud WHERE est=1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        public function get_listarsucursal(){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_sucursal WHERE est=1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_listararea(){
            $conectar=parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_area WHERE est=1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //OBTIENE LA CATEGORIA PRINCIPAL EN LISTADO COMO PARAMETRO ACTIVA
        public function get_categoria(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_categoria WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //OBTIENE LA SUBCATEGORIA A LA QUE PERTENECE LA CATEGORIA PRINCIPAL
        public function listarSubCategoria($idCategoria){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT tm_subcategoria.* FROM tm_subcategoria 
            INNER JOIN tm_categoria ON tm_subcategoria.cat_id =tm_categoria.cat_id 
            WHERE tm_subcategoria.cat_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idCategoria);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //OBTIENE LA SUBCATEGORIA A LA QUE PERTENECE LA CATEGORIA PRINCIPAL
        public function listarArticuloSubCategoria($idSubCategoria){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_articulo 
            WHERE id_subCategoria=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idSubCategoria);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }

        public function get_rolSoporte(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_categoria WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticket($usu_id,$tipoSolicitud,$sucursal,$areas,$prioridad,$cat_id,$subcat_id,
                                    $articulo_id,$tick_titulo,$tick_descrip,$soporte,$supervisor){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_ticket
                    VALUES(NULL,?,?,?,?,?,?,?,?,?,?,?,?,'Abierto',now(),now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->bindValue(2, $tipoSolicitud);
            $sql->bindValue(3, $sucursal);
            $sql->bindValue(4, $areas);
            $sql->bindValue(5, $prioridad);

            $sql->bindValue(6, $cat_id);
            $sql->bindValue(7, $subcat_id);
            $sql->bindValue(8, $articulo_id);
            
            $sql->bindValue(9, $tick_titulo);
            $sql->bindValue(10, $tick_descrip);
            $sql->bindValue(11, $soporte);
            $sql->bindValue(12, $supervisor); 
         
            $sql->execute();

            $sql1="select last_insert_id() as 'tick_id';";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
            return $resultado=$sql1->fetchAll(pdo::FETCH_ASSOC);
        }

        public function listar_ticket_x_usu($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_estado,
                tm_ticket.fech_crea,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_categoria.cat_nom
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                WHERE
                tm_ticket.est = 1
                AND tm_usuario.usu_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
       

        public function listar_ticket_x_id($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            tm_ticket.tick_id,
            tm_ticket.usu_id,
            tm_ticket.id_tipo,
            tm_ticket.id_sucursal,
            tm_ticket.id_area,
            tm_ticket.tick_prioridad,            
            tm_ticket.cat_id,
            tm_ticket.id_subcat,
            tm_ticket.id_articulo_sub,
            tm_ticket.tick_titulo,
            tm_ticket.tickd_descrip,
            tm_ticket.est,
            tm_ticket.fech_crea,

            tm_usuario.usu_nom,
            tm_usuario.usu_ape,
            tm_usuario.usu_correo,
            tm_ticket.usu_asig,
            tm_categoria.cat_nom,
            tm_subcategoria.subcat_nom,
            tm_articulo.articulo_subcat            
            FROM 
            tm_ticket
            INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
            INNER join tm_subcategoria on tm_ticket.id_subcat = tm_subcategoria.id_subcategoria
            INNER join tm_articulo on tm_ticket.id_articulo_sub = tm_articulo.id_articulo_sub	
                             
            INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
           
            WHERE
            tm_ticket.est = 1
            AND tm_ticket.tick_id =?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        public function listar_ticket(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_estado,
                tm_ticket.fech_crea,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_categoria.cat_nom
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                WHERE
                tm_ticket.est = 1
                ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticketdetalle_x_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
                td_ticketdetalle.tickd_id,
                td_ticketdetalle.tickd_descrip,
                td_ticketdetalle.fech_crea,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.rol_id
                FROM 
                td_ticketdetalle
                INNER join tm_usuario on td_ticketdetalle.usu_id = tm_usuario.usu_id
                WHERE 
                tick_id =?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticketdetalle($tick_id,$usu_id,$tickd_descrip){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="INSERT INTO td_ticketdetalle (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) VALUES (NULL,?,?,?,now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->bindValue(3, $tickd_descrip);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticketdetalle_cerrar($tick_id,$usu_id){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="call sp_i_ticketdetalle_01(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="update tm_ticket 
                set	
                    tick_estado = 'Cerrado'
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_ticket_asignacion($tick_id,$usu_asig){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="update tm_ticket 
                set	
                    usu_asig = ?,
                    fech_asig = now()
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_asig);
            $sql->bindValue(2, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_ticket_total(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_ticket_totalabierto(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where tick_estado='Abierto'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_ticket_totalcerrado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where tick_estado='Cerrado'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        public function get_ticket_grafico(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE    
                tm_ticket.est = 1
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        public function get_correo_usuario_asignado_soporte($idTicketAsig){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT usu_correo FROM tm_usuario WHERE usu_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idTicketAsig);            
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>