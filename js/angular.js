angular.module('admin', [])
  .config(function($sceProvider) {
    $sceProvider.enabled(false);
  })
  .controller('AdminCtrl', ['$http', '$scope', function($http, $scope) {
    var errorId = 0;

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
      papers: {
        text: 'Publications to download'
      },
      talks: {
        text: 'Talks to download'
      }
    };

    var computeMissingCollaborators = function() {
      var data = $scope.data;
      var papers = data.papers.entries;
      var collaborators = data.collaborators.entries;
      if (!papers || !collaborators) return;
      collaborators = _.map(collaborators, 'name');
      collaborators.push('Alexandra Silva');
      collaborators.push('Davide Grohmann');
      var authors = _.chain(papers)
        .map('authors')
        .flatten()
        .uniq()
        .value();
      $scope.missingCollaborators = _.filter(authors, function(author) {
        return !_.contains(collaborators, author);
      });
    };

    var checkUrls = function(links, checking, desc) {
      checking.toCheck = links.length;
      checking.checked = 0;
      var done = function() {
        checking.checked++;
      };
      _.each(links, function(link) {
        $http.get(link).success(function() {
          done();
        }).error(function(data, status) {
          done();
          $scope.errors.push({
            text: 'Wrong ' + desc + ' link: <a href="' + link + '">' + link + '</a>',
            id: errorId++
          });
        });
      });
    };

    var checkPapers = function() {
      var links = _.chain($scope.data.papers.entries)
        .map('download')
        .filter(function(c) { return c && c.indexOf('/files/') == 0; })
        .value();
      checkUrls(links, $scope.checking.papers, 'paper');
    };

    var checkTalks = function() {
      var links = _.chain($scope.data.talks.entries)
        .map('download')
        .flatten()
        .filter(function(c) { return c; })
        .map('url')
        .filter(function(c) { return c && c.indexOf('/files/') == 0; })
        .value();
      checkUrls(links, $scope.checking.talks, 'talk');
    };

    $scope.numPapers = _.memoize(function(author) {
      return _.filter($scope.data.papers.entries, function(paper) {
        return _.contains(paper.authors, author);
      }).length;
    });

    _.each($scope.data, function(d, key) {
      $http.get(d.url).success(function(data) {
        d.entries = data;
        if (key == 'papers') checkPapers();
        if (key == 'talks') checkTalks();
        if (key == 'collaborators' && $scope.data.papers.entries) computeMissingCollaborators();
        if (key == 'papers' && $scope.data.collaborators.entries) computeMissingCollaborators();
      }).error(function() {
        $scope.errors.push({
          text: 'Could not load <b>' + d.text + '</b>; please check <pre>' + d.url + '</pre>',
          id: errorId++
        });
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
          controller: 'PubsCtrl',
          reloadOnSearch: false
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

  .controller('PubsCtrl', ['$scope', '$http', '$location', function($scope, $http, $location) {
    $scope.papers = [];
    $scope.pubTypeFilter = 'all';
    $scope.search = $location.search().search;

    $scope.selectedCollaborator = function(author) {
      if (!$scope.search) return false;
      var authorNames = author.name.split(' ');
      var matchesAuthor = function(searchTerm) {
        return _.find(authorNames, function(name) {
          return name.toUpperCase() == searchTerm.toUpperCase();
        });
      };
      return _.every($scope.search.split(' '), matchesAuthor);
    };

    var findMatchingCollaborators = function() {
      $scope.matchingCollaborators = _.filter($scope.collaborators, $scope.selectedCollaborator);
    };

    $scope.searchFor = function(searchTerm) {
      $scope.search = searchTerm;
    };

    $scope.$watch(function() {
      $scope.pubTypeFilter = $('[name=cd-dropdown]').val();
    });

    $scope.$watch('search', function(search) {
      $location.search('search', search);
      findMatchingCollaborators();
    });

    $scope.$watch('collaborators', function() {
      findMatchingCollaborators();
    });

    $scope.filterByPubType = function() {
      return function(item) {
        return $scope.pubTypeFilter === 'all' || item.hasOwnProperty($scope.pubTypeFilter);
      };
    };

    $http.get('data/papers.json').success(function(data) {
      $scope.papers = data;
    });

    $http.get('data/collaborators.json').success(function(data) {
      $scope.collaborators = data;
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
    $scope.publications = [];

    $scope.rowsPerSize = [
      {size: 'xs', elems: 2},
      {size: 'sm', elems: 3},
      {size: 'md', elems: 4},
      {size: 'lg', elems: 6}
    ];

    var isAuthor = function(author, paper) {
      return _.contains(paper.authors, author.name);
    };

    $scope.getNumPubForAuthor = function(author) {
      return _.filter($scope.papers, function(paper) {
        var publicationCounts = paper.edited || paper.journal || paper.conference;
        return publicationCounts && isAuthor(author, paper);
      }).length;
    };

    var sortCollaborators = function() {
      if (!$scope.collaborators || !$scope.papers) return;
      $scope.collaborators = _.sortBy($scope.collaborators, $scope.getNumPubForAuthor).reverse();
    };

    $scope.getCollaboratorRows = _.memoize(function(elemsPerRow) {
      if (!$scope.papers) return [];

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
      sortCollaborators();
      $scope.getCollaboratorRows.cache = {};
    });

    $http.get('data/papers.json').success(function(data) {
      $scope.papers = data;
      sortCollaborators();
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
        element.on('click', 'div.pubmain .pubcollapse', function() {
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
