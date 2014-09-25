<?php

Breadcrumbs::register('dashboard', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('dashboard'));
});

Breadcrumbs::register('my-profile', function($breadcrumbs, $username) {
    $breadcrumbs->push('My Profile', route('profile.show', $username));
});

Breadcrumbs::register('change-password', function($breadcrumbs) {
    $breadcrumbs->parent('my-profile');
    $breadcrumbs->push('Change Password', route('accounts.edit'));
});

Breadcrumbs::register('update-profile', function($breadcrumbs, $username) {
    $breadcrumbs->parent('my-profile', $username);
    $breadcrumbs->push('Update Profile', route('profile.edit', $username));
});

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

Breadcrumbs::register('add-department', function($breadcrumbs) {
    $breadcrumbs->push('Add Department Record', route('departments.create'));
});

Breadcrumbs::register('list-departments', function($breadcrumbs) {
    $breadcrumbs->push('Manage Department Records', route('departments.index'));
});