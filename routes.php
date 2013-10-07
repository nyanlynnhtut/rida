<?php

// Route file for module Rida


Route::get('docs/{*:file}?', 'Rida\Rida::index')
		->csrf(false);
