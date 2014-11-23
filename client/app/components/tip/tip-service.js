/**
 * Created by eanjorin on 9/23/14.
 */
define([], function () {

  var TipService = function ($interval, $sce) {
    this.sce_ = $sce;
    this.styles = {
      INFO: 'tip-info',
      ERROR: 'tip-error'
    };
    this.interval_ = $interval;
    this.tip = {
      message: '',
      visible: false,
      style: this.styles.INFO,
      delay: 5000
    };

  };
  TipService.prototype.info = function (message) {
    this.tip.message = this.sce_.trustAsHtml(message);
    this.tip.style = this.styles.INFO;
    return this;
  };
  TipService.prototype.loading = function () {
    this.tip.message = this.sce_.trustAsHtml('Loading..');
    this.tip.style = this.styles.INFO;
    return this;
  };
  TipService.prototype.ajaxError = function () {
    this.tip.message = this.sce_.trustAsHtml(['An error has occurred, please try again or ',
      '<a href=\'\'>reload<a/> your browser'].join(''));
    this.tip.style = this.styles.ERROR;
    this.delay = 1000000;
    this.show();
  };
  TipService.prototype.error = function (message) {
    this.tip.message = this.sce_.trustAsHtml(message);
    this.tip.style = this.styles.ERROR;
    this.tip.delay = 5000;
    return this;
  };

  TipService.prototype.delay = function (delay) {
    this.tip.delay = delay;
    return this;
  };

  TipService.prototype.hide = function () {
    this.tip.visible = false;
    return this;
  };

  TipService.prototype.show = function () {
    if (angular.isString(this.tip.message.toString())) {
      var self = this;
      this.tip.visible = true;
      if (typeof this.tip.delay === 'function') {
        this.interval_(function () {
          self.tip.delay();
          self.tip.visible = false;
        }, 100, 1);
      } else {
        this.interval_(function () {
          self.hide();
        }, this.tip.delay, 1);
      }
    }
    return this;
  };

  return ['$interval', '$sce', TipService];


});
