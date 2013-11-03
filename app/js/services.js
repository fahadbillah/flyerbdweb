'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('flyerBDServices', []).
  value('version', '0.1')
  .factory('getRandomSpan', function(){
  	return function(length){
  		console.log(length);
  		var count = 12;
      var spanList = [2,3,4];
      var spanArr = [];
      for(var i=0;i<length;i++){
        var rand = spanList[Math.floor((Math.random()*spanList.length))];
        count -= rand;
        if(count<2){
          count += rand;
          spanArr.push(count);
          count = 12;
        }
        else
          spanArr.push(rand);
      }
      console.log(spanArr);
      //var spanArray = [2,3,3,4,4,4,2,2,4,5,3,3,3,3,3,2,2,2,4];
      return spanArr;
  	};
  });
