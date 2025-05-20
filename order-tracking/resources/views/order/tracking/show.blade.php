@extends('components.layouts.base')

@section('title', 'Nagem - Pedido '.$order->order_id)

<?php
$statusCompleted = array_column((array)$order->tracking->toArray(), 'step');
$countActives = 0;

$stepPositions = [];
foreach ($statusCompleted as $status) {
    if (array_key_exists($status, App\Models\Order::STEP)) {
        $stepPositions[$status] = App\Models\Order::STEP[$status]['pos'];
    }
}
asort($stepPositions);
$maxCompletedStep = end($stepPositions);

?>

@section('content')
<header class="sticky top-0 z-10 flex flex-col bg-white">
    <div class="flex items-center justify-center w-full px-4 py-8 mx-auto bg-primary">
        <a class="pr-6 md:pr-12" href="/">
            <span class="hidden" itemprop="name">Nagem.com.br</span>
            <img class="w-[88px] md:w-[134px]" src="//static.nagem.com.br/util/artefatos/asset/n/9821596550697/img/layout/logoNagem.png" alt="Nagem.com.br">
        </a>
        <h2 class="font-baloo font-bold text-lg md:text-[2rem] text-white">Rastreio de Pedidos</h2>
    </div>
    <h2 class="mx-auto my-5 text-2xl font-bold md:my-10 md:mb-16 font-baloo text-primary">Pedido {{ $order->order_id }}</h2>
    <h3 class="m-auto mb-6 text-sm font-bold md:hidden">{{ $order->tracking->last() ? App\Models\Order::STEP[$order->tracking->last()->step]['title'] : '' }}</h3>
</header>
<div class="flex justify-center animate-slidein">  
    <ul id="progress-bar-container" class="relative grid grid-cols-5 gap-8 mb-2 text-sm font-semibold text-center md:mb-16 md:gap-20 color-white text-neutral-400 font-baloo">  
        @foreach (App\Models\Order::STEP as $key => $tracking)  
        <li class="relative">  
            <span class="flex justify-center m-auto md:mb-4 items-center rounded-full aspect-square w-10 md:w-16 {{ $loop->index < $maxCompletedStep ? 'bg-success text-white' : 'bg-neutral-300' }}">  
                <span class="md:scale-100 scale-[.57]">@include('components.icons.'.$tracking['icon'])</span>  
            </span>  
            <p class="hidden md:block {{ $loop->index < $maxCompletedStep ? 'text-black' : '' }}">{{ $tracking['title'] }}</p>  
        </li>  
        @endforeach  
        <!-- Barra de progresso -->  
        <div id="progress-bar-wrapper" class="absolute -z-10 py-">  
            <div id="progress-bar" class="relative h-1 my-4 bg-neutral-300 md:my-8">  
                <!-- Parte ativa da barra -->  
                <div id="active-progress" class="absolute h-full bg-success" style="width: calc(<?= min((($maxCompletedStep - .5) / (count(App\Models\Order::STEP) - 1)) * 100, 100) ?>%);"></div>  
            </div>  
        </div>  
    </ul>  
</div>

<div class="container flex flex-col flex-grow px-4 py-8 mx-auto md:py-0 animate-slidein">
    <div class="grid grid-cols-3 gap-4 mt-2 mb-10 md:mx-2">
        <div class="flex md:flex-row flex-col md:items-center rounded-[10px] border-solid border border-neutral-400 px-4 md:px-6 py-4">
            <span class="relative pr-4 text-primary">
                <span class="-ml-[30%] md:ml-0 block scale-[.6] md:scale-100">@include('components.icons.calendar')</span>
            </span>
            <div>
                <h3 class="text-xs md:text-sm text-neutral-500">Data estimada de entrega</h3>
                <p class="text-sm font-semibold">
                    {{ $order->estimated_delivery ? $order->estimated_delivery->format('d/m/Y') : '' }}
                </p>
            </div>
        </div>
        <div class="flex md:flex-row flex-col md:items-center rounded-[10px] border-solid border border-neutral-400 px-4 md:px-6 py-4">
            <span class="relative pr-4 text-primary">
                <span class="-ml-[30%] md:ml-0 block scale-[.6] md:scale-100">@include('components.icons.package')</span>
            </span>
            <div>
                <h3 class="text-xs md:text-sm text-neutral-500">Saída da</h3>
                <p class="text-sm font-semibold">{{ $order->origin_title }}</p>
                <p class="text-sm font-semibold">{{ $order->origin_zipcode }}</p>
            </div>
        </div>
        <div class="flex md:flex-row flex-col md:items-center rounded-[10px] border-solid border border-neutral-400 px-4 md:px-6 py-4">
            <span class="relative pr-4 text-primary">
                <span class="-ml-[30%] md:ml-0 block scale-[.6] md:scale-100">@include('components.icons.truck-bold')</span>
            </span>
            <div>
                <h3 class="text-xs md:text-sm text-neutral-500">Entrega para</h3>
                <div class="relative flex group">
                    <span class="block max-w-full overflow-hidden text-sm font-semibold truncate whitespace-normal cursor-pointer" id="city-span">
                        {{ $order->destination_city }} / {{ $order->destination_state }}
                    </span>
                    <!-- Tooltip -->
                    <div id="tooltip" class="absolute px-1 mx-auto text-sm text-gray-100 transition-opacity -translate-x-1/2 -translate-y-full bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 left-1/2">
                        {{ $order->destination_city }} / {{ $order->destination_state }}
                    </div>
                </div>
                <p class="text-sm font-semibold">{{ $order->destination_zipcode }}</p>
            </div>
        </div>
    </div>
    <table class="hidden table-auto md:table">
        <thead>
            <tr>
                <th class="text-start">Data / Hora</th>
                <th class="text-start">Status</th>
                <th class="text-start">Detalhes</th>
                <th class="text-start">Observações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->tracking as $tracking)
            <tr>
                <td class="text-sm text-neutral-500">{{ $tracking->created_at->format('d/m/Y H:i') }}</td>
                <td class="font-bold text-primary">{{ $tracking->status }}</td>
                <td>{{ $tracking->message }}</td>
                <td class="text-sm text-neutral-500">{{ $tracking->observation }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="flex flex-col gap-4 md:hidden font-baloo">
        @foreach ($order->tracking as $tracking)
        <div class="bg-white border rounded-lg table-one-tracking">
            <div class="grid grid-cols-3 gap-4">
                <div>Data / Hora</div>
                <div class="text-neutral-500">{{ $tracking->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>Status</div>
                <div class="font-bold text-primary">{{ App\Models\Order::STEP[$tracking->step]['title'] }}</div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>Detalhes</div>
                <div>{{ $tracking->message }}</div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>Observações</div>
                <div class="text-neutral-500">{{ $tracking->observation }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
@push('scripts')
<script>
    const adjustProgressBar = function() {
        const li = document.querySelectorAll('#progress-bar-container li');
        const progressBarWrapper = document.getElementById('progress-bar-wrapper');

        if (li.length > 0 && progressBarWrapper) {
            // Calcula metade da largura do primeiro e do último <li>
            const firstLiHalfWidth = li[0].offsetWidth / 2;
            const lastLiHalfWidth = li[li.length - 1].offsetWidth / 2;

            // Aplica os estilos dinamicamente ao progressBarWrapper
            progressBarWrapper.style.left = `${firstLiHalfWidth}px`;
            progressBarWrapper.style.right = `${lastLiHalfWidth}px`;
        }
    }
    document.addEventListener('DOMContentLoaded', adjustProgressBar);
    window.addEventListener('resize', adjustProgressBar);

    // Função para esconder o tooltip
    function hideTooltip() {
        const tooltip = document.getElementById('tooltip');
        tooltip.classList.add('hidden');
    }

    // Adiciona o evento de clique no span
    document.getElementById('city-span').addEventListener('click', function(event) {
        const tooltip = document.getElementById('tooltip');

        // Exibe o tooltip
        tooltip.classList.remove('hidden');

        // Remove o tooltip após 10 segundos
        setTimeout(hideTooltip, 10000);

        // Previne o clique no span de fechar o tooltip imediatamente
        event.stopPropagation();
    });

    // Esconde o tooltip quando o usuário clica em qualquer outro lugar da tela
    document.addEventListener('click', function() {
        hideTooltip();
    });

    // Previne que o tooltip desapareça se o clique for dentro dele
    document.getElementById('tooltip').addEventListener('click', function(event) {
        event.stopPropagation();
    });
</script>
@endpush