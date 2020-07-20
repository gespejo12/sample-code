@extends('layouts.dashmix')
@section('content')
<div  id="app">
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title" v-cloak>@{{ specialization.specialization }}</h3>
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#add-category">Add New Category</button>
        </div>
        <div class="block-content block-content-full">
            <div>
                <div class="row" v-for="(q, key, index) in questions">
                    <div class="col-lg-12 push">
                        <div id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="block block-rounded mb-1">
                                <div class="block-header block-header-default" role="tab" id="key" style="background-color: #343a40;">
                                    <a class="font-w600" data-toggle="collapse" style="color: #74b3fb;" data-parent="#accordion" :href="getHashIndexHref(index)" aria-expanded="true" aria-controls="getIndexID(index)" v-cloak>@{{key}}</a>
                                </div>
                                <div :id="getIndexID(index)" class="collapse"  role="tabpanel" aria-labelledby="key" data-parent="#accordion">
                                    <div class="block-content" style="padding: 8px; background: #343a40; border-bottom-left-radius: .25rem; border-bottom-right-radius: .25rem; padding-bottom: 15px;">
                                        <div style="padding: 5px; background: white; border-radius: .25rem;">
                                            <div v-for="(question, i_q) in q">
                                                <div class="list-group-item d-flex justify-content-between align-items-center" style="border-radius: 0;" v-if="question.question_type == 'Rating Star'">
                                                    <div style="position: absolute;top: 8px; z-index: 999; left: -8px;">
                                                        <button class="btn btn-link btn-sm" v-on:click="deleteQuestion(question.id, question.question_category, i_q)">
                                                        <i class="si si-close" style="color: #74b3fb;"></i>
                                                        </button>
                                                    </div>
                                                    <span>@{{ question.question }}</span>
                                                    <div class="js-rating"></div>
                                                </div>
                                                <div class="list-group-item d-flex justify-content-between align-items-center" style="border-radius: 0;" v-if="question.question_type == 'Yes Or No'">
                                                    <div style="position: absolute;top: 16px; z-index: 999; left: -8px;">
                                                        <button class="btn btn-link btn-sm" v-on:click="deleteQuestion(question.id, question.question_category, i_q)">
                                                        <i class="si si-close" style="color: #74b3fb;"></i>
                                                        </button>
                                                    </div>
                                                    <span >@{{ question.question }}</span>
                                                    <select class="custom-select" style="width: auto;">
                                                        <option value="" disabled="" selected>Please select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div class="list-group-item d-flex justify-content-between align-items-center" style="border-radius: 0;" v-if="question.question_type == 'Certifiication'">
                                                    <div style="position: absolute;top: 18px; z-index: 999; left: -8px;">
                                                        <button class="btn btn-link btn-sm" v-on:click="deleteQuestion(question.id, question.question_category, i_q)">
                                                        <i class="si si-close" style="color: #74b3fb;"></i>
                                                        </button>
                                                    </div>
                                                    <span >@{{ question.question }}</span>
                                                    <input type="checkbox" class="form-control" style="width: auto;">
                                                    <input type="date" class="form-control" placeholder="Expiry Date" style="width: auto;">
                                                </div>
                                                <div class="list-group-item d-flex justify-content-between align-items-center" style="border-radius: 0;" v-if="question.question_type == 'Rating Star & Textbox'">
                                                    <div style="position: absolute;top: 17px; z-index: 999; left: -8px;">
                                                        <button class="btn btn-link btn-sm" v-on:click="deleteQuestion(question.id, question.question_category, i_q)">
                                                        <i class="si si-close" style="color: #74b3fb;"></i>
                                                        </button>
                                                    </div>
                                                    <span >@{{ question.question }}</span>
                                                    <input type="text" class="form-control" :placeholder="question.question" style="width: auto;">
                                                    <div class="js-rating"></div>
                                                </div>
                                                <div class="list-group-item d-flex justify-content-between align-items-center" style="border-radius: 0;" v-if="question.question_type == 'Add Additional (Textbox)'">
                                                    <div style="position: absolute; top: 17px; z-index: 999; left: -8px;">
                                                        <button class="btn btn-link btn-sm" v-on:click="deleteQuestion(question.id, question.question_category, i_q)">
                                                        <i class="si si-close" style="color: #74b3fb;"></i>
                                                        </button>
                                                    </div>
                                                    <span >@{{ question.question }}</span>
                                                    <input type="text" class="form-control" :placeholder="question.question" style="width: auto;">
                                                </div>
                                                <div class="list-group-item d-flex justify-content-between align-items-center" style="border-radius: 0;" v-if="question.question_type == 'Certifiication & Textbox'">
                                                    <div style="position: absolute;top: 18px; z-index: 999; left: -8px;">
                                                        <button class="btn btn-link btn-sm" v-on:click="deleteQuestion(question.id, question.question_category, i_q)">
                                                        <i class="si si-close" style="color: #74b3fb;"></i>
                                                        </button>
                                                    </div>
                                                    <span >@{{ question.question }}</span>
                                                    <input type="text" class="form-control" :placeholder="question.question" style="width: auto;">
                                                    <input type="date" class="form-control" placeholder="Expiry Date" style="width: auto;">
                                                </div>
                                            </div>
                                        </div>
                                        <button v-on:click="openQuestionAdd(key)" type="button" class="btn btn-sm btn-primary custom-btn-job-diva" data-toggle="modal" data-target="#add-modal"><i class="fa fa-fw fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-category" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Title" required  v-model="cache_category">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-secondary" v-on:click="saveCategory()">Save</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" class="form-control" name="question" placeholder="Question" required  v-model="cache_modal.question">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label>Question Type</label>
                            <select class="custom-select" name="question_type" v-model="cache_modal.question_type" required="">
                                <option value="">Please select</option>
                                <option value="Rating Star" selected>Rating Star</option>
                                <option value="Yes Or No">Yes Or No</option>
                                <option value="Certifiication">Certifiication</option>
                                <option value="Rating Star & Textbox">Rating Star & Textbox</option>
                                <option value="Certifiication & Textbox">Certifiication & Textbox</option>
                                <option value="Add Additional (Textbox)">Add Additional (Textbox)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-secondary" v-on:click="saveQuestion()">Save</button>
            </div>
        </div>
    </div>
</div>



</div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/raty-js/jquery.raty.css') }}">
<style type="text/css">
    [v-cloak] {
      display: none;
    }
    .custom-btn-job-diva {
        background: #1d2124 !important;
        border-color: rgb(116, 179, 251) !important;
        color: rgb(116, 179, 251) !important;
        margin-top: 10px !important;
    }
    .custom-btn-job-diva:hover {
        opacity: 0.8 !important;
    }
</style>

@endsection
@section('scripts')
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/raty-js/jquery.raty.js') }}"></script>
<script src="{{ asset('/js/vue.js') }}"></script>
<script>
    $('.js-rating').raty({
        starType: 'i',
        readOnly: true,
        starHalf: "fa fa-fw fa-star-half text-warning",
        starOff:  "fa fa-fw fa-star text-muted",
        starOn: "fa fa-fw fa-star text-warning",
    });
    window.publicUrl = "{{url('/')}}";
    window.questions = @json($questions);
    window.specialization = @json($specialization);
</script>
<script src="{{ asset('/js/question.js') }}"></script>
@endsection
