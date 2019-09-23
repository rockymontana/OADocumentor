<?php

Route::view(
    config('documentor.redoc.endpoint'),
    'OADocumentor::docs',
    ['docsFile' => config('documentor.save.path').'/'.config('documentor.save.filename')]
);