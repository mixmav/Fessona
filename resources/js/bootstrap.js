import $ from 'jquery';
import Vue from 'vue';
import _ from 'lodash'

Vue.prototype._ = _;

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		'X-Requested-With': 'XMLHttpRequest'
	}
});