angular.module('homepage', [])
  .controller('NavCtrl', ['$scope', '$location', function($scope, $location) {
    $scope.menuItems = [
      { href: 'index.html', icon: 'home', text: 'Main page' },
      { href: 'aboutme.html', icon: 'user', text: 'About me' },
      { href: 'publications.html', icon: 'edit', text: 'Publications' }
    ];
    $scope.isCurrent = function(menuItem) {
      return $location.absUrl().indexOf(menuItem.href) !== -1;
    };
  }]);
