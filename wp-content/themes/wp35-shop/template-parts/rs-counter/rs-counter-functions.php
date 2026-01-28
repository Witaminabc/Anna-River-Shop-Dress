<?php
function style_rs_counter_theme() {
    wp_enqueue_style( 'rs-counter', get_stylesheet_directory_uri().'/template-parts/rs-counter/css/rs-counter.css');
}
function storefront_rs_counter() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 17, // id блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
        $bg_img = get_field('bg_img')?: false;
        if ($bg_img) {
            $url = $bg_img['url'];
            $attachment_id = attachment_url_to_postid($url);
            $srcm = wp_get_attachment_image_url($attachment_id, 'medium_large');
            $src = wp_get_attachment_image_url($attachment_id, 'large');
            $srcF = wp_get_attachment_image_url($attachment_id, 'full');
        }
		$title = get_field("title") ?: '';
		$finish_date = get_field("finish_date") ?: '';
		$finish_time = get_field("finish_time") ?: '';
        add_action( 'wp_print_scripts', 'style_rs_counter_theme', 11);
    }
?>
<section class="rs-17">
	<div class="rs-counter <?if ($bg_img) {?> b-lazy <?}?>" <?if ($bg_img) {?> data-src="<?=$srcF?>" data-medium="<?=$src?>" data-small="<?=$srcm?>" style="background-size: cover;"<?}?>>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 title">
					<h2 data-nekoanim="fadeInUp" data-nekodelay="100" class="text-center"><?=$title; ?></h2>
				</div>
				<div class="timer">
				<?php
				    $dateformatstring = "Y-m-d";
				    $unixtimestamp = strtotime($finish_date);
				?>
				<script>
				    (function() {
				        var _id="6113b4640076fcf0ccc784bd60de54f7";
				        while(document.getElementById("timer"+_id))_id=_id+"0";
				        document.write("<div id='timer"+_id+"' style='min-width: 814px; height: 172px;'></div>");
				        var _t=document.createElement("script");
				        _t.src="<?=get_stylesheet_directory_uri(); ?>/assets/js/timer.min.js";
				        
				        var msUTC = Date.parse("<?php echo date_i18n($dateformatstring, $unixtimestamp); ?>T<?php echo ($finish_time); ?>:00.000Z");
				        
				        var _f=function(_k) {
				            var l = new MegaTimer(_id, {
				                "view": [1,1,1,1],
				                "type": {
				                    "currentType":"1",
				                    "params": {
				                        "usertime":true,
				                        "tz":"3",
				                        "utc":msUTC
				                              
				                    }
				                },
				                "design": {
				                    "type":"circle",
				                    "params": {
				                        "width":"11",
				                        "radius":"74",
				                        "line":"solid",
				                        "line-color":"#ffeb3b",
				                        "background":"solid",
				                        "background-color":"rgba(255,255,255,0.13)",
				                        "direction":"direct",
				                        "number-font-family": {"family":"Open Sans"},
				                        "number-font-size":"50",
				                        "number-font-color":"#ffffff",
				                        "separator-margin":"21",
				                        "separator-on":false,
				                        "separator-text":":",
				                        "text-on":true,
				                        "text-font-family":{"family":"Open Sans"},
				                        "text-font-size":"15",
				                        "text-font-color":"#ffffff"}},
				                        "designId":8,
				                        "theme":"black",
				                        "width":814,
				                        "height":172
				            });
				            if(_k!=null)l.run();
				        };
				        _t.onload=_f;
				        _t.onreadystatechange=function() {
				            if(_t.readyState=="loaded")_f(1);
				        };
				        var _h=document.head||document.getElementsByTagName("head")[0];
				        _h.appendChild(_t);
				    }).call(this);
				</script>				
				</div>
			</div>
		</div>
	</div>
</section>
<?php
	wp_reset_query();	
}