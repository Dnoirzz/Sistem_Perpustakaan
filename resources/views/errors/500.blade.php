@extends('errors.layout')

@section('title', '500 Server Error')
@section('code', '500')
@section('icon', 'dns')
@section('icon-bg', 'bg-rose-50 border-rose-200 text-rose-700')
@section('pill-bg', 'bg-rose-50 text-rose-800 border-rose-200')
@section('headline', 'Gangguan Server Internal')
@section('message', $exception->getMessage() ?: 'Terjadi kesalahan internal pada server sistem. Silakan coba beberapa saat lagi.')
