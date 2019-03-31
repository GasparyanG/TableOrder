TableOrder.controller("RestaurantCtrl", ["$scope", "$http", "QueryStringMaker", "UrlMaker", "BookmarkHandler", "CommentHandler",
    function($scope, $http, QueryStringMaker, UrlMaker, BookmarkHandler, CommentHandler) {
    // hide all alerts at the beginning
    $('#noTableLeft').hide();
    $('#errorWhileSearching').hide();

    // comment section
    $('#commentSubmitted').hide();
    $('#submitError').hide();

   $scope.findATable = function() {
      $http({
          url: QueryStringMaker.getQueryStringForAjaxRequest($scope, "/test"),
          method: 'GET'
      }).then(function successCallback(response) {
          var tableState = response.data.tableState;
          // some error occurred
         if (tableState === null) {
             $('#errorWhileSearching').show();
         }
         // no table found
         else if (!tableState) {
             $('#noTableLeft').show();
         }

         // tables are found: redirect
         else if (tableState) {
             window.location.href = UrlMaker.getRestaurantScopeReservationUrl($scope);
         }

      }, function errorCallback(response) {
         console.log("err");
      });
   }

   // BOOKMARK
   $scope.bookmark = function(url) {
       BookmarkHandler.bookmark(url);
    };

    // COMMENT
    $scope.addComment = function(url){
      CommentHandler.addComment($scope, url);
    }
}]);