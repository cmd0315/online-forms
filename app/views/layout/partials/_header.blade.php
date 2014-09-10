<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ isset($pageTitle) ? $pageTitle : '' }} | BCD Online Forms</title>
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/main.css') }}
</head>