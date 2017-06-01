app.controller('FrontController',
    ['$scope', '$http', '$location',
        function($scope, $http, $location){
        	// var ctrl=this
        	$scope.signup=function(){
        		// console.log($scope.email)
        		var req = {
    				 method: 'POST',
    				 url: '/signup',
    				 headers: {
    				   'Content-Type': 'application/json'
    				 },
    				 data: {
               username: $scope.pseudo,
               email: $scope.email,
               password: $scope.password
    					}
    				}
    				$http(req).then(function(){
              $location.url('/')
            }, function(){});
          }
          $scope.login=function(){
        		var req = {
    				 method: 'POST',
    				 url: '/login_check',
    				 headers: {
    				   'Content-Type': 'application/json'
    				 },
    				 data: {
               _username: $scope.pseudo,
               _password: $scope.password,
               _target_path: '/',
               _failure_path: '/login'
    					}
    				}
    				$http(req).then(function(response){
              console.log(response)
            }, function(response){
              console.log(response)
            });
          }

          $scope.all_post=function(){
        		var req = {
    				 method: 'GET',
    				 url: '/page',
    				 headers: {
    				   'Content-Type': 'application/json'
    				 },
    				 data: {
		               _title: $scope.title,
		               _content: $scope.content
    					}
    				}
    				$http(req).then(function(response){
		              console.log(response)
		            }, function(response){
		              console.log(response)
            });
          }

        }
    ]
);
