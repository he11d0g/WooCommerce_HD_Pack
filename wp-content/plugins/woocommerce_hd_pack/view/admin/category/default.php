<?php
/**
 * @author: Pavlovskiy
 * @date:   12.05.15
 */
?>
<div>
    <hr>
    <h3> <?php _e('HD Options',$locale);?></h3>
    <div class="form-field term-name-wrap">
        <input name="hd_status" id="hd_status" type="checkbox" <?php echo !empty($params['hd_status']) ? 'checked' : ''?>><?php _e('Status',$locale);?>
        <p><?php _e('Enable/Disable additional options',$locale);?></p>
    </div>
    <div class="form-field term-name-wrap">
        <label>Template</label>
        <?php echo $dropdown?>
        <p><?php _e('Category view template',$locale);?></p>
    </div>
    <a class="wchp_test_media media-button button"><?php _e('Add images',$locale);?></a>
    <div class="hd_image_list">
        <?php foreach($img_list as $img) {?>
            <div class="hd_image_thumb" style="float:left;padding:5px" data-url="<?php echo $img['url']?>"><div><img src="<?php echo $img['url']?>" width="100" height="100"></div><input type="hidden" name="wchp_cat_images[]" value="<?php echo $img['url']?>"></div>
        <?php }?>
    </div>
    <br />
</div>

<?php do_action('whcp_product_cat_register_script')?>