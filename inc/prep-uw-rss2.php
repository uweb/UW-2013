<?php
remove_all_actions('do_feed_rss2');
add_action('do_feed_rss2', 'prep_uw_rss2', 10, 1);
add_action('pre_rss2_enclosure', 'add_uw_feed_enclosure_image');

function prep_uw_rss2( $for_comments ){
    $uw_rss_template = get_template_directory() . '/inc/uw-feed-rss2.php';
    if ((file_exists($uw_rss_template)) || (!$for_comments)) {
        load_template($uw_rss_template);
    }
    else {
        do_feed_rss2($for_comments);
    }
}

function add_uw_feed_enclosure_image() {
    global $post;
    $thumbnailID = get_post_thumbnail_id($post->ID);
    if(!empty($thumbnailID)){
        $url = wp_get_attachment_image_src($thumbnailID, 'rss');
        $url = $url[0];
        //$mime = get_post_mime_type($thumbnailID);  unneeded DB call to get mime type
        $img_headers = get_headers($url);
        foreach ($img_headers as $img_header) {
            $info = explode(" ", $img_header);
            if ($info[0] == 'Content-Length:') {
                $size = $info[1];
            }
            else if ($info[0] == 'Content-Type:') {
                $mime = $info[1];
            }
        }
        ?>
        <enclosure url="<?= $url ?>" type="<?= $mime ?>" size="<?= $size ?>" />
        <?php
    }
}
