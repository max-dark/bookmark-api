/**
 * @author Max Dark
 * @license MIT
 */

/*
 * @copyright Copyright (C) 2016. Max Dark maxim.dark@gmail.com
 * @license MIT; see LICENSE.txt
 */
/**
 * @param {Object} opt
 *
 * @constructor {Rest}
 */
var ApiClient = function (opt) {
    var display_result;
    var api_url;
    var jq = opt.jq;
    var $result = jq("#result");
    var $url = jq("#url");
    var $bid = jq("#bid");
    var $cid = jq("#cid");
    var $text = jq("#text");

    // получить список 10 последних добавленных BookMark
    this.get_last = function () {
        jq.get(api_url(opt, "bmk", "/last")).done(display_result);
    };
    // получить BookMark (с комментариями) по BookMark.url. Если такого ещё нет, не создавать.
    this.get_bmk = function () {
        jq.get(api_url(opt, "bmk", "/get"), {url: $url.val()}).done(display_result);
    };
    // добавить BookMark по url и получить BookMark.uid. Если уже есть BookMark с таким url,
    // не добавлять ещё один, но получить BookMark.uid
    this.add_bmk = function () {
        jq.post(api_url(opt, "bmk", "/add"), {url: $url.val()}).done(display_result);
    };
    // добавить Comment к BookMark (по uid) и получить Comment.uid
    this.add_cmt = function () {
        jq.post(api_url(opt, "cmt", "/add"), {uid: $bid.val(), text: $text.val()}).done(display_result);
    };
    // изменить Comment.text по uid (если он добавлен с этого же IP и прошло меньше часа после добавления)
    this.set_cmt = function () {
        jq.post(api_url(opt, "cmt", "/edit"), {uid: $cid.val(), text: $text.val()}).done(display_result);
    };
    // удалить Comment по uid (если он добавлен с этого же IP и прошло меньше часа после добавления)
    this.del_cmt = function () {
        jq.post(api_url(opt, "cmt", "/delete"), {uid: $cid.val()}).done(display_result);
    };
    /**
     * Display result
     * @param data {Object}
     */
    display_result = function (data) {
        $result.text(JSON.stringify(data, null, "\t"));
    };
    api_url = (function (opt, type, method) {
        return opt.mount + opt[type] + method
    });
};