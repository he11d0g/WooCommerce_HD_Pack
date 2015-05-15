<?php
/**
 * @author: he11d0g
 * @date:   12.05.15
 */
class WCHP_Action {

    public function __construct ()
    {
        $this->add_actions();
    }

    private function add_actions()
    {
        add_action('product_cat_add_form_fields',array($this,'show_params'));
        add_action('edit_tag_form',array($this,'show_params'));
        add_action('edited_terms',array($this,'save_category'));
    }

    private function format_request_data()
    {
        $data = array(
            'hd_status' => isset($_REQUEST['hd_status']) && $_REQUEST['hd_status'] == 'on' ? 1 : 0,
            'hd_cat_template' => isset($_REQUEST['hd_cat_template']) && WCHP_Db::valid_row($_REQUEST['hd_cat_template'],'hd_cat_template') ? $_REQUEST['hd_cat_template'] : 0,
            'wchp_cat_images' => isset($_REQUEST['wchp_cat_images']) ? $_REQUEST['wchp_cat_images'] : array(),
        );

        return $data;
    }

    private function format_array($array,$key,$val){
        $out = array();
        foreach($array as $item){
            if(isset($item[$key],$item[$val])){
                $out[$item[$key]] = $item[$val];
            }
        }
        return $out;
    }

    private static function prepare_meta_params ( $params, $must_hve_keys = array())
    {
        $result = array();
        foreach($params as $param){
            $result[$param['meta_key']] = $param['meta_value'];
        }

        return $result;
    }


    /** Actions **/
    public function show_params()
    {
        $id = $_REQUEST['tag_ID'];
        $locale = get_locale();
        $params = self::prepare_meta_params(WCHP_Db::get_category_term_meta($id));
        $selected = isset($params['hd_cat_template']) ? $params['hd_cat_template'] : false;
        $img_list = WCHP_Db::get_category_images($id);
        $dropdown = WCHP_Helper::dropdown('hd_cat_template',array(
            'category' => __('Category',$locale),
            'product' => __('Product',$locale),
        ),$selected,'','export');

        include  WCHP_PATH . "/view/admin/category/default.php";
    }


    public function save_category()
    {
        if(isset($_REQUEST['tag_ID'],$_REQUEST['taxonomy'])){
            $data = $this->format_request_data();
            if ( !empty($data) ){
                $id = $_REQUEST['tag_ID'];
                $params = WCHP_Db::get_meta_value($id, 'hd_status');
                if(empty($params)){
                    foreach($data as $k => $v){
                        WCHP_Db::insert_category_param($id, $k, $v);
                    }
                } else {
                    foreach($data as $k => $v){
                        WCHP_Db::update_category_param($id, $k, $v);
                    }
                }

                $images = self::format_array(WCHP_Db::get_category_images($id),'url','id');
                if(!empty($data['wchp_cat_images'])){
                    foreach($data['wchp_cat_images'] as $src){
                        if(!isset($images[$src])){
                            WCHP_Db::save_cat_image($id, $src);
                        }
                    }
                }
                //delete
                $del_img_list = array();
                foreach($images as $k => $v){
                    if(!in_array($k,$data['wchp_cat_images'])){
                        $del_img_list[] = $v;
                    }
                }
                if($del_img_list){
                    WCHP_Db::delete_images($id, $del_img_list);
                }

            }
        }
    }

}

new WCHP_Action();
