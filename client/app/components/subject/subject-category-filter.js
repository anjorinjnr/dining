/**
 * Created by eanjorin on 10/8/14.
 */
define([], function () {

  var subjCategoryFilter = function () {
    return function (input, category_id) {
      // console.log(category);
      if (category_id === 0) {
        return input;
      } else {
        var out = [];
        angular.forEach(input, function (value) {
          //console.log(value);
          for (var i = 0; i < value.categories.length; i++) {
            if (value.categories[i].id === category_id) {
              out.push(value);
              break;
            }
          }
        });
        return out;
      }
    };
  };
  return subjCategoryFilter;
});
