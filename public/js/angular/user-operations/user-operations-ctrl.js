TableOrder.controller("UserOperationsCtrl", ["$scope", "NotificationHandler", function($scope, NotificationHandler) {
    $scope.markAsRead = function() {
        NotificationHandler.markAsRead();
    }
}]);