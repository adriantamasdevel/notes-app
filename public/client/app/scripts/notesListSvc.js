'use strict';
angular.module('notesApp')
.factory('notesListSvc', ['$http', function ($http) {

    $http.defaults.useXDomain = true;
    delete $http.defaults.headers.common['X-Requested-With'];

    return {
        getItems : function(){
            return $http.get(apiEndpoint + '/api/notes');
        },
        getItem : function(id){
            return $http.get(apiEndpoint + '/api/notes/' + id);
        },
        postItem : function(item){
            return $http.post(apiEndpoint + '/api/notes', item);
        },
        putItem : function(item){
            return $http.put(apiEndpoint + '/api/notes/', item);
        },
        deleteItem : function(id){
            return $http({
                method: 'DELETE',
                url: apiEndpoint + '/api/notes/' + id
            });
        }
    };
}]);
