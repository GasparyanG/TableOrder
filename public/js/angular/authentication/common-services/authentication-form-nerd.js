TableOrder.service("AuthenticationFormNerd", [function() {
    this.getSignUpFormData = function(scope) {
        var objectToReturn = {};
        objectToReturn.firstName = scope.firstName;
        objectToReturn.lastName = scope.lastName;
        objectToReturn.username = scope.username;
        objectToReturn.password = scope.password;

        return objectToReturn;
    }
}]);