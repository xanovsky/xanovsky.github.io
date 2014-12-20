angular.module('admin', [])
  .controller('AdminCtrl', ['$http', '$scope', function($http, $scope) {
    $scope.errors = [];
    $scope.data = {
      papers: {
        url: 'data/papers.json',
        text: 'Publications'
      },
      collaborators: {
        url: 'data/collaborators.json',
        text: 'Collaborators'
      },
      news: {
        url: 'data/news.json',
        text: 'News'
      },
      talks: {
        url: 'data/talks.json',
        text: 'Talks'
      }
    };
    $scope.checking = {
      collaboratorHomepages: {
        text: 'Homepages of collaborators'
      }
    };

    var computeMissingCollaborators = function() {
      var data = $scope.data;
      var papers = data.papers.entries;
      var collaborators = data.collaborators.entries;
      if (!papers || !collaborators) return;
      collaborators = _.map(collaborators, 'name');
      collaborators.push('Alexandra Silva');
      var authors = _.chain(papers)
        .map('authors')
        .flatten()
        .uniq()
        .value();
      $scope.missingCollaborators = _.filter(authors, function(author) {
        return !_.contains(collaborators, author);
      });
    };

    $scope.numPapers = _.memoize(function(author) {
      return _.filter($scope.data.papers.entries, function(paper) {
        return _.contains(paper.authors, author);
      }).length;
    });

    _.each($scope.data, function(d, key) {
      $http.get(d.url).success(function(data) {
        d.entries = data;
        if (key == 'collaborators' && $scope.data.papers.entries) computeMissingCollaborators();
        if (key == 'papers' && $scope.data.collaborators.entries) computeMissingCollaborators();
      }).error(function() {
        $scope.errors.push('Could not load <b>' + d.text + '</b>; please check <pre>' + d.url + '</pre>');
      });
    });
  }]);

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
        .when('/talks.html', {
          templateUrl: 'talks.html',
          controller: 'TalksCtrl'
        })
        .when('/news.html', {
          templateUrl: 'news.html'
        })
        .when('/activities.html', {
          templateUrl: 'activities.html'
        })
        .when('/teaching.html', {
          templateUrl: 'teaching.html'
        })
        .when('/calendar.html', {
          templateUrl: 'calendar.html'
        })
        .when('/thesis.html', {
          templateUrl: 'thesis.html'
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
      { href: '#/talks.html', icon: 'comment', text: 'Talks' },
      { href: '#/news.html', icon: 'bullhorn', text: 'News' },
      { href: '#/activities.html', icon: 'tasks', text: 'Activities' },
      { href: '#/teaching.html', icon: 'time', text: 'Teaching' },
      { href: '#/calendar.html', icon: 'calendar', text: 'Calendar' },
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

  .controller('TalksCtrl', ['$scope', '$http', function($scope, $http) {
    $scope.talks = [];

    $http.get('data/talks.json').success(function(data) {
      $scope.talks = data;
    });
  }])

  .controller('NewsCtrl', ['$scope', '$http', function($scope, $http) {
    $scope.news = [];

    $http.get('data/news.json').success(function(data) {
      $scope.news = data;
    });
  }])

  .controller('CollabCtrl', ['$scope', '$http', function($scope, $http) {
    $scope.collaborators = [];

    $scope.rowsPerSize = [
      {size: 'xs', elems: 2},
      {size: 'sm', elems: 3},
      {size: 'md', elems: 4},
      {size: 'lg', elems: 6}
    ];

    $scope.getCollaboratorRows = _.memoize(function(elemsPerRow) {
      var res = [];
      for (var i = 0; i < $scope.collaborators.length; i++) {
        if (i % elemsPerRow == 0) {
          res.push([]);
        }
        _.last(res).push($scope.collaborators[i]);
      }
      return res;
    });

    $http.get('data/collaborators.json').success(function(data) {
      $scope.collaborators = data;
      $scope.getCollaboratorRows.cache = {};
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
