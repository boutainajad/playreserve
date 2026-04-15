<?php $__env->startSection('title', 'Owner Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-8 relative rounded-[32px] overflow-hidden shadow-sm border border-gray-200">
    <div class="h-40 bg-gray-200 w-full relative">
        <?php if($club->cover_image): ?>
            <img src="<?php echo e(Storage::url($club->cover_image)); ?>" class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-r from-playtomic-blue/20 to-playtomic-lime/20"></div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-black/40"></div>
        <button onclick="openEditClubModal()" class="absolute top-4 right-4 px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl text-white font-bold text-sm flex items-center gap-2 transition-all shadow-sm">
            <i class="bi bi-pencil-square"></i> Edit Club Profile
        </button>
    </div>
    <div class="bg-white p-6 relative">
        <div class="flex items-center gap-6">
            <div class="w-24 h-24 bg-white rounded-2xl shadow-lg border-4 border-white -mt-16 relative flex-shrink-0 flex items-center justify-center overflow-hidden">
                <?php if($club->logo): ?>
                    <img src="<?php echo e(Storage::url($club->logo)); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <i class="bi bi-shop text-4xl text-gray-300"></i>
                <?php endif; ?>
            </div>
            <div class="mt-[-10px]">
                <h1 class="text-2xl font-black text-[#0B1526] mb-1"><?php echo e($club->name); ?></h1>
                <p class="text-[14px] font-medium text-gray-500 flex items-center gap-3">
                    <span><i class="bi bi-geo-alt-fill text-playtomic-blue mr-1"></i> <?php echo e($club->city); ?></span>
                    <span><i class="bi bi-telephone-fill text-playtomic-blue mr-1"></i> <?php echo e($club->phone); ?></span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in-up">
    <div class="bg-white border border-gray-100 p-6 rounded-3xl shadow-sm hover:shadow-md transition-shadow flex items-center gap-5 group">
        <div class="w-14 h-14 bg-blue-50 group-hover:bg-playtomic-blue group-hover:text-white rounded-2xl flex items-center justify-center text-playtomic-blue text-2xl transition-all duration-300">
            <i class="bi bi-wallet2"></i>
        </div>
        <div>
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Revenue</p>
            <h4 class="text-2xl font-black text-[#0B1526]"><?php echo e(number_format($totalRevenue, 0)); ?> <span class="text-sm">DH</span></h4>
        </div>
    </div>
    <div class="bg-white border border-gray-100 p-6 rounded-3xl shadow-sm hover:shadow-md transition-shadow flex items-center gap-5 group">
        <div class="w-14 h-14 bg-playtomic-lime/10 group-hover:bg-playtomic-lime group-hover:text-black rounded-2xl flex items-center justify-center text-playtomic-lime text-2xl transition-all duration-300">
            <i class="bi bi-calendar2-check"></i>
        </div>
        <div>
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Active Bookings</p>
            <h4 class="text-2xl font-black text-[#0B1526]"><?php echo e($activeBookings); ?></h4>
        </div>
    </div>
    <div class="bg-white border border-gray-100 p-6 rounded-3xl shadow-sm hover:shadow-md transition-shadow flex items-center gap-5 group">
        <div class="w-14 h-14 bg-orange-50 group-hover:bg-orange-500 group-hover:text-white rounded-2xl flex items-center justify-center text-orange-500 text-2xl transition-all duration-300">
            <i class="bi bi-grid-3x3-gap"></i>
        </div>
        <div>
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">My Courts</p>
            <h4 class="text-2xl font-black text-[#0B1526]"><?php echo e($terrains->count()); ?></h4>
        </div>
    </div>
    <div class="bg-white border border-gray-100 p-6 rounded-3xl shadow-sm hover:shadow-md transition-shadow flex items-center gap-5 group">
        <div class="w-14 h-14 bg-purple-50 group-hover:bg-purple-600 group-hover:text-white rounded-2xl flex items-center justify-center text-purple-600 text-2xl transition-all duration-300">
            <i class="bi bi-people"></i>
        </div>
        <div>
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Users</p>
            <h4 class="text-2xl font-black text-[#0B1526]"><?php echo e($reservations->pluck('user_id')->unique()->count()); ?></h4>
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $terrains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $terrain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white border border-gray-100 rounded-[32px] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative group shadow-sm overflow-hidden">
                        <?php if($terrain->image): ?>
                            <div class="h-36 w-full overflow-hidden shrink-0">
                                <img src="<?php echo e(Storage::url($terrain->image)); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        <?php else: ?>
                            <div class="h-4 w-full shrink-0"></div>
                        <?php endif; ?>
                        <div class="p-8 pt-4 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex-1 w-full relative group/btn">
                                <div class="flex justify-between items-start w-full gap-2">
                                    <h5 class="font-black text-[#0B1526] text-xl mb-1 truncate"><?php echo e($terrain->name); ?></h5>
                                    <button onclick='openEditTerrainModal(<?php echo e(json_encode(["id" => $terrain->id, "name" => $terrain->name, "sport_type" => $terrain->sport_type, "price_per_hour" => $terrain->price_per_hour, "description" => $terrain->description])); ?>)' class="w-8 h-8 flex-shrink-0 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:text-playtomic-blue hover:bg-blue-50 transition-colors border border-gray-100">
                                        <i class="bi bi-pencil-fill text-xs"></i>
                                    </button>
                                </div>
                                <div class="text-[11px] font-black text-playtomic-blue uppercase tracking-widest flex items-center gap-1.5">
                                    <?php if($terrain->sport_type == 'football'): ?> ⚽
                                    <?php elseif($terrain->sport_type == 'basketball'): ?> 🏀
                                    <?php elseif($terrain->sport_type == 'volleyball'): ?> 🏐
                                    <?php elseif($terrain->sport_type == 'tennis'): ?> 🎾
                                    <?php elseif($terrain->sport_type == 'padel'): ?> 🎯
                                    <?php else: ?> 🎯 <?php endif; ?>
                                    <?php echo e($terrain->sport_type); ?>

                                </div>
                            </div>
                            <?php if($terrain->is_available): ?>
                                <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wide border border-green-100">Active</span>
                            <?php else: ?>
                                <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wide border border-red-100">Inactive</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-8 p-5 bg-[#F9FAFC] rounded-24">
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-black text-[#0B1526]"><?php echo e(number_format($terrain->price_per_hour, 0)); ?></span>
                                <span class="text-sm font-bold text-gray-400">DH / HOUR</span>
                            </div>
                        </div>
                        
                        <div class="mt-auto space-y-4">
                            <div class="flex items-center justify-between text-sm font-medium text-gray-500 bg-gray-50/50 p-3 rounded-xl border border-gray-100">
                                <span class="flex items-center gap-2"><i class="bi bi-calendar3"></i> Slots</span>
                                <span class="font-black text-[#0B1526]"><?php echo e($terrain->creneaux->count()); ?></span>
                            </div>
                            
                            <button onclick="openSlotModal('<?php echo e($terrain->id); ?>', '<?php echo e($terrain->name); ?>')" class="w-full py-4 bg-white hover:bg-playtomic-blue hover:text-white border-2 border-gray-100 hover:border-playtomic-blue rounded-24 text-[14px] font-black text-[#0B1526] transition-all flex items-center justify-center gap-2 shadow-sm">
                                <i class="bi bi-gear-fill"></i> MANAGE SLOTS
                            </button>
                        </div>
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
            <div class="overflow-hidden bg-white">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[11px] uppercase font-black text-gray-400 tracking-widest">
                            <th class="px-8 py-5 bg-[#F9FAFC] border-b border-gray-100">Member</th>
                            <th class="px-8 py-5 bg-[#F9FAFC] border-b border-gray-100">Terrain</th>
                            <th class="px-8 py-5 bg-[#F9FAFC] border-b border-gray-100">Date & Time</th>
                            <th class="px-8 py-5 bg-[#F9FAFC] border-b border-gray-100 text-right">Amount</th>
                            <th class="px-8 py-5 bg-[#F9FAFC] border-b border-gray-100 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-playtomic-blue text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                            <?php echo e(strtoupper(substr($res->user->name, 0, 1))); ?>

                                        </div>
                                        <div class="font-bold text-[#0B1526] text-[15px]"><?php echo e($res->user->name); ?></div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 font-semibold text-gray-500 text-[14px]">
                                    <?php echo e($res->terrain->name); ?>

                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-black text-[#0B1526]"><?php echo e(\Carbon\Carbon::parse($res->reservation_date)->format('d M Y')); ?></div>
                                    <div class="text-[12px] font-bold text-playtomic-blue mt-0.5"><?php echo e(\Carbon\Carbon::parse($res->start_time)->format('H:i')); ?> – <?php echo e(\Carbon\Carbon::parse($res->end_time)->format('H:i')); ?></div>
                                </td>
                                <td class="px-8 py-6 text-right font-black text-[#0B1526] text-base">
                                    <?php echo e(number_format($res->total_price, 0)); ?> <span class="text-[11px] text-gray-400">DH</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-center">
                                        <?php if($res->status == 'confirmed'): ?>
                                            <span class="px-3 py-1.5 bg-green-50 text-green-600 rounded-xl text-[10px] font-black uppercase tracking-wider border border-green-100">CONFIRMED</span>
                                        <?php elseif($res->status == 'pending'): ?>
                                            <span class="px-3 py-1.5 bg-orange-50 text-orange-600 rounded-xl text-[10px] font-black uppercase tracking-wider border border-orange-100">PENDING</span>
                                        <?php else: ?>
                                            <span class="px-3 py-1.5 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase tracking-wider border border-red-100 uppercase"><?php echo e($res->status); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
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
                <h3 class="text-[#0B1526] font-black text-2xl mb-1">Manage Slots</h3>
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
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-3">Select Days</label>
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
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Opening Time</label>
                        <input type="time" name="start_time" value="08:00" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                    </div>
                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Closing Time</label>
                        <input type="time" name="end_time" value="22:00" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Slot Duration (Minutes)</label>
                    <select name="duration" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold appearance-none">
                        <option value="60">60 Minutes (1h)</option>
                        <option value="30">30 Minutes</option>
                        <option value="45">45 Minutes</option>
                        <option value="90">90 Minutes (1h30)</option>
                        <option value="120">120 Minutes (2h)</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-playtomic-blue text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30 text-[15px]">
                    Generate Weekly Slots
                </button>
            </form>
        </div>
    </div>
</div>

<div id="addTerrainModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-lg shadow-2xl overflow-hidden animate-fadeInUp max-h-[90vh] flex flex-col">
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC] shrink-0">
            <h3 class="text-[#0B1526] font-black text-2xl">Add Court</h3>
            <button onclick="document.getElementById('addTerrainModal').classList.add('hidden')" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
        <div class="p-8 overflow-y-auto">
            <form action="<?php echo e(route('owner.terrains.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Court Name</label>
                    <input type="text" name="name" required placeholder="e.g. Central Court" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                </div>
                
                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Sport Type</label>
                    <div class="relative">
                        <select name="sport_type" required class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold appearance-none cursor-pointer">
                            <option value="football">⚽ Football</option>
                            <option value="basketball">🏀 Basketball</option>
                            <option value="tennis">🎾 Tennis</option>
                            <option value="volleyball">🏐 Volleyball</option>
                            <option value="handball">🤾 Handball</option>
                            <option value="piscine">🏊 Swimming</option>
                            <option value="padel">🎯 Padel</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Price per Hour (DH)</label>
                    <input type="number" name="price_per_hour" step="0.01" min="0" required placeholder="0" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold text-xl">
                </div>

                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="LED lighting, synthetic grass..." class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium"></textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Court Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium text-sm">
                </div>

                <button type="submit" class="w-full bg-playtomic-blue text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30">
                    Add Court
                </button>
            </form>
        </div>
    </div>
</div>

<div id="editClubModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-2xl shadow-2xl overflow-hidden animate-fadeInUp max-h-[90vh] flex flex-col">
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC] shrink-0">
            <h3 class="text-[#0B1526] font-black text-2xl">Edit Club Profile</h3>
            <button onclick="document.getElementById('editClubModal').classList.add('hidden')" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
        <div class="p-8 overflow-y-auto">
            <form action="<?php echo e(route('owner.club.update', $club->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="grid grid-cols-2 gap-6 mb-5">
                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Club Name</label>
                        <input type="text" name="name" value="<?php echo e($club->name); ?>" required class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                    </div>
                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">City</label>
                        <input type="text" name="city" value="<?php echo e($club->city); ?>" required class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Address</label>
                    <input type="text" name="address" value="<?php echo e($club->address); ?>" required class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                </div>

                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Phone</label>
                    <input type="text" name="phone" value="<?php echo e($club->phone); ?>" required class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                </div>
                
                <div class="grid grid-cols-2 gap-6 mb-5">
                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Club Logo</label>
                        <input type="file" name="logo" accept="image/*" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium text-sm">
                    </div>
                    <div>
                        <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Cover Image</label>
                        <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium text-sm">
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Club Location on Map</label>
                    <div id="edit_club_map" class="w-full h-[250px] rounded-xl border-2 border-gray-100 z-10 block"></div>
                    <input type="hidden" name="latitude" id="edit_latitude" value="<?php echo e($club->latitude); ?>">
                    <input type="hidden" name="longitude" id="edit_longitude" value="<?php echo e($club->longitude); ?>">
                </div>

                <div class="mb-8">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">About the Club</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium"><?php echo e($club->description); ?></textarea>
                </div>

                <button type="submit" class="w-full bg-playtomic-blue text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
</div>

<div id="editTerrainModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-lg shadow-2xl overflow-hidden animate-fadeInUp max-h-[90vh] flex flex-col">
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-[#F9FAFC] shrink-0">
            <h3 class="text-[#0B1526] font-black text-2xl">Edit Court</h3>
            <button onclick="document.getElementById('editTerrainModal').classList.add('hidden')" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
        <div class="p-8 overflow-y-auto">
            <form id="editTerrainForm" action="" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Court Name</label>
                    <input type="text" name="name" id="edit_terrain_name" required class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold">
                </div>
                
                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Sport Type</label>
                    <div class="relative">
                        <select name="sport_type" id="edit_terrain_sport_type" required class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold appearance-none cursor-pointer">
                            <option value="football">⚽ Football</option>
                            <option value="basketball">🏀 Basketball</option>
                            <option value="tennis">🎾 Tennis</option>
                            <option value="volleyball">🏐 Volleyball</option>
                            <option value="handball">🤾 Handball</option>
                            <option value="piscine">🏊 Swimming</option>
                            <option value="padel">🎯 Padel</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Price per Hour (DH)</label>
                    <input type="number" name="price_per_hour" id="edit_terrain_price" step="0.01" min="0" required class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-bold text-xl">
                </div>

                <div class="mb-5">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Description</label>
                    <textarea name="description" id="edit_terrain_desc" rows="3" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium"></textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-[12px] uppercase tracking-wide font-black text-gray-400 mb-2">Update Image <span class="normal-case font-medium text-gray-400 ml-1">(Optional)</span></label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 bg-[#f4f5f7] border-transparent rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-playtomic-blue font-medium text-sm">
                </div>

                <button type="submit" class="w-full bg-playtomic-blue text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-playtomic-blue/30">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    let editMapInitialized = false;
    let editMap = null;
    let editMarker = null;

    function openEditClubModal() {
        document.getElementById('editClubModal').classList.remove('hidden');
        
        if (!editMapInitialized) {
            setTimeout(() => {
                const latInput = document.getElementById('edit_latitude').value;
                const lngInput = document.getElementById('edit_longitude').value;
                
                let lat = latInput ? parseFloat(latInput) : 31.7917;
                let lng = lngInput ? parseFloat(lngInput) : -7.0926;
                let zoom = latInput ? 15 : 5;

                editMap = L.map('edit_club_map').setView([lat, lng], zoom);
                
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 20
                }).addTo(editMap);

                if (latInput) {
                    editMarker = L.marker([lat, lng]).addTo(editMap);
                }

                editMap.on('click', function(e) {
                    if (editMarker) {
                        editMarker.setLatLng(e.latlng);
                    } else {
                        editMarker = L.marker(e.latlng).addTo(editMap);
                    }
                    document.getElementById('edit_latitude').value = e.latlng.lat;
                    document.getElementById('edit_longitude').value = e.latlng.lng;
                });
                
                editMapInitialized = true;
            }, 200);
        }
    }

    function openSlotModal(id, name) {
        const modal = document.getElementById('slotModal');
        const form = document.getElementById('bulkSlotForm');
        const nameDisplay = document.getElementById('modalTerrainName');
        
        nameDisplay.innerText = name;
        form.action = `/owner/terrains/${id}/creneaux`;
        modal.classList.remove('hidden');
    }

    function openEditTerrainModal(terrain) {
        document.getElementById('edit_terrain_name').value = terrain.name;
        document.getElementById('edit_terrain_sport_type').value = terrain.sport_type;
        document.getElementById('edit_terrain_price').value = terrain.price_per_hour;
        document.getElementById('edit_terrain_desc').value = terrain.description || '';
        document.getElementById('editTerrainForm').action = `/owner/terrains/${terrain.id}`;
        
        document.getElementById('editTerrainModal').classList.remove('hidden');
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Youcode\Desktop\playreserve\resources\views/dashboard/owner.blade.php ENDPATH**/ ?>