@extends('layout.master')
@include('layout.header')
@section('tittel', 'Om oss - Westfinder')

<div class="omoss col-md-10 col-md-offset-1">
    <img src="/bilder/logo.png" style="height:250px;">
    <h1>Westfinder</h1>
    <p>Westfinder er en applikasjon for studenter ved Westerdals, og tar utgangspunkt i campusene ved Fjerdingen og Vulkan for å gi informasjon om deres nærmiljøer.</p>
    <h2>Teamet</h2>
    <p>Applikasjonen er designet og utviklet som et studentprosjekt av Hans, Joakim, Sarah, Thomas og Jørgen.</p>
</div>

<style>
    body{
        position: absolute;
        background-size: cover;
        background-image: url("/bilder/forside.jpg");
        display: block;
        height: 100%;
        width: 100%;
        left: 0;
        right: 0;
        z-index: 1;
        text-align: center;
        margin-bottom: 20px;
    }
</style>
