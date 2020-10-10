//for generate professional skills
		const ad_sk = document.querySelector('#ad_sk');
		const skills =document.querySelector('.skills');
		let amx = 0;

		ad_sk.addEventListener('click',()=>{

			if(amx<5){
				let nde = document.createElement('div');
				nde.classList.add('sk_row');

				let skp = document.createElement('p');

				let sklb = document.createElement('label');
				sklb.innerText = 'Title';
				let skin = document.createElement('input');
				skin.setAttribute('type','text');
				skin.setAttribute('name','professional_title1[]');

				skp.appendChild(sklb);
				skp.appendChild(skin);

				let skp1 = document.createElement('div');
				skp1.classList.add('prc');

				let twopc = document.createElement('div');
				twopc.classList.add('twopc');

				let sklb1 = document.createElement('label');
				sklb1.innerText = 'Percentage';
				let skin1 = document.createElement('input');
				skin1.setAttribute('type','range');
				skin1.setAttribute('name','professional_precenage1[]');
				skin1.setAttribute('value','0');
				skin1.setAttribute('oninput','scrol(event)')
				let skin2 = document.createElement('input');
				skin2.classList.add('range_box');
				skin2.setAttribute('type','text');
				skin2.setAttribute('id','valu1');
				skin2.setAttribute('value','0');

				let twopcs = document.createElement('div');
				twopcs.classList.add('twopcs');

				twopc.appendChild(sklb1);
				twopc.appendChild(skin1);
				twopcs.appendChild(skin2);


				let span = document.createElement('span');
				span.innerText='%';
				twopcs.appendChild(span);

				let skdl = document.createElement('button');
				skdl.classList.add('butdl');
				skdl.innerHTML='<i class="fas fa-trash"></i>';
				skdl.setAttribute('type','button');
				skdl.setAttribute('onclick','dl_row(event)');
				twopcs.appendChild(skdl);
				
				let skRow =document.createElement('div');
				skRow.classList.add('sk_row');
				skp1.appendChild(twopc);
				skp1.appendChild(twopcs);
				skRow.appendChild(skp);
				skRow.appendChild(skp1);


				skills.appendChild(skRow);
				console.log(skills);

				amx++;
			}
		});

		function dl_row(event){
			let deleting_one = event.target.parentElement.parentElement.parentElement.parentElement;

			deleting_one.classList.add('animation_skills');

			deleting_one.addEventListener('transitionend',()=>{
				let skDlRow = event.target.parentElement.parentElement.parentElement.parentElement;
				amx--;
				skDlRow.remove();	
			});
		}

		//for generate new education
		const ad_ed = document.querySelector('.ad_ed');
		const ed_fl = document.querySelector('.ed_fl');
		let ad_co =1;

		ad_ed.addEventListener('click',()=>{

			if(ad_co<3){

				let ed_fl_row = document.createElement('div');
				ed_fl_row.classList.add('ed_fl_row');

				let dl_row_ed = document.createElement('div');
				dl_row_ed.classList.add('dl_row_ed');
				let dl_row_ed_but = document.createElement('button');
				dl_row_ed_but.setAttribute('type','button');
				dl_row_ed_but.classList.add('dl_row_ed_but');
				dl_row_ed_but.innerHTML='<i class="fas fa-trash"></i>';
				dl_row_ed_but.setAttribute('onclick','dl_row_ed(event)');

				dl_row_ed.appendChild(dl_row_ed_but);
				ed_fl_row.appendChild(dl_row_ed);

				let p1 = document.createElement('p');

				let labelTl = document.createElement('label');
				labelTl.innerText='Title';
				let input1 = document.createElement('input');
				input1.setAttribute('type','text');
				input1.setAttribute('name','education_title[]');

				p1.appendChild(labelTl);
				p1.appendChild(input1);

				let p2 = document.createElement('p');

				let labelY2 = document.createElement('label');
				labelY2.innerText='Year';
				let input2 = document.createElement('input');
				input2.setAttribute('type','month');
				input2.setAttribute('name','education_year[]');

				p2.appendChild(labelY2);
				p2.appendChild(input2);

				let p3 = document.createElement('p');

				let labelI3 = document.createElement('label');
				labelI3.innerText='Institute';
				let input3 = document.createElement('input');
				input3.setAttribute('type','text');
				input3.setAttribute('name','education_institute[]');

				p3.appendChild(labelI3);
				p3.appendChild(input3);

				let p4 = document.createElement('p');

				let description1 = document.createElement('label');
				description1.innerText='Description';
				let textarea1 = document.createElement('textarea');
				textarea1.setAttribute('name','education_description[]');
				textarea1.setAttribute('maxlength','500');

				p4.appendChild(description1);
				p4.appendChild(textarea1);

				ed_fl_row.appendChild(p1);
				ed_fl_row.appendChild(p2);
				ed_fl_row.appendChild(p3);
				ed_fl_row.appendChild(p4);

				ed_fl.appendChild(ed_fl_row);

				ad_co++;
			}

		});

		//delete education field
		function dl_row_ed(event){
			let deleting_row = event.target.parentElement.parentElement.parentElement;

			deleting_row.classList.add('animation_fields');

			deleting_row.addEventListener('transitionend',()=>{
				event.target.parentElement.parentElement.parentElement.remove();
				if(ad_co!=1){
					ad_co--;
				}
			});
		}

		//for generate new work and experience
		const ad_we = document.querySelector('.ad_we');
		const we_fl = document.querySelector('.we_fl');
		let we_co =1;

		ad_we.addEventListener('click',()=>{

			if(we_co<3){

				let we_fl_row = document.createElement('div');
				we_fl_row.classList.add('we_fl_row');

				let dl_row_ed = document.createElement('div');
				dl_row_ed.classList.add('dl_row_ed');
				let dl_row_ed_but = document.createElement('button');
				dl_row_ed_but.setAttribute('type','button');
				dl_row_ed_but.classList.add('dl_row_ed_but');
				dl_row_ed_but.innerHTML='<i class="fas fa-trash"></i>';
				dl_row_ed_but.setAttribute('onclick','dl_row_we(event)');

				dl_row_ed.appendChild(dl_row_ed_but);
				we_fl_row.appendChild(dl_row_ed);

				let p1 = document.createElement('p');

				let labelTl = document.createElement('label');
				labelTl.innerText='Title';
				let input1 = document.createElement('input');
				input1.setAttribute('type','text');
				input1.setAttribute('name','work_title[]');

				p1.appendChild(labelTl);
				p1.appendChild(input1);

				let p2 = document.createElement('p');

				let labelY2 = document.createElement('label');
				labelY2.innerText='Company Name';
				let input2 = document.createElement('input');
				input2.setAttribute('type','text');
				input2.setAttribute('name','work_name[]');

				p2.appendChild(labelY2);
				p2.appendChild(input2);

				let p3 = document.createElement('p');

				let labelI3 = document.createElement('label');
				labelI3.innerText='year';
				let input3 = document.createElement('input');
				input3.setAttribute('type','month');
				input3.setAttribute('name','work_year[]');

				p3.appendChild(labelI3);
				p3.appendChild(input3);

				let p4 = document.createElement('p');

				let description1 = document.createElement('label');
				description1.innerText='Description';
				let textarea1 = document.createElement('textarea');
				textarea1.setAttribute('name','description[]');
				textarea1.setAttribute('maxlength','500');

				p4.appendChild(description1);
				p4.appendChild(textarea1);

				we_fl_row.appendChild(p1);
				we_fl_row.appendChild(p2);
				we_fl_row.appendChild(p3);
				we_fl_row.appendChild(p4);

				we_fl.appendChild(we_fl_row);

				we_co++;
			}

		});
		//delete work and experience field
		function dl_row_we(event){
			let deleting_row = event.target.parentElement.parentElement.parentElement;

			deleting_row.classList.add('animation_fields');

			deleting_row.addEventListener('transitionend',()=>{
				event.target.parentElement.parentElement.parentElement.remove();
				if(we_co!=1){
					we_co--;
				}
			});
		}

		//for generate new awards
		const ad_aw = document.querySelector('.ad_aw');
		const aw_fl = document.querySelector('.aw_fl');
		let aw_co =1;

		ad_aw.addEventListener('click',()=>{

			if(aw_co<3){

				let aw_fl_row = document.createElement('div');
				aw_fl_row.classList.add('aw_fl_row');

				let dl_row_ed = document.createElement('div');
				dl_row_ed.classList.add('dl_row_ed');
				let dl_row_ed_but = document.createElement('button');
				dl_row_ed_but.setAttribute('type','button');
				dl_row_ed_but.classList.add('dl_row_ed_but');
				dl_row_ed_but.innerHTML='<i class="fas fa-trash"></i>';
				dl_row_ed_but.setAttribute('onclick','dl_row_aw(event)');

				dl_row_ed.appendChild(dl_row_ed_but);
				aw_fl_row.appendChild(dl_row_ed);

				let p1 = document.createElement('p');

				let labelTl = document.createElement('label');
				labelTl.innerText='Title';
				let input1 = document.createElement('input');
				input1.setAttribute('type','text');
				input1.setAttribute('name','award_title[]');

				p1.appendChild(labelTl);
				p1.appendChild(input1);

				let p2 = document.createElement('p');

				let labelY2 = document.createElement('label');
				labelY2.innerText='Institute';
				let input2 = document.createElement('input');
				input2.setAttribute('type','text');
				input2.setAttribute('name','award_institute[]');

				p2.appendChild(labelY2);
				p2.appendChild(input2);

				let p3 = document.createElement('p');

				let labelI3 = document.createElement('label');
				labelI3.innerText='year';
				let input3 = document.createElement('input');
				input3.setAttribute('type','month');
				input3.setAttribute('name','awards_year[]');

				p3.appendChild(labelI3);
				p3.appendChild(input3);

				let p4 = document.createElement('p');

				let description1 = document.createElement('label');
				description1.innerText='Description';
				let textarea1 = document.createElement('textarea');
				textarea1.setAttribute('name','award_description[]');
				textarea1.setAttribute('maxlength','500');

				p4.appendChild(description1);
				p4.appendChild(textarea1);

				aw_fl_row.appendChild(p1);
				aw_fl_row.appendChild(p2);
				aw_fl_row.appendChild(p3);
				aw_fl_row.appendChild(p4);

				aw_fl.appendChild(aw_fl_row);

				aw_co++;
			}

		});
		//delete work and experience field
		function dl_row_aw(event){
			let deleting_row = event.target.parentElement.parentElement.parentElement;

			deleting_row.classList.add('animation_fields');

			deleting_row.addEventListener('transitionend',()=>{

				event.target.parentElement.parentElement.parentElement.remove();
				if(aw_co!=1){
					aw_co--;
				}
			});

		}