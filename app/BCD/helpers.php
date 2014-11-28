<?php

function sort_employees_by($column, $body) {
	$direction = (Request::get('direction') == 'asc') ? 'desc' : 'asc';
	$search = Request::get('q');
	return link_to_route('employees.index', $body, ['q' => $search, 'sortBy' => $column, 'direction' => $direction]);
}


function sort_departments_by($column, $body) {
	$direction = (Request::get('direction') == 'asc') ? 'desc' : 'asc';
	$search = Request::get('q');
	return link_to_route('departments.index', $body, ['q' => $search, 'sortBy' => $column, 'direction' => $direction]);
}

function sort_clients_by($column, $body) {
	$direction = (Request::get('direction') == 'asc') ? 'desc' : 'asc';
	$search = Request::get('q');
	return link_to_route('clients.index', $body, ['q' => $search, 'sortBy' => $column, 'direction' => $direction]);
}

function sort_rejectreasons_by($column, $body) {
	$direction = (Request::get('direction') == 'asc') ? 'desc' : 'asc';
	$search = Request::get('q');
	return link_to_route('rejectreasons.index', $body, ['q' => $search, 'sortBy' => $column, 'direction' => $direction]);
}

function sort_rfps_by($column, $body) {
	$direction = (Request::get('direction') == 'asc') ? 'desc' : 'asc';
	$search = Request::get('q');
	return link_to_route('rfps.index', $body, ['q' => $search, 'sortBy' => $column, 'direction' => $direction]);
}