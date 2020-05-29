<?php

Route::get('saldo', 'TransacaoController@show');

Route::put('sacar', 'TransacaoController@update')->name('sacar');

Route::put('depositar', 'TransacaoController@update')->name('depositar');

