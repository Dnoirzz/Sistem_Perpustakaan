@extends('errors.layout')

@section('title', '503 Pemeliharaan Sistem')
@section('code', '503')
@section('icon', 'construction')
@section('icon-bg', 'bg-amber-50 border-amber-200 text-amber-800')
@section('pill-bg', 'bg-amber-50 text-amber-800 border-amber-200')
@section('headline', 'Pemeliharaan Sistem')
@section('message', $exception->getMessage() ?: 'Sistem Perpustakaan Digital sedang dalam proses pemeliharaan rutin. Silakan kembali beberapa saat lagi.')
