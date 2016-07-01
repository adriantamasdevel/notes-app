//
// Use the following code for running without authentication.
//
'use strict';
angular.module('notesApp', ['ngRoute'])
.config(['$routeProvider', '$httpProvider', function ($routeProvider, $httpProvider) {
    $routeProvider.when("/home", {
        controller: "homeCtrl",
        templateUrl: "/client/app/views/NotesList.html",
    }).otherwise({ redirectTo: "/home" });
}]);