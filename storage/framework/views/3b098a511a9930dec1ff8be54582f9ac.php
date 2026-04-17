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
                           onclick="this.showPicker()"
                           class="w-full px-6 py-4 bg-[#f4f5f7] border-transparent rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-black text-lg transition-all cursor-pointer">
                    <i class="bi bi-calendar-event absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-playtomic-blue transition-colors pointer-events-none"></i>
                </form>
            </div>

            <div class="bg-white border border-gray-200 rounded-[32px] p-8 shadow-sm min-h-[400px]">
                <h3 class="text-[#0B1526] font-black text-xl mb-6">2. Select a timeslot</h3>
                
                <?php if($creneaux->count() > 0): ?>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <?php $__currentLoopData = $creneaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($slot->is_reserved): ?>
                                <div class="relative flex flex-col items-center justify-center py-4 px-2 border-2 border-gray-100 bg-gray-50/30 rounded-2xl transition-all overflow-hidden">
                                    <span class="text-[13px] font-black text-gray-300 mb-2">
                                        <?php echo e(\Carbon\Carbon::parse($slot->start_time)->format('H:i')); ?>

                                    </span>
                                    <form action="<?php echo e(route('reservations.joinWaitlist')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="terrain_id" value="<?php echo e($terrain->id); ?>">
                                        <input type="hidden" name="reservation_date" value="<?php echo e($date); ?>">
                                        <input type="hidden" name="start_time" value="<?php echo e($slot->start_time); ?>">
                                        <input type="hidden" name="end_time" value="<?php echo e($slot->end_time); ?>">
                                        <button type="submit" class="text-[9px] font-black text-white bg-playtomic-blue px-3 py-1 rounded-full shadow-sm uppercase tracking-tighter hover:bg-blue-600 transition-colors">
                                            Waitlist
                                        </button>
                                    </form>
                                </div>
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

                    <div id="selectionPreview" class="hidden animate-fadeInUp">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-playtomic-bg flex items-center justify-center text-lg">
                                    <i class="bi bi-clock-fill text-playtomic-blue"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="text-[11px] uppercase font-black text-gray-400 tracking-wider">Start Time</div>
                                    <div id="timeText" class="font-bold text-[#0B1526]">--:--</div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-2xl">
                                <label class="block text-[11px] uppercase font-black text-playtomic-blue tracking-wider mb-2">Duration</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button" onclick="updateDuration(60)" class="dur-btn py-2 text-xs font-black rounded-xl border-2 border-transparent bg-white shadow-sm hover:border-playtomic-blue transition-all" id="dur-60">1h</button>
                                    <button type="button" onclick="updateDuration(90)" class="dur-btn py-2 text-xs font-black rounded-xl border-2 border-transparent bg-white shadow-sm hover:border-playtomic-blue transition-all" id="dur-90">1h30</button>
                                    <button type="button" onclick="updateDuration(120)" class="dur-btn py-2 text-xs font-black rounded-xl border-2 border-transparent bg-white shadow-sm hover:border-playtomic-blue transition-all" id="dur-120">2h</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-6">

                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <div class="text-gray-500 font-bold">Total price</div>
                            <div class="text-[10px] text-playtomic-lime font-black uppercase tracking-widest" id="durationStatus">Selected: 60 min</div>
                        </div>
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
    let selectedStart = null;
    let selectedDuration = 60;
    
    function selectSlot(start, end, btn) {
        document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        
        selectedStart = start;
        updateCalculation();
        
        document.getElementById('selectionPreview').classList.remove('hidden');
        document.getElementById('timeText').innerText = start.substring(0, 5);
        document.getElementById('submitBtn').disabled = false;
        
        if (window.innerWidth < 768) {
            document.getElementById('selectionPreview').scrollIntoView({ behavior: 'smooth' });
        }
    }

    function updateDuration(mins) {
        selectedDuration = mins;
        document.querySelectorAll('.dur-btn').forEach(b => b.classList.remove('border-playtomic-blue', 'text-playtomic-blue'));
        document.getElementById('dur-' + mins).classList.add('border-playtomic-blue', 'text-playtomic-blue');
        
        updateCalculation();
    }

    function updateCalculation() {
        if (!selectedStart) return;

        const [hours, minutes] = selectedStart.split(':').map(Number);
        const startDate = new Date();
        startDate.setHours(hours, minutes, 0);
        
        const endDate = new Date(startDate.getTime() + selectedDuration * 60000);
        const endStr = endDate.getHours().toString().padStart(2, '0') + ':' + endDate.getMinutes().toString().padStart(2, '0');

        const totalPrice = (pricePerHour / 60) * selectedDuration;
        
        document.getElementById('input_start').value = selectedStart;
        document.getElementById('input_end').value = endStr;
        document.getElementById('input_price').value = totalPrice;
        
        document.getElementById('totalPriceText').innerText = parseFloat(totalPrice).toFixed(2);
        document.getElementById('durationStatus').innerText = `Selected: ${selectedDuration} min`;
    }


    updateDuration(60);
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