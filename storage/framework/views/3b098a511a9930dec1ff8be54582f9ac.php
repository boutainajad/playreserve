

<?php $__env->startSection('title', 'Book ' . $terrain->name); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <?php if(session('error')): ?>
        <div class="mb-8 p-6 bg-red-50 border-l-8 border-red-500 text-red-800 rounded-2xl font-black flex items-center gap-4 animate-fadeInUp shadow-sm">
            <div class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center flex-shrink-0">
                <i class="bi bi-exclamation-lg text-xl"></i>
            </div>
            <div>
                <div class="text-xs uppercase tracking-widest text-red-500/70 mb-0.5">Reservation Error</div>
                <div class="text-lg leading-tight"><?php echo e(session('error')); ?></div>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="mb-10 text-center md:text-left flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <nav class="flex items-center gap-2 text-sm font-bold text-gray-400 mb-4 tracking-wide uppercase">
                <a href="<?php echo e(route('home')); ?>" class="hover:text-playtomic-blue transition-colors">Home</a>
                <i class="bi bi-chevron-right text-[10px]"></i>
                <a href="<?php echo e(route('clubs.show', $terrain->club->id)); ?>" class="hover:text-playtomic-blue transition-colors"><?php echo e($terrain->club->name); ?></a>
                <i class="bi bi-chevron-right text-[10px]"></i>
                <span class="text-playtomic-blue"><?php echo e($terrain->name); ?></span>
            </nav>
            <h1 class="text-4xl font-black text-[#0B1526] tracking-tight mb-2">Book your court</h1>
            <p class="text-gray-500 text-[17px] font-medium">Select a date and time to start playing.</p>
        </div>
        <div class="w-20 h-20 bg-playtomic-blue/10 rounded-3xl flex items-center justify-center text-playtomic-blue text-3xl">
             <?php if($terrain->sport_type == 'football'): ?> <i class="bi bi-dribbble"></i>
             <?php elseif($terrain->sport_type == 'basketball'): ?> <i class="bi bi-basket"></i>
             <?php elseif($terrain->sport_type == 'piscine'): ?> <i class="bi bi-water"></i>
             <?php else: ?> <i class="bi bi-grid-3x3-gap-fill"></i> <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white border border-gray-200 rounded-[32px] p-8 shadow-sm">
                <h3 class="text-[#0B1526] font-black text-xl mb-6">1. Pick a date</h3>
                <form action="<?php echo e(route('reservations.create', $terrain->id)); ?>" method="GET" id="dateFilterForm" class="relative group">
                    <input type="date" name="date" value="<?php echo e($date); ?>" min="<?php echo e(date('Y-m-d')); ?>" 
                           onchange="document.getElementById('dateFilterForm').submit()"
                           class="w-full px-6 py-4 bg-[#f4f5f7] border-transparent rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-black text-lg transition-all cursor-pointer">
                    <i class="bi bi-calendar-event absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-playtomic-blue transition-colors"></i>
                </form>
            </div>

            
            <div class="bg-white border border-gray-200 rounded-[32px] p-8 shadow-sm min-h-[400px]">
                <h3 class="text-[#0B1526] font-black text-xl mb-6">2. Select a timeslot</h3>
                
                <?php if($creneaux->count() > 0): ?>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <?php $__currentLoopData = $creneaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($slot->is_reserved): ?>
                                <button type="button" disabled
                                        class="relative flex flex-col items-center justify-center py-4 px-2 border-2 border-transparent bg-gray-50/50 cursor-not-allowed rounded-2xl transition-all overflow-hidden">
                                    <div class="absolute inset-0 bg-gray-100/40 backdrop-blur-[1px] flex items-center justify-center z-10">
                                        <span class="text-[9px] font-black text-red-500 bg-white border border-red-200 px-2 py-0.5 rounded-full shadow-sm uppercase tracking-tighter transform -rotate-12">RESERVED</span>
                                    </div>
                                    <span class="relative text-[15px] font-black text-gray-300">
                                        <?php echo e(\Carbon\Carbon::parse($slot->start_time)->format('H:i')); ?>

                                    </span>
                                    <span class="relative text-[11px] font-bold text-gray-200 uppercase tracking-wide">
                                        <?php echo e(Carbon\Carbon::parse($slot->duration_minutes ?? 60)->format('g\h')); ?> session
                                    </span>
                                </button>
                            <?php else: ?>
                                <button type="button" 
                                        onclick="selectSlot('<?php echo e($slot->start_time); ?>', '<?php echo e($slot->end_time); ?>', this)"
                                        class="slot-btn group relative flex flex-col items-center justify-center py-4 px-2 border-2 border-transparent bg-gray-50 hover:bg-playtomic-blue/5 rounded-2xl transition-all active:scale-95 overflow-hidden">
                                    <div class="absolute inset-0 bg-playtomic-blue opacity-0 group-[.selected]:opacity-100 transition-opacity"></div>
                                    <span class="relative text-[15px] font-black text-[#0B1526] group-[.selected]:text-white transition-colors">
                                        <?php echo e(\Carbon\Carbon::parse($slot->start_time)->format('H:i')); ?>

                                    </span>
                                    <span class="relative text-[11px] font-bold text-gray-400 group-[.selected]:text-white/80 uppercase tracking-wide transition-colors">
                                        <?php echo e(Carbon\Carbon::parse($slot->duration_minutes ?? 60)->format('g\h')); ?> session
                                    </span>
                                    <div class="absolute -bottom-1 -right-1 group-[.selected]:block hidden">
                                        <div class="bg-playtomic-lime p-1 rounded-tl-lg shadow-sm">
                                            <i class="bi bi-check-lg text-black text-[10px] font-black"></i>
                                        </div>
                                    </div>
                                </button>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <i class="bi bi-slash-circle text-gray-300 text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-[#0B1526] mb-1">No slots available</h4>
                        <p class="text-gray-500 font-medium">Try picking another date.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-200 rounded-[32px] p-8 shadow-sm sticky top-28 border-t-8 border-t-playtomic-blue">
                <h3 class="text-[#0B1526] font-black text-xl mb-6">Booking Summary</h3>
                
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-playtomic-bg flex items-center justify-center text-lg">
                            <i class="bi bi-geo-alt-fill text-playtomic-lime"></i>
                        </div>
                        <div>
                            <div class="text-[11px] uppercase font-black text-gray-400 tracking-wider">Club</div>
                            <div class="font-bold text-[#0B1526]"><?php echo e($terrain->club->name); ?></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-playtomic-bg flex items-center justify-center text-lg">
                            <i class="bi bi-calendar-check-fill text-playtomic-blue"></i>
                        </div>
                        <div>
                            <div class="text-[11px] uppercase font-black text-gray-400 tracking-wider">Date</div>
                            <div class="font-bold text-[#0B1526]"><?php echo e(\Carbon\Carbon::parse($date)->translatedFormat('l, d M Y')); ?></div>
                        </div>
                    </div>

                    <div id="selectionPreview" class="hidden">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-playtomic-bg flex items-center justify-center text-lg">
                                <i class="bi bi-clock-fill text-playtomic-blue"></i>
                            </div>
                            <div>
                                <div class="text-[11px] uppercase font-black text-gray-400 tracking-wider">Time</div>
                                <div id="timeText" class="font-bold text-[#0B1526]">--:-- to --:--</div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-6">

                    <div class="flex items-center justify-between mb-8">
                        <div class="text-gray-500 font-bold">Total to pay</div>
                        <div class="text-3xl font-black text-[#0B1526]">
                            <span id="totalPriceText">0.00</span> <span class="text-sm">DH</span>
                        </div>
                    </div>

                    <form action="<?php echo e(route('reservations.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="terrain_id" value="<?php echo e($terrain->id); ?>">
                        <input type="hidden" name="reservation_date" value="<?php echo e($date); ?>">
                        <input type="hidden" id="input_start" name="start_time" required>
                        <input type="hidden" id="input_end" name="end_time" required>
                        <input type="hidden" id="input_price" name="total_price" required>

                        <button type="submit" id="submitBtn" disabled class="w-full py-4 bg-playtomic-blue text-white font-black rounded-2xl transition-all shadow-lg shadow-playtomic-blue/20 hover:bg-blue-700 disabled:bg-gray-100 disabled:text-gray-400 disabled:shadow-none translate-y-0 active:translate-y-1">
                            Continue to Payment <i class="bi bi-arrow-right ml-2 font-black"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    const pricePerHour = <?php echo e($terrain->price_per_hour); ?>;
    
    function selectSlot(start, end, btn) {
        // Remove selection from all buttons
        document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
        
        // Add selection to clicked button
        btn.classList.add('selected');
        
        // Update hidden inputs
        document.getElementById('input_start').value = start;
        document.getElementById('input_end').value = end;
        
        // Calculate price based on duration (simple logic for now, assuming 1h slots if not specified)
        // In a real app we'd parse the timestamps
        const totalPrice = pricePerHour; 
        document.getElementById('input_price').value = totalPrice;
        
        // Update UI summary
        document.getElementById('selectionPreview').classList.remove('hidden');
        document.getElementById('timeText').innerText = `${start.substring(0, 5)} to ${end.substring(0, 5)}`;
        document.getElementById('totalPriceText').innerText = parseFloat(totalPrice).toFixed(2);
        
        // Enable button
        document.getElementById('submitBtn').disabled = false;
        
        // Smooth scroll to summary on mobile
        if (window.innerWidth < 768) {
            document.getElementById('selectionPreview').scrollIntoView({ behavior: 'smooth' });
        }
    }
</script>
<style>
    .animate-fadeInUp {
        animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/reservations/create.blade.php ENDPATH**/ ?>