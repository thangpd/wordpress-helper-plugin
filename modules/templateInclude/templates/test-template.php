<?php
/**
 * Date: 1/17/21
 * Time: 2:53 PM
 */
wp_head();
echo __FILE__;
global $wp_scripts;
echo '<pre>';
print_r($wp_scripts);
echo '</pre>';


?>
test-template.php
<?php wp_footer() ?>
