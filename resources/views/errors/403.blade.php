@extends('errors.layout')

@section('title', '403 Akses Ditolak')
@section('code', '403')
@section('icon', 'lock_person')
@section('icon-bg', 'bg-rose-50 border-rose-200 text-rose-700')
@section('pill-bg', 'bg-rose-50 text-rose-800 border-rose-200')
@section('headline', 'Akses Ditolak')
@section('message', $exception->getMessage() ?: 'Anda tidak memiliki hak akses untuk membuka halaman atau naskah dokumen ini.')
