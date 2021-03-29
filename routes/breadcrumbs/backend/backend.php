<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

Breadcrumbs::for('admin.physician.index', function ($trail) {
    $trail->push('Users');
    $trail->push('Physicians', route('admin.physician.index'));
});

Breadcrumbs::for('admin.physician.create', function ($trail) {
    $trail->push('Users');
    $trail->push('Physicians', route('admin.physician.index'));
    $trail->push('Create New Physician', route('admin.physician.index'));
});

Breadcrumbs::for('admin.physician.edit', function ($trail) {
    $trail->push('Users');
    $trail->push('Physicians', route('admin.physician.index'));
    $trail->push('Edit Physician', route('admin.physician.index'));
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

Breadcrumbs::for('admin.physician.gallery.index', function ($trail) {
    $trail->push('Clinics', route('admin.physician.clinics.index'));
    $trail->push('Gallery');
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
    $trail->push('Branch of Medicine', '');
});

Breadcrumbs::for('admin.hospitals.index', function ($trail) {
    $trail->push('Hospitals', '');
});

Breadcrumbs::for('admin.hospitals.create', function ($trail) {
    $trail->push('Hospitals', '');
    $trail->push('Create New Hospital', '');
});

Breadcrumbs::for('admin.hospitals.edit', function ($trail) {
    $trail->push('Hospitals', '');
    $trail->push('Update Hospital', '');
});

Breadcrumbs::for('admin.mstr.pro_qualify.index', function ($trail) {
    $trail->push('Master Pages', '');
    $trail->push('Professional Qualification', '');
});


Breadcrumbs::for('admin.medical-student.index', function ($trail) {
    $trail->push('Users', '');
    $trail->push('Medical Student');
});

Breadcrumbs::for('admin.medical-student.create', function ($trail) {
    $trail->push('Users', '');
    $trail->push('Medical Student', route('admin.medical-student.index'));
    $trail->push('Create New Student', '');
});

Breadcrumbs::for('admin.medical-student.edit', function ($trail) {
    $trail->push('Users', '');
    $trail->push('Medical Student', route('admin.medical-student.index'));
    $trail->push('Update Student', '');
});

Breadcrumbs::for('admin.homeopathic-pharmacy.index', function ($trail) {
    $trail->push('Homeopathic', '');
    $trail->push('Pharmacy');
});

Breadcrumbs::for('admin.homeopathic-pharmacy.create', function ($trail) {
    $trail->push('Homeopathic', '');
    $trail->push('Pharmacy', route('admin.homeopathic-pharmacy.index'));
    $trail->push('Create New Pharmacy', '');
});

Breadcrumbs::for('admin.homeopathic-pharmacy.edit', function ($trail) {
    $trail->push('homeopathic', '');
    $trail->push('Pharmacy', route('admin.homeopathic-pharmacy.index'));
    $trail->push('Update Pharmacy', '');
});

Breadcrumbs::for('admin.homeopathic-associate.index', function ($trail) {
    $trail->push('homeopathic', '');
    $trail->push('Association');
});

Breadcrumbs::for('admin.homeopathic-associate.create', function ($trail) {
    $trail->push('homeopathic', '');
    $trail->push('Association', route('admin.homeopathic-associate.index'));
    $trail->push('Create New Association', '');
});

Breadcrumbs::for('admin.homeopathic-associate.edit', function ($trail) {
    $trail->push('homeopathic', '');
    $trail->push('Association', route('admin.homeopathic-associate.index'));
    $trail->push('Update Association', '');
});

Breadcrumbs::for('admin.diagnostic-center.index', function ($trail) {
    $trail->push('Diagnostic Center', '');
    $trail->push('Association');
});

Breadcrumbs::for('admin.diagnostic-center.create', function ($trail) {
    $trail->push('Diagnostic Center', route('admin.diagnostic-center.index'));
    $trail->push('Create New Diagnostic Center', '');
});

Breadcrumbs::for('admin.diagnostic-center.edit', function ($trail) {
    $trail->push('Diagnostic Center', route('admin.diagnostic-center.index'));
    $trail->push('Update Diagnostic Center', '');
});

Breadcrumbs::for('admin.mstr.department.index', function ($trail) {
    $trail->push('Master Pages', '');
    $trail->push('Departments');
});

Breadcrumbs::for('admin.mstr.course.index', function ($trail) {
    $trail->push('Master Pages', '');
    $trail->push('Courses');
});

Breadcrumbs::for('admin.homeopathic-institution.index', function ($trail) {
    $trail->push('Homeopathic', '');
    $trail->push('Institutions');
});

Breadcrumbs::for('admin.homeopathic-institution.create', function ($trail) {
    $trail->push('Homeopathic', '');
    $trail->push('Institutions', route('admin.homeopathic-institution.index'));
    $trail->push('Create New Institution', '');
});

Breadcrumbs::for('admin.homeopathic-institution.edit', function ($trail) {
    $trail->push('Homeopathic', '');
    $trail->push('Institutions', route('admin.homeopathic-institution.index'));
    $trail->push('Update Institution', '');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/log-viewer.php';
