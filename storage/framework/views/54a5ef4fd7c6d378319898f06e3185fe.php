<?php $__env->startSection('title', $club->name); ?>

<?php $__env->startSection('content'); ?>


<div class="relative bg-playtomic-blue rounded-3xl overflow-hidden mb-10 shadow-lg mt-4 h-[250px] md:h-[300px] flex items-center justify-center">
    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-overlay"></div>
    <div class="relative z-10 text-center px-4 w-full max-w-4xl">
        <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight"><?php echo e($club->name); ?></h1>
        <div class="flex flex-wrap justify-center items-center gap-4 text-white/90 font-medium text-[15px]">
            <span class="flex items-center gap-1.5"><i class="bi bi-geo-alt-fill text-playtomic-lime"></i> <?php echo e($club->city); ?></span>
            <span class="hidden md:inline">|</span>
            <span class="flex items-center gap-1.5"><i class="bi bi-telephone-fill text-playtomic-lime"></i> <?php echo e($club->phone); ?></span>
        </div>
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-8">
    
    <div class="w-full lg:w-1/3">
        <div class="bg-white border border-gray-200 rounded-[24px] p-8 sticky top-28 shadow-sm">
            <h3 class="text-[#0B1526] font-black text-xl mb-4">About this club</h3>
            <p class="text-gray-500 font-medium leading-relaxed mb-6 text-[15px]">
                <?php echo e($club->description); ?>

            </p>
            <hr class="border-gray-100 mb-6">
            <h4 class="text-[#0B1526] font-bold text-[17px] mb-4">Location</h4>
            <div class="flex items-start gap-3 text-gray-500 font-medium mb-4">
                <i class="bi bi-geo-alt-fill text-playtomic-blue text-lg mt-0.5"></i>
                <span><?php echo e($club->city); ?></span>
            </div>
        </div>
    </div>

    
    <div class="w-full lg:w-2/3">
        <h2 class="text-2xl font-black text-[#0B1526] mb-6">Available Courts</h2>
        
        <?php if($terrains->count() > 0): ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $terrains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $terrain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white border border-gray-200 rounded-[20px] p-6 hover:shadow-md transition-shadow flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 rounded-full bg-[#F4F5F7] flex items-center justify-center text-playtomic-blue text-2xl flex-shrink-0">
                                <?php if($terrain->sport_type == 'football'): ?>
                                    <i class="bi bi-dribbble"></i>
                                <?php elseif($terrain->sport_type == 'basketball'): ?>
                                    <i class="bi bi-basket"></i>
                                <?php elseif($terrain->sport_type == 'volleyball'): ?>
                                    <i class="bi bi-circle"></i>
                                <?php elseif($terrain->sport_type == 'handball'): ?>
                                    <i class="bi bi-hand-thumbs-up"></i>
                                <?php elseif($terrain->sport_type == 'piscine'): ?>
                                    <i class="bi bi-water"></i>
                                <?php elseif($terrain->sport_type == 'padel'): ?>
                                    <i class="bi bi-balloon"></i>
                                <?php else: ?>
                                    <i class="bi bi-grid-3x3-gap-fill"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <h4 class="text-[#0B1526] font-extrabold text-xl"><?php echo e($terrain->name); ?></h4>
                                    <span class="bg-[#f0f4ff] text-playtomic-blue px-2.5 py-1 rounded-md text-[11px] font-black uppercase tracking-wide border border-blue-100">
                                        <?php echo e(ucfirst($terrain->sport_type)); ?>

                                    </span>
                                </div>
                                <p class="text-[17px] font-black text-[#0B1526] mt-2">
                                    <?php echo e(number_format($terrain->price_per_hour, 0)); ?> <span class="text-[13px] text-gray-500 font-semibold uppercase">DH / heure</span>
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 md:mt-0 flex w-full md:w-auto">
                            <?php if($terrain->is_available): ?>
                                <a href="<?php echo e(route('reservations.create', $terrain->id)); ?>" class="w-full md:w-auto px-8 py-3.5 bg-playtomic-blue text-white font-bold rounded-full text-[15px] hover:bg-blue-700 transition-colors shadow-md shadow-playtomic-blue/20 text-center">
                                    Book Now
                                </a>
                            <?php else: ?>
                                <span class="w-full md:w-auto px-8 py-3.5 bg-gray-100 text-gray-400 font-bold rounded-full text-[15px] text-center border border-gray-200 cursor-not-allowed">
                                    Unavailable
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="flex flex-col items-center justify-center p-12 bg-white border border-gray-200 rounded-[20px] text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <i class="bi bi-calendar-x text-3xl text-gray-300"></i>
                </div>
                <h3 class="text-[#0B1526] font-bold text-lg mb-2">No courts available</h3>
                <p class="text-gray-500 font-medium mb-0">This club hasn't added any bookable courts yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/clubs/show.blade.php ENDPATH**/ ?>