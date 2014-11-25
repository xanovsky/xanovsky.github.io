angular.module('homepage', ['ngRoute', 'ngAnimate', 'ngSanitize'])
  .config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider) {
      $routeProvider
        .when('/main.html', {
          templateUrl: 'main.html'
        })
        .when('/aboutme.html', {
          templateUrl: 'aboutme.html'
        })
        .when('/publications.html', {
          templateUrl: 'publications.html',
          controller: 'PubsCtrl'
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
  }])

  .controller('PubsCtrl', ['$scope', '$http', function($scope, $http) {
    $scope.papers = [];
    $scope.pubTypeFilter = 'all';

    $scope.$watch(function() {
      $scope.pubTypeFilter = $('[name=cd-dropdown]').val();
    });

    $scope.filterByPubType = function() {
      return function(item) {
        return $scope.pubTypeFilter === 'all' || item.hasOwnProperty($scope.pubTypeFilter);
      };
    };

    $http.get('data/papers.json').success(function(data) {
      $scope.papers = data;
    });
  }])

  .directive('pubTypeDropdown', ['$timeout', '$rootScope', function($timeout, $rootScope) {
    return {
      restrict: 'A',
      link: function(scope, element) {
        element.dropdownit({
          gutter: 0,
          onOptionSelect: function() {
            $timeout(function() {
              $rootScope.$digest();
            });
          }
        });
      }
    };
  }])

  .directive('pubGrid', function() {
    return {
      restrict: 'A',
      link: function(scope, element) {
        element.on('click', 'div.pubmain', function() {
          var $this = $(this);
          var $item = $this.closest('.item');

          $item.find('div.pubdetails').slideToggle(function(){
            $this.children('i').toggleClass('icon-collapse-alt icon-expand-alt');
          },function(){
            $this.children('i').toggleClass('icon-expand-alt icon-collapse-alt');
          });
	});
      }
    };
  });
