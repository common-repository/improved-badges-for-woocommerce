<?php

if (!defined('ABSPATH'))
  exit;

if (!class_exists('IBFW_back')) {

    class IBFW_back {

        protected static $instance;
       
        function IBFW_create_custpost() {
            $post_type = 'ibfw_product_label';
            $singular_name = 'Product Label';
            $plural_name = 'Product Labels';
            $slug = 'ibfw_product_label';
            $labels = array(
                'name'               => _x( $plural_name, 'post type general name', 'improved-badges-for-woocommerce' ),
                'singular_name'      => _x( $singular_name, 'post type singular name', 'improved-badges-for-woocommerce' ),
                'menu_name'          => _x( $singular_name, 'admin menu name', 'improved-badges-for-woocommerce' ),
                'name_admin_bar'     => _x( $singular_name, 'add new name on admin bar', 'improved-badges-for-woocommerce' ),
                'add_new'            => __( 'Add New', 'improved-badges-for-woocommerce' ),
                'add_new_item'       => __( 'Add New '.$singular_name, 'improved-badges-for-woocommerce' ),
                'new_item'           => __( 'New '.$singular_name, 'improved-badges-for-woocommerce' ),
                'edit_item'          => __( 'Edit '.$singular_name, 'improved-badges-for-woocommerce' ),
                'view_item'          => __( 'View '.$singular_name, 'improved-badges-for-woocommerce' ),
                'all_items'          => __( 'All '.$plural_name, 'improved-badges-for-woocommerce' ),
                'search_items'       => __( 'Search '.$plural_name, 'improved-badges-for-woocommerce' ),
                'parent_item_colon'  => __( 'Parent '.$plural_name.':', 'improved-badges-for-woocommerce' ),
                'not_found'          => __( 'No Table found.', 'improved-badges-for-woocommerce' ),
                'not_found_in_trash' => __( 'No Table found in Trash.', 'improved-badges-for-woocommerce' )
            );

            $args = array(
                'labels'             => $labels,
                'description'        => __( 'Description.', 'improved-badges-for-woocommerce' ),
                'public'             => false,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => $slug ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'supports'           => array( 'title' ),
                'menu_icon'          => 'dashicons-awards'
            );
            register_post_type( $post_type, $args );
        }

        function IBFW_add_meta_box() {
            add_meta_box(
                'OCPL_metabox',
                __( 'Label Settings', 'improved-badges-for-woocommerce' ),
                array($this, 'IBFW_metabox_cb'),
                'ibfw_product_label',
                'normal'
            );
        }

        function IBFW_metabox_cb( $post ) {
            // Add a nonce field so we can check for it later.
            wp_nonce_field( 'OCPL_meta_save', 'OCPL_meta_save_nounce' );
            ?> 
            <div class="ocpl_container">
                <ul class="ocpl_tabs">
                    <li class="tab-link current" data-tab="tab-default">
                        <?php echo __( 'Default Settings', 'improved-badges-for-woocommerce' );?>
                    </li>
                    <li class="tab-link" data-tab="tab-data">
                        <?php echo __( 'Label Design', 'improved-badges-for-woocommerce' );?>
                    </li>
                    <li class="tab-link" data-tab="tab-general">
                        <?php echo __( 'Product Settings', 'improved-badges-for-woocommerce' );?>
                    </li>
                    
                </ul>
                <div id="tab-default" class="tab-content current">
                    <div class="attribute_div">
                        <div class="label_div"><?php echo __( 'Show Label', 'improved-badges-for-woocommerce' );?></div>
                        <div class="input_div">
                            <?php
                            $lbl = get_post_meta($post->ID, 'ocpl_show_label', true);

                            if( $lbl == '') {
                                $lbl = 'on';
                            }
                            ?>
                            <input type="checkbox" name="ocpl_show_label" <?php if($lbl == "on") { echo "checked"; } ?>>
                        </div>
                    </div> 
                    <div class="attribute_div">
                        <div class="label_div"><?php echo __( 'Badge Position', 'improved-badges-for-woocommerce' );?></div>
                        <div class="input_div">
                            <?php $bagde_position = get_post_meta($post->ID,'ocpl_image_position',true); ?>
                            <select class="ocpl_image_position regular-text" name="ocpl_image_position">
                                <option value="top_left" <?php if($bagde_position == "top_left") { echo "selected"; } ?>><?php echo __( 'Top-left', 'improved-badges-for-woocommerce' );?></option>
                                <option value="top_right" <?php if($bagde_position == "top_right") { echo "selected"; } ?>><?php echo __( 'Top-Right', 'improved-badges-for-woocommerce' );?></option>
                                <option value="bottom_left" <?php if($bagde_position == "bottom_left") { echo "selected"; } ?>><?php echo __( 'Bottom-left', 'improved-badges-for-woocommerce' );?></option>
                                <option value="bottom_right" <?php if($bagde_position == "bottom_right") { echo "selected"; } ?>><?php echo __( 'Bottom-right', 'improved-badges-for-woocommerce' );?></option>
                                <option value="custom_position" <?php if($bagde_position == "custom_position") { echo "selected"; } ?>><?php echo __( 'Custom Position', 'improved-badges-for-woocommerce' );?></option>
                            </select>
                        </div>
                    </div>
                    <div class="attribute_div custom_position">
                       <div class="label_div"></div>
                        <div class="input_div ocpl_pos_indiv">
                            <?php

                                $top = get_post_meta($post->ID, 'ocpl_top', true); 
                                $left = get_post_meta($post->ID, 'ocpl_left', true); 
                                $right = get_post_meta($post->ID, 'ocpl_right', true); 
                                $bottom = get_post_meta($post->ID, 'ocpl_bottom', true); 

                                if(empty($left)) {
                                    $left = "-20";
                                } else {
                                    $left = $left;
                                }

                                if(empty($right)) {
                                    $right = "0";
                                } else {
                                    $right = $right;
                                }

                                if(empty($top)) {
                                    $top = "-20";
                                } else {
                                    $top = $top;
                                }

                                if(empty($bottom)) {
                                    $bottom = "0";
                                } else {
                                    $bottom = $bottom;
                                }

                            ?>
                            <label><?php echo __( 'Left', 'improved-badges-for-woocommerce' );?></label>
                            <input type="number" class="regular-text" name="ocpl_left" value="<?php echo $left; ?>">
                            <label><?php echo __( 'Right', 'improved-badges-for-woocommerce' );?></label>
                            <input type="number" class="regular-text" name="ocpl_right" value="<?php echo $right; ?>">
                            <label><?php echo __( 'Top', 'improved-badges-for-woocommerce' );?></label>
                            <input type="number" class="regular-text" name="ocpl_top" value="<?php echo $top; ?>">
                            <label><?php echo __( 'Bottom', 'improved-badges-for-woocommerce' );?></label>
                            <input type="number" class="regular-text" name="ocpl_bottom" value="<?php echo $bottom; ?>">
                        </div>
                    </div> 
                    <div class="attribute_div">
                        <div class="label_div"><?php echo __( 'Show Label Single product page', 'improved-badges-for-woocommerce' );?></div>
                        <div class="input_div">
                            <input type="checkbox" name="ocpl_show_label_single_pro" disabled>
                            <label class="IBFW_pro_link"><?php echo __( 'Only available in pro version ', 'improved-badges-for-woocommerce' );?><a href="https://oceanwebguru.com/shop/improved-badges-for-woocommerce-pro/" target="_blank"><?php echo __( 'link', 'improved-badges-for-woocommerce' );?></a></label>
                        </div>
                    </div>  
                </div>
                <div id="tab-data" class="tab-content">
                    <div class="ocpl_inner_container">
                        <ul class="ocpl_inner_tabs">
                            <li class="tab-link" data-tab="tab-text">
                                <input type="radio" id="or_text_badge" class="badge_define" name="badge_define" value="or_text_badge" <?php if(empty(get_post_meta($post->ID,'badge_define',true ))||get_post_meta( $post->ID,'badge_define',true )=="or_text_badge"){ echo "checked=checked"; } ?>><label for="or_text_badge"><?php echo __( 'Text Badge', 'improved-badges-for-woocommerce' );?></label>
                                <?php //echo __( 'Text Badge', 'improved-badges-for-woocommerce' );?>
                            </li>
                            <li class="tab-link" data-tab="tab-image">
                                <input type="radio" id="or_image_badge" class="badge_define" name="badge_define" value="or_image_badge" <?php if(get_post_meta( $post->ID , 'badge_define',true )=="or_image_badge"){ echo "checked=checked"; } ?>><label for="or_image_badge"><?php echo __( 'Image Badge', 'improved-badges-for-woocommerce' );?></label>
                            </li> 
                        </ul>
                        <div id="tab-text" class="tab-contentt">
                            <div class="attribute_div">
                                <div class="label_div"><?php echo __( 'Discount Text', 'improved-badges-for-woocommerce' );?></div>
                                <div class="input_div">
                                    <?php 
                                        $ocpl_discount_text = get_post_meta($post->ID,'ocpl_discount_text',true);
                                        if(empty($ocpl_discount_text)) {

                                            $ocpl_discount_text = "Sale";

                                        } else {

                                            $ocpl_discount_text = $ocpl_discount_text;

                                        }
                                    ?>
                                    <input type="text" class="regular-text" name="ocpl_discount_text" value="<?php echo $ocpl_discount_text; ?>">
                                    <span class="ocpl_desc"><?php echo __( 'Use the <strong>&lt;br&gt;</strong> tag to enter line breaks between words.', 'improved-badges-for-woocommerce' );?></span>
                                </div>
                            </div>
                            <div class="attribute_div">
                                <div class="label_div"><?php echo __( 'Label Font Color', 'improved-badges-for-woocommerce' );?></div>
                                <div class="input_div">
                                    <?php

                                    $ocpl_font_clr = get_post_meta( $post->ID, 'ocpl_font_clr', true);
                                        
                                        if($ocpl_font_clr == '') {
                                            $ocpl_font_clr = '#ffffff';
                                        }

                                    ?>
                                    <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo $ocpl_font_clr; ?>" name="ocpl_font_clr" value="<?php echo $ocpl_font_clr; ?>"/>
                                </div>
                            </div>
                           
                            <div class="attribute_div">
                                <div class="label_div"><?php echo __( 'Background Color', 'improved-badges-for-woocommerce' );?></div>
                                <div class="input_div">
                                    <?php
                                    $ocpl_bg_clr = get_post_meta( $post->ID, 'ocpl_bg_clr', true);
                                        
                                    if($ocpl_bg_clr == '') {
                                        $ocpl_bg_clr = '#000000';
                                    }
                                    ?>
                                    <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo $ocpl_bg_clr; ?>" name="ocpl_bg_clr" value="<?php echo $ocpl_bg_clr; ?>"/>
                                </div>
                            </div>
                            <div class="attribute_div">
                                <div class="label_div"><?php echo __( 'Font Size', 'improved-badges-for-woocommerce' );?></div>
                                <div class="input_div">
                                    <?php 
                                        $ocpl_ft_size = get_post_meta($post->ID,'ocpl_ft_size',true); 
                                        if(empty($ocpl_ft_size)) {
                                            $ft_size = "12";
                                        } else {
                                            $ft_size = $ocpl_ft_size;
                                        }
                                    ?>
                                    <input type="number" class="regular-text" name="ocpl_ft_size" value="<?php echo $ft_size; ?>"> 
                                </div>
                            </div>
                            <div class="attribute_div">
                                <div class="label_div"><?php echo __( 'Label Shape', 'improved-badges-for-woocommerce' );?></div>
                                <div class="input_div">
                                    <?php $shape = get_post_meta($post->ID, 'ocpl_lbl_shape', true); ?>
                                    <label class="layersMenu">
                                        <input type="radio" name="ocpl_lbl_shape" value="square" <?php if($shape == "square" || empty($shape)){ echo "checked"; }?> />
                                        <div class="ibfw_square_data">
                                            <div class="ibfw_square"></div>
                                        </div>
                                    </label>

                                    <label class="layersMenu">
                                        <input type="radio" name="ocpl_lbl_shape" value="rectangle" <?php if($shape == "rectangle"){ echo "checked"; }?>/>
                                        <div class="ibfw_square_data">
                                            <div class="ibfw_rectangle"></div>
                                        </div>
                                    </label>

                                    <label class="layersMenu">
                                        <input type="radio" name="ocpl_lbl_shape" value="rectangle_up" <?php if($shape == "rectangle_up"){ echo "checked"; }?>/>
                                        <div class="ibfw_square_data">
                                            <div class="ibfw_rectangle_up"></div>
                                        </div>
                                    </label>
                                    <label class="layersMenu">
                                        <input type="radio" name="ocpl_lbl_shape" value="offers" <?php if($shape == "offers"){ echo "checked"; }?>/>
                                        <div class="ibfw_square_data">
                                            <div class="ibfw_offers">
                                                <i style="background-color:#dac6c8; border-color:#dac6c8;" class="template-i "></i>            
                                                <i style="background-color:#dac6c8; border-color:#dac6c8;" class="template-i-before "></i>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="layersMenu">
                                        <input type="radio" name="ocpl_lbl_shape" value="tag" <?php if($shape == "tag"){ echo "checked"; }?>/>
                                        <div class="ibfw_square_data">
                                            <div class="ibfw_tag">
                                                <i style="background-color:#8aaae5; border-color:#8aaae5;" class="template-span-before "></i>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="layersMenu">
                                        <input type="radio" name="ocpl_lbl_shape" value="collar" <?php if($shape == "collar"){ echo "checked"; }?>/>
                                        <div class="ibfw_square_data">
                                            <div class="ibfw_collar">
                                                <i style="background-color:#295f2d; border-color:#295f2d;" class="template-span-before "></i>
                                                <i style="background-color:#295f2d; border-color:#295f2d;" class="template-i-after "></i>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="layersMenu">
                                        <input type="radio" name="ocpl_lbl_shape" value="rectangle_round" <?php if($shape == "rectangle_round") { echo "checked"; } ?>/>
                                        <div class="ibfw_square_data">
                                            <div class="ibfw_rectangle_round">
                                            </div>
                                        </div>
                                    </label>

                                    <label class="layersMenu">
                                        <input type="radio" name="ocpl_lbl_shape" value="rectangle_circle" <?php if($shape == "rectangle_circle") { echo "checked"; } ?>/>
                                        <div class="ibfw_square_data">
                                            <div class="ibfw_rectangle_circle">
                                            </div>
                                        </div>
                                    </label>

                                    <label class="layersMenu">
                                        <input type="radio" name="ocpl_lbl_shape" value="circle" <?php if($shape == "circle") { echo "checked"; }?> />
                                        <div class="ibfw_square_data">
                                            <div class="ibfw_circle">
                                            </div>
                                        </div>
                                    </label>

                                    <label class="layersMenu">
                                        <input type="radio" name="ocpl_lbl_shape" value="corner_badge" <?php if($shape == "corner_badge"){ echo "checked"; }?>/>
                                        <div class="ibfw_square_data">
                                            <div class="ibfw_corner_badge">
                                                <i style="background-color:#adf0d1; border-color:#adf0d1;" class="template-i-before "></i>
                                                <i class="template-i-after "></i>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="tab-image" class="tab-contentt">

                           

                            <div class="attribute_div">
                                <div class="label_div"><?php echo __( 'Image Badge select', 'improved-badges-for-woocommerce' );?></div>
                                <div class="input_div">
                                    <?php //print_r(get_post_meta($post->ID, 'ibfw_background' ,true )); ?>
                                    <input type="radio" class="radioBtnClass_badge" name="ibfw_background" value="or_badge_image" <?php if(empty(get_post_meta($post->ID, 'ibfw_background' ,true ))|| get_post_meta( $post->ID , 'ibfw_background',true )=="or_badge_image"){ echo "checked=checked"; } ?>><lable><strong><?php echo __( 'Badge Select', 'improved-badges-for-woocommerce' );?></strong></lable>

                                    <input type="radio" class="radioBtnClass_badge" name="ibfw_background" value="or_badge_image_upload" <?php if(get_post_meta( $post->ID,'ibfw_background',true )=="or_badge_image_upload"){ echo "checked=checked"; } ?>><lable><strong><?php echo __( 'Custom Badge Add', 'improved-badges-for-woocommerce' );?></strong></lable>
                                    <div class="ibfw_back_badge">
                                        <input type="radio" name="image_badge" value="badge.png" <?php if(empty(get_post_meta($post->ID, 'image_badge' ,true ))|| get_post_meta( $post->ID , 'image_badge',true )=="badge.png"){ echo "checked=checked"; } ?>>
                                        <label>
                                           <img src="<?php echo IBFW_PLUGIN_DIR; ?>/includes/images/badge.png" class="ocscw_badge">
                                        </label>
                                          <input type="radio" name="image_badge" value="badge1.png"  <?php if(get_post_meta( $post->ID,'image_badge',true )=="badge1.png"){ echo "checked=checked"; } ?>>
                                        <label>
                                           <img src="<?php echo IBFW_PLUGIN_DIR; ?>/includes/images/badge1.png" class="ocscw_badge">
                                        </label>
                                        <input type="radio" name="image_badge" value="badge2.png" <?php if(get_post_meta( $post->ID,'image_badge',true )=="badge2.png"){ echo "checked=checked"; } ?>>
                                        <label>
                                           <img src="<?php echo IBFW_PLUGIN_DIR; ?>/includes/images/badge2.png" class="ocscw_badge">
                                        </label>
                                        <input type="radio" name="image_badge" value="badge3.png" <?php if(get_post_meta( $post->ID,'image_badge',true )=="badge3.png"){ echo "checked=checked"; } ?>>
                                        <label>
                                           <img src="<?php echo IBFW_PLUGIN_DIR; ?>/includes/images/badge3.png" class="ocscw_badge">
                                        </label>
                                    </div>
                                    <div class="ocpsw_back_img_class">
                                        <?php  
                                            echo $this->IBFW_image_uploader_field('ocor_bg_img_form',get_post_meta( $post->ID, 'ocor_bg_img_form', true) );
                                        
                                           ?>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div id="tab-general" class="tab-content">
                    <div class="attribute_div">
                        <div class="label_div"><?php echo __( 'Condition', 'improved-badges-for-woocommerce' );?></div>
                        <div class="input_div">
                            <?php $pro_con = get_post_meta($post->ID,'ocpl_pro_condition',true); ?>
                            <select class="ocpl_pro_condition regular-text" name="ocpl_pro_condition">
                                <option value=""><?php echo __( 'Select Option', 'improved-badges-for-woocommerce' );?></option>
                                <option value="all_products" <?php if($pro_con == "all_products") { echo "selected"; } ?>><?php echo __( 'All Products', 'improved-badges-for-woocommerce' );?></option>
                                <option value="selected_products" <?php if($pro_con == "selected_products") { echo "selected"; } ?>><?php echo __( 'Selected Products', 'improved-badges-for-woocommerce' );?></option>
                                <option value="price" <?php if($pro_con == "price") { echo "selected"; } ?>><?php echo __( 'Price', 'improved-badges-for-woocommerce' );?></option>
                                <option value="category" <?php if($pro_con == "category") { echo "selected"; } ?>><?php echo __( 'Category', 'improved-badges-for-woocommerce' );?></option>
                                <option value="tag" <?php if($pro_con == "tag") { echo "selected"; } ?>><?php echo __( 'Tag', 'improved-badges-for-woocommerce' );?></option>
                                <option value="onsale" <?php if($pro_con == "onsale") { echo "selected"; } ?>><?php echo __( 'On Sale', 'improved-badges-for-woocommerce' );?></option>
                            </select>
                        </div>
                    </div>   
                    <div class="attribute_div ocpl_badge_cond">
                        <div class="child_div ocpl_price_div" style="display: none;">
                            <h2 class="des_head">Price</h2>
                            <label style="opacity: .7;"><?php echo __( 'Price', 'improved-badges-for-woocommerce' );?></label>
                            <select class="ocpl_price_condition regular-text" name="ocpl_price_condition" disabled>
                                <option value="between"><?php echo __( 'Between', 'improved-badges-for-woocommerce' );?></option>
                                <option value="lessthan" selected><?php echo __( 'Less than', 'improved-badges-for-woocommerce' );?></option>
                                <option value="greaterthan"><?php echo __( 'Greater than', 'improved-badges-for-woocommerce' );?></option>
                            </select>
                            <div class="ocpl_price_between_div">
                                <div class="ocpl_prbtwn">
                                    <label style="opacity: .7;"><?php echo __( 'Minimum Price', 'improved-badges-for-woocommerce' );?></label>
                                    <input type="number" class="regular-text" name="ocpl_bet1" value="" disabled>
                                </div>
                                <div class="ocpl_prbtwn">
                                    <label style="opacity: .7;"><?php echo __( 'Maximum Price', 'improved-badges-for-woocommerce' );?></label>
                                    <input type="number" class="regular-text" name="ocpl_bet2" value="" disabled>
                                </div>
                            </div>
                            <div class="ocpl_price_single_div" style="display: none;">
                                <label style="opacity: .7;"><?php echo __( 'Price', 'improved-badges-for-woocommerce' );?></label>
                                <input type="number" class="regular-text" name="ocpl_price" value="" disabled>
                            </div>
                            <label class="IBFW_pro_link"><?php echo __( 'Only available in pro version ', 'improved-badges-for-woocommerce' );?><a href="https://oceanwebguru.com/shop/improved-badges-for-woocommerce-pro/" target="_blank"><?php echo __( 'link', 'improved-badges-for-woocommerce' );?></a></label> 
                        </div>
                        <div class="child_div ocpl_product_div" style="display: none;">
                            <h2 class="des_head"><?php echo __( 'Products', 'improved-badges-for-woocommerce' );?></h2>
                            <select id="ibfw_select_product" name="ibfw_select2[]" multiple="multiple" style="width:100%;">
                                <?php 
                                $productsa = get_post_meta($post->ID,'ibfw_combo',true);

                                if(!empty($productsa)) {

                                        foreach ($productsa as $value) {
                                            $productc = wc_get_product($value);
                                            if ( $productc && $productc->is_in_stock() && $productc->is_purchasable() ) {
                                                    $title = $productc->get_name();?>
                                                    <option value="<?php echo $value; ?>" selected="selected"><?php echo $title; ?></option>
                                                <?php
                                            }
                                        }

                                }
                                ?>
                            </select> 
                        </div>
                        <div class="child_div ocpl_category_div" style="display: none;">
                            <h2 class="des_head"><?php echo __( 'Category', 'improved-badges-for-woocommerce' );?></h2>
                            <?php
                                $orderby = 'name';
                                $order = 'asc';
                                $hide_empty = false;
                                $cat_args = array(
                                    'orderby'    => $orderby,
                                    'order'      => $order,
                                    'hide_empty' => $hide_empty,
                                );
                                $ocpl_categories = get_terms( 'product_cat', $cat_args );
                                $category = get_post_meta($post->ID,'ocpl_cat',true);
                                foreach( $ocpl_categories as $ocpl_category ) {
                                    ?>
                                    <div class="ocpl_catlist">
                                    <input type="checkbox" name="ocpl_cat[]" value="<?php echo $ocpl_category->term_id;?>"  disabled>
                                    <label style="opacity: .7"><?php echo $ocpl_category->name;?></label>
                                    </div>
                                    <?php 
                                } 
                            ?>  
                            <label class="IBFW_pro_link"><?php echo __( 'Only available in pro version ', 'improved-badges-for-woocommerce' );?><a href="https://oceanwebguru.com/shop/improved-badges-for-woocommerce-pro/" target="_blank"><?php echo __( 'link', 'improved-badges-for-woocommerce' );?></a></label> 
                        </div>
                        <div class="child_div ocpl_tag_div" style="display: none;">
                            <h2 class="des_head"><?php echo __( 'Tag', 'improved-badges-for-woocommerce' );?></h2>
                            <?php
                                $ocpl_tags = $terms = get_terms(array('taxonomy' => 'product_tag', 'hide_empty' => false));
                                $tag = get_post_meta($post->ID,'ocpl_tag',true);
                                foreach( $ocpl_tags as $ocpl_tag ) {
                                    ?>
                                    <div class="ocpl_catlist">
                                        <input type="checkbox" name="ocpl_tag[]" value="<?php echo $ocpl_tag->term_id;?>" <?php if(!empty($tag) && in_array($ocpl_tag->term_id,$tag)){echo "checked";} ?>>
                                        <label>
                                            <?php echo $ocpl_tag->name;?>
                                        </label>
                                    </div>
                                    <?php 
                                } 
                            ?>
                        </div>
                        <div class="child_div ocpl_onsale_div" style="display: none;">
                            <h2 class="des_head"><?php echo __( 'Onsale', 'improved-badges-for-woocommerce' );?></h2>
                            <?php $on_sale = get_post_meta($post->ID,'ocpl_onsale',true); ?>
                            <label><?php echo __( 'Is on Sale', 'improved-badges-for-woocommerce' );?></label>
                            <select name="ocpl_onsale" class="ocpl_onsale regular-text">
                                <option value="no" <?php if($on_sale == "no") { echo "selected"; } ?>><?php echo __( 'No', 'improved-badges-for-woocommerce' );?></option>
                                <option value="yes" <?php if($on_sale == "yes") { echo "selected"; } ?>><?php echo __( 'Yes', 'improved-badges-for-woocommerce' );?></option>
                            </select>
                        </div>
                    </div>          
                </div>
            </div>
            <?php
        }

        function  IBFW_image_uploader_field($name, $value = '') {
                $image = ' button">Upload image';
                $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
                $display = 'none'; // display state ot the "Remove image" button

               
                return '
                <div>
                    <a href="#"  class="misha_upload_image_button image_disbledataa' . $image . '</a>
                   <label class="IBFW_pro_link">Only available in pro version <a href="https://oceanwebguru.com/shop/improved-badges-for-woocommerce-pro/" target="_blank">link</a></label>
                </div>';

        }

        function IBFW_product_ajax() {
      
            $return = array();
            $post_types = array( 'product','product_variation');
            $search_results = new WP_Query( array( 
                's'=> $_GET['q'],
                'post_status' => 'publish',
                'post_type' => $post_types,
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => '_stock_status',
                        'value' => 'instock',
                        'compare' => '=',
                    )
                )
            ));

            if( $search_results->have_posts() ) {
                while( $search_results->have_posts() ){
                    $search_results->the_post();   
                    $productc = wc_get_product( $search_results->post->ID );
                    if ( $productc && $productc->is_in_stock() && $productc->is_purchasable() ) {
                        $title = $search_results->post->post_title;
                        //print_r( $title);
                        // $price = $productc->get_price_html();
                        if ( $productc->is_type( "variable" ) ) {
                            foreach ( $productc->get_children( false ) as $child_id ) {
                                $variation = wc_get_product( $child_id ); 
                                if ( ! $variation || ! $variation->exists() ) {
                                    continue;
                                }
                                $title = $variation->get_name();
                            }
                        } else {
                            $title = $search_results->post->post_title;
                        }                       
                        $price=$productc->get_price_html();                     
                        $return[] = array( $search_results->post->ID, $title , $price);   
                    }
                }
            }

            echo json_encode( $return );
            die;
        }

        function IBFW_meta_save( $post_id, $post ){
            // the following line is needed because we will hook into edit_post hook, so that we can set default value of checkbox.
            if ($post->post_type != 'ibfw_product_label') {return;}
            // Is the user allowed to edit the post or page?
            if ( !current_user_can( 'edit_post', $post_id )) return;
            // Perform checking for before saving
            $is_autosave = wp_is_post_autosave($post_id);
            $is_revision = wp_is_post_revision($post_id);
            $is_valid_nonce = (isset($_POST['OCPL_meta_save_nounce']) && wp_verify_nonce( $_POST['OCPL_meta_save_nounce'], 'OCPL_meta_save' )? 'true': 'false');

            if ( $is_autosave || $is_revision || !$is_valid_nonce ) return;

            /*=======================Label Setting================================*/
            $ocpl_show_label = sanitize_text_field( $_REQUEST['ocpl_show_label'] );

            if(isset($_REQUEST['ocpl_show_label']) && $_REQUEST['ocpl_show_label'] == 'on') {
                $ocpl_show_label = sanitize_text_field( $_REQUEST['ocpl_show_label'] );
            } else {
                $ocpl_show_label = 'off';
            }

            update_post_meta($post_id, 'ocpl_show_label', $ocpl_show_label);
            

            $ocpl_left   = sanitize_text_field( $_REQUEST['ocpl_left']); 
            $ocpl_right  = sanitize_text_field( $_REQUEST['ocpl_right']); 
            $ocpl_top    = sanitize_text_field( $_REQUEST['ocpl_top']);
            $ocpl_bottom = sanitize_text_field( $_REQUEST['ocpl_bottom']);  
            update_post_meta($post_id, 'ocpl_left', $ocpl_left);
            update_post_meta($post_id, 'ocpl_right', $ocpl_right);
            update_post_meta($post_id, 'ocpl_top', $ocpl_top);
            update_post_meta($post_id, 'ocpl_bottom', $ocpl_bottom);

            $ocpl_allowed_html = array(
              'br' => array()
            );
            $ocpl_discount_text = wp_kses( $_REQUEST['ocpl_discount_text'], $ocpl_allowed_html );
            update_post_meta($post_id, 'ocpl_discount_text', $ocpl_discount_text);

           
            $badge_define = sanitize_text_field( $_REQUEST['badge_define'] );
            update_post_meta($post_id, 'badge_define', $badge_define);
            

            /*====================Design Setting==================================*/
            $ocpl_font_clr = sanitize_text_field( $_REQUEST['ocpl_font_clr'] );
            update_post_meta($post_id, 'ocpl_font_clr', $ocpl_font_clr);

            $ocpl_bg_clr = sanitize_text_field( $_REQUEST['ocpl_bg_clr'] );
            update_post_meta($post_id, 'ocpl_bg_clr', $ocpl_bg_clr);

            $ocpl_ft_size = sanitize_text_field( $_REQUEST['ocpl_ft_size'] );
            update_post_meta($post_id, 'ocpl_ft_size', $ocpl_ft_size);

          

            $ocpl_lbl_shape = sanitize_text_field( $_REQUEST['ocpl_lbl_shape'] );
            update_post_meta($post_id, 'ocpl_lbl_shape', $ocpl_lbl_shape);

            /*====================Design Setting==================================*/
            $ocpl_pro_condition = sanitize_text_field( $_REQUEST['ocpl_pro_condition'] );
            update_post_meta($post_id, 'ocpl_pro_condition', $ocpl_pro_condition);

            $ocpl_image_position = sanitize_text_field( $_REQUEST['ocpl_image_position'] );
            update_post_meta($post_id, 'ocpl_image_position', $ocpl_image_position);

            /*---price---*/

            /*---tag---*/
            $ocpl_tag = $this->recursive_sanitize_text_field( $_REQUEST['ocpl_tag'] );
            update_post_meta($post_id, 'ocpl_tag', $ocpl_tag);
            /*---tag---*/

            /*---onsale---*/
            $ocpl_onsale = sanitize_text_field( $_REQUEST['ocpl_onsale'] );
            update_post_meta($post_id, 'ocpl_onsale', $ocpl_onsale);
            /*---onsale---*/

            update_post_meta($post_id,'ibfw_background', sanitize_text_field( $_REQUEST['ibfw_background']));

            update_post_meta($post_id,'image_badge', sanitize_text_field( $_REQUEST['image_badge']));

            if(!empty($_REQUEST['ibfw_select2'])) {
                $ibfw_combo = $this->recursive_sanitize_text_field( $_REQUEST['ibfw_select2'] );
                update_post_meta($post_id,'ibfw_combo', $ibfw_combo);
            } else {
                update_post_meta($post_id,'ibfw_combo', '');
            }
            
        }


        function recursive_sanitize_text_field($array) {
            foreach ( $array as $key => &$value ) {
                if ( is_array( $value ) ) {
                    $value = $this->recursive_sanitize_text_field($value);
                }else{
                    $value = sanitize_text_field( $value );
                }
            }
            return $array;
        }


        function IBFW_support_rating_donate_notice() {
            $screen = get_current_screen();
            if( 'ibfw_product_label' == $screen->post_type ) {
                ?>
                <div class="ibfw_ratesup_notice_main">
                    <div class="ibfw_rateus_notice">
                        <div class="ibfw_rtusnoti_left">
                            <h3><?php echo __( 'Rate Us', 'improved-badges-for-woocommerce' );?></h3>
                            <label><?php echo __( 'If you like our plugin, ', 'improved-badges-for-woocommerce' );?></label>
                            <a target="_blank" href="https://wordpress.org/support/plugin/improved-badges-for-woocommerce/reviews/?filter=5#new-post">
                                <label><?php echo __( 'Please vote us', 'improved-badges-for-woocommerce' );?></label>
                            </a>
                            <label><?php echo __( ', so we can contribute more features for you.', 'improved-badges-for-woocommerce' );?></label>
                        </div>
                        <div class="ibfw_rtusnoti_right">
                            <img src="<?php echo IBFW_PLUGIN_DIR; ?>/includes/images/review.png" class="ocscw_review_icon">
                        </div>
                    </div>
                    <div class="ibfw_support_notice">
                        <div class="ibfw_rtusnoti_left">
                            <h3><?php echo __( 'Having Issues?', 'improved-badges-for-woocommerce' );?></h3>
                            <label><?php echo __( 'You can contact us at', 'improved-badges-for-woocommerce' );?></label>
                            <a target="_blank" href="https://oceanwebguru.com/contact-us/">
                                <label><?php echo __( 'Our Support Forum', 'improved-badges-for-woocommerce' );?></label>
                            </a>
                        </div>
                        <div class="ibfw_rtusnoti_right">
                            <img src="<?php echo IBFW_PLUGIN_DIR; ?>/includes/images/support.png" class="ocscw_review_icon">
                        </div>
                    </div>
                </div>
                <div class="ibfw_donate_main">
                   <img src="<?php echo IBFW_PLUGIN_DIR; ?>/includes/images/coffee.svg">
                   <h3><?php echo __( 'Buy me a Coffee !', 'improved-badges-for-woocommerce' );?></h3>
                   <p><?php echo __( 'If you like this plugin, buy me a coffee and help support this plugin !', 'improved-badges-for-woocommerce' );?></p>
                   <div class="ibfw_donate_form">
                      <a class="button button-primary ocwg_donate_btn" href="https://www.paypal.com/paypalme/shayona163/" data-link="https://www.paypal.com/paypalme/shayona163/" target="_blank"><?php echo __( 'Buy me a coffee !', 'improved-badges-for-woocommerce' );?></a>
                   </div>
                </div>
                <?php
            }
        }


        function init() {
            add_action('init', array($this, 'IBFW_create_custpost'));
            add_action('add_meta_boxes', array($this, 'IBFW_add_meta_box'));
            add_action( 'edit_post', array($this, 'IBFW_meta_save'), 10, 2);
            add_action( 'admin_notices', array($this, 'IBFW_support_rating_donate_notice' ));
            add_action( 'wp_ajax_nopriv_ibfw_product_ajax',array($this, 'IBFW_product_ajax') );
            add_action( 'wp_ajax_ibfw_product_ajax', array($this, 'IBFW_product_ajax') );
        }

        public static function instance() {
            if (!isset(self::$instance)) {
                self::$instance = new self();
                self::$instance->init();
            }
            return self::$instance;
        }
    }
    IBFW_back::instance();
}