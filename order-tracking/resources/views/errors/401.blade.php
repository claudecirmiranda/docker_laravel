@extends('errors::minimal')

@section('title', __('Não autorizado'))
@section('code', '401')
@section('message', __('Parece que você não tem permissão para acessar esta página.'))
