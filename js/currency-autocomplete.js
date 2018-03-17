var currencies = [];


$(function(){
	
	for(var x in parsed){
		var id = parsed[x]['id'];
		var busca = parsed[x]['nome'] + ", " + parsed[x]['logradouro'];
		currencies.push({ value: busca, data: id });
	}	

  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: currencies,
    onSelect: function (suggestion) {
		send(suggestion.data);
    }
  });
  

});