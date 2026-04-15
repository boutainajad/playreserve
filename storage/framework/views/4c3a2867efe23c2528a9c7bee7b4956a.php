<?php $__env->startSection('title', 'My Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-10">
    <div class="bg-white border border-gray-200 rounded-[28px] p-8 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-[#0B1526] mb-1 tracking-tight">Hello, <?php echo e(auth()->user()->name); ?>!</h1>
            <p class="text-gray-400 font-medium text-[16px]">Find your next court and manage your bookings.</p>
        </div>
        <div class="w-14 h-14 rounded-full bg-playtomic-blue/10 flex items-center justify-center text-playtomic-blue text-2xl">
            <i class="bi bi-person-fill"></i>
        </div>
</div>

<div class="mb-10 bg-white border border-gray-200 rounded-[28px] p-8 shadow-sm">
    <h2 class="text-xl font-black text-[#0B1526] mb-5 flex items-center gap-2">
        <i class="bi bi-search text-playtomic-blue"></i> Find a Court
    </h2>
    <form action="<?php echo e(route('search')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="relative">
            <div class="absolute inset-y-0 left-4 flex items-center shadow-none pointer-events-none text-gray-400">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <input type="text" name="city" placeholder="City..." class="w-full pl-10 px-4 py-3.5 bg-[#f4f5f7] border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-playtomic-blue font-bold transition-all">
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400">
                <i class="bi bi-award-fill"></i>
            </div>
            <select name="sport_type" class="w-full pl-10 px-4 py-3.5 bg-[#f4f5f7] border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-playtomic-blue font-bold appearance-none transition-all cursor-pointer">
                <option value="">All sports</option>
                <option value="football">Football</option>
                <option value="basketball">Basketball</option>
                <option value="padel">Padel</option>
            </select>
        </div>
        <div class="relative">
             <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400">
                <i class="bi bi-calendar-event-fill"></i>
            </div>
            <input type="date" name="date" class="w-full pl-10 px-4 py-3.5 bg-[#f4f5f7] border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-playtomic-blue font-bold transition-all" min="<?php echo e(date('Y-m-d')); ?>">
        </div>
        <div class="relative">
             <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400">
                <i class="bi bi-clock-fill"></i>
            </div>
            <input type="time" name="time" class="w-full pl-10 px-4 py-3.5 bg-[#f4f5f7] border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-playtomic-blue font-bold transition-all cursor-pointer" step="1800">
        </div>
        <button type="submit" class="bg-playtomic-blue text-white font-black py-3.5 rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30 text-[15px]">
            Search Courts
        </button>
    </form>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div class="lg:col-span-1">
        <h2 class="text-xl font-black text-[#0B1526] mb-5 flex items-center gap-2">
            <i class="bi bi-calendar-check-fill text-playtomic-blue"></i> My Reservations
        </h2>

        <?php if($reservations->count() > 0): ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white border border-gray-100 rounded-[20px] p-5 shadow-sm hover:shadow-md transition-all">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <div class="text-lg font-black text-[#0B1526]">
                                    <?php echo e(\Carbon\Carbon::parse($res->reservation_date)->format('d M Y')); ?>

                                </div>
                                <div class="text-sm font-bold text-playtomic-blue">
                                    <?php echo e(\Carbon\Carbon::parse($res->start_time)->format('H:i')); ?> – <?php echo e(\Carbon\Carbon::parse($res->end_time)->format('H:i')); ?>

                                </div>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-lg
                                <?php if($res->status == 'confirmed'): ?> bg-green-100 text-green-700
                                <?php elseif($res->status == 'pending'): ?> bg-yellow-100 text-yellow-700
                                <?php else: ?> bg-red-100 text-red-700 <?php endif; ?>">
                                <?php echo e($res->status); ?>

                            </span>
                        </div>
                        <div class="pt-3 border-t border-gray-50">
                            <p class="font-bold text-[#0B1526] text-[15px]"><?php echo e($res->terrain->name); ?></p>
                            <p class="text-sm text-gray-400 font-medium flex items-center gap-1.5 mt-1">
                                <i class="bi bi-geo-alt-fill text-playtomic-lime"></i> <?php echo e($res->terrain->club->name); ?>

                            </p>
                            <p class="font-black text-playtomic-blue text-base mt-2"><?php echo e(number_format($res->total_price, 0)); ?> DH</p>
                        </div>
                        
                        <?php if(in_array($res->status, ['confirmed', 'pending'])): ?>
                            <?php
                                $reservationDateTime = \Carbon\Carbon::parse($res->reservation_date)->setTimeFromTimeString($res->start_time);
                                $isTooLate = now()->diffInHours($reservationDateTime, false) < 24;
                            ?>
                            
                            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                                <form action="<?php echo e(route('reservations.cancel', $res->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?')">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-[12px] font-black <?php echo e($isTooLate ? 'text-gray-300 cursor-not-allowed' : 'text-red-500 hover:text-red-700'); ?> flex items-center gap-1.5 transition-colors group">
                                        <i class="bi <?php echo e($isTooLate ? 'bi-lock-fill' : 'bi-x-circle-fill'); ?>"></i> 
                                        CANCEL RESERVATION
                                    </button>
                                </form>
                                
                                <?php if($isTooLate): ?>
                                    <span class="text-[10px] font-bold text-gray-400 bg-gray-50 px-2 py-0.5 rounded-md">Fixed (< 24h)</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="bg-white border border-gray-100 rounded-[20px] p-10 text-center shadow-sm">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-calendar-x text-3xl text-gray-300"></i>
                </div>
                <p class="text-gray-400 font-bold text-sm">No reservations yet.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="lg:col-span-2">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
            <h2 class="text-xl font-black text-[#0B1526] flex items-center gap-2">
                <i class="bi bi-buildings text-playtomic-blue"></i> All Clubs
            </h2>

            <form action="<?php echo e(route('dashboard')); ?>" method="GET" class="relative">
                <select name="city" onchange="this.form.submit()"
                    class="pl-10 pr-8 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-sm text-gray-700 appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-playtomic-blue shadow-sm min-w-[190px]">
                    <option value="">📍 All cities</option>
                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($city); ?>" <?php echo e(request('city') == $city ? 'selected' : ''); ?>><?php echo e($city); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-playtomic-blue">
                    <i class="bi bi-geo-alt-fill text-sm"></i>
                </div>
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                    <i class="bi bi-chevron-down text-xs"></i>
                </div>
            </form>
        </div>

        <?php if(request('city')): ?>
            <div class="mb-4 flex items-center gap-2">
                <span class="text-sm font-bold text-gray-500">Filtered by city: <span class="text-[#0B1526]"><?php echo e(request('city')); ?></span></span>
                <a href="<?php echo e(route('dashboard')); ?>" class="text-xs text-playtomic-blue font-bold underline underline-offset-4">Clear</a>
            </div>
        <?php endif; ?>

        <?php if($clubs->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php $__currentLoopData = $clubs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $club): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white border border-gray-200 rounded-[24px] overflow-hidden flex flex-col shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                        <div class="h-40 relative flex items-center justify-center border-b border-gray-100 overflow-hidden shrink-0">
                            <?php if($club->cover_image): ?>
                                <img src="<?php echo e(Storage::url($club->cover_image)); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <?php else: ?>
                                <div class="absolute inset-0 bg-gradient-to-br from-playtomic-blue/5 to-playtomic-lime/10"></div>
                                <i class="bi bi-buildings text-[80px] text-playtomic-blue/10 absolute"></i>
                            <?php endif; ?>
                            <div class="absolute top-3 right-4 bg-playtomic-lime text-black px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wide">
                                <?php echo e($club->city); ?>

                            </div>
                            <div class="absolute bottom-3 left-4 flex gap-1.5 flex-wrap z-10">
                                <?php $__currentLoopData = $club->terrains->pluck('sport_type')->unique(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="bg-white/80 backdrop-blur-sm border border-white px-2.5 py-1 rounded-full text-[10px] font-black text-playtomic-blue uppercase shadow-sm">
                                        <?php if($sport=='football'): ?>⚽
                                        <?php elseif($sport=='basketball'): ?>🏀
                                        <?php elseif($sport=='volleyball'): ?>🏐
                                        <?php elseif($sport=='handball'): ?>🤾
                                        <?php elseif($sport=='piscine'): ?>🏊
                                        <?php else: ?>🎯<?php endif; ?>
                                        <?php echo e($sport); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="w-16 h-16 absolute -bottom-8 right-6 rounded-2xl bg-white shadow-md border-2 border-white flex flex-shrink-0 items-center justify-center text-playtomic-blue text-2xl z-20 overflow-hidden">
                                <?php if($club->logo): ?>
                                    <img src="<?php echo e(Storage::url($club->logo)); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="bi bi-shop text-3xl text-gray-300"></i>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="p-6 pt-5 flex flex-col flex-1">
                            <h3 class="text-xl font-black text-[#0B1526] mb-1"><?php echo e($club->name); ?></h3>
                            <p class="text-sm text-gray-400 font-medium line-clamp-2 mb-5"><?php echo e($club->description); ?></p>

                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-xs font-black text-gray-400 uppercase tracking-wide">
                                    <?php echo e($club->terrains->count()); ?> court<?php echo e($club->terrains->count() > 1 ? 's' : ''); ?>

                                </span>
                                <a href="<?php echo e(route('clubs.show', $club->id)); ?>"
                                   class="px-5 py-2.5 bg-playtomic-blue text-white font-black rounded-xl text-[13px] hover:bg-blue-700 transition-colors flex items-center gap-2">
                                    Book Now <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="bg-white border border-gray-100 rounded-[24px] p-16 text-center shadow-sm">
                <i class="bi bi-search text-5xl text-gray-200 mb-4 block"></i>
                <h4 class="text-lg font-bold text-gray-400">No clubs found in this city.</h4>
                <a href="<?php echo e(route('dashboard')); ?>" class="text-playtomic-blue font-black mt-3 inline-block underline underline-offset-4 text-sm">See all clubs</a>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/dashboard/membre.blade.php ENDPATH**/ ?>