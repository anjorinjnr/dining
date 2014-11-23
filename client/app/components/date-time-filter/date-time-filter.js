/**
 * Created by eanjorin on 11/1/14.
 */
define([], function () {

  var formatDateFilter =  function () {
    /**
     * 
     * @param {string} input 
     * @param {string} srcFormat 
     * @param {string} dstFormat
     * @returns {string}
     */
    return function (input, srcFormat, dstFormat) {
      return moment(input, srcFormat).format(dstFormat);
    };
  };
  return formatDateFilter;
});
