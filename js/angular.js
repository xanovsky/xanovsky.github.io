angular.module('homepage', ['ngRoute', 'ngAnimate'])
  .config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider) {
      $routeProvider
        .when('/main.html', {
          templateUrl: 'main.html'
        })
        .when('/aboutme.html', {
          templateUrl: 'aboutme.html'
        })
	.when('/cv.pdf', {
          redirectTo: '/cv.pdf'
        })
        .otherwise('/main.html');
      $locationProvider.html5Mode(false);
  }])
  .controller('NavCtrl', ['$scope', '$location', function($scope, $location) {
    $scope.menuItems = [
      { href: '#/main.html', icon: 'home', text: 'Main page' },
      { href: '#/aboutme.html', icon: 'user', text: 'About me' },
      { href: '#/publications.html', icon: 'edit', text: 'Publications' },
      { href: 'cv.pdf', icon: 'download-alt', text: 'Download CV' }
    ];
    $scope.isCurrent = function(menuItem) {
      return $location.absUrl().indexOf(menuItem.href) !== -1;
    };
  }]);
