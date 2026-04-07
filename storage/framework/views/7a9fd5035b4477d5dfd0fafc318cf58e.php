<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <div class="bg-white border border-gray-200 rounded-2xl p-6 flex flex-col shadow-sm">
        <div class="w-12 h-12 rounded-xl bg-playtomic-blue/10 text-playtomic-blue flex items-center justify-center text-xl mb-4">
            <i class="bi bi-building"></i>
        </div>
        <div class="text-[#0B1526] font-black text-3xl mb-1"><?php echo e(count($clubs)); ?></div>
        <div class="text-[14px] font-semibold text-gray-500 uppercase tracking-wide">Total Clubs</div>
    </div>
    
    
    <div class="bg-white border border-gray-200 rounded-2xl p-6 flex flex-col shadow-sm">
        <div class="w-12 h-12 rounded-xl bg-playtomic-blue/10 text-playtomic-blue flex items-center justify-center text-xl mb-4">
            <i class="bi bi-people-fill"></i>
        </div>
        <div class="text-[#0B1526] font-black text-3xl mb-1"><?php echo e(count($users)); ?></div>
        <div class="text-[14px] font-semibold text-gray-500 uppercase tracking-wide">Registered Users</div>
    </div>

    
    <div class="bg-white border border-gray-200 rounded-2xl p-6 flex flex-col shadow-sm">
        <div class="w-12 h-12 rounded-xl bg-playtomic-blue/10 text-playtomic-blue flex items-center justify-center text-xl mb-4">
            <i class="bi bi-calendar-check-fill"></i>
        </div>
        <div class="text-[#0B1526] font-black text-3xl mb-1"><?php echo e(count($reservations)); ?></div>
        <div class="text-[14px] font-semibold text-gray-500 uppercase tracking-wide">Total Matches</div>
    </div>
</div>


<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC]">
        <h3 class="text-[#0B1526] font-black text-xl flex items-center gap-2">
            <i class="bi bi-buildings text-playtomic-blue"></i> Club Directory
        </h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b border-gray-100">
                    <th class="py-4 px-6 text-[12px] font-bold text-gray-400 uppercase tracking-wider">ID</th>
                    <th class="py-4 px-6 text-[12px] font-bold text-gray-400 uppercase tracking-wider">Club Name</th>
                    <th class="py-4 px-6 text-[12px] font-bold text-gray-400 uppercase tracking-wider">City</th>
                    <th class="py-4 px-6 text-[12px] font-bold text-gray-400 uppercase tracking-wider">Owner</th>
                    <th class="py-4 px-6 text-[12px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $clubs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $club): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-4 px-6 text-[14px] font-bold text-[#0B1526]"><?php echo e($club->id); ?></td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-[#0B1526]"><?php echo e($club->name); ?></div>
                    </td>
                    <td class="py-4 px-6 text-[14px] font-semibold text-gray-500"><?php echo e($club->city); ?></td>
                    <td class="py-4 px-6">
                        <?php if($club->owner): ?>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-playtomic-blue/10 text-playtomic-blue flex items-center justify-center text-[10px] font-bold">
                                    <?php echo e(strtoupper(substr($club->owner->name, 0, 1))); ?>

                                </div>
                                <span class="text-[14px] font-semibold text-[#0B1526]"><?php echo e($club->owner->name); ?></span>
                            </div>
                        <?php else: ?>
                            <span class="text-[13px] font-semibold text-gray-400 italic">No Owner</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-4 px-6">
                        <?php if($club->is_active): ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wide bg-[#e6f4ea] text-[#137333]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#137333]"></span> Active
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wide bg-[#fce8e6] text-[#c5221f]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#c5221f]"></span> Inactive
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-3">
                            <i class="bi bi-buildings text-2xl text-gray-400"></i>
                        </div>
                        <h4 class="text-[#0B1526] font-bold text-lg">No clubs found</h4>
                        <p class="text-gray-500 text-sm mt-1">There are currently no clubs registered in the system.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>