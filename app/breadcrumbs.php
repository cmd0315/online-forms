<?php

Breadcrumbs::register('dashboard', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('dashboard'));
});

Breadcrumbs::register('my-profile', function($breadcrumbs) {
    $breadcrumbs->push('My Profile', route('profile.index'));
});

Breadcrumbs::register('change-password', function($breadcrumbs) {
    $breadcrumbs->parent('my-profile');
    $breadcrumbs->push('Change Password', route('accounts.edit'));
});

Breadcrumbs::register('update-profile', function($breadcrumbs) {
    $breadcrumbs->parent('my-profile');
    $breadcrumbs->push('Update Profile', route('profile.edit'));
});

Breadcrumbs::register('add-employee', function($breadcrumbs) {
    $breadcrumbs->push('Add Employee Record', route('employees.create'));
});

Breadcrumbs::register('list-employees', function($breadcrumbs) {
    $breadcrumbs->push('Manage Employee Records', route('employees.index'));
});