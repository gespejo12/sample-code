<?php

Route::group([
    'middleware' => 'auth'
], function () {
    Route::resource('match-group', 'MatchGroupController')
});