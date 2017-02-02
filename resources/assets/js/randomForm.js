var $ = require('jquery');
require('jquery-ui-browserify');

var alertify = require('alertify.js');

var Vue = require('vue');
var VueAutosize = require('vue-autosize');
Vue.use(VueAutosize);

require('browsernizr/test/inputtypes');
var Modernizr = require('browsernizr');
var Moment = require('moment');

var VueAjax = require('./ajaxVue.js');
window.app = new VueAjax({
  el: '#form',

  data: {
    participants: [],
    smsContent: '',
    maxSms: global.maxSms,
    dearsanta: false,
    date: window.now
  },

  components: {
    participant: {
      template: '#participant-template',
      props: ['idx', 'participants', 'dearsanta'],
      data: function() {
        return {
          name: '',
          email: '',
          exclusions: []
        };
      },
      components: {
        select2: require('../vuejs/select2.vue')
      },
      computed: {
        participantNames: function() {
          var names = [];
          this.participants.forEach(function(participant, idx) {
            if(participant.name && idx !== this.idx) {
              names.push({id: participant.id, value: idx, text: participant.name});
            }
          }.bind(this));
          return names;
        }
      },
      watch: {
        name: function() {
          this.$emit('changename', this.name);
        },
        email: function() {
          this.$emit('changeemail', this.email);
        }
      }
    }
  },

  computed: {

    emailUsed: function() {
      var used = false;
      for(var i in this.participants) {
        used = used || (this.participants[i].email !== '');
      }
      return used;
    },

    allMails: function() {
      var allMails = true;
      this.participants.forEach(function(participant) {
        allMails = (allMails && (participant.name === '' || participant.email !== ''));
      });
      return allMails;
    }

  },

  created: function() {
    this.addParticipant();
    this.addParticipant();
    this.addParticipant();

    Vue.nextTick(function() {
      if (!Modernizr.inputtypes.date) {
        $('input[type=date]', this.$el).datepicker({
          // Consistent format with the HTML5 picker
          dateFormat: 'yy-mm-dd',
          minDate: Moment(this.now).add(1, 'day').toDate(),
          maxDate: Moment(this.now).add(1, 'year').toDate()
        });
      }
    }.bind(this));
  },

  filters: {
    moment: function (date, amount, unit) {
      return Moment(date).add(amount, unit).format("YYYY-MM-DD");
    }
  },

  watch: {
    sending: function(newVal) {
      // If we reset the sending status, reset the captcha
      if(!newVal) {
        grecaptcha.reset();
      }
    },

    sent: function(newVal) {
      // If sent is a success, scroll to the message
      if(newVal) {
        $.scrollTo('#form .row', 800, {offset: -120});
      }
    },

    errors: function(newVal) {
      // If there's new errors, scroll to them
      if(newVal.length) {
        $.scrollTo('#form .row', 800, {offset: -120});
      }
    },

    allMails: function(newVal) {
      this.dearsanta = this.dearsanta && newVal;
    }
  },

  methods: {

    addParticipant: function() {
      this.participants.push({
        name: '',
        email: '',
        id: 'id' + this.participants.length + (new Date()).getTime()
      });
    }

  }
});
