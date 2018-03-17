var id_mapa = 0;

function initialize() {
	var mapOptions = {
		zoom: 17,
		panControl:false,
		zoomControl:true,
		mapTypeControl:false,
		scaleControl:false,
		streetViewControl:false,
		overviewMapControl:false,
		rotateControl:false,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	
	
	
var map = new google.maps.Map(document.getElementById('googleMap'),mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);
									   
		var local_atual = new google.maps.Marker({
				position: pos,
				map: map,
				icon: 'js/soccer22.png'
			});
			
		


										
		
		
		map.setCenter(pos);
		
		var marker = [];
		var infowindow = [];
		
		for(var i in quadras) {
		

  
			var conteudo = '<div id="iw-container">' +
                    '<div class="iw-title">'+quadras[i]['nome']+'</div>' +
                    '<div class="iw-content">' +
                      '<div class="iw-subTitle">Endereço</div>' +
                      '<p>'+quadras[i]['logradouro']+', '+quadras[i]['numero']+'<br>'+quadras[i]['bairro']+' </p>'+
                      '<a href="detalhes_quadra.php?id='+quadras[i]['id']+'" class="btn btn-md btn-success">Ver Detalhes</a>'+
                    '</div>' +
                  '</div>';
			
			marker[i] = new google.maps.Marker({
				position: new google.maps.LatLng(quadras[i]['lat'],quadras[i]['lng']),
				map: map,
				icon: 'js/marcador.png',
				animation: google.maps.Animation.BOUNCE
			});
			
			infowindow[i] = new google.maps.InfoWindow({
				content: conteudo,
				maxWidth: 350
			});

			google.maps.event.addListener(marker[i], 'click', function(innerKey) {
			return function() {
				infowindow[innerKey].open(map, marker[innerKey]);
			}
			}(i));
			
			google.maps.event.addListener(map, 'click', function(innerKey) {
			return function() {
				infowindow[innerKey].close();
			}
			}(i));
			
			google.maps.event.addListener(infowindow[i], 'domready', function() {

			// Referência ao DIV que agrupa o fundo da infowindow
			var iwOuter = $('.gm-style-iw');

			/* Uma vez que o div pretendido está numa posição anterior ao div .gm-style-iw.
			* Recorremos ao jQuery e criamos uma variável iwBackground,
			* e aproveitamos a referência já existente do .gm-style-iw para obter o div anterior com .prev().
			*/
			var iwBackground = iwOuter.prev();

			// Remover o div da sombra do fundo
			iwBackground.children(':nth-child(2)').css({'display' : 'none'});

			// Remover o div de fundo branco
			iwBackground.children(':nth-child(4)').css({'display' : 'none'});

			// Altera a cor desejada para a sombra da cauda
			iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});

			// Referência ao DIV que agrupa os elementos do botão fechar
			var iwCloseBtn = iwOuter.next();

			// Aplica o efeito desejado ao botão fechar
			iwCloseBtn.css({"display":"none"});

			// Se o conteúdo da infowindow não ultrapassar a altura máxima definida, então o gradiente é removido.
			if($('.iw-content').height() < 140){
			$('.iw-bottom-gradient').css({display: 'none'});
			}

			// A API aplica automaticamente 0.7 de opacidade ao botão após o evento mouseout. Esta função reverte esse evento para o valor desejado.
			iwCloseBtn.mouseout(function(){
			$(this).css({opacity: '1'});
			});
			});
			
			
			var div = $(".autocomplete-suggestions");
		div.click(function(){
			var teste = new google.maps.LatLng(quadras[id_mapa]['lat'],quadras[id_mapa]['lng']);
			infowindow[id_mapa].open(map, marker[id_mapa]);
			map.setCenter(teste);
		});
			
		}
		
		
	
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
}



function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Error: The Geolocation service failed.';
  } else {
    var content = 'Error: Your browser doesn\'t support geolocation.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(60, 105),
    content: content
  };

  var infowindow = new google.maps.InfoWindow(options);
  map.setCenter(options.position);
}

google.maps.event.addDomListener(window, 'load', initialize);