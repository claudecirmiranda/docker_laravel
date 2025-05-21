

<?php $__env->startSection('title', 'Nagem - ' . ($title ?? 'Tivemos um problema')); ?>

<link rel="preload" as="style" href="//cloud.nagem.com.br/api/order-tracking/build/assets/error-69i9Ik0h.css" /><link rel="stylesheet" href="//cloud.nagem.com.br/api/order-tracking/build/assets/error-69i9Ik0h.css" />

<?php $__env->startSection('content'); ?>
    <header class="flex flex-col bg-white">
        <div class="flex items-center justify-center w-full px-4 py-8 mx-auto bg-primary">
            <a class="pr-6 md:pr-12" href="/">
                <span class="hidden" itemprop="name">Nagem.com.br</span>
                <img class="w-[88px] md:w-[134px]" src="//static.nagem.com.br/util/artefatos/asset/n/9821596550697/img/layout/logoNagem.png" alt="Nagem.com.br">
            </a>
        </div>
    </header>
    <div class="container flex flex-col mx-auto text-center grow font-baloo animate-slidein">
        <h2 class="mx-auto my-8 mt-16 text-2xl font-bold text-primary"><?php echo $__env->yieldContent('title', 'Tivemos um problema'); ?></h2>
        <section class="my-8 font-bold text-sliced text-primary opacity-85 text-7xl md:text-9xl">
            <div class="top">Ooops!</div>
            <div class="bottom" aria-hidden="true">Ooops!</div>
        </section>
        <p class="mx-auto my-8 max-w-80"><?php echo $__env->yieldContent('message', 'Tivemos um problema. Tente novamente mais tarde!'); ?></p>
        <a href="//www.nagem.com.br" class="px-4 py-2 mx-auto my-10 font-bold text-white rounded w-fit bg-primary hover:opacity-95">
            Voltar para a página inicial
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/errors/minimal.blade.php ENDPATH**/ ?>