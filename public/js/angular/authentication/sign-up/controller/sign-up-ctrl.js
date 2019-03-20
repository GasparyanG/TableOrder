TableOrder.controller("SignUpCtrl", ["$scope", "$http", "AuthenticationFormNerd", function($scope, $http, AuthenticationFormNerd) {

    $scope.signUp = function() {
        $http({
            method: "POST",
            url: "/authentication/sign-up",
            data: AuthenticationFormNerd.getSignUpFormData($scope),

            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            }
        }).then(function successCallback(response) {
            console.log(response.data);
        }, function errorCallback(response) {
            console.log("error");
        })
    }
}]);