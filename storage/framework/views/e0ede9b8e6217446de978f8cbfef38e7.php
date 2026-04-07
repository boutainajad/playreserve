<?php $__env->startSection('title', 'Clubs Sportifs'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-12 bg-white border border-gray-200 rounded-[32px] p-8 md:p-10 shadow-sm border-b-8 border-b-playtomic-blue">
    <div class="max-w-2xl">
        <h1 class="text-4xl font-black text-[#0B1526] tracking-tight mb-4">Trouvez votre club</h1>
        <p class="text-gray-500 text-[17px] font-medium mb-8">Découvrez les meilleurs clubs de multi-sport au Maroc et réservez votre krinou.</p>
    </div>

    <form action="<?php echo e(route('clubs.index')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="relative group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-playtomic-blue transition-colors">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <input type="text" name="city" value="<?php echo e(request('city')); ?>" placeholder="Taper une ville (ex: Casablanca)..." 
                   class="w-full pl-11 pr-4 py-4 bg-[#f4f5f7] border-transparent rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold transition-all">
        </div>

        <div class="relative group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-playtomic-blue transition-colors">
                <i class="bi bi-award-fill"></i>
            </div>
            <select name="sport_type" class="w-full pl-11 pr-4 py-4 bg-[#f4f5f7] border-transparent rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold appearance-none transition-all cursor-pointer">
                <option value="">Tous les sports</option>
                <option value="football" <?php echo e(request('sport_type') == 'football' ? 'selected' : ''); ?>>⚽ Football</option>
                <option value="basketball" <?php echo e(request('sport_type') == 'basketball' ? 'selected' : ''); ?>>🏀 Basketball</option>
                <option value="volleyball" <?php echo e(request('sport_type') == 'volleyball' ? 'selected' : ''); ?>>🏐 Volleyball</option>
                <option value="handball" <?php echo e(request('sport_type') == 'handball' ? 'selected' : ''); ?>>🤾 Handball</option>
                <option value="piscine" <?php echo e(request('sport_type') == 'piscine' ? 'selected' : ''); ?>>🏊 Piscine</option>
            </select>
            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-playtomic-blue">
                <i class="bi bi-chevron-down"></i>
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-playtomic-blue text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30 text-[15px]">
                Rechercher
            </button>
            <?php if(request()->anyFilled(['city', 'sport_type'])): ?>
                <a href="<?php echo e(route('clubs.index')); ?>" class="w-14 bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-700 font-bold rounded-2xl flex items-center justify-center transition-all">
                    <i class="bi bi-arrow-counterclockwise text-xl"></i>
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php $__empty_1 = true; $__currentLoopData = $clubs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $club): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white border border-gray-200 rounded-[32px] overflow-hidden flex flex-col group relative shadow-sm hover:shadow-xl hover:translate-y-[-4px] transition-all duration-500">
            
            <div class="h-48 bg-playtomic-blue/5 relative overflow-hidden flex items-center justify-center border-b border-gray-100">
                <i class="bi bi-buildings text-playtomic-blue/10 text-7xl absolute animate-pulse"></i>
                
                
                <div class="absolute bottom-4 left-6 flex flex-wrap gap-2 z-10">
                    <?php
                        $sports = $club->terrains->pluck('sport_type')->unique();
                    ?>
                    <?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider text-playtomic-blue shadow-sm border border-playtomic-blue/20 flex items-center gap-1.5">
                            <?php if($sport == 'football'): ?> <i class="bi bi-dribbble"></i>
                            <?php elseif($sport == 'basketball'): ?> <i class="bi bi-basket"></i>
                            <?php elseif($sport == 'piscine'): ?> <i class="bi bi-water"></i>
                            <?php else: ?> <i class="bi bi-lightning-fill"></i> <?php endif; ?>
                            <?php echo e($sport); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                
                <div class="absolute top-4 right-6 bg-playtomic-lime text-black px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm z-10">
                    <?php echo e($club->city); ?>

                </div>
            </div>

            <div class="p-8 flex flex-col flex-1">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-2xl font-black text-[#0B1526] leading-tight mb-1"><?php echo e($club->name); ?></h3>
                        <p class="text-gray-400 font-bold text-[13px] uppercase tracking-wide">
                            <?php echo e($club->terrains->count()); ?> Terrains disponibles
                        </p>
                    </div>
                </div>
                
                <p class="text-[15px] text-gray-500 leading-relaxed font-medium mb-6 line-clamp-2">
                    <?php echo e($club->description); ?>

                </p>
                
                <div class="mt-auto pt-6 border-t border-gray-100 flex items-center justify-between gap-4">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-wider">Starting from</span>
                        <span class="text-lg font-black text-[#0B1526]">
                             <?php echo e(number_format($club->terrains->min('price_per_hour') ?? 0, 0)); ?> <span class="text-xs">DH</span>
                        </span>
                    </div>
                    <a href="<?php echo e(route('clubs.show', $club->id)); ?>" class="px-6 py-3.5 bg-playtomic-blue text-white font-black rounded-2xl text-[14px] hover:bg-blue-700 transition-all shadow-md shadow-playtomic-blue/10 flex items-center gap-2 group-hover:gap-3">
                        Book Now <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full flex flex-col items-center justify-center py-24 bg-white border border-gray-100 rounded-[40px] text-center shadow-sm">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <i class="bi bi-search text-4xl text-gray-300"></i>
            </div>
            <h4 class="text-2xl font-black text-[#0B1526] mb-2">Aucun résultat trouvé</h4>
            <p class="text-gray-500 font-medium max-w-sm">Désolé, nous n'avons trouvé aucun club correspondant à votre recherche. Essayez de sélectionner d'autres filtres.</p>
            <a href="<?php echo e(route('clubs.index')); ?>" class="mt-8 text-playtomic-blue font-black underline underline-offset-8">Effacer les filtres</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/clubs/index.blade.php ENDPATH**/ ?>