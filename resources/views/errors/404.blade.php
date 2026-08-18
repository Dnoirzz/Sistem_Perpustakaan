@extends('errors.layout')

@section('title', '404 Tidak Ditemukan')
@section('code', '404')
@section('icon', 'find_in_page')
@section('icon-bg', 'bg-amber-50 border-amber-200 text-amber-800')
@section('pill-bg', 'bg-amber-50 text-amber-800 border-amber-200')
@section('headline', 'Halaman Tidak Ditemukan')
@section('message', $exception->getMessage() ?: 'Halaman atau naskah dokumen yang Anda cari tidak dapat ditemukan atau telah dipindahkan.')
