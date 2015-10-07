
function editarSenha( senhaatual, newsenha, novasenharepetida, myModal ) {
    var url = '/application/async/atualizarsenha';

    $.post( url, {
      'senhaatual': senhaatual,
      'newsenha': newsenha,
      'novasenharepetida': novasenharepetida
      },
      function( data ){
        switch(data.status) {
            case 'success':
                toastr[data.status]( "Sua senha foi alterada com sucesso!" );
                break;
            case 'error':
                toastr[data.status]( "Senha atual não confere!" );
                break;
            default:
                toastr[data.status]( "Por favor, tente novamente, houve um problema nessa requisição!" );
                toastr[data.status]( "Por favor, tente novamente, houve um problema nessa requisição!" );
                break;
        }

        myModal.modal('hide');

      },'json'
    );
}

function editarDadosUsuario(usrId, usrNome, usrEmail, usrTelefone, myModal) {
    var url = '/application/async/atualizarperfil';

    $.post( url, {
          'usrId': usrId,
          'usrNome': usrNome,
          'usrEmail': usrEmail,
          'usrTelefone': usrTelefone
          },
          function( data ) {

            if (data.status == 'success') {
                toastr[data.status]( "Dados de perfil alterados com sucesso!" );
            } else {
                // erro
                toastr[data.status]( "Por favor, tente novamente, houve um problema nessa requisição!" );
            }

            myModal.modal('hide');

          },'json'
        );
}
