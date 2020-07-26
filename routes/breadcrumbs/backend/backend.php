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

Breadcrumbs::for('admin.physician.clinics.index', function ($trail) {
    $trail->push('Clinics', route('admin.physician.clinics.index'));
});

Breadcrumbs::for('admin.physician.clinics.create', function ($trail) {
    $trail->push('Clinics', route('admin.physician.clinics.index'));
    $trail->push('Create New Clinic');
});

Breadcrumbs::for('admin.physician.clinics.edit', function ($trail) {
    $trail->push('Clinics', route('admin.physician.clinics.index'));
    $trail->push('Update Clinic');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/log-viewer.php';
