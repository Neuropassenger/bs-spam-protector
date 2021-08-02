<?php
class Bs_Spam_Protector_Functions {
	public static function logit( $data, $description = '[INFO]' ) {
		$filename = WP_CONTENT_DIR . '/bs_spam_protector.log';

		$text = "===[ " . $description . " ]===\n";
		$text .= "===[ " . date( 'M d Y, G:i:s', time() ) . " ]===\n";
		$text .= print_r( $data, true ) . "\n";
		$file = fopen( $filename, 'a' );
		fwrite( $file, $text );
		fclose( $file );
	}
}