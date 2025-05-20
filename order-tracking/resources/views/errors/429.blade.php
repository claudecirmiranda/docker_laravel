@extends('errors::minimal')

@section('title', __('Muitas requisições'))
@section('code', '429')
@section('message', __('Desculpe, você fez muitas requisições.'))
