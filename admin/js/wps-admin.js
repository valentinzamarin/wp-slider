class WPS_Admin {

	constructor() {

		this.list = document.querySelector( '.wps-slides__list' );
		
		document.querySelector( '#wps-form' ).addEventListener( 'submit', event => {
			this.addSlider( event )
		});

		jQuery("div.wps-slides__list").sortable({
			update: event => {
				document.querySelectorAll( '.wps-slides__item' ).forEach( ( item, index ) => {
					item.querySelector( '.wps-slides__index' ).textContent = index;
				});
				this.refreshList();
			}
		});
	}
	
	refreshList() {
		let list = [];
		
		document.querySelectorAll( '.wps-slides__item' ).forEach( ( item, index ) => {
			let title = item.querySelector( '.wps-slides__title' ).textContent.trim(),
				descr = item.querySelector( '.wps-slides__descr' ).textContent.trim(),
				link = item.querySelector( '.wps-slides__link' ).textContent.trim(),
				img = item.querySelector( '.wps-slides__img' ).src;

			list.push({
				'idx'   : index,
				'title' : title,
				'descr' : descr,
				'link'  : link,
				'img'   : img,
			});
		});
		
		this.list.style.opacity = '0.5';

		let refreshData = new FormData();
		refreshData.append( 'action', 'wps_refresh' );
		refreshData.append( '_wpnonce', wps_ajax.nonce );
		refreshData.append( 'list', JSON.stringify( list ) );

		fetch( ajaxurl, {
			method: 'post',
			body: refreshData,
		})
			.then(response => response.text())
			.then( result => {
				console.log( result );
				this.list.style.removeProperty('opacity');
			})
			.catch((response) => console.log(response))
			.finally(() => {})
	}

	addSlider( event ) {
		event.preventDefault();
		
		let name  = event.target.name.value,
			descr = event.target.descr.value,
			link  = event.target.link.value,
			image = event.target.image.files[0],
			idx   = document.querySelectorAll( '.wps-slides__item' ).length;
		
		let formData = new FormData();
		formData.append( 'action', 'wps_action' );
		formData.append( '_wpnonce', wps_ajax.nonce );
		formData.append( 'name', name );
		formData.append( 'descr', descr );
		formData.append( 'link', link );
		formData.append( 'image', image );
		formData.append( 'idx', idx );

		fetch( ajaxurl, {
			method: 'post',
			body: formData,
		})
			.then(response => response.json())
			.then( result => {
				document.location.reload();
			})
			.catch((response) => console.log(response))
			.finally(() => {})
		
	}

}
new WPS_Admin();

