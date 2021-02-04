$(document).ready(function(){


	

	//praparing canvas variable

	var $canvas = $('#canvas');
	var context = $canvas.get(0).getContext('2d');

	//hide and show canvas
	$('#upload-provider-pic').on('click',function(){
		$('#imj-canvas').show(900);

	});

	$('#upload-provider-pic').on('change',function(){

		if (this.files && this.files[0]) {

			if (this.files[0].type.match(/^image\//)) {

				$('#up_file_name').attr('value',this.files[0].name);
				$('#up_file_size').attr('value',this.files[0].size);
				$('#up_file_type').attr('value',this.files[0].type);

					var reader = new FileReader();

					reader.onload = function(e){
						var img = new Image();
						img.onload = function(){
							context.canvas.width = img.width;
							context.canvas.height=img.height;
							context.drawImage(img,0,0);

							//add croper
							var cropper = $canvas.cropper({
								aspectRatio: 1/1
							});
						};
						img.src =e.target.result;
					};
					$('#crop').click(function(){
						$('.imj-canvas').hide(600);
						$('.preview').show(600);

						var croppedImage = $canvas.cropper('getCroppedCanvas').toDataURL('img/jpg');
						$('.preview').append($('<img>').attr('src',croppedImage));
						$('#up_pic').attr('value',croppedImage);
					});

					reader.readAsDataURL(this.files[0]);
			}
			else{
				alert("Invalied file type");
			}
		}

		/*else{
			alert("Please Select File");
		}*/
	});

});