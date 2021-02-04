
		$(document).ready(function(){

			$('#upload-pic').on('change',function(){
				$('.model_page').css('display','flex');
			});

			$('#close').click(function(){
				$('.model_page').fadeOut(600);
			});	

			var $canvas = $('#canvas');
			var context = $canvas.get(0).getContext('2d');

			$('#upload-pic').on('change', function(){

				if(this.files && this.files[0]){

					if(this.files[0].type.match(/^image\//)){

						$('#cv_pic_name').attr('value',this.files[0].name);
						$('#cv_pic_size').attr('value',this.files[0].size);
						$('#cv_pic_type').attr('value',this.files[0].type);

						var reader = new FileReader();

						reader.onload = function(e){
							var img = new Image();
							img.onload=function(){
								context.canvas.width = img.width;
								context.canvas.height =img.height;
								context.drawImage(img,0,0);

								/*add cropper */
								var cropper = $canvas.cropper({
									aspectRatio: 1/1
								});
							};
							img.src = e.target.result;
						};

						$('#crop').click(function(){
							$('.model_page').fadeOut(600);

							var croppedImage = $canvas.cropper('getCroppedCanvas').toDataURL('img/jpg');
							$('.cv-pic img').attr('src',croppedImage);
							$('#cv_pic').attr('value',croppedImage);

						});

						reader.readAsDataURL(this.files[0]);
					}
					else{
						alert("Invalied File Type");
					}
				}
				else{
					alert("Please Select A File");
				}

			});
		});