<?php $__env->startSection('title', 'Owner Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="mb-8">
    <div class="flex items-center justify-between bg-white border border-gray-200 p-6 rounded-2xl shadow-sm">
        <div>
            <h1 class="text-2xl font-black text-[#0B1526] mb-1 tracking-tight">Manage your club</h1>
            <p class="text-[15px] font-medium text-gray-500">You are currently managing <span class="font-bold text-playtomic-blue"><?php echo e($club->name); ?></span></p>
        </div>
        <div class="w-14 h-14 bg-playtomic-blue/10 rounded-full flex items-center justify-center">
            <i class="bi bi-shop text-3xl text-playtomic-blue"></i>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-playtomic-blue/10 rounded-xl flex items-center justify-center text-playtomic-blue text-xl">
            <i class="bi bi-currency-dollar"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Revenue</p>
            <h4 class="text-xl font-black text-[#0B1526]"><?php echo e(number_format($totalRevenue, 2)); ?> DH</h4>
        </div>
    </div>
    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-playtomic-lime/10 rounded-xl flex items-center justify-center text-playtomic-lime text-xl">
            <i class="bi bi-calendar-check-fill"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Active Bookings</p>
            <h4 class="text-xl font-black text-[#0B1526]"><?php echo e($activeBookings); ?></h4>
        </div>
    </div>
    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-500 text-xl">
            <i class="bi bi-grid-3x3-gap-fill"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Courts</p>
            <h4 class="text-xl font-black text-[#0B1526]"><?php echo e($terrains->count()); ?></h4>
        </div>
    </div>
    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 text-xl">
            <i class="bi bi-people-fill"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Users</p>
            <h4 class="text-xl font-black text-[#0B1526]"><?php echo e($reservations->pluck('user_id')->unique()->count()); ?></h4>
        </div>
    </div>
</div>


<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC]">
        <h3 class="text-[#0B1526] font-black text-xl flex items-center gap-2">
            <i class="bi bi-grid-3x3-gap-fill text-playtomic-blue"></i> My Courts
        </h3>
        <button onclick="document.getElementById('addTerrainModal').classList.remove('hidden')" class="px-5 py-2.5 bg-playtomic-blue hover:bg-blue-700 text-white font-bold rounded-full text-[13px] transition-colors shadow-md shadow-playtomic-blue/20 flex items-center gap-2 cursor-pointer">
            <i class="bi bi-plus-lg"></i> Add Court
        </button>
    </div>
    
    <div class="p-6">
        <?php if($terrains->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $terrains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $terrain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-2xl p-6 hover:shadow-md transition-shadow bg-white flex flex-col h-full relative group">
                        <div class="flex justify-between items-start mb-4">
                            <h5 class="font-black text-[#0B1526] text-lg"><?php echo e($terrain->name); ?></h5>
                            <span class="bg-[#f0f4ff] text-playtomic-blue px-2.5 py-1 rounded-md text-[11px] font-black uppercase tracking-wide border border-blue-100 flex items-center gap-1.5">
                                <?php if($terrain->sport_type == 'football'): ?> <i class="bi bi-dribbble"></i>
                                <?php elseif($terrain->sport_type == 'basketball'): ?> <i class="bi bi-basket"></i>
                                <?php elseif($terrain->sport_type == 'volleyball'): ?> <i class="bi bi-circle"></i>
                                <?php elseif($terrain->sport_type == 'handball'): ?> <i class="bi bi-hand-thumbs-up"></i>
                                <?php elseif($terrain->sport_type == 'piscine'): ?> <i class="bi bi-water"></i>
                                <?php endif; ?>
                                <?php echo e(ucfirst($terrain->sport_type)); ?>

                            </span>
                        </div>
                        
                        <div class="mb-5">
                            <span class="text-3xl font-black text-[#0B1526]"><?php echo e(number_format($terrain->price_per_hour, 0)); ?></span>
                            <span class="text-sm font-semibold text-gray-500">DH / hour</span>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="text-[13px] font-semibold text-gray-500 flex items-center gap-2">
                                <i class="bi bi-calendar text-playtomic-blue"></i> 
                                <span class="text-[#0B1526] font-bold"><?php echo e($terrain->creneaux->count()); ?></span> standard timeslots
                            </div>
                            
                            <button onclick="openSlotModal('<?php echo e($terrain->id); ?>', '<?php echo e($terrain->name); ?>')" class="w-full py-3 bg-gray-50 hover:bg-playtomic-blue hover:text-white border border-dashed border-gray-300 hover:border-playtomic-blue rounded-xl text-[13px] font-bold text-gray-600 transition-all flex items-center justify-center gap-2">
                                <i class="bi bi-gear-fill"></i> Manage Slots
                            </button>
                        </div>
                        
                        <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <?php if($terrain->is_available): ?>
                                <span class="flex items-center gap-1.5 text-[12px] font-bold text-[#137333]">
                                    <span class="w-2 h-2 rounded-full bg-[#137333]"></span> Active
                                </span>
                            <?php else: ?>
                                <span class="flex items-center gap-1.5 text-[12px] font-bold text-[#c5221f]">
                                    <span class="w-2 h-2 rounded-full bg-[#c5221f]"></span> Maintenance
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-grid-3x3-gap-fill text-3xl text-gray-300"></i>
                </div>
                <h4 class="text-[#0B1526] font-bold text-lg mb-2">No courts configured</h4>
                <p class="text-gray-500 text-sm mb-6">You haven't added any courts to your club yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-12">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC]">
        <h3 class="text-[#0B1526] font-black text-xl flex items-center gap-2">
            <i class="bi bi-journal-check text-playtomic-blue"></i> Recent Bookings
        </h3>
    </div>
    <div class="p-0 overflow-x-auto">
        <?php if($reservations->count() > 0): ?>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[12px] uppercase font-black text-gray-400 tracking-wider">
                        <th class="px-6 py-4 border-b border-gray-100">Member</th>
                        <th class="px-6 py-4 border-b border-gray-100">Terrain</th>
                        <th class="px-6 py-4 border-b border-gray-100">Date & Time</th>
                        <th class="px-6 py-4 border-b border-gray-100">Amount</th>
                        <th class="px-6 py-4 border-b border-gray-100">Status</th>
                    </tr>
                </thead>
                <tbody class="text-[14px]">
                    <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 border-b border-gray-50">
                                <span class="font-bold text-[#0B1526]"><?php echo e($res->user->name); ?></span>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-50 font-medium text-gray-600">
                                <?php echo e($res->terrain->name); ?>

                            </td>
                            <td class="px-6 py-4 border-b border-gray-50">
                                <div class="font-bold text-[#0B1526]"><?php echo e(\Carbon\Carbon::parse($res->reservation_date)->format('d M')); ?></div>
                                <div class="text-[12px] text-gray-400"><?php echo e(\Carbon\Carbon::parse($res->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($res->end_time)->format('H:i')); ?></div>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-50 font-black text-playtomic-blue">
                                <?php echo e(number_format($res->total_price, 0)); ?> DH
                            </td>
                            <td class="px-6 py-4 border-b border-gray-50">
                                <?php if($res->status == 'confirmed'): ?>
                                    <span class="px-2.5 py-1 bg-[#e6f4ea] text-[#137333] rounded-lg text-[10px] font-black uppercase tracking-wide">Confirmed</span>
                                <?php elseif($res->status == 'pending'): ?>
                                    <span class="px-2.5 py-1 bg-[#fef7e0] text-[#b06000] rounded-lg text-[10px] font-black uppercase tracking-wide">Pending</span>
                                <?php else: ?>
                                    <span class="px-2.5 py-1 bg-[#fce8e6] text-[#c5221f] rounded-lg text-[10px] font-black uppercase tracking-wide"><?php echo e($res->status); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="p-12 text-center text-gray-400 font-medium italic">
                No recent bookings to display.
            </div>
        <?php endif; ?>
    </div>
</div>




<div id="slotModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-xl shadow-2xl overflow-hidden animate-fadeInUp">
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC]">
            <div>
                <h3 class="text-[#0B1526] font-black text-2xl mb-1">Gérer les créneaux</h3>
                <p id="modalTerrainName" class="text-sm font-bold text-playtomic-blue uppercase tracking-wider"></p>
            </div>
            <button onclick="document.getElementById('slotModal').classList.add('hidden')" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
        <div class="p-8">
            <form id="bulkSlotForm" action="" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-6">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-3">Sélectionner les jours</label>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="cursor-pointer group">
                                <input type="checkbox" name="days[]" value="<?php echo e($day); ?>" checked class="peer hidden">
                                <div class="px-4 py-2 bg-gray-100 peer-checked:bg-playtomic-blue peer-checked:text-white rounded-full text-[13px] font-bold transition-all group-hover:scale-105 active:scale-95">
                                    <?php echo e(substr($day, 0, 3)); ?>

                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Heure d'ouverture</label>
                        <input type="time" name="start_time" value="08:00" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                    </div>
                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Heure de fermeture</label>
                        <input type="time" name="end_time" value="22:00" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Durée d'un krino (Minutes)</label>
                    <select name="duration" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold appearance-none">
                        <option value="60">60 Minutes (1h)</option>
                        <option value="30">30 Minutes</option>
                        <option value="45">45 Minutes</option>
                        <option value="90">90 Minutes (1h30)</option>
                        <option value="120">120 Minutes (2h)</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-playtomic-blue text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30 text-[15px]">
                    Générer les créneaux par défaut de la semaine
                </button>
            </form>
        </div>
    </div>
</div>


<div id="addTerrainModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-lg shadow-2xl overflow-hidden animate-fadeInUp">
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC]">
            <h3 class="text-[#0B1526] font-black text-2xl">Ajouter un terrain</h3>
            <button onclick="document.getElementById('addTerrainModal').classList.add('hidden')" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
        <div class="p-8">
            <form action="<?php echo e(route('owner.terrains.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Nom du terrain</label>
                    <input type="text" name="name" required placeholder="ex: Terrain Central" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                </div>
                
                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Type de sport</label>
                    <div class="relative">
                        <select name="sport_type" required class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold appearance-none cursor-pointer">
                            <option value="football">⚽ Football</option>
                            <option value="basketball">🏀 Basketball</option>
                            <option value="tennis">🎾 Tennis</option>
                            <option value="volleyball">🏐 Volleyball</option>
                            <option value="handball">🤾 Handball</option>
                            <option value="piscine">🏊 Piscine</option>
                            <option value="padel">🎯 Padel</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Prix par heure (DH)</label>
                    <input type="number" name="price_per_hour" step="0.01" min="0" required placeholder="0" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold text-xl">
                </div>

                <div class="mb-8">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="Éclairage LED, Gazon synthétique..." class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium"></textarea>
                </div>

                <button type="submit" class="w-full bg-playtomic-blue text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30">
                    Ajouter le terrain
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function openSlotModal(id, name) {
        const modal = document.getElementById('slotModal');
        const form = document.getElementById('bulkSlotForm');
        const nameDisplay = document.getElementById('modalTerrainName');
        
        nameDisplay.innerText = name;
        form.action = `/owner/terrains/${id}/creneaux`;
        modal.classList.remove('hidden');
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/dashboard/owner.blade.php ENDPATH**/ ?>