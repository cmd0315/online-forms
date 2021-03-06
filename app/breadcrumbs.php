<?php

Breadcrumbs::register('dashboard', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('dashboard'));
});

/*** USER PROFILE ***/
Breadcrumbs::register('my-profile', function($breadcrumbs, $username) {
    $breadcrumbs->push('Employee Profile', route('profile.show', $username));
});

Breadcrumbs::register('change-password', function($breadcrumbs, $username) {
    $breadcrumbs->parent('my-profile', $username);
    $breadcrumbs->push('Change Password', route('accounts.edit', $username));
});

Breadcrumbs::register('update-profile', function($breadcrumbs, $username) {
    $breadcrumbs->parent('my-profile', $username);
    $breadcrumbs->push('Update Profile', route('profile.edit', $username));
});

/*** EMPLOYEES ***/
Breadcrumbs::register('add-employee', function($breadcrumbs) {
    $breadcrumbs->push('Add Employee Record', route('employees.create'));
});

Breadcrumbs::register('list-employees', function($breadcrumbs) {
    $breadcrumbs->push('Manage Employee Records', route('employees.index'));
});

Breadcrumbs::register('show-employee', function($breadcrumbs, $username) {
    $breadcrumbs->parent('list-employees');
    $breadcrumbs->push('Employee Profile', route('employees.show', $username));
});

Breadcrumbs::register('edit-employee', function($breadcrumbs, $username) {
    $breadcrumbs->parent('show-employee', $username);
    $breadcrumbs->push('Edit Employee Profile', route('employees.edit', $username));
});

/*** DEPARTMENTS ***/
Breadcrumbs::register('add-department', function($breadcrumbs) {
    $breadcrumbs->push('Add Department Record', route('departments.create'));
});

Breadcrumbs::register('list-departments', function($breadcrumbs) {
    $breadcrumbs->push('Manage Department Records', route('departments.index'));
});

Breadcrumbs::register('department-profile', function($breadcrumbs, $id) {
    $breadcrumbs->parent('list-departments', $id);
    $breadcrumbs->push('Department Profile', route('departments.show', $id));
});

Breadcrumbs::register('edit-department', function($breadcrumbs, $id) {
    $breadcrumbs->parent('department-profile', $id);
    $breadcrumbs->push('Edit Department Information', route('departments.edit', $id));
});

/*** CLIENTS ***/
Breadcrumbs::register('add-client', function($breadcrumbs) {
    $breadcrumbs->push('Add Client Record', route('clients.create'));
});

Breadcrumbs::register('list-clients', function($breadcrumbs) {
    $breadcrumbs->push('Manage Client Records', route('clients.index'));
});

Breadcrumbs::register('client-profile', function($breadcrumbs, $id) {
    $breadcrumbs->parent('list-clients', $id);
    $breadcrumbs->push('Client Profile', route('clients.show', $id));
});

Breadcrumbs::register('edit-client', function($breadcrumbs, $id) {
    $breadcrumbs->parent('client-profile', $id);
    $breadcrumbs->push('Edit Client Information', route('clients.edit', $id));
});

/*** FORMS ***/
Breadcrumbs::register('online-forms', function($breadcrumbs) {
    $breadcrumbs->push('List of Online Forms', route('forms.index'));
});

Breadcrumbs::register('payment-request', function($breadcrumbs) {
    $breadcrumbs->parent('online-forms');
    $breadcrumbs->push('Payment Request', route('prs.index'));
});

Breadcrumbs::register('show-payment-request', function($breadcrumbs, $id) {
    $breadcrumbs->parent('payment-request');
    $breadcrumbs->push('Payment', route('prs.show', $id));
});

Breadcrumbs::register('edit-payment-request', function($breadcrumbs, $id) {
    $breadcrumbs->parent('payment-request');
    $breadcrumbs->push('Edit Payment Request', route('prs.edit', $id));
});


/*** FORM REJECT RESON ***/
Breadcrumbs::register('list-reject-reasons', function($breadcrumbs) {
    $breadcrumbs->push('List of Reject Reasons', route('rejectreasons.index'));
});

Breadcrumbs::register('add-reject-reason', function($breadcrumbs) {
    $breadcrumbs->parent('list-reject-reasons');
    $breadcrumbs->push('Add Form Reject Reason', route('rejectreasons.create'));
});

Breadcrumbs::register('edit-reject-reason', function($breadcrumbs, $id) {
    $breadcrumbs->parent('list-reject-reasons');
    $breadcrumbs->push('Edit Form Reject Reason', route('rejectreasons.edit', $id));
});