<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

Breadcrumbs::for('admin.physician.index', function ($trail) {
    $trail->push('Physicians', route('admin.physician.index'));
});

Breadcrumbs::for('admin.physician.create', function ($trail) {
    $trail->push('Physicians', route('admin.physician.index'));
    $trail->push('Create New Physician', route('admin.physician.index'));
});

Breadcrumbs::for('admin.physician.edit', function ($trail) {
    $trail->push('Physicians', route('admin.physician.index'));
    $trail->push('Update Physician', route('admin.physician.index'));
});



require __DIR__ . '/auth.php';
require __DIR__ . '/log-viewer.php';
