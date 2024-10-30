<?php

if (!defined('ABSPATH'))
  exit;

if (!class_exists('IBFW_front')) {

    class IBFW_front {

        protected static $instance;

        function IBFW_hide_sale_flash(){
            return false;
        }
       
        function IBFW_frontdesign() {
            global $product;
            $is_setup = false;
            $product_id = $product->get_id();
            $price = $product->get_price();
            $tags = $product->get_tag_ids();
            $args = array(
                'post_type' => 'ibfw_product_label',
            );
            $post_list = get_posts( $args );
            foreach ( $post_list as $post ) {
                $pro_con = get_post_meta($post->ID, 'ocpl_pro_condition', true);
                if( $is_setup != true ) {
                    if ($pro_con == "all_products") {
                        $this->IBFW_create_label($post->ID);
                    } elseif ($pro_con == "selected_products") {
                        $productsa = get_post_meta($post->ID,'ibfw_combo',true);
                        if(!empty($productsa)) {
                            if(in_array($product_id, $productsa)) {
                                $this->IBFW_create_label($post->ID);
                            }  
                        }
                    } elseif ($pro_con == "tag") {
                        $tag = get_post_meta($post->ID, 'ocpl_tag', true);
                        if(!empty($tag)) {
                            if(array_intersect($tags, $tag)) {
                                $this->IBFW_create_label($post->ID);
                            }
                        }
                    } elseif ($pro_con == "onsale") {
                        $on_sale = get_post_meta($post->ID, 'ocpl_onsale', true);
                        if( $on_sale == "no") {
                            if(empty($product->is_on_sale())) {
                                $this->IBFW_create_label($post->ID);
                            }
                        } else {
                            if($product->is_on_sale() == 1) {
                                $this->IBFW_create_label($post->ID);
                            }
                        }                       
                    }
                }
            }
        }

        function IBFW_create_label($post_id) {
            $lbl = get_post_meta($post_id, 'ocpl_show_label', true);
            $left = get_post_meta($post_id, 'ocpl_left', true);
            $right = get_post_meta($post_id, 'ocpl_right', true);
            $top = get_post_meta($post_id, 'ocpl_top', true);
            $bottom = get_post_meta($post_id, 'ocpl_bottom', true);
            $ocpl_discount_text = get_post_meta($post_id, 'ocpl_discount_text', true);
            $ocpl_font_clr = get_post_meta($post_id, 'ocpl_font_clr', true);
            $ocpl_bg_clr = get_post_meta($post_id, 'ocpl_bg_clr', true);
            $ft_size = get_post_meta($post_id, 'ocpl_ft_size', true);
            $shape = get_post_meta($post_id, 'ocpl_lbl_shape', true);
            $ibfw_background = get_post_meta($post_id, 'ibfw_background', true);
            $image_badge = get_post_meta($post_id, 'image_badge', true);
            $badge_define=get_post_meta($post_id,'badge_define',true );
            $bagde_position = get_post_meta($post_id,'ocpl_image_position',true);
            $text = '<span style="font-size: '.$ft_size.'px;">'.$ocpl_discount_text.'</span>';
            //echo $bagde_position;
            if($right != 0) {
                $left = "inherit";
            } else {
                $left = $left."px";
            }

            if($bagde_position =="custom_position"){
                if($badge_define == "or_text_badge"){
                    $style ="top:".$top."px;right:".$right."px;bottom:".$bottom."px;left:".$left.";background-color:".$ocpl_bg_clr.";color:".$ocpl_font_clr.";";
                }else{
                    $style = "top:".$top."px;right:".$right."px;bottom:".$bottom."px;left:".$left.";";
                }
            }else{
                if($badge_define == "or_text_badge"){
                    if($bagde_position == "top_left"){
                        $style = "top:0px;left:0px;background-color:".$ocpl_bg_clr.";color:".$ocpl_font_clr.";"; 
                        $style_corner = "top:0px;left:-10px;transform: rotate(315deg);color: ".$ocpl_font_clr.";"; 
                        $style_corner_text = "transform: rotate(0deg);";
                    }else if($bagde_position == "top_right"){
                        $style = "top:0px;right:0px;background-color:".$ocpl_bg_clr.";color:".$ocpl_font_clr.";"; 
                        $style_corner = "top:0px;right:-10px;transform: rotate(45deg);color: ".$ocpl_font_clr.";";
                        $style_corner_text = "transform: rotate(0deg);";
                    }else if($bagde_position == "bottom_left"){
                        $style = "bottom:0px;left:0px;background-color:".$ocpl_bg_clr.";color:".$ocpl_font_clr.";"; 
                        $style_corner = "bottom:0px;left:-10px;transform: rotate(225deg);color: ".$ocpl_font_clr.";";
                        $style_corner_text = "transform: rotate(180deg);";
                    }else{
                        $style = "right: 0px;bottom:0px;background-color:".$ocpl_bg_clr.";color:".$ocpl_font_clr.";";
                        $style_corner = "bottom:0px;right:-10px;transform: rotate(135deg);color: ".$ocpl_font_clr.";";
                        $style_corner_text = "transform: rotate(180deg);";  
                    }
                 }else{
                    if($bagde_position == "top_left"){
                        $style = "top:0px;left:0px;"; 
                    }else if($bagde_position == "top_right"){
                        $style = "top:0px;right:0px;"; 
                    }else if($bagde_position == "bottom_left"){
                        $style = "bottom:0px;left:0px;"; 
                    }else{
                        $style = "right: 0px;;bottom:0px;"; 
                    }
                }
            }

            //text and image badge 
            if($lbl == "on") {
                if($badge_define == "or_text_badge"){
                    if($shape == "square") {
                        ?>
                            <div class="ibfw_square_data">
                                <div class="ibfw_square" style="<?php echo $style; ?>">
                                    <b><?php echo $text; ?></b>
                                </div>
                            </div>
                        <?php
                    }else if ($shape == "rectangle") {
                        ?>
                            <div class="ibfw_square_data">
                                <div class="ibfw_rectangle" style="<?php echo $style; ?>">
                                    <b><?php echo $text; ?></b>
                                </div>
                            </div>
                        <?php
                    }else if ($shape == "rectangle_up") {
                        ?>
                            <div class="ibfw_square_data">
                                <div class="ibfw_rectangle_up" style="<?php echo $style; ?>">
                                    <b><?php echo $text; ?></b>
                                </div>
                            </div>
                        <?php
                    }else if ($shape == "offers") {
                        ?>
                            <div class="ibfw_square_data">
                                <div class="ibfw_offers" style="<?php echo $style; ?>">
                                    <i style="background-color:<?php echo $ocpl_bg_clr?>; border-color:<?php echo $ocpl_bg_clr?>;" class="template-i "></i>            
                                    <i style="background-color:<?php echo $ocpl_bg_clr?>; border-color:<?php echo $ocpl_bg_clr?>;" class="template-i-before "></i>
                                    <b><?php echo $text; ?></b>
                                </div>
                            </div>
                        <?php
                    }else if ($shape == "tag") {
                        ?>
                            <div class="ibfw_square_data">
                                <div class="ibfw_tag" style="<?php echo $style; ?>">
                                    <i style="background-color:<?php echo $ocpl_bg_clr?>; border-color:<?php echo $ocpl_bg_clr?>;" class="template-span-before "></i>
                                    <b><?php echo $text; ?></b>
                                </div>
                            </div>
                        <?php
                    }else if ($shape == "collar") {
                        ?>
                            <div class="ibfw_square_data">
                                <div class="ibfw_collar" style="<?php echo $style; ?>">
                                    <i style="border-color:<?php echo $ocpl_bg_clr?>;" class="template-span-before "></i>
                                    <i style="border-color:<?php echo $ocpl_bg_clr?>;" class="template-i-after "></i>
                                    <b><?php echo $text; ?></b>
                                </div>
                            </div>
                        <?php
                    }else if ($shape == "rectangle_round") {
                        ?>
                            <div class="ibfw_square_data">
                                <div class="ibfw_rectangle_round" style="<?php echo $style; ?>">
                                    <b><?php echo $text; ?></b>
                                </div>
                            </div>
                        <?php
                    }else if ($shape == "rectangle_circle") {
                        ?>
                            <div class="ibfw_square_data">
                                <div class="ibfw_rectangle_circle" style="<?php echo $style; ?>">
                                    <b><?php echo $text; ?></b>
                                </div>
                            </div>
                        <?php
                    }else if ($shape == "circle") {
                        ?>
                            <div class="ibfw_square_data">
                                <div class="ibfw_circle" style="<?php echo $style; ?>">
                                    <b><?php echo $text; ?></b>
                                </div>
                            </div>
                        <?php
                    }else if ($shape == "corner_badge") {
                        ?>
                        <div class="ibfw_square_data">
                            <div class="ibfw_corner_badge" style="<?php echo $style_corner;?>"> 
                                <i style="background-color:<?php echo $ocpl_bg_clr?>; border-color:<?php echo $ocpl_bg_clr?>;" class="template-i-before "></i>
                                <i class="template-i-after " style="<?php echo $style_corner_text;?>"><b><?php echo $text; ?></b></i>
                            </div>
                        </div>
                        <?php
                    }
                }else if($badge_define == "or_image_badge"){
                    if($ibfw_background == "or_badge_image"){  ?>
                        <div class="ibfw_square_data">
                            <div class="ibfw_square" style="<?php echo $style; ?>">
                                <img src="<?php echo IBFW_PLUGIN_DIR; ?>/includes/images/<?php echo $image_badge; ?>">
                            </div>
                        </div>
                    <?php } 
                }
            }
        }

        function woocommerce_template_loop_product_thumbnaila(){
            echo "<div class='ibfw_square_data_main'>";
        }
        
        function woocommerce_template_loop_product_thumbnailb(){
            echo "</div>";
        }

        function init() {
            $args = array( 'post_type' => 'ibfw_product_label' );
            $query = new WP_Query( $args );
            $count_posts = $query->post_count;
            if ($count_posts > 0) {
                add_filter('woocommerce_sale_flash', array($this,'IBFW_hide_sale_flash'));
            }
            add_action( 'woocommerce_before_shop_loop_item_title', array($this, 'IBFW_frontdesign'), 10,5 );
            add_action( 'woocommerce_before_shop_loop_item_title', array($this,'woocommerce_template_loop_product_thumbnaila'), 9 );
            add_action( 'woocommerce_before_shop_loop_item_title', array($this,'woocommerce_template_loop_product_thumbnailb'), 11 );
        }

        public static function instance() {
            if (!isset(self::$instance)) {
                self::$instance = new self();
                self::$instance->init();
            }
            return self::$instance;
        }
    }
    IBFW_front::instance();
}