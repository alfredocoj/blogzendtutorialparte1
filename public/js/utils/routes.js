// Função que redireciona para uma index de um dado controller.
// Caso necessário, deve-se passar os ids em um array.
function redirectToIndex( nickname, ids )
{
	url = '/admin/'+ nickname + '/index';
	if( typeof ids !== undefined ) {
		for(id in ids ) {
			url += '/' + ids[id];
		}

	}
	window.location.href = url;
}

// Função que redireciona para uma create de um dado controller.
// Caso necessário, deve-se passar os ids em um array.
function redirectToCreate( nickname, ids )
{
	url = '/admin/'+ nickname + '/update';

	if( typeof ids !== undefined ) {
		for(id in ids ) {
			url += '/' + ids[id];
		}

	}

	window.location.href = url;
}

// Função que redireciona para uma update de um dado controller.
// Deve-se passar os ids em um array.
function updateById( nickname, ids )
{
	url = '/admin/'+ nickname + '/update';

	if( typeof ids !== undefined ) {
		for(id in ids ) {
			url += '/' + ids[id];
		}

		window.location.href = url;
	}
}

// Função que redireciona para uma delete de um dado controller.
// Deve-se passar os ids em um array.
function deleteById( nickname, ids )
{
	url = '/admin/'+ nickname + '/delete';

	if( typeof ids !== undefined ) {
		for( id in ids ) {
			url += '/' + ids[id];
		}

		window.location.href = url;
	}
}

// Função que redireciona para uma action de um dado controller.
// Deve-se passar os ids em um array.
function goToAction( controller, action, ids )
{
	url = '/admin/'+ controller + '/' + action;

	if( typeof ids !== undefined ) {
		for( id in ids ) {
			url += '/' + ids[id];
		}

		window.location.href = url;
	}
}

function popularSelectById(id, select, labelSelect) {
    var url;

    switch(labelSelect) {
        case 'getperfisbymoduloid':
            url = '/admin/async/getperfisbymoduloid/';
            labelSelect = 'perfil';
            break;
    }

    $.getJSON( url+id, function( res ) {
        select.show();
        select.empty();
        select.append("<option value=''>Escolha um(a) "+labelSelect+"</option>");
        if(res != null){
            for(var i in res) {
              select.append("<option value='"+res[i].id +"'>"+res[i].descricao+"</option>");
            }
        }
    });
}

function popularSelectByIdInGerenciaPerfis(id, select, labelSelect, btn) {
    var url;

    switch(labelSelect) {
        case 'getperfisbymoduloid':
            url = '/admin/async/getperfisbymoduloid/';
            labelSelect = 'perfil';
            break;
    }

    $.getJSON( url+id, function( res ) {
        select.show();
        select.empty();
        select.append("<option value=''>Escolha um(a) "+labelSelect+"</option>");
        if(res != null){
            for(var i in res) {
              select.append("<option value='"+res[i].prfId +"'>"+res[i].prfNome+"</option>");
            }
            // habilita o botao
            btn.show();
        }
    });
}
