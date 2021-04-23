jQuery(document).ready(function($){

// http://firegoby.jp/archives/4031

	var custom_uploader;

	$('#select-og-image').click(function(e) {
		e.preventDefault();
		if (custom_uploader) {
			custom_uploader.open();
			return;
		}
		custom_uploader = wp.media({
			title: 'Choose Image',
			library: {
				type: 'image'
			},
			button: {
				text: 'Choose Image'
			},
			multiple: false // falseにすると画像を1つしか選択できなくなる
		});
		custom_uploader.on('select', function() {
			var images = custom_uploader.state().get('selection');
			images.each(function(file){
				if ( $('#og-sample-image').attr( 'src' ) ) {
					$('#og-sample-image').attr( 'src', file.toJSON().url );
				} else {
					$('#og-image').append('<img src="'+file.toJSON().url+'" id="og-sample-image" />');
				}
				$('#ogp_image').val(file.toJSON().id);
				$('#deleat-og-image').css( 'display', 'inline' );
			});
		});
		custom_uploader.open();
	});
	
	// 削除処理
	$('#deleat-og-image').click(function(e) {
		$('#og-image img').remove();
		$('#ogp_image').removeAttr('value');
		$('#deleat-og-image').css( 'display', 'none' );
		return false;
	});

});