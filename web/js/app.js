var app = angular.module("WikiApp", ["ngRoute"]);

app.config(['$routeProvider', function($routeProvider){
    $routeProvider.
    when('/', {
        templateUrl: '/templates/index.html',
        controller: "FrontController",
        controllerAs: 'ctrl',
        title: 'homepage'
    }).
    when('/register.html', {
        templateUrl: '/templates/register.html',
        controller: "FrontController",
        controllerAs: 'ctrl',
        title: 'Register'
    }).
    when('/login.html', {
        templateUrl: '/templates/login.html',
        controller: "FrontController",
        controllerAs: 'ctrl',
        title: 'Login'
    }).
     when('/add-page.html', {
        templateUrl: '/templates/add-page.html',
        controller: "FrontController",
        controllerAs: 'ctrl',
        title: 'Ajout de nouvelle page'
    })
}]);

app.run(['$rootScope', '$route', function($rootScope, $route) {
    $rootScope.$route = $route;
    $rootScope.$on('$routeChangeSuccess', function() {

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
        templateUrl: '/templates/login.html'
    }
}]);

app.directive('login', ['$http', function($http){
    return {
        restrict: 'EA',
        templateUrl: '/templates/login.html'
    }
}]);
