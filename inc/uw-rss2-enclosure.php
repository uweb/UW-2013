<?php
add_action('rss2_item', 'add_uw_feed_enclosure_image');

function add_uw_feed_enclosure_image() {
    global $post;
    $thumbnailID = get_post_thumbnail_id($post->ID);
    if(!empty($thumbnailID)){
        $url = wp_get_attachment_url($thumbnailID);
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
?>
