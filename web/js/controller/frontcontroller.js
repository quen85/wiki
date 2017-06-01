app.controller('FrontController',
    ['$scope', '$http',
        function($scope, $http){
        	var ctrl=this;
        	ctrl.signup=function({
        		console.log($scope.email)
        		var req = {
				 method: 'POST',
				 url: 'http://127.0.0.1:8000/#!/register.html',
				 headers: {
				   'Content-Type': undefined
				 },
				 data: { pseudo: $scope.pseudo,email: $scope.email, password: $scope.password
					}
				}

				$http(req).then(function(){...}, function(){...});
        	})
        }
    ]
);

