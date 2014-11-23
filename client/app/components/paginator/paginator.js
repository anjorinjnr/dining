/**
 * Provides pagination for a collection of data.
 * Supports adding/removing items from the paged collection
 * Created by eanjorin on 11/1/14.
 * 
 */
define([], function () {

  var Paginator = function (pageSize) {

    if (_.isNumber(pageSize)) {
      this.pageSize = pageSize;
    } else {
      this.pageSize = 20;
    }
    this.start = 0;
    this.end = 0;
    this.total = 0;
    this.pageData = [];
    this.data = [];
    this.masterSelect = false;
    this.selected = [];
    this.currentPage = 1;

  };

  /**
   * Getter/Setter for pageSize
   * @param {int} pageSize
   * @returns {Number}
   */
  Paginator.prototype.pageSize = function (pageSize) {
    if (arguments.length === 0) {
      return this.pageSize;
    }
    if (_.isNumber(pageSize) && !_.isNaN(pageSize)) {
      this.pageSize = pageSize;
      this.start = 0;
    }
  };
  /**
   * Sets the underlying data to be paged
   * @param {type} data
   * @returns {undefined}
   */
  Paginator.prototype.setData = function (data) {
    this.data = data;
    this.total = data.length;
    this.lastPage = Math.ceil(this.total / this.pageSize);
    this.changePage();
  };

  /**
   * Loads a new page of the data based on the current internal state
   * @returns {Array}
   */
  Paginator.prototype.changePage = function () {
    if (!_.isEmpty(this.data)) {
      this.end = (this.start + this.pageSize > this.total) ? this.total : this.start + this.pageSize;
      this.pageData = this.data.slice(this.start, this.end);
    } else {
      this.pageData = [];
    }
    return this.pageData;
  };

  /**
   * Advances to the next page 
   * @returns {undefined}
   */
  Paginator.prototype.nextPage = function () {
    if (this.hasNext()) {
      this.start = this.end;
      this.currentPage++;
      this.changePage();
    }
  };
  /**
   * Advances to the previous page
   * @returns {undefined}
   */
  Paginator.prototype.prevPage = function () {
    if (this.hasPrev()) {
      this.start = this.start - this.pageSize;
      this.currentPage--;
      this.changePage();
    }
  };

  /**
   * Returns true if there is next page, false otherwise
   * @returns {Boolean}
   */
  Paginator.prototype.hasNext = function () {
    return this.end < this.total;
  };

  /**
   * Returns true if there is prev page, false otherwise
   * @returns {Boolean}
   */
  Paginator.prototype.hasPrev = function () {
    return this.start > 0;
  };

  /**
   * Adds/Removes an item to the selected list. This item should be added from
   * a view using a check box for example
   * @param {object} item
   * @returns {undefined}
   */
  Paginator.prototype.select = function (item) {
    var i = this.selected.indexOf(item.id);
    if (i >= 0) {
      this.selected.splice(i, 1);
    } else {
      this.selected.push(item.id);
    }

  };

  /**
   * Select/unselect all items in the current page
   * @returns {undefined}
   */
  Paginator.prototype.checkAll = function () {
    this.masterSelect = !this.masterSelect;
    if (this.masterSelect) {
      var ids = [];
      this.pageData.forEach(function (item) {
        ids.push(item.id);
      });
      this.selected = ids;
    } else {
      this.selected = [];
    }
  };

  Paginator.prototype.reset = function () {
    this.start = 0;
    this.end = 0;
    this.total = 0;
    this.pageData = [];
    this.data = [];
    this.masterSelect = false;
    this.selected = [];
    this.currentPage = 1;
  };

  /**
   * Deletes all currently deleted items from the underlying data.
   * The object using the this paginator is responsible for actual deletion.
   * @returns {undefined}
   */
  Paginator.prototype.delete = function () {
    if (this.select.length < 1)
      return;
    var tmp = this.data;
    this.data = [];
    var self = this;
    tmp.forEach(function (item) {
      if (self.selected.indexOf(item.id) < 0) {
        self.data.push(item);
      }
    });
    //console.log(self);
    this.total = this.data.length;
    if (this.total === 0) {
      this.reset();
    }
    if (this.selected.length === this.pageData.length) {
      //if user deleted all items on current page
      //load next or prev page
      if (this.currentPage === this.lastPage && this.currentPage > 1) {
        this.prevPage();
      } else if (this.currentPage === 1) {
        this.start = 0;
      }
    }
    if (this.start >= this.total) {
      this.prevPage();
    }
    this.selected = [];
    this.masterSelect = false;
    //this.end = 0;
    this.changePage();
  };

  return Paginator;

});
