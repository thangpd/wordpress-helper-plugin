<?php
/**
 * Date: 2/17/21
 * Time: 1:31 PM
 */

?>

    <h3 class="title">zalo OA api shortcode</h3>


<?php
if ( isset( $_POST['delete_zalo_info'] ) ) {
	delete_option( 'app_id' );
	delete_option( 'redirect_uri' );
	delete_transient( 'zalo_access_token' );
	delete_transient( 'zalo_oaId' );
	delete_transient( 'oa_information' );
}

if ( isset( $_POST['app_id'] ) && ! empty( $_POST['app_id'] ) ) {
	update_option( 'app_id', $_POST['app_id'] );
}
if ( isset( $_POST['redirect_uri'] ) && ! empty( $_POST['redirect_uri'] ) ) {
	update_option( 'redirect_uri', $_POST['redirect_uri'] );
}


$app_id       = get_option( 'app_id' );
$redirect_uri = get_option( 'redirect_uri' );
//$transient_at   = get_transient( 'zalo_access_token' );
$transient_at = '6uWRO2IfZGqOY1nY9wU83Xw86MOYlyeBSD4M6KcA_0iF_GmTJTIOA0t_2JvEdDeXTBnI8IZFZazBv75b2f7Y2rFvS0Pha9OADyiB4bATn1eupHaF2fNFDJF72rbBakTYS_i7QpMLwrvKmWjY39x7N6R_3a8OWFnsV_us6p7HqXjyhZKk4-3R9IYrHXPltfi5AxvQQL35asa9bbnZTygoIJUWV7TfqQ5b6v9DPYFuZ6vcqNjj5BcHUrh4J5KqchmyHTHt46ESldjTq2Dk89c_N47wSKiybg1UJtWB6QLP8x-D3G';
//$transient_oaId = get_transient( 'zalo_oaId' );
$transient_oaId = 2378013480520699910;

if ( ! empty( $transient_oaId ) && ! empty( $transient_at ) ) {
	$zalo = new \Elhelper\model\TechvsiZaloModel( $transient_at, $transient_oaId );
	$res=$zalo->call_remote_api('https://openapi.zalo.me/v2.0/oa/getoa','GET',[]);
	echo '<pre>';
	print_r($res);
	echo '</pre>';

	echo '<pre>';
	echo 'access_token<Br>';
	print_r( $transient_at );
	echo '</pre>';
	echo '<pre>';
	echo 'oaId<br>';
	print_r( $transient_oaId );
	echo '</pre>';


	$res = $zalo->getOAInformation();
	echo '<h2>OA Information</h2>';
	echo '<pre>';
	print_r( $res );
	echo '</pre>';


//	$res = $zalo->getListSubscribers();
//	echo '<h2>List Subscribers</h2>';
//	echo '<pre>';
//	print_r( $res );
//	echo '</pre>';


	$zalo->sendMessageToListRecipient();


	?>

    <form action="" method="post">
        <input type="submit" name="delete_zalo_info" value="Delete Current OA"/>
    </form>
	<?php
} elseif ( ! empty( $app_id ) && ! empty( $redirect_uri ) ) {
	//3200355550004632180
	//https://gomsu.fun/access-token
	?><a target="popup" class="btn btn-success zalo-btn-get-at"
         href="https://oauth.zaloapp.com/v3/oa/permission?app_id=<?php echo $app_id ?>&redirect_uri=<?php echo $redirect_uri ?>">
        Accept gain permission to website
    </a>

	<?php
} else {
	?>
    <form action="" class="form-container form-group" method="post">
        <label for="app_id">App ID: <input class="form-control" type="text" id="app_id" name="app_id"
                                           placeholder="App Id"></label>
        <label for="redirect_uri">Redirect Uri: <input class="form-control" type="text" id="redirect_uri"
                                                       name="redirect_uri"
                                                       placeholder="Redirect Uri"></label>
        <input type="submit" value="Get link" class="btn">
    </form>
	<?php
} ?>


<?php


?>