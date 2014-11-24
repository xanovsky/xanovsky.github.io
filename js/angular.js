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
    $scope.publications = [];

    $http.get('data/papers.json').success(function(data) {
      $scope.publications = data;
    });
  }])

  .directive('pubTypeDropdown', function() {
    return {
      restrict: 'A',
      link: function(scope, element) {
        element.dropdownit({
	  gutter : 0
	});
      }
    };
  })

  .directive('pubGrid', function() {
    return {
      restrict: 'A',
      link: function(scope, element) {
	element.mixitup({
	  layoutMode: 'list',
	  easing: 'snap',
	  transitionSpeed: 600,
	  onMixEnd: function(){
	    $('.tooltips').tooltip();
	  }
	}).on('click','div.pubmain',function(){
	  var $this = $(this);
	  var $item = $this.closest(".item");

	  $item.find('div.pubdetails').slideToggle(function(){
	    $this.children("i").toggleClass('icon-collapse-alt icon-expand-alt');
	  },function(){
	    $this.children("i").toggleClass('icon-expand-alt icon-collapse-alt');
	  });

          return false;
	});
      }
    };
  });
