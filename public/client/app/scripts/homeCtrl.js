'use strict';
angular.module('notesApp')
    .controller('homeCtrl', ['$scope', '$location', 'notesListSvc', function ($scope, $location, notesListSvc) {
        $scope.error = "";
        $scope.loadingMessage = "Loading...";
        $scope.notesList = null;
        $scope.notesTotal = 0;
        $scope.editingInProgress = false;
        $scope.newNoteContent = "";


        $scope.editInProgressTodo = {
            content: "",
            id: 0
        };



        $scope.editSwitch = function (todo) {
            todo.edit = !todo.edit;
            if (todo.edit) {
                $scope.editInProgressTodo.content = todo.content;
                $scope.editInProgressTodo.id = todo.id;
                $scope.editingInProgress = true;
            } else {
                $scope.editingInProgress = false;
            }
        };

        $scope.populate = function () {
            notesListSvc.getItems().success(function (results) {
                $scope.notesList = results.data;
                $scope.notesTotal = results.meta.pagination.total;
                $scope.loadingMessage = "";
            }).error(function (err) {
                $scope.error = err;
                $scope.loadingMessage = "";
            })
        };
        $scope.delete = function (id) {
            notesListSvc.deleteItem(id).success(function (results) {
                $scope.loadingMessage = "";
                $scope.populate();
            }).error(function (err) {
                $scope.error = err;
                $scope.loadingMessage = "";
            })
        };
        $scope.update = function (todo) {
            notesListSvc.putItem($scope.editInProgressTodo).success(function (results) {
                $scope.loadingMsg = "";
                $scope.populate();
                $scope.editSwitch(todo);
            }).error(function (err) {
                $scope.error = err;
                $scope.loadingMessage = "";
            })
        };
        $scope.add = function () {
            notesListSvc.postItem({
                'content': $scope.newNoteContent,
            }).success(function (results) {
                $scope.loadingMsg = "";
                $scope.newNoteContent = "";
                $scope.populate();
            }).error(function (err) {
                $scope.error = err.message;
                $scope.loadingMsg = "";
            })
        };
    }]);
