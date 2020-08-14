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

Breadcrumbs::for('admin.physician.branches.index', function ($trail) {
    $trail->push('Users', '');
    $trail->push('Physicians', route('admin.physician.index'));
    $trail->push('Branches', route('admin.physician.branches.index'));
});

Breadcrumbs::for('admin.physician.branches.create', function ($trail) {
    $trail->push('Users', '');
    $trail->push('Physicians', route('admin.physician.index'));
    $trail->push('Branches', route('admin.physician.branches.index'));
    $trail->push('Create New Branch', '');
});

Breadcrumbs::for('admin.physician.branches.edit', function ($trail) {
    $trail->push('Users', '');
    $trail->push('Physicians', route('admin.physician.index'));
    $trail->push('Branches', route('admin.physician.branches.index'));
    $trail->push('Update Branch', '');
});


Breadcrumbs::for('admin.physician.consultants.index', function ($trail) {
    if (request()->has('clinic')) {
        $trail->push('Clinics', route('admin.physician.clinics.index', ['physician' => request()->physician]));
    } else {
        $trail->push('Clinics', route('admin.physician.clinics.index', ['clinic' => request()->clinic]));
    }
    $trail->push('Consultants', route('admin.physician.consultants.index'));
});

Breadcrumbs::for('admin.physician.consultants.create', function ($trail) {
    if (request()->has('clinic')) {
        $trail->push('Clinics', route('admin.physician.clinics.index', ['physician' => request()->physician]));
    } else {
        $trail->push('Clinics', route('admin.physician.clinics.index', ['clinic' => request()->clinic]));
    }
    $trail->push('Consultants', route('admin.physician.consultants.index'));
    $trail->push('Create New Consultant');
});

Breadcrumbs::for('admin.physician.consultants.edit', function ($trail) {
    if (request()->has('clinic')) {
        $trail->push('Clinics', route('admin.physician.clinics.index', ['physician' => request()->physician]));
    } else {
        $trail->push('Clinics', route('admin.physician.clinics.index', ['clinic' => request()->clinic]));
    }
    $trail->push('Consultants', route('admin.physician.consultants.index'));
    $trail->push('Update Consultant');
});

Breadcrumbs::for('admin.mstr.designation.index', function ($trail) {
    $trail->push('Master Pages', '');
    $trail->push('Designations', '');
});

Breadcrumbs::for('admin.mstr.membership.index', function ($trail) {
    $trail->push('Master Pages', '');
    $trail->push('Memberships', '');
});

Breadcrumbs::for('admin.mstr.branch_medicine.index', function ($trail) {
    $trail->push('Master Pages', '');
    $trail->push('Professional Qualification', '');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/log-viewer.php';
