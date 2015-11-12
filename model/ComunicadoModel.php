<?php
class ComunicadoModel
{

	 private $message;	
public function __construct()
	{	
		$this->message =0;
	}// fin function __construct

/**
         * allow the controller to modify this property
         *
         * @package MVC Example
         * @subpackage FooModel
         * @param string $newMessage
         * @since0.1
         */
        public function set_Categoria( $newMessage )
        {
            $this->message = $newMessage;
        }
 
        /**
         * retrieve the message
         *
         * @package MVC Example
         * @subpackage FooModel
         * @return string $message
         * @since 0.1
         */
        public function get_Categoria($CatgoriaComunicado)
        {
            //return $this->message;
         global $wpdb;																//like '".$estado_1."'
		$WP_term_id = $wpdb->get_row( "SELECT term_id FROM $wpdb->terms WHERE slug = '".$CatgoriaComunicado."'", ARRAY_N );
		$ID_Categoria=(int)$WP_term_id[0];
		return $ID_Categoria;
                        
            
        }



}//fin  ProyectoModel

?>