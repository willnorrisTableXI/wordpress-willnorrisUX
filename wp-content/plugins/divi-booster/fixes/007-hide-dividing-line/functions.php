<?php 
function db007_user_css($plugin) { ?>
.container:before { background-color:transparent !important; }
.et_pb_widget_area_right { border-left:0 !important; }
<?php
}
add_action('wp_head.css', 'db007_user_css');