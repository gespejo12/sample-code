const app = new Vue({
    el: '#app',
    data () {
        return {
            questions: {},
            specialization: {},
            cache_modal: {
                question_category: null,
                question: null,
                question_type: 'Rating Star',
                specialization_id: null,
            },
            cache_category: null,
        }
    },
    mounted: function(){
        var __this = this;
        var x = window.questions;
        if(x.length === 0) {
            __this.questions =  {};
        } else {
            __this.questions =  window.questions;
        }
        __this.specialization =  window.specialization;
    },
    created: function(){

    },
    methods:{
        getHashIndexHref(i) {
            return '#accordion'+i;

        },
        getIndexID(i) {
            return 'accordion'+i;
        },
        openQuestionAdd(key) {
            var __this = this;
            __this.cache_modal.question_category = key;
        },
        deleteQuestion(id, category, key) {
            var __this = this;

            $.ajax({
                method: 'delete',
                url: window.publicUrl + '/question/' + id,
                jsonp: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    __this.questions[category].splice(key, 1);
                }
            });

        },
        saveQuestion() {
            var __this = this;

            __this.cache_modal.specialization_id = __this.specialization.id;

            $.ajax({
                method: 'post',
                url: window.publicUrl + '/question',
                jsonp: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: __this.cache_modal,
                success: function(response) {
                    var question = response.data;
                    console.log(question);
                    __this.questions[__this.cache_modal.question_category].push(question);

                    __this.cache_modal = {
                        question_category: null,
                        question: null,
                        question_type: 'Rating Star',
                        specialization_id: null,
                    }
                }
            });

            $('#add-modal').modal('hide');
        },
        saveCategory() {
            var __this = this;
            __this.questions[__this.cache_category] = []
            __this.cache_category = null;
            $('#add-category').modal('hide');
        }
    }
});

