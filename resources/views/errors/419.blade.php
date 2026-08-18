@extends('errors.layout')

@section('title', '419 Sesi Berakhir')
@section('code', '419')
@section('icon', 'history_toggle_off')
@section('icon-bg', 'bg-cyan-50 border-cyan-200 text-cyan-800')
@section('pill-bg', 'bg-cyan-50 text-cyan-800 border-cyan-200')
@section('headline', 'Sesi Halaman Kadaluarsa')
@section('message', $exception->getMessage() ?: 'Sesi keamanan halaman telah berakhir karena terlalu lama tidak ada aktivitas. Silakan muat ulang halaman.')
