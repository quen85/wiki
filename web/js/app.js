var app = angular.module("WikiApp", ["ngRoute"]);

app.config(['$routeProvider', function($routeProvider){
    $routeProvider.
    when('/', {
        templateUrl: '/templates/index.html',
        controller: "FrontController",
        controllerAs: 'ctrl',
        title: 'homepage'
    })
}]);

app.run(['$rootScope', '$route', function($rootScope, $route) {
    $rootScope.$route = $route;
    $rootScope.$on('$routeChangeSuccess', function() {
        // Si on veux faire des trucs au changement de page
    });
}]);

app.directive('header', ['$http', function($http){
    return {
        restrict: 'EA',
        templateUrl: '/templates/bases/header.html'
    }
}]);

app.directive('footer', ['$http', function($http){
    return {
        restrict: 'EA',
        templateUrl: '/templates/bases/footer.html'
    }
}]);

app.directive('titre', ['$http', function($http){
    return {
        restrict: 'EA',
        templateUrl: '/templates/bases/title.html'
    }
}]);