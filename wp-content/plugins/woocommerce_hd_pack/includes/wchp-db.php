<?php
/**
 * @author: Pavlovskiy 
 * @date:   13.05.15
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
class WCHP_Db {

    private static $db;

//    public static function get_category_params($cat_id)
//    {
//        return self::$db->get_results('SELECT * FROM '.self::$db->base_prefix . 'woocommerce_termmeta WHERE woocommerce_term_id = '.$id.' AND meta_key = "hd_status"',ARRAY_A);
//    }

    public static function insert_category_param($id, $key, $value)
    {
        $key = str_replace('"', '\'', $key);
        $value = str_replace('"', '\'', $value);

        return self::$db->query('INSERT INTO '.self::$db->base_prefix . 'woocommerce_termmeta (woocommerce_term_id,meta_key,meta_value) VALUES ("'.$id.'","'.$key.'","'.$value.'")');
    }

    public static function update_category_param($id, $key, $value)
    {
        $key = str_replace('"', '\'', $key);
        $value = str_replace('"', '\'', $value);

        return self::$db->query('UPDATE '.self::$db->base_prefix . 'woocommerce_termmeta SET meta_value = "'.$value.'" WHERE woocommerce_term_id = '.$id.' AND meta_key = "'.$key.'"');
    }


    public static function get_meta_value($id, $key)
    {
        $key = str_replace('"', '\'', $key);

        return self::$db->get_results('SELECT meta_value FROM '.self::$db->base_prefix . 'woocommerce_termmeta WHERE woocommerce_term_id = '.$id.' AND meta_key = "'.$key.'"',ARRAY_A);
    }


    public static function get_product_category_by_id( $category_id ) {
        $term = get_term_by( 'id', $category_id, 'product_cat', 'ARRAY_A' );
        return $term;
    }

    public static function get_category_term_meta($cat_id)
    {
        return self::$db->get_results('SELECT meta_key, meta_value FROM '.self::$db->base_prefix . 'woocommerce_termmeta WHERE woocommerce_term_id = '.$cat_id,ARRAY_A);
    }

    public static function init(){
        if(empty($db)){
            global $wpdb;
            self::$db = $wpdb;
        }
    }

    public static function valid_row($value, $meta_key)
    {
        $conf = array(
            'hd_cat_template' => array(
                'category',
                'product'
            )
        );

        return isset($conf[$meta_key]) && in_array($value,$conf[$meta_key]);
    }

    public static function install()
    {
        $table_cat_images = self::$db->base_prefix.'wchp_cat_images';


        if(self::$db->get_var('SHOW TABLES LIKE "'.$table_cat_images.'"') != $table_cat_images){
            $sql = "CREATE TABLE {$table_cat_images} (
                    id int(11) NOT NULL auto_increment,
                    cat_id int(11) NOT NULL ,
                    url varchar(255) NOT NULL,
                    PRIMARY KEY  (id)
                    ) ;";
            self::$db->query( $sql );
        }
    }

    public static function get_category_images($id)
    {
        return self::$db->get_results('SELECT * FROM '.self::$db->base_prefix.'wchp_cat_images WHERE cat_id = '.$id,ARRAY_A);
    }

    public static function delete_images($cat_id,$id_list)
    {
        $id_list = implode($id_list,',');
        return self::$db->query('DELETE FROM '.self::$db->base_prefix.'wchp_cat_images WHERE cat_id = '.$cat_id.' AND id IN('.$id_list.')');
    }

    public static function save_cat_image($cat_id,$src)
    {
        return self::$db->query('INSERT INTO '.self::$db->base_prefix.'wchp_cat_images (cat_id, url) VALUES ("'.$cat_id.'","'.$src.'")');
    }
}

WCHP_Db::init();