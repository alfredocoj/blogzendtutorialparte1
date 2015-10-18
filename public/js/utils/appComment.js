var app = angular.module('commentApp',['ngRoute']);

app.controller('commentController',['$scope','$http', function($scope, $http){

    //Variável que contém configurações para enviar os dados para o servidor.
	var config = { headers: { 'Content-Type' : 'application/x-www-form-urlencoded;' } };

    //Função para salvar um comentário.
    //Parametros:
    //  objectComentario: um objeto com os dados do comentário.
    //  post: um objeto com os dados do post em questão.
	$scope.salvarComentario = function(objectComentario, post, comentarioForm) {

        // função para enviar o formulário depois que a validação estiver ok
        // verifica se o formulário é válido
            if (comentarioForm.$valid) {
                var objectSave = {
                    name: objectComentario.name,
                    description: objectComentario.description,
                    webpage: objectComentario.webpage,
                    email: objectComentario.email,
                    postsId: post.id
                }

                $http.post('/admin/async/salvarcomentario', $.param(objectSave), config).
                then(function(response) {
                    if (response.data.response == 'ok') {
                        alert("Seu comentário foi salvo com sucesso");
                        post.commentsPost.push(objectSave);

                        objectComentario.name        = "";
                        objectComentario.description = "";
                        objectComentario.webpage     = "";
                        objectComentario.email       = "";
                        objectComentario.postsId     = "";

                        comentarioForm.$setUntouched();
                        comentarioForm.$setPristine();
                    } else {
                        alert("Ocorreu um erro nessa requisição. Por favor, tente novamente!");
                    }

                }, function(response) {
                       alert("Ocorreu um erro nessa requisição. Entre em contato com nossos desenvolvedores!");
                });
            } else {
                alert("Erro de validação");
            }


	};

    //Função que busca os posts no servidor.
    $scope.getPosts = function() {
      $http.get('/admin/async/getposts').
      then(function(response) {
        $scope.posts = response.data;
        // this callback will be called asynchronously
        // when the response is available
      }, function(response) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
      });
    };

    $scope.getPosts();
}]);
