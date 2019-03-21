TableOrder.service("AuthenticationFormNerd", [function() {
    this.getSignUpFormData = function(scope) {
        var objectToReturn = {};
        objectToReturn.firstName = scope.firstName === undefined ? "" : scope.firstName;
        objectToReturn.lastName = scope.lastName === undefined ? "" : scope.lastName;
        objectToReturn.username = scope.username === undefined ? "" : scope.username;
        objectToReturn.password = scope.password === undefined ? "" : scope.password;

        console.log(objectToReturn);

        return objectToReturn;
    }
}]);