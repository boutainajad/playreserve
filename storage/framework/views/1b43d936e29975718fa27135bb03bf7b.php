<?php $__env->startSection('title', 'My Matches History'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-10">
    <div class="bg-white border border-gray-200 rounded-[28px] p-8 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-[#0B1526] mb-1 tracking-tight">Booking History</h1>
            <p class="text-gray-500 font-medium text-[16px]">Track and manage your past and upcoming matches.</p>
        </div>
        <div class="w-14 h-14 rounded-full bg-playtomic-blue/10 flex items-center justify-center text-playtomic-blue text-2xl">
            <i class="bi bi-clock-history"></i>
        </div>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-[32px] overflow-hidden shadow-sm animate-fade-in-up">
    <?php if($reservations->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F9FAFC] border-b border-gray-100">
                        <th class="py-5 px-8 text-[11px] font-black text-gray-400 uppercase tracking-widest">Details</th>
                        <th class="py-5 px-8 text-[11px] font-black text-gray-400 uppercase tracking-widest">Date & Time</th>
                        <th class="py-5 px-8 text-[11px] font-black text-gray-400 uppercase tracking-widest">Price</th>
                        <th class="py-5 px-8 text-[11px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="py-5 px-8 text-[11px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-6 px-8">
                                <div class="font-bold text-[#0B1526] text-lg"><?php echo e($res->terrain->name); ?></div>
                                <div class="text-sm text-gray-400 font-medium flex items-center gap-1.5">
                                    <i class="bi bi-geo-alt-fill text-playtomic-lime"></i> <?php echo e($res->terrain->club->name); ?>

                                </div>
                            </td>
                            <td class="py-6 px-8">
                                <div class="font-black text-[#0B1526]"><?php echo e(\Carbon\Carbon::parse($res->reservation_date)->format('d M Y')); ?></div>
                                <div class="text-[12px] font-bold text-playtomic-blue mt-0.5 uppercase">
                                    <?php echo e(\Carbon\Carbon::parse($res->start_time)->format('H:i')); ?> – <?php echo e(\Carbon\Carbon::parse($res->end_time)->format('H:i')); ?>

                                </div>
                            </td>
                            <td class="py-6 px-8">
                                <span class="font-black text-[#0B1526] text-lg"><?php echo e(number_format($res->total_price, 0)); ?> <span class="text-xs">DH</span></span>
                            </td>
                            <td class="py-6 px-8">
                                <div class="flex">
                                    <?php if($res->status == 'confirmed'): ?>
                                        <span class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-[10px] font-black uppercase tracking-wider border border-green-100">CONFIRMED</span>
                                    <?php elseif($res->status == 'pending'): ?>
                                        <span class="px-3 py-1 bg-orange-50 text-orange-600 rounded-lg text-[10px] font-black uppercase tracking-wider border border-orange-100">PENDING</span>
                                    <?php elseif($res->status == 'cancelled'): ?>
                                        <span class="px-3 py-1 bg-red-50 text-red-600 rounded-lg text-[10px] font-black uppercase tracking-wider border border-red-100">CANCELLED</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-gray-50 text-gray-400 rounded-lg text-[10px] font-black uppercase tracking-wider border border-gray-100"><?php echo e($res->status); ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="py-6 px-8 text-right">
                                <?php if(in_array($res->status, ['confirmed', 'pending'])): ?>
                                    <?php
                                        $reservationDateTime = \Carbon\Carbon::parse($res->reservation_date)->setTimeFromTimeString($res->start_time);
                                        $isTooLate = now()->diffInHours($reservationDateTime, false) < 24;
                                    ?>

                                    <form action="<?php echo e(route('reservations.cancel', $res->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?')">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[12px] font-black transition-all
                                            <?php echo e($isTooLate ? 'bg-gray-100 text-gray-300 cursor-not-allowed' : 'bg-red-50 text-red-600 hover:bg-red-100'); ?>">
                                            <i class="bi <?php echo e($isTooLate ? 'bi-lock-fill' : 'bi-x-circle-fill'); ?>"></i> 
                                            CANCEL
                                        </button>
                                        <?php if($isTooLate): ?>
                                            <div class="text-[9px] text-gray-400 mt-1 font-bold uppercase tracking-tighter">Fixé (< 24h)</div>
                                        <?php endif; ?>
                                    </form>
                                <?php else: ?>
                                    <span class="text-gray-300 text-[13px] font-bold italic">No actions</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center justify-center py-24 text-center px-8">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <i class="bi bi-calendar-x text-4xl text-gray-200"></i>
            </div>
            <h4 class="text-2xl font-black text-[#0B1526] mb-2 tracking-tight">No match history found</h4>
            <p class="text-gray-500 font-medium max-w-sm mb-8">You haven't made any reservations yet. Start exploring clubs to book your first court!</p>
            <a href="<?php echo e(route('dashboard')); ?>" class="px-8 py-3.5 bg-playtomic-blue text-white font-black rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-playtomic-blue/30 text-[15px]">
                Explore Now
            </a>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/reservations/history.blade.php ENDPATH**/ ?>